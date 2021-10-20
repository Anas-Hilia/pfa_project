@extends('layouts.app')

@section('template_title')
    {!! trans('usersmanagement.editing-user', ['name' => $user->last_name]) !!}
@endsection

@section('template_linked_css')
    <style type="text/css">
        .btn-save,
        .pw-change-container {
            display: none;
        }
        .change-continer2 {
            display: none;
        }

        .payment_img{
          -webkit-backface-visibility: hidden; 
          -ms-transform: translateZ(0); /* IE 9 */
          -webkit-transform: translateZ(0); /* Chrome, Safari, Opera */
          transform: translateZ(0);
        }
        .payment_img:hover {

            transform: translateY(-30px) scale(1.5) ;
            -webkit-transition: .3s ease-in-out;
            transition: .3s ease-in-out;

        }
    </style>
@endsection

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-lg-10 offset-lg-1">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            @if($currentRole==2)
                                {!! trans('Edit Professor', ['name' => $user->last_name]) !!}
                            @else
                                {!! trans('Edit Student', ['name' => $user->last_name]) !!}
                            @endif
                            <div class="pull-right">
                                @if($currentRole==2)
                                    <a href="{{ URL::TO('/profs') }}" class="btn btn-light btn-sm float-right" data-toggle="tooltip" data-placement="top" title="{{ trans('back to profs') }}">
                                        <i class="fa fa-fw fa-reply-all" aria-hidden="true"></i>
                                        {!! trans('back to profs') !!}
                                    </a>
                                    <a href="{{ url('/users/' . $user->id) }}" class="btn btn-light btn-sm float-right" data-toggle="tooltip" data-placement="left" title="{{ trans('back to prof') }}">
                                        <i class="fa fa-fw fa-reply" aria-hidden="true"></i>
                                        {!! trans('back to prof') !!}
                                    </a>
                                @elseif($currentRole==3)
                                    <a href="{{ URL::TO('/students') }}" class="btn btn-light btn-sm float-right" data-toggle="tooltip" data-placement="top" title="{{ trans('back to students') }}">
                                        <i class="fa fa-fw fa-reply-all" aria-hidden="true"></i>
                                        {!! trans('back to students') !!}
                                    </a>
                                    <a href="{{ url('/users/' . $user->id) }}" class="btn btn-light btn-sm float-right" data-toggle="tooltip" data-placement="left" title="{{ trans('back to student') }}">
                                        <i class="fa fa-fw fa-reply" aria-hidden="true"></i>
                                        {!! trans('back to student') !!}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        {!! Form::open(array('route' => ['users.update', $user->id], 'method' => 'PUT','enctype' => 'multipart/form-data', 'role' => 'form', 'class' => 'needs-validation')) !!}

                            {!! csrf_field() !!}

                            

                            <div class="form-group has-feedback row {{ $errors->has('first_name') ? ' has-error ' : '' }}">
                                {!! Form::label('first_name', trans('forms.create_user_label_firstname'), array('class' => 'col-md-3 control-label')); !!}
                                <div class="col-md-9">
                                    <div class="input-group">
                                        {!! Form::text('first_name', $user->first_name, array('id' => 'first_name', 'class' => 'form-control', 'placeholder' => trans('forms.create_user_ph_firstname'))) !!}
                                        <div class="input-group-append">
                                            <label class="input-group-text" for="first_name">
                                                <i class="fa fa-fw {{ trans('forms.create_user_icon_firstname') }}" aria-hidden="true"></i>
                                            </label>
                                        </div>
                                    </div>
                                    @if($errors->has('first_name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('first_name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group has-feedback row {{ $errors->has('last_name') ? ' has-error ' : '' }}">
                                {!! Form::label('last_name', trans('forms.create_user_label_lastname'), array('class' => 'col-md-3 control-label')); !!}
                                <div class="col-md-9">
                                    <div class="input-group">
                                        {!! Form::text('last_name', $user->last_name, array('id' => 'last_name', 'class' => 'form-control', 'placeholder' => trans('forms.create_user_ph_lastname'))) !!}
                                        <div class="input-group-append">
                                            <label class="input-group-text" for="last_name">
                                                <i class="fa fa-fw {{ trans('forms.create_user_icon_lastname') }}" aria-hidden="true"></i>
                                            </label>
                                        </div>
                                    </div>
                                    @if($errors->has('last_name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('last_name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group has-feedback row {{ $errors->has('email') ? ' has-error ' : '' }}">
                                {!! Form::label('email', trans('forms.create_user_label_email'), array('class' => 'col-md-3 control-label')); !!}
                                <div class="col-md-9">
                                    <div class="input-group">
                                        {!! Form::text('email', $user->email, array('id' => 'email', 'class' => 'form-control', 'placeholder' => trans('forms.create_user_ph_email'))) !!}
                                        <div class="input-group-append">
                                            <label for="email" class="input-group-text">
                                                <i class="fa fa-fw {{ trans('forms.create_user_icon_email') }}" aria-hidden="true"></i>
                                            </label>
                                        </div>
                                    </div>
                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group  has-feedback row {{ $errors->has('phone_number') ? ' has-error ' : '' }}">
                                {!! Form::label('phone_number', trans('Phone number'), array('class' => 'col-md-3 control-label')); !!}
                                <div class="col-md-9">
                                    <div class="input-group">
                                        {!! Form::text('phone_number', $user->tel, array('id' => 'phone_number', 'class' => 'form-control', 'placeholder' => trans('Phone number'))) !!}
                                        <div class="input-group-append">
                                            <label class="input-group-text" for="phone_number">
                                                <i class="fa fa-fw {{ trans('fa-phone') }}" aria-hidden="true"></i>
                                            </label>
                                        </div>
                                    </div>
                                    @if ($errors->has('phone_number'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('phone_number') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>


                            <div style="" class="form-group has-feedback row {{ $errors->has('role') ? ' has-error ' : '' }}">

                                {!! Form::label('role', trans('forms.create_user_label_role'), array('class' => 'col-md-3 control-label')); !!}

                                <div class="col-md-9">
                                    <div class="input-group">
                                        <select class="custom-select form-control" id="select_" name="role" id="role">
                                            @if ($roles)
                                                @foreach($roles as $role)
                                                    @if($currentRole == $role->id)
                                                        <option value="{{ $role->id }}" {{ $currentRole == $role->id ? 'selected="selected"' : '' }}>{{ $role->name }}</option>
                                                        @break
                                                    @endif
                                                @endforeach
                                            @endif
                                        </select>
                                        <div class="input-group-append">
                                            <label class="input-group-text" for="role">
                                                <i class="{{ trans('forms.create_user_icon_role') }}" aria-hidden="true"></i>
                                            </label>
                                        </div>
                                    </div>
                                    @if ($errors->has('role'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('role') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            @if($currentRole==2) 
                            <div class="form-group has-feedback row establishment_Of_Prof {{ $errors->has('establishment_prof') ? ' has-error ' : '' }}">
                                {!! Form::label('establishment_prof', trans('Establishment'), array('class' => 'col-md-3 control-label')); !!}
                                <div class="col-md-9">
                                    <div class="input-group">
                                        {!! Form::text('establishment_prof', $user->establishment_prof, array('id' => 'establishment_prof', 'class' => 'form-control', 'placeholder' => trans('Establishment'))) !!}
                                        <div class="input-group-append">
                                            <label class="input-group-text" for="establishment_prof">
                                                <i class="fa fa-fw fa-building" aria-hidden="true"></i>
                                            </label>
                                        </div>
                                    </div>
                                    @if($errors->has('establishment_prof'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('establishment_prof') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            @endif

                            <div class="pw-change-container">
                                <div class="form-group has-feedback row {{ $errors->has('password') ? ' has-error ' : '' }}">

                                    {!! Form::label('password', trans('forms.create_user_label_password'), array('class' => 'col-md-3 control-label')); !!}

                                    <div class="col-md-9">
                                        <div class="input-group">
                                            {!! Form::password('password', array('id' => 'password', 'class' => 'form-control ', 'placeholder' => trans('forms.create_user_ph_password'))) !!}
                                            <div class="input-group-append">
                                                <label class="input-group-text" for="password">
                                                    <i class="fa fa-fw {{ trans('forms.create_user_icon_password') }}" aria-hidden="true"></i>
                                                </label>
                                            </div>
                                        </div>
                                        @if ($errors->has('password'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group has-feedback row {{ $errors->has('password_confirmation') ? ' has-error ' : '' }}">

                                    {!! Form::label('password_confirmation', trans('forms.create_user_label_pw_confirmation'), array('class' => 'col-md-3 control-label')); !!}

                                    <div class="col-md-9">
                                        <div class="input-group">
                                            {!! Form::password('password_confirmation', array('id' => 'password_confirmation', 'class' => 'form-control', 'placeholder' => trans('forms.create_user_ph_pw_confirmation'))) !!}
                                            <div class="input-group-append">
                                                <label class="input-group-text" for="password_confirmation">
                                                    <i class="fa fa-fw {{ trans('forms.create_user_icon_pw_confirmation') }}" aria-hidden="true"></i>
                                                </label>
                                            </div>
                                        </div>
                                        @if ($errors->has('password_confirmation'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('password_confirmation') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            @if($currentRole==3)    

                            <div class="">
                                
                                {{-- -------------formation------------- --}}
                                <div class="border-bottom m-3 "></div>
                                <h5 style="font-family: Georgia, serif" class="mb-4 ">
                                    {{trans('Formation :')}}
                                </h5>
                            
                             
                                <div class="form-row d-flex justify-content-center formation_class" >
                                    <div class="form-group col-md-4 has-feedback row {{ $errors->has('type_formation') ? ' has-error ' : '' }}">
                                        {!! Form::label('type_formation', trans('Type of formations :'), array('class' => 'col-md-auto control-label')); !!}
                                        <br/>
                                        <div class="col-md-12">
                                            <div class="input-group">
                                                <select class="custom-select form-control select_TF" required="required" name="type_formation" id="select__" >
                                                    
        
                                                    @if ($types_formations)
                                                        @foreach($types_formations as $type_form)
                                                            @if($formation_student->formation_type==$type_form->type)
                                                                <option value="{{ $type_form->type }}" selected >{{ $type_form->type }}</option>
                                                            @else
                                                                <option value="{{ $type_form->type }}" >{{ $type_form->type }}</option>
                                                            @endif                                                    
                                                        @endforeach
                                                    @endif
                                                </select>                                               
                                                
                                                
                                            </div>
                                        </div>
                                            @if($errors->has('type_formation'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('type_formation') }}</strong>
                                                </span>
                                            @endif
                                    </div>
                                    
                                    <div class="form-group col-md-4 has-feedback row {{ $errors->has('formations_names') ? ' has-error ' : '' }}">
                                        {!! Form::label('formations_names', trans('Formations Names :'), array('class' => 'col-md-auto control-label')); !!}
                                        <br/>
                                        <div class="col-md-12 ">
                                            <div class="select_Fname_load_in">
                                                <div class="input-group select_Fname_load">
                                                    
                                                    @php
                                                        
                                                        $formations_names=[];
                                                        if(!empty($_COOKIE['type_formation']))
                                                            $formations_names=DB::select("select id,name from formations where type = '".$_COOKIE['type_formation']."'")
                                                    @endphp
                                                    
                                                    <select class="custom-select form-control select_Fname" required="required" name="formations_names" id="select__" >
                                                       
                                                        @if ($formations_names)
                                                        
                                                            @foreach($formations_names as $formations_)
                                                                
                                                                @if($formation_student->formation_name==$formations_->name)
                                                                    
                                                                    <option value="{{ $formations_->id }}" selected >{{ $formations_->name }}</option>
                                                                @else    
                                                                    <option value="{{ $formations_->id }}" >{{ $formations_->name }}</option>
                                                                @endif 
                                                            @endforeach
                                                        @endif
                                                    </select>                                               
                                                    
                                                    
                                                </div>
                                            </div>
                                                @if($errors->has('formations_names'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('formations_names') }}</strong>
                                                    </span>
                                                @endif
                                            
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4 has-feedback row  {{ $errors->has('branche_formation') ? ' has-error ' : '' }}">
                                        {!! Form::label('branches_formation', trans('Branches of formation : '), array('class' => 'col-md-auto control-label')); !!}
                                        <br/>
                                        <div class="col-md-12">
                                            <div class="select_BrFname_load">
                                                <div class="input-group select_BrFname">
                                                    
                                                    @php
                                                        $branches_formation=[];
                                                        if(!empty($_COOKIE['FormationName']))
                                                            $branches_formation=DB::select("select id_BrF,name from branches_formations where id_formation = '".$_COOKIE['FormationName']."'")
                                                    @endphp
                                                    
                                                    <select class="custom-select form-control brName" required="required" name="branches_formation" id="select__" >
                                                        
                                                        @if ($branches_formation==[])                                                    
                                                            <option value="" selected disabled >{{ trans('No branche found') }}</option>
                                                        @else
                                                            @foreach($branches_formation as $branche_form)
                                                                @if($formation_student->formation_branche==$branche_form->name)
                                                                    <option value="{{ $branche_form->id_BrF }}" selected >{{ $branche_form->name }}</option>
                                                                @else
                                                                    <option value="{{ $branche_form->id_BrF }}" >{{ $branche_form->name }}</option>
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    </select>                                               
                                                    
                                                    
                                                </div>
                                            </div>
                                                @if($errors->has('branches_formation'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('branches_formation') }}</strong>
                                                    </span>
                                                @endif
                                            
                                        </div>
                                    </div>
                                </div>                                                    
                                {{-- ----------------------------------- --}}
                                


                                <div class="border-bottom  m-3"></div>
                                <h5 style="font-family: Georgia, serif" class="mb-4" >
                                    {{trans('Personnal informations :')}}
                                </h5>
                                
                                

                                <div class="form-row d-flex justify-content-center">
                                    <div class="form-group col-md-6  d-flex justify-content-center  has-feedback row {{ $errors->has('CNE') ? ' has-error ' : '' }}">
                                        {!! Form::label('CNE', trans('CNE'), array('class' => 'col-md-10 control-label')); !!}
                                        <br/>
                                        <div class="col-md-10">
                                            <div class="input-group">
                                                {!! Form::text('CNE', $user->CNE, array('id' => 'CNE', 'class' => 'form-control', 'placeholder' => trans('CNE'))) !!}
                                                <div class="input-group-append">
                                                    <label class="input-group-text" for="CNE">
                                                        <i class="fa fa-fw fa-user-circle" aria-hidden="true"></i>
                                                    </label>
                                                </div>
                                            </div>
                                            @if ($errors->has('CNE'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('CNE') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6  d-flex justify-content-center has-feedback row {{ $errors->has('CIN') ? ' has-error ' : '' }}">
                                        {!! Form::label('CIN', trans('CIN'), array('class' => 'col-md-10 control-label')); !!}
                                        <br/>
                                        <div class="col-md-10">
                                            <div class="input-group">
                                                {!! Form::text('CIN', $user->CIN, array('id' => 'CIN', 'class' => 'form-control', 'placeholder' => trans('CIN'))) !!}
                                                <div class="input-group-append">
                                                    <label class="input-group-text" for="CIN">
                                                        <i class="fa fa-fw fa-user-circle" aria-hidden="true"></i>
                                                    </label>
                                                </div>
                                            </div>
                                            @if ($errors->has('CIN'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('CIN') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row d-flex justify-content-center">
                                    <div class="form-group col-md-6  d-flex justify-content-center has-feedback row {{ $errors->has('date_birth') ? ' has-error ' : '' }}">
                                        {!! Form::label('date_birth', trans('Date birth'), array('class' => 'col-md-10 control-label')); !!}
                                        <br/>
                                        <div class="col-md-10">
                                            <div class="input-group">
                                                {!! Form::date('date_birth', $user->date_birth, array('id' => 'date_birth', 'class' => 'form-control')) !!}
                                                <div class="input-group-append">
                                                    <label class="input-group-text" for="date_birth">
                                                        <i class="fa fa-fw fa-calendar" aria-hidden="true"></i>
                                                    </label>
                                                </div>
                                            </div>
                                            @if ($errors->has('date_birth'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('date_birth') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6 d-flex justify-content-center has-feedback row {{ $errors->has('place_birth') ? ' has-error ' : '' }}">
                                        {!! Form::label('place_birth', trans('Place birth'), array('class' => 'col-md-10 control-label')); !!}
                                        <br/>
                                        <div class="col-md-10">
                                            <div class="input-group">
                                                {!! Form::text('place_birth', $user->place_birth, array('id' => 'place_birth', 'class' => 'form-control', 'placeholder' => trans('Place birth'))) !!}
                                                <div class="input-group-append">
                                                    <label class="input-group-text" for="place_birth">
                                                        <i class="fa fa-fw fa-map-marker" aria-hidden="true"></i>
                                                    </label>
                                                </div>
                                            </div>
                                            @if ($errors->has('place_birth'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('place_birth') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                
                                <div class="border-bottom m-3"></div>
                                <h5 style="font-family: Georgia, serif" class="mb-4">
                                    {{trans('Baccalaureat :')}}
                                </h5>
                                
                                 

                                <div class="form-row d-flex justify-content-center">
                                    <div class="form-group col-md-6 d-flex justify-content-center has-feedback row {{ $errors->has('Serie') ? ' has-error ' : '' }}">
                                        {!! Form::label('Serie', trans('Serie'), array('class' => 'col-md-10 control-label')); !!}
                                        <br/>
                                        <div class="col-md-10">
                                            <div class="input-group">
                                                {!! Form::text('serie', $user->serie, array('id' => 'serie', 'class' => 'form-control', 'placeholder' => trans('Serie'))) !!}
                                                <div class="input-group-append">
                                                    <label class="input-group-text" for="Serie">
                                                        <i class="fa fa-fw fa-server" aria-hidden="true"></i>
                                                    </label>
                                                </div>
                                            </div>
                                            @if ($errors->has('Serie'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('Serie') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6 d-flex justify-content-center has-feedback row {{ $errors->has('academy') ? ' has-error ' : '' }}">
                                        {!! Form::label('academy', trans('Academy'), array('class' => 'col-md-10 control-label')); !!}
                                        <br/>
                                        <div class="col-md-10">
                                            <div class="input-group">
                                                {!! Form::text('academy', $user->academy, array('id' => 'academy', 'class' => 'form-control', 'placeholder' => trans('academy'))) !!}
                                                <div class="input-group-append">
                                                    <label class="input-group-text" for="academy">
                                                        <i class="fa fa-fw fa-university" aria-hidden="true"></i>
                                                    </label>
                                                </div>
                                            </div>
                                            @if ($errors->has('academy'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('academy') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row d-flex justify-content-center">

                                    <div class="form-group col-md-6 d-flex justify-content-center has-feedback row {{ $errors->has('establishment') ? ' has-error ' : '' }}">
                                        {!! Form::label('establishment', trans('Establishment'), array('class' => 'col-md-10 control-label')); !!}
                                        <br/>
                                        <div class="col-md-10">
                                            <div class="input-group">
                                                {!! Form::text('establishment1', $user->establishment_1, array('id' => 'establishment1', 'class' => 'form-control', 'placeholder' => trans('establishment'))) !!}
                                                <div class="input-group-append">
                                                    <label class="input-group-text" for="establishment">
                                                        <i class="fa fa-fw fa-building" aria-hidden="true"></i>
                                                    </label>
                                                </div>
                                            </div>
                                            @if ($errors->has('establishment'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('establishment') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6  d-flex justify-content-center has-feedback row {{ $errors->has('bac_year') ? ' has-error ' : '' }}">
                                        {!! Form::label('bac_year', trans('Year'), array('class' => 'col-md-10 control-label')); !!}
                                        <br/>
                                        <div class="col-md-10">
                                            <div class="input-group">
                                                {!! Form::number('bac_year', $user->bac_year, array('id' => 'bac_year', 'class' => 'form-control' ,'placeholder'=> trans('Example: 2016'))) !!}
                                                <div class="input-group-append">
                                                    <label class="input-group-text" for="bac_year">
                                                        <i class="fa fa-fw fa-calendar" aria-hidden="true"></i>
                                                    </label>
                                                </div>
                                            </div>
                                            @if ($errors->has('bac_year'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('bac_year') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="border-bottom  m-3"></div>
                                <h5 style="font-family: Georgia, serif" class="mb-4" >
                                    {{trans('Formation Academemique :')}}
                                </h5>
                                
                                  

                                <div class="form-row d-flex justify-content-center">
                                    <div class="form-group col-md-4 has-feedback row {{ $errors->has('diploma') ? ' has-error ' : '' }}">
                                        {!! Form::label('diploma1', trans('Diploma'), array('class' => 'col-md-12 control-label')); !!}
                                        <br/>
                                        <div class="col-md-12">
                                            <div class="input-group">
                                                {!! Form::text('diploma', $user->diploma, array('id' => 'diploma', 'class' => 'form-control', 'placeholder' => trans('diploma'))) !!}
                                                <div class="input-group-append">
                                                    <label class="input-group-text" for="diploma">
                                                        <i class="fa fa-fw fa-graduation-cap " aria-hidden="true"></i>
                                                    </label>
                                                </div>
                                            </div>
                                            @if ($errors->has('diploma'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('diploma') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4 has-feedback row {{ $errors->has('date_obtained') ? ' has-error ' : '' }}">
                                        {!! Form::label('date_obtained', trans('Date obtained'), array('class' => 'col-md-12 control-label')); !!}
                                        <br/>
                                        <div class="col-md-12">
                                            <div class="input-group">
                                                {!! Form::date('date_obtained', $user->date_obtained, array('id' => 'date_obtained', 'class' => 'form-control')) !!}
                                                <div class="input-group-append">
                                                    <label class="input-group-text" for="date_obtained">
                                                        <i class="fa fa-fw fa-calendar" aria-hidden="true"></i>
                                                    </label>
                                                </div>
                                            </div>
                                            @if ($errors->has('date_obtained'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('date_obtained') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4 has-feedback row {{ $errors->has('establishment') ? ' has-error ' : '' }}">
                                        {!! Form::label('establishment', trans('Establishment'), array('class' => 'col-md-12 control-label')); !!}
                                        <br/>
                                        <div class="col-md-12">
                                            <div class="input-group">
                                                {!! Form::text('establishment2', $user->establishment_2, array('id' => 'establishment2', 'class' => 'form-control', 'placeholder' => trans('establishment'))) !!}
                                                <div class="input-group-append">
                                                    <label class="input-group-text" for="establishment">
                                                        <i class="fa fa-fw fa-building" aria-hidden="true"></i>
                                                    </label>
                                                </div>
                                            </div>
                                            @if ($errors->has('establishment'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('establishment') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="border-bottom m-3"></div>
                                <h5 style="font-family: Georgia, serif" class="mb-4" >
                                    {{trans('Experience professionnelle :')}}
                                </h5> 
                                <div class="form-row d-flex justify-content-center mb-4">

                                    <div class="form-group col-md-6 has-feedback row {{ $errors->has('employer_organization') ? ' has-error ' : '' }}">
                                        {!! Form::label('employer_organization', trans('Employer organization'), array('class' => 'col-md-12 control-label')); !!}
                                        <br/>
                                        <div class="col-md-12">
                                            <div class="input-group">
                                                {!! Form::text('employer_organization', $user->employer_organization, array('id' => 'employer_organization', 'class' => 'form-control', 'placeholder' => trans('employer organization'))) !!}
                                                <div class="input-group-append">
                                                    <label class="input-group-text" for="employer_organization">
                                                        <i class="fa fa-fw fa-building" aria-hidden="true"></i>
                                                    </label>
                                                </div>
                                            </div>
                                            @if ($errors->has('employer_organization'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('employer_organization') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6 has-feedback row {{ $errors->has('poste occupied') ? ' has-error ' : '' }}">
                                        {!! Form::label('poste_occupied', trans('Poste occupied'), array('class' => 'col-md-12 control-label')); !!}
                                        <br/>
                                        <div class="col-md-12">
                                            <div class="input-group">
                                                {!! Form::text('poste_occupied', $user->poste_occupied, array('id' => 'poste_occupied', 'class' => 'form-control', 'placeholder' => trans('poste occupied'))) !!}
                                                <div class="input-group-append">
                                                    <label class="input-group-text" for="poste_occupied">
                                                        <i class="fa fa-fw fa-briefcase" aria-hidden="true"></i>
                                                    </label>
                                                </div>
                                            </div>
                                            @if ($errors->has('poste_occupied'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('poste_occupied') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    
                                </div>
                                
                                <div class="border-bottom m-3"></div>
                                <h5 style="font-family: Georgia, serif" class="mb-4" >
                                    {{trans('Payement :')}}
                                </h5> 
                                
                                <div class="form-row d-flex justify-content-center">

                                    <div class="form-group col-md-6 has-feedback row {{ $errors->has('s1_amount') ? ' has-error ' : '' }}">
                                        {!! Form::label('s1_amount', trans('Amount S1 :'), array('class' => 'col-md-12 control-label')); !!}
                                        <br/>
                                        <div class="col-md-12">
                                            <div class="input-group">
                                                {!! Form::number('s1_amount', $user->s1_amount, array('step' => '0.01' ,'id' => 's1_amount', 'class' => 'form-control', 'placeholder' => trans('Amount S1'))) !!}
                                                <div class="input-group-append">
                                                    <label class="input-group-text" for="s1_amount">
                                                        <i class="fa fa-fw fa-money" aria-hidden="true"></i>
                                                    </label>
                                                </div>
                                            </div>
                                            @if ($errors->has('s1_amount'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('s1_amount') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6 has-feedback row {{ $errors->has('s2_amount') ? ' has-error ' : '' }}">
                                        {!! Form::label('s2_amount', trans('Amount S2 : '), array('class' => 'col-md-12 control-label')); !!}
                                        <br/>
                                        <div class="col-md-12">
                                            <div class="input-group">
                                                {!! Form::number('s2_amount', $user->s2_amount, array('step' => '0.01' ,'id' => 's2_amount', 'class' => 'form-control', 'placeholder' => trans('Amount S2'))) !!}
                                                <div class="input-group-append">
                                                    <label class="input-group-text" for="s2_amount">
                                                        <i class="fa fa-fw fa-money" aria-hidden="true"></i>
                                                    </label>
                                                </div>
                                            </div>
                                            @if ($errors->has('s2_amount'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('s2_amount') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="form-row d-flex justify-content-center ">

                                    <div class="form-group col-md-6 has-feedback row {{ $errors->has('s1_receipt') ? ' has-error ' : '' }}">
                                        {!! Form::label('s1_receipt', trans('S1 Receipt :'), array('class' => 'col-md-12 control-label')); !!}
                                        <br/>
                                        <div class="col-md-12">
                                            <div class="input-group">
                                                {!! Form::file('s1_receipt', NULL, array('id' => 's1_receipt', 'class' => 'form-control', 'placeholder' => trans('S1 Receipt'))) !!}
                                                
                                            </div>
                                            <br/>
                                            @if($user->s1_receipt)
                                                <img src="{{asset("custom_symlink/".$user->s1_receipt)}}" class="img-thumbnail payment_img ml-5" style="width:200px; height:200px;" >
                                                
                                            @endif
                                            @if ($errors->has('s1_receipt'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('s1_receipt') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6 has-feedback row {{ $errors->has('s2_receipt') ? ' has-error ' : '' }}">
                                        {!! Form::label('s2_receipt', trans('S2 Receipt :'), array('class' => 'col-md-12 control-label')); !!}
                                        <br/>
                                        <div class="col-md-12">
                                            <div class="input-group">
                                                {!! Form::file('s2_receipt', NULL, array('id' => 's2_receipt', 'class' => 'form-control', 'placeholder' => trans('S2 Receipt'))) !!}
                                                
                                            </div>
                                            <br>
                                            @if($user->s2_receipt)
                                                <img src="{{asset("custom_symlink/".$user->s2_receipt)}}" class="img-thumbnail payment_img ml-5" style="width:200px; height:200px;" >
                                            @endif
                                            @if ($errors->has('s2_receipt'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('s2_receipt') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="border-bottom mr-5 ml-5  mb-3"></div>

                                <div class="form-row d-flex justify-content-center">

                                    <div class="form-group col-md-6 has-feedback row {{ $errors->has('s3_amount') ? ' has-error ' : '' }}">
                                        {!! Form::label('s3_amount', trans('Amount S3 :'), array('class' => 'col-md-12 control-label')); !!}
                                        <br/>
                                        <div class="col-md-12">
                                            <div class="input-group">
                                                {!! Form::number('s3_amount', $user->s3_amount, array('step' => '0.01' ,'id' => 's3_amount', 'class' => 'form-control', 'placeholder' => trans('Amount S3'))) !!}
                                                <div class="input-group-append">
                                                    <label class="input-group-text" for="s3_amount">
                                                        <i class="fa fa-fw fa-money" aria-hidden="true"></i>
                                                    </label>
                                                </div>
                                            </div>
                                            @if ($errors->has('s3_amount'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('s3_amount') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6 has-feedback row {{ $errors->has('s4_amount') ? ' has-error ' : '' }}">
                                        {!! Form::label('s4_amount', trans('Amount S4 : '), array('class' => 'col-md-12 control-label')); !!}
                                        <br/>
                                        <div class="col-md-12">
                                            <div class="input-group">
                                                {!! Form::number('s4_amount', $user->s4_amount, array('step' => '0.01' ,'id' => 's4_amount', 'class' => 'form-control', 'placeholder' => trans('Amount S4'))) !!}
                                                <div class="input-group-append">
                                                    <label class="input-group-text" for="s4_amount">
                                                        <i class="fa fa-fw fa-money" aria-hidden="true"></i>
                                                    </label>
                                                </div>
                                            </div>
                                            @if ($errors->has('s4_amount'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('s4_amount') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="form-row d-flex justify-content-center ">

                                    <div class="form-group col-md-6 has-feedback row {{ $errors->has('s3_receipt') ? ' has-error ' : '' }}">
                                        {!! Form::label('s3_receipt', trans('S3 Receipt :'), array('class' => 'col-md-12 control-label')); !!}
                                        <br/>
                                        <div class="col-md-12">
                                            <div class="input-group">
                                                {!! Form::file('s3_receipt', NULL, array('id' => 's3_receipt', 'class' => 'form-control', 'placeholder' => trans('S3 Receipt'))) !!}
                                                
                                            </div>
                                            <br/>
                                            @if($user->s3_receipt)
                                                <img src="{{asset("custom_symlink/".$user->s3_receipt)}}" class="img-thumbnail payment_img ml-5" style="width:200px; height:200px;" >
                                            @endif
                                            @if ($errors->has('s3_receipt'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('s3_receipt') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6 has-feedback row {{ $errors->has('s4_receipt') ? ' has-error ' : '' }}">
                                        {!! Form::label('s4_receipt', trans('S4 Receipt :'), array('class' => 'col-md-12 control-label')); !!}
                                        <br/>
                                        <div class="col-md-12">
                                            <div class="input-group">
                                                {!! Form::file('s4_receipt', NULL, array('id' => 's4_receipt', 'class' => 'form-control', 'placeholder' => trans('S4 Receipt'))) !!}
                                            </div>
                                            <br/>
                                            @if($user->s4_receipt)
                                                <img src="{{asset("custom_symlink/".$user->s4_receipt)}}" class="img-thumbnail payment_img ml-5" style="width:200px; height:200px;" >
                                            @endif
                                            @if ($errors->has('s4_receipt'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('s4_receipt') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                            </div>
                            @endif
                            
                            <div class="row">
                                <div class="col-12 col-sm-4 mb-2">
                                    <a href="#" class="btn btn-outline-secondary btn-block btn-change-pw mt-3" title="{{ trans('forms.change-pw')}} ">
                                        <i class="fa fa-fw fa-lock" aria-hidden="true"></i>
                                        <span></span> {!! trans('forms.change-pw') !!}
                                    </a>
                                </div>
                                <div class="col-12 col-sm-4 mb-2 other_info" style="display:none;">
                                    <a href="#" class="btn btn-info btn-block mt-3" title="{{ trans('change other informations')}} ">
                                        <i class="fa fa-fw fa-info" aria-hidden="true"></i>
                                        <span></span> {!! trans('change other informations') !!}
                                    </a>
                                </div>
                                <div class="col-12 col-sm-4">
                                    {!! Form::button(trans('forms.save-changes'), array('class' => 'btn btn-success btn-block margin-bottom-1 mt-3 mb-2 btn-save','type' => 'button', 'data-toggle' => 'modal', 'data-target' => '#confirmSave', 'data-title' => trans('modals.edit_user__modal_text_confirm_title'), 'data-message' => trans('modals.edit_user__modal_text_confirm_message'))) !!}
                                </div>
                            </div>
                        {!! Form::close() !!}
                    </div>

                </div>
            </div>
        </div>
    </div>

    @include('modals.modal-save')
    @include('modals.modal-delete')

@endsection

@section('footer_scripts')
  @include('scripts.delete-modal-script')
  @include('scripts.save-modal-script')
  @include('scripts.check-changed')

  <script>
    
        // var $other_info = $(".change-continer2" ) ;
        
        

        // $('#tranche').change(function(evt) {
        //     $(".btn-save").show();
        // });
        // $('#tranche1').change(function(evt) {
        //     $(".btn-save").show();
        // }); 
            

       
  </script>

  {{-- select and cookies --}}
  <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" rossorigin= "anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.js"></script>

<script>
    $( document ).ready(function(){
        
        $.cookie("type_formation", $('.select_TF').val() );
        $(".select_Fname_load_in").load(location.href + " .select_Fname_load");
        setTimeout(function(){
             $.cookie("FormationName", $('.select_Fname').val() );
             $(".select_BrFname_load").load(location.href + " .select_BrFname");
        }, 1500);

    });

    $('form').submit(function() {
        $('.select_TF').remove();
        $('.select_Fname').remove();
    });
    
    
    $('.select_TF').on('change', function() {
        $.removeCookie('type_formation');
        $.removeCookie('FormationName');
        $.cookie("type_formation", this.value );
        $(".select_Fname_load_in").load(location.href + " .select_Fname_load");
        
        $(".select_BrFname_load").load(location.href + " .select_BrFname");
        
    });

    $('.container').on('change','#select__', function() {
        $(".btn-save").show();
    });

    

    $('.container').on('change','.select_Fname', function() {
        $(".btn-save").show();
        $.cookie("FormationName", this.value );
        $(".select_BrFname_load").load(location.href + " .select_BrFname");

        // alert($.cookie('FormationName'));

    });
    
  </script>



@endsection
