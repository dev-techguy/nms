<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{

    /**
     * @param  $request
     * @return mixed
     */
    public function toResponse($request)
    {
        //$home = auth()->user()->is_admin ? '/admin' : '/dashboard';
        $home = '/';
        if (auth()->user()->hasRole('Watcher'))
            $home = '/watchers';
        if (auth()->user()->hasRole('Dispatcher'))
            $home = '/dispatchers';
        //dd($home);
        return redirect()->intended($home);
    }

}
