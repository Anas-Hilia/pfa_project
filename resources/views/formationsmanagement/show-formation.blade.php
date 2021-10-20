@extends('layouts.app')

@section('template_title')
  {!! trans('showing-user', ['name' =>  $formation->name]) !!}
@endsection

{{-- @php
  $levelAmount = trans('UserLevel');
  if ($formation->level() >= 2) {
    $levelAmount = trans('UserLevels');
  }
@endphp --}}

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-lg-10 offset-lg-1">

        <div class="card">

          <div class="card-header  {{-- @if ($formation->activated == 1) bg-success --}}  {{--@else bg-danger @endif--}}">
            <div style="display: flex; justify-content: space-between; align-items: center;">
              {!! trans('Show formation', ['name' => $formation->name]) !!}
              <div class="float-right">
                <a href="{{ route('formations') }}" class="btn btn-light btn-sm float-right" data-toggle="tooltip" data-placement="left" title="{{ trans('formationsmanagement.tooltips.back-users') }}">
                  <i class="fa fa-fw fa-mail-reply" aria-hidden="true"></i>
                  {!! trans('back to formations') !!}
                </a>
              </div>
            </div>
          </div>

          <div class="card-body">

            <div class="row d-flex justify-content-center">
                            
              <div class="col-sm-4 col-md-6">
                  @if ($formation->name)
                    <h4 class="text-muted margin-top-sm-1 text-center text-left-tablet">
                            {{$formation->name}}
                    </h4>
                  @endif  
                  <p class="text-center text-left-tablet">
                      @if ($formation->type)
                        {{ trans('Type :') }} 
                        <strong>
                        {{ $formation->type }}
                        </strong>
                      @endif
                      
                      <br/>
                      <a href="{{ URL::to('formations/'.$formation->id.'/branches' ) }}" data-toggle="tooltip" title="{{trans('Branches of formation')}}">
                        {{trans('Branches of formation')}}
                      </a>
                      <br />
                      
                  </p>
                  @if($formation->created_by==Auth::User()->id || Auth::User()->currentUserRole==1)
                    <div class="text-center text-left-tablet mb-4">
                      <a href="/formations/{{$formation->id}}/edit" class="btn btn-sm btn-warning " data-toggle="tooltip" data-placement="top" title="{{ trans('Edit Formation') }}">
                        <i class="fa fa-pencil fa-fw" aria-hidden="true"></i> <span class="hidden-xs hidden-sm hidden-md "> {{ trans('Edit') }} </span>
                      </a>
                      {!! Form::open(array('url' => 'formations/' . $formation->id , 'class' => 'form-inline', 'data-toggle' => 'tooltip', 'data-placement' => 'right', 'title' => trans('Delete Formation'))) !!}
                        {!! Form::hidden('_method', 'DELETE') !!}
                        {!! Form::button('<i class="fa fa-trash-o fa-fw" aria-hidden="true"></i> <span class="hidden-xs hidden-sm hidden-md">' . trans('Delete') . '</span>' , array('class' => 'btn btn-danger btn-sm','type' => 'button', 'data-toggle' => 'modal', 'data-target' => '#confirmDelete', 'data-title' => 'Delete Formation', 'data-message' => 'Are you sure you want to delete this formation?')) !!}
                      {!! Form::close() !!}
                    </div>
                  @endif
                 
              </div>
          </div>

          <div class="clearfix"></div>
          <div class="border-bottom"></div>
            

            @if ($formation->name)

              <div class="col-sm-5 col-6 text-larger">
                <strong>
                  {{ trans('Name :') }}
                </strong>
              </div>

              <div class="col-sm-7">
                {{ $formation->name }}
              </div>

              <div class="clearfix"></div>
              <div class="border-bottom"></div>

            @endif

            
            @if ($formation->description)

              <div class="col-sm-5 col-6 text-larger">
                <strong>
                  {{ trans('Description :') }}
                </strong>
              </div>

              <div class="col-sm-7">
                {{ $formation->description }}
              </div>

              <div class="clearfix"></div>
              <div class="border-bottom"></div>

            @endif

            @if ($formation->type)

              <div class="col-sm-5 col-6 text-larger">
                <strong>
                  {{ trans("Type :") }}
                </strong>
              </div>

              <div class="col-sm-7">
                {{ $formation->type }}
              </div>

              <div class="clearfix"></div>
              <div class="border-bottom"></div>

            @endif

            @if ($formation->nbr_max)

              <div class="col-sm-5 col-6 text-larger">
                <strong>
                  {{ trans("Nombre max des students") }}
                </strong>
              </div>

              <div class="col-sm-7">
                {{ $formation->nbr_max }}
              </div>

              <div class="clearfix"></div>
              <div class="border-bottom"></div>

            @endif
            @if($created_by && Auth::User()->currentUserRole!=3)
              @if ($created_by->fname && $created_by->lname )

                <div class="col-sm-5 col-6 text-larger">
                  <strong>
                    {{ trans('Created By :') }}
                  </strong>
                </div>

                <div class="col-sm-7" style="color:blue;" >
                  
                  <a href="{{ URL::to( 'users/'. $created_by->id ) }}" >{{ $created_by->lname . ' ' . $created_by->fname }}</a>

                </div>

                <div class="clearfix"></div>
                <div class="border-bottom"></div>

              @endif
            @endif
            
            @if($updated_by && Auth::User()->currentUserRole!=3)
              @if ($updated_by->fname && $updated_by->lname )

                <div class="col-sm-5 col-6 text-larger">
                  <strong>
                    {{ trans('Updated By :') }}
                  </strong>
                </div>

                <div class="col-sm-7 " style="color:blue;">
                  <a href="{{ URL::to( 'users/'. $updated_by->id ) }}" >{{ $updated_by->lname . ' ' . $updated_by->fname }}</a>

                </div>

                <div class="clearfix"></div>
                <div class="border-bottom"></div>

              @endif
            @endif
            

            @if ($formation->created_at && Auth::User()->currentUserRole!=3)

              <div class="col-sm-5 col-6 text-larger">
                <strong>
                  {{ trans('Created At :') }}
                </strong>
              </div>

              <div class="col-sm-7">
                {{ $formation->created_at }}
              </div>

              <div class="clearfix"></div>
              <div class="border-bottom"></div>

            @endif

            @if ($formation->updated_at && Auth::User()->currentUserRole!=3)

              <div class="col-sm-5 col-6 text-larger">
                <strong>
                  {{ trans('Updated At :') }}
                </strong>
              </div>

              <div class="col-sm-7">
                {{ $formation->updated_at }}
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
  @if(config('formationsmanagement.tooltipsEnabled'))
    @include('scripts.tooltips')
  @endif
@endsection
