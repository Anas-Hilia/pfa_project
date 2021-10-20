<?php

namespace App\Http\Controllers;

use App\Models\Formation;
use Illuminate\Http\Request;
use jeremykenedy\LaravelRoles\Models\Role;
use DB;
use Auth;

class SoftDeletesFormationsController extends Controller
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
     * Get Soft Deleted formation.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public static function getDeletedformation($id)
    {
        
        $formation = Formation::onlyTrashed()->where('id', $id)->get();
        if (count($formation) !== 1) {
            return redirect('/formations/deleted/')->with('error', trans('Formation Not Found'));
        }

        return $formation[0];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $formations = Formation::onlyTrashed()
        ->select('formations.id','formations.name','formations.type','formations.nbr_max','users.id as id_uwd','users.first_name as fname_uwd','users.last_name as lname_uwd')
            ->join('users','users.id','formations.deleted_by')
            ->get();
        
        return View('formationsmanagement.show-deleted-formations', compact('formations'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $formation = self::getDeletedformation($id);
        
        $deleted_by = Formation::onlyTrashed()
        ->where('formations.id',$id)
        ->select('users.id as id','users.first_name as fname','users.last_name as lname')
        ->join('users','users.id','formations.deleted_by')
        ->get()->first();
        $created_by = Formation::onlyTrashed()
                ->find($id)
                ->select('users.id as id','users.first_name as fname','users.last_name as lname')
                ->join('users','users.id','formations.created_by')
                ->get()->first();
        $updated_by = Formation::onlyTrashed()
            ->find($id)
            ->select('users.id as id','users.first_name as fname','users.last_name as lname')
            ->join('users','users.id','formations.updated_by')
            ->get()->first();
            

        return view('formationsmanagement.show-deleted-formation')->with([
            'formation'  => $formation,
            'deleted_by' => $deleted_by,
            'created_by' => $created_by,
            'updated_by' => $updated_by,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $formation = self::getDeletedformation($id);
        $formation->restore();

        return redirect('/formations/')->with('success', trans('Formation was restored successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $formation = self::getDeletedformation($id);
        $formation->forceDelete();

        return redirect('/formations/deleted/')->with('success', trans('Formation was Destroyed successfully'));
    }
}
