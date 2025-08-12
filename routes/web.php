<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [WelcomeController::class, 'getLatestDoctor'])->name('welcome');
// Admin Routes
Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminController::class, 'login'])->name('admin.login');
    Route::post('/login', [AdminController::class, 'authenticate'])->name('admin.authenticate');
});

Route::middleware(['admin'])->prefix('admin')->group(function () {
    Route::get('/patient/list', [AdminController::class, 'patientList'])->name('list.patient');
    Route::delete('/patient/destroy/{id}', [AdminController::class, 'patientDestroy'])->name('destroy.patient');
    Route::get('/patient/export', [AdminController::class, 'patientExport'])->name('export.patient');
    Route::get('/patient/view/{id}', [AdminController::class, 'patientView'])->name('admin.patient.view');

    Route::get('/appointment/list', [AdminController::class, 'appointmentList'])->name('list.appointment');
    Route::get('/appointment/view/{id}', [AdminController::class, 'appointmentView'])->name('admin.appointment.view');

    Route::get('/department/list', [AdminController::class, 'departmentList'])->name('list.department');
    Route::post('/department/store', [AdminController::class, 'departmentStore'])->name('store.department');
    Route::get('/department/create', [AdminController::class, 'departmentCreate'])->name('create.department');
    Route::get('/department/edit/{id}', [AdminController::class, 'departmentEdit'])->name('edit.department');
    Route::put('/department/update/{id}', [AdminController::class, 'departmentUpdate'])->name('update.department');
    Route::delete('/department/destroy/{id}', [AdminController::class, 'departmentDestroy'])
        ->name('destroy.department');
    Route::get('/department/search', [AdminController::class, 'departmentSearch'])->name('search.department');
    Route::get('/department/export', [AdminController::class, 'departmentExport'])->name('export.department');
    Route::post('/department/import', [AdminController::class, 'departmentImport'])->name('import.department');
    Route::get('/department/view/{id}', [AdminController::class, 'departmentView'])->name('admin.department.view');

    Route::get('/doctor/list', [AdminController::class, 'doctorList'])->name('list.doctor');
    Route::get('/doctor/create', [AdminController::class, 'doctorCreate'])->name('create.doctor');
    Route::post('/doctor/store', [AdminController::class, 'doctorStore'])->name('store.doctor');
    Route::get('/doctor/edit/{id}', [AdminController::class, 'doctorEdit'])->name('edit.doctor');
    Route::put('/doctor/update/{id}', [AdminController::class, 'doctorUpdate'])->name('update.doctor');
    Route::delete('/doctor/destroy/{id}', [AdminController::class, 'doctorDestroy'])->name('destroy.doctor');
    Route::get('/doctor/export', [AdminController::class, 'doctorExport'])->name('export.doctor');
    Route::get('/doctor/view/{id}', [AdminController::class, 'doctorView'])->name('admin.doctor.view');

    Route::get('/room/list', [AdminController::class, 'roomList'])->name('list.room');
    Route::get('/room/create', [AdminController::class, 'roomCreate'])->name('create.room');
    Route::post('/room/store', [AdminController::class, 'roomStore'])->name('store.room');
    Route::get('/room/edit/{id}', [AdminController::class, 'roomEdit'])->name('edit.room');
    Route::put('/room/update/{id}', [AdminController::class, 'roomUpdate'])->name('update.room');
    Route::delete('/room/delete/{id}', [AdminController::class, 'roomDestroy'])->name('destroy.room');
    Route::get('/room/export', [AdminController::class, 'roomExport'])->name('export.room');
    Route::post('/room/import', [AdminController::class, 'roomImport'])->name('import.room');

    Route::post('/logout', [AdminController::class, 'logout'])->name('admin.logout');
    Route::get('/profile', [AdminController::class, 'profile'])->name('admin.profile');
});

// Appointment Routes
Route::middleware(['patient'])->prefix('appointment')->group(function () {
    Route::get('/create', [AppointmentController::class, 'create'])->name('appointment.create');
    Route::post('/store', [AppointmentController::class, 'store'])->name('appointment.store');
    Route::get('/{id}', [AppointmentController::class, 'detail'])->name('appointment.detail');
});

// patient protected routes
Route::middleware(['patient'])->prefix('patient')->group(function () {
    Route::get('/', [PatientController::class, 'index'])->name('patient.index');
    Route::post('/logout', [PatientController::class, 'logout'])->name('patient.logout');
    Route::get('/{patientId}/appointments', [PatientController::class, 'getAllAppointment'])
        ->name('patient.get-all-appointment');
    Route::get('/profile', [PatientController::class, 'profile'])->name('patient.profile');
    Route::post('/cancel', [PatientController::class, 'cancelAppointment'])->name('patient.cancel-appointment');
    Route::get('/update', [PatientController::class, 'edit'])->name('patient.edit');
    Route::post('/update', [PatientController::class, 'update'])->name('patient.update');
    Route::delete('/delete', [PatientController::class, 'destroy'])->name('patient.destroy');
    Route::get('/change-password', [PatientController::class, 'editPassword'])->name('patient.edit-password');
    Route::post('/change-password', [PatientController::class, 'updatePassword'])->name('patient.update-password');
    Route::get('/{patientId}/detail', [PatientController::class, 'detail'])->name('patient.detail');
});

// patient public
Route::prefix('patient')->group(function () {
    Route::get('/register', [PatientController::class, 'create'])->name('patient.create');
    Route::post('/register', [PatientController::class, 'store'])->name('patient.store');
    Route::get('/login', [PatientController::class, 'login'])->name('patient.login');
    Route::post('/login', [PatientController::class, 'authenticate'])->name('patient.authenticate');
    Route::view('/forgot-password', 'patient.forgot_password')->name('password.request');
    Route::post('/forgot-password', [PatientController::class, 'passwordEmail'])->name('password.email');
    Route::get('/reset-password/{token}', [PatientController::class, 'passwordReset'])->name('password.reset');
    Route::post('/reset-password', [PatientController::class, 'passwordUpdate'])->name('password.update');
});


Route::prefix('doctor')->group(function () {
    Route::get('/login', [DoctorController::class, 'login'])->name('doctor.login');
    Route::post('/login', [DoctorController::class, 'authenticate'])->name('doctor.authenticate');
    Route::get('/forgot/password', [DoctorController::class, 'forgotPassword'])->name('doctor.forgot.psw');
    Route::post('/forgot/action', [DoctorController::class, 'restlink'])->name('doctor.forgot.action');
    Route::get('/reset/password', [DoctorController::class, 'resetForm'])->name('doctor.reset.password');
    Route::post('/reset/password', [DoctorController::class, 'resetPassword'])->name('doctor.restore.password');
    Route::get('/department/{departmentId}', [DoctorController::class, 'getDocFromDepartmentId'])
        ->name('doctor.get-doc-from-department-id');
});

Route::middleware(['doctor'])->prefix('doctor')->group(function () {
    Route::post('/logout', [DoctorController::class, 'logout'])->name('doctor.logout');
    Route::get('/dashboard', [DoctorController::class, 'dashboard'])->name('doctor.dashboard');
    //profile
    Route::get('/profile', [DoctorController::class, 'profile'])->name('doctor.profile');
    Route::post('/upload', [DoctorController::class, 'uploadProfile'])->name('doctor.uploadProfile');
    Route::get('/change/password', [DoctorController::class, 'changePassword'])->name('doctor.change.psw');
    Route::post('/update/password', [DoctorController::class, 'updatePassword'])->name('doctor.upload.psw');

    //doctor's patientlist
    Route::get('/patient/list', [DoctorController::class, 'patientListByDoctorId'])->name('doctor.patient.list');
    Route::get('/patient-list/export', [DoctorController::class, 'downloadPatientList'])
        ->name('doctor.patient.list.export');
    Route::get('appointment/record/{patientId}', [DoctorController::class, 'appointmentRecordByPatientId'])
        ->name('doctor.patient.appointment.record');

    //doctor'sAppointmentRoutes
    Route::get('/appointment/list', [DoctorController::class, 'appointmentList'])->name('doctor.appointment.list');
    Route::get('appointment/view/{id}', [DoctorController::class, 'appointmentView'])->name('doctor.appointment.view');
    Route::put('/appointment/confirm/{id}', [DoctorController::class, 'appointmentConfirm'])
        ->name('doctor.appointment.confirm');
    Route::put('/appointment/reject/{id}', [DoctorController::class, 'appointmentReject'])
        ->name('doctor.appointment.reject');
    Route::put('/appointment/complete/{id}', [DoctorController::class, 'completeAppointment'])
        ->name('doctor.appointment.complete');
    Route::get('/appointment/list/export', [DoctorController::class, 'downloadAppoinrmentList'])
        ->name('admin.appointment.export');
    Route::get('/appointment/pending', [DoctorController::class, 'pendingAppointments'])
        ->name('doctor.pending.appointment');
    Route::get('/appointment/today', [DoctorController::class, 'todayAppointments'])
        ->name('doctor.today.appointment');
    Route::get('/appointment/confirmed', [DoctorController::class, 'confirmedAppointments'])
        ->name('doctor.confirm.appointment');
    Route::get('/appointment/finished', [DoctorController::class, 'finishedAppointments'])
        ->name('doctor.finished.appointment');
    Route::get('/appointment/rejected', [DoctorController::class, 'rejectedAppointments'])
        ->name('doctor.rejected.appointment');
    Route::get('/appointment/missed', [DoctorController::class, 'missedAppointments'])
        ->name('doctor.missed.appointment');
});
