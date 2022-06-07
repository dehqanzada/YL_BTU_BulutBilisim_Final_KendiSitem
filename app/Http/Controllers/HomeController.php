<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;

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
        if (Auth::user()->admin == "Y") {
            return view('home');    
        }else{
            return view('user');
        }
    }

    public function registerIndex()
    {
        $users = User::all();
        if (Auth::user()->admin == "Y") {
            return view('is_admin', compact('users', $users));    
        }else{
            return view('user');
        }
    }


    public function registerIndexUpdate(Request $request, $userId)
    {
        if(Auth::user()->admin != 'Y'){
            return back();
        }

        $data = User::where('id', $userId)->update([
            'admin' => $request->statu,
        ]);        

        if ($data){
            return redirect(route('register.index'));
        }
        return back();
    }
  
  
  
 
  
  
  
  
  
  
}
