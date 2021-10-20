<div class="row">
    <div class="col-sm-8 offset-sm-4 col-md-6 offset-md-6 col-lg-5 offset-lg-7 col-xl-4 offset-xl-8">
        {!! Form::open(['route' => 'search-users', 'method' => 'POST', 'role' => 'form', 'class' => 'needs-validation', 'id' => 'search_users']) !!}
            {!! csrf_field() !!}
            <div class="input-group mb-3">
                {!! Form::hidden('routeName', json_encode(Route::CurrentRouteName())) !!}
                @if (   Route::currentRouteName()=='students_of_prof_formation' ||
                        Route::currentRouteName()=='students_validate' ||
                        Route::currentRouteName()=='students_of_prof_completed' ||
                        Route::currentRouteName()=='students_of_prof_uncompleted')

                    {!! Form::hidden('id1', json_encode(Request::route('id1'))) !!}
                    {!! Form::hidden('id2', json_encode(Request::route('id2'))) !!}
                    

                @endif
                {!! Form::text('user_search_box', NULL, ['id' => 'user_search_box', 'class' => 'form-control', 'placeholder' => trans('Search by Email'), 'aria-label' => trans('usersmanagement.search.search-users-ph'), 'required' => true]) !!}
                <div class="input-group-append">
                    <a href="#" class="input-group-addon btn btn-warning clear-search" data-toggle="tooltip" title="{{ trans('usersmanagement.tooltips.clear-search') }}" style="display:none;">
                        <i class="fa fa-fw fa-times" aria-hidden="true"></i>
                        <span class="sr-only">
                            {!! trans('usersmanagement.tooltips.clear-search') !!}
                        </span>
                    </a>
                    <a href="#" class="input-group-addon btn btn-secondary" id="search_trigger" data-toggle="tooltip" data-placement="bottom" title="{{ trans('usersmanagement.tooltips.submit-search') }}" >
                        <i class="fa fa-search fa-fw" aria-hidden="true"></i>
                        <span class="sr-only">
                            {!!  trans('usersmanagement.tooltips.submit-search') !!}
                        </span>
                    </a>
                </div>
            </div>
        {!! Form::close() !!}
        
    </div>
</div>
