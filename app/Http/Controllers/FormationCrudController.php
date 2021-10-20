<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteUserAccount;
use App\Http\Requests\UpdateUserPasswordRequest;
use App\Http\Requests\UpdateUserProfile;
use App\Models\Profile;
use App\Models\Theme;
use App\Models\User;
use App\Notifications\SendGoodbyeEmail;
use App\Traits\CaptureIpTrait;
use File;
use App\Models\Branches_Formation ;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Image;
use jeremykenedy\Uuid\Uuid;
use Validator;
use View;
use App\Models\Formation ;
use DB;
use Auth;



class FormationCrudController extends Controller
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
     * @param $id
     *
     * @return mixed
     */
    
    /**
     * Display the specified resource.
     *
     * @param string $id
     *
     * @return Response
     */
    public function show($id)
    {
        

        try {
            // show the view and pass the shark to it
            if($this->AuthUserRole==1){
                $formation = Formation::find($id);
                if($formation==NULL){
                    abort(404);

                }

            }else if($this->AuthUserRole==2)
            {
                
                $formation = Formation::where('id',$id)
                    ->where('created_by',Auth::User()->id)
                    ->first();
                
                if($formation==NULL){
                    $formation = Formation::where('id',$id)
                    ->where('c_accepted',1)
                    ->where('u_accepted',1)->first();
                }

                
            }
            else{
                
                $formation = Formation::where('id',$id)
                    ->where('c_accepted',1)
                    ->where('u_accepted',1)->first();
            }

            if($formation==NULL){
                abort(403,trans('Access Denied'));

            }

            $created_by = Formation::select('users.id as id_user','users.first_name as fname','users.last_name as lname')
                ->join('users','users.id','formations.created_by')
                ->where('formations.id',$id)
                ->get()->first();
            $updated_by = Formation::select('users.id as id_user','users.first_name as fname','users.last_name as lname')
                ->join('users','users.id','formations.updated_by')
                ->where('formations.id',$id)
                ->get()->first();
            
            
            
        
        } catch (ModelNotFoundException $exception) {
            abort(404);
        }

        return view('formationsmanagement.show-formation')->with([
            'formation' => $formation,
            'created_by' => $created_by,
            'updated_by' => $updated_by,

        ]);
    }

    //create
    public function create(){

        //begin---permissions
        
        if($this->AuthUserRole==3 ){
            abort(403,trans('Access Denied'));

        }
        //end---permissions

        return view('formationsmanagement.create-formation');
    } 

    //store
    public function store(Request $request ){

        //begin---permissions
        
        if($this->AuthUserRole==3 ){
            abort(403,trans('Access Denied'));

        }
        //end---permissions
        $c_accepted = 0;
        if($this->AuthUserRole==1 ){
            $c_accepted=1;
        }
        try {
            Formation::create([
                'name'          => $request->name,
                'description'   => $request->description,
                'type'          => $request->type,
                'created_by'    => Auth::User()->id,
                'nbr_max'       => $request->nbr_max,
                'c_accepted'     => $c_accepted,
            ]);

        } catch (ModelNotFoundException $exception) {
            abort(404);
        }   

        Session::flash('msg' , 'The formation was created successfully'); 
        Session::flash('alert-class', 'alert-success');

        return redirect('formations');


    }

    /**
     * /profiles/username/edit.
     *
     * @param $id
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
            if($this->AuthUserRole==1){
                $formation = Formation::find($id);
                
                if($formation==NULL){
                    abort(404);
                }
            
            }else 
            {
                //begin---permissions

                $formation = Formation::where('id',$id)
                    ->where('created_by',Auth::User()->id)
                    ->first();

                if($formation==NULL){
                    abort(403,trans('Access Denied'));
                }

                //end---permissions

            }        
            

        } catch (ModelNotFoundException $exception) {
            abort(404);
        }       
        return view('formationsmanagement.edit-formation')->with(['formation' => $formation]);
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
            if($this->AuthUserRole==1){
                
                $formation = Formation::find($id);
                
                if($formation==NULL){
                    abort(404);
                }
            
            }else 
            {
                //begin---permissions

                $formation = Formation::where('id',$id)
                    ->where('created_by',Auth::User()->id)
                    ->first();

                if($formation==NULL){
                    abort(403,trans('Access Denied'));
                }

                //end---permissions

            }

            $u_accepted=0;
            if($this->AuthUserRole==1 || $formation->c_accepted==0){
                $u_accepted=1;
            }
            
            $formation->update(
                [
                    'name'          => $request->name,
                    'description'   => $request->description,
                    'type'          => $request->type,
                    'nbr_max'       => $request->nbr_max,
                    'updated_by'    => Auth::User()->id,
                    'u_accepted'     => $u_accepted,

                ]

            );

            $formation2 = Formation::find($id);

        
        } catch (ModelNotFoundException $exception) {
            abort(404);
        }
        
        if($formation != $formation2){

            /*
            if(!$condition){
                Session::flash('msg', 'Error msg !');
                Session::flash('alert-class', 'alert-danger');
                return redirect()->back();
            }
            */
            Session::flash('msg', 'the formation was updated successfully  !');
            Session::flash('alert-class', 'alert-success');

            return redirect('formations');

        }
        return view('formationsmanagement.edit-formation')->with(['formation' => $formation]);
    }

    // public function delete($id){

    //     try{
    //         Formation::find($id)->delete();
            
    //     } catch (ModelNotFoundException $exception) {
    //         abort(404);
    //     }

    //     Session::flash('msg', 'the formation was deleted successfully  !');
    //     Session::flash('alert-class', 'alert-success');

    //     return redirect()->route('formations', [
    //         'formations' => Formation::all(),
    //     ]);
    // }
    public function destroy($id)
    {
        //begin---permissions
        
        if($this->AuthUserRole==3 ){
            abort(403,trans('Access Denied'));

        }
        //end---permissions
        
        try {
            
            if($this->AuthUserRole==1){
                $formation = Formation::find($id);
                
                if($formation==NULL){
                    abort(404);
                }else {
                    $formation->delete();
                }
            
            }else 
            {
                //begin---permissions

                $formation = Formation::where('id',$id)
                    ->where('created_by',Auth::User()->id)
                    ->first();

                if($formation==NULL){
                    abort(403,trans('Access Denied'));
                }

                //end---permissions

            }
           
            $formation->deleted_by = Auth::User()->id;
            $formation->save();
            $formation->delete();

            return redirect('formations')->with('success', trans('Formation was Deleted successfully'));

        
        } catch (ModelNotFoundException $exception) {
            return back()->with('error', trans('Deleting formation failed'));
        }
           

        

    }
    
}