<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\User;
use App\Group;
use Auth;

class GroupController extends Controller
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

    public function getMyGroups() {
    	return response()->json($this->user->my_groups, 200)->header('Content-Type', 'application/json');
    }

    public function getGroupsJoined() {
        $groups = $this->user->groups_joined()->with('owner')->get();
        $user_id = $this->user->id;
        $groups->map(function ($item) use ($user_id) {
            $groupMember = Group::where('id', $item['id'])->with(['users' => 
                function ($q) use ($user_id) {
                    $q->where('user_id', $user_id)->get();
                }])->get();
          $item['approved'] = $groupMember->first()->users->first()->pivot->approved;
          return $item;
        });
        return response()->json($groups, 200)->header('Content-Type', 'application/json');
        //return response()->json($this->user->groups_joined()->with('owner')->get(), 200)->header('Content-Type', 'application/json');
    }

    public function getAllGroupsExceptJoined($search = '') {

        $groupsJoined = $this->user->groups_joined->pluck('id');

        return response()
            ->json(Group::where('name','like','%' . $search . '%')
            ->with('owner')
            ->whereNotIn('id',$groupsJoined)
            ->get(), 200)
            ->header('Content-Type', 'application/json');
    }

    public function getAllGroups($search = '') {
    	return response()->json(Group::where('name','like','%' . $search . '%')->with('owner')->get(), 200)->header('Content-Type', 'application/json');
    }

    public function createGroup(Request $request) {
    	$group = new Group;
    	try { 
    		$group->fill($request->all());
    		$group->user_id = $this->user->id;
    		if ($group->save()) {
    			return response()->json("success",200)->header('Content-Type', 'application/json');
    		}else{
    			return response()->json("error",500)->header('Content-Type', 'application/json');
    		}
    	}catch (\Exception $e) {
    		return response()->json("error",500)->header('Content-Type', 'application/json');
    	}
    }
}
