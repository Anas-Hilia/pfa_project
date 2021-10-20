@extends('layouts.app')

@section('template_title')
    {!! trans('Editing-brancheF', ['name' => $brancheF->name]) !!}
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
                            {!! trans('Editing Branche of Formation') !!}
                            <div class="pull-right">
                                <a href="{{ route('BranchesFs',$brancheF->id_formation) }}" class="btn btn-light btn-sm float-right" data-toggle="tooltip" data-placement="top" title="{{ trans('brancheFsmanagement.tooltips.back-brancheFs') }}">
                                    <i class="fa fa-fw fa-reply-all" aria-hidden="true"></i>
                                    {!! trans('back to branches') !!}
                                </a>
                                <a href="{{ url('/BranchesFs/' . $brancheF->id_BrF) }}" class="btn btn-light btn-sm float-right" data-toggle="tooltip" data-placement="left" title="{{ trans('brancheFsmanagement.tooltips.back-brancheFs') }}">
                                    <i class="fa fa-fw fa-reply" aria-hidden="true"></i>
                                    {!! trans('back to branche') !!}
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        {!! Form::open(array('route' => ['BranchesFs.update', $brancheF->id_BrF ], 'method' => 'put', 'role' => 'form', 'class' => 'needs-validation')) !!}

                            {!! csrf_field() !!}

                            <div class="form-group has-feedback row {{ $errors->has('name') ? ' has-error ' : '' }}">
                                {!! Form::label('name', trans('Name'), array('class' => 'col-md-3 control-label')); !!}
                                <div class="col-md-9">
                                    <div class="input-group">
                                        {!! Form::textarea('name', $brancheF->name, array('id' => 'name','rows'=> '2', 'class' => 'form-control', 'placeholder' => trans('Name'))) !!}
                                        
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
                                        {!! Form::textarea('description', $brancheF->description, array('id' => 'description','rows' => '3', 'class' => 'form-control', 'placeholder' => trans('Description'))) !!}
                                        
                                    </div>
                                    @if($errors->has('description'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('description') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            
                            <div class="form-group has-feedback row {{ $errors->has('coordinateur') ? ' has-error ' : '' }}">
                                {!! Form::label('coordinateur', trans('Coordinateur'), array('class' => 'col-md-3 control-label')); !!}
                                <div class="col-md-9">
                                    <div class="input-group">
                                        <select class="custom-select form-control" name="coordinateur" id="coordinateur">
                                            <option value="{{ $brancheF->coordinateur }}" >{{ $brancheF->lname .' '. $brancheF->fname }}</option>

                                            @if ($coordinateurs)
                                                @foreach($coordinateurs as $coordinateur)
                                                    
                                                    <option value="{{ $coordinateur->id }}" >{{ $coordinateur->lname .' '. $coordinateur->fname }}</option>
                                                    
                                                @endforeach
                                            @endif
                                        </select>                                        
                                    </div>
                                    @if($errors->has('coordinateur'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('coordinateur') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>  
                            <div class="form-group has-feedback row {{ $errors->has('id_formation') ? ' has-error ' : '' }}">
                                {!! Form::label('id_formation', trans('Formation'), array('class' => 'col-md-3 control-label')); !!}
                                <div class="col-md-9">
                                    <div class="input-group">
                                        
                                        <select class="custom-select form-control" name="id_formation" id="id_formation">
                                            
                                            <option value="{{ $brancheF->id_formation }}" >{{ $brancheF->form_name }}</option>

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
