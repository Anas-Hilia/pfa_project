@extends('layouts.app')

@section('template_title')
    {!!trans('showing-deleted-formation')!!} {{ $formation->name }}
@endsection



@section('content')

    <div class="container">
        <div class="row">
            <div class="col-lg-10 offset-lg-1">
                <div class="card">

                    <div class="card-header bg-danger text-white">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            {!! trans('Show deleted formation') !!}
                            <div class="float-right">
                                <a href="/formations/deleted/" class="btn btn-light btn-sm float-right" data-toggle="tooltip" data-placement="left" title="{{ trans('Back-deleted-formations') }}">
                                    <i class="fa fa-fw fa-mail-reply" aria-hidden="true"></i>
                                    <span class="sr-only">
                                        {!! trans('back to deleted formations') !!}
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row d-felx justify-content-center">
                            
                            <div class="col-sm-4 col-md-6">
                              @if ($formation->name)
                                <h4 class="text-muted margin-top-sm-1 text-center text-left-tablet">
                                        {{$formation->name}}
                                </h4>
                              @endif  
                              <p class="text-center text-left-tablet">
                                  @if ($formation->type)
                                    Type : 
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
                          
                                <div class="text-center text-left-tablet mb-4">
                                    {!! Form::model($formation, array('action' => array('SoftDeletesFormationsController@update', $formation->id), 'method' => 'PUT', 'class' => 'form-inline')) !!}
                                        {!! Form::button('<i class="fa fa-refresh fa-fw" aria-hidden="true"></i> Restore formation', array('class' => 'btn btn-success btn-block btn-sm mt-1 mb-1', 'type' => 'submit', 'data-toggle' => 'tooltip', 'title' => 'Restore formation')) !!}
                                        {!! Form::close() !!}
                                        {!! Form::model($formation, array('action' => array('SoftDeletesFormationsController@destroy', $formation->id), 'method' => 'DELETE', 'class' => 'form-inline', 'data-toggle' => 'tooltip', 'title' => 'Permanently Delete formation')) !!}
                                        {!! Form::hidden('_method', 'DELETE') !!}
                                        {!! Form::button('<i class="fa fa-trash fa-fw" aria-hidden="true"></i> Delete formation', array('class' => 'btn btn-danger btn-sm ','type' => 'button', 'style' =>'width: 100%;' ,'data-toggle' => 'modal', 'data-target' => '#confirmDelete', 'data-title' => 'Permanently Delete formation', 'data-message' => 'Are you sure you want to permanently delete this formation?')) !!}
                                    {!! Form::close() !!}
                                </div>
                               
                            </div>
                        </div>

                        <div class="clearfix"></div>
                        <div class="border-bottom"></div>

                        @if ($formation->deleted_at)
                            <div class="col-sm-5 col-xs-6 text-larger">
                                <strong>
                                    {{ trans('Deleted At :') }}
                                </strong>
                            </div>
                            <div class="col-sm-7 text-warning">
                                {{ $formation->deleted_at }}
                            </div>

                            <div class="clearfix"></div>
                            <div class="border-bottom"></div>
                        @endif

                        @if($deleted_by)
                          @if ($deleted_by->fname && $deleted_by->lname )

                            <div class="col-sm-5 col-6 text-larger">
                              <strong>
                                {{ trans('Deleted By :') }}
                              </strong>
                            </div>

                            <div class="col-sm-7" style="color:blue;" >
                              
                              <a href="{{ URL::to( 'users/'. $deleted_by->id ) }}" >{{ $deleted_by->lname . ' ' . $deleted_by->fname }}</a>

                            </div>

                            <div class="clearfix"></div>
                            <div class="border-bottom"></div>

                          @endif
                        @endif
                        

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
                                {{ trans("Nombre max des students :") }}
                              </strong>
                            </div>

                            <div class="col-sm-7">
                              {{ $formation->nbr_max }}
                            </div>

                            <div class="clearfix"></div>
                            <div class="border-bottom"></div>

                          @endif

                          @if($created_by)
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
                          
                          @if($updated_by)
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


                          @if ($formation->created_at)

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

                          @if ($formation->updated_at)

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
    @include('scripts.tooltips')
@endsection
