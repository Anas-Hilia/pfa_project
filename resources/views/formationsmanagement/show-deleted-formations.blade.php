@extends('layouts.app')

@section('template_title')
    {!!trans('show-deleted-formations')!!}

@endsection

@section('template_linked_css')
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css">
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
            margin-bottom: .15em;
        }
        .btn__{
            max-width:100px; 
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header bg-danger text-white">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span id="card_title">
                                {!!trans('Show deleted Formations')!!}
                            </span>
                            <div class="float-right">
                                <a href="{{ route('formations') }}" class="btn btn-light btn-sm float-right" data-toggle="tooltip" data-placement="left" title="{{ trans('back-to-formations') }}">
                                    <i class="fa fa-fw fa-mail-reply" aria-hidden="true"></i>
                                    {!! trans('back to formations') !!}
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">

                        @if(count($formations) === 0)

                            <tr>
                                <p class="text-center margin-half">
                                    {!! trans('no-records') !!}
                                </p>
                            </tr>

                        @else
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
                                        <th class="hidden-xs" >{!! trans('Type') !!}</th>
                                        <th class="hidden-sm hidden-xs hidden-md">{!! trans('Max Number') !!}</th>
                                        <th class="hidden-xs">{{trans('Deleted By')}}</th>
                                        <th>{!! trans('Branches') !!}</th>
                                        <th class="">{{ trans('Actions')}}</th>
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
                                            <td class="hidden-xs">

                                            @if ($formation->fname_uwd && $formation->lname_uwd )    
                                                <a href="{{ URL::to( 'users/'. $formation->id_uwd ) }}" >{{ $formation->lname_uwd . ' ' . $formation->fname_uwd }}</a>
                                            @endif
                                            
                                            </td>                                             
                                            
                                            <td>
                                                <a class="btn btn-sm btn-primary btn-block btn__"  href="{{ URL::to('formations/'.$formation->id.'/branches' ) }}" data-toggle="tooltip" title="{{trans('Show branches')}}">
                                                    {!! trans('branches') !!}
                                                </a>
                                            </td>
                                            <td>
                                                {!! Form::model($formation, array('action' => array('SoftDeletesFormationsController@update', $formation->id), 'method' => 'PUT', 'data-toggle' => 'tooltip')) !!}
                                                    {!! Form::button('<i class="fa fa-refresh" aria-hidden="true"></i>', array('class' => 'btn btn-success btn-block btn-sm', 'type' => 'submit', 'data-toggle' => 'tooltip', 'title' => 'Restore formation')) !!}
                                                {!! Form::close() !!}
                                            </td>
                                            <td>
                                                <a class="btn btn-sm btn-info btn-block btn__" href="{{ URL::to('formations/deleted/' . $formation->id) }}" data-toggle="tooltip" title="Show formation">
                                                    <i class="fa fa-eye fa-fw" aria-hidden="true"></i>
                                                </a>
                                            </td>
                                            <td>
                                                {!! Form::model($formation, array('action' => array('SoftDeletesFormationsController@destroy', $formation->id), 'method' => 'DELETE', 'class' => 'inline', 'data-toggle' => 'tooltip', 'title' => 'Destroy formation Record')) !!}
                                                    {!! Form::hidden('_method', 'DELETE') !!}
                                                    {!! Form::button('<i class="fa fa-trash" aria-hidden="true"></i>', array('class' => 'btn btn-danger btn-sm inline btn__','type' => 'button', 'style' =>'width: 100%;' ,'data-toggle' => 'modal', 'data-target' => '#confirmDelete', 'data-title' => 'Delete formation', 'data-message' => 'Are you sure you want to delete this formation ?')) !!}
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
                            

                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('modals.modal-delete')

@endsection

@section('footer_scripts')

    @if (count($formations) > 10)
        @include('scripts.datatables')
    @endif
    @include('scripts.delete-modal-script')
    @include('scripts.save-modal-script')
    @include('scripts.tooltips')

@endsection
