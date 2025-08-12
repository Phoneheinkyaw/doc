<?php

namespace App\Imports;

use App\Models\Room;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class RoomsImport implements ToCollection, WithHeadingRow
{
    protected $errors = [];

    protected $acceptedFields = ['name'];
    protected $importedCount = 0;

    /**
     * Processes the imported rows, validates them, and saves valid rows to the database.
     *
     * @param Collection $rows The collection of rows imported from the file.
     * @return void
     */
    public function collection(Collection $rows)
    {
        Log::info('Starting room import process', ['row_count' => $rows->count()]);
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

                if ($nonEmptyValues !== 1) {
                    Log::warning("Row {$rowIndex}: Exactly 1 column required (name)");
                    $this->errors[] = "Row {$rowIndex}: Exactly 1 column (name) is required per row";
                    $hasErrors = true;
                    continue;
                }

                if (!isset($normalizedRow['name'])) {
                    Log::warning("Row {$rowIndex}: Missing required column");
                    $this->errors[] = "Row {$rowIndex}: Name column is required";
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
                        $room = Room::create([
                            'name' => $filteredRow['name'],

                        ]);
                        Log::info("Created room", $room->toArray());
                        $this->importedCount++;
                    } catch (\Exception $e) {
                        Log::error("Failed to create room: " . $e->getMessage(), $filteredRow->toArray());
                        $this->errors[] = "Row {$rowIndex}: Failed to create room - " . $e->getMessage();
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
            Log::error('Room import failed: ' . $e->getMessage());
            $this->errors[] = 'An error occurred during import: ' . $e->getMessage();
        }

        if (!empty($this->errors)) {
            Log::error('Import completed with errors', ['errors' => $this->errors]);
        }
        Log::info("Room import completed. {$this->importedCount} rooms imported.");
    }

    /**
     * Checks if a row is completely empty.
     * @param Collection $row The row to check.
     * @return bool True if the row is empty, otherwise false.
     */
    private function isRowEmpty(Collection $row): bool
    {
        return $row->filter()->isEmpty();
    }

    /**
     * Validates a single row of data.
     * @param Collection $row The row to validate.
     * @param int $rowIndex The index of the row in the imported file.
     * @return void
     */
    private function validateRow(Collection $row, int $rowIndex): void
    {
        if (!$row->has('name') || empty($row['name'])) {
            $this->errors[] = "Row {$rowIndex}: Name is required";
        }

        if ($row->has('name') && !empty($row['name'])) {
            $existingRoom = Room::where('name', $row['name'])->first();
            if ($existingRoom) {
                $this->errors[] = "Row {$rowIndex}: Room name '{$row['name']}' already exists";
            }
        }
    }

    /**
     * Retrieves all errors encountered during the import process.
     * @return array An array of error messages.
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}
