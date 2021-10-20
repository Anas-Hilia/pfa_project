<?php

namespace App\Http\Controllers\AcceptCU;
use App\Http\Controllers\Controller;
use Auth;
use DB;
use App\Models\Formation ;

class FormationsWaitAcceptController extends Controller
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
        $formations=DB::table('formations')
            ->where('deleted_at', NULL)
            ->where('c_accepted',0)
            ->get();
            return view('waitacceptmanagement.show-created-formations',compact('formations'));

    }
    public function createdAccept ($id){
        $formation=Formation::where('id',$id)->first();
        $formation->c_accepted = 1;
        $formation->save();
        return redirect('/formations/created');

    }
    public function createdRefuse ($id){
        $formation=Formation::where('id',$id)->first();
        $formation->delete();

        return redirect('/formations/created');
    
    }
    public function updated (){
        $formations=DB::table('formations')
        ->where('deleted_at', NULL)
        ->where('u_accepted',0)
        ->get();
        return view('waitacceptmanagement.show-updated-formations',compact('formations'));

    }
    public function updatedAccept ($id){
        $formation=Formation::where('id',$id)->first();
        $formation->u_accepted = 1;
        $formation->save();

        return redirect('/formations/updated');
    }
    public function updatedRefuse ($id){
        $formation=Formation::where('id',$id)->first();
        $formation->delete();
        return redirect('/formations/updated');

    }
}
