@extends('layouts.app')

@section('template_title')
    {!!trans('show-deleted-branches-Fs')!!}

@endsection

@section('template_linked_css')
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css">
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
            margin-bottom: .15em;
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
                                {!!trans('Show deleted Branches')!!}
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

                        @if(count($brancheFs) === 0)

                            <tr>
                                <p class="text-center margin-half">
                                    {!! trans('no-records') !!}
                                </p>
                            </tr>

                        @else

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
                                            <th class="hidden-sm hidden-xs hidden-md">{!! trans('Coordinator Email') !!}</th>
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
                                                <td class="hidden-sm hidden-xs hidden-md" ><a href="mailto:{{ $brancheF->email_cord }}" title="email {{ $brancheF->email_cord }}">{{ $brancheF->email_cord }}</a></td> 
                                                <td>
                                                    {!! Form::model($brancheF, array('action' => array('SoftDeletesBrancheFsController@update', $brancheF->id_BrF), 'method' => 'PUT', 'data-toggle' => 'tooltip')) !!}
                                                        {!! Form::button('<i class="fa fa-refresh" aria-hidden="true"></i>', array('class' => 'btn btn-success btn-block btn-sm', 'type' => 'submit', 'data-toggle' => 'tooltip', 'title' => 'Restore branche')) !!}
                                                    {!! Form::close() !!}
                                                </td>
                                                <td>
                                                    <a class="btn btn-sm btn-info btn-block btn__" href="{{ URL::to('BranchesFs/deleted/' . $brancheF->id_BrF) }}" data-toggle="tooltip" title="Show branche">
                                                        <i class="fa fa-eye fa-fw" aria-hidden="true"></i>
                                                    </a>
                                                </td>
                                                <td>
                                                    {!! Form::model($brancheF, array('action' => array('SoftDeletesBrancheFsController@destroy', $brancheF->id_BrF), 'method' => 'DELETE', 'class' => 'inline', 'data-toggle' => 'tooltip', 'title' => 'Destroy branche')) !!}
                                                        {!! Form::hidden('_method', 'DELETE') !!}
                                                        {!! Form::button('<i class="fa fa-trash" aria-hidden="true"></i>', array('class' => 'btn btn-danger btn-sm inline btn__','type' => 'button', 'style' =>'width: 100%;' ,'data-toggle' => 'modal', 'data-target' => '#confirmDelete', 'data-title' => 'Delete brancheF', 'data-message' => 'Are you sure you want to delete this branche of formation ?')) !!}
                                                    {!! Form::close() !!}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
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

    @if (count($brancheFs) > 10)
        @include('scripts.datatables')
    @endif
    @include('scripts.delete-modal-script')
    @include('scripts.save-modal-script')
    @include('scripts.tooltips')

@endsection
