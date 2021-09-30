<?php

namespace App\Http\Controllers\Watchers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class CaseController extends Controller
{
    /**
     * create controller instance
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * get single case page
     * @return Application|Factory|View
     */
    public function singleCasePage(): View|Factory|Application
    {
        return view('watchers.cases.single-case');
    }

    /**
     * get single case page
     * @return Factory|View|Application
     */
    public function massCasePage(): Factory|View|Application
    {
        return view('watchers.cases.mass-case');
    }
}
