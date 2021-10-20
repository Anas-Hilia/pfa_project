<?php

namespace App\Http\Controllers;
use DB;
use Auth;
use App\Models\User;
use Illuminate\Http\Request;
use jeremykenedy\LaravelRoles\Models\Role;

class SoftDeletesController extends Controller
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
     * Get Soft Deleted User.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public static function getDeletedUser($id)
    {
        $user = User::onlyTrashed()->where('id', $id)->get();
        if (count($user) !== 1) {
            return redirect('/users/deleted/')->with('error', trans('usersmanagement.errorUserNotFound'));
        }

        return $user[0];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        

        $users = User::onlyTrashed()->get();
        $roles = Role::all();

        return View('usersmanagement.show-deleted-users', compact('users', 'roles'));
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
        $userRole = DB::select('select role_id from role_user where user_id =' . $id);
        $currentRole=$userRole[0]->role_id;
        $formation=NULL;

        if($currentRole=="3"){
        
            $user = User::onlyTrashed()
                    ->select('*','users.created_at AS created_at','users.updated_at AS updated_at','users.deleted_at AS deleted_at')
                    ->join('students', 'users.id', '=', 'students.id_user')
                    ->join('bac_student', 'students.id_S', '=', 'bac_student.id_student')
                    ->join('diploma_student', 'students.id_S', '=', 'diploma_student.id_student')
                    ->join('experience_student', 'students.id_S', '=', 'experience_student.id_student')
                    ->where('users.id','=',$id)->first();
            
            $formation = User::select('formations.name as formation_name','formations.type as formation_type','branches_formations.name as formation_branche' )
                    ->join('students', 'users.id', '=', 'students.id_user')
                    ->join('branches_formations', 'branches_formations.id_BrF', '=', 'students.id_branche_formation')
                    ->join('formations', 'formations.id', '=', 'branches_formations.id_formation')
                    ->where('users.id','=',$id)->onlyTrashed()->first();
        }
        elseif($currentRole=="2"){
            $user = User::onlyTrashed()
            ->select('email','first_name','last_name','tel','establishment_prof',
            'users.created_at','users.updated_at','users.deleted_at',
            'id_formation','branches_formations.name as brfName')
                    ->join('branches_formations', 'coordinateur', '=', 'users.id')
                    ->where('users.id','=',$id)->first();
        }

        return view('usersmanagement.show-deleted-user')->with([
            'user' => $user,
            'currentRole' => $currentRole,
            'formation' => $formation,
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
        $user = self::getDeletedUser($id);
        $user->restore();

        return redirect('/users/')->with('success', trans('usersmanagement.successRestore'));
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
        $user = self::getDeletedUser($id);
        $user->forceDelete();

        return redirect('/users/deleted/')->with('success', trans('usersmanagement.successDestroy'));
    }
}
