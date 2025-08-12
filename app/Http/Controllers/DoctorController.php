<?php

namespace App\Http\Controllers;

use App\Contracts\Services\AppointmentServiceInterface;
use App\Contracts\Services\DepartmentServiceInterface;
use App\Contracts\Services\DoctorServiceInterface;
use App\Contracts\Services\PatientServiceInterface;
use App\Contracts\Services\RoomServiceInterface;
use App\Exports\AppointmentsExport;
use App\Exports\PatientListForDocExport;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\DoctorProfileRequest;
use App\Http\Requests\DoctorRequest;
use App\Http\Requests\DoctorResetPasswordRequest;
use App\Http\Requests\ResetEmailRequest;
use App\Mail\AppointmentApproved;
use App\Mail\AppointmentRejected;
use App\Mail\DoctrPasswordResetMail;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;

class DoctorController extends Controller
{
    protected $doctorService;
    protected $departmentService;
    protected $appointmentService;
    protected $roomService;
    protected $patientService;

    /**
     * @param DepartmentServiceInterface $departmentService
     * @param DoctorServiceInterface $doctorService
     * @param AppointmentServiceInterface $appointmentService
     * @param RommServiceInterface $roomService
     * @param PatientServiceInterface $appointmentService
     */

    public function __construct(
        DoctorServiceInterface $doctorService,
        DepartmentServiceInterface $departmentService,
        AppointmentServiceInterface $appointmentService,
        PatientServiceInterface $patientService,
        RoomServiceInterface $roomService
    ) {
        $this->doctorService = $doctorService;
        $this->departmentService = $departmentService;
        $this->appointmentService = $appointmentService;
        $this->patientService = $patientService;
        $this->roomService = $roomService;
    }

    /**
     * Display a listing of the resource
     * @return view
     */
    public function index(): View
    {
        return view('Doctor.dashboard');
    }

    /**
     * Display the login form for doctors.
     * @return View
     */
    public function login(): View
    {
        return view('Doctor.login');
    }

    /**
     * Authenticate the doctor's login credentials.
     * @param DoctorRequest $request
     * @returnRedirectResponse
     */
    public function authenticate(DoctorRequest $request): RedirectResponse
    {
        $credentials = $request->only('email', 'password');
        if (Auth::guard('doctors')->attempt($credentials)) {
            return redirect()->intended(route('doctor.dashboard'));
        }
        return back()->withErrors([
            'email' => 'Invalid email or password. Please try again.',
        ])->onlyInput('email');
    }

    /**
     * Display the doctor's dashboard.
     * @return View
     */
    public function dashboard(): View
    {
        $doctorId = Auth::guard('doctors')->user()->id;
        $todayAppointment = $this->appointmentService->todayAppointments($doctorId);
        $confirmedAppointment = $this->appointmentService->confirmedAppointments($doctorId);
        $rejectedAppointment = $this->appointmentService->rejectedAppointments($doctorId);
        $pendingAppointment = $this->appointmentService->pendingAppointments($doctorId);
        $finishedAppointment = $this->appointmentService->finishedAppointments($doctorId);
        $missedAppointment = $this->appointmentService->missedAppointments($doctorId);
        return view('doctor.dashboard', compact(
            'todayAppointment',
            'confirmedAppointment',
            'rejectedAppointment',
            'pendingAppointment',
            'finishedAppointment',
            'missedAppointment'
        ));
    }

    /**
     * todayAppointments function
     * @return View
     */
    public function todayAppointments(): View
    {
        $doctorId = Auth::guard('doctors')->user()->id;
        $appointments = $this->appointmentService->todayAppointments($doctorId);
        $pageTitle = "Today Confirmed Appointments";
        return view('doctor.appointment.type', compact('appointments', 'pageTitle'));
    }

    /**
     * confirmedAppointments function
     * @return View
     */
    public function confirmedAppointments(): View
    {
        $doctorId = Auth::guard('doctors')->user()->id;
        $appointments = $this->appointmentService->confirmedAppointments($doctorId);
        $pageTitle = "Confirmed Appointments";
        return view('doctor.appointment.type', compact('appointments', 'pageTitle'));
    }

    /**
     * rejectedAppointments function
     * @return view
     */
    public function rejectedAppointments(): View
    {
        $doctorId = Auth::guard('doctors')->user()->id;
        $appointments = $this->appointmentService->rejectedAppointments($doctorId);
        $pageTitle = "Rejected Appointments";
        return view('doctor.appointment.type', compact('appointments', 'pageTitle'));
    }

    /**
     * pendingAppointments function
     * @return view
     */
    public function pendingAppointments(): view
    {
        $doctorId = Auth::guard('doctors')->user()->id;
        $appointments = $this->appointmentService->pendingAppointments($doctorId);
        return view('doctor.appointment.pending', compact('appointments'));
    }

    /**
     * Undocumented function
     * @return View
     */
    public function finishedAppointments(): view
    {
        $doctorId = Auth::guard('doctors')->user()->id;
        $appointments = $this->appointmentService->finishedAppointments($doctorId);
        $pageTitle = "Finished Appointments";
        return view('doctor.appointment.type', compact('appointments', 'pageTitle'));
    }

    /**
     * missedAppointments function
     * @return view
     */
    public function missedAppointments(): View
    {
        $doctorId = Auth::guard('doctors')->user()->id;
        $appointments = $this->appointmentService->missedAppointments($doctorId);
        $pageTitle = "Missed Appointments";
        return view('doctor.appointment.type', compact('appointments', 'pageTitle'));
    }

    /**
     * Display the doctor's profile.
     * @return View
     */
    public function profile(): View
    {
        return view('Doctor.Profile.view');
    }

    /**
     * Upload the doctor's profile image.
     * @param DoctorProfileRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadProfile(DoctorProfileRequest $request): JsonResponse
    {
        return $this->doctorService->uploadProfileImage($request->validated());
    }

    /**
     * appointmentList function.
     * @return View
     */
    public function appointmentList(Request $request): View
    {
        $doctorId = Auth::guard('doctors')->user()->id;
        $search = $request->input('search');
        $appointments = $this->appointmentService->getAllAppointment($search, $doctorId);
        return view('doctor.appointment.list', [
            'appointments' => $appointments,
            'error' => $appointments->isEmpty() ? 'No appointments found' : null,
        ]);
    }

    /**
     * Confirm the specified appointment and send a notification to the patient.
     * @param int $id
     * @return RedirectResponse
     */
    public function appointmentConfirm($appointmentId, Request $request): RedirectResponse
    {
        $appointment = $this->appointmentService->getById($appointmentId);
        $status = $request->input('status');
        $data = $this->appointmentService->updateIfPending($appointmentId, $status);
        $mail = $this->appointmentService->getMailByAppointment($appointmentId);
        if ($data === null) {
            Mail::to($mail)->send(new AppointmentApproved($appointment));
            return back()->with('success', 'Appointment confirmed successfully.');
        } else {
            return back()->with('error', 'Appointment can only be confirmed if it is pending.');
        }
    }

    /**
     * Reject the specified appointment and send a notification to the patient.
     * @param int $appointmentId
     * @param Request $request
     * @return Redirect response
     */
    public function appointmentReject($appointmentId, Request $request): RedirectResponse
    {
        $appointment = $this->appointmentService->getById($appointmentId);
        $roomId = $appointment->room_id;
        $status = $request->input('status');
        $data = $this->appointmentService->updateIfPending($appointmentId, $status);
        $mail = $this->appointmentService->getMailByAppointment($appointmentId);
        if ($data === null) {
            if ($roomId) {
                $this->roomService->changeRoomStatus($roomId);
            }
            Mail::to($mail)->send(new AppointmentRejected($appointment));
            return back()->with('success', 'Appointment reject successfully.');
        } else {
            return back()->with('error', 'Appointment can only be reject if it is pending.');
        }
        return back();
    }

    /**
     * completeAppointment function
     * @param int $appointmentId
     * @param Request $request
     * @return Redirect response
     */
    public function completeAppointment($appointmentId, Request $request): RedirectResponse
    {
        $appointment = $this->appointmentService->getById($appointmentId);
        $roomId = $appointment->room_id;
        $status = $request->input('status');
        $appointmentDate = \Carbon\Carbon::parse($appointment->appointment_date);
        if ($appointment->status !== config('constants.statuses.confirmed')) {
            return back()->with('error', 'Appointment can only be completed once it is confirmed.');
        }
        if (!$appointmentDate->isToday()) {
            return back()->with('error', 'Error completing an appointment before its due date.');
        }
        $result = $this->appointmentService->updateIfConfirmed($appointmentId, $status);
        if ($result === null) {
            if ($roomId) {
                $this->roomService->changeRoomStatus($roomId);
            }
            return back()->with('success', 'Appointment finished successfully.');
        } else {
            return back()->with('error', 'Appointment can only be completed once it is confirmed.');
        }
    }

    /**
     * Retrieve doctors
     * @param int $departmentId
     */
    public function getDocFromDepartmentId($departmentId)
    {
        try {
            $doctors = $this->doctorService->getDocFromDepartmentId((int)$departmentId);
            return response()->json([
                'status' => 200,
                'doctors' => $doctors,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 404,
                'errors' => $e,
                'doctors' => [],
            ]);
        }
    }

    /**
     * Update the authenticated doctor's password.
     * @param ChangePasswordRequest
     * @return RedirectResponse
     */
    public function updatePassword(ChangePasswordRequest $request): RedirectResponse
    {
        $doctor = Auth::guard('doctors')->user();
        if (!$doctor) {
            return redirect()->back()->withErrors(['error' => 'Doctor not authenticated.']);
        }
        if (!Hash::check($request->current_password, $doctor->password)) {
            return redirect()->back()->withErrors(['current_password' => 'The current password is incorrect.']);
        }
        if (Hash::check($request->new_password, $doctor->password)) {
            return redirect()->back()
                ->withErrors(['new_password' => 'The new password cannot be the same as the current password.']);
        }
        $result = $this->doctorService->changePassword(
            $doctor,
            $request->new_password
        );
        if ($result) {
            return redirect()->route('doctor.profile')->with('success', 'Your password changed successfully');
        } else {
            return redirect()->back()->with('error', 'Failed to update the password. Please try again later');
        }
    }

    /**
     * Display the form for changing the doctor's password.
     * @return View
     */
    public function changePassword(): View
    {
        return view('doctor.profile.password_change');
    }

    /**
     * Display the form for the doctor to reset their password.
     * @return View
     */
    public function forgotPassword(): View
    {
        return view('doctor.profile.forgot_password');
    }

    /**
     * Send a password reset link to the specified doctor's email.
     * @param ResetEmailRequest $request
     * @return RedirectResponse
     */
    public function restlink(ResetEmailRequest $request): RedirectResponse
    {
        $email = $request->input('email');
        $doctor = $this->doctorService->getDoctorByEmail($email);
        if ($doctor) {
            $url = url('doctor/reset/password?name=' . urlencode($email));
            Mail::to($email)->send(new DoctrPasswordResetMail($email, $url));
            return back()->with('success', 'We sent a reset password link to your account.');
        } else {
            return back()->with('error', 'Your account was not found.');
        }
    }

    /**
     * Display the form for resetting the doctor's password.
     * @return View
     */
    public function resetForm(): View
    {
        return view('doctor.profile.reset_password');
    }

    /**
     * Reset the password for the specified doctor.
     * @param DoctorResetPasswordRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */

    public function resetPassword(DoctorResetPasswordRequest $request): RedirectResponse
    {
        $doctor = $this->doctorService->getDoctorByEmail($request->input('email'));
        if ($doctor) {
            $this->doctorService->resetDoctorPassword($doctor, $request->input('newPassword'));
            return redirect()->route('doctor.login')->with('success', 'Your password has been reset successfully.');
        } else {
            return back()->with('error', 'Your Email Not Found');
        }
    }

    /**
     * patientListByDoctorId function
     * @param Request $request
     * @return View|Redirect Resonse
     */
    public function patientListByDoctorId(Request $request): View|RedirectResponse
    {
        $docorId = Auth::guard('doctors')->user()->id;
        $search = $request->input('search', '');
        $patients = $this->patientService->patientListByDoctorId($docorId, $search);
        if ($patients) {
            return view('doctor.patient.list', compact('patients'));
        } else {
            return back()->with('error', 'You can not rech this page');
        }
    }

    /**
     * Download a list of patients for the authenticated doctor
     * @return  An Excel file response for downloading
     */
    public function downloadPatientList()
    {
        $doctorId = Auth::guard('doctors')->user()->id;
        return Excel::download(new PatientListForDocExport($doctorId), 'patient_list.xlsx');
    }

    /**
     * appointmentRecordByPatientId function
     * @param int $patientId
     * @return view|redirect
     */
    public function appointmentRecordByPatientId($patientId): View
    {
        $doctorId = Auth::guard('doctors')->user()->id;
        $patient = $this->patientService->getPatientById($patientId);
        if (!$patient) {
            abort(404, 'Patient not found.');
        }
        $appointments = $this->patientService->appointmentRecordByPatientId($doctorId, $patientId);
        if ($appointments) {
            return view('doctor.patient.record', compact('appointments', 'patient'));
        } else {
            return back()->with('error', 'You can not rech this page');
        }
    }

    /**
     * downloadAppoinrmentLi function
     * @return \Illuminate\Http\Response
     */
    public function downloadAppoinrmentList()
    {
        $doctorId = Auth::guard('doctors')->user()->id;
        return Excel::download(new AppointmentsExport($doctorId), 'appointments.xlsx');
    }

    /**
     * AppointmentView function
     * @param int $appointmentId
     * @return view
     */
    public function appointmentView($appointmentId)
    {
        $appointment = $this->appointmentService->getById($appointmentId);
        return view('doctor.appointment.view', compact('appointment'));
    }

    /**
     * Log out the authenticated doctor.
     * @return RedirectResponse
     */
    protected function logout(): RedirectResponse
    {
        Auth::guard('doctors')->logout();
        return redirect(route('welcome'));
    }
}
