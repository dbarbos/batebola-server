<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\User;
use App\Group;
use App\UserGroup;
use App\Event;
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

    public function getGroupById($id) {
        $group = Group::where('id', $id)
            ->with(['owner', 'users', 'events'])
            ->first();

        $group->users->map(function ($user) use ($id) {
            $user["approved"] = $user["pivot"]["approved"];
        });
  
        return response()
            ->json($group, 200)
            ->header('Content-Type', 'application/json');
    }

    public function getOwnerOfGroupById($id) {
        return response()
            ->json(User::find(Group::find($id)->user_id), 200)
            ->header('Content-Type', 'application/json');
    }

    public function getMembersOfGroupById($id) {

        $members = User::whereIn('id', UserGroup::where('group_id', $id)->pluck('user_id'))->get();

        $members->map(function ($user) use ($id) {
            $user["approved"] = UserGroup::where('user_id',$user["id"])
                ->where('group_id',$id)
                ->first()
                ->approved;
        });

        return response()
            ->json($members, 200)
            ->header('Content-Type', 'application/json');
    }

    public function getEventsOfGroupById($id) {

        $events = Event::where('group_id', $id)->with('users')->get();

        $events->map(function ($event) {
            $event['users']->map(function ($user) {
                $user["paid"] = $user['pivot']['paid'];
            });
        });

        return response()
            ->json($events, 200)
            ->header('Content-Type', 'application/json');
    }

    // retorna todos os grupos criados pelo usuário
    public function getMyGroups() {
    	return response()
            ->json($this->user->my_groups()->limit(30)->get(), 200)
            ->header('Content-Type', 'application/json');
    }

    // retorna todos os grupos que o usuário faz parte e indica se ele já foi aprovado ou não (approved : Boolean)
    public function getGroupsJoined() {
        $groups = $this->user
            ->groups_joined()
            ->with('owner')
            ->limit(30)
            ->get();
        //return response()->json($groups, 200);
        $user_id = $this->user->id;
        $groups->map(function ($item) use ($user_id) {
            $groupMember = Group::where('id', $item['id'])->with(['users' => 
                function ($q) use ($user_id) {
                    $q->where('user_id', $user_id)->get();
                }])->get();
          $item['approved'] = $groupMember->first()->users->first()->pivot->approved;
          return $item;
        });
        return response()
            ->json($groups, 200)
            ->header('Content-Type', 'application/json');
        //return response()->json($this->user->groups_joined()->with('owner')->get(), 200)->header('Content-Type', 'application/json');
    }

    // retorna todos os grupos excluindo os que o usuário já está incluido
    public function getAllGroupsExceptJoined($search = '') {

        $groupsJoined = array_keys(array_column($this->user->groups_joined()->get()->toArray(), null, "id"));

        return response()
            ->json(Group::where('name','like','%' . $search . '%')
            ->with('owner')
            ->whereNotIn('id',$groupsJoined)
            ->get(), 200)
            ->header('Content-Type', 'application/json');
    }

    // retorna todos os grupos
    public function getAllGroups($search = '') {
    	return response()
            ->json(Group::where('name','like','%' . $search . '%')->with('owner')->get(), 200)
            ->header('Content-Type', 'application/json');
    }

    // cria um novo grupo no banco
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

    // cria um novo grupo no banco
    public function joinGroup(Request $request) {
        $user_group = new UserGroup;
        try { 
            $user_group->fill($request->all());
            $user_group->user_id = $this->user->id;
            if ($user_group->save()) {
                return response()->json("success",200)->header('Content-Type', 'application/json');
            }else{
                return response()->json("error",500)->header('Content-Type', 'application/json');
            }
        }catch (\Exception $e) {
            return response()->json("error",500)->header('Content-Type', 'application/json');
        }
    }
}
