@extends('layouts.app')

@section('template_title')
    {!!trans('usersmanagement.showing-user-deleted')!!} {{ $user->last_name }}
@endsection

@php
    $levelAmount = 'Level:';
    if ($user->level() >= 2) {
        $levelAmount = 'Levels:';
    }
@endphp

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-lg-10 offset-lg-1">
                <div class="card">

                    <div class="card-header bg-danger text-white">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            {!! trans('usersmanagement.usersDeletedPanelTitle') !!}
                            <div class="float-right">
                                <a href="/users/deleted/" class="btn btn-light btn-sm float-right" data-toggle="tooltip" data-placement="left" title="{{ trans('usersmanagement.usersBackDelBtn') }}">
                                    <i class="fa fa-fw fa-mail-reply" aria-hidden="true"></i>
                                    <span class="sr-only">
                                        {!! trans('back to deleted users') !!}
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-4 offset-sm-2 col-md-2 offset-md-3">

                              @php
                                $avatarUser="admin";
                                
                                if($currentRole==2){
                                    $avatarUser="prof";
            
                                }else if($currentRole==3){
                                    $avatarUser="student";
                                
                                }
                                
                                  
                              @endphp
              
                              <img src="{{ asset('custom_symlink/home_icons/'.$avatarUser.'_icon.png') }}" alt="{{ Auth::user()->last_name }}" class="rounded-circle center-block mb-3 mt-4 user-image">
                            </div>
                            <div class="col-sm-4 col-md-6">
                                <h4 class="text-muted margin-top-sm-1 text-center text-left-tablet">
                                    {{ $user->last_name }}
                                </h4>
                                <p class="text-center text-left-tablet">
                                    <strong>
                                    {{ $user->first_name }} {{ $user->last_name }}
                                    </strong>
                                    <br />
                                    {{ HTML::mailto($user->email, $user->email) }}
                                </p>
                                @if ($user->profile)
                                <div class="text-center text-left-tablet mb-4">
                                    {!! Form::model($user, array('action' => array('SoftDeletesController@update', $user->id), 'method' => 'PUT', 'class' => 'form-inline')) !!}
                                        {!! Form::button('<i class="fa fa-refresh fa-fw" aria-hidden="true"></i> Restore User', array('class' => 'btn btn-success btn-block btn-sm mt-1 mb-1', 'type' => 'submit', 'data-toggle' => 'tooltip', 'title' => 'Restore User')) !!}
                                        {!! Form::close() !!}
                                        {!! Form::model($user, array('action' => array('SoftDeletesController@destroy', $user->id), 'method' => 'DELETE', 'class' => 'form-inline', 'data-toggle' => 'tooltip', 'title' => 'Permanently Delete User')) !!}
                                        {!! Form::hidden('_method', 'DELETE') !!}
                                        {!! Form::button('<i class="fa fa-user-times fa-fw" aria-hidden="true"></i> Delete User', array('class' => 'btn btn-danger btn-sm ','type' => 'button', 'style' =>'width: 100%;' ,'data-toggle' => 'modal', 'data-target' => '#confirmDelete', 'data-title' => 'Permanently Delete User', 'data-message' => 'Are you sure you want to permanently delete this user?')) !!}
                                    {!! Form::close() !!}
                                </div>
                                @endif
                            </div>
                        </div>

                        <div class="clearfix"></div>
                        <div class="border-bottom"></div>

                        @if ($user->deleted_at)
                            <div class="col-sm-5 col-xs-6 text-larger">
                                <strong>
                                    {{ trans('Deleted At :') }}
                                </strong>
                            </div>
                            <div class="col-sm-7 text-warning">
                                {{ $user->deleted_at }}
                            </div>

                            <div class="clearfix"></div>
                            <div class="border-bottom"></div>
                        @endif
                      
            

            @if ($user->email)

            <div class="col-sm-5 col-6 text-larger">
              <strong>
                {{ trans('Email :') }}
              </strong>
            </div>

            <div class="col-sm-7">
              <span data-toggle="tooltip" data-placement="top" title="{{ trans('usersmanagement.tooltips.email-user', ['user' => $user->email]) }}">
                {{ HTML::mailto($user->email, $user->email) }}
              </span>
            </div>

            <div class="clearfix"></div>
            <div class="border-bottom"></div>

            @endif

            @if ($user->first_name)

              <div class="col-sm-5 col-6 text-larger">
                <strong>
                  {{ trans('First Name :') }}
                </strong>
              </div>

              <div class="col-sm-7">
                {{ $user->first_name }}
              </div>

              <div class="clearfix"></div>
              <div class="border-bottom"></div>

            @endif

            @if ($user->last_name)

              <div class="col-sm-5 col-6 text-larger">
                <strong>
                  {{ trans('Last Name :') }}
                </strong>
              </div>

              <div class="col-sm-7">
                {{ $user->last_name }}
              </div>

              

            @endif
            
            @if ($user->tel)

              <div class="clearfix"></div>
              <div class="border-bottom"></div>

              <div class="col-sm-5 col-6 text-larger">
                <strong>
                  {{ trans('Phone Number : ') }}
                </strong>
              </div>

              <div class="col-sm-7">
                {{ $user->tel }}
              </div>

              

            @endif

            @if ($user->establishment_prof)

              <div class="clearfix"></div>
              <div class="border-bottom"></div>

              <div class="col-sm-5 col-6 text-larger">
                <strong>
                  {{ trans('Establishment :') }}
                </strong>
              </div>

              <div class="col-sm-7">
                {{ $user->establishment_prof }}
              </div>

            @endif

            @if($currentRole=='3')

              <div class="border-bottom mb-3"></div>
              <h5 style="font-family: Georgia, serif ; color:green;" class="mb-4 ml-3" >
                {{trans('Personnal informations :')}}
              </h5> 
          
              <div class="d-flex ml-4" style="column-gap: 10px">
                @if ($user->CIN)
                  <div class="">
                      <div class="text-larger">
                        <strong>
                          {{ trans('CIN : ') }}
                        </strong>
                      </div>
                  </div>
                  <div class="">
                    {{ $user->CIN }}
                  </div>
                @endif
              </div>

              <div class="d-flex ml-4" style="column-gap: 10px">
                @if ($user->CNE)
                <div class="">
                    <div class="text-larger">
                      <strong>
                        {{ trans('CNE : ') }}
                      </strong>
                    </div>
                </div>
                <div class="">
                  {{ $user->CNE }}
                </div>
                @endif     
              </div>
              
              <div class="d-flex ml-4" style="column-gap: 10px">  
                @if ($user->date_birth)
                  <div class="">
                      <div class="text-larger">
                        <strong>
                          {{ trans('Date of Birth : ') }}
                        </strong>
                      </div>
                  </div>
                  <div class="">
                    {{ $user->date_birth }}
                  </div>
                @endif
              </div>

              <div class="d-flex ml-4" style="column-gap: 10px">
                @if ($user->place_birth)
                  <div class="">
                      <div class="text-larger">
                        <strong>
                          {{ trans('Place of Birth : ') }}
                        </strong>
                      </div>
                  </div>
                  <div class="">
                    {{ $user->place_birth }}
                  </div>
                @endif     
              </div>

              <div class="border-bottom m-3"></div>
              <h5 style="font-family: Georgia, serif ; color:green;" class="mb-4 ml-3" >
                {{trans('Bachelor :')}}
              </h5>
                <div class="d-flex ml-4" style="column-gap: 10px">
                    @if ($user->serie)
                      <div class="">
                          <div class="text-larger">
                            <strong>
                              {{ trans('Serie : ') }}
                            </strong>
                          </div>
                      </div>
                      <div class="">
                        {{ $user->serie }}
                      </div>
                    @endif 
                </div>
                <div class="d-flex ml-4" style="column-gap: 10px">
                  @if ($user->academy)
                    <div class="">
                    
                      <div class="text-larger">
                        <strong>
                          {{ trans('Academy :') }}
                        </strong>
                      </div>
                    
                    </div>
                      
                    <div class="">
                      {{ $user->academy }}
                    </div>
                  @endif 
                </div>

                <div class="d-flex ml-4" style="column-gap: 10px">
                  @if ($user->establishment_1)
                    <div class="">
                    
                      <div class="text-larger">
                        <strong>
                          {{ trans('Establishment :') }}
                        </strong>
                      </div>
                    
                    </div>
                      
                    <div class="">
                      {{ $user->establishment_1 }}
                    </div>
                  @endif
                </div>
              
              <div class="border-bottom m-3"></div>
              <h5 style="font-family: Georgia, serif ; color:green;" class="mb-4 ml-3" >
                {{trans('Academic training :')}}
              </h5> 
            
                <div class="d-flex ml-4" style="column-gap: 10px">
                  @if ($user->diploma)
                    <div class="">
                        <div class="text-larger">
                          <strong>
                            {{ trans('Diploma : ') }}
                          </strong>
                        </div>
                    </div>
                    <div class="">
                      {{ $user->diploma }}
                    </div>
                  @endif 
                </div>

                <div class="d-flex ml-4" style="column-gap: 10px">
                  @if ($user->date_obtained)
                    <div class="">
                        <div class="text-larger">
                          <strong>
                            {{ trans('date_obtained : ') }}
                          </strong>
                        </div>
                    </div>
                    <div class="">
                      {{ $user->date_obtained }}
                    </div>
                  @endif 
                </div>

                <div class="d-flex ml-4" style="column-gap: 10px">
                  @if ($user->establishment_2)
                      <div class="">
                          <div class="text-larger">
                            <strong>
                              {{ trans('Establishment : ') }}
                            </strong>
                          </div>
                      </div>
                      <div class="">
                        {{ $user->establishment_2 }}
                      </div>
                    @endif   
              </div>
              
          
              
              <div class="border-bottom m-3"></div>
              <h5 style="font-family: Georgia, serif ; color:green;" class="mb-4 ml-3" >
                {{trans('Experience professionnelle :')}}
              </h5> 
            
                <div class="d-flex ml-4" style="column-gap: 10px">
                  @if ($user->employer_organization)
                    <div class="">
                        <div class="text-larger">
                          <strong>
                            {{ trans('Employer organization : ') }}
                          </strong>
                        </div>
                    </div>
                    <div class="">
                      {{ $user->employer_organization }}
                    </div>
                  @endif
                </div>

                <div class="d-flex ml-4" style="column-gap: 10px">
                  @if ($user->poste_occupied)
                    <div class="">
                        <div class="text-larger">
                          <strong>
                            {{ trans('Poste occupied : ') }}
                          </strong>
                        </div>
                    </div>
                    <div class="">
                      {{ $user->poste_occupied }}
                    </div>
                  @endif     
                </div>
              
              <div class="border-bottom m-3"></div>
              <h5 style="font-family: Georgia, serif ; color:green;" class="mb-4 ml-3" >
                  {{trans('Formation chosed : ')}} 
              </h5>

                  <div class="d-flex ml-4" style="column-gap: 10px">
                    @if ($formation->formation_name)
                      <div class="">
                          <div class="text-larger">
                            <strong>
                              {{ trans('Name : ') }}
                            </strong>
                          </div>
                      </div>
                      <div class="">
                        {{ $formation->formation_name }}
                      </div>
                    @endif 
                  </div>

                  <div class="d-flex ml-4" style="column-gap: 10px">
                    @if ($formation->formation_type)
                      <div class="">
                      
                        <div class="text-larger">
                          <strong>
                            {{ trans('Type :') }}
                          </strong>
                        </div>
                      
                      </div>
                        
                      <div class="">
                        {{ $formation->formation_type }}
                      </div>
                    @endif 
                  </div>  

                <div class="d-flex ml-4" style="column-gap: 10px">
                  @if ($formation->formation_branche)
                    <div class="">
                    
                      <div class="text-larger">
                        <strong>
                          {{ trans('Branche:') }}
                        </strong>
                      </div>
                    
                    </div>
                      
                    <div class="">
                      {{ $formation->formation_branche }}
                    </div>
                  @endif
                </div>

              @if ($user->tranche_1 && $user->tranche_2)
                <div class="clearfix"></div>
                <div class="border-bottom m-3"></div>
                <h5 style="font-family: Georgia, serif ; color:green;" class="mb-4 ml-3" >
                    Payment :
                </h5> 
                

                <div class="d-flex justify-content-center mb-3">  
                  @if ($user->tranche_1)
                      <div class="">
                          <div class="text-larger">
                            <strong>
                              {{ trans('Tranche 1 : ') }}
                            </strong>
                          </div>
                      </div>
                      <div class="">
                        {{ $user->tranche_1 }}
                        <br/>
                        <br/>
                        
                        <img src="{{asset("custom_symlink/".$user->tranche_1)}}" class="img-thumbnail payment_img" style="width:200px; height:200px;" >
                      </div>
                    @endif
                    @if ($user->tranche_2)
                    <div class="">
                        <div class="text-larger">
                          <strong>
                            {{ trans('Tranche 2 : ') }}
                          </strong>
                        </div>
                    </div>
                    <div class="">
                      {{ $user->tranche_2 }}
                      <br/>
                      <br/>
                      
                      <img src="{{asset("custom_symlink/".$user->tranche_2)}}" class="img-thumbnail payment_img" style="width:200px; height:200px;" >

                      
                    </div>
                  @endif     
                </div>
              @endif
            @endif
            <div class="clearfix"></div>
            <div class="border-bottom"></div>

            
            <div class="col-sm-5 col-6 text-larger">
              <strong>
                {{ trans('Role : ') }}
              </strong>
            </div>

            <div class="col-sm-7">
               
                
                @if ($currentRole == '1')
                  @php 
                    $badgeClass = 'warning';
                    $userRole = "Admin" ;
                  @endphp

                @elseif ($currentRole == '2')
                  @php 
                    $badgeClass = 'primary';
                    $userRole = 'Professor'; 
                  @endphp

                @elseif ($currentRole == '3')
                  @php 
                    $badgeClass = 'success' ;
                    $userRole = "Student" ;
                  @endphp

                @else
                  @php $badgeClass = 'default' @endphp

                @endif

                <span class="badge badge-{{$badgeClass}}">{{ trans($userRole) }}</span>

            </div>
            
          {{-- if the user is prof and he is coordinator of an formation --}}
          
          @if ($user->brfName)
            <div class="clearfix"></div>
            <div class="border-bottom"></div>

            <div class="col-sm-5 col-6 text-larger">
              <strong>
                {{ trans('Coordinator of the formation :') }}
              </strong>
            </div>

            <div class="col-sm-12">
              <a href="{{URL::TO('BranchesFs/'.$user->id_formation)}}" >{{ $user->brfName }}</a>
            </div>

            

            @endif


            {{-- <div class="clearfix"></div>
            <div class="border-bottom"></div>

            <div class="col-sm-5 col-6 text-larger">
              <strong>
                {{ trans('usersmanagement.labelStatus') }}
              </strong>
            </div>

            <div class="col-sm-7">
              @if ($user->activated == 1)
                <span class="badge badge-success">
                  Activated
                </span>
              @else
                <span class="badge badge-danger">
                  Not-Activated
                </span>
              @endif
            </div> --}}

            

            
            

            
            {{-- <div class="col-sm-5 col-6 text-larger">
              <strong>
                {{ trans('usersmanagement.labelPermissions') }}
              </strong>
            </div>

            <div class="col-sm-7">
              @if($user->canViewUsers())
                <span class="badge badge-primary margin-half margin-left-0">
                  {{ trans('permsandroles.permissionView') }}
                </span>
              @endif

              @if($user->canCreateUsers())
                <span class="badge badge-info margin-half margin-left-0">
                  {{ trans('permsandroles.permissionCreate') }}
                </span>
              @endif

              @if($user->canEditUsers())
                <span class="badge badge-warning margin-half margin-left-0">
                  {{ trans('permsandroles.permissionEdit') }}
                </span>
              @endif

              @if($user->canDeleteUsers())
                <span class="badge badge-danger margin-half margin-left-0">
                  {{ trans('permsandroles.permissionDelete') }}
                </span>
              @endif
            </div>
            --}}
            <div class="clearfix"></div>
            <div class="border-bottom"></div> 


            @if ($user->created_at)
              
              <div class="col-sm-5 col-6 text-larger">
                <strong>
                  {{ trans('Created At :') }}
                </strong>
              </div>

              <div class="col-sm-7">
                {{ $user->created_at }}
              </div>

              <div class="clearfix"></div>
              <div class="border-bottom"></div>

            @endif

            @if ($user->updated_at)

              <div class="col-sm-5 col-6 text-larger">
                <strong>
                  {{ trans('Updated At :') }}
                </strong>
              </div>

              <div class="col-sm-7">
                {{ $user->updated_at }}
              </div>

              

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
