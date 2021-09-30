<?php

namespace App\Http\Controllers;

use App\Http\Helpers\Coordinates;
use App\Http\Helpers\Tracker;
use App\Models\DriverVehicle;
use App\Models\EmergencyCenter;
use App\Models\Facility;
use App\Models\Incident;
use App\Models\Task;
use FCM;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use Spatie\Activitylog\Models\Activity;

//use App\Models\User;

class TaskController extends Controller
{

    protected $helper;
    protected $tracker;

    public function __construct()
    {
        $this->helper = new Coordinates();
        $this->tracker = new Tracker();
    }


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $tasks = Task::orderBy('id', 'desc')->get();
        return view('tasks.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create($id)
    {
        $driver_vehicle = DriverVehicle::findOrFail($id);

        //Check if driver has not checked out
        if ($driver_vehicle->check_out) {
            return redirect()->route('tasks.index')
                ->with('error',
                    'Driver has already checked out');
        }

        //Check if driver has another task
        $task = Task::where('driver_id', $driver_vehicle->driver_id)
            ->whereNotIn('status', ['completed', 'cancelled'])
            ->first();
        //dd($task);
        if ($task) {
            return redirect()->route('tasks.show', $task)
                ->with('error',
                    'Driver has an active task');
        }

        $emergencycenters = EmergencyCenter::all();
        $facilities = Facility::orderBy('title', 'asc')->get();

        return view('tasks.create', compact('driver_vehicle', 'id', 'emergencycenters', 'facilities'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //Validate fields
        $this->validate($request, [
            'driver_id' => 'required',
            'vehicle_id' => 'required',
            'incident_id' => 'required',
        ]);

        //dd($request->input());
        //$driver_vehicle = DriverVehicle::findOrFail($id);

        $task = Task::create([
            'driver_id' => $request->driver_id,
            'vehicle_id' => $request->vehicle_id,
            'incident_id' => $request->incident_id,
            'emt_id' => $request->emt_id,
            'nurse_id' => $request->nurse_id,
            //'task_name' => $request->task_name,
            'status' => 'pending',

        ]);

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

        $tracker_object_id = '';
        $start_lat = '';
        $start_long = '';

        if ($vehicleList) {
            foreach ($vehicleList as $item) {
                if ($item['id'] == $request->id) {
                    $tracker_object_id = $item['id'];
                    $start_lat = $item['lat'];
                    $start_long = $item['long'];
                    break;
                }
            }
        }

        $task->task_name = "Emergency at " . $task->incident->location;
        $task->tracker_object_id = $tracker_object_id;
        $task->start_lat = $start_lat;
        $task->start_long = $start_long;
        $task->save();

        $incident = Incident::findOrFail($task->incident_id);
        $incident->status = 'dispatched';
        $incident->save();

        //Send Notification
        $notification_title = $task->incident->location;
        $notification_body = "Emergency at " . $task->incident->location;
        $task_id = $task->id;
        $task_date = $task->created_at;
        $fcm_token = $task->driver->fcm_token;

        $optionBuilder = new OptionsBuilder();
        $optionBuilder->setTimeToLive(60 * 20);

        $notificationBuilder = new PayloadNotificationBuilder($notification_title);
        $notificationBuilder->setBody($notification_body)
            ->setSound('default');

        $dataBuilder = new PayloadDataBuilder();
        $dataBuilder->addData(['task_id' => $task_id, 'task_name' => $notification_body, 'task_date' => $task_date]);

        $option = $optionBuilder->build();
        $notification = $notificationBuilder->build();
        $data = $dataBuilder->build();

        $token = $fcm_token;

        $downstreamResponse = FCM::sendTo($token, $option, $notification, $data);


        //Log Activity
        activity('task')
            ->performedOn($task)
            ->causedBy($request->user())
            ->log('Task Created');

        activity('case')
            ->performedOn($incident)
            ->causedBy($request->user())
            ->log('Case Dispatched');

        //Redirect
        return redirect()->route('cases.dispatch.tasks', $incident)
            ->with('success',
                'Task successfully submitted.');

    }


    /**
     * Display the specified resource.
     *
     * @param int $task
     * @return Response
     */
    public function show(Task $task)
    {
        $activities = Activity::where('subject_id', $task->id)
            ->where('log_name', 'task')
            ->orderBy('id', 'desc')
            ->get();

        return view('tasks.show', compact('task', 'activities'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $task
     * @return Response
     */
    public function destroy(Request $request, Task $task)
    {

        if (in_array($task->status, ['completed', 'rejected', 'cancelled'])) {
            return redirect()->route('tasks.index')
                ->with('error',
                    'Task cannot be cancelled.');
        }

        $task->status = 'cancelled';
        $task->cancelled_on = date('Y-m-d H:i:s');
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


        //Send Notification
        $notification_title = "Task Cancelled";
        $notification_body = "Emergency at " . $request->emergency_location;
        $task_id = $task->id;
        $task_date = $task->created_at;
        $fcm_token = $task->driver->fcm_token;

        $optionBuilder = new OptionsBuilder();
        $optionBuilder->setTimeToLive(60 * 20);

        $notificationBuilder = new PayloadNotificationBuilder($notification_title);
        $notificationBuilder->setBody($notification_body)
            ->setSound('default');

        $dataBuilder = new PayloadDataBuilder();
        $dataBuilder->addData(['task_id' => $task_id, 'task_name' => $notification_body, 'task_date' => $task_date]);

        $option = $optionBuilder->build();
        $notification = $notificationBuilder->build();
        $data = $dataBuilder->build();

        $token = $fcm_token;

        $downstreamResponse = FCM::sendTo($token, $option, $notification, $data);

        //Log Activity
        activity('task')
            ->performedOn($task)
            ->causedBy($request->user())
            ->log('Task cancelled');

        return redirect()->route('tasks.index')
            ->with('success',
                'Task successfully cancelled.');
    }
}
