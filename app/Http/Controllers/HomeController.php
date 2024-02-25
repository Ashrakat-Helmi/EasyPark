<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  App\Models\User;
use App\Models\garages;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //$users = User::all();
        /* return view('home', [
            'users' => $users,
            ])->with('success','You have successfully
            added an user');*/
            $users = User::all();
                $data['garage']= garages::all();
                return view('home')->with('data',$data)->with('users',$users);
                

    }
 
}
