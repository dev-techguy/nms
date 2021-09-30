<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class NurseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $users = User::whereHas('roles', function ($query) {
            return $query->whereIn('name', ['Nurse']);
        })->get();
        return view('nurses.index')->with('users', $users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('nurses.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //Validate name, email and password fields
        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'phone' => 'required|unique:users',
            'id_number' => 'required|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

        //Format phone
        $phone = formatPhone($request->phone);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $phone,
            'id_number' => $request->id_number,
            'password' => Hash::make($request->password)
        ]);

        $user->assignRole('Nurse'); //Assigning role to user

        //Redirect to the users.index view and display message
        return redirect()->route('nurses.index')
            ->with('success',
                'Paramedic successfully added.');

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return redirect('nurses');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id); //Get user with specified id
        return view('nurses.edit', compact('user')); //pass user and roles data to view
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id); //Get user specified by id

        //Validate name, email and password fields
        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'required|unique:users,phone,' . $id,
            'id_number' => 'required|unique:users,phone,' . $id,
            'password' => 'nullable|min:6|confirmed',
        ]);

        $input = $request->only(['name', 'email', 'id_number']); //Retrieve the name, email fields
        $user->fill($input)->save();

        //Format phone
        $phone = formatPhone($request->phone);

        $user->phone = $phone;
        $user->save();

        if ($request->get('password')) {
            $user->password = Hash::make($request->password);
            $user->save();
        }

        return redirect()->route('nurses.index')
            ->with('success',
                'Paramedic successfully edited.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //Find a user with a given id and delete
        $user = User::findOrFail($id);


        if ($user->email == 'matthewokusimba@gmail.com') {
            return redirect()->route('nurses.index')
                ->with('error',
                    'Paramedic not deleted');
        }

        if ($user->hasRole('Nurse'))
            $user->delete();

        return redirect()->route('nurses.index')
            ->with('success',
                'Paramedic successfully deleted.');
    }
}
