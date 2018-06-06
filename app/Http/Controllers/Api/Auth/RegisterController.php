<?php

namespace App\Http\Controllers\Api\Auth;

use App\User;
use Illuminate\Support\Facades\Route;
use Laravel\Passport\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PhpParser\Node\Stmt\Return_;

class RegisterController extends Controller
{

    private $client;

    public function __construct()
    {
        $this->client = Client::find(3);
    }

    public function register(Request $request){

        $this->validate($request,[
            'name' =>'required',
            'email' => 'required|email|unique:users,email',
            'password' =>'required|min:6|confirmed'
        ]);

        $user = User::create([
            'name' => request('name'),
            'email' => request('email'),
            'password' => bcrypt('password')
        ]);

        $params = [

            'grant_type' =>'password',
            'client_id' => $this->client->id,
            'client_secret' => $this->client->secret,
            'username' => request('email'),
            'password' => request('password'),
            'scope' => '*'
        ];

        $request->request->add($params);

        $proxy = Request::create('oauth/token', 'POST');
        return Route::dispatch($proxy);
        //dd($request->all());
    }
}
