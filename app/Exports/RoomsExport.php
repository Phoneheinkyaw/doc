<?php

namespace App\Exports;

use App\Models\Room;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class RoomsExport implements FromCollection, WithHeadings, WithStyles
{
    /**
     * Fetch rooms data
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Room::all()->map(function ($room) {
            return [
                'name' => $room->name,
                'status' => $room->status == 0 ? 'Occupied' : 'Free',
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
            'Name',
            'Status',
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
