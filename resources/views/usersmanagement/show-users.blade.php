@extends('layouts.app')

@section('template_title')
    
    @if (Route::currentRouteName()=='students' )
        {!! trans('showing all students') !!}
    @elseif(Route::currentRouteName()=='students_of_prof_formation' )
        {!! trans('Activated Students') !!}
    @elseif(Route::currentRouteName()=='students_of_prof_completed')
        {!! trans('Students with Complete paymnet') !!}
    @elseif(Route::currentRouteName()=='students_of_prof_uncompleted')
        {!! trans('Students with Uncomplete paymnet') !!}
    @elseif(Route::currentRouteName()=='students_validate')
        {!! trans('Unactivated Students') !!}
    @elseif(Route::currentRouteName()=='profs')
        {!! trans('showing all professors') !!}
    @else
        {!! trans('showing all users') !!}
    @endif
    
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

                                @if (Route::currentRouteName()=='students')
                                    {!! trans('Showing all students') !!}
                                @elseif(Route::currentRouteName()=='students_of_prof_formation')
                                    {!! trans('Showing Activated students') !!}
                                @elseif(Route::currentRouteName()=='students_validate')
                                    {!! trans('Showing Unactivated students') !!}
                                @elseif(Route::currentRouteName()=='students_of_prof_completed')
                                    {!! trans('Showing Students with Complete paymnet :') !!}
                                @elseif(Route::currentRouteName()=='students_of_prof_uncompleted')
                                    {!! trans('Showing Students with incomplete paymnet :') !!}
                                @elseif(Route::currentRouteName()=='profs')
                                    {!! trans('Showing all professors') !!}
                                @else
                                    {!! trans('usersmanagement.showing-all-users') !!}
                                @endif
                                
                            </span>

                            <div class="btn-group pull-right btn-group-xs">
                                @if(Auth::user()->currentUserRole==1)

                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fa fa-ellipsis-v fa-fw" aria-hidden="true"></i>
                                        <span class="sr-only">
                                            {!! trans('usersmanagement.users-menu-alt') !!}
                                        </span>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="/users/create">
                                            <i class="fa fa-fw fa-user-plus" aria-hidden="true"></i>
                                            {!! trans('usersmanagement.buttons.create-new') !!}
                                        </a>
                                        <a class="dropdown-item" href="/users/deleted">
                                            <i class="fa fa-fw fa-group" aria-hidden="true"></i>
                                            {!! trans('usersmanagement.show-deleted-users') !!}
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        @if(count($users) === 0)

                            <tr>
                                <p class="text-center margin-half">
                                    {!! trans('no-records') !!}
                                </p>
                            </tr>

                        @else
                        
                            @if(config('usersmanagement.enableSearchUsers'))
                                @include('partials.search-users-form')
                            @endif

                            <div class="table-responsive users-table">
                                <table class="table table-striped table-sm data-table">
                                    <caption id="user_count">
                                    @php
                                        if (Route::currentRouteName()=='students' || 
                                            Route::currentRouteName()=='students_of_prof_formation' ||
                                            Route::currentRouteName()=='students_validate'||
                                            Route::currentRouteName()=='students_of_prof_uncompleted' ||
                                            Route::currentRouteName()=='students_of_prof_completed')

                                            $UserType="student";
                                        else if(Route::currentRouteName()=='profs')
                                            $UserType="professor";
                                        else
                                            $UserType="user";
                                            
                                    @endphp

                                        @if($users->count()==1)
                                            {{trans($users->count().' '.$UserType.' total')}}
                                        @else
                                            {{trans($users->count().' '.$UserType.'s total')}}
                                        @endif
                                        
                                    </caption>
                                    <thead class="thead">
                                        <tr>
                                            <th>{!! trans('Id') !!}</th>
                                            <th >{!! trans('Email') !!}</th>
                                            <th class="hidden-xs">{!! trans('Fist Name') !!}</th>
                                            <th class="hidden-xs">{!! trans('Last Name') !!}</th>
                                            <th>{!! trans('Role') !!}</th>
                                            @if (Route::currentRouteName()=='students' || 
                                                 Route::currentRouteName()=='students_of_prof_formation' ||
                                                 Route::currentRouteName()=='students_validate' ||
                                                 Route::currentRouteName()=='students_of_prof_completed' ||
                                                 Route::currentRouteName()=='students_of_prof_uncompleted')
                                                
                                                <th>{!! trans('Status') !!}</th>
                                                {{-- <th class="hidden-xs">{!! trans('tranche 1') !!}</th>
                                                <th class="hidden-xs">{!! trans('tranche 2') !!}</th> --}}

                                            @endif
                                            
                                            <th>{!! trans('Actions') !!}</th>
                                            <th class="no-search no-sort"></th>
                                            <th class="no-search no-sort"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="users_table">
                                        @foreach($users as $user)
                                            <tr>
                                                <td>{{$user->id}}</td>
                                                <td ><a href="mailto:{{ $user->email }}" title="email {{ $user->email }}">{{ $user->email }}</a></td>
                                                <td class="hidden-xs">{{$user->first_name}}</td>
                                                <td class="hidden-xs">{{$user->last_name}}</td>

                                                <td>
                                                    @foreach ($user->roles as $user_role)
                                                        @if ($user_role->name == 'Professor')
                                                            @php $badgeClass = 'primary' @endphp
                                                        @elseif ($user_role->name == 'Admin')
                                                            @php $badgeClass = 'warning' @endphp
                                                        @elseif ($user_role->name == 'Student')
                                                            @php $badgeClass = 'success' @endphp
                                                        @else
                                                            @php $badgeClass = 'default' @endphp
                                                        @endif
                                                        <span class="badge badge-{{$badgeClass}}">{{ trans($user_role->name) }}</span>
                                                    @endforeach
                                                </td>
                                                @if (Route::currentRouteName()=='students' || 
                                                    Route::currentRouteName()=='students_of_prof_formation' ||
                                                    Route::currentRouteName()=='students_validate' ||
                                                    Route::currentRouteName()=='students_of_prof_completed' ||
                                                    Route::currentRouteName()=='students_of_prof_uncompleted')
                                                    <td>
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

                                                    </td>
                                                    {{-- <td>
                                                        @php
                                                            if($user->status_tr1==0){
                                                                $status='Uncompleted';
                                                                $badgeClass='warning';
                                                            }else{
                                                                $status='Completed';
                                                                $badgeClass='success';
                                                            }
                                                            
                                                        @endphp
                                                    <span class="badge badge-{{$badgeClass}}">{{ trans($status) }}</span>

                                                    </td>
                                                    <td>
                                                        @php
                                                            if($user->status_tr2==0){
                                                                $status='Uncompleted';
                                                                $badgeClass='warning';
                                                            }else{
                                                                $status='Completed';
                                                                $badgeClass='success';
                                                            }
                                                            
                                                        @endphp
                                                    <span class="badge badge-{{$badgeClass}}">{{ trans($status) }}</span>

                                                    </td> --}}
                                                @endif
                                                
                                                @if(Route::currentRouteName()=='students_validate')
                                                    <td>
                                                        <a class="btn btn-sm btn-success btn-block" href="{{ URL::to('users/' . $user->id.'/accept') }}" data-toggle="tooltip" title="Accept">
                                                            {!! trans('Accept') !!}
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <a class="btn btn-sm btn-danger btn-block" href="{{ URL::to('users/' . $user->id.'/refuse') }}" data-toggle="tooltip" title="Refuse">
                                                            {!! trans('Refuse') !!}
                                                        </a>
                                                    </td>
                                                @else
                                                    <td>
                                                        <a class="btn btn-sm btn-success btn-block" href="{{ URL::to('users/' . $user->id) }}" data-toggle="tooltip" title="Show">
                                                            {!! trans('show') !!}
                                                        </a>
                                                    </td>

                                                    @if(Auth::User()->currentUserRole==1)
                                                        
                                                        <td>
                                                            <a class="btn btn-sm btn-info btn-block" href="{{ URL::to('users/' . $user->id . '/edit') }}" data-toggle="tooltip" title="Edit">
                                                                {!! trans('edit') !!}
                                                            </a>
                                                        </td>
                                                        <td>
                                                            {!! Form::open(array('url' => 'users/' . $user->id, 'class' => '', 'data-toggle' => 'tooltip', 'title' => 'Delete')) !!}
                                                                {!! Form::hidden('_method', 'DELETE') !!}
                                                                {!! Form::button(trans('delete'), array('class' => 'btn btn-danger btn-sm','type' => 'button', 'style' =>'width: 100%;' ,'data-toggle' => 'modal', 'data-target' => '#confirmDelete', 'data-title' => 'Delete User', 'data-message' => 'Are you sure you want to delete this user ?')) !!}
                                                            {!! Form::close() !!}
                                                        </td>

                                                    @endif
                                                @endif
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tbody id="search_results"></tbody>
                                    @if(config('usersmanagement.enableSearchUsers'))
                                        <tbody id="search_results"></tbody>
                                    @endif

                                </table>
                                <div class="d-flex justify-content-center">    
                                    @if(config('usersmanagement.enablePagination'))
                                        {{ $users->links() }}
                                    @endif
                                </div>
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
    @if ((count($users) > config('usersmanagement.datatablesJsStartCount')) && config('usersmanagement.enabledDatatablesJs'))
        @include('scripts.datatables')
    @endif
    @include('scripts.delete-modal-script')
    @include('scripts.save-modal-script')
    @if(config('usersmanagement.tooltipsEnabled'))
        @include('scripts.tooltips')
    @endif
    @if(config('usersmanagement.enableSearchUsers'))
        @include('scripts.search-users')
    @endif
    
@endsection
