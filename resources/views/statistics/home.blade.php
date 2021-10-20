@extends('layouts.app')

@section('template_title')
    {{trans("Statistic Home ")}}
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
                                {!! trans('Statistics :') !!}
                            </span>
                            
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row d-flex justify-content-center " style="column-gap:20px;" >
                            <div class="card " style="width: 18rem;">
                                <img src="{{ asset('custom_symlink/home_icons/statistics_1.jpg') }}" class="card-img-top img_icon " alt="...">
                                <div class="card-body">
                                    <h5 class="card-title"> <strong> {{trans('Statistics :')}}</strong></h5>
                                    <p class="card-text">{{trans('Representation of students by formation.')}}</p>
                                </div>
                                
                                <div class="card-body">
                                    <a href="{{URL::TO('/statistics/charts/1')}}" class="card-link">{{trans('Show Statistics')}}</a>
                                    
                                </div>
                            </div>
                            <div class="card " style="width: 18rem;">
                                <img src="{{ asset('custom_symlink/home_icons/statistics_3.png') }}" class="card-img-top img_icon" alt="...">
                                <div class="card-body">
                                    <h5 class="card-title"> <strong> {{trans('Statistics :')}}</strong></h5>
                                    <p class="card-text">{{trans('Representation of students by branche of formation.')}}</p>
                                </div>
                                
                                <div class="card-body">
                                    <a href="{{URL::TO('/statistics/charts/2')}}" class="card-link">{{trans('Show Statistics')}}</a>
                                    
                                </div>
                            </div>
                            <div class="card " style="width: 18rem;">
                                <img src="{{ asset('custom_symlink/home_icons/statistics_2.jpg') }}" class="card-img-top img_icon" alt="...">
                                <div class="card-body">
                                    <h5 class="card-title"> <strong> {{trans('Statistics :')}}</strong></h5>
                                    <p class="card-text">{{trans('Representation of formation by their branches depending on number of students.')}}</p>
                                </div>
                                
                                <div class="card-body">
                                    <a href="{{URL::TO('/statistics/formations')}}" class="card-link">{{trans('Show Statistics')}}</a>
                                    
                                </div>
                            </div>
                            <div class="card " style="width: 18rem;">
                                <img src="{{ asset('custom_symlink/home_icons/statistics_4.jpg') }}" class="card-img-top img_icon" alt="...">
                                <div class="card-body">
                                    <h5 class="card-title"> <strong> {{trans('Statistics :')}}</strong></h5>
                                    <p class="card-text">{{trans('Representation of students by their payment status.')}}</p>
                                </div>
                                
                                <div class="card-body">
                                    <a href="{{URL::TO('/statistics/charts/3')}}" class="card-link">{{trans('Show Statistics')}}</a>
                                    
                                </div>
                            </div>
                       
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
    
@endsection
