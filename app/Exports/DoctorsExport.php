<?php

namespace App\Exports;

use App\Models\Doctor;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DoctorsExport implements FromCollection, WithHeadings, WithStyles
{
    /**
     * Fetch doctors data with department names, excluding id and password
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Doctor::with('department')->get()->map(function ($doctor) {
            return [
                'id' => $doctor->id,
                'name' => $doctor->name,
                'email' => $doctor->email,
                'phone' => $doctor->phone,
                'department' => $doctor->department ? $doctor->department->name : 'N/A',
                'licence_number' => $doctor->licence_number,
            ];
        });
    }

    /**
     * Define the headings for the Excel sheet
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'Id', 'Name', 'Email', 'Phone', 'Department', 'Licence Number',
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
        $sheet->getStyle('A1:F1')->getFont()->setBold(true);
    }
}
