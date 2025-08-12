<?php

namespace App\Exports;

use App\Models\Appointment;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;

class AppointmentsExport implements FromQuery, WithHeadings, WithMapping, WithEvents
{
    protected $doctorId;

    public function __construct($doctorId)
    {
        $this->doctorId = $doctorId;
    }

    public function query()
    {
        return Appointment::with('patient', 'room')
            ->where('doctor_id', $this->doctorId)
            ->where('status', '!=', config('constants.statuses.canceled'))
            ->orderBy('created_at', 'desc');
    }

    public function headings(): array
    {
        return [
            'Patient Name',
            'Room',
            'Appointment Date',
            'Status',
        ];
    }

    public function map($appointment): array
    {
        return [
            $appointment->patient->name ?? 'N/A',
            $appointment->room->name ?? 'N/A',
            $appointment->appointment_date,
            array_search($appointment->status, config('constants.statuses')),
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // Bold the header row (1)
                $event->sheet->getStyle('A1:E1')->getFont()->setBold(true);

                // Set column widths
                $event->sheet->getColumnDimension('A')->setWidth(10);
                $event->sheet->getColumnDimension('B')->setWidth(25);
                $event->sheet->getColumnDimension('C')->setWidth(20);
                $event->sheet->getColumnDimension('D')->setWidth(15);

                // Set row height for the header
                $event->sheet->getRowDimension(1)->setRowHeight(20);

                // Handle empty data case
                if ($this->query()->count() === 0) {
                    $event->sheet->setCellValue('A2', 'No Data');
                    $event->sheet->getStyle('A2')->getFont()->setBold(true);
                    $event->sheet->getRowDimension(2)->setRowHeight(20);
                    $event->sheet->getColumnDimension('A')->setWidth(25);
                }
            },
        ];
    }
}
