<?php

namespace App\Http\Controllers;
use App\Models\User;


use Auth;
use DB;
class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            //begin---permissions
            $this->AuthUserRole=DB::select('select role_id from role_user where user_id =' . Auth::user()->id);
            $this->AuthUserRole=$this->AuthUserRole[0]->role_id;
            //end---permissions
            Auth::user()->currentUserRole = $this->AuthUserRole;
            
            return $next($request);
          });
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        return view('pages.user.home')->with([
            'currentRole' => $this->AuthUserRole,
        ]);
    }
}
