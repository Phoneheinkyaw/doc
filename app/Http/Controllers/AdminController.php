<?php

namespace App\Http\Controllers;

use App\Contracts\Services\AppointmentServiceInterface;
use App\Contracts\Services\DepartmentServiceInterface;
use App\Contracts\Services\DoctorServiceInterface;
use App\Contracts\Services\PatientServiceInterface;
use App\Contracts\Services\RoomServiceInterface;
use App\Exports\DepartmentExport;
use App\Exports\DoctorsExport;
use App\Exports\PatientsExport;
use App\Exports\RoomsExport;
use App\Http\Requests\AdminRequest;
use App\Http\Requests\DoctorCreateRequest;
use App\Http\Requests\DoctorUpdateRequest;
use App\Http\Requests\ImportDepartmentRequest;
use App\Http\Requests\ImportRoomRequest;
use App\Http\Requests\RoomRequest;
use App\Http\Requests\StoreDepartmentRequest;
use App\Http\Requests\UpdateDepartmentRequest;
use App\Imports\DepartmentsImport;
use App\Imports\RoomsImport;
use App\Mail\DoctorWelcomeMail;
use App\Models\Department;
use App\Models\Room;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

/**
 *
 */
class AdminController extends Controller
{
    protected $patientService;
    protected $doctorService;
    protected $roomService;
    protected $departmentService;
    protected $appointmentService;

    /**
     * __construct function
     *
     * @param PatientServiceInterface $patientService
     * @param DoctorServiceInterface $doctorService
     * @param RoomServiceInterface $roomService
     * @param DepartmentServiceInterface $departmentService
     * @param AppointmentServiceInterface $appointmentService
     */
    public function __construct(
        PatientServiceInterface $patientService,
        DoctorServiceInterface $doctorService,
        RoomServiceInterface $roomService,
        DepartmentServiceInterface $departmentService,
        AppointmentServiceInterface $appointmentService,
    ) {
        $this->patientService = $patientService;
        $this->doctorService = $doctorService;
        $this->roomService = $roomService;
        $this->departmentService = $departmentService;
        $this->appointmentService = $appointmentService;
    }

    /**
     * admin login function
     *
     *
     * @return View
     */

    public function login(): View
    {
        return view('admin.login');
    }

    /**
     * Authenticate admin login credentials function
     *
     * @param AdminRequest $request
     *
     * @return RedirectResponse
     */

    public function authenticate(AdminRequest $request): RedirectResponse
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('admins')->attempt($credentials)) {
            return redirect()->intended(route('list.patient'));
        }

        return back()->withErrors([
            'email' => 'Invalid email or password. Please try again.',
        ])->onlyInput('email');
    }

    /**
     * Display patient dashboard function
     *
     * @return View
     */

    public function patientList(Request $request): View
    {
        $search = $request->input('search') ?? '';
        $patients = $this->patientService->searchPatients($search);

        return view('admin.patient.list', compact('patients'));
    }

    /**
     * Delete doctor function
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function patientDestroy($id): RedirectResponse
    {
        try {
            $this->patientService->destroy($id);
            return redirect()->back()->with('success', 'Patient deleted successfully.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Error: Paitent has ongoing appointment history!');
        }
    }

    /**
     * Exports the list of patients to an Excel file.
     *
     * This method initiates a download of an Excel file containing patient data,
     * using the PatientsExport class to format the data.
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse The downloadable Excel file response.
     */
    public function patientExport()
    {
        return Excel::download(new PatientsExport(), 'patients.xlsx');
    }

    /**
     * Display list of doctors function
     *
     * @return view
     */
    public function doctorList(Request $request): View
    {
        $search = $request->input('search') ?? '';
        $doctors = $this->doctorService->searchDoctors($search);

        return view('Admin.doctor.list', compact('doctors'));
    }

    /**
     * Store new doctor function
     *
     * @param DoctorCreateRequest $request
     * @return RedirectResponse
     */
    public function doctorStore(DoctorCreateRequest $request): RedirectResponse
    {
        $doctor = $this->doctorService->create($request->validated());
        $url = url('doctor/');
        Mail::to($doctor->email)->send(new DoctorWelcomeMail($doctor, $url));

        return redirect()->route('list.doctor')->with('success', 'Doctor created successfully.');
    }

    /**
     * Display doctor create function
     *
     * @return view
     */
    public function doctorCreate(): View
    {
        $departments = $this->departmentService->getAll();

        return view('Admin.doctor.create', compact('departments'));
    }

    /**
     * Display doctor edit function
     *
     * @param int $id
     * @return view
     */
    public function doctorEdit($id): View
    {
        $doctor = $this->doctorService->getDoctorById($id);
        $departments = $this->departmentService->getAll();

        return view('Admin.doctor.edit', compact('doctor', 'departments'));
    }

    /**
     * Update doctor function
     *
     * @param DoctorUpdateRequest $request
     * @param int $id
     * @return RedirectResponse
     */
    public function doctorUpdate(DoctorUpdateRequest $request, $id): RedirectResponse
    {
        $data = $request->validated();
        $updatedDoctor = $this->doctorService->updateDoctor($id, $data);

        return redirect()->route('list.doctor', $updatedDoctor->id)
            ->with('success', 'Doctor updated successfully.');
    }

    /**
     * Delete doctor function
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function doctorDestroy($id): RedirectResponse
    {
        $hasAppointments = $this->doctorService->hasAppointments($id);
        if ($hasAppointments) {
            return redirect()->route('list.doctor')
                ->with('error', 'Doctor has active appointments and cannot be deleted.');
        }
        $this->doctorService->destroy($id);
        return redirect()->route('list.doctor')->with('success', 'Doctor deleted successfully.');
    }

    /**
     * Export student data to an Excel file.
     *
     * @return BinaryFileResponse
     */
    public function doctorExport(): BinaryFileResponse
    {
        return Excel::download(new DoctorsExport(), 'doctors.xlsx');
    }

    /**
     * Display room dashboard function
     *
     * @return View
     */

    public function roomList(Request $request): View
    {
        $search = $request->input('search') ?? '';
        $rooms = $this->roomService->searchRooms($search);

        return view('Admin.room.list', compact('rooms'));
    }

    /**
     * Display department dashboard function
     *
     * @return View
     */

    public function departmentList(): View
    {
        $departments = $this->departmentService->getAll();

        return view('Admin.department.list', compact('departments'));
    }

    /**
     * Display room create function
     *
     * @return View
     */

    public function roomCreate(): View
    {
        return view('Admin.room.create');
    }

    /**
     * Export room data to an Excel file.
     *
     * @return BinaryFileResponse
     */
    public function roomExport(): BinaryFileResponse
    {
        return Excel::download(new RoomsExport(), 'rooms.xlsx');
    }

    /**
     * Import rooms from an uploaded Excel file.
     *
     * @param ImportRoomRequest $request
     * @return RedirectResponse
     */
    public function roomImport(ImportRoomRequest $request): RedirectResponse
    {
        $file = $request->file('file');
        $import = new RoomsImport();
        Excel::import($import, $file);
        if (!empty($import->getErrors())) {
            return redirect()->route('list.room')->withErrors($import->getErrors());
        }
        return redirect()->route('list.room')->with('success', 'Rooms imported successfully.');
    }

    /**
     * Store new room function
     *
     * @param RoomRequest $request
     * @return RedirectResponse
     */

    public function roomStore(RoomRequest $request): RedirectResponse
    {
        $this->roomService->store($request);

        return redirect()->route('list.room')->with('success', 'Room created successfully.');
    }

    /**
     * Display room edit function
     *
     * @param int $id
     * @return View
     */

    public function roomEdit($id): View
    {
        $room = Room::find($id);

        return view('Admin.room.edit', compact('room'));
    }

    /**
     * Update room function
     *
     * @param RoomRequest $request
     * @param int $id
     * @return RedirectResponse
     */

    public function roomUpdate(RoomRequest $request, $id): RedirectResponse
    {
        $this->roomService->updateRooms($request, $id);

        return redirect()->route('list.room')->with('success', 'Room updated successfully.');
    }

    /**
     * Delete room function
     *
     * @param int $id
     * @return RedirectResponse
     */

    public function roomDestroy($id): RedirectResponse
    {
        try {
            $this->roomService->destory($id);
            return redirect()->back()->with('success', 'Room deleted successfully!');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Error: Room is currently occupied!');
        }
    }

    /**
     * Display department create function
     *
     * @return View
     */

    public function departmentCreate(): View
    {
        return view('Admin.department.create');
    }

    /**
     * Store new department function
     *
     * @param StoreDepartmentRequest $request
     * @return RedirectResponse
     */

    public function departmentStore(StoreDepartmentRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $this->departmentService->storeDepartment($data);

        return redirect()->route('list.department')->with('success', 'Department created successfully!');
    }

    /**
     * Display department edit function
     *
     * @param int $id
     * @return View
     */

    public function departmentEdit($id): View
    {
        $department = $this->departmentService->getDepartmentById($id);

        return view('Admin.department.edit', compact('department'));
    }

    /**
     * Update department function
     *
     * @param UpdateDepartmentRequest $request
     * @param int $id
     * @return RedirectResponse
     */

    public function departmentUpdate(UpdateDepartmentRequest $request, $id): RedirectResponse
    {
        $updated = $this->departmentService->updateDepartment($id, $request->validated());

        if ($updated) {
            return redirect()->route('list.department')->with('success', 'Department updated successfully');
        }

        return redirect()->back()->with('error', 'Failed to update department');
    }

    /**
     * Search department function
     *
     * @param Request $request
     * @return View
     */
    public function departmentSearch(Request $request): View
    {
        $searchTerm = $request->input('search');
        $departments = $this->departmentService->search($searchTerm);

        return view('admin.department.list', compact('departments'));
    }

    /**
     * Delete department function
     *
     * @param int $id
     * @return RedirectResponse
     */

    public function departmentDestroy($id): RedirectResponse
    {
        try {
            $this->departmentService->destroy($id);
            return redirect()->route('list.department')->with('success', 'Department deleted successfully.');
        } catch (Exception $e) {
            return redirect()->route('list.department')->with('error', 'Cannot delete department with active doctors');
        }
    }

    /**
     * Export all departments to an Excel file.
     *
     * This function retrieves all department records from the database
     * and exports them into an Excel file named "departments.xlsx".
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse The Excel file download response.
     */

    public function departmentExport(): BinaryFileResponse
    {
        $departments = Department::all();

        return Excel::download(new DepartmentExport(), 'departments.xlsx');
    }

    /**
     * Import departments from an uploaded file.
     *
     * @param ImportDepartmentRequest $request The validated request containing the file.
     * @return RedirectResponse  Redirects to the department list route with success or error messages.
     */
    public function departmentImport(ImportDepartmentRequest $request): RedirectResponse
    {

        $file = $request->file('file');
        $import = new DepartmentsImport();
        Excel::import($import, $file);
        if (!empty($import->getErrors())) {
            return redirect()->route('list.department')->withErrors($import->getErrors());
        }

        return redirect()->route('list.department')->with('success', 'Departments imported successfully.');
    }

    /**
     * Display room dashboard function
     *
     * @return View
     */

    public function appointmentList(Request $request): View
    {
        $search = $request->input('search') ?? '';
        $appointments = $this->appointmentService->searchAppointment($search);

        return view('admin.appointment.list', compact('appointments'));
    }

    /**
     * Display admin profile function
     *
     * @return View
     */

    public function profile(): View
    {
        return view('Admin.profile');
    }

    /**
     * logout function
     *
     * @return RedirectResponse
     */

    public function logout(): RedirectResponse
    {
        Auth::guard('admins')->logout();

        return redirect(route('welcome'));
    }

    /**
     * Patient View function
     *
     * @param int $patientId
     * @return view
     */
    public function patientView($patientId): View
    {
        $patient = $this->patientService->getPatientById($patientId);
        if ($patient) {
            return view('admin.patient.view', compact('patient'));
        } else {
            abort('404');
        }
    }

    /**
     * doctorView function
     * @param int $doctorId
     * @return View
     */
    public function doctorView($doctorId): View
    {
        $doctor = $this->doctorService->getDoctorById($doctorId);
        if ($doctor) {
            return view('admin.doctor.view', compact('doctor'));
        }
        abort('404');
    }

    /**
     * departmentView function
     * @param int $departmentId
     * @return view
     */
    public function departmentView($departmentId): View
    {
        $department = $this->departmentService->getDepartmentById($departmentId);
        if ($department) {
            return view('admin.department.view', compact('department'));
        }
        abort('404');
    }

    /**
     * appointmentView function
     * @param int $appointmentId
     * @return view
     */
    public function appointmentView($appointmentId): View
    {
        $appointment = $this->appointmentService->getById($appointmentId);
        if ($appointment) {
            return view('admin.appointment.view', compact('appointment'));
        }
        abort('404');
    }
}
