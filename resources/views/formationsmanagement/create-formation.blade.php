@extends('layouts.app')

@section('template_title')
    {!! trans('create-new-formation') !!}
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
                            {!! trans('Create-new-formation') !!}
                            <div class="pull-right">
                                <a href="{{ url('/formations') }}" class="btn btn-light btn-sm float-right" data-toggle="tooltip" data-placement="left" title="{{ trans('formationsmanagement.tooltips.back-formations') }}">
                                    <i class="fa fa-fw fa-reply-all" aria-hidden="true"></i>
                                    {!! trans('back to formations') !!}
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        {!! Form::open(array('route' => 'formations.store', 'method' => 'post', 'role' => 'form', 'class' => 'needs-validation')) !!}

                            {!! csrf_field() !!}
                            

                            <div class="form-group has-feedback row {{ $errors->has('name') ? ' has-error ' : '' }}">
                                {!! Form::label('name', trans('Name'), array('class' => 'col-md-3 control-label')); !!}
                                <div class="col-md-9">
                                    <div class="input-group">
                                        {!! Form::textarea('name', NULL, array('id' => 'name','rows'=>'2', 'class' => 'form-control', 'placeholder' => trans('Name'))) !!}
                                        
                                    </div>
                                    @if ($errors->has('name'))
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
                                        {!! Form::textarea('description', NULL, array('id' => 'description','rows'=>'3', 'class' => 'form-control', 'placeholder' => trans('Description'))) !!}
                                        
                                    </div>
                                    @if ($errors->has('description'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('description') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group has-feedback row {{ $errors->has('type') ? ' has-error ' : '' }}">
                                {!! Form::label('type', trans('Type'), array('class' => 'col-md-3 control-label')); !!}
                                <div class="col-md-9">
                                    <div class="input-group">
                                        <select class="custom-select form-control" id="" name="type" id="type">
                                            <option selected  disabled>{{ trans('select type') }}</option>
                                            <option value="LUS" >{{trans('Licence d’Université Spécialisé ( LUS )')}}</option>   
                                            <option value="MUS" >{{trans('Master d’Université Spécialisé ( MUS )')}}</option>    

                                        </select>
                                        
                                    </div>
                                    @if ($errors->has('type'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('type') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group has-feedback row {{ $errors->has('nbr_max') ? ' has-error ' : '' }}">
                                {!! Form::label('nbr_max', trans('Nombre max des students'), array('class' => 'col-md-3 control-label')); !!}
                                <div class="col-md-9">
                                    <div class="input-group">
                                        {!! Form::number('nbr_max', NULL, array('id' => 'nbr_max', 'class' => 'form-control', 'placeholder' => trans('Nombre max des students'))) !!}
                                        
                                    </div>
                                    @if ($errors->has('nbr_max'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('nbr_max') }}</strong>
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
