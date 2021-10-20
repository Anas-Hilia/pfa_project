@extends('layouts.app')

@section('template_title')
  {!! trans('showing-Branche-Formation', ['name' =>  $brancheF->brf_name]) !!}
@endsection

{{-- @php
  $levelAmount = trans('UserLevel');
  if ($brancheF->level() >= 2) {
    $levelAmount = trans('UserLevels');
  }
@endphp --}}

@section('content')

  <div class="container">
    <div class="row">
      <div class="col-lg-10 offset-lg-1">

        <div class="card">

          <div class="card-header  {{-- @if ($brancheF->activated == 1) bg-success --}}  {{--@else bg-danger @endif--}}">
            <div style="display: flex; justify-content: space-between; align-items: center;">
              {!! trans("Showing Branche of Formation") !!}
              <div class="float-right">
                <a href="{{ route('BranchesFs',$brancheF->id_formation) }}" class="btn btn-light btn-sm float-right" data-toggle="tooltip" data-placement="left" title="{{ trans('brancheFsmanagement.tooltips.back-users') }}">
                  <i class="fa fa-fw fa-mail-reply" aria-hidden="true"></i>
                  {!! trans('back to branches of Formation') !!}
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
                  
                  @if($brancheF->coordinateur == Auth::User()->id || Auth::User()->currentUserRole==1)

                    <div class="text-center text-left-tablet mb-4">
                      <a href="/BranchesFs/{{$brancheF->id_BrF}}/edit" class="btn btn-sm btn-warning " data-toggle="tooltip" data-placement="top" title="{{ trans('Edit Formation') }}">
                        <i class="fa fa-pencil fa-fw" aria-hidden="true"></i> <span class="hidden-xs hidden-sm hidden-md "> {{ trans('Edit') }} </span>
                      </a>
                      {!! Form::open(array('url' => 'BranchesFs/' . $brancheF->id_BrF , 'class' => 'form-inline', 'data-toggle' => 'tooltip', 'data-placement' => 'right', 'title' => trans('Delete Formation'))) !!}
                        {!! Form::hidden('_method', 'DELETE') !!}
                        {!! Form::button('<i class="fa fa-trash-o fa-fw" aria-hidden="true"></i> <span class="hidden-xs hidden-sm hidden-md">' . trans('Delete') . '</span>' , array('class' => 'btn btn-danger btn-sm','type' => 'button', 'data-toggle' => 'modal', 'data-target' => '#confirmDelete', 'data-title' => 'Delete Branche of Formation', 'data-message' => 'Are you sure you want to delete this branche of Formation ?')) !!}
                      {!! Form::close() !!}
                    </div>
                    
                  @endif
              
              </div>
          </div>
            
          <div class="clearfix"></div>
          <div class="border-bottom"></div>

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
              
            

            
            @if ($brancheF->created_at && Auth::User()->currentUserRole!=3)

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

            @if ($brancheF->updated_at && Auth::User()->currentUserRole!=3)

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
  @if(config('brancheFsmanagement.tooltipsEnabled'))
    @include('scripts.tooltips')
  @endif
@endsection
