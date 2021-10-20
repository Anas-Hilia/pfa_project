@extends('layouts.app')

@section('template_title')
    {!! trans('showing-all-formations') !!}
@endsection

@section('template_linked_css')
    @if(config('formationsmanagement.enabledDatatablesJs'))
        <link rel="stylesheet" type="text/css" href="{{ config('formationsmanagement.datatablesCssCDN') }}">
    @endif
    <style type="text/css" media="screen">
        .formations-table {
            border: 0;
        }
        .formations-table tr td:first-child {
            padding-left: 15px;
        }
        .formations-table tr td:last-child {
            padding-right: 15px;
        }
        .formations-table.table-responsive,
        .formations-table.table-responsive table {
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
                                
                                {!! trans('showing formations recently updated') !!}
                                
                            </span>

                            <div class="btn-group pull-right btn-group-xs">
                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-ellipsis-v fa-fw" aria-hidden="true"></i>
                                    {{-- <span class="sr-only">
                                        {!! trans('formationsmanagement.formations-menu-alt') !!}
                                    </span> --}}
                                </button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="formations/create">
                                        <i class="fa fa-fw fa-plus" aria-hidden="true"></i>
                                        {!! trans('create-new-formation') !!}
                                    </a>
                                    <a class="dropdown-item" href="/formations/deleted">
                                        <i class="fa fa-fw fa-trash" aria-hidden="true"></i>
                                        {!! trans('show-deleted-formations') !!}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">

                        @if(config('formationsmanagement.enableSearchformations'))
                            @include('partials.search-formations-form')
                        @endif

                        <div class="table-responsive formations-table">
                            <table class="table table-striped table-sm data-table">
                                <caption id="formation_count">
                                    {!!  
                                        $nbr_formation = $formations->count();
                        
                                        if($nbr_formation==1) 
                                            echo ' formation total' ;
                                        else  
                                            echo ' formations total';
                                    !!} 
                                </caption>
                                <thead class="thead">
                                    <tr>
                                        <th>{!! trans('Id') !!}</th>
                                        <th>{!! trans('Name') !!}</th>
                                        <th class="hidden-xs ">{!! trans('Type') !!}</th>
                                        <th class="hidden-sm hidden-xs hidden-md" >{!! trans('Max Number') !!}</th>
                                        <th >{!! trans('Actions') !!}</th>
                                        <th class="no-search no-sort"></th>
                                        <th class="no-search no-sort"></th>
                                        <th class="no-search no-sort"></th>
                                    </tr>
                                </thead>
                                <tbody id="formations_table">
                                    @foreach($formations as $formation)
                                        <tr>
                                            <td>{{$formation->id}}</td>
                                            <td>
                                                <a style="color:black;" href="{{ URL::to('formations/'.$formation->id ) }}" data-toggle="tooltip" title="{{trans('More Details')}}">
                                                    {{$formation->name}}
                                                </a>
                                            </td>
                                            <td class="hidden-xs">{{$formation->type}}</td> 
                                            <td class="hidden-sm hidden-xs hidden-md">{{$formation->nbr_max}}</td>                                           
                                            
                                            <td>
                                                
                                                <a class="btn btn-sm btn-primary btn-block" href="{{ URL::to('formations/'.$formation->id.'/branches' ) }}" data-toggle="tooltip" title="{{trans('Show branches')}}">
                                                    {!! trans('branches') !!}
                                                </a>
                                                    
                                            </td>
                                             <td>
                                                <a class="btn btn-sm btn-success btn-block" href="{{ URL::to('/formations/updated/' . $formation->id.'/accept') }}" data-toggle="tooltip" title="Show">
                                                    {!! trans('Accept') !!}
                                                </a>
                                            </td>
                                            <td>
                                                {!! Form::open(array('url' => '/formations/updated/' . $formation->id.'/refuse', 'class' => '', 'data-toggle' => 'tooltip', 'title' => 'Delete formation')) !!}
                                                    {!! Form::button(trans('Refuse'), array('class' => 'btn btn-danger btn-sm','type' => 'button', 'style' =>'width: 100%;' ,'data-toggle' => 'modal', 'data-target' => '#confirmDelete', 'data-title' => 'Delete formation', 'data-message' => trans('Are you sure you want to refuse updating this formation ( you want to delete it ? ) ?'))) !!}
                                                {!! Form::close() !!}
                                            </td>
                                           
                                            
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tbody id="search_results"></tbody>
                                @if(config('formationsmanagement.enableSearchformations'))
                                    <tbody id="search_results"></tbody>
                                @endif

                            </table>

                            @if(config('formationsmanagement.enablePagination'))
                                {{ $formations->links() }}
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
    @if ((count($formations) > config('formationsmanagement.datatablesJsStartCount')) && config('formationsmanagement.enabledDatatablesJs'))
        @include('scripts.datatables')
    @endif
    @include('scripts.delete-modal-script')
    @include('scripts.save-modal-script')
    @if(config('formationsmanagement.tooltipsEnabled'))
        @include('scripts.tooltips')
    @endif
    @if(config('formationsmanagement.enableSearchformations'))
        @include('scripts.search-formations')
    @endif
@endsection
