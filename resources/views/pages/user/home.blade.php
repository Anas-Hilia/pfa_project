@extends('layouts.app')

@section('template_title')
{{ trans('Welcome ') . Auth::user()->last_name }}
@endsection

@section('head')
@endsection


@section('template_title')
    {!! trans('usersmanagement.showing-all-users') !!}
@endsection

@section('template_linked_css')
    @if(config('usersmanagement.enabledDatatablesJs'))
        <link rel="stylesheet" type="text/css" href="{{ config('usersmanagement.datatablesCssCDN') }}">
    @endif
    <style type="text/css" media="screen">
        .users-table {
            border: 0;
        }
        .users-table tr td:first-child {
            padding-left: 15px;
        }
        .users-table tr td:last-child {
            padding-right: 15px;
        }
        .users-table.table-responsive,
        .users-table.table-responsive table {
            margin-bottom: 0;
        }
        .img_icon{

            height:270px;
            width:285px;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">

                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {!! trans('Dashboard')  !!}
                            </span>
                            {{-- @php $locale = session()->get('locale'); @endphp
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    @switch($locale)
                                        @case('en')
                                        <img src="{{asset('images/flag/en.png')}}" width="25px"> English
                                        @break
                                        @case('fr')
                                        <img src="{{asset('images/flag/fr.png')}}" width="25px"> Français
                                        @break
                                        @default
                                        <img src="{{asset('images/flag/en.png')}}" width="25px"> English
                                    @endswitch
                                    <span class="caret"></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="lang/en"><img src="{{asset('images/flag/en.png')}}" width="25px"> English</a>
                                    <a class="dropdown-item" href="lang/fr"><img src="{{asset('images/flag/fr.png')}}" width="25px"> Français</a>
                                </div>
                            </li> --}}

                            
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row d-flex justify-content-center " style="column-gap:20px;" >
                        @if($currentRole != 3)
                            <div class="card " style="width: 18rem;" >
                                <img src="{{ asset('custom_symlink/home_icons/profs.jpg') }}" class="card-img-top img_icon" alt="...">
                                @if($currentRole == 1)
                                    <div class="card-body">
                                        <h5 class="card-title"> <strong> {{trans('Professors :')}}</strong></h5>
                                        <p class="card-text">{{trans('List of all professors.')}}</p>
                                    </div>
                                    <div class="card-body">
                                        <a href="/profs" class="card-link">{{trans('Visit Professors')}}</a>
                                    </div>
                                @else
                                    <div class="card-body">
                                        <h5 class="card-title"> <strong> {{trans('Your Profile :')}}</strong></h5>
                                    </div>
                                    <div class="card-body">
                                        <a href="/users/{{Auth::User()->id}}" class="card-link">{{trans('Visit your profile')}}</a>
                                    </div>
                                @endif
                                
                            </div>
                        @endif
                           <div class="card " style="width: 18rem;">
                                <img src="{{ asset('custom_symlink/home_icons/students.jpg') }}" class="card-img-top img_icon" alt="...">
                                @if($currentRole == 2)
                                    <div class="card-body">
                                        <h5 class="card-title"> <strong> {{trans('Your Students :')}}</strong></h5>
                                        <p class="card-text">{{trans('List of your students.')}}</p>
                                    
                                        <a href="prof/{{Auth::User()->id}}/students" class="card-link">{{trans('Visit Your Activated Students')}}</a>
                                        <div class="border-bottom ml-2 mr-2 "></div>
                                        <a href="prof/{{Auth::User()->id}}/validate.students" class="card-link">{{trans('Visit Your Unactivited Students')}}</a>
                                        <div class="border-bottom ml-2 mr-2 "></div>
                                        <a href="prof/{{Auth::User()->id}}/completed.students" class="card-link">{{trans('Students with Complete paymnet')}}</a>
                                        <div class="border-bottom ml-2 mr-2 "></div>
                                        <a href="prof/{{Auth::User()->id}}/uncompleted.students" class="card-link">{{trans('Students with Uncomplete paymnet')}}</a>
                                        
                                    </div>
                                @elseif($currentRole == 3)
                                    <div class="card-body">
                                        <h5 class="card-title"> <strong> {{trans('Your Profile :')}}</strong></h5>
                                    </div>
                                    
                                    <div class="card-body">
                                        <a href="/users/{{Auth::User()->id}}" class="card-link">{{trans('Visit Your Profle')}}</a>
                                    </div>
                                @else
                                    <div class="card-body">
                                        <h5 class="card-title"> <strong> {{trans('Students :')}}</strong></h5>
                                        <p class="card-text">{{trans('List of all students.')}}</p>
                                    </div>
                                    
                                    <div class="card-body">
                                        <a href="/students" class="card-link">{{trans('Visit Students')}}</a>
                                        <div class="border-bottom ml-2 mr-2 "></div>
                                        <a class="card-link" href="{{ url('/students/ImportExport') }}">
                                            {!! trans('Import and Export Students') !!}
                                        </a>
                                    </div>
                                @endif

                            </div>
                       
                            <div class="card " style="width: 18rem;">
                                <img src="{{ asset('custom_symlink/home_icons/formations.png') }}" class="card-img-top img_icon" alt="...">
                                <div class="card-body">
                                    <h5 class="card-title"> <strong> {{trans('Formations :')}}</strong></h5>
                                    <p class="card-text">{{trans('List of all Formations.')}}</p>
                                </div>
                                
                                <div class="card-body">
                                    <a href="/formations" class="card-link">{{trans('Visit Formations')}}</a>
                                    @if($currentRole == 2 )
                                        <div class="border-bottom ml-2 mr-2 "></div>
                                        <a href="prof/{{Auth::User()->id}}/formations" class="card-link">{{trans('Visit Your Formations')}}</a>
                                    @endif
                                </div>
                            </div>
                            @if($currentRole!=3)
                                <div class="card " style="width: 18rem;">
                                    <img src="{{ asset('custom_symlink/home_icons/all_statistics.jfif') }}" class="card-img-top img_icon" alt="...">
                                    <div class="card-body">
                                        <h5 class="card-title"> <strong> {{trans('Statistics :')}}</strong></h5>
                                        <p class="card-text">{{trans('Show All Statistics.')}}</p>
                                    </div>
                                    
                                    <div class="card-body">
                                        <a href="{{URL::TO('/statistics/home')}}" class="card-link">
                                            @if($currentRole==1)
                                                {{trans('Visit all Statistics')}}
                                            @else
                                                {{trans('Visit Your Statistics')}}
                                            @endif
                                        </a>
                                    </div>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('modals.modal-delete')

@endsection

@section('footer_scripts')
    
    @include('scripts.delete-modal-script')
    @include('scripts.save-modal-script')
    @if(config('usersmanagement.tooltipsEnabled'))
        @include('scripts.tooltips')
    @endif
    @if(config('usersmanagement.enableSearchUsers'))
        @include('scripts.search-users')
    @endif
@endsection
