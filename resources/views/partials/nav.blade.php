

<nav class="navbar navbar-expand-xl navbar-light navbar-laravel">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/home') }}" class="navbar-brand">
            {{-- <strong>{{trans('Gestion Formations')}}</strong> --}}
            <img src="{{asset("custom_symlink/home_icons/cufcc.png")}}" width="100" height="70" class="d-inline-block align-top" alt="">

        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            <span class="sr-only">{!! trans('Gestion Fomations') !!}</span>
        </button>
        
        @if(Auth::user())
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            {{-- Left Side Of Navbar --}}
            <ul class="navbar-nav mr-auto">
                {{-- @role('admin') --}}
                @if(Auth::User()->currentUserRole!=3)
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {!! trans('User Management') !!}
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        @if(Auth::User()->currentUserRole==1)
                            <a class="dropdown-item {{ Request::is('users/create') ? 'active' : null }}" href="{{ route('users.create') }}">
                                {!! trans('Create New User') !!}
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item " href="{{ url('/students/ImportExport') }}">
                                {!! trans('Import and Export Students') !!}
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item " href="{{ url('/users') }}">
                                {!! trans('Show All Users') !!}
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item " href="{{ url('/profs') }}">
                                {!! trans('Show All Profs') !!}
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item " href="{{ url('/students') }}">
                                {!! trans('Show All Students') !!}
                            </a>
                            

                        @else
                            <a class="dropdown-item " href="/prof/{{Auth::User()->id}}/students" >
                                {{trans('Show Your Activated Students')}}
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item " href="/prof/{{Auth::User()->id}}/validate.students" >
                                {{trans('Show Your Unactivated Students')}}
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item " href="/prof/{{Auth::User()->id}}/completed.students" >
                                {{trans('Students with Complete paymnet')}}
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item " href="/prof/{{Auth::User()->id}}/uncompleted.students" >
                                {{trans('Students with Uncomplete paymnet')}}
                            </a>
                        @endif
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ url('/statistics/home') }}" >
                            {!! trans('Show Statistics') !!}
                        </a>
                    </div>
                </li>
                
                @endif
                
                                
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {!! trans('Formation Management') !!}
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        @if(Auth::User()->currentUserRole!=3)
                            <a class="dropdown-item {{ Request::is('formations/create') ? 'active' : null }}" href="{{ route('formations.create') }}">
                                {!! trans('Create New Formation') !!}
                            </a>
                            <div class="dropdown-divider"></div>
                        @endif
                        <a class="dropdown-item" href="{{ url('/formations') }}">
                            {!! trans('Show All Formations') !!}
                        </a>
                        @if(Auth::User()->currentUserRole==2)
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="/prof/{{Auth::User()->id}}/formations">
                                {{trans('Show Your Formations')}}
                            </a>
                        @endif
                        
                        
                    </div>
                </li>
                @if(Auth::User()->currentUserRole!=3)
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {!! trans('Branche Management') !!}
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            
                            <a class="dropdown-item {{ Request::is('BranchesFs/create') ? 'active' : null }}" href="{{ route('BranchesFs.create') }}">
                                {!! trans('Create New Branche') !!}
                            </a>
                            
                            
                            
                        </div>
                    </li>
                @endif
                
                {{-- Recently Add & Recently Deleted  --}}
                @if(Auth::User()->currentUserRole==1)
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {!! trans('Recently A/U') !!}
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            
                            <a class="dropdown-item " href="{{ url('/formations/created') }}">
                                {!! trans('Formations Created') !!}
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item " href="{{ url('/formations/updated') }}">
                                {!! trans('Formations Updated') !!}
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item " href="{{ url('/branches/created') }}">
                                {!! trans('Branches Created') !!}
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item " href="{{ url('/branches/created') }}">
                                {!! trans('Branches Updated') !!}
                            </a>
                                
                        </div>
                    </li>
                @endif
                @if(Auth::User()->currentUserRole==1)
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {!! trans('Recently Deleted') !!}
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            
                            <a class="dropdown-item " href="{{ url('/users/deleted') }}">
                                {!! trans('Users (profs/students)') !!}
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item " href="{{ url('/formations/deleted') }}">
                                {!! trans('Formations') !!}
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item " href="{{ url('/BranchesFs/deleted') }}">
                                {!! trans('Branches') !!}
                            </a>
                            
                                
                        </div>
                    </li>
                @endif


            </ul>
            
            {{-- Right Side Of Navbar --}}
            <ul class="navbar-nav ml-auto">
                {{-- Authentication Links --}}
                @guest
                    <li><a class="nav-link" href="{{ route('login') }}">{{ trans('titles.login') }}</a></li>
                    @if (Route::has('register'))
                        <li><a class="nav-link" href="{{ route('register') }}">{{ trans('titles.register') }}</a></li>
                    @endif
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                                        
                            @php
                                $avatarUser="admin";
                                if(Auth::User()->currentUserRole){
                                    if(Auth::User()->currentUserRole==2){
                                        $avatarUser="prof";
        
                                    }else if(Auth::User()->currentUserRole==3){
                                        $avatarUser="student";
                                    
                                    }
                                
                                }
                            @endphp

                            <img src="{{ asset('custom_symlink/home_icons/'.$avatarUser.'_icon.png') }}" alt="{{ Auth::user()->last_name }}" class="user-avatar-nav">

                            {{ Auth::user()->last_name }} <span class="caret"></span>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item {{ Request::is('users/'.Auth::user()->id, 'users/'.Auth::user()->id . '/edit') ? 'active' : null }}" href="{{ url('/users/'.Auth::user()->id) }}">
                                {!! trans('titles.profile') !!}
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>

        @endif
    
    </div>
</nav>
