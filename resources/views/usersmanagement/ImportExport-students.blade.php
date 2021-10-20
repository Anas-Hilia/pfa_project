@extends('layouts.app')

@section('template_title')
    {!! trans('Import and Export Students') !!}
@endsection

@section('template_fastload_css')

@endsection

@section('template_linked_css')
    <style type="text/css">
        
        .change-continer2 {
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
                            {!! trans('Import and Export Students') !!}
                            <div class="pull-right">
                                <a href="{{ route('students') }}" class="btn btn-light btn-sm float-right" data-toggle="tooltip" data-placement="left" title="{{ trans('back to students') }}">
                                    <i class="fa fa-fw fa-reply-all" aria-hidden="true"></i>
                                    {!! trans('back to students') !!}
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        {!! Form::open(array('route' => 'students_import', 'method' => 'POST','enctype' => 'multipart/form-data', 'files' => true , 'role' => 'form', 'class' => 'needs-validation')) !!}

                            {!! csrf_field() !!}

                                <h5 style="font-family: Georgia, serif" class="mb-4" >
                                    {{trans('Import Data :')}}
                                </h5> 
                                <div class="form-row d-flex justify-content-center ">

                                    <div class="form-group col-md-6 has-feedback row {{ $errors->has('students_file') ? ' has-error ' : '' }}">
                                        {!! Form::label('students_file', trans('Import data :'), array('class' => 'col-md-12 control-label')); !!}
                                        <br/>
                                        <div class="col-md-12">
                                            <div class="input-group">
                                                {!! Form::file('students_file', NULL, array('id' => 'students_file', 'class' => 'form-control')) !!}
                                                
                                            </div>
                                            @if ($errors->has('students_file'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('students_file') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    
                                </div>
                                
                            
                            
                            <div class=" d-flex justify-content-center" >
                                
                                <div class="col-12 col-sm-4 d-flex justify-content-center">

                                    {!! Form::button(trans('Import'), array('class' => 'btn btn-outline-success btn-block margin-bottom-1 mt-3 mb-2 btn-save','style' => 'width:150px;','type' => 'submit','data-toggle' => 'modal', 'data-target' => '#confirmSave', 'data-title' => trans('modals.create_user__modal_text_confirm_title'), 'data-message' => trans('modals.create_user__modal_text_confirm_message'))) !!}
                                </div>
                            </div>
                        {!! Form::close() !!}
                        <div class="border-bottom m-3"></div>
                        <h5 style="font-family: Georgia, serif" class="mb-4" >
                            {{trans('Export Data :')}}
                        </h5> 
                        <div class=" d-flex justify-content-center" >
                                
                            <div class="col-12 col-sm-4 d-flex justify-content-center">
                                <a href="{{URL::TO('/students/Export')}}" id="" class="btn btn-outline-primary btn-block margin-bottom-1 mt-3 mb-2" style="width: 150px" href="#" role="button"> <i class="fa fa-file-excel-o" aria-hidden="true"></i> Export</i></a>
                            </div>
                            
                        </div>
                        <div class="border-bottom m-3"></div>

                        <h5 style="font-family: Georgia, serif" class="mb-4" >
                            {{trans('Export Students Payment :')}}
                        </h5> 
                        <div class=" d-flex justify-content-center" >
                                
                            <div class="col-12 col-sm-4 d-flex justify-content-center">
                                <a href="{{URL::TO('/students/ShortExport')}}" id="" class="btn btn-outline-primary btn-block margin-bottom-1 mt-3 mb-2" style="width: 150px" href="#" role="button"> <i class="fa fa-file-excel-o" aria-hidden="true"></i> Export</i></a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection

@section('footer_scripts')

@endsection
