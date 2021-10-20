@extends('layouts.app')

@section('template_title')
    {!!trans('showing-deleted-branche-F')!!} {{ $brancheF->name }}
@endsection



@section('content')

    <div class="container">
        <div class="row">
            <div class="col-lg-10 offset-lg-1">
                <div class="card">

                    <div class="card-header bg-danger text-white">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            {!! trans('showing deleted branche') !!}
                            <div class="float-right">
                                <a href="/BranchesFs/deleted/" class="btn btn-light btn-sm float-right" data-toggle="tooltip" data-placement="left" title="{{ trans('back-to-deleted-branches') }}">
                                    <i class="fa fa-fw fa-mail-reply" aria-hidden="true"></i>
                                    {{-- <span class="sr-only"> --}}
                                        {!! trans('back to deleted branches') !!}
                                    {{-- </span> --}}
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row d-flex justify-content-center">
                           
                            <div class="col-sm-4 col-md-6">
                                <h4 class="text-muted margin-top-sm-1 text-center text-left-tablet">
                                    {{ $brancheF->brf_name }}
                                </h4>
                                
                                <div class="text-center text-left-tablet mb-4">
                                    {!! Form::model($brancheF, array('action' => array('SoftDeletesBrancheFsController@update', $brancheF->id_BrF), 'method' => 'PUT', 'class' => 'form-inline')) !!}
                                        {!! Form::button('<i class="fa fa-refresh fa-fw" aria-hidden="true"></i> Restore Branche', array('class' => 'btn btn-success btn-block btn-sm mt-1 mb-1', 'type' => 'submit', 'data-toggle' => 'tooltip', 'title' => 'Restore brancheF')) !!}
                                        {!! Form::close() !!}
                                        {!! Form::model($brancheF, array('action' => array('SoftDeletesBrancheFsController@destroy', $brancheF->id_BrF), 'method' => 'DELETE', 'class' => 'form-inline', 'data-toggle' => 'tooltip', 'title' => 'Permanently Delete brancheF')) !!}
                                        {!! Form::hidden('_method', 'DELETE') !!}
                                        {!! Form::button('<i class="fa fa-trash fa-fw" aria-hidden="true"></i> Delete Branche', array('class' => 'btn btn-danger btn-sm ','type' => 'button', 'style' =>'width: 100%;' ,'data-toggle' => 'modal', 'data-target' => '#confirmDelete', 'data-title' => 'Permanently Delete brancheF', 'data-message' => 'Are you sure you want to permanently delete this brancheF?')) !!}
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </div>

                        <div class="clearfix"></div>
                        <div class="border-bottom"></div>

                        @if ($brancheF->deleted_at)
                            <div class="col-sm-5 col-xs-6 text-larger">
                                <strong>
                                    {{ trans('Deleted At :') }}
                                </strong>
                            </div>
                            <div class="col-sm-7 text-warning">
                                {{ $brancheF->deleted_at }}
                            </div>

                            <div class="clearfix"></div>
                            <div class="border-bottom"></div>
                        @endif

                        @if ($brancheF->brf_name)

              <div class="col-sm-5 col-6 text-larger">
                <strong>
                  {{ trans('Name of Branche :') }}
                </strong>
              </div>

              <div class="col-sm-7">
                {{ $brancheF->brf_name }}
              </div>

              <div class="clearfix"></div>
              <div class="border-bottom"></div>

            @endif

            
            @if ($brancheF->description)

              <div class="col-sm-5 col-6 text-larger">
                <strong>
                  {{ trans('Description') }}
                </strong>
              </div>

              <div class="col-sm-7">
                {{ $brancheF->description }}
              </div>

              <div class="clearfix"></div>
              <div class="border-bottom"></div>

            @endif

            @if ($brancheF->form_name)

              <div class="col-sm-5 col-6 text-larger">
                <strong>
                  {{ trans("Name of Formation :") }}
                </strong>
              </div>

              <div class="col-sm-7">
                <a href="{{ URL::to( 'formations/'. $brancheF->id_formation ) }}" >{{ $brancheF->form_name }}</a>

              </div>

              <div class="clearfix"></div>
              <div class="border-bottom"></div>

            @endif

            @if ($brancheF->Coord_fname && $brancheF->Coord_lname)

              <div class="col-sm-5 col-6 text-larger">
                <strong>
                  {{ trans("Full Name of the coordinator : ") }}
                </strong>
              </div>

              <div class="col-sm-7">
                <a href="{{ URL::to( 'users/'. $brancheF->coordinateur ) }}" >{{ $brancheF->Coord_lname .' '. $brancheF->Coord_fname }}</a>
                
              </div>

              <div class="clearfix"></div>
              <div class="border-bottom"></div>

            @endif
              
            

            
            @if ($brancheF->created_at)

              <div class="col-sm-5 col-6 text-larger">
                <strong>
                  {{ trans('Created At :') }}
                </strong>
              </div>

              <div class="col-sm-7">
                {{ $brancheF->created_at }}
              </div>

              <div class="clearfix"></div>
              <div class="border-bottom"></div>

            @endif

            @if ($brancheF->updated_at)

              <div class="col-sm-5 col-6 text-larger">
                <strong>
                  {{ trans('Updated At :') }}
                </strong>
              </div>

              <div class="col-sm-7">
                {{ $brancheF->updated_at }}
              </div>

              <div class="clearfix"></div>
              <div class="border-bottom"></div>

            @endif


                        

                        
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('modals.modal-delete')

@endsection

@section('footer_scripts')
    @include('scripts.delete-modal-script')
    @include('scripts.tooltips')
@endsection
