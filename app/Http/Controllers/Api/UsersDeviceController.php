<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\UsersDevice;
use App\User;
use Carbon\Carbon;
use Auth;

class UsersDeviceController extends Controller
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
    public function storeUserDeviceData(Request $request) {
        $all_request = $request->all();

        $user_device = UsersDevice::where('deviceToken', $all_request['deviceToken'])->where('user_id', $this->user->id)->first();
        if($user_device == null) {
            $user_device = new UsersDevice;
        }
        $user_device->fill($all_request);
        $user_device->user_id = $this->user->id;

        $user_device->save();

        return response()->json(["message" => "sucesso"], 200)->header('Content-Type', 'application/json');
    }



}
