<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteUserAccount;
use App\Http\Requests\UpdateUserPasswordRequest;
use App\Http\Requests\UpdateUserProfile;
use App\Models\Profile;
use App\Models\Theme;
use App\Models\User;
use App\Models\Formation;

use App\Notifications\SendGoodbyeEmail;
use App\Traits\CaptureIpTrait;
use File;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Image;
use jeremykenedy\Uuid\Uuid;
use Validator;
use View;
use App\Models\Branches_Formation ;
use DB;
use Auth;


class BranchesFCrudController extends Controller
{
    protected $idMultiKey = '618423'; //int
    protected $seperationKey = '****';

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
     * Fetch user
     * (You can extract this to repository method).
     *
     * @param $id_brancheF
     *
     * @return mixed
     */
    public function index(){
        abort(404);
    }
    /**
     * Display the specified resource.
     *
     * @param string $id_brancheF
     *
     * @return Response
     */
    public function show($id)
    {
        try {
            
            // show the view and pass the shark to it

            if($this->AuthUserRole==1){
                $brancheF = Branches_Formation::select('id_BrF','branches_formations.name as brf_name','branches_formations.description',
                    'branches_formations.created_at','branches_formations.updated_at',
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

            }else if($this->AuthUserRole==2){
                $brancheF = Branches_Formation::select('id_BrF','branches_formations.name as brf_name','branches_formations.description',
                            'branches_formations.created_at','branches_formations.updated_at',
                            //users
                            'coordinateur','first_name as Coord_fname','last_name as Coord_lname',
                            //formation
                            'id_formation','formations.name as form_name')
                            ->join('formations', 'formations.id', '=', 'id_formation')
                            ->join('users', 'users.id', '=', 'coordinateur')
                            ->where('id_BrF',$id)
                            ->where('branches_formations.coordinateur',Auth::user()->id)
                            ->get()->first();
                
                if($brancheF==NULL){

                    $brancheF = Branches_Formation::select('id_BrF','branches_formations.name as brf_name','branches_formations.description',
                            'branches_formations.created_at','branches_formations.updated_at',
                            //users
                            'coordinateur','first_name as Coord_fname','last_name as Coord_lname',
                            //formation
                            'id_formation','formations.name as form_name')
                            ->join('formations', 'formations.id', '=', 'id_formation')
                            ->join('users', 'users.id', '=', 'coordinateur')
                            ->where('id_BrF',$id)
                            ->where('branches_formations.c_accepted',1)
                            ->where('branches_formations.u_accepted',1)
                            ->get()->first();
                }
            }
            else{
                $brancheF = Branches_Formation::select('id_BrF','branches_formations.name as brf_name','branches_formations.description',
                        'branches_formations.created_at','branches_formations.updated_at',
                        //users
                        'coordinateur','first_name as Coord_fname','last_name as Coord_lname',
                        //formation
                        'id_formation','formations.name as form_name')
                        ->join('formations', 'formations.id', '=', 'id_formation')
                        ->join('users', 'users.id', '=', 'coordinateur')
                        ->where('id_BrF',$id)
                        ->where('branches_formations.c_accepted',1)
                        ->where('branches_formations.u_accepted',1)
                        ->get()->first();

            }
            if($brancheF==NULL){
                abort(404);
            }
            

        } catch (ModelNotFoundException $exception) {
            abort(404);
        }
        return view('branchesformationsmanagement.show-brancheF')->with('brancheF',$brancheF);
    }

    //create
    public function create(){

        //begin---permissions
        
        if($this->AuthUserRole==3 ){
            abort(403,trans('Access Denied'));

        }
        //end---permissions

        else if($this->AuthUserRole==2 ){

            $formations=DB::table('formations')
            ->where('created_by',Auth::User()->id)
            ->where('formations.deleted_at', NULL)
            ->where('formations.c_accepted',1)
            ->where('formations.u_accepted',1)
            ->get();
            
            $coordinateurs = User::select('users.id','first_name as fname','last_name as lname')
                    ->where('users.id',Auth::User()->id)
                    ->get();

        }
        else{
            $formations = Formation::select('*')
            ->where('formations.deleted_at', NULL)
            ->where('formations.c_accepted',1)
            ->where('formations.u_accepted',1)
            ->get();
            
            $coordinateurs = User::select('users.id','first_name as fname','last_name as lname')
                    ->join('role_user','role_user.user_id','users.id')
                    ->where('role_id','=',2)
                    ->where('users.deleted_at', NULL)
                    ->get();
        }
        return view('branchesformationsmanagement.create-brancheF')->with([
            'formations' => $formations,
            'coordinateurs' => $coordinateurs,
        ]);
    } 

    //store
    public function store(Request $request ){
        //begin---permissions
       
        if($this->AuthUserRole==3 ){
            abort(403,trans('Access Denied'));

        }
        $c_accepted=0;
        if($this->AuthUserRole==1 ){
            $c_accepted=1;
        }
        //end---permissions
        try {
            Branches_Formation::create([
                'name'              => $request->name,
                'description'       => $request->description,
                'coordinateur'      => $request->coordinateur,
                'id_formation'      => $request->id_formation,
                'c_accepted'        => $c_accepted,

            ]);

        } catch (ModelNotFoundException $exception) {
            abort(404);
        }   

        Session::flash('msg' , trans('The branche was created successfully')); 
        Session::flash('alert-class', 'alert-success');

        return redirect('formations/'.$request->id_formation.'/branches');

        


    }

    /**
     * /profiles/username/edit.
     *
     * @param $id_brancheF
     *
     * @return mixed
     */

    public function edit($id){
        //begin---permissions
        
        if($this->AuthUserRole==3 ){
            abort(403,trans('Access Denied'));

        }
        
        //end---permissions
        try {
            // show the view and pass the shark to it
            if($this->AuthUserRole==1)
            {
                $brancheF = Branches_Formation::select('id_BrF','branches_formations.name','branches_formations.description',
                'coordinateur','first_name as fname','last_name as lname',
                'id_formation','formations.name as form_name')
                ->join('formations', 'formations.id', '=', 'id_formation')
                ->join('users', 'users.id', '=', 'coordinateur')
                ->where('id_BrF',$id)
                ->get()->first();

                if($brancheF==NULL){
                    abort(404);
                }
            
            }else
            {
                $brancheF = Branches_Formation::select('id_BrF','branches_formations.name','branches_formations.description',
                'coordinateur','first_name as fname','last_name as lname',
                'id_formation','formations.name as form_name')
                ->join('formations', 'formations.id', '=', 'id_formation')
                ->join('users', 'users.id', '=', 'coordinateur')
                ->where('id_BrF',$id)
                ->where('coordinateur', Auth::User()->id)
                ->get()->first();

                if($brancheF==NULL){
                    abort(403,trans('Access Denied'));
                }
            }

           //send formations infos and coordinateurs info to the view

            if($this->AuthUserRole==1){
           
                $formations = Formation::select('*')
                ->where('formations.id','<>',$brancheF->id_formation)
                ->where('formations.deleted_at', NULL)
                ->get();

                $coordinateurs = User::select('users.id','first_name as fname','last_name as lname')
                    ->join('role_user','role_user.user_id','users.id')
                    ->where('role_id','=',2)
                    ->where('users.id','<>',$brancheF->coordinateur)
                    ->get();
            }
            else if($this->AuthUserRole==2 ){

                $formations=DB::table('formations')
                ->select('*','formations.name as name')
                ->where('formations.id','<>',$brancheF->id_formation)
                ->where('created_by',Auth::User()->id)
                ->where('formations.deleted_at', NULL)
                ->where('formations.c_accepted',1)
                ->where('formations.u_accepted',1)
                ->get();
                
                $coordinateurs = [];
    
            }

        } catch (ModelNotFoundException $exception) {
            abort(404);
        }       
        return view('branchesformationsmanagement.edit-brancheF')->with([
            'brancheF'      => $brancheF,
            'formations'    => $formations,
            'coordinateurs' => $coordinateurs

        ]);
    }

    //update
    public function update(Request $request , $id)
    { 
        //begin---permissions
        
        if($this->AuthUserRole==3 ){
            abort(403,trans('Access Denied'));

        }
        //end---permissions

        try {
            // show the view and pass the shark to it
            $brancheF = Branches_Formation::find($id);
            
            if($brancheF==NULL){
                abort(404);
            }
            if($this->AuthUserRole==2 && $brancheF->coordinateur != Auth::User()->id){
                abort(403,trans('Access Denied'));
    
            }
            $u_accepted=0;
            if($this->AuthUserRole==1 || $brancheF->c_accepted==0){
                $u_accepted=1;
            }

            $brancheF->update(
                [
                    'name'              => $request->name,
                    'description'       => $request->description,
                    'coordinateur'      => $request->coordinateur,
                    'id_formation'      => $request->id_formation,    
                    'u_accepted'        =>$u_accepted,    
                    
                ]);

            $brancheF2 = Branches_Formation::find($id);


        
        } catch (ModelNotFoundException $exception) {
            abort(404);
        }
        
        if($brancheF != $brancheF2){

            /*
            if(!$condition){
                Session::flash('msg', 'Error msg !');
                Session::flash('alert-class', 'alert-danger');
                return redirect()->back();
            }
            */
            Session::flash('msg', 'the brancheF was updated successfully  !');
            Session::flash('alert-class', 'alert-success');

            return redirect('formations/'.$request->id_formation.'/branches');


        }
        return view('branchesformationsmanagement.edit-brancheF')->with(['brancheF' => $brancheF]);
    }

    // public function delete($id){

    //     try{
    //         $brancheF=Branches_Formation::find($id)->delete();
    //         if($brancheF==NULL){
    //             abort(404);
    //         }
            
    //     } catch (ModelNotFoundException $exception) {
    //         abort(404);
    //     }

    //     Session::flash('msg', 'the brancheF was deleted successfully  !');
    //     Session::flash('alert-class', 'alert-success');

    //     return redirect('formations/'.$brancheF->id_formation.'/branches');

    // }

    public function destroy($id)
    {
        //begin---permissions
        
        if($this->AuthUserRole==3 ){
            abort(403,trans('Access Denied'));

        }
        
        //end---permissions
        
        try {
            
            $brancheF = Branches_Formation::find($id);
            
            if($brancheF==NULL){
                abort(404);
            }
            if($this->AuthUserRole==2 && $brancheF->coordinateur != Auth::User()->id){
                abort(403,trans('Access Denied'));
    
            }
            
            $brancheF->save();
            $brancheF->delete();

            return redirect('formations/'.$brancheF->id_formation.'/branches')->with('success', trans('Branche of Formation Deleted successfully'));

        
        } catch (ModelNotFoundException $exception) {
            return back()->with('error', trans('Deleting Branche of formation failed'));
        }
     
    }
   
}