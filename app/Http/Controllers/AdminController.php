<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect;
use Session;
use DB;

//Start session
session_start();

class AdminController extends Controller
{
    public function index(){

    	return view('admin_login_view');
    }

    public function show_dashboard(){
        
    	return view('admin.dashboard_view');
    }

    //Check admin login
    public function dashboard(Request $request_ad){

    	$username = $request_ad->username;
    	$password = md5($request_ad->password);

    	$result = DB::table('admin') -> where('username', $username)
    							     -> where('password', $password)
    							     -> first();
		if($result){
            Session::put('username', $result->username);
            Session::put('id', $result->id);
            return Redirect::to('/dashboard');
        }
        else {
            Session::put('message', 'Sai mật khẩu!!!');
            return Redirect::to('/admin');
        }
    }

    public function logout(){

        Session::put('username', null);
        Session::put('id', null);

        return Redirect::to('/admin');
    }
}
