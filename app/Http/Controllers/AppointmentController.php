<?php

namespace App\Http\Controllers;

use App\Contracts\Services\AppointmentServiceInterface;
use App\Contracts\Services\DepartmentServiceInterface;
use App\Http\Requests\AppointmentRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AppointmentController extends Controller
{
    protected DepartmentServiceInterface $departmentService;
    protected AppointmentServiceInterface $appointmentService;

    /**
     * @param DepartmentServiceInterface $departmentService
     * @param AppointmentServiceInterface $appointmentService
     */
    public function __construct(
        DepartmentServiceInterface $departmentService,
        AppointmentServiceInterface $appointmentService
    ) {
        $this->appointmentService = $appointmentService;
        $this->departmentService = $departmentService;
    }

    /**
     * View appointment's detail page
     * @param $id
     * @return View
     */
    public function detail($id): View
    {
        $appointment = $this->appointmentService->getById($id);
        return view('patient.appointment.detail', ["appointment" => $appointment]);
    }

    /**
     * create appointment view
     * @return View
     */
    public function create(): View
    {
        return view('patient.appointment.create', ['departments' => $this->departmentService->getAllDepartment()]);
    }

    /**
     * create a new appointment
     * @param AppointmentRequest $request
     * @return RedirectResponse
     */
    public function store(AppointmentRequest $request): RedirectResponse
    {
        $validatedData = $request->only(['patientId', 'date', 'room', 'doctor']);
        try {
            $this->appointmentService->createAppointment($validatedData);
        } catch (\Exception $e) {
            return back()->with('createError', $e->getMessage());
        }
        return redirect(route(
            'patient.get-all-appointment',
            ['patientId' => $validatedData['patientId']]
        ))->with('success', 'New appointment has been made.');
    }
}
