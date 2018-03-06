<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User;
use App\Event;
use App\Group;
use App\UserEvent;
use Auth;
use Carbon\Carbon;

class EventController extends Controller
{
    /**
     * Repository implementation.
     *
     */
    protected $user;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        
        $this->middleware('auth:api');
        $this->user = Auth::guard('api')->user();
    }

    public function getEventById($id) {
        $events = Event::where('id', $id)->with('users')->first();
        $events->users->map(function ($users) {
            $users["paid"] = $users["pivot"]["paid"];
        });

        return response()->json($events, 200)->header('Content-Type', 'application/json');
    }

    public function getParticipantsOfEventById($id) {
        $events = Event::where('id', $id)->with('users')->first();
        $events->users->map(function ($users) {
            $users["paid"] = $users["pivot"]["paid"];
        });

        return response()->json($events->users, 200)->header('Content-Type', 'application/json');
    }

    public function getAllMyEvents() {
        $events = Event::whereIn('id', UserEvent::where('user_id', $this->user->id)->pluck('event_id'))
	        ->with('group')
	        ->orderBy('date', 'DESC')
	        ->limit(30)
	        ->get();
    	// $events->users->map(function ($users) {
    	// 	$users["paid"] = $users["pivot"]["paid"];
    	// });

        return $events;
    }

    public function getEventByIdWithParticipants($id) {
        $events = Event::where('id', $id)->with('users')->first();
    	$events->users->map(function ($users) {
    		$users["paid"] = $users["pivot"]["paid"];
    	});

        return response()->json($events, 200)->header('Content-Type', 'application/json');
    }

    // cria um novo evento no banco
    public function createEvent(Request $request) {
    	$event = new Event;
    	try { 
    		$event->fill($request->all());
    		$event->date = Carbon::parse($event->date)->toDateTimeString();
    		//return response()->json($event,200);
    		if ($event->save()) {
    			return response()->json("success",200)->header('Content-Type', 'application/json');
    		}else{
    			return response()->json("error",500)->header('Content-Type', 'application/json');
    		}
    	}catch (\Exception $e) {
    		return response()->json("error",500)->header('Content-Type', 'application/json');
    	}
    }

    //Fazer check-in no evento ou retornar informando que já foi feito.
    public function eventCheckIn(Request $request) {

    	$all_request = $request->all();

    	$userEvent = UserEvent::where('user_id', $this->user->id)->where('event_id', $all_request['event_id'])->get();

    	if (count($userEvent) > 0) {
    		return response()->json("success",409)->header('Content-Type', 'application/json');
    	}

    	$newUserEvent = new userEvent;
    	try { 
    		$newUserEvent->fill($request->all());
    		$newUserEvent->user_id = $this->user->id;

    		if ($newUserEvent->save()) {
    			return response()->json("success",200)->header('Content-Type', 'application/json');
    		}else{
    			return response()->json("error",500)->header('Content-Type', 'application/json');
    		}
    	}catch (\Exception $e) {
    		return response()->json("error",500)->header('Content-Type', 'application/json');
    	}
    }

    //Alterar o status de pagamento do usuário no evento.
    public function changePaymentStatus(Request $request) {

    	$all_request = $request->all();

    	$userEvent = UserEvent::where('user_id', $all_request['user_id'])->where('event_id', $all_request['event_id'])->first();

    	try {

    		$event = Event::find($userEvent->event_id);

    		$group = Group::find($event->group_id);

    		if($group->user_id != $this->user->id) {
    			return response()->json("error",403)->header('Content-Type', 'application/json');
    		} 

    		if ($userEvent != null) {
	    		$userEvent->paid = $userEvent->paid == 0 ? 1 : 0;
	    		if ($userEvent->save()) {
	    			return response()->json("success",200)->header('Content-Type', 'application/json');
	    		}else{
	    			return response()->json("error",500)->header('Content-Type', 'application/json');
	    		}
	    	}
    	}catch (\Exception $e) {
    		return response()->json("error",500)->header('Content-Type', 'application/json');
    	}
    }
}
