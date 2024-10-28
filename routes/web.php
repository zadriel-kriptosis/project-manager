<?php

use App\Http\Controllers\Admin\Dashboard\indexController as SysDashboardController;
use App\Http\Controllers\Admin\Role\indexController as RoleController;
use App\Http\Controllers\Admin\Setting\indexController as SettingController;
use App\Http\Controllers\Admin\User\indexController as UserController;
use App\Http\Controllers\Admin\Company\indexController as AdminCompanyController;
use App\Http\Controllers\Admin\Project\indexController as AdminProjectController;
//use App\Http\Controllers\Admin\Demand\indexController as AdminDemandController;
//use App\Http\Controllers\UserAdmin\ProcessRecord\indexController as AdminProcessRecordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\User\Company\indexController as CompanyController;
use App\Http\Controllers\User\Project\indexController as ProjectController;
use App\Http\Controllers\User\Demand\indexController as DemandController;
use App\Http\Controllers\User\ProcessRecord\indexController as ProcessRecordController;
use Illuminate\Support\Facades\Route;

// Using an array to specify multiple middleware
Route::middleware(['web'])->group(function () {

//SITE CONTROLLERS (UN-AUTH SUPPORTED)
//    Route::get('test', [BaseController::class, 'test'])->name('test');

    Route::get('/', [SysDashboardController::class, 'index'])->name('home');
    Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [RegisterController::class, 'register']);
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login'])->name('login.post');
    Route::get('logout', [LoginController::class, 'logout'])->name('logout');


    Route::group(['prefix' => 'user', 'as' => 'user.', 'middleware' => 'auth'], function () {
        Route::prefix('company')
            ->name('company.')
            ->group(function () {
                Route::controller(CompanyController::class)->group(function () {
                    Route::get('/', 'index')->name('index');
                    Route::get('/create', 'create')->name('create');
                    Route::get('/edit/{id}', 'edit')->name('edit');
                    Route::post('/store', 'store')->name('store');
                    Route::put('/update/{id}', 'update')->name('update');
                    Route::get('/destroy/{id}', 'destroy')->name('destroy');
                    Route::get('/is_active/{id}', 'is_active')->name('is_active');
                    Route::post('/export', 'export')->name('export');
                    Route::get('/show/{slug}', 'show')->name('show');
                });
            });

        Route::prefix('project')
            ->name('project.')
            ->group(function () {
                Route::controller(ProjectController::class)->group(function () {
                    Route::get('/', 'index')->name('index');
                    Route::get('/create/{company}', 'create')->name('create');
                    Route::get('/edit/{id}', 'edit')->name('edit');
                    Route::post('/adduser/{id}', 'adduser')->name('adduser');
                    Route::delete('/deleteuser/{project_id}/{user_id}', 'deleteuser')->name('deleteuser');
                    Route::post('/store/{company}', 'store')->name('store');
                    Route::put('/update/{id}', 'update')->name('update');
                    Route::get('/destroy/{id}', 'destroy')->name('destroy');
                    Route::get('/is_active/{id}', 'is_active')->name('is_active');
                    Route::post('/export', 'export')->name('export');
                    Route::get('/show/{id}', 'show')->name('show');
                });
            });

        Route::prefix('processrecord')
            ->name('processrecord.')
            ->group(function () {
                Route::controller(ProcessRecordController::class)->group(function () {
                    Route::get('/', 'index')->name('index');
                    Route::get('/create', 'create')->name('create');
                    Route::get('/edit/{id}', 'edit')->name('edit');
                    Route::post('/store', 'store')->name('store');
                    Route::put('/update/{id}', 'update')->name('update');
                    Route::get('/destroy/{id}', 'destroy')->name('destroy');
                    Route::get('/is_active/{id}', 'is_active')->name('is_active');
                    Route::post('/export', 'export')->name('export');
                    Route::get('/show/{id}', 'show')->name('show');
                });
            });

        Route::prefix('demand')
            ->name('demand.')
            ->group(function () {
                Route::controller(DemandController::class)->group(function () {
                    Route::get('/', 'index')->name('index');
                    Route::get('/create/{project_id}/{type_id}', 'create')->name('create');
                    Route::get('/edit/{id}', 'edit')->name('edit');
                    Route::post('/store/{project_id}/{type_id}', 'store')->name('store');
                    Route::get('/gallery/add/{demand_id}', 'galleryaddview')->name('galleryaddview');
                    Route::post('/gallery/add/{demand_id}', 'galleryadd')->name('galleryadd');
                    Route::put('/update/{id}', 'update')->name('update');
                    Route::get('/destroy/{id}', 'destroy')->name('destroy');
                    Route::get('/is_active/{id}', 'is_active')->name('is_active');
                    Route::post('/export', 'export')->name('export');
                    Route::get('/show/{id}', 'show')->name('show');
                });
            });

    });


//ADMIN CONTROLLERS
    Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'auth'], function () {

        Route::prefix('dashboard')
            ->name('dashboard.')
            ->group(function () {
                Route::controller(SysDashboardController::class)->group(function () {
                    Route::get('/index', 'index')->name('index');
                });
            });

        Route::prefix('role')
            ->name('role.')
            ->group(function () {
                Route::controller(RoleController::class)->group(function () {
                    Route::get('/', 'index')->name('index');
                    Route::get('/edit/{uuid}', 'edit')->name('edit');
                    Route::put('/update/{uuid}', 'update')->name('update');
                    Route::get('/destroy/{uuid}', 'destroy')->name('destroy');
                    Route::post('/export', 'export')->name('export');
                });
            });


        Route::prefix('user')
            ->name('user.')
            ->group(function () {
                Route::controller(UserController::class)->group(function () {
                    Route::get('/', 'index')->name('index');
                    Route::get('/create', 'create')->name('create');
                    Route::get('/edit/{id}', 'edit')->name('edit');
                    Route::post('/store', 'store')->name('store');
                    Route::put('/update/{id}', 'update')->name('update');
                    Route::get('/destroy/{id}', 'destroy')->name('destroy');
                    Route::get('/is_active/{id}', 'is_active')->name('is_active');
                    Route::post('/ban_user/{id}', 'ban_user')->name('ban_user');
                    Route::post('/unban_user/{id}', 'unban_user')->name('unban_user');
                    Route::post('/export', 'export')->name('export');
                });
            });


        Route::prefix('setting')
            ->name('setting.')
            ->group(function () {
                Route::controller(SettingController::class)->group(function () {
                    Route::get('/', 'index')->name('index');
                    Route::get('/edit/{id}', 'edit')->name('edit');
                    Route::put('/update/', 'update')->name('update');
                    Route::post('/export', 'export')->name('export');
                    /*                    Route::get('/edit/{uuid}', 'edit')->name('edit');
                                        Route::put('/update/{uuid}', 'update')->name('update');
                                        Route::get('/destroy/{uuid}', 'destroy')->name('destroy');
                                        Route::post('/export', 'export')->name('export');*/
                });
            });

        Route::prefix('activity')
            ->name('activity.')
            ->group(function () {
                Route::controller(ActivityController::class)->group(function () {
                    Route::get('/', 'index')->name('index');
                    Route::get('/destroy/{id}', 'destroy')->name('destroy');
                    Route::post('/export', 'export')->name('export');
                });
            });

        Route::prefix('company')
            ->name('company.')
            ->group(function () {
                Route::controller(AdminCompanyController::class)->group(function () {
                    Route::get('/', 'index')->name('index');
                    Route::get('/create', 'create')->name('create');
                    Route::get('/edit/{id}', 'edit')->name('edit');
                    Route::post('/store', 'store')->name('store');
                    Route::put('/update/{id}', 'update')->name('update');
                    Route::get('/destroy/{id}', 'destroy')->name('destroy');
                    Route::get('/is_active/{id}', 'is_active')->name('is_active');
                    Route::post('/export', 'export')->name('export');
                    Route::get('/show/{slug}', 'show')->name('show');
                });
            });

        Route::prefix('project')
            ->name('project.')
            ->group(function () {
                Route::controller(AdminProjectController::class)->group(function () {
                    Route::get('/', 'index')->name('index');
                    Route::get('/create/{company}', 'create')->name('create');
                    Route::get('/edit/{id}', 'edit')->name('edit');
                    Route::post('/adduser/{id}', 'adduser')->name('adduser');
                    Route::delete('/deleteuser/{project_id}/{user_id}', 'deleteuser')->name('deleteuser');
                    Route::post('/store/{company}', 'store')->name('store');
                    Route::put('/update/{id}', 'update')->name('update');
                    Route::get('/destroy/{id}', 'destroy')->name('destroy');
                    Route::get('/is_active/{id}', 'is_active')->name('is_active');
                    Route::post('/export', 'export')->name('export');
                    Route::get('/show/{id}', 'show')->name('show');
                });
            });

        Route::prefix('processrecord')
            ->name('processrecord.')
            ->group(function () {
                Route::controller(ProcessRecordController::class)->group(function () {
                    Route::get('/', 'index')->name('index');
                    Route::get('/create', 'create')->name('create');
                    Route::get('/edit/{id}', 'edit')->name('edit');
                    Route::post('/store', 'store')->name('store');
                    Route::put('/update/{id}', 'update')->name('update');
                    Route::get('/destroy/{id}', 'destroy')->name('destroy');
                    Route::get('/is_active/{id}', 'is_active')->name('is_active');
                    Route::post('/export', 'export')->name('export');
                    Route::get('/show/{id}', 'show')->name('show');
                });
            });

        Route::prefix('demand')
            ->name('demand.')
            ->group(function () {
                Route::controller(DemandController::class)->group(function () {
                    Route::get('/', 'index')->name('index');
                    Route::get('/create/{project_id}/{type_id}', 'create')->name('create');
                    Route::get('/edit/{id}', 'edit')->name('edit');
                    Route::post('/store/{project_id}/{type_id}', 'store')->name('store');
                    Route::get('/gallery/add/{demand_id}', 'galleryaddview')->name('galleryaddview');
                    Route::post('/gallery/add/{demand_id}', 'galleryadd')->name('galleryadd');
                    Route::put('/update/{id}', 'update')->name('update');
                    Route::get('/destroy/{id}', 'destroy')->name('destroy');
                    Route::get('/is_active/{id}', 'is_active')->name('is_active');
                    Route::post('/export', 'export')->name('export');
                    Route::get('/show/{id}', 'show')->name('show');
                });
            });
    });
});
