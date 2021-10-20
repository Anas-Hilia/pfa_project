{{-- @dd(Route::currentRouteName()) --}}
<script>
    $(function() {
        var cardTitle = $('#card_title');
        var usersTable = $('#users_table');
        var resultsContainer = $('#search_results');
        var usersCount = $('#user_count');
        var clearSearchTrigger = $('.clear-search');
        var searchform = $('#search_users');
        var searchformInput = $('#user_search_box');
        var userPagination = $('#user_pagination');
        var searchSubmit = $('#search_trigger');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        searchform.submit(function(e) {
            e.preventDefault();
            resultsContainer.html('');
            usersTable.hide();
            clearSearchTrigger.show();
            let noResulsHtml = '<tr>' +
                                '<td>{!! trans("usersmanagement.search.no-results") !!}</td>' +
                                '<td></td>' +
                                '<td class="hidden-xs"></td>' +
                                '<td class="hidden-xs"></td>' +
                                '<td class="hidden-xs"></td>' +
                                '<td class="hidden-sm hidden-xs"></td>' +
                                '<td class="hidden-sm hidden-xs hidden-md"></td>' +
                                '<td class="hidden-sm hidden-xs hidden-md"></td>' +
                                '<td></td>' +
                                '<td></td>' +
                                '<td></td>' +
                                '</tr>';
                                
            $.ajax({
                type:'POST',
                url: "{{ route('search-users') }}",
                data: searchform.serialize(),
                success: function (result) {
                    let jsonData = JSON.parse(result);
                    if (jsonData.length != 0) {
                        $.each(jsonData, function(index, val) {
                            let emailHTML = '<a href="mailto:'+ val.email + '" title="email '+ val.email +'">'+ val.email +'</a>';
                            let rolesHtml = '';
                            let roleClass = '';
                            let showCellHtml = '<a class="btn btn-sm btn-success btn-block" href="/users/' + val.id + '" data-toggle="tooltip" title="{{ trans("usersmanagement.tooltips.show") }}">{!! trans("usersmanagement.buttons.show") !!}</a>';
                            let editCellHtml = '<a class="btn btn-sm btn-info btn-block" href="/users/' + val.id + '/edit" data-toggle="tooltip" title="{{ trans("usersmanagement.tooltips.edit") }}">{!! trans("usersmanagement.buttons.edit") !!}</a>';
                            let deleteCellHtml = '<form method="POST" action="/users/'+ val.id +'" accept-charset="UTF-8" data-toggle="tooltip" title="Delete">' +
                                    '{!! Form::hidden("_method", "DELETE") !!}' +
                                    '{!! csrf_field() !!}' +
                                    '<button class="btn btn-danger btn-sm" type="button" style="width: 100%;" data-toggle="modal" data-target="#confirmDelete" data-title="Delete User" data-message="{!! trans("usersmanagement.modals.delete_user_message", ["user" => "'+val.name+'"]) !!}">' +
                                        '{!! trans("usersmanagement.buttons.delete") !!}' +
                                    '</button>' +
                                '</form>';

                            $.each(val.roles, function(roleIndex, role) {
                                if (role.name == "Student") {
                                    roleClass = 'success';
                                } else if (role.name == "Professor") {
                                    roleClass = 'primary';
                                } else {
                                    roleClass = 'default';
                                };
                                rolesHtml = '<span class="badge badge-' + roleClass + '">' + role.name + '</span> ';
                                @if (Route::currentRouteName()=='students' || 
                                                 Route::currentRouteName()=='students_of_prof_formation' ||
                                                 Route::currentRouteName()=='students_validate' ||
                                                 Route::currentRouteName()=='students_of_prof_completed' ||
                                                 Route::currentRouteName()=='students_of_prof_uncompleted')
                                                        
                                        if(val.validate==0){
                                            status='Unactivated';
                                            badgeClass='warning';
                                        }else{
                                            status='Activated';
                                            badgeClass='success';
                                        }
                                        statusHTML ='<span class="badge badge-'+ badgeClass +'">' + status + '</span>';
                                        
                                        // if(val.status_tr1==0){
                                        //     status='Uncompleted';
                                        //     badgeClass='warning';
                                        // }else{
                                        //     status='Completed';
                                        //     badgeClass='success';
                                        // }
                                        // tr1HTML ='<span class="badge badge-'+ badgeClass +'">' + status + '</span>';
                                        
                                        // if(val.status_tr2==0){
                                        //     status='Uncompleted';
                                        //     badgeClass='warning';
                                        // }else{
                                        //     status='Completed';
                                        //     badgeClass='success';
                                        // }
                                        // tr2HTML ='<span class="badge badge-'+ badgeClass +'">' + status + '</span>';
                                @endif
                            });
                            resultsContainer.append('<tr>' +
                                '<td>' + val.id + '</td>' +
                                '<td>' + emailHTML + '</td>' +
                                '<td class="hidden-xs">' + val.first_name + '</td>' +
                                '<td class="hidden-xs">' + val.last_name + '</td>' +
                                '<td> ' + rolesHtml  +'</td>' +
                                @if (Route::currentRouteName()=='students' || 
                                                 Route::currentRouteName()=='students_of_prof_formation' ||
                                                 Route::currentRouteName()=='students_validate' ||
                                                 Route::currentRouteName()=='students_of_prof_completed' ||
                                                 Route::currentRouteName()=='students_of_prof_uncompleted')
                                                 '<td>' + statusHTML + '</td>' +
                                                //  '<td>' + tr1HTML + '</td>' +
                                                //  '<td>' + tr2HTML + '</td>' +
                                @endif
                                '<td>' + showCellHtml + '</td>' +
                                @if(Auth::User()->currentUserRole==1)
                                '<td>' + editCellHtml + '</td>' +
                                '<td>' + deleteCellHtml + '</td>' +
                                @endif
                            '</tr>');
                        });
                    } else {
                        resultsContainer.append(noResulsHtml);
                    };
                    usersCount.html(jsonData.length + " {!! trans('usersmanagement.search.found-footer') !!}");
                    userPagination.hide();
                    cardTitle.html("{!! trans('usersmanagement.search.title') !!}");
                },
                error: function (response, status, error) {
                    if (response.status === 422) {
                        resultsContainer.append(noResulsHtml);
                        usersCount.html(0 + " {!! trans('usersmanagement.search.found-footer') !!}");
                        userPagination.hide();
                        cardTitle.html("{!! trans('usersmanagement.search.title') !!}");
                    };
                },
            });
        });
        searchSubmit.click(function(event) {
            event.preventDefault();
            searchform.submit();
        });
        searchformInput.keyup(function(event) {
            if ($('#user_search_box').val() != '') {
                clearSearchTrigger.show();
            } else {
                clearSearchTrigger.hide();
                resultsContainer.html('');
                usersTable.show();
                cardTitle.html(
                    @if (Route::currentRouteName()=='students')
                        "{!! trans('Showing all students') !!}"
                    @elseif(Route::currentRouteName()=='students_of_prof_formation')
                        "{!! trans('Showing Activated students') !!}"
                    @elseif(Route::currentRouteName()=='students_validate')
                        "{!! trans('Showing Unactivated students') !!}"
                    @elseif(Route::currentRouteName()=='students_of_prof_completed')
                        "{!! trans('Showing Students with Complete paymnet :') !!}"
                    @elseif(Route::currentRouteName()=='students_of_prof_uncompleted')
                        "{!! trans('Showing Students with incomplete paymnet :') !!}"
                    @elseif(Route::currentRouteName()=='profs')
                        "{!! trans('Showing all professors') !!}"
                    @else
                        "{!! trans('usersmanagement.showing-all-users') !!}"
                    @endif
                    );
                userPagination.show();
                usersCount.html(" ");
            };
        });
        clearSearchTrigger.click(function(e) {
            e.preventDefault();
            clearSearchTrigger.hide();
            usersTable.show();
            resultsContainer.html('');
            searchformInput.val('');
            cardTitle.html("{!! trans('usersmanagement.showing-all-users') !!}");
            userPagination.show();
            usersCount.html(" ");
        });
    });
</script>
