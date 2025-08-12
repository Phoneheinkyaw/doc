<?php

namespace App\Imports;

use App\Models\Department;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DepartmentsImport implements ToCollection, WithHeadingRow
{
    protected $errors = [];
    protected $acceptedFields = ['name', 'description'];
    protected $importedCount = 0;

    /**
     * collection function
     *
     * @param Collection $rows
     * @return void
     */
    public function collection(Collection $rows)
    {
        Log::info('Starting department import process', ['row_count' => $rows->count()]);
        $hasErrors = false;

        if ($rows->isEmpty()) {
            $this->errors[] = 'Input file is empty.';
            Log::warning('Input file is empty.');

            return;
        }

        DB::beginTransaction();
        try {
            foreach ($rows as $index => $row) {
                $rowIndex = $index + 1;
                Log::info("Processing row {$rowIndex}", $row->toArray());

                $normalizedRow = collect($row)->map(function ($value) {

                    return trim(strval($value));
                });

                if ($this->isRowEmpty($normalizedRow)) {
                    Log::info("Row {$rowIndex} is empty, skipping.");
                    $this->errors[] = "Row {$rowIndex}: All fields are blank";
                    $hasErrors = true;
                    continue;
                }

                $nonEmptyValues = $normalizedRow->filter()->count();

                if ($nonEmptyValues !== 2) {
                    Log::warning("Row {$rowIndex}: Exactly 2 columns required (name and description)");
                    $this->errors[] = "Row {$rowIndex}: Exactly 2 columns (name and description) are required per row";
                    $hasErrors = true;
                    continue;
                }

                if (!isset($normalizedRow['name']) || !isset($normalizedRow['description'])) {
                    Log::warning("Row {$rowIndex}: Missing required columns");
                    $this->errors[] = "Row {$rowIndex}: Both name and description columns are required";
                    $hasErrors = true;
                    continue;
                }

                $filteredRow = $normalizedRow->only($this->acceptedFields);

                $this->validateRow($filteredRow, $rowIndex);

                if (!empty($this->errors)) {
                    $hasErrors = true;
                    continue;
                }
            }

            if (!$hasErrors) {
                foreach ($rows as $index => $row) {
                    $rowIndex = $index + 1;
                    $normalizedRow = collect($row)->map(function ($value) {

                        return trim(strval($value));
                    });
                    $filteredRow = $normalizedRow->only($this->acceptedFields);

                    try {
                        $department = Department::create([
                            'name' => $filteredRow['name'],
                            'description' => $filteredRow['description'],
                            'status' => 1,
                        ]);
                        Log::info("Created department", $department->toArray());
                        $this->importedCount++;
                    } catch (\Exception $e) {
                        Log::error("Failed to create department: " . $e->getMessage(), $filteredRow->toArray());
                        $this->errors[] = "Row {$rowIndex}: Failed to create department - " . $e->getMessage();
                        throw $e;
                    }
                }
                DB::commit();
            } else {
                DB::rollBack();
                Log::error('Import failed due to validation errors');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Department import failed: ' . $e->getMessage());
            $this->errors[] = 'An error occurred during import: ' . $e->getMessage();
        }

        if (!empty($this->errors)) {
            Log::error('Import completed with errors', ['errors' => $this->errors]);
        }

        Log::info("Department import completed. {$this->importedCount} departments imported.");
    }

    /**
     * Check if a row is empty
     *
     * @param Collection $row
     * @return bool
     */
    private function isRowEmpty(Collection $row): bool
    {
        return $row->filter()->isEmpty();
    }

    /**
     * Validate a row of data
     *
     * @param Collection $row
     * @param int $rowIndex
     * @return void
     */
    private function validateRow(Collection $row, int $rowIndex): void
    {
        if (!$row->has('name') || empty($row['name'])) {
            $this->errors[] = "Row {$rowIndex}: Name is required";
        }

        if (!$row->has('description') || empty($row['description'])) {
            $this->errors[] = "Row {$rowIndex}: Description is required";
        }

        if ($row->has('name') && !empty($row['name'])) {
            $existingDepartment = Department::where('name', $row['name'])->first();
            if ($existingDepartment) {
                $this->errors[] = "Row {$rowIndex}: Department name '{$row['name']}' already exists";
            }
        }
    }

    /**
     * Get all errors that occurred during import
     *
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}
