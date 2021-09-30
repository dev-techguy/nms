<?php

namespace App\Http\Controllers;

use App\Models\Stakeholder;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class StakeholderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $allData = Stakeholder::all();
        return view('stakeholders.index', compact('allData'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('stakeholders.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'contact' => 'unique:stakeholders',
            'email' => 'email|unique:stakeholders',
        ]);

        $stakeholder = new stakeholder();
        $stakeholder->name = $request->name;
        $stakeholder->email = $request->email;
        $stakeholder->contact = $request->contact;
        $stakeholder->institution = $request->institution;
        $stakeholder->save();

        Session()->flash('success', 'Created successfully');

        return redirect()->route('stakeholders.index');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\stakeholder $stakeholder
     * @return Response
     */
    public function show(stakeholder $stakeholder)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\stakeholder $stakeholder
     * @return Response
     */
    public function edit(stakeholder $stakeholder)
    {
        $editData = $stakeholder;
        return view('stakeholders.edit', compact('editData'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param \App\stakeholder $stakeholder
     * @return Response
     */
    public function update(Request $request, stakeholder $stakeholder)
    {
        $stakeholder->name = $request->name;
        $stakeholder->email = $request->email;
        $stakeholder->contact = $request->contact;
        $stakeholder->institution = $request->institution;
        $stakeholder->save();

        Session()->flash('success', 'Updated successfully');

        return redirect()->route('stakeholders.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\stakeholder $stakeholder
     * @return Response
     */
    public function destroy(stakeholder $stakeholder)
    {
        $stakeholder->delete();
        Session()->flash('success', 'Deleted successfully');

        return redirect()->route('stakeholders.index');
    }
}
