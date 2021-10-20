<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
| Middleware options can be located in `app/Http/Kernel.php`
|
*/

// Homepage Route
Route::group(['middleware' => ['web', 'checkblocked']], function () {
    Route::get('/', 'App\Http\Controllers\Auth\LoginController@showLoginForm')->name('login');
    Route::get('/terms', 'App\Http\Controllers\TermsController@terms')->name('terms');
});

// Authentication Routes
Auth::routes();

//lang route
Route::get('lang/{locale}', 'App\Http\Controllers\LocalizationController@index');


// Public Routes
// Route::group(['middleware' => ['web', 'activity', 'checkblocked']], function () {

//     // Activation Routes
//     Route::get('/activate', ['as' => 'activate', 'uses' => 'App\Http\Controllers\Auth\ActivateController@initial']);

//     Route::get('/activate/{token}', ['as' => 'authenticated.activate', 'uses' => 'App\Http\Controllers\Auth\ActivateController@activate']);
//     Route::get('/activation', ['as' => 'authenticated.activation-resend', 'uses' => 'App\Http\Controllers\Auth\ActivateController@resend']);
//     Route::get('/exceeded', ['as' => 'exceeded', 'uses' => 'App\Http\Controllers\Auth\ActivateController@exceeded']);

//     // Socialite Register Routes
//     Route::get('/social/redirect/{provider}', ['as' => 'social.redirect', 'uses' => 'App\Http\Controllers\Auth\SocialController@getSocialRedirect']);
//     Route::get('/social/handle/{provider}', ['as' => 'social.handle', 'uses' => 'App\Http\Controllers\Auth\SocialController@getSocialHandle']);

//     // Route to for user to reactivate their user deleted account.
//     Route::get('/re-activate/{token}', ['as' => 'user.reactivate', 'uses' => 'App\Http\Controllers\RestoreUserController@userReActivate']);
// });

// Registered and Activated User Routes
Route::group(['middleware' => ['auth', 'activity', 'checkblocked']], function () {

    // Activation Routes
    Route::get('/activation-required', ['uses' => 'App\Http\Controllers\Auth\ActivateController@activationRequired'])->name('activation-required');
    Route::get('/logout', ['uses' => 'App\Http\Controllers\Auth\LoginController@logout'])->name('logout');
});

// Registered and Activated User Routes
Route::group(['middleware' => ['auth', 'activity', 'twostep', 'checkblocked']], function () {

    //  Homepage Route - Redirect based on user role is in controller.
    Route::get('/home', ['as' => 'public.home',   'uses' => 'App\Http\Controllers\UserController@index']);

    // Show users profile - viewable by other users.
    Route::get('profile/{id}', [
        'as'   => '{id}',
        'uses' => 'App\Http\Controllers\ProfilesController@show',
    ]);
});
//-----formation-------
Route::group(['middleware' => ['auth', 'role:admin', 'activity', 'twostep', 'checkblocked']], function () {
    
    Route::resource('themes', \App\Http\Controllers\ThemesManagementController::class, [
        'names' => [
            'index'   => 'themes',
            'destroy' => 'themes.destroy',
        ],
    ]);

    Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
    Route::get('routes', 'App\Http\Controllers\AdminDetailsController@listRoutes');
    Route::get('active-users', 'App\Http\Controllers\AdminDetailsController@activeUsers');
});
//----------------------Formations------------------------


Route::group(['middleware' => ['auth', 'activity', 'twostep', 'checkblocked']], function () {

    //  Homepage Route - Redirect based on user role is in controller.
    Route::get('formations', ['as' => 'formations',   'uses' => 'App\Http\Controllers\FormationController@index']);
    Route::get('/prof/{id}/formations', ['as' => 'formations_prof',   'uses' => 'App\Http\Controllers\FormationController@index']);

   
    
});



//----------------------BranchesFs---------------------
Route::group(['middleware' => ['auth', 'activity', 'twostep', 'checkblocked']], function () {

    
    //  Homepage Route - Redirect based on user role is in controller.
    Route::get('formations/{id}/branches', ['as' => 'BranchesFs',   'uses' => 'App\Http\Controllers\BrancheFController@index']);
    Route::get('formations/{id_1}/branches/prof/{id_2}', ['as' => 'BranchesFs_prof',   'uses' => 'App\Http\Controllers\BrancheFController@index']);
    
   
   
});



//--------------------------------------------------------


// Registered, activated, and is current user routes.
Route::group(['middleware' => ['auth', 'currentUser', 'activity', 'twostep', 'checkblocked']], function () {

    // User Profile and Account Routes
    Route::resource(
        'profile',
        \App\Http\Controllers\ProfilesController::class,
        [
            'only' => [
                'show',
                'edit',
                'update',
                'create',
            ],
        ]
    );
    Route::put('profile/{username}/updateUserAccount', [
        'as'   => '{username}',
        'uses' => 'App\Http\Controllers\ProfilesController@updateUserAccount',
    ]);
    Route::put('profile/{username}/updateUserPassword', [
        'as'   => '{username}',
        'uses' => 'App\Http\Controllers\ProfilesController@updateUserPassword',
    ]);
    Route::delete('profile/{username}/deleteUserAccount', [
        'as'   => '{username}',
        'uses' => 'App\Http\Controllers\ProfilesController@deleteUserAccount',
    ]);

    // Route to show user avatar
    Route::get('images/profile/{id}/avatar/{image}', [
        'uses' => 'App\Http\Controllers\ProfilesController@userProfileAvatar',
    ]);

    // Route to upload user avatar.
    Route::post('avatar/upload', ['as' => 'avatar.upload', 'uses' => 'App\Http\Controllers\ProfilesController@upload']);
});

// Registered, activated, and is admin routes.
Route::group(['middleware' => ['auth', 'role:admin', 'activity', 'twostep', 'checkblocked']], function () {
    Route::resource('/users/deleted', \App\Http\Controllers\SoftDeletesController::class, [
        'only' => [
            'index', 'show', 'update', 'destroy',
        ],
    ]);

    Route::resource('/formations/deleted', \App\Http\Controllers\SoftDeletesFormationsController::class, [
        'only' => [
            'index', 'show', 'update', 'destroy',
        ],
    ]);

    Route::resource('/BranchesFs/deleted', \App\Http\Controllers\SoftDeletesBrancheFsController::class, [
        'only' => [
            'index', 'show', 'update', 'destroy',
        ],
    ]);
    //----Formation------accepte create--------------  
    Route::get('/formations/created', [
        'uses' => 'App\Http\Controllers\AcceptCU\FormationsWaitAcceptController@created',
    ]);

    Route::get('/formations/created/{id}/accept', [
        'uses' => 'App\Http\Controllers\AcceptCU\FormationsWaitAcceptController@createdAccept',
    ]);
    Route::get('/formations/created/{id}/refuse', [
        'uses' => 'App\Http\Controllers\AcceptCU\FormationsWaitAcceptController@createdRefuse',
    ]);
    //------------accept update--------------
    Route::get('/formations/updated', [
        'uses' => 'App\Http\Controllers\AcceptCU\FormationsWaitAcceptController@updated',
    ]);

    Route::get('/formations/updated/{id}/accept', [
        'uses' => 'App\Http\Controllers\AcceptCU\FormationsWaitAcceptController@updatedAccept',
    ]);
    Route::get('/formations/updated/{id}/refuse', [
        'uses' => 'App\Http\Controllers\AcceptCU\FormationsWaitAcceptController@updatedRefuse',
    ]);

    //----------------------------------------

//----Branches------accepte create--------------  
Route::get('/branches/created', [
    'uses' => 'App\Http\Controllers\AcceptCU\BranchesWaitAcceptController@created',
]);

Route::get('/branches/created/{id}/accept', [
    'uses' => 'App\Http\Controllers\AcceptCU\BranchesWaitAcceptController@createdAccept',
]);
Route::get('/branches/created/{id}/refuse', [
    'uses' => 'App\Http\Controllers\AcceptCU\BranchesWaitAcceptController@createdRefuse',
]);
//------------accept update--------------
Route::get('/branches/updated', [
    'uses' => 'App\Http\Controllers\AcceptCU\BranchesWaitAcceptController@updated',
]);

Route::get('/branches/updated/{id}/accept', [
    'uses' => 'App\Http\Controllers\AcceptCU\BranchesWaitAcceptController@updatedAccept',
]);
Route::get('/branches/updated/{id}/refuse', [
    'uses' => 'App\Http\Controllers\AcceptCU\BranchesWaitAcceptController@updatedRefuse',
]);

//----------------------------------------

    Route::resource('users', \App\Http\Controllers\UsersManagementController::class, [
        'names' => [
            'index' => 'users',
            'destroy' => 'user.destroy',
            //------------------
            'show', 'update',

        ],
        'except' => [
            'deleted',
        ],
    ]);
    Route::resource('formations', \App\Http\Controllers\FormationCrudController::class, [
        'names' => [
            'destroy' => 'formations.destroy',
            //------------------
            'show', 'update',

        ],
        'except' => [
            'index',
            'deleted',
        ],
    ]);
    Route::resource('BranchesFs', \App\Http\Controllers\BranchesFCrudController::class, [
        'names' => [
            'destroy' => 'BranchesFs.destroy',
            //------------------
            'show', 'update',

        ],
        'except' => [
            'deleted',
        ],
    ]);

    
    Route::get('profs', [
        'as'   => 'profs',
        'uses' => 'App\Http\Controllers\UsersManagementController@index_profs',
    ]);
    Route::get('students', [
        'as'   => 'students',
        'uses' => 'App\Http\Controllers\UsersManagementController@index_students',
    ]);
    Route::get('/prof/{id}/students', [
        'as'   => 'students_of_prof',
        'uses' => 'App\Http\Controllers\UsersManagementController@formOfprof',
    ]);
    Route::get('/prof/{id1}/students/brancheF/{id2}', [
        'as'   => 'students_of_prof_formation',
        'uses' => 'App\Http\Controllers\UsersManagementController@index_students',
    ]);

    Route::get('/prof/{id}/validate.students', [
        'as'   => 'students_validate_brf',
        'uses' => 'App\Http\Controllers\UsersManagementController@formOfprof',
    ]);
    Route::get('/prof/{id1}/validate.students/brancheF/{id2}', [
        'as'   => 'students_validate',
        'uses' => 'App\Http\Controllers\UsersManagementController@index_students',
    ]);
    Route::get('/prof/{id}/completed.students', [
        'as'   => 'students_of_prof_brf_completed',
        'uses' => 'App\Http\Controllers\UsersManagementController@formOfprof',
    ]);
    Route::get('/prof/{id}/uncompleted.students', [
        'as'   => 'students_of_prof_brf_uncompleted',
        'uses' => 'App\Http\Controllers\UsersManagementController@formOfprof',
    ]);
    Route::get('/prof/{id1}/completed.students/brancheF/{id2}', [
        'as'   => 'students_of_prof_completed',
        'uses' => 'App\Http\Controllers\UsersManagementController@index_students',
    ]);
    Route::get('/prof/{id1}/uncompleted.students/brancheF/{id2}', [
        'as'   => 'students_of_prof_uncompleted',
        'uses' => 'App\Http\Controllers\UsersManagementController@index_students',
    ]);
    Route::get('/users/{id}/accept', [
        'as'   => 'students_accept',
        'uses' => 'App\Http\Controllers\UsersManagementController@student_accept',
    ]);
    Route::get('/users/{id}/refuse', [
        'as'   => 'students_refuse',
        'uses' => 'App\Http\Controllers\UsersManagementController@student_refuse',
    ]);
    //------------------Charts----------------------
    Route::get('/statistics/home', [
        'as'   => 'statistics_home',
        'uses' => 'App\Http\Controllers\StatisticsController@index',
    ]);
    Route::get('/statistics/charts/{id}', [
        'as'   => 'statistics_charts',
        'uses' => 'App\Http\Controllers\StatisticsController@charts',
    ]);
    Route::get('/statistics/formations', [
        'as'   => 'statistics_byFormation',
        'uses' => 'App\Http\Controllers\StatisticsController@chartsByFormation',
    ]);
    Route::get('/statistics/formations/{id}/charts', [
        'as'   => 'statistics_byFormation_charts',
        'uses' => 'App\Http\Controllers\StatisticsController@chartsByFormation',
    ]);
    //----------------Import Export------------------------
    Route::post('search-users', 'App\Http\Controllers\UsersManagementController@search')->name('search-users');
    Route::get('/students/ImportExport', [
        'as'   => 'students_ImportExport',
        'uses' => 'App\Http\Controllers\UsersManagementController@students_ImportExport',
    ]);
    Route::post('/students/Import', [
        'as'   => 'students_import',
        'uses' => 'App\Http\Controllers\UsersManagementController@students_import',
    ]);
    Route::get('/students/Export', [
        'as'   => 'students_export',
        'uses' => 'App\Http\Controllers\UsersManagementController@students_export',
    ]);
    Route::get('/students/ShortExport', [
        'as'   => 'students_short_export',
        'uses' => 'App\Http\Controllers\UsersManagementController@students_short_export',
    ]);
    
    //-----------------------------------------------------

    Route::resource('themes', \App\Http\Controllers\ThemesManagementController::class, [
        'names' => [
            'index'   => 'themes',
            'destroy' => 'themes.destroy',
        ],
    ]);

    Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
    Route::get('routes', 'App\Http\Controllers\AdminDetailsController@listRoutes');
    Route::get('active-users', 'App\Http\Controllers\AdminDetailsController@activeUsers');
});

Route::redirect('/php', '/phpinfo', 301);
