<?php

namespace App\Http\Controllers\AcceptCU;
use App\Http\Controllers\Controller;
use Auth;
use DB;
use App\Models\Formation ;
use App\Models\Branches_Formation ;


class BranchesWaitAcceptController extends Controller
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

            if($this->AuthUserRole != 1){
                abort(403,trans('Access Denied'));
            }
            //end---permissions

            return $next($request);
          });
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function created (){
        $brancheFs=DB::table('branches_formations')
                ->select('id_BrF','id_formation','branches_formations.name as brf_name','email as email_cord','formations.name as form_name','branches_formations.description','branches_formations.created_at','branches_formations.updated_at')
                ->join('formations', 'formations.id', '=', 'id_formation')
                ->join('users', 'users.id', '=', 'coordinateur')
                ->where('branches_formations.deleted_at',NULL)
                ->where('branches_formations.c_accepted',0)
                ->get();
        
            return view('waitacceptmanagement.show-created-branches',compact('brancheFs'));

    }
    public function createdAccept ($id){
        $branche=Branches_Formation::where('id_BrF',$id)->first();
        $branche->c_accepted = 1;
        $branche->save();
        return redirect('/branches/created');

    }
    public function createdRefuse ($id){
        $branche=Branches_Formation::where('id_BrF',$id)->first();
        $branche->delete();

        return redirect('/branches/created');
    
    }
    public function updated (){
        $brancheFs=DB::table('branches_formations')
                ->select('id_BrF','id_formation','branches_formations.name as brf_name','email as email_cord','formations.name as form_name','branches_formations.description','branches_formations.created_at','branches_formations.updated_at')
                ->join('formations', 'formations.id', '=', 'id_formation')
                ->join('users', 'users.id', '=', 'coordinateur')
                ->where('branches_formations.deleted_at',NULL)
                ->where('branches_formations.u_accepted',0)
                ->get();
        return view('waitacceptmanagement.show-updated-branches',compact('brancheFs'));

    }
    public function updatedAccept ($id){
        $branche=Branches_Formation::where('id_BrF',$id)->first();
        $branche->u_accepted = 1;
        $branche->save();

        return redirect('/branches/updated');
    }
    public function updatedRefuse ($id){
        $branche=Branches_Formation::where('id_BrF',$id)->first();
        dd('$branche');
        $branche->delete();
        return redirect('/branches/updated');

    }
}
