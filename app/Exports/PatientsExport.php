<?php

namespace App\Exports;

use App\Models\Patient;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PatientsExport implements FromCollection, WithHeadings, WithStyles, WithMapping
{
    public function collection()
    {
        return Patient::select('name', 'email', 'address', 'phone', 'gender')->get();
    }

    public function headings(): array
    {
        return ['Name', 'Email', 'Address', 'Phone', 'Gender'];
    }
    public function map($patient): array
    {
        return [
            'name' => $patient->name,
            'email' => $patient->email,
            'address' => $patient->address,
            'phone' => $patient->phone,
            'gender' => $this->mapGender($patient->gender),
        ];
    }
    private function mapGender(int $gender): string
    {
        return match ($gender) {
            1 => 'Male',
            2 => 'Female',
            3 => 'Other',
        };
    }
    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
