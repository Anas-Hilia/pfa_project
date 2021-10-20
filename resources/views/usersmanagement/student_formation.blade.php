@extends('layouts.app')

@section('template_title')
    {{ trans('Showing All Student') }}
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
            width:270px;
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
                                @if (Route::currentRouteName()=='students_validate_brf')
                                    {!! trans('Showing Unactivated Students of each formation :') !!}
                                @elseif(Route::currentRouteName()=='students_of_prof')
                                    {!! trans('Showing Activated Students of each formation :') !!}
                                @elseif(Route::currentRouteName()=='students_of_prof_brf_completed')
                                    {!! trans('Showing Students with Complete paymnet of each formation :') !!}
                                @elseif(Route::currentRouteName()=='students_of_prof_brf_uncompleted')
                                    {!! trans('Showing Students with incomplete paymnet of each formation :') !!}
                                @endif

                            </span>
                           
                            
                        </div>
                    </div>

                    <div class="card-body">
                        @if(count($branches) === 0)

                            <tr>
                                <p class="text-center margin-half">
                                    {!! trans('no-records') !!}
                                </p>
                            </tr>

                        @else
                            <div class="row d-flex justify-content-center " style="column-gap:20px;" >
                                <div class="row">
                                    @foreach($branches as $branche)    
                                        <div @if(count($branches)>1) class="col-sm-6" @endif >
                                            <div class="card" >
                                                <div class="card-body" style="height:170px">
                                                    <h5 class="card-title">{{trans('Branche Name :')}}</h5>
                                                    <p class="card-text">{{$branche->name}}.</p>
                                                    @if (Route::currentRouteName()=='students_validate_brf')
                                                        <a href="{{URL::TO('prof/'.$branche->coordinateur.'/validate.students/brancheF/'.$branche->id_BrF)}}" class="btn btn btn-outline-info">{{trans('Show Students')}}</a>
                                                    @elseif(Route::currentRouteName()=='students_of_prof')
                                                        <a href="{{URL::TO('prof/'.$branche->coordinateur.'/students/brancheF/'.$branche->id_BrF)}}" class="btn btn btn-outline-info">{{trans('Show Students')}}</a>
                                                    @elseif(Route::currentRouteName()=='students_of_prof_brf_completed')
                                                        <a href="{{URL::TO('prof/'.$branche->coordinateur.'/completed.students/brancheF/'.$branche->id_BrF)}}" class="btn btn btn-outline-info">{{trans('Show Students')}}</a>
                                                    @elseif(Route::currentRouteName()=='students_of_prof_brf_uncompleted')
                                                        <a href="{{URL::TO('prof/'.$branche->coordinateur.'/uncompleted.students/brancheF/'.$branche->id_BrF)}}" class="btn btn btn-outline-info">{{trans('Show Students')}}</a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
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
    
    @include('scripts.delete-modal-script')
    @include('scripts.save-modal-script')
    @if(config('usersmanagement.tooltipsEnabled'))
        @include('scripts.tooltips')
    @endif
    @if(config('usersmanagement.enableSearchUsers'))
        @include('scripts.search-users')
    @endif
@endsection
