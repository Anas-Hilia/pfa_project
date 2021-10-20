<?php

namespace App\Http\Controllers;

use Auth;
use DB;
class BrancheFController extends Controller
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
    public function index($id_1 , $id_2=null)
    {
        if($id_2==Null)
        {
            $brancheFs=DB::table('branches_formations')
                ->select('id_BrF','coordinateur','id_formation','branches_formations.name as brf_name','email as email_cord','formations.name as form_name','branches_formations.description','branches_formations.created_at','branches_formations.updated_at')
                ->join('formations', 'formations.id', '=', 'id_formation')
                ->join('users', 'users.id', '=', 'coordinateur')
                ->where('branches_formations.deleted_at',NULL)
                ->where('id_formation',$id_1)
                ->get();
        }
        else{
            $brancheFs=DB::table('branches_formations')
                ->select('id_BrF','coordinateur','id_formation','branches_formations.name as brf_name','email as email_cord','formations.name as form_name','branches_formations.description','branches_formations.created_at','branches_formations.updated_at')
                ->join('formations', 'formations.id', '=', 'id_formation')
                ->join('users', 'users.id', '=', 'coordinateur')
                ->where('coordinateur', $id_2)
                ->where('branches_formations.deleted_at',NULL)
                ->where('id_formation',$id_1)
                ->get();
        }
        

            
        return view('branchesformationsmanagement.show-BranchesF',compact('brancheFs'));
    

    }
}
