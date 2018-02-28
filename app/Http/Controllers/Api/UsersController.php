<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\User;
use Carbon\Carbon;
use Auth;

class UsersController extends Controller
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

    /**
     *
     * @return \Illuminate\Http\Response
     */
    public function getProjectOwnerDataAndUserApproval(Request $request) {
        $all_request = $request->all();

        $project = Project::find($all_request["project_id"]);

        $owner = User::find($project->created_by);

        $project_users = ProjectsUsers::where('user_id', $this->user->id)->where('project_id', $project->id)->first();


        return response()->json(["message" => $owner, 'project_users' => $project_users], 200)->header('Content-Type', 'application/json');
    }



}
