@extends('layouts.app')

@section('template_title')
  {!! trans('usersmanagement.showing-user', ['name' => $user->last_name]) !!}
@endsection

@section('template_linked_css')
    <style type="text/css">
        
        .payment_img{
          -webkit-backface-visibility: hidden; 
          -ms-transform: translateZ(0); /* IE 9 */
          -webkit-transform: translateZ(0); /* Chrome, Safari, Opera */
          transform: translateZ(0);
        }
        .payment_img:hover {
          
          transform: scale(2);
          -webkit-transition: .3s ease-in-out;
          transition: .3s ease-in-out;

        }
    </style>
@endsection

@section('content')
  
  <div class="container">
    <div class="row">
      <div class="col-lg-10 offset-lg-1">

        <div class="card">

          <div class="card-header  bg-primary ">
            <div style="display: flex; justify-content: space-between; align-items: center;">
              {!! trans('usersmanagement.showing-user-title', ['name' => $user->last_name]) !!}
              @if(Auth::User()->currentUserRole==1)
                <div class="float-right">
                  
                  @if($currentRole==2)
                    <a href="{{ URL::TO('/profs') }}" class="btn btn-light btn-sm float-right" data-toggle="tooltip" data-placement="top" title="{{ trans('back to profs') }}">
                        <i class="fa fa-fw fa-reply-all" aria-hidden="true"></i>
                        {!! trans('back to profs') !!}
                    </a>
                  @elseif($currentRole==3)
                    <a href="{{ URL::TO('/students') }}" class="btn btn-light btn-sm float-right" data-toggle="tooltip" data-placement="top" title="{{ trans('back to students') }}">
                        <i class="fa fa-fw fa-reply-all" aria-hidden="true"></i>
                        {!! trans('back to students') !!}
                    </a>
                  @endif

                </div>
              @endif
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
                  @if($user->email)
                    <br />
                    <span class="text-center" data-toggle="tooltip" data-placement="top" title="{{ trans('usersmanagement.tooltips.email-user', ['user' => $user->email]) }}">
                      {{ Html::mailto($user->email, $user->email) }}
                    </span>
                  @endif
                </p>
                <div class="text-center text-left-tablet mb-4">
                @if($user->id==Auth::User()->id || Auth::User()->currentUserRole==1)
                    
                    <a href="/users/{{$user->id}}/edit" class="btn btn-sm btn-warning" data-toggle="tooltip" data-placement="top" title="{{ trans('usersmanagement.editUser') }}">
                      <i class="fa fa-pencil fa-fw" aria-hidden="true"></i> <span class="hidden-xs hidden-sm hidden-md"> {{ trans('Edit') }} </span>
                    </a>
                    {!! Form::open(array('url' => 'users/' . $user->id, 'class' => 'form-inline', 'data-toggle' => 'tooltip', 'data-placement' => 'right', 'title' => trans('usersmanagement.deleteUser'))) !!}
                      {!! Form::hidden('_method', 'DELETE') !!}
                      {!! Form::button('<i class="fa fa-trash-o fa-fw" aria-hidden="true"></i> <span class="hidden-xs hidden-sm hidden-md">' . trans('Delete') . '</span>' , array('class' => 'btn btn-danger btn-sm','type' => 'button', 'data-toggle' => 'modal', 'data-target' => '#confirmDelete', 'data-title' => 'Delete User', 'data-message' => 'Are you sure you want to delete this user?')) !!}
                    {!! Form::close() !!}
                    <br>
                    <br>

                    @if($currentRole=='2')
                      <a class="btn btn-sm btn-outline-primary" href="{{URL::TO('prof/'.$user->id.'/students')}}" data-toggle="tooltip" title="Activated Students">
                          {{trans('Activated Students')}}
                      </a>
                  
                      <a class="btn btn-sm btn-outline-secondary" href="{{URL::TO('prof/'.$user->id.'/validate.students')}}" data-toggle="tooltip" title="UnActivated Students">
                          {{trans('UnActivated Students')}}
                      </a>
                      <br>
                      <br>
                      <a class="btn btn-sm btn-outline-primary" href="{{URL::TO('prof/'.$user->id.'/completed.students')}}" data-toggle="tooltip" title="Students with Complete paymnet">
                        {{trans('Complete paymnet')}}
                      </a>
                
                      <a class="btn btn-sm btn-outline-secondary" href="{{URL::TO('prof/'.$user->id.'/uncompleted.students')}}" data-toggle="tooltip" title="Students with Uncomplete paymnet">
                          {{trans('Uncomplete paymnet')}}
                      </a>
                      
                    @endif  
                  @endif
                  @if(Auth::User()->currentUserRole!=3 && $currentRole=='3' && $user->validate==0 )
                  <a class="btn btn-sm btn-outline-success" href="{{URL::TO('users/' . $user->id.'/accept')}}" data-toggle="tooltip" title="{{trans('Activate student profile')}}">
                    {{trans('Accept')}}
                  </a>
                  <a class="btn btn-sm btn-outline-danger" href="{{URL::TO('users/' . $user->id.'/refuse')}}" data-toggle="tooltip" title="{{trans('not Activate student profile')}}">
                    {{trans('Refuse')}}
                  </a>
                  @endif
                  </div>  

              </div>
            </div>

            <div class="clearfix"></div>
            <div class="border-bottom"></div>

            

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
                <div class="d-flex ml-4" style="column-gap: 10px">
                  @if ($user->bac_year)
                    <div class="">
                    
                      <div class="text-larger">
                        <strong>
                          {{ trans('Year :') }}
                        </strong>
                      </div>
                    
                    </div>
                      
                    <div class="">
                      {{ $user->bac_year }}
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
                          {{ trans('Branche: ') }}
                        </strong>
                      </div>
                    
                    </div>
                      
                    <div class="">
                      {{ $formation->formation_branche }}
                    </div>
                  @endif
                </div>
                @if ($user->s1_receipt || $user->s2_receipt || $user->s3_receipt || $user->s4_receipt)
                  <div class="clearfix"></div>
                  <div class="border-bottom m-3"></div>
                  <h5 style="font-family: Georgia, serif ; color:green;" class="mb-4 ml-3" >
                      {{trans('Payment :')}}
                  </h5> 
                  

                  <div class="row mb-3  justify-content-center">  
                    @if ($user->s1_receipt)
                    <div class="d-flex mr-5 mb-3 justify-content-center">
                        <div class="">
                            <div class="text-larger">
                              <strong>
                                {{ trans('Tranche 1 (S1): ') }}
                              </strong>
                            </div>
                        </div>
                        <div class="">
                          <br/>
                          <div class="text-larger ml-3">
                            <div>
                              <strong>
                                {{ trans('Amount : ') }}
                              </strong>
                              {{ $user->s1_amount .' DH' }}
                            </div>
                            <div>
                              <strong >
                                {{ trans('Date : ') }}
                              </strong>
                              {{ $user->s1_date  }}
                            </div>
                          </div>
                          
                          <br/>
                          
                          <img src="{{asset("custom_symlink/".$user->s1_receipt)}}" class="img-thumbnail payment_img" style="width:200px; height:200px;" >
                        </div>
                    </div>
                    @endif
                    @if ($user->s2_receipt)
                    <div class="d-flex justify-content-center">
                      <div class="">
                          <div class="text-larger">
                            <strong>
                              {{ trans('Tranche 2 (S2): ') }}
                            </strong>
                          </div>
                      </div>
                      <div class="">
                        
                        <br/>
                        <div class="text-larger ml-3">
                          <div>
                            <strong>
                              {{ trans('Amount : ') }}
                            </strong>
                            {{ $user->s2_amount .' DH' }}
                          </div>
                          <div>
                            <strong >
                              {{ trans('Date : ') }}
                            </strong>
                            {{ $user->s2_date  }}
                          </div>
                        </div>
                        <br/>
                        
                        <img src="{{asset("custom_symlink/".$user->s2_receipt)}}" class="img-thumbnail payment_img" style="width:200px; height:200px;" >

                        
                      </div>
                    </div>
                    @endif     
                  </div>

                  <div class="border-bottom ml-5 mr-5 mb-4"></div>

                  <div class="row mb-3  justify-content-center">  
                    @if ($user->s3_receipt)
                    <div class="d-flex mr-5 mb-3 justify-content-center">
                        <div class="">
                            <div class="text-larger">
                              <strong>
                                {{ trans('Tranche 3 (S3): ') }}
                              </strong>
                            </div>
                        </div>
                        <div class="">
                          <br/>
                          <div class="text-larger ml-3">
                            <div>
                              <strong>
                                {{ trans('Amount : ') }}
                              </strong>
                              {{ $user->s3_amount .' DH' }}
                            </div>
                            <div>
                              <strong >
                                {{ trans('Date : ') }}
                              </strong>
                              {{ $user->s3_date  }}
                            </div>
                          </div>
                          
                          <br/>
                          
                          <img src="{{asset("custom_symlink/".$user->s3_receipt)}}" class="img-thumbnail payment_img" style="width:200px; height:200px;" >
                        </div>
                    </div>
                    @endif
                    @if ($user->s4_receipt)
                    <div class="d-flex justify-content-center">
                      <div class="">
                          <div class="text-larger">
                            <strong>
                              {{ trans('Tranche 4 (S4): ') }}
                            </strong>
                          </div>
                      </div>
                      <div class="">
                        
                        <br/>
                        <div class="text-larger ml-3">
                          <div>
                            <strong>
                              {{ trans('Amount : ') }}
                            </strong>
                            {{ $user->s4_amount .' DH' }}
                          </div>
                          <div>
                            <strong >
                              {{ trans('Date : ') }}
                            </strong>
                            {{ $user->s4_date  }}
                          </div>
                        </div>
                        <br/>
                        
                        <img src="{{asset("custom_symlink/".$user->s4_receipt)}}" class="img-thumbnail payment_img" style="width:200px; height:200px;" >
                        
                        
                      </div>
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
          {{-- if the user is student .. we check if his accout is activated or not --}}
          @if($currentRole == '3')  
            <div class="clearfix"></div>
            <div class="border-bottom"></div>

            <div class="col-sm-5 col-6 text-larger">
              <strong>
                {{ trans('Status : ') }}
              </strong>
            </div>

            <div class="col-sm-7">
               
              @php
                if($user->validate==0){
                    $status='Unactivated';
                    $badgeClass='warning';
                }else{
                    $status='Activated';
                    $badgeClass='success';
                }
                  
              @endphp
              <span class="badge badge-{{$badgeClass}}">{{ trans($status) }}</span> 
            </div>
            <div class="clearfix"></div>
            <div class="border-bottom"></div>

            
            <div class="col-sm-5 col-6 text-larger mb-2">
              <strong>
                {{ trans('Payment Status : ') }}
              </strong>
            </div>
            <div class="d-flex ml-5" style="column-gap: 10px">
              <div class="">
                  <div class="text-larger">
                    <strong>
                      {{ trans('Tranche 1 (S1): ') }}
                    </strong>
                  </div>
              </div>
              <div class="">
                  @php
                  if($user->status_s1==0){
                      $status='Uncompleted';
                      $badgeClass='warning';
                  }else{
                      $status='Completed';
                      $badgeClass='success';
                  }
                    
                @endphp
                <span class="badge badge-{{$badgeClass}}">{{ trans($status) }}</span>
              </div>
 
            </div>
            <div class="d-flex ml-5" style="column-gap: 10px">
            
              <div class="">
                  <div class="text-larger">
                    <strong>
                      {{ trans('Tranche 2 (S2): ') }}
                    </strong>
                  </div>
              </div>
              <div class="">
                @php
                if($user->status_s2==0){
                    $status='Uncompleted';
                    $badgeClass='warning';
                }else{
                    $status='Completed';
                    $badgeClass='success';
                }
                  
                @endphp
                <span class="badge badge-{{$badgeClass}}">{{ trans($status) }}</span>
              </div>
              
            </div>
            <div class="d-flex ml-5" style="column-gap: 10px">
              <div class="">
                  <div class="text-larger">
                    <strong>
                      {{ trans('Tranche 3 (S3): ') }}
                    </strong>
                  </div>
              </div>
              <div class="">
                  @php
                  if($user->status_s3==0){
                      $status='Uncompleted';
                      $badgeClass='warning';
                  }else{
                      $status='Completed';
                      $badgeClass='success';
                  }
                    
                @endphp
                <span class="badge badge-{{$badgeClass}}">{{ trans($status) }}</span>
              </div>
 
            </div>
            <div class="d-flex ml-5" style="column-gap: 10px">
              <div class="">
                  <div class="text-larger">
                    <strong>
                      {{ trans('Tranche 4 (S4): ') }}
                    </strong>
                  </div>
              </div>
              <div class="">
                  @php
                  if($user->status_s4==0){
                      $status='Uncompleted';
                      $badgeClass='warning';
                  }else{
                      $status='Completed';
                      $badgeClass='success';
                  }
                    
                @endphp
                <span class="badge badge-{{$badgeClass}}">{{ trans($status) }}</span>
              </div>
 
            </div>
          @endif
              
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
  @if(config('usersmanagement.tooltipsEnabled'))
    @include('scripts.tooltips')
  @endif
@endsection
