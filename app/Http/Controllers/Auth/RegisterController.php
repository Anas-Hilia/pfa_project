<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\User;
use App\Models\Student;
use App\Models\Formation;
use App\Models\Bac_Student;
use App\Models\Diploma_Student;
use App\Models\Experience_Student;
use App\Traits\ActivationTrait;
use App\Traits\CaptchaTrait;
use App\Traits\CaptureIpTrait;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use jeremykenedy\LaravelRoles\Models\Role;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
     */

    use ActivationTrait;
    use CaptchaTrait;
    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/activate';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', [
            'except' => 'logout',
        ]);
    }

    /**
     * Get a validator for an incoming registration data.
     *
     * @param array $data
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $data['captcha'] = $this->captchaCheck();

        if (! config('settings.reCaptchStatus')) {
            $data['captcha'] = true;
        }


        return Validator::make(
            $data,
            [
                'first_name'            => 'alpha_dash',
                'last_name'             => 'alpha_dash',
                'email'                 => 'required|email|max:255|unique:users',
                'password'              => 'required|min:6|max:30|confirmed',
                'password_confirmation' => 'required|same:password',
                'g-recaptcha-response'  => '',
                'captcha'               => 'required|min:1',
                'CNE'                   => 'require|unique:students',
                'CIN'                   => 'require|unique:students',
                'bac_year'              => 'required|numeric|min:1900|max:'.(date('Y')-1),
            ],
            [
                
                'first_name.required'           => trans('auth.fNameRequired'),
                'last_name.required'            => trans('auth.lNameRequired'),
                'email.required'                => trans('auth.emailRequired'),
                'email.email'                   => trans('auth.emailInvalid'),
                'password.required'             => trans('auth.passwordRequired'),
                'password.min'                  => trans('auth.PasswordMin'),
                'password.max'                  => trans('auth.PasswordMax'),
                'g-recaptcha-response.required' => trans('auth.captchaRequire'),
                'captcha.min'                   => trans('auth.CaptchaWrong'),
                
            ]
        );
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     *
     * @return User
     */
    public function showRegistrationForm()
    {
        $types_formations= Formation::select('type')
            ->distinct()
            ->get();

        
        return view('auth.register')->with([
            'types_formations' => $types_formations,
    ]);
    }
    protected function create(Request $request)
    {
        //register new Student
        $validator = Validator::make($request->all(),[
            [
                // 'first_name'            => 'alpha_dash',
                // 'last_name'             => 'alpha_dash',
                // 'password'              => 'required|min:6|max:30|confirmed',
                // 'password_confirmation' => 'required|same:password',
            ],
            [
                
                // 'first_name.required'           => trans('auth.fNameRequired'),
                // 'last_name.required'            => trans('auth.lNameRequired'),
                // 'password.required'             => trans('auth.passwordRequired'),
                // 'password.min'                  => trans('auth.PasswordMin'),
                // 'password.max'                  => trans('auth.PasswordMax'),

                
            ]
        ]);
    
    
    
    
        
        
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }


        $profile = new Profile();

        $user = User::create([
            'first_name'       => strip_tags($request->input('first_name')),
            'last_name'        => strip_tags($request->input('last_name')),
            'email'            => $request->input('email'),
            'password'         => Hash::make($request->input('password')),
            'tel'              => strip_tags($request->input('phone_number')),
            'token'            => str_random(64),
            'activated'        => 1,
        ]);
        $user->profile()->save($profile);
        
        $user->attachRole($request->input('role'));
        
         //----------store_files--------------
            
            
            // ensure the request has a file before we attempt anything else.
            if ($request->hasFile('tranche_1') && $request->hasFile('tranche_2') ) {
                $request->validate([
                    'tranche_1' => 'mimes:jpeg,bmp,png', // Only allow .jpg, .bmp and .png file types.
                    'tranche_2' => 'mimes:jpeg,bmp,png', 
                ]);

                // Save the file locally in the storage/public/ folder under a new folder named /product
                // dd($request->all());
                
                $guessExtension1 = $request->file('tranche_1')->guessExtension();
                $path1 = $request->file('tranche_1')->storeAs('payments/t1', 't1_'.$user->id.'.'.$guessExtension1  ,'public');

                $guessExtension2 = $request->file('tranche_2')->guessExtension();
                $path2 = $request->file('tranche_2')->storeAs('payments/t2', 't2_'.$user->id.'.'.$guessExtension2  ,'public');


                
                $student = Student::create([
                    'id_user' => $user->id,
                    'id_branche_formation' => strip_tags($request->input('branches_formation')),
                    'CNE'=> strip_tags($request->input('CNE')),
                    'CIN'=> strip_tags($request->input('CIN')),
                    'date_birth'=> strip_tags($request->input('date_birth')),
                    'place_birth'=> strip_tags($request->input('place_birth')),
                    // Store the record, using the new file hashname which will be it's new filename identity.
                    'tranche_1' => $path1,
                    'tranche_2' => $path2,
                    'amount_tr1' => strip_tags($request->input('amount_tr1')),
                    'amount_tr2' => strip_tags($request->input('amount_tr2')),
                    
                ]);
                
            
        }
        else{
            $student = Student::create([
                'id_user' => $user->id,
                'id_branche_formation' => strip_tags($request->input('branches_formation')),
                'CNE'=> strip_tags($request->input('CNE')),
                'CIN'=> strip_tags($request->input('CIN')),
                'date_birth'=> strip_tags($request->input('date_birth')),
                'place_birth'=> strip_tags($request->input('place_birth')),
                
                
            ]);
        }

            //-----------------------------------


            
            
            //bac
            Bac_Student::create([
                
                'id_student' => strip_tags($student->id_S),
                'serie'         => strip_tags($request->input('serie')),
                'academy'       => strip_tags($request->input('academy')),
                'establishment_1' => strip_tags($request->input('establishment1')),
                'bac_year' => strip_tags($request->input('bac_year')),

                
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



        $user->save();

        return $user;
    }
}
