<?php

namespace App\Http\Controllers;

use App\Contracts\Services\AppointmentServiceInterface;
use App\Contracts\Services\PatientServiceInterface;
use App\Contracts\Services\RoomServiceInterface;
use App\Http\Requests\PatientRequest;
use App\Mail\WelcomeEmail;
use App\Models\Patient;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;

class PatientController extends Controller
{
    protected PatientServiceInterface $patientService;
    protected AppointmentServiceInterface $appointmentService;
    protected RoomServiceInterface $roomService;

    /**
     * @param PatientServiceInterface $patientService
     * @param AppointmentServiceInterface $appointmentService
     * @param RoomServiceInterface $roomService
     */
    public function __construct(
        PatientServiceInterface $patientService,
        AppointmentServiceInterface $appointmentService,
        RoomServiceInterface $roomService
    ) {
        $this->patientService = $patientService;
        $this->appointmentService = $appointmentService;
        $this->roomService = $roomService;
    }

    /**
     * Patient dashboard or home page
     * @return View
     */
    public function index(): View
    {
        $patientId = Auth::guard('patients')->user()->id;
        $completedAppointments = $this->appointmentService->getPreviousCompletedAppointments($patientId);
        $count = $this->appointmentService->getAllAppointmentCount($patientId);
        $nextAppointment = $this->appointmentService->getNextAppointment($patientId);
        return view('patient.index', [
            'count' => $count,
            'nextAppointment' => $nextAppointment,
            'completedAppointments' => $completedAppointments
        ]);
    }

    /**
     * Create patient form view
     * @return View
     */
    public function create(): View
    {
        return view('patient.register');
    }

    /**
     * create new patient
     * @param PatientRequest $request
     * @return RedirectResponse
     */
    public function store(PatientRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();
        $this->patientService->createPatient($validatedData);

        $name = $validatedData['name'];
        $url = 'http://localhost:8000/patient/login';
        try {
            Mail::to($validatedData['email'])->send(new WelcomeEmail($name, $url));
        } catch (\Exception $e) {
        }
        return redirect(route('patient.login'));
    }

    /**
     * update patient
     * @param PatientRequest $request
     * @return RedirectResponse
     */
    public function update(PatientRequest $request): RedirectResponse
    {
        try {
            $validatedData = $request->validated();
            $this->patientService->updatePatient($validatedData);
            return redirect()->route('patient.profile')->with('success', 'Profile updated successfully.');
        } catch (\Exception $e) {
            return back()->with('editError', 'Error updating profile.');
        }
    }

    /**
     * Delete patient
     * @param Request $request
     * @return RedirectResponse
     */
    public function destroy(Request $request): RedirectResponse
    {
        try {
            $patientId = $request->id;
            $this->patientService->deletePatient($patientId);
            return redirect()->route('patient.create');
        } catch (\Exception $e) {
            return back()->with('deleteError', $e->getMessage());
        }
    }

    /**
     * send reset token link
     * @param Request $request
     * @return RedirectResponse
     */
    public function passwordEmail(Request $request): RedirectResponse
    {

        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }

    /**
     * input email page view
     * @param string $token
     * @param Request $request
     * @return View
     */
    public function passwordReset(string $token, Request $request): View
    {
        $email = $request->query('email');
        return view('patient.reset_password', ['token' => $token, 'email' => $email]);
    }

    /**
     * update password
     * @param Request $request
     * @return RedirectResponse
     */
    public function passwordUpdate(Request $request): RedirectResponse
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (Patient $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ]);

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('patient.login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }

    /**
     * Login Form Page View
     * @return View
     */
    protected function login(): View
    {
        return view('patient.login');
    }

    /**
     * log in the user
     * @param PatientRequest $request
     * @return RedirectResponse
     */
    protected function authenticate(PatientRequest $request): RedirectResponse
    {
        $credentials = $request->only('email', 'password');
        if (Auth::guard('patients')->attempt($credentials)) {
            return redirect()->intended(route('patient.index'));
        }
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
            'password' => 'The provided credentials do not match our records.'
        ]);
    }

    /**
     * Log out the user
     * @return RedirectResponse
     */
    protected function logout(): RedirectResponse
    {
        Auth::guard('patients')->logout();
        return redirect(route('welcome'));
    }

    /**
     * appointments table view for patient
     * @param $patientId
     * @return View
     */
    protected function getAllAppointment($patientId, Request $request): View
    {
        $search = $request->query('search') ?? null;
        $appointments = $this->appointmentService->getAppointmentsByPatientId($patientId, $search);
        return view('patient.appointment', ['appointments' => $appointments]);
    }

    /**
     * cancel appointment and free up room
     * @param Request $request
     * @return RedirectResponse
     */
    protected function cancelAppointment(Request $request): RedirectResponse
    {
        try {
            $this->appointmentService->changeAppointmentStatus($request->appointmentId, $request->status);
            $this->roomService->changeRoomStatus($request->roomId);
            return back();
        } catch (\Exception $e) {
            return back()->with("updateStatusError", $e->getMessage());
        }
    }

    /**
     * View profile page
     * @return View
     */
    protected function profile(): View
    {
        return view('patient.profile');
    }

    /**
     * View update page
     * @return View
     */
    protected function edit(): View
    {
        return view('patient.edit');
    }

    /**
     * View edit password page
     * @return View
     */
    protected function editPassword(): View
    {
        return view('patient.password_change');
    }

    /**
     * Update password
     * @param PatientRequest $request
     * @return RedirectResponse
     */
    protected function updatePassword(PatientRequest $request): RedirectResponse
    {
        $patient = Auth::guard('patients')->user();

        if (!$patient) {
            return redirect()->back()->withErrors(['error' => 'Patient not authenticated.']);
        }
        if (!Hash::check($request->current_password, $patient->password)) {
            return redirect()->back()->withErrors(['current_password' => 'The current password is incorrect.']);
        }
        try {
            $this->patientService->updatePassword($patient, $request->new_password);
            return redirect()->route('patient.profile')->with('success', 'Your password changed successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update the password. Please try again later');
        }
    }
    /**
     * View patient's detail page
     * @param $id
     * @return View
     */
    public function detail($id): View
    {
        $patient = $this->patientService->getById($id);
        return view('patient.detail', ["patient" => $patient]);
    }
}
