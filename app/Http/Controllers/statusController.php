<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Doctor;
use App\Models\Profile;
use App\Models\Appointment;
use Illuminate\Http\Request;

class statusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $appointments = Appointment::with('user', 'profile', 'doctor')->where('status', 'Approved')->simplePaginate(5);

        $doctors = Doctor::get();

        foreach ($appointments as $appointment) {
            $appointment->appointment_date = Carbon::parse($appointment->appointment_date)->isoFormat('MMMM DD, YYYY');
        }
        // dd($appointments);
        return view('Patient.Appointment.index', compact('appointments', 'doctors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $appointment = Appointment::findorFail($id);

        if ($appointment->status == 'Approved') {
            $appointment->update([
                'status' => 'Pending',
            ]);
            $appointment->save();

            return redirect()->back()->with('rejected', 'success');
        } else {
            $appointment->update([
                'status' => 'Approved',
            ]);
            $appointment->save();
            return redirect()->back()->with('approved', 'success');
        }

        // dd($appointment->status);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
