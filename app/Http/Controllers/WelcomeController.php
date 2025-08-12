<?php

namespace App\Http\Controllers;

use App\Contracts\Services\DoctorServiceInterface;
use Illuminate\Contracts\View\View;

class WelcomeController extends Controller
{
    protected $doctorService;
    /**
     * @param DoctorServiceInterface $doctorService
     */

    public function __construct(
        DoctorServiceInterface $doctorService,
    ) {
        $this->doctorService = $doctorService;
    }

    /**
     * Summary of getLatestDoctor
     * @return \Illuminate\Contracts\View\View
     */
    public function getLatestDoctor(): View
    {
        $doctors = $this->doctorService->getLatestDoctor();
        return view('welcome', compact('doctors'));
    }
}
