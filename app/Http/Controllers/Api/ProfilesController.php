<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProfilesController extends Controller
{
    public function index(){
        $profiles = Auth::user()->profiles()->get();

        //dd($profiles);

        return response()->json(['data' =>$profiles], 200, [], JSON_NUMERIC_CHECK);
    }
}
