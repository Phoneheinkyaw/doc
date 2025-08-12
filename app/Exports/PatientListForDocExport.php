<?php

namespace App\Exports;

use App\Models\Appointment;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class PatientListForDocExport implements FromView, WithEvents
{
    protected $doctorId;

    public function __construct(int $doctorId)
    {
        $this->doctorId = $doctorId;
    }

    public function view(): View
    {
        $patients = Appointment::join('patients', 'appointments.patient_id', '=', 'patients.id')
            ->select('patients.id as patient_id', 'patients.name', DB::raw('count(*) as total_appointments'))
            ->where('appointments.doctor_id', $this->doctorId)
            ->groupBy('patients.id', 'patients.name')
            ->get();

        return view('doctor.patient.export', [
            'patients' => $patients,
        ]);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // Bold the header row (1)
                $event->sheet->getStyle('A1:C1')->getFont()->setBold(true);

                // Set column widths
                $event->sheet->getColumnDimension('A')->setWidth(10); // Patient ID
                $event->sheet->getColumnDimension('B')->setWidth(25); // Patient Name
                $event->sheet->getColumnDimension('C')->setWidth(20); // Total Appointments

                // Set row height for the header
                $event->sheet->getRowDimension(1)->setRowHeight(20);

                // Handle empty data case
                if ($event->sheet->getHighestRow() == 1) { // Check if there's only the header
                    $event->sheet->setCellValue('A2', 'No Data');
                    $event->sheet->getStyle('A2')->getFont()->setBold(true);
                    $event->sheet->getRowDimension(2)->setRowHeight(20);
                    $event->sheet->getColumnDimension('A')->setWidth(25);
                }
            },
        ];
    }
}
