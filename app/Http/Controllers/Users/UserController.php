<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

//Importing laravel-permission models

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware(['auth', 'isAdmin']); //isAdmin middleware lets only users with a //specific permission permission to access these resources
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //Get all users and pass it to the view
        //role(['Super Admin', 'Admin'])->
        //$users = User::get();
        $users = User::whereHas('roles', function ($query) {
            return $query->whereNotIn('name', ['Driver', 'EMT', 'Nurse']);
        })->get();
        return view('auth.users.index')->with('users', $users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //Get all roles and pass it to the view
        $roles = Role::whereNotIn('name', ['Driver', 'EMT', 'Nurse'])
            ->orderBy('name', 'asc')->get();
        return view('auth.users.create', ['roles' => $roles]);
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
            'password' => 'required|min:6|confirmed'
        ]);

        //$user = User::create($request->only('email', 'name', 'password')); //Retrieving only the email and password data

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $roles = $request['roles']; //Retrieving the roles field
        //Checking if a role was selected
        if (isset($roles)) {

            foreach ($roles as $role) {
                $role_r = Role::where('id', '=', $role)->firstOrFail();
                $user->assignRole($role_r); //Assigning role to user
            }
        }

        //Redirect to the users.index view and display message
        return redirect()->route('users.index')
            ->with('success',
                'User successfully added.');

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return redirect('users');
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
        $roles = Role::whereNotIn('name', ['Driver', 'EMT', 'Nurse'])
            ->orderBy('name', 'asc')->get(); //Get all roles

        return view('auth.users.edit', compact('user', 'roles')); //pass user and roles data to view
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
            'password' => 'nullable|min:6|confirmed'
        ]);
        $input = $request->only(['name', 'email']); //Retrieve the name, email fields
        $roles = $request['roles']; //Retreive all roles
        $user->fill($input)->save();

        if ($request->get('password')) {
            $user->password = Hash::make($request->password);
            $user->save();
        }

        if (isset($roles)) {
            $user->roles()->sync($roles);  //If one or more role is selected associate user to roles
        } else {
            $user->roles()->detach(); //If no role is selected remove exisiting role associated to a user
        }
        return redirect()->route('users.index')
            ->with('success',
                'User successfully edited.');
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
            return redirect()->route('users.index')
                ->with('error',
                    'User not deleted');
        }

        $user->delete();

        return redirect()->route('users.index')
            ->with('success',
                'User successfully deleted.');
    }
}
