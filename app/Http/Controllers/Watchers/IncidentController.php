<?php

namespace App\Http\Controllers\Watchers;

use App\Http\Controllers\Controller;
use App\Models\Incident;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Validation\ValidationException;

class IncidentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Application|Factory|View
     */
    public function index(Request $request): View|Factory|Application
    {
        $user_id = $request->user()->id;

        $data = Incident::query()->where('watcher_id', $user_id)->orderBy('id', 'desc')->get();
        return view('watchers.cases.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create(): View|Factory|Application
    {
        return view('watchers.cases.case-panel');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        //Validate fields
        $this->validate($request, [
            'chief_complaint' => 'required',
            'location' => 'required',
            'alert_mode' => 'required',
        ]);

        $case_number = IdGenerator::generate(['table' => 'incidents', 'field' => 'case_number',
            'length' => 10, 'prefix' => 'CASE-']);

        //dd($request);
        $channel = '';
        $notifier_phone = '';

        $notifiers = $request->notifiers;
        if ($notifiers) {
            $channel_array = Arr::pluck($notifiers, 'channel');
            $channel = implode(",", $channel_array);

            $phone_array = Arr::pluck($notifiers, 'phone');
            $notifier_phone = implode(",", $phone_array);
        }

        $incident = Incident::create([
            'watcher_id' => $request->user()->id,
            'case_number' => $case_number,
            'chief_complaint' => $request->chief_complaint,
            'location' => $request->location,
            'location_lat' => $request->location_lat,
            'location_long' => $request->location_long,
            'sub_county' => $request->sub_county,
            'alert_mode' => $request->alert_mode,
            'channel' => $channel,
            'notifier_phone' => $notifier_phone,
            'alert_nature' => $request->alert_nature,
            'estate_health_facility' => $request->estate_health_facility,
            'patient_name' => $request->patient_name,
            'patient_age' => $request->patient_age,
            'patient_gender' => $request->patient_gender,
            'patient_nhif_insurance_data' => $request->patient_nhif_insurance_data,
            'patient_contact' => $request->patient_contact,
            'patient_next_of_kin' => $request->patient_next_of_kin,
            'mass_casualty_incident' => $request->mass_casualty_incident,
            'mass_casualty_cases' => $request->mass_casualty_cases,
            'watcher_comments' => $request->watcher_comments,
            'status' => 'draft',

        ]);

        //Log Activity
        activity('incident')
            ->performedOn($incident)
            ->causedBy($request->user())
            ->log('Case Created');


        //Redirect
        return redirect()->route('incidents.index')
            ->with('success',
                'Case successfully saved.');
    }

    /**
     * Display the specified resource.
     *
     * @param Incident $incident
     * @return Application|Factory|View
     */
    public function show(Incident $incident): View|Factory|Application
    {
        return view('watchers.cases.show', compact('incident'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Incident $incident
     * @return Application|Factory|View
     */
    public function edit(Incident $incident): View|Factory|Application
    {
        $channel_data = [];
        $phone_data = [];

        $channel = $incident->channel;
        $notifier_phone = $incident->notifier_phone;

        if ($channel) {
            $channel_data = explode(",", $channel);
        }
        if ($notifier_phone) {
            $phone_data = explode(",", $notifier_phone);
        }

        return view('watchers.cases.edit', compact('incident', 'channel_data', 'phone_data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Incident $incident
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function update(Request $request, Incident $incident): RedirectResponse
    {
        //Validate fields
        $this->validate($request, [
            'chief_complaint' => 'required',
            'location' => 'required',
            'alert_mode' => 'required',
        ]);

        $channel = '';
        $notifier_phone = '';

        $notifiers = $request->notifiers;
        if ($notifiers) {
            $channel_array = Arr::pluck($notifiers, 'channel');
            $channel = implode(",", $channel_array);

            $phone_array = Arr::pluck($notifiers, 'phone');
            $notifier_phone = implode(",", $phone_array);
        }

        $input = $request->only(['chief_complaint', 'location',
            'location_lat', 'location_long', 'sub_county', 'alert_mode',
            'alert_nature', 'estate_health_facility', 'patient_name', 'patient_age',
            'patient_gender', 'patient_nhif_insurance_data', 'patient_contact',
            'patient_next_of_kin', 'status', 'mass_casualty_incident', 'watcher_comments', 'mass_casualty_cases']);

        $incident->fill($input)->save();

        $incident->channel = $channel;
        $incident->notifier_phone = $notifier_phone;
        $incident->save();

        //Log Activity
        activity('incident')
            ->performedOn($incident)
            ->causedBy($request->user())
            ->log('Case Updated');


        //Redirect
        return redirect()->route('incidents.index')
            ->with('success',
                'Case successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Incident $incident
     * @return Application|Factory|View
     */
    public function resolveCase(Incident $incident): View|Factory|Application
    {
        return view('watchers.cases.resolve', compact('incident'));
    }


    /**
     * Resolve
     *
     * @param Request $request
     * @param Incident $incident
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function resolve(Request $request, Incident $incident): RedirectResponse
    {
        //Validate fields
        $this->validate($request, [
            'watcher_comments' => 'required',
        ]);

        $incident->watcher_comments = $request->watcher_comments;
        $incident->status = 'resolved';
        $incident->save();

        //Log Activity
        activity('incident')
            ->performedOn($incident)
            ->causedBy($request->user())
            ->log('Case Resolved');

        return redirect()->route('incidents.index')
            ->with('success',
                'Case marked as resolved');
    }

    /**
     * Resolve
     *
     * @param Request $request
     * @param Incident $incident
     * @return RedirectResponse
     */
    public function submit(Request $request, Incident $incident): RedirectResponse
    {

        $incident->status = 'submitted';
        $incident->save();

        //Log Activity
        activity('incident')
            ->performedOn($incident)
            ->causedBy($request->user())
            ->log('Case Submitted');

        return redirect()->route('incidents.index')
            ->with('success',
                'Case submitted to dispatch');
    }
}
