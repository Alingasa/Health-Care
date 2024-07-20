<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\User;
use App\Models\Profile;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        // dd($id);
        $doctors = Profile::with('role')
            ->whereHas('role', function ($query) {
                $query->where('role_name', 'Doctor');
            })->simplePaginate(5);

        return view('Patient.Appointment.create', compact('doctors'))->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        // $u =  auth()->user()->id;

        // dd(auth()->user());
        // $user = User::findorFail($request['user_id']);
        // dd($user);

        $data = $request->validate([
            // 'user_id' => $request['user_id'],
            'profile_id' => 'required',
            'doctor_id' => 'required',
            'requests' => 'required',
            'appointment_date' => 'required',
        ]);

        if ($request['user_id']) {
            $data['user_id'] = $request['user_id'];
        }
        if ($request['status']) {
            $data['status'] = $request['status'];
        }
        // dd($data);
        Appointment::create($data);
        return redirect()->route('patient.edit', $data['profile_id'])->with('add_success', 'succeses');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //=

        // $appointment = Appointment::where('profile_id', $id);
        // // dd($appointment);
        // // dd($appointment);
        // return view('Patient.Appointment.appointment_view', compact('appointment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //

        // dd($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        // dd($request->all());
        $data = $request->validate([
            // 'user_id' => $request['user_id'],
            'profile_id' => 'required',
            // 'doctor_id' => 'required',
            'requests' => 'required',
            'appointment_date' => 'required',
        ]);

        // dd($request->all());

        if ($request['user_id']) {
            $data['user_id'] = $request['user_id'];
        }
        if ($request['status']) {
            $data['status'] = $request['status'];
        }
        $profile = Appointment::findorFail($id);


        $profile->update($data);
        // dd($profile->doctor_id);
        $profile->save();
        return redirect()->back()->with('update_success', 'success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $delete = Appointment::findorFail($id);
        $delete->delete();
        return redirect()->route('patient.edit', $delete->profile_id)->with('delete', 'success');
    }
}
