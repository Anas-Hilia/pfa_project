<?php

namespace App\Http\Controllers;

use Auth;
use DB;
class FormationController extends Controller
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
            Auth::user()->currentUserRole = $this->AuthUserRole;

            //end---permissions

            return $next($request);
          });
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id_prof=Null)
    {
        

        if($id_prof==NULL)
        {
            $formations=DB::table('formations')
            ->where('deleted_at', NULL)
            ->where('c_accepted',1)
            ->where('u_accepted',1)
            ->get();
            
        }else
        {
            $formations=DB::table('formations')
            ->select('*','formations.name as name')
            ->where('created_by',$id_prof)
            ->where('c_accepted',1)
            ->where('u_accepted',1)
            ->where('formations.deleted_at', NULL)
            ->get();
        }
        // if($formations->isEmpty()){
        //     abort(404);
        // }
        return view('formationsmanagement.show-formations',compact('formations'));
    

    }
}
