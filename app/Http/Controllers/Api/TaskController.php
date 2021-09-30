<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Coordinates;
use App\Http\Helpers\Tracker;
use App\Models\Incident;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public $successStatus = 200;
    public $unauthorisedStatus = 401;
    public $unverifiedUser = 201;
    public $notFoundStatus = 404;
    public $notAllowedStatus = 405;


    protected $helper;
    protected $tracker;

    public function __construct()
    {
        $this->helper = new Coordinates();
        $this->tracker = new Tracker();
    }


    public function tasks(Request $request)
    {
        $user_id = $request->user()->id;

        $status = $request->status;

        if ($status) {
            $tasks = Task::where('driver_id', $user_id)
                ->where('status', $status)
                ->orderBy('id', 'desc')
                ->get();
        } else {
            $tasks = Task::where('driver_id', $user_id)
                ->orderBy('id', 'desc')
                ->get();
        }

        $taskList = [];

        if ($tasks) {
            foreach ($tasks as $item) {
                $caseData = [];
                if ($item->incident_id) {
                    $caseData = [
                        'id' => $item->incident->id,
                        'watcher' => $item->incident->watcher->name,
                        'dispatcher' => $item->incident->dispatcher->name,
                        'facility' => $item->incident->facility->title,
                        'case_number' => $item->incident->case_number,
                        'chief_complaint' => $item->incident->chief_complaint,
                        'location' => $item->incident->location,
                        'location_lat' => $item->incident->location_lat,
                        'location_long' => $item->incident->location_long,
                        'alert_mode' => $item->incident->alert_mode,
                        'channel' => $item->incident->channel,
                        'notifier_phone' => $item->incident->notifier_phone,
                        'alert_nature' => $item->incident->alert_nature,
                        'patient_name' => $item->incident->patient_name,
                        'patient_age' => $item->incident->patient_age,
                        'patient_gender' => $item->incident->patient_gender,
                        'status' => $item->incident->status,
                        'date' => $item->incident->created_at->format('Y-m-d H:i:s'),
                    ];
                }
                $taskList[] = [
                    'id' => $item->id,
                    'vehicle_name' => $item->vehicle->registration_number,
                    'case_id' => $item->incident_id,
                    'task_name' => $item->task_name,
                    'case' => $caseData,
                    'accepted_on' => $item->accepted_on,
                    'completed_on' => $item->completed_on,
                    'rejected_on' => $item->rejected_on,
                    'cancelled_on' => $item->cancelled_on,
                    'pick_time' => $item->pick_time,
                    'facility_arrival_time' => $item->facility_arrival_time,
                    'challenges' => $item->challenges,
                    'comments' => $item->comments,
                    'guest_nurse_name' => $item->guest_nurse_name,
                    'guest_nurse_phone' => $item->guest_nurse_phone,
                    'guest_nurse_id_number' => $item->guest_nurse_id_number,
                    'status' => $item->status,
                    'date' => $item->created_at->format('Y-m-d H:i:s'),
                ];
            }
        }


        $success['status'] = $this->successStatus;
        $success['taskList'] = $taskList;
        return response()->json(['success' => $success], $this->successStatus);
    }

    public function singleTask(Request $request, $id)
    {
        $user_id = $request->user()->id;

        $task_id = $id;

        if (!$task_id) {
            $success['status'] = $this->notAllowedStatus;
            $success['message'] = "Missing Task ID";
            return response()->json(['success' => $success], $this->notAllowedStatus);
        }

        $task = Task::where('id', $task_id)
            ->where('driver_id', $user_id)
            ->first();

        if (!$task) {
            $success['status'] = $this->notAllowedStatus;
            $success['message'] = "Invalid task";
            return response()->json(['success' => $success], $this->notAllowedStatus);
        }

        $caseData = [];
        if ($task->incident_id) {
            $caseData = [
                'id' => $task->incident->id,
                'watcher' => $task->incident->watcher->name,
                'dispatcher' => $task->incident->dispatcher->name,
                'facility' => $task->incident->facility->title,
                'case_number' => $task->incident->case_number,
                'chief_complaint' => $task->incident->chief_complaint,
                'location' => $task->incident->location,
                'location_lat' => $task->incident->location_lat,
                'location_long' => $task->incident->location_long,
                'alert_mode' => $task->incident->alert_mode,
                'channel' => $task->incident->channel,
                'notifier_phone' => $task->incident->notifier_phone,
                'alert_nature' => $task->incident->alert_nature,
                'patient_name' => $task->incident->patient_name,
                'patient_age' => $task->incident->patient_age,
                'patient_gender' => $task->incident->patient_gender,
                'status' => $task->incident->status,
                'date' => $task->incident->created_at->format('Y-m-d H:i:s'),
            ];
        }

        $taskData = [
            'id' => $task->id,
            'vehicle_name' => $task->vehicle->registration_number,
            'case_id' => $task->incident_id,
            'task_name' => $task->task_name,
            'case' => $caseData,
            'accepted_on' => $task->accepted_on,
            'completed_on' => $task->completed_on,
            'rejected_on' => $task->rejected_on,
            'cancelled_on' => $task->cancelled_on,
            'pick_time' => $task->pick_time,
            'facility_arrival_time' => $task->facility_arrival_time,
            'challenges' => $task->challenges,
            'comments' => $task->comments,
            'guest_nurse_name' => $task->guest_nurse_name,
            'guest_nurse_phone' => $task->guest_nurse_phone,
            'guest_nurse_id_number' => $task->guest_nurse_id_number,
            'status' => $task->status,
            'date' => $task->created_at->format('Y-m-d H:i:s'),
        ];


        $success['status'] = $this->successStatus;
        $success['taskData'] = $taskData;
        return response()->json(['success' => $success], $this->successStatus);
    }


    public function taskAction(Request $request, $action, $id)
    {
        $user_id = $request->user()->id;
        $task_id = $id;

        if (!$action) {
            $success['status'] = $this->notAllowedStatus;
            $success['message'] = "Missing Action. Allowed actions are accept, reject or complete";
            return response()->json(['success' => $success], $this->notAllowedStatus);
        }

        if (!$task_id) {
            $success['status'] = $this->notAllowedStatus;
            $success['message'] = "Missing Task ID";
            return response()->json(['success' => $success], $this->notAllowedStatus);
        }

        $task = Task::where('id', $task_id)
            ->where('driver_id', $user_id)
            ->first();

        if (!$task) {
            $success['status'] = $this->notAllowedStatus;
            $success['message'] = "Invalid task";
            return response()->json(['success' => $success], $this->notAllowedStatus);
        }

        if ($action == 'accept') {
            $task->status = 'accepted';
            $task->accepted_on = date('Y-m-d H:i:s');
            $task->rejected_on = NULL;
            $task->save();

            $incident = Incident::findOrFail($task->incident_id);
            $incident->status = 'responders_handling';
            $incident->save();

            //Log Activity
            activity('task')
                ->performedOn($task)
                ->causedBy($request->user())
                ->log('Task Accepted');

            activity('case')
                ->performedOn($incident)
                ->causedBy($request->user())
                ->log('Responders Handling');
        } elseif ($action == 'reject') {
            $task->status = 'rejected';
            $task->rejected_on = date('Y-m-d H:i:s');
            $task->save();

            //Log Activity
            activity('task')
                ->performedOn($task)
                ->causedBy($request->user())
                ->log('Task Rejected');
        } elseif ($action == 'pick') {
            $task->pick_time = date('Y-m-d H:i:s');
            $task->save();

            //Log Activity
            activity('task')
                ->performedOn($task)
                ->causedBy($request->user())
                ->log('Patient Picked');
        } elseif ($action == 'arrive') {
            $task->facility_arrival_time = date('Y-m-d H:i:s');
            $task->save();

            //Log Activity
            activity('task')
                ->performedOn($task)
                ->causedBy($request->user())
                ->log('Arrived at facility');
        } elseif ($action == 'report') {
            /*if ($task->status != 'completed') {
                $success['status'] = $this->notAllowedStatus;
                $success['message'] = "Task is not complete";
                return response()->json(['success' => $success], $this->notAllowedStatus);
            }*/

            $request->validate([
                'challenges' => 'required',
                'comments' => 'required',
            ]);

            $task->challenges = $request->challenges;
            $task->comments = $request->comments;
            $task->save();

            //Log Activity
            activity('task')
                ->performedOn($task)
                ->causedBy($request->user())
                ->log('Task Report Filed');
        } elseif ($action == 'guest') {
            $request->validate([
                'guest_nurse_name' => 'required',
                'guest_nurse_phone' => 'required',
                'guest_nurse_id_number' => 'required',
            ]);

            $task->guest_nurse_name = $request->guest_nurse_name;
            $task->guest_nurse_phone = $request->guest_nurse_phone;
            $task->guest_nurse_id_number = $request->guest_nurse_id_number;
            $task->save();

            //Log Activity
            activity('task')
                ->performedOn($task)
                ->causedBy($request->user())
                ->log('Guest Nurse Added');

            $success['status'] = $this->successStatus;
            $success['message'] = 'You have successfully added the guest nurse';
            return response()->json(['success' => $success], $this->successStatus);
        } elseif ($action == 'complete') {
            $task->status = 'completed';
            $task->completed_on = date('Y-m-d H:i:s');
            $task->save();


            //record tracking data
            //Get tracking data
            $vehicleList = [];
            $strCookie = session()->getId();
            //dd($strCookie);
            $timestamp = time();
            $trackerLogin = $this->tracker->login($timestamp, $strCookie);

            //dd($trackerLogin);
            if ($trackerLogin == 'ok') {
                $vehicleList = $this->tracker->vehicleList($timestamp, $strCookie);
                //dd($vehicleList);
            }

            $end_lat = '';
            $end_long = '';

            if ($vehicleList) {
                foreach ($vehicleList as $item) {
                    if ($item['id'] == $task->tracker_object_id) {
                        $end_lat = $item['lat'];
                        $end_long = $item['long'];
                        break;
                    }
                }
            }

            $task->end_lat = $end_lat;
            $task->end_long = $end_long;
            $task->save();

            //Log Activity
            activity('task')
                ->performedOn($task)
                ->causedBy($request->user())
                ->log('Task Completed');
        } else {
            $success['status'] = $this->notAllowedStatus;
            $success['message'] = "Invalid task action";
            return response()->json(['success' => $success], $this->notAllowedStatus);
        }

        $caseData = [];
        if ($task->incident_id) {
            $caseData = [
                'id' => $task->incident->id,
                'watcher' => $task->incident->watcher->name,
                'dispatcher' => $task->incident->dispatcher->name,
                'facility' => $task->incident->facility->title,
                'case_number' => $task->incident->case_number,
                'chief_complaint' => $task->incident->chief_complaint,
                'location' => $task->incident->location,
                'location_lat' => $task->incident->location_lat,
                'location_long' => $task->incident->location_long,
                'alert_mode' => $task->incident->alert_mode,
                'channel' => $task->incident->channel,
                'notifier_phone' => $task->incident->notifier_phone,
                'alert_nature' => $task->incident->alert_nature,
                'patient_name' => $task->incident->patient_name,
                'patient_age' => $task->incident->patient_age,
                'patient_gender' => $task->incident->patient_gender,
                'status' => $task->incident->status,
                'date' => $task->incident->created_at->format('Y-m-d H:i:s'),
            ];
        }

        $taskData = [
            'id' => $task->id,
            'vehicle_name' => $task->vehicle->registration_number,
            'case_id' => $task->incident_id,
            'task_name' => $task->task_name,
            'case' => $caseData,
            'status' => $task->status,
            'date' => $task->created_at->format('Y-m-d H:i:s'),
        ];


        $success['status'] = $this->successStatus;
        $success['taskData'] = $taskData;
        return response()->json(['success' => $success], $this->successStatus);
    }


    public function tasksSummary(Request $request)
    {
        $user_id = $request->user()->id;

        $tasks = Task::where('driver_id', $user_id)
            ->get();
        //$status = pending|received|accepted|completed|rejected|cancelled

        $taskSumarry = [];
        $taskSumarry['today'] = ['total' => 0, 'pending' => 0, 'accepted' => 0,
            'completed' => 0, 'rejected' => 0, 'cancelled' => 0];

        $taskSumarry['all'] = ['total' => 0, 'pending' => 0, 'accepted' => 0,
            'completed' => 0, 'rejected' => 0, 'cancelled' => 0];

        if ($tasks) {
            foreach ($tasks as $item) {
                $created_date = $item->created_at->format('Y-m-d');
                $today = date('Y-m-d');
                if (strtotime($today) == strtotime($created_date)) {
                    $taskSumarry['today']['total'] += 1;

                    if ($item->status == 'pending')
                        $taskSumarry['today']['pending'] += 1;
                    elseif ($item->status == 'accepted')
                        $taskSumarry['today']['accepted'] += 1;
                    elseif ($item->status == 'completed')
                        $taskSumarry['today']['completed'] += 1;
                    elseif ($item->status == 'rejected')
                        $taskSumarry['today']['rejected'] += 1;
                    elseif ($item->status == 'cancelled')
                        $taskSumarry['today']['cancelled'] += 1;
                }

                $taskSumarry['all']['total'] += 1;

                if ($item->status == 'pending')
                    $taskSumarry['all']['pending'] += 1;
                elseif ($item->status == 'accepted')
                    $taskSumarry['all']['accepted'] += 1;
                elseif ($item->status == 'completed')
                    $taskSumarry['all']['completed'] += 1;
                elseif ($item->status == 'rejected')
                    $taskSumarry['all']['rejected'] += 1;
                elseif ($item->status == 'cancelled')
                    $taskSumarry['all']['cancelled'] += 1;
            }
        }


        $success['status'] = $this->successStatus;
        $success['taskSumarry'] = $taskSumarry;
        return response()->json(['success' => $success], $this->successStatus);
    }


    public function singleCase(Request $request, $id)
    {
        //$user_id = $request->user()->id;

        $case_id = $id;

        if (!$case_id) {
            $success['status'] = $this->notAllowedStatus;
            $success['message'] = "Missing Case ID";
            return response()->json(['success' => $success], $this->notAllowedStatus);
        }

        $case = Incident::where('id', $case_id)
            ->first();

        if (!$case) {
            $success['status'] = $this->notAllowedStatus;
            $success['message'] = "Invalid Case";
            return response()->json(['success' => $success], $this->notAllowedStatus);
        }

        $caseData = [
            'id' => $case->id,
            'watcher' => $case->watcher->name,
            'dispatcher' => $case->dispatcher->name,
            'facility' => $case->facility->title,
            'case_number' => $case->case_number,
            'chief_complaint' => $case->chief_complaint,
            'location' => $case->location,
            'location_lat' => $case->location_lat,
            'location_long' => $case->location_long,
            'alert_mode' => $case->alert_mode,
            'channel' => $case->channel,
            'notifier_phone' => $case->notifier_phone,
            'alert_nature' => $case->alert_nature,
            'patient_name' => $case->patient_name,
            'patient_age' => $case->patient_age,
            'patient_gender' => $case->patient_gender,
            'status' => $case->status,
            'date' => $case->created_at->format('Y-m-d H:i:s'),
        ];


        $success['status'] = $this->successStatus;
        $success['caseData'] = $caseData;
        return response()->json(['success' => $success], $this->successStatus);
    }

}
