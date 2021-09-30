<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class WatcherDispatcherController extends Controller
{
    /**
     * Show the form for choosing user type
     *
     * @return Application|Factory|View
     */
    public function login()
    {
        return view('watcherdispatcher');
    }


    /**
     * Store user type in session
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function setUserType(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'usertype' => 'required',
        ]);

        $request->session()->put('usertype', $request->usertype);

        // Redirect to the watchers dashboard
        return redirect()->route('watchers.dashboard');

    }

}
