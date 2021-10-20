<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Excel;
use App\Exports\UsersExport;
use App\Exports\UsersShortExport;
use App\Imports\UsersImport;

use App\Models\Student;
use App\Models\Payment;
use App\Models\Profile;
use App\Models\User;
use App\Models\Formation;
use App\Models\Branches_Formation;
use App\Models\Bac_Student;
use App\Models\Diploma_Student;
use App\Models\Experience_Student;
use App\Traits\CaptureIpTrait;
use Auth;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use jeremykenedy\LaravelRoles\Models\Role;
use Validator;
use jeremykenedy\Uuid\Uuid;
use View;
use File;
use DB;

class UsersManagementController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //begin---permissions
        
        if($this->AuthUserRole!=1 ){
            abort(403,trans('Access Denied'));

        }
        //end---permissions

        $paginationEnabled = config('usersmanagement.enablePagination');
        if ($paginationEnabled) {
            $users=User::select('users.id','email','first_name','last_name','tel','role_id','users.created_at','users.updated_at')
            ->join('role_user', 'users.id' , 'role_user.user_id')
            ->where('role_user.role_id','<>',1)
            ->paginate(10);
        } else {

            $users=User::select('users.id','email','first_name','last_name','tel','role_id','users.created_at','users.updated_at')
            ->join('role_user', 'users.id' , 'role_user.user_id')
            ->where('role_user.role_id','<>',1)
            ->get();
        }
        $roles = Role::all();

        // if($users->isEmpty()){
        //     abort(404);
        // }
        return View('usersmanagement.show-users', compact('users', 'roles'));
    }


    public function index_profs()
    {
        //begin---permissions
        
        if($this->AuthUserRole!=1 ){
            abort(403,trans('Access Denied'));

        }
        //end---permissions

        $paginationEnabled = config('usersmanagement.enablePagination');
        if ($paginationEnabled) {
            $users=User::select('users.id','email','first_name','last_name','tel','role_id','users.created_at','users.updated_at')
            ->join('role_user', 'users.id' , 'role_user.user_id')
            ->where('role_user.role_id',2)
            ->paginate(10);
        } else {

            $users=User::select('users.id','email','first_name','last_name','tel','role_id','users.created_at','users.updated_at')
            ->join('role_user', 'users.id' , 'role_user.user_id')
            ->where('role_user.role_id',2)
            ->get();
        }
        $roles = Role::all();
        
        return View('usersmanagement.show-users', compact('users', 'roles'));
    }
    public function formOfprof($id_prof){
        //begin---permissions
        if($this->AuthUserRole==3 || ($this->AuthUserRole==2 && $id_prof!=Auth::user()->id)){
            abort(403,trans('Access Denied'));
        }
        //end---permissions
        $branches = Branches_Formation::where('coordinateur',$id_prof)->get();
        return View('usersmanagement.student_formation', compact('branches'));

    }
    public function index_students($id_prof=NULL , $id_brf=NULL)
    {
        
        $paginationEnabled = config('usersmanagement.enablePagination');
        if($id_prof==NULL && $id_brf==NULL)
        {   
            //begin---permissions
            if($this->AuthUserRole!=1 ){
                abort(403,trans('Access Denied'));
            }
            //end---permissions

            if ($paginationEnabled) {
                $users=User::select('users.id','students.validate','email','first_name','last_name','tel','role_id','users.created_at','users.updated_at')
                ->join('students', 'users.id' , 'students.id_user')
                ->join('role_user', 'users.id' , 'role_user.user_id')
                ->where('role_id',3)
                ->paginate(10);
            } else {

                $users=User::select('users.id','students.validate','email','first_name','last_name','tel','role_id','users.created_at','users.updated_at')
                ->join('students', 'users.id' , 'students.id_user')
                ->join('role_user', 'users.id' , 'role_user.user_id')
                ->where('role_id','<>',3)
                ->get();
            }
        }
        else if($id_prof!=NULL && $id_brf!=NULL)
        {
            //begin---permissions
            if($this->AuthUserRole==3 || ($this->AuthUserRole==2 && $id_prof!=Auth::user()->id)){
                abort(403,trans('Access Denied'));
            }
            //end---permissions
            if(Route::currentRouteName()=='students_validate'){
                if ($paginationEnabled) {
                    $users=User::select('users.id','students.validate','coordinateur','email','first_name','last_name','tel','role_id','users.created_at','users.updated_at')
                    ->join('students', 'users.id' , 'students.id_user')
                    ->join('branches_formations', 'branches_formations.id_BrF', 'students.id_branche_formation')
                    ->where('coordinateur',$id_prof)
                    ->where('id_BrF',$id_brf)
                    ->where('students.validate',0)
                    ->join('role_user', 'users.id' , 'role_user.user_id')
                    ->where('role_id',3)
                    ->paginate(10);
                } else {
    
                    $users=User::select('users.id','students.validate','coordinateur','email','first_name','last_name','tel','role_id','users.created_at','users.updated_at')
                    ->join('students', 'users.id' , 'students.id_user')
                    ->join('branches_formations', 'branches_formations.id_BrF', 'students.id_branche_formation')
                    ->where('coordinateur',$id_prof)
                    ->where('id_BrF',$id_brf)
                    ->where('students.validate',0)
                    ->join('role_user', 'users.id' , 'role_user.user_id')
                    ->where('role_id',3)
                    ->get();
    
                }
            }else if(Route::currentRouteName()=="students_of_prof_formation"){
                if ($paginationEnabled) {
                    $users=User::select('users.id','students.validate','coordinateur','email','first_name','last_name','tel','role_id','users.created_at','users.updated_at')
                    ->join('students', 'users.id' , 'students.id_user')
                    ->join('branches_formations', 'branches_formations.id_BrF', 'students.id_branche_formation')
                    ->where('coordinateur',$id_prof)
                    ->where('id_BrF',$id_brf)
                    ->where('students.validate',1)
                    ->join('role_user', 'users.id' , 'role_user.user_id')
                    ->where('role_id',3)
                    ->paginate(10);
                } else {
    
                    $users=User::select('users.id','students.validate','coordinateur','email','first_name','last_name','tel','role_id','users.created_at','users.updated_at')
                    ->join('students', 'users.id' , 'students.id_user')
                    ->join('branches_formations', 'branches_formations.id_BrF', 'students.id_branche_formation')
                    ->where('coordinateur',$id_prof)
                    ->where('id_BrF',$id_brf)
                    ->where('students.validate',1)
                    ->join('role_user', 'users.id' , 'role_user.user_id')
                    ->where('role_id',3)
                    ->get();
    
                }

            }
            else if(Route::currentRouteName()=="students_of_prof_completed"){
                if ($paginationEnabled) {
                    $users=User::select('users.id','students.validate','coordinateur','email','first_name','last_name','tel','role_id','users.created_at','users.updated_at')
                    ->join('students', 'users.id' , 'students.id_user')
                    ->join('branches_formations', 'branches_formations.id_BrF', 'students.id_branche_formation')
                    ->where('coordinateur',$id_prof)
                    ->where('id_BrF',$id_brf)
                    ->where('students.status_tr1',1)
                    ->where('students.status_tr2',1)
                    ->join('role_user', 'users.id' , 'role_user.user_id')
                    ->where('role_id',3)
                    ->paginate(10);
                } else {
    
                    $users=User::select('users.id','students.validate','coordinateur','email','first_name','last_name','tel','role_id','users.created_at','users.updated_at')
                    ->join('students', 'users.id' , 'students.id_user')
                    ->join('branches_formations', 'branches_formations.id_BrF', 'students.id_branche_formation')
                    ->where('coordinateur',$id_prof)
                    ->where('id_BrF',$id_brf)
                    ->where('students.status_tr1',1)
                    ->where('students.status_tr2',1)
                    ->join('role_user', 'users.id' , 'role_user.user_id')
                    ->where('role_id',3)
                    ->get();
    
                }

            }else if(Route::currentRouteName()=="students_of_prof_uncompleted"){
                if ($paginationEnabled) {
                    $users=User::select('users.id','students.validate','coordinateur','email','first_name','last_name','tel','role_id','users.created_at','users.updated_at')
                    ->join('students', 'users.id' , 'students.id_user')
                    ->join('branches_formations', 'branches_formations.id_BrF', 'students.id_branche_formation')
                    ->where('coordinateur',$id_prof)
                    ->where('id_BrF',$id_brf)
                    ->where('students.status_tr1',0)
                    ->orwhere('students.status_tr2',0)
                    ->join('role_user', 'users.id' , 'role_user.user_id')
                    ->where('role_id',3)
                    ->paginate(10);
                } else {
    
                    $users=User::select('users.id','students.validate','coordinateur','email','first_name','last_name','tel','role_id','users.created_at','users.updated_at')
                    ->join('students', 'users.id' , 'students.id_user')
                    ->join('branches_formations', 'branches_formations.id_BrF', 'students.id_branche_formation')
                    ->where('coordinateur',$id_prof)
                    ->where('id_BrF',$id_brf)
                    ->where('students.status_tr1',0)
                    ->orwhere('students.status_tr2',0)
                    ->join('role_user', 'users.id' , 'role_user.user_id')
                    ->where('role_id',3)
                    ->get();
    
                }

            }
        }
        else{
            abort(404);
        }
        $roles = Role::all();
        return View('usersmanagement.show-users', compact('users', 'roles'));
    }
    public function student_accept($id){
        $student=Student::where('id_user' , $id)->first();
        $student->validate = 1;
        $student->save();
        return back()->with('success', trans('Student accepted succesfully'));
    }
    public function student_refuse($id){
        $student=User::where('id' , $id)->first();
        $student->save();
        $student->delete();
        return back()->with('success', trans('Student refused succesfully'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //begin---permissions
        
        if($this->AuthUserRole!=1 ){
            abort(403,trans('Access Denied'));

        }
        //end---permissions

        $roles = Role::where('name','<>','Admin')->get();
        $types_formations= Formation::select('type')
            ->distinct()
            ->get();

        
        return view('usersmanagement.create-user')->with([
            'roles' => $roles,
            'types_formations' => $types_formations,
        ]); 
    }
    public function students_ImportExport()
    {
        //begin---permissions
        
        if($this->AuthUserRole!=1 ){
            abort(403,trans('Access Denied'));

        }
       
        
        return view('usersmanagement.ImportExport-students'); 
    }

    //Import
    public function students_import(Request $request)
    {
        //begin---permissions
        
        if($this->AuthUserRole!=1 ){
            abort(403,trans('Access Denied'));

        }
    
        $request->validate([
            'students_file' => 'required|mimes:xlsx,xls', 
        ]);

        Excel::import(new UsersImport, $request->file('students_file')->store('temp'));
        return back()->with('success', trans('Excel Data Imported Successfully'));
        
    }
    //Export
    public function students_export()
    {
        //begin---permissions
        
        if($this->AuthUserRole!=1 ){
            abort(403,trans('Access Denied'));

        }
        
        return Excel::download( new UsersExport, 'students-' . time() . '.xlsx');
        // return Excel::download( new UsersShortExport, 'students_payment-' . time() . '.xlsx');
        
        // return back()->with('success', trans('Data Exported Successfully'));


    }
    public function students_short_export()
    {
        //begin---permissions
        
        if($this->AuthUserRole!=1 ){
            abort(403,trans('Access Denied'));

        }
        
        return Excel::download( new UsersShortExport, 'students_payment-' . time() . '.xlsx');
        
        
        // return back()->with('success', trans('Data Exported Successfully'));


    }
    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //begin---permissions
        
        
        if($this->AuthUserRole!=1 ){
            abort(403,trans('Access Denied'));

        }
        //end---permissions
        
        $validator = Validator::make(
            $request->all(),
            [
                // 'name'                  => 'required|max:255|unique:users|alpha_dash',
                'first_name'            => 'required|max:255',
                'last_name'             => 'required|max:255',
                'email'                 => 'required|email|max:255|unique:users',
                'phone_number'          => 'required',
                'password'              => 'required|min:6|max:20|confirmed',
                'password_confirmation' => 'required|same:password',
                'role'                  => 'required',
            ],
            [
                'first_name.required' => trans('auth.fNameRequired'),
                'last_name.required'  => trans('auth.lNameRequired'),
                'email.required'      => trans('auth.emailRequired'),
                'email.email'         => trans('auth.emailInvalid'),
                'phone_number.required' => trans('Phone Number is required'),
                'password.required'   => trans('auth.passwordRequired'),
                'password.min'        => trans('auth.PasswordMin'),
                'password.max'        => trans('auth.PasswordMax'),
                'role.required'       => trans('auth.roleRequired'),
            ]
        );
        

        if($request->role==3){
            
            $request->validate([

                'CNE'      => 'required|unique:students',
                'CIN'      => 'required|unique:students',
                'bac_year' => 'required|numeric|min:1900|max:'.(date('Y')-1),
                's1_receipt' => 'mimes:jpeg,bmp,png', // Only allow .jpg, .bmp and .png file types.
                's2_receipt' => 'mimes:jpeg,bmp,png', 
                's3_receipt' => 'mimes:jpeg,bmp,png', 
                's4_receipt' => 'mimes:jpeg,bmp,png', 
            ]);
        }

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }


        $profile = new Profile();
        $establishment_prof = NULL;
        if($request->role=="2"){
            $establishment_prof = strip_tags($request->input('establishment_prof'));
        }

        $user = User::create([
            'first_name'          => strip_tags($request->input('first_name')),
            'last_name'           => strip_tags($request->input('last_name')),
            'email'               => $request->input('email'),
            'password'            => Hash::make($request->input('password')),
            'tel'                 => strip_tags($request->input('phone_number')),
            'establishment_prof'  => $establishment_prof,
            'token'               => str_random(64),
            'activated'           => 1,
        ]);
        $user->profile()->save($profile);
        
        $user->attachRole($request->input('role'));
        
        //----------------Student------------------

        if($request->role=="3"){
        
            //Fill the student table
            $student = Student::create([
                'id_user' => $user->id,
                'id_branche_formation' => strip_tags($request->input('branches_formation')),
                'CNE'=> strip_tags($request->input('CNE')),
                'CIN'=> strip_tags($request->input('CIN')),
                'date_birth'=> strip_tags($request->input('date_birth')),
                'place_birth'=> strip_tags($request->input('place_birth')),
                
                
            ]);
            
           
            
            //----------store_files--------------
           
            $path1=$path2=$path3=$path4 = NULL ;  
            $date1=$date2=$date3=$date4 = NULL ;   

            if($request->hasFile('s1_receipt')){
                $date1=date("Y-m-d");
                $guessExtension = $request->file('s1_receipt')->guessExtension();
                $path1 = $request->file('s1_receipt')->storeAs('payments/s1', 's1_'.$user->id.'.'.$guessExtension  ,'public');
            }
            if($request->hasFile('s2_receipt')){
                $date2=date("Y-m-d");
                $guessExtension = $request->file('s2_receipt')->guessExtension();
                $path2 = $request->file('s2_receipt')->storeAs('payments/s2', 's2_'.$user->id.'.'.$guessExtension  ,'public');
            }
            if($request->hasFile('s3_receipt')){
                $date3=date("Y-m-d");
                $guessExtension = $request->file('s3_receipt')->guessExtension();
                $path3 = $request->file('s3_receipt')->storeAs('payments/s3', 's3_'.$user->id.'.'.$guessExtension  ,'public');
            }
            if($request->hasFile('s4_receipt')){
                $date4=date("Y-m-d");
                $guessExtension = $request->file('s4_receipt')->guessExtension();
                $path4 = $request->file('s4_receipt')->storeAs('payments/s4', 's4_'.$user->id.'.'.$guessExtension  ,'public');
            }
            // Save the file locally in the storage/public/ folder under a new folder named /product
            // dd($request->all());
            
            
            
            //payement status
            $status_s1=$request->s1_amount<18000?0:1;
            $status_s2=$request->s2_amount<6000?0:1;
            $status_s3=$request->s3_amount<9000?0:1;
            $status_s4=$request->s4_amount<1000?0:1;



            $payment = Payment::create([
                'id_S' => $student->id_S,
                //-----------------------
                's1_receipt' => $path1,
                's1_amount' => strip_tags($request->input('s1_amount')),
                's1_date'   => $date1,
                'status_s1' => $status_s1,
                //-----------------------
                's2_receipt' => $path2,
                's2_amount' => strip_tags($request->input('s2_amount')),
                's2_date'   => $date2,
                'status_s2' => $status_s2,
                //-----------------------
                's3_receipt' => $path3,
                's3_amount' => strip_tags($request->input('s3_amount')),
                's3_date'   => $date3,
                'status_s3' => $status_s3,
                //-----------------------
                's4_receipt' => $path4,
                's4_amount' => strip_tags($request->input('s4_amount')),
                's4_date'   => $date4,
                'status_s4' => $status_s4,
                
            ]);

           
            //-----------------------------------


            
            
            //bac
            Bac_Student::create([
                
                'id_student' => strip_tags($student->id_S),
                'serie'         => strip_tags($request->input('serie')),
                'academy'       => strip_tags($request->input('academy')),
                'establishment_1' => strip_tags($request->input('establishment1')),
                'bac_year'              => strip_tags($request->input('bac_year')),

                
            ]);
            

            Diploma_Student::create([
                
                'id_student' => strip_tags($student->id_S),
                'diploma'         => strip_tags($request->input('diploma')),
                'date_obtained'       => strip_tags($request->input('date_obtained')),
                'establishment_2' => strip_tags($request->input('establishment2')),
                
            ]);
            
            Experience_Student::create([
                
                'id_student' => strip_tags($student->id_S),
                'employer_organization'         => strip_tags($request->input('employer_organization')),
                'poste_occupied'       => strip_tags($request->input('poste_occupied')),
                
            ]);
        }

        $user->save();
        if($request->role==2){
            return redirect('users')->with('success', 'Professor created successfully');
        }
        else{
            return redirect('users')->with('success', 'Student created successfully');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     *
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $userRole = DB::select('select role_id from role_user where user_id =' . $user->id);
        $currentRole=$userRole[0]->role_id;
        $formation=NULL;

        //begin---permission
        
        if( ($this->AuthUserRole==2 && $user->id == 1) || ($this->AuthUserRole==3 && Auth::User()->id != $user->id) ){
            
            abort(403,trans('can not show this user')); 
            
        }
        // else if( $this->AuthUserRole==2){
        //     $user00 = Student::select('coordinateur')
        //             ->join('branches_formations','id_branche_formation','id_BrF')
        //             ->where('id_user',$user->id)
        //             ->where('coordinateur',Auth::user()->id)
        //             ->get()->first();
        //     if($user00==NULL){
        //        abort(403,trans('can not show this user'));    
        //     }
        // }
        
        //end---permissions
        if($currentRole=="3"){
        
           
            $user = User::select('*')
                    ->join('students', 'users.id' , 'students.id_user')
                    ->join('bac_student', 'students.id_S' , 'bac_student.id_student')
                    ->join('diploma_student', 'students.id_S' , 'diploma_student.id_student')
                    ->join('experience_student', 'students.id_S' , 'experience_student.id_student')
                    ->join('payment','payment.id_S','students.id_S')
                    ->where('users.id' , $user->id)->first();

            $formation = User::select('formations.name as formation_name','formations.type as formation_type','branches_formations.name as formation_branche' )
                    ->join('students', 'users.id' , 'students.id_user')
                    ->join('branches_formations', 'branches_formations.id_BrF' , 'students.id_branche_formation')
                    ->join('formations', 'formations.id' , 'branches_formations.id_formation')
                    ->where('users.id' , $user->id)->first();
            
            
        }
        elseif($currentRole=="2"){
         
            $user01 = User::select('users.id','email','first_name','last_name','tel','establishment_prof',
            'users.created_at','users.updated_at','users.deleted_at',
            'id_formation','branches_formations.name as brfName','id_BrF')
                    ->join('branches_formations', 'coordinateur', 'users.id')
                    ->where('users.id',$user->id)->first();
            if($user01!=NULL){
                $user=$user01;
            }
            
                    

            
        }
        // dd($user);
        return view('usersmanagement.show-user')->with([
            'user' => $user,
            'currentRole' => $currentRole,
            'formation' => $formation,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //begin---permission
        
        if( $this->AuthUserRole!=1  && Auth::User()->id != $user->id){
            
            abort(403,trans('can not edit this user'));    
            
        }
       
        //user can change his data while he is not yet accepted (just for student)
        if($this->AuthUserRole==3){
            $StudentValidate=Student::select('validate')
                ->where('id_user' ,Auth::user()->id)
                ->first();

            if($StudentValidate->validate==1){
                abort(403,trans('warning : YOUR PROFILE IS ACTIVATED , YOU CAN NOT MODIFY YOUR DATA NOW'));
            }
        }

        
        //end---permissions

        $userRole = DB::select('select role_id from role_user where user_id =' . $user->id);
        $currentRole=$userRole[0]->role_id;
        $roles = Role::all();
        if($currentRole=="3"){
            $user = User::select('*')
                    ->join('students', 'users.id' , 'students.id_user')
                    ->join('bac_student', 'students.id_S' , 'bac_student.id_student')
                    ->join('diploma_student', 'students.id_S' , 'diploma_student.id_student')
                    ->join('experience_student', 'students.id_S' , 'experience_student.id_student')
                    ->join('payment','payment.id_S','students.id_S')
                    ->where('id' , $user->id)->first();
        }
        $types_formations= Formation::select('type')
            ->distinct()
            ->get();
        $formation_student = User::select('formations.id as formation_id','formations.name as formation_name','formations.type as formation_type','branches_formations.name as formation_branche' )
                    ->join('students', 'users.id' , 'students.id_user')
                    ->join('branches_formations', 'branches_formations.id_BrF' , 'students.id_branche_formation')
                    ->join('formations', 'formations.id' , 'branches_formations.id_formation')
                    ->where('users.id' , $user->id)->first();

        $data = [
            'user'        => $user,
            'roles'       => $roles,
            'currentRole' => $currentRole,
            'types_formations' => $types_formations,
            'formation_student' => $formation_student,

        ];
        
        return view('usersmanagement.edit-user')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param User                     $user
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //begin permission
        if( $this->AuthUserRole!=1  && Auth::User()->id != $user->id){
            abort(403,trans('can not update this user'));    
        }
        //user can change his data while he is not yet accepted (just for student)
        if($this->AuthUserRole==3){
            $StudentValidate=Student::select('validate')
                ->where('id_user' ,Auth::user()->id)
                ->first();
            if($StudentValidate->validate==1){
                abort(403,trans('warning : YOUR PROFILE IS ACTIVATED , YOU CAN NOT MODIFY YOUR DATA NOW'));
            }
        }
        //end permission
        $validator = Validator::make($request->all(), [
            [
                'first_name'            => 'alpha_dash',
                'last_name'             => 'alpha_dash',
                'password'              => 'required|min:6|max:30|confirmed',
                'password_confirmation' => 'required|same:password',
            ],
            [       
                'first_name.required'           => trans('auth.fNameRequired'),
                'last_name.required'            => trans('auth.lNameRequired'),
                'password.required'             => trans('auth.passwordRequired'),
                'password.min'                  => trans('auth.PasswordMin'),
                'password.max'                  => trans('auth.PasswordMax'),   
            ]
        ]);
        $emailCheck = $request->input('email') !== $user->email;
        if($request->role==2){
            if ($emailCheck) {
                $request->validate([
                    'email'  => 'required|email|max:255|unique:users',
                ]);
            } else {
                $validator = Validator::make($request->all(), [
                    // 'first_name'    => 'alpha_dash',
                    // 'last_name'     => 'alpha_dash',
                    // 'password'      => 'nullable|confirmed|min:6',
                ]);
            }
        }elseif($request->role==3){
            $user01= User::select('*')
                ->join('students','students.id_user','users.id')
                ->where('users.id',$user->id)
                ->first();
            $CneCheck = $request->input('CNE') !== $user01->CNE;
            $CinCheck = $request->input('CIN') !== $user01->CIN;
            //file format allowed
            $request->validate([
                'branches_formation' => 'required',
                's1_receipt' => 'mimes:jpeg,bmp,png', // Only allow .jpg, .bmp and .png file types.
                's2_receipt' => 'mimes:jpeg,bmp,png', 
                's3_receipt' => 'mimes:jpeg,bmp,png', 
                's4_receipt' => 'mimes:jpeg,bmp,png', 
            ]);

            if ($emailCheck) {
                if($CinCheck && $CneCheck){
                    $request->validate([
                        'email'    => 'required|email|max:255|unique:users',
                        'CNE'      => 'required|unique:students',
                        'CIN'      => 'required|unique:students',
                        'bac_year' => 'required|numeric|min:1900|max:'.(date('Y')-1),
                    ]);
                }
                else if($CneCheck){
                    $request->validate([
                        'email'    => 'required|email|max:255|unique:users',
                        'CNE'      => 'required|unique:students',
                        'bac_year' => 'required|numeric|min:1900|max:'.(date('Y')-1),
                    ]);
                }
                else if($CinCheck){
                    $request->validate([
                        'email'    => 'required|email|max:255|unique:users',
                        'CIN'      => 'required|unique:students',
                        'bac_year' => 'required|numeric|min:1900|max:'.(date('Y')-1),
                    ]);
                }else{
                    $request->validate([
                        'email'    => 'required|email|max:255|unique:users',
                        'bac_year' => 'required|numeric|min:1900|max:'.(date('Y')-1),
                    ]);
                }
            }else{
                if($CneCheck && $CinCheck){
                    $request->validate([
                        'CNE'      => 'required|unique:students',
                        'CIN'      => 'required|unique:students',                        
                        'bac_year' => 'required|numeric|min:1900|max:'.(date('Y')-1),
                    ]);
                }else if($CneCheck){
                    $request->validate([
                        'CNE'      => 'required|unique:students',
                        'bac_year' => 'required|numeric|min:1900|max:'.(date('Y')-1),
                    ]);
                }else if($CinCheck){
                    $request->validate([
                        'CIN'      => 'required|unique:students',                        
                        'bac_year' => 'required|numeric|min:1900|max:'.(date('Y')-1),
                    ]);
                }
                else{   
                    $request->validate([
                        'bac_year' => 'required|numeric|min:1900|max:'.(date('Y')-1),
                    ]);
                }
            }
        }
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $user->first_name = strip_tags($request->input('first_name'));
        $user->last_name  = strip_tags($request->input('last_name'));
        $user->tel        = strip_tags($request->input('phone_number'));
        if($request->role=="2"){
            $user->establishment_prof = strip_tags($request->input('establishment_prof'));
        }
        if ($emailCheck) {
            $user->email = $request->input('email');
        }
        if ($request->input('password') !== null) {
            $user->password = Hash::make($request->input('password'));
        }
        $userRole = $request->input('role');
        if ($userRole !== null) {
            $user->detachAllRoles();
            $user->attachRole($userRole);
        }
        switch ($userRole) {
            case 3:
                $user->activated = 0;
                break;

            default:
                $user->activated = 1;
                break;
        }
        //edit other tables 
        //---------------Student----------------
        if($request->role=="3"){
            //----------store_files--------------
            

            $student = Student::where('id_user' , $user->id)->first();
            $student->update([
                'id_user' => $user->id,
                'id_branche_formation' => strip_tags($request->input('branches_formation')),
                'CNE'=> strip_tags($request->input('CNE')),
                'CIN'=> strip_tags($request->input('CIN')),
                'date_birth'=> strip_tags($request->input('date_birth')),
                'place_birth'=> strip_tags($request->input('place_birth')),
                
            ]);
            //----------store_files--------------
        
            $payment = Payment::where('payment.id_S' , $student->id_S)->first();
            //payement status
            $status_s1=$request->s1_amount<18000?0:1;
            $status_s2=$request->s2_amount<6000?0:1;
            $status_s3=$request->s3_amount<9000?0:1;
            $status_s4=$request->s4_amount<1000?0:1;
            //update amount and status
            $payment->update([
                //-----------Amount------------
                's1_amount' => strip_tags($request->input('s1_amount')),
                's2_amount' => strip_tags($request->input('s2_amount')),
                's3_amount' => strip_tags($request->input('s3_amount')),
                's4_amount' => strip_tags($request->input('s4_amount')),
                //-----------Status-------------
                'status_s1' => $status_s1,
                'status_s2' => $status_s2, 
                'status_s3' => $status_s3, 
                'status_s4' => $status_s4, 

            ]);

            if($request->hasFile('s1_receipt')){
                $date1=date("Y-m-d");
                $guessExtension = $request->file('s1_receipt')->guessExtension();
                $path1 = $request->file('s1_receipt')->storeAs('payments/s1', 's1_'.$user->id.'.'.$guessExtension  ,'public');

                $payment->update([
                    //-----------------------
                    's1_receipt' => $path1,
                    's1_date'   => $date1,
                ]);
            }
            if($request->hasFile('s2_receipt')){
                $date2=date("Y-m-d");
                $guessExtension = $request->file('s2_receipt')->guessExtension();
                $path2 = $request->file('s2_receipt')->storeAs('payments/s2', 's2_'.$user->id.'.'.$guessExtension  ,'public');
                
                $payment->update([
                    's2_receipt' => $path2,
                    's2_date'   => $date2,
                ]);
            }
            if($request->hasFile('s3_receipt')){
                $date3=date("Y-m-d");
                $guessExtension = $request->file('s3_receipt')->guessExtension();
                $path3 = $request->file('s3_receipt')->storeAs('payments/s3', 's3_'.$user->id.'.'.$guessExtension  ,'public');
                
                $payment->update([
                    's3_receipt' => $path3,
                    's3_date'   => $date3,
                     
                ]);
            }
            if($request->hasFile('s4_receipt')){
                $date4=date("Y-m-d");
                $guessExtension = $request->file('s4_receipt')->guessExtension();
                $path4 = $request->file('s4_receipt')->storeAs('payments/s4', 's4_'.$user->id.'.'.$guessExtension  ,'public');
                
                $payment->update([
                    
                    's4_receipt' => $path4,
                    's4_date'   => $date4,
                    
                ]);

            }
            // Save the file locally in the storage/public/ folder under a new folder named /product
            // dd($request->all());
            
            
            
            

            

            

           
            //-----------------------------------
            


            //bac
            
            $bac = Bac_Student::where('id_student' , $student->id_S)->first();
            
            $bac->update([
                
                'id_student' => strip_tags($student->id_S),
                'serie'         => strip_tags($request->input('serie')),
                'academy'       => strip_tags($request->input('academy')),
                'establishment_1' => strip_tags($request->input('establishment1')),
                'bac_year'        => strip_tags($request->input('bac_year')),

                
            ]);
            
            $diploma = Diploma_Student::where('id_student' , $student->id_S)->first();
            $diploma->update([
                
                'id_student' => strip_tags($student->id_S),
                'diploma'         => strip_tags($request->input('diploma')),
                'date_obtained'       => strip_tags($request->input('date_obtained')),
                'establishment_2' => strip_tags($request->input('establishment2')),
                
            ]);
            
            $experience = Experience_Student::where('id_student' , $student->id_S)->first();
            $experience->update([
                
                'id_student'             => strip_tags($student->id_S),
                'employer_organization'  => strip_tags($request->input('employer_organization')),
                'poste_occupied'         => strip_tags($request->input('poste_occupied')),
                
            ]);

        }
        //-----------------
        $user->save();
        
        return redirect('users/'.$user->id)->with('success', trans('usersmanagement.updateSuccess'));
        

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //begin---permission
        
        if( $this->AuthUserRole!=1  && Auth::User()->id != $user->id){
            
            abort(403,trans('can not destroy this user'));    
            
        }
        //end---permission
        $currentUser = Auth::user();

        if ($user->id !== $currentUser->id) {
            $user->save();
            $user->delete();

            return redirect('users')->with('success', trans('usersmanagement.deleteSuccess'));
        }

        return back()->with('error', trans('usersmanagement.deleteSelfError'));
    }

    /**
     * Method to search the users.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request , $id_prof=NULL , $id_brf=NULL)
    {
        $searchTerm = $request->input('user_search_box');
        $searchRules = [
            'user_search_box' => 'required|string|max:255',
        ];
        $searchMessages = [
            'user_search_box.required' => 'Search term is required',
            'user_search_box.string'   => 'Search term has invalid characters',
            'user_search_box.max'      => 'Search term has too many characters - 255 allowed',
        ];

        $validator = Validator::make($request->all(), $searchRules, $searchMessages);

        if ($validator->fails()) {
            return response()->json([
                json_encode($validator),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        
        // $results = User::where('id', 'like', $searchTerm.'%')
        //                     ->orWhere('email', 'like', $searchTerm.'%')->get();
        // $results = json_decode($request->users_, true);
        $routeName = json_decode($request->routeName, true);
        if ($routeName=='students_of_prof_formation' ||
            $routeName=='students_validate' ||
            $routeName=='students_of_prof_completed' ||
            $routeName=='students_of_prof_uncompleted'){

                $id1 = json_decode($request->id1, true);
                $id2 = json_decode($request->id2, true);
            
            }
        
        if($routeName=='users'){    
           
            $results=User::select('users.id','email','first_name','last_name','tel','users.created_at','users.updated_at')
                    ->join('role_user', 'users.id' , 'role_user.user_id')
                    ->where('role_user.role_id','<>',1)
                    ->Where('email', 'like', $searchTerm.'%')
                    ->get();
            
                   
        }
        else if($routeName=='profs'){    
           
            $results=User::select('users.id','email','first_name','last_name','tel','users.created_at','users.updated_at')
                    ->join('role_user', 'users.id' , 'role_user.user_id')
                    ->where('role_user.role_id',2)
                    ->Where('email', 'like', $searchTerm.'%')
                    ->get();
            
                   
        }
        else if($routeName=='students'){    
           
            
            $results=User::select('users.id','students.validate','email','first_name','last_name','tel','role_id','users.created_at','users.updated_at')
                ->join('students', 'users.id' , 'students.id_user')
                ->join('role_user', 'users.id' , 'role_user.user_id')
                ->where('role_id',3)
                ->Where('email', 'like', $searchTerm.'%')
                ->get();
                   
        }
        else if($routeName=='students_validate'){
           
            $results=User::select('users.id','students.validate','coordinateur','email','first_name','last_name','tel','role_id','users.created_at','users.updated_at')
            ->join('students', 'users.id' , 'students.id_user')
            ->join('branches_formations', 'branches_formations.id_BrF', 'students.id_branche_formation')
            ->where('coordinateur',$id1)
            ->where('id_BrF',$id2)
            ->where('students.validate',0)
            ->join('role_user', 'users.id' , 'role_user.user_id')
            ->where('role_id',3)
            ->Where('email', 'like', $searchTerm.'%')     
            ->get();

           
        }else if($routeName=="students_of_prof_formation"){
           

            $results=User::select('users.id','students.validate','coordinateur','email','first_name','last_name','tel','role_id','users.created_at','users.updated_at')
            ->join('students', 'users.id' , 'students.id_user')
            ->join('role_user', 'users.id' , 'role_user.user_id')
            ->where('role_id',3)
            ->join('branches_formations', 'branches_formations.id_BrF', 'students.id_branche_formation')
            ->where('coordinateur',$id1)
            ->where('id_BrF',$id2)
            ->where('students.validate',1)
            ->Where('email', 'like', $searchTerm.'%')     
            ->get();

           

        }
        else if($routeName=="students_of_prof_completed"){
           

            $results=User::select('users.id','students.validate','coordinateur','email','first_name','last_name','tel','role_id','users.created_at','users.updated_at')
                ->join('students', 'users.id' , 'students.id_user')
                ->join('role_user', 'users.id' , 'role_user.user_id')
                ->where('role_id',3)
                ->join('branches_formations', 'branches_formations.id_BrF', 'students.id_branche_formation')
                ->where('coordinateur',$id1)
                ->where('id_BrF',$id2)
                ->where('students.status_tr1',1)
                ->where('students.status_tr2',1)
                ->Where('email', 'like', $searchTerm.'%')
                ->get();

           

        }else if($routeName=="students_of_prof_uncompleted"){
            
            $results=User::select('users.id','students.validate','coordinateur','email','first_name','last_name','tel','role_id','users.created_at','users.updated_at')
                    ->join('students', 'users.id' , 'students.id_user')
                    ->join('role_user', 'users.id' , 'role_user.user_id')
                    ->where('role_id',3)
                    ->join('branches_formations', 'branches_formations.id_BrF', 'students.id_branche_formation')
                    ->where('coordinateur',$id1)
                    ->where('id_BrF',$id2)
                    ->where('students.status_tr1',0)
                    ->orwhere('students.status_tr2',0)
                    ->Where('email', 'like', $searchTerm.'%')     
                    ->get();

            }

        // Attach roles to results
        foreach ($results as $result) {
            $roles = [
                'roles' => $result->roles,
            ];
            $result->push($roles);
        }
        
        return response()->json([
            json_encode($results),
        ], Response::HTTP_OK);
    }
    
}
