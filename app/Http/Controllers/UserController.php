<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Carbon\Carbon;
use App\Models\Role;
use App\Models\User;
use App\Models\Profile;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $users = Profile::simplePaginate(5);

        foreach ($users as $user) {
            $user->birth_of_birth = Carbon::parse($user->date_of_birth)->isoFormat('MMMM DD, YYYY');
        }
        return view('User.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $roles = Role::all();
        return view('User.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        // dd($request->all());
        // dd('mweehehehe');

        $data = $request->validate([
            'role_id' => 'required',
            'first_name' => 'required',
            'middle_name'   => 'required',
            'last_name' => 'required',
            'date_of_birth' => 'required',
            'gender' => 'required',
            'address' => 'required',
            'email' => 'required|unique:profiles',
        ]);

        if ($request->hasFile('profile_image')) {
            $image = $request->file('profile_image');
            $imagePath = $image->store('images', 'public');
            $data['profile_image'] = $imagePath;
        } else {
            $data['profile_image'] = null;
        }


        $email = strtolower($data['first_name'][0]) . '.' . strtolower($data['last_name']) . '@healthcare.com';

        $i = 1;
        while (User::where('email', $email)->exists()) {
            $email = strtolower($data['first_name'][0]) . '.' . strtolower($data['last_name']) . $i . '@healthcare.com';
            $i++;
        }

        $data['user_id'] =  User::create([
            'profile_image' => $data['profile_image'] ?? null,
            'name' => $data['first_name'] . ' ' . $data['last_name'],
            'email' => $email,
            'password' => 'healthcare2024',
        ])->id;

        Profile::create($data);

        $doctor = Profile::with('role')
            ->whereHas('role', function ($query) {
                $query->where('role_name', 'Doctor');
            })->latest()->first();


        $createDoctor = Doctor::firstOrCreate([
            'profile_id' => $doctor->id ?? null,
            'profile_image' => $doctor->profile_image ?? null,
            'role' => $doctor->role->role_name ?? null,
            'full_name' => $doctor->full_name ?? null,
            'email' => $doctor->email ?? null,
        ]);

        if (!$createDoctor->exists) {
            // $data['doctor_id'] = $createDoctor->id;
            $doctor->save();
        }

        return redirect()->route('user.index')->with('add_success', 'added successfully');
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
        $user = Profile::with('user')->findorFail($id);

        $user->birth_of_birth = Carbon::parse($user->date_of_birth)->isoFormat('MMMM DD, YYYY');

        $roles = Role::all();
        return view('User.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        // dd($id);
        $profile = Profile::findorFail($id);
        $data = $request->validate([
            'first_name' => 'required',
            'middle_name'   => 'required',
            'last_name' => 'required',
            'date_of_birth' => 'required',
            'gender' => 'required',
            'address' => 'required',
            'email' => 'required',
        ]);

        if ($request->hasFile('profile_image')) {
            $image = $request->file('profile_image');
            $imagePath = $image->store('images', 'public');
            $data['profile_image'] = $imagePath;
        } else {
            // $data['profile_image'];
        }

        // if ($request['specialization']) {
        //     $data['specialization'] = $request['specialization'];
        // } else {
        //     $data['specialization'] = null;
        // }

        // dd($data);
        if ($doctorUpdate = Doctor::where('profile_id', $id)) {
            $doctorUpdate->update([
                'profile_image' => $data['profile_image'] ?? null,
                'full_name' => $data['first_name'] . ' ' . $data['last_name'],
                'email' => $data['email'],
                'updated_at' => now(),
            ]);
        }

        $profile->update($data);

        // dd($data);
        return redirect()->back()->with('update_success', 'success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //

        $user = Profile::findorFail($id);
        $account = User::findorFail($user->user_id);
        $account->delete();
        $user->delete();

        return redirect()->route('user.index')->with('delete', 'success');
    }
}
