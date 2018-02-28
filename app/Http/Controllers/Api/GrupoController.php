<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\User;
use App\Grupo;
use Auth;

class GrupoController extends Controller
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

    public function getMeusGrupos() {
    	return response()->json($this->user->grupos, 200)->header('Content-Type', 'application/json');
    }

    public function getTodosOsGrupos($search = '') {
    	return response()->json(Grupo::where('nome','like','%' . $search . '%')->get(), 200)->header('Content-Type', 'application/json');
    }

    public function createGrupo(Request $request) {
    	$grupo = new Grupo;
    	try { 
    		$grupo->fill($request->all()); 
    		$grupo->user_id = $this->user->id;
    		if ($grupo->save()) {
    			return response()->json("success",200)->header('Content-Type', 'application/json');
    		}else{
    			return response()->json("error",500)->header('Content-Type', 'application/json');
    		}
    	}catch (\Exception $e) {
    		return response()->json("error",500)->header('Content-Type', 'application/json');
    	}
    }
}
