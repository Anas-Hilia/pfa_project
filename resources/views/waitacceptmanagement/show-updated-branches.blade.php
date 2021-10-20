@extends('layouts.app')

@section('template_title')
    {!! trans('showing-branches') !!}
@endsection

@section('template_linked_css')
    @if(config('brancheFsmanagement.enabledDatatablesJs'))
        <link rel="stylesheet" type="text/css" href="{{ config('brancheFsmanagement.datatablesCssCDN') }}">
    @endif
    <style type="text/css" media="screen">
        .brancheFs-table {
            border: 0;
        }
        .brancheFs-table tr td:first-child {
            padding-left: 15px;
        }
        .brancheFs-table tr td:last-child {
            padding-right: 15px;
        }
        .brancheFs-table.table-responsive,
        .brancheFs-table.table-responsive table {
            margin-bottom: 0;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            {{-- show allert --}}
            <div class="col-12">
               <!-- view file -->
                @if(Session::has('msg'))
                <div class="alert {{ Session::get('alert-class', 'alert-info') }} alert-dismissible fade show">
                    {{ Session::get('msg') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif
            </div>
            
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">

                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                
                                {!! trans('Showing branches recently updated') !!}
                                
                            </span>

                            <div class="btn-group pull-right btn-group-xs">
                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-ellipsis-v fa-fw" aria-hidden="true"></i>
                                    {{-- <span class="sr-only">
                                        {!! trans('usersmanagement.users-menu-alt') !!}
                                    </span> --}}
                                </button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="{{ URL::to('BranchesFs/create')}}">
                                        <i class="fa fa-fw fa-plus" aria-hidden="true"></i>
                                        {!! trans('create new branche') !!}
                                    </a>
                                    <a class="dropdown-item" href="{{ URL::to('BranchesFs/deleted')}}">
                                        <i class="fa fa-fw fa-trash" aria-hidden="true"></i>
                                        {!! trans('show deleted branches') !!}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">

                        @if(config('brancheFsmanagement.enableSearchbrancheFs'))
                            @include('partials.search-brancheFs-form')
                        @endif

                        <div class="table-responsive brancheFs-table">
                            <table class="table table-striped table-sm data-table">
                                <caption id="brancheF_count">
                                    {!!  
                                        $nbr_brancheF = $brancheFs->count();
                        
                                        if($nbr_brancheF==1) 
                                            echo ' branche total' ;
                                        else  
                                            echo ' branches total';
                                    !!} 
                                </caption>
                                <thead class="thead">
                                    <tr>
                                        <th>{!! trans('Id') !!}</th>
                                        <th>{!! trans('Branche Name') !!}</th>
                                        <th class="hidden-xs">{!! trans('Formation') !!}</th>
                                        <th class="hidden-sm hidden-xs hidden-md" >{!! trans('Coordinator Email') !!}</th>
                                        <th>{!! trans('Actions') !!}</th>
                                        <th class="no-search no-sort"></th>
                                        <th class="no-search no-sort"></th>
                                    </tr>
                                </thead>
                                <tbody id="brancheFs_table">
                                    @foreach($brancheFs as $brancheF)
                                        <tr>
                                            <td>{{$brancheF->id_BrF}}</td>
                                            <td>
                                                <a style="color: black;" href="{{ URL::to('BranchesFs/' . $brancheF->id_BrF) }}" data-toggle="tooltip" title="Show more detail ">
                                                    {{$brancheF->brf_name}}
                                                </a>                                           
                                            </td>
                                            <td class="hidden-xs">{{$brancheF->form_name}}</td>
                                            <td class="hidden-sm hidden-xs hidden-md"><a href="mailto:{{ $brancheF->email_cord }}" title="email {{ $brancheF->email_cord }}">{{ $brancheF->email_cord }}</a></td> 
                                            <td>
                                                <a class="btn btn-sm btn-success btn-block" href="{{ URL::to('/branches/updated/' . $brancheF->id_BrF.'/accept') }}" data-toggle="tooltip" title="Show">
                                                    {!! trans('Accept') !!}
                                                </a>
                                            </td>
                                            <td>
                                                {!! Form::open(array('url' => '/branches/updated/' . $brancheF->id_BrF.'/refuse', 'class' => '', 'data-toggle' => 'tooltip', 'title' => 'Delete formation')) !!}
                                                    {!! Form::button(trans('Refuse'), array('class' => 'btn btn-danger btn-sm','type' => 'button', 'style' =>'width: 100%;' ,'data-toggle' => 'modal', 'data-target' => '#confirmDelete', 'data-title' => 'Delete formation', 'data-message' => 'Are you sure you want to refuse creation of this branche of formation ?')) !!}
                                                {!! Form::close() !!}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tbody id="search_results"></tbody>
                                @if(config('brancheFsmanagement.enableSearchbrancheFs'))
                                    <tbody id="search_results"></tbody>
                                @endif

                            </table>

                            @if(config('brancheFsmanagement.enablePagination'))
                                {{ $brancheFs->links() }}
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
    @if ((count($brancheFs) > config('brancheFsmanagement.datatablesJsStartCount')) && config('brancheFsmanagement.enabledDatatablesJs'))
        @include('scripts.datatables')
    @endif
    @include('scripts.delete-modal-script')
    @include('scripts.save-modal-script')
    @if(config('brancheFsmanagement.tooltipsEnabled'))
        @include('scripts.tooltips')
    @endif
    @if(config('brancheFsmanagement.enableSearchbrancheFs'))
        @include('scripts.search-brancheFs')
    @endif
@endsection
