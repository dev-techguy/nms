<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class EMTController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $users = User::whereHas('roles', function ($query) {
            return $query->whereIn('name', ['EMT']);
        })->get();
        return view('emts.index')->with('users', $users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('emts.create');
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

        $user->assignRole('EMT'); //Assigning role to user

        //Redirect to the users.index view and display message
        return redirect()->route('emts.index')
            ->with('success',
                'EMT successfully added.');

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return redirect('emts');
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
        return view('emts.edit', compact('user')); //pass user and roles data to view
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

        return redirect()->route('emts.index')
            ->with('success',
                'EMT successfully edited.');
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
            return redirect()->route('emts.index')
                ->with('error',
                    'EMT not deleted');
        }

        if ($user->hasRole('EMT'))
            $user->delete();

        return redirect()->route('emts.index')
            ->with('success',
                'EMT successfully deleted.');
    }
}
