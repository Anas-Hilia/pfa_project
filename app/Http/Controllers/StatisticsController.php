<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Branches_Formation;
use App\Models\Student;
use App\Models\Formation;
use ConsoleTVs\Charts;
use Auth;
use DB;
use Route;
class StatisticsController extends Controller
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
            if($this->AuthUserRole==3){
                abort(403,trans('Access Denied'));
            }
            return $next($request);
          });
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    	
    	return view('statistics.home');
    }

    public function charts($id)
    {
        if($id==1){
            if($this->AuthUserRole==1){
                $statisticTable = Student::select('formations.id','formations.name', DB::raw('count(students.id_S) as nbr_Student') )
                            ->join('branches_formations','id_BrF','id_branche_formation')
                            ->join('formations','formations.id','branches_formations.id_formation')
                            ->where('validate',1)
                            ->groupBy('formations.id','formations.name')
                            ->orderBy('formations.id', 'asc')
                            ->get();
            }else{
                $statisticTable = Student::select('formations.id','formations.name', DB::raw('count(students.id_S) as nbr_Student') )
                            ->join('branches_formations','id_BrF','id_branche_formation')
                            ->join('formations','formations.id','branches_formations.id_formation')
                            ->where('validate',1)
                            ->where('formations.created_by',Auth::user()->id)
                            ->groupBy('formations.id','formations.name')
                            ->orderBy('formations.id', 'asc')
                            ->get();
            }
        }
        else if($id==2){
            if($this->AuthUserRole==1){
                $statisticTable = Student::select('id_BrF','branches_formations.name', DB::raw('count(students.id_S) as nbr_Student') )
                            ->join('branches_formations','id_BrF','id_branche_formation')
                            ->where('validate',1)
                            ->groupBy('id_BrF','branches_formations.name')
                            ->orderBy('id_BrF', 'asc')
                            ->get();
            }else{
                $statisticTable = Student::select('id_BrF','branches_formations.name', DB::raw('count(students.id_S) as nbr_Student') )
                            ->join('branches_formations','id_BrF','id_branche_formation')
                            ->where('validate',1)
                            ->where('coordinateur',Auth::user()->id)
                            ->groupBy('id_BrF','branches_formations.name')
                            ->orderBy('id_BrF', 'asc')
                            ->get();

            }
            
        }else if($id==3){

            if($this->AuthUserRole==1){
                
                $nbrstdComp = Student::select(DB::raw('count(students.id_S) as nbr_Student') )                   
                            ->join('payment','payment.id_S','students.id_S')         
                            ->where('status_s1',1)
                            ->where('status_s2',1)
                            ->where('status_s3',1)
                            ->where('status_s4',1)
                            ->where('validate',1)
                            ->get()->first();
                $nbrstdUnComp = Student::select(DB::raw('count(students.id_S) as nbr_Student') )
                            ->join('payment','payment.id_S','students.id_S')                            
                            ->where('status_s1',0)
                            ->orwhere('status_s2',0)
                            ->orwhere('status_s3',0)
                            ->orwhere('status_s4',0)
                            ->where('validate',1)
                            ->get()->first();

                $statisticTable = array(array('name' => 'Payment Completed','nbr_Student'=> $nbrstdComp->nbr_Student),array('name' => 'Payment Uncompleted','nbr_Student'=> $nbrstdUnComp->nbr_Student));

            
            }else{

                $nbrstdComp = Student::select(DB::raw('count(students.id_S) as nbr_Student') )  
                            ->join('branches_formations','id_branche_formation','id_BrF')
                            ->where('coordinateur',Auth::user()->id)     
                            ->join('payment','payment.id_S','students.id_S')                     
                            ->where('status_s1',1)
                            ->where('status_s2',1)
                            ->where('status_s3',1)
                            ->where('status_s4',1)
                            ->where('validate',1)
                            ->get()->first();
                $nbrstdUnComp = Student::select(DB::raw('count(students.id_S) as nbr_Student') )  
                            ->join('branches_formations','id_branche_formation','id_BrF')    
                            ->where('coordinateur',Auth::user()->id)
                            ->join('payment','payment.id_S','students.id_S')                          
                            ->where('status_s1',0)
                            ->orwhere('status_s2',0)
                            ->orwhere('status_s3',0)
                            ->orwhere('status_s4',0)
                            ->where('validate',1)
                            ->get()->first();

                $statisticTable = array(array('name' => 'Payment Completed','nbr_Student'=> $nbrstdComp->nbr_Student),array('name' => 'Payment Uncompleted','nbr_Student'=> $nbrstdUnComp->nbr_Student));


            }
        }
        else{
            
            abort(404);
        }
        if($id==3){
            if($statisticTable==NULL){
                abort(404);
            }
        }
        else if($statisticTable->isEmpty()){
            abort(404);
        }
        $id_check = $id;
        if($this->AuthUserRole==2){
            if($id==1){
                $students = Student::select(DB::raw('count(students.id_S) as nbr') )
                    ->join('branches_formations','id_BrF','id_branche_formation')
                    ->join('formations','branches_formations.id_formation','formations.id')
                    ->where('validate',1)
                    ->where('formations.created_by',Auth::user()->id)
                    ->get()->first();
            }else{
                $students = Student::select(DB::raw('count(students.id_S) as nbr') )
                    ->join('branches_formations','id_BrF','id_branche_formation')
                    ->where('validate',1)
                    ->where('coordinateur',Auth::user()->id)
                    ->get()->first();
            }
        }else{
            $students = Student::select(DB::raw('count(students.id_S) as nbr') )
                    ->where('validate',1)
                    ->get()->first();
        }
        $total_student=$students->nbr;

    	return view('statistics.charts',compact('statisticTable','total_student','id_check'));
    }
    public function chartsByFormation($id=NULL)
    {
        if($id==NULL){
            if($this->AuthUserRole==1){
                $formations=DB::table('formations')
                ->where('deleted_at', NULL)
                ->where('c_accepted',1)
                ->where('u_accepted',1)
                ->get();
            }else{
                $formations=DB::table('formations')
                ->where('deleted_at', NULL)
                ->where('formations.created_by',Auth::user()->id)
                ->where('c_accepted',1)
                ->where('u_accepted',1)
                ->get();
            }
            return view('formationsmanagement.show-formations',compact('formations'));
        }
        else{
            

            $formation = Student::select('formations.id','formations.created_by','formations.name',DB::raw('count(students.id_S) as total'))
                        ->join('branches_formations','id_BrF','id_branche_formation')
                        ->join('formations','formations.id','branches_formations.id_formation')
                        ->where('validate',1)
                        ->groupBy('formations.id','formations.name','formations.created_by')
                        ->orderBy('formations.id', 'asc')
                        ->where('id',$id)->get();

                        
            if($formation->isEmpty()){
                abort(404);
            }
            $formation=$formation[0];
            if($this->AuthUserRole==2 && $formation->created_by!==Auth::user()->id){
                abort(403,'Access denied');
            }
            $statisticTable = Student::select('id_BrF','branches_formations.name', DB::raw('count(students.id_S) as nbr_Student') )
                        ->join('branches_formations','id_BrF','id_branche_formation')
                        ->join('formations','formations.id','branches_formations.id_formation')
                        ->where('validate',1)
                        ->where('formations.id',$id)
                        ->groupBy('id_BrF','branches_formations.name','formations.name')
                        ->orderBy('id_BrF', 'asc')
                        ->get();

            if($statisticTable->isEmpty()){
                abort(404);
            }       
        
            $students = Student::select(DB::raw('count(students.id_S) as nbr') )
                        ->where('validate',1)
                        ->get();
            
            $total_student=$students[0]->nbr;      

            return view('statistics.charts',compact('formation','statisticTable','total_student'));

        }
    }    
}
