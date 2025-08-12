<?php

namespace App\Exports;

use App\Models\Department;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DepartmentExport implements FromCollection, WithHeadings, WithStyles
{
    /**
     * Fetch departments data
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Department::all(['name', 'description']);
    }

    /**
     * Define the headings for the Excel sheet
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'Name',
            'Description',
        ];
    }

    /**
     * Apply styles to the Excel sheet
     *
     * @param Worksheet $sheet
     * @return void
     */
    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
