@extends('layouts.app')

@section('template_title')
    {!! trans('Editing-formation', ['name' => $formation->name]) !!}
@endsection

@section('template_linked_css')
    <style type="text/css">
        .btn-save,
        .pw-change-container {
            display: none;
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
                            {!! trans('Editing-formation', ['name' => $formation->name]) !!}
                            <div class="pull-right">
                                <a href="{{ route('formations') }}" class="btn btn-light btn-sm float-right" data-toggle="tooltip" data-placement="top" title="{{ trans('formationsmanagement.tooltips.back-formations') }}">
                                    <i class="fa fa-fw fa-reply-all" aria-hidden="true"></i>
                                    {!! trans('back to formations') !!}
                                </a>
                                <a href="{{ url('/formations/' . $formation->id) }}" class="btn btn-light btn-sm float-right" data-toggle="tooltip" data-placement="left" title="{{ trans('formationsmanagement.tooltips.back-formations') }}">
                                    <i class="fa fa-fw fa-reply" aria-hidden="true"></i>
                                    {!! trans('back to formation') !!}
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        {!! Form::open(array('route' => ['formations.update', $formation->id], 'method' => 'put', 'role' => 'form', 'class' => 'needs-validation')) !!}

                            {!! csrf_field() !!}

                            <div class="form-group has-feedback row {{ $errors->has('name') ? ' has-error ' : '' }}">
                                {!! Form::label('name', trans('Name'), array('class' => 'col-md-3 control-label')); !!}
                                <div class="col-md-9">
                                    <div class="input-group">
                                        {!! Form::textarea('name', $formation->name, array('id' => 'name','rows'=> '2', 'class' => 'form-control', 'placeholder' => trans('Name'))) !!}
                                        
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
                                        {!! Form::textarea('description', $formation->description, array('id' => 'description','rows' => '3', 'class' => 'form-control', 'placeholder' => trans('Description'))) !!}
                                        
                                    </div>
                                    @if($errors->has('description'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('description') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group has-feedback row {{ $errors->has('Type') ? ' has-error ' : '' }}">
                                {!! Form::label('Type', trans('Type'), array('class' => 'col-md-3 control-label')); !!}
                                <div class="col-md-9">
                                    <select class="custom-select form-control" id="" name="type" id="type">
                                        <option disabled>{{ trans('select type') }}</option>
                                        <option value="LUS" @if($formation->type=='LUS') selected @endif > {{trans('Licence d’Université Spécialisé ( LUS )')}} </option>   
                                        <option value="MUS" @if($formation->type=='MUS') selected @endif > {{trans('Master d’Université Spécialisé ( MUS )')}} </option>    

                                    </select>
                                    @if($errors->has('Type'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('Type') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group has-feedback row {{ $errors->has('nbr_max') ? ' has-error ' : '' }}">
                                {!! Form::label('nbr_max', trans('Nombre max'), array('class' => 'col-md-3 control-label')); !!}
                                <div class="col-md-9">
                                    <div class="input-group">
                                        {!! Form::number('nbr_max', $formation->nbr_max, array('id' => 'nbr_max', 'class' => 'form-control', 'placeholder' => trans('Nombre max des students'))) !!}
                                        
                                    </div>
                                    @if($errors->has('nbr_max'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('nbr_max') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            
                            <div class="row">
                                <div class="col-12 col-sm-6 mb-2">
                                    
                                </div>
                                <div class="col-12 col-sm-6">
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
@endsection
