@extends('layouts.app')

@section('template_title')
    {!! trans('create-new-brancheF') !!}
@endsection

@section('template_fastload_css')
@endsection

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-lg-10 offset-lg-1">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            {!! trans('Create new Branche Formation') !!}
                            <div class="pull-right">
                                <a href="{{ url('/formations') }}" class="btn btn-light btn-sm float-right" data-toggle="tooltip" data-placement="left" title="{{ trans('BranchesFsmanagement.tooltips.back-BranchesFs') }}">
                                    <i class="fa fa-fw fa-reply-all" aria-hidden="true"></i>
                                    {!! trans('back to formations') !!}
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        {!! Form::open(array('route' => 'BranchesFs.store', 'method' => 'post', 'role' => 'form', 'class' => 'needs-validation')) !!}

                            {!! csrf_field() !!}
                            

                            <div class="form-group has-feedback row {{ $errors->has('name') ? ' has-error ' : '' }}">
                                {!! Form::label('name', trans('Name of Branche'), array('class' => 'col-md-3 control-label')); !!}
                                <div class="col-md-9">
                                    <div class="input-group">
                                        {!! Form::textarea('name', NULL, array('id' => 'name','rows'=> '2', 'class' => 'form-control', 'placeholder' => trans('Name'))) !!}
                                        
                                    </div>
                                    @if($errors->has('name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group has-feedback row {{ $errors->has('description') ? ' has-error ' : '' }}">
                                {!! Form::label('description', trans('Description'), array('class' => 'col-md-3 control-label')); !!}
                                <div class="col-md-9">
                                    <div class="input-group">
                                        {!! Form::textarea('description', NULL, array('id' => 'description','rows' => '3', 'class' => 'form-control', 'placeholder' => trans('Description'))) !!}
                                        
                                    </div>
                                    @if($errors->has('description'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('description') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            
                            <div class="form-group has-feedback row {{ $errors->has('coordinatoor') ? ' has-error ' : '' }}">
                                {!! Form::label('coordinator', trans('Coordinator'), array('class' => 'col-md-3 control-label')); !!}
                                <div class="col-md-9">
                                    <div class="input-group">
                                        <select class="custom-select form-control" required="required" name="coordinator" id="coordinator">
                                            @if(Auth::user()->currentUserRole!=2)
                                                <option value="" selected="selected" disabled>{{trans('Coordinator')}}</option>
                                            @endif

                                            @if ($coordinateurs)
                                                @foreach($coordinateurs as $coordinateur)
                                                    
                                                    <option value="{{ $coordinateur->id }}" >{{ $coordinateur->lname .' '. $coordinateur->fname }}</option>
                                                    
                                                @endforeach
                                            @endif
                                        </select>                                        
                                    </div>
                                    @if($errors->has('coordinator'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('coordinator') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>  
                            <div class="form-group has-feedback row {{ $errors->has('id_formation') ? ' has-error ' : '' }}">
                                {!! Form::label('id_formation', trans('Formation'), array('class' => 'col-md-3 control-label')); !!}
                                <div class="col-md-9">
                                    <div class="input-group">
                                        
                                        <select class="custom-select form-control" name="id_formation" id="id_formation">
                                            
                                            <option value="" selected="selected" disabled>Formation</option>

                                            @if ($formations)
                                                @foreach($formations as $formation)
                                                    
                                                    <option value="{{ $formation->id }}" >{{ $formation->name }}</option>
                                                    
                                                @endforeach
                                            @endif
                                        </select>

                                    </div>
                                    @if($errors->has('id_formation'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('id_formation') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>  

                            
                            {!! Form::button(trans('Create'), array('class' => 'btn btn-success margin-bottom-1 mb-1 float-right','type' => 'submit' )) !!}
                        {!! Form::close() !!}
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection

@section('footer_scripts')
@endsection
