<?php

namespace App\Http\Controllers;

use App\Models\Branches_Formation;
use Illuminate\Http\Request;
use jeremykenedy\LaravelRoles\Models\Role;
use DB;
use Auth;

class SoftDeletesBrancheFsController extends Controller
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
     * Get Soft Deleted brancheF.
     *
     * @param int $id_BrF
     *
     * @return \Illuminate\Http\Response
     */
    public static function getDeletedbrancheF($id_BrF)
    {
        $brancheF = Branches_Formation::onlyTrashed()->where('id_BrF', $id_BrF)->get();
        if (count($brancheF) !== 1) {
            return redirect('/BranchesFs/deleted/')->with('error', trans('Branche of Formation Not Found'));
        }

        return $brancheF[0];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $brancheFs=Branches_Formation::onlyTrashed()
            ->select('id_BrF','id_formation','branches_formations.name as brf_name','email as email_cord','formations.name as form_name','branches_formations.description','branches_formations.created_at','branches_formations.updated_at','branches_formations.deleted_at')
            ->join('formations', 'formations.id', '=', 'id_formation')
            ->join('users', 'users.id', '=', 'coordinateur')
            ->get();

        return View('branchesformationsmanagement.show-deleted-branchesF', compact('brancheFs'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id_BrF
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $brancheF = Branches_Formation::onlyTrashed()
            ->select('id_BrF','branches_formations.name as brf_name','branches_formations.description',
            'branches_formations.created_at','branches_formations.updated_at','branches_formations.deleted_at',
            //users
            'coordinateur','first_name as Coord_fname','last_name as Coord_lname',
            //formation
            'id_formation','formations.name as form_name')
            ->join('formations', 'formations.id', '=', 'id_formation')
            ->join('users', 'users.id', '=', 'coordinateur')
            ->where('id_BrF',$id)
            ->get()->first();
            if($brancheF==NULL){
                abort(404);
            }

        return view('branchesformationsmanagement.show-deleted-brancheF')->with('brancheF',$brancheF);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id_BrF
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id_BrF)
    {
        $brancheF = self::getDeletedbrancheF($id_BrF);
        $brancheF->restore();

        return redirect('formations/'.$brancheF->id_formation.'/branches')->with('success', trans('Branche of Formation was restored successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id_BrF
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_BrF)
    {
        $brancheF = self::getDeletedbrancheF($id_BrF);
        $brancheF->forceDelete();

        return redirect('/BranchesFs/deleted/')->with('success', trans('Branche of Formation was destroyed successfully'));
    }
}
