<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Admin
        $this->app->bind('App\Contracts\Services\AdminServiceInterface', 'App\Services\AdminService');
        $this->app->bind('App\Contracts\Dao\AdminDaoInterface', 'App\Dao\AdminDao');

        // Doctor
        $this->app->bind('App\Contracts\Services\DoctorServiceInterface', 'App\Services\DoctorService');
        $this->app->bind('App\Contracts\Dao\DoctorDaoInterface', 'App\Dao\DoctorDao');

        // Patient
        $this->app->bind('App\Contracts\Services\PatientServiceInterface', 'App\Services\PatientService');
        $this->app->bind('App\Contracts\Dao\PatientDaoInterface', 'App\Dao\PatientDao');

        // Appointment
        $this->app->bind('App\Contracts\Services\AppointmentServiceInterface', 'App\Services\AppointmentService');
        $this->app->bind('App\Contracts\Dao\AppointmentDaoInterface', 'App\Dao\AppointmentDao');

        // Room
        $this->app->bind('App\Contracts\Services\RoomServiceInterface', 'App\Services\RoomService');
        $this->app->bind('App\Contracts\Dao\RoomDaoInterface', 'App\Dao\RoomDao');

        // Department
        $this->app->bind('App\Contracts\Services\DepartmentServiceInterface', 'App\Services\DepartmentService');
        $this->app->bind('App\Contracts\Dao\DepartmentDaoInterface', 'App\Dao\DepartmentDao');
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFour();
    }
}
