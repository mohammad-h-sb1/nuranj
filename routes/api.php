<?php

use App\Http\Controllers\V1\Auth\AuthController;
use App\Http\Controllers\V1\Dashboard\Admin\CustomerClubController;
use App\Http\Controllers\V1\Dashboard\Admin\MenuController;
use App\Http\Controllers\V1\Dashboard\User\ProfileController;
use App\Http\Controllers\V1\Front\User\CategoryController;
use App\Http\Controllers\V1\Front\User\CommentController;
use App\Http\Controllers\V1\Front\User\ConsultingController;
use App\Http\Controllers\V1\Front\User\ConsultingLogController;
use App\Http\Controllers\V1\Front\User\CustomerClubLogController;
use App\Http\Controllers\V1\Front\User\EmployeeController;
use App\Http\Controllers\V1\Front\User\PageController;
use App\Http\Controllers\V1\Front\User\ProjectController;
use App\Http\Controllers\V1\Front\User\WorkTeamController;
use Illuminate\Http\Request;
use App\Http\Controllers\V1\Dashboard\Admin\EmployeeController as DashboardAdminEmployee;
use App\Http\Controllers\V1\Dashboard\Admin\ProjectController as DashboardAdminProject;
use App\Http\Controllers\V1\Dashboard\Admin\CategoryController as DashboardAdminCategory;
use App\Http\Controllers\V1\Dashboard\User\ProjectController as DashboardUserProject;
use App\Http\Controllers\V1\Dashboard\User\CommentController as DashboardUserComment;
use App\Http\Controllers\V1\Dashboard\Admin\CommentController as DashboardAdminComment;
use App\Http\Controllers\V1\Front\User\CustomerClubController as FrontUserCustomerClub;
use App\Http\Controllers\V1\Dashboard\Admin\WorkTeamController as DashboardAdminWorkTeam;
use App\Http\Controllers\V1\Dashboard\Admin\ConsultingController as DashboardAdminConsulting;
use App\Http\Controllers\V1\Dashboard\Admin\CustomerClubLogController as DashboardAdminConsultingLog;
use App\Http\Controllers\V1\Dashboard\User\ImageController as DashboardUserImage;
use App\Http\Controllers\V1\Front\Admin\ConsultingLogController as FrontConsultingLogController;
use App\Http\Controllers\V1\Dashboard\Admin\ImageController as DashboardAdminImage;
use App\Http\Controllers\V1\Dashboard\Admin\PageController as DashboardAdminPage;
use App\Http\Controllers\V1\Dashboard\User\TicketController as DashboardUserTicket;
use App\Http\Controllers\V1\Dashboard\Admin\TicketController as DashboardAdminTicket;
use App\Http\Controllers\V1\Dashboard\Admin\AnswerController as DashboardAdminAnswer;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware('auth:api')->group(function (){

    Route::prefix('dashboard')->name('dashboard')->group(function (){
        Route::prefix('admin')->name('admin')->group(function (){
            //customer Club
            Route::prefix('customer/club')->name('customer_club')->group(function (){
                Route::get('/',[CustomerClubController::class,'index'])->middleware('admin');
                Route::post('/store',[CustomerClubController::class,'store'])->middleware('admin');
                Route::get('/show/{customerClub}',[CustomerClubController::class,'show'])->middleware('admin');
                Route::get('/edit/{customerClub}',[CustomerClubController::class,'edit'])->middleware('admin');
                Route::put('/update/{customerClub}',[CustomerClubController::class,'update'])->middleware('admin');
                Route::delete('/delete/{customerClub}',[CustomerClubController::class,'destroy'])->middleware('admin');
                Route::post('/status/{id}',[CustomerClubController::class,'status'])->middleware('admin');
            });

            //menu
            Route::prefix('menu')->name('menu')->group(function (){
                Route::get('/',[MenuController::class,'index'])->middleware('admin');
                Route::post('/store',[MenuController::class,'store'])->middleware('admin');
                Route::get('/show/{menu}',[MenuController::class,'show'])->middleware('admin');
                Route::get('/edit/{menu}',[MenuController::class,'edit'])->middleware('admin');
                Route::put('/update/{menu}',[MenuController::class,'update'])->middleware('admin');
                Route::delete('/delete/{menu}',[MenuController::class,'destroy'])->middleware('admin');
            });


            //consulting مشاور
            Route::prefix('consulting')->name('consulting')->group(function (){
                Route::get('/',[DashboardAdminConsulting::class,'index'])->middleware('admin');
                Route::post('/store',[DashboardAdminConsulting::class,'store'])->middleware('admin');
                Route::get('/show/{consulting}',[DashboardAdminConsulting::class,'show'])->middleware('admin');
                Route::get('/edit/{consulting}',[DashboardAdminConsulting::class,'edit'])->middleware('admin');
                Route::put('/update/{consulting}',[DashboardAdminConsulting::class,'update'])->middleware('admin');
                Route::delete('/delete/{consulting}',[DashboardAdminConsulting::class,'destroy'])->middleware('admin');
                Route::post('/status/{id}',[DashboardAdminConsulting::class,'status'])->middleware('admin');
            });

            //ست کردن تیم طزاح با پروژه
            Route::prefix('project/work/team')->group(function (){
                Route::post('store/{id}',[DashboardAdminProject::class,'projectTeam'])->middleware('admin');
            });

            Route::prefix('page')->name('page')->group(function (){
                Route::get('/',[DashboardAdminPage::class,'index'])->middleware('admin');
                Route::post('/store',[DashboardAdminPage::class,'store'])->middleware('admin');
                Route::get('show/{page}',[DashboardAdminPage::class,'show'])->middleware('admin');
                Route::get('edit/{page}',[DashboardAdminPage::class,'edit'])->middleware('admin');
                Route::put('update/{page}',[DashboardAdminPage::class,'update'])->middleware('admin');
            });

        });

        Route::name('Manager')->group(function (){
            // Employees and intern
            Route::prefix('employee')->name('Employees')->group(function (){
            Route::get('/',[DashboardAdminEmployee::class,'index'])->middleware('manager');
            Route::get('show/{id}',[DashboardAdminEmployee::class,'show'])->middleware('manager');
            Route::delete('delete/{id}',[DashboardAdminEmployee::class,'destroy'])->middleware('manager');

            //رزمه های خوانده شده
            Route::get('read',[DashboardAdminEmployee::class,'read'])->middleware('manager');
            Route::get('unread',[DashboardAdminEmployee::class,'unread'])->middleware('manager');

            //status Employee
            Route::post('status/{id}',[DashboardAdminEmployee::class,'status'])->middleware('manager');
        });
            Route::prefix('intern')->name('intern')->group(function (){
            Route::get('/',[DashboardAdminEmployee::class,'intern'])->middleware('manager');
        });

            //project
            Route::prefix('project')->name('project')->group(function (){
                Route::get('/',[DashboardAdminProject::class,'index'])->middleware('manager');
                Route::get('/show/{id}',[DashboardAdminProject::class,'show'])->middleware('manager');
                Route::get('/delete/{id}',[DashboardAdminProject::class,'destroy'])->middleware('manager');

                //پروژه های اماده شده
                Route::get('active',[DashboardAdminProject::class,'active'])->middleware('manager');
                //پروژه های وب شایتی
                 Route::get('website',[DashboardAdminProject::class,'website'])->middleware('manager');
                 //پروژه های اپلیکیشنی
                Route::get('application',[DashboardAdminProject::class,'application'])->middleware('manager');
                //پروژه های استارتاپی
                Route::get('startup',[DashboardAdminProject::class,'startup'])->middleware('manager');
                //پروژه های برای تجربه کاری
                Route::get('work/experience',[DashboardAdminProject::class,'work_experience'])->middleware('manager');
                //پروژه های کد نویسی
                Route::get('coding',[DashboardAdminProject::class,'coding'])->middleware('manager');
                //پروژه های برای ارتباط
                Route::get('trade/relations',[DashboardAdminProject::class,'trade_relations'])->middleware('manager');
                //پروژه در چه مرحله ای هست
                Route::put('laval/{id}',[DashboardAdminProject::class,'level'])->middleware('manager');
                //status پروژه
                Route::post('status/{id}',[DashboardAdminProject::class,'status'])->middleware('manager');
            });

            //comment
            Route::prefix('comment')->name('comment')->group(function (){
                Route::get('show/{id}',[DashboardAdminComment::class,'show'])->middleware('manager');
                Route::get('edit/{id}',[DashboardAdminComment::class,'edit'])->middleware('manager');
                Route::put('update/{id}',[DashboardAdminComment::class,'update'])->middleware('manager');
                Route::delete('delete/{id}',[DashboardAdminComment::class,'destroy'])->middleware('manager');
                Route::post('status/{id}',[DashboardAdminComment::class,'status'])->middleware('manager');
            });

            //category
            Route::prefix('category')->name('category')->group(function (){
                Route::get('/',[DashboardAdminCategory::class,'index'])->middleware('manager');
                Route::post('/store',[DashboardAdminCategory::class,'store'])->middleware('manager');
                Route::get('/show/{category}',[DashboardAdminCategory::class,'show'])->middleware('manager');
                Route::get('/edit/{category}',[DashboardAdminCategory::class,'edit'])->middleware('manager');
                Route::put('/update/{category}',[DashboardAdminCategory::class,'update'])->middleware('manager');
                Route::delete('/delete/{category}',[DashboardAdminCategory::class,'destroy'])->middleware('manager');
            });

            //تیم کاری
            Route::prefix('work/team')->name('work_team')->group(function (){
                Route::get('/',[DashboardAdminWorkTeam::class,'index'])->middleware('manager');
                Route::post('/store',[DashboardAdminWorkTeam::class,'store'])->middleware('manager');
                Route::get('/show/{workTeam}',[DashboardAdminWorkTeam::class,'show'])->middleware('manager');
                Route::get('/edit/{workTeam}',[DashboardAdminWorkTeam::class,'edit'])->middleware('manager');
                Route::put('/update/{workTeam}',[DashboardAdminWorkTeam::class,'update'])->middleware('manager');
                Route::delete('/delete/{workTeam}',[DashboardAdminWorkTeam::class,'destroy'])->middleware('manager');
            });

            //مشاوره
            Route::prefix('consulting/log')->name('consulting_log')->group(function (){
                Route::get('/',[DashboardAdminConsultingLog::class,'index'])->middleware('manager');
                Route::get('/show/{id}',[DashboardAdminConsultingLog::class,'show'])->middleware('manager');
            });

            //img
            Route::prefix('img')->name('img')->group(function (){
                Route::get('/',[DashboardAdminImage::class,'index'])->middleware('manager');
                Route::post('/store',[DashboardAdminImage::class,'store'])->middleware('manager');
                Route::get('/show/{image}',[DashboardAdminImage::class,'show'])->middleware('manager');
                Route::delete('/delete/{image}',[DashboardAdminImage::class,'destroy'])->middleware('manager');
                Route::post('/status/{id}',[DashboardAdminImage::class,'status'])->middleware('manager');
            });

            //قسمت تیکت و پاسخ
            Route::prefix('ticket')->name('ticket')->group(function (){
                Route::get('/',[DashboardAdminTicket::class,'index'])->middleware('manager');
                Route::get('/show/{id}',[DashboardAdminTicket::class,'show'])->middleware('manager');

                //سوال های پاسخ داده شده
                Route::get('has/been/answered',[DashboardAdminTicket::class,'hasBeenAnswered'])->middleware('manager');
                //سوال های پاسخ داده نشده
                Route::get('no/answered',[DashboardAdminTicket::class,'NotAnswered'])->middleware('manager');
                //سوال های مربوط به فرانت
                Route::get('/for/font',[DashboardAdminTicket::class,'frontAnswered'])->middleware('manager');
                //سوال های مربوط به بکند
                Route::get('/for/backend',[DashboardAdminTicket::class,'backendAnswered'])->middleware('manager');

            });
            Route::prefix('answer')->name('answer')->group(function (){
                Route::get('',[DashboardAdminAnswer::class,'index'])->middleware('manager');
                Route::post('store/{id}',[DashboardAdminAnswer::class,'store'])->middleware('manager');
                Route::get('show/{answer}',[DashboardAdminAnswer::class,'show'])->middleware('manager');
                Route::get('edit/{answer}',[DashboardAdminAnswer::class,'edit'])->middleware('manager');
                Route::put('update/{answer}',[DashboardAdminAnswer::class,'update'])->middleware('manager');
                Route::delete('delete/{answer}',[DashboardAdminAnswer::class,'destroy'])->middleware('manager');
            });

        });

        Route::prefix('customer')->group(function (){
            //project,
            Route::prefix('project')->group(function (){
                Route::get('/',[DashboardUserProject::class,'index'])->middleware('customer');
                Route::post('/store',[DashboardUserProject::class,'store'])->middleware('customer');
                Route::get('/show/{id}',[DashboardUserProject::class,'show'])->middleware('customer');
                Route::delete('/delete/{id}',[DashboardUserProject::class,'destroy'])->middleware('customer');
            });

            //comment
            Route::prefix('comment')->name('comment')->group(function (){
                Route::get('show/{comment}',[DashboardUserComment::class,'show'])->middleware('customer');
                Route::post('store',[DashboardUserComment::class,'store'])->middleware('customer');
                Route::get('edit/{comment}',[DashboardUserComment::class,'edit'])->middleware('customer');
                Route::put('update/{comment}',[DashboardUserComment::class,'update'])->middleware('customer');
                Route::delete('delete/{comment}',[DashboardUserComment::class,'destroy'])->middleware('customer');
            });

            //profile
            Route::prefix('profile')->name('profile')->group(function (){
                Route::post('store',[ProfileController::class,'store'])->middleware('customer');
                Route::get('show/{profile}',[ProfileController::class,'show'])->middleware('customer');
                Route::get('edit/{profile}',[ProfileController::class,'edit'])->middleware('customer');
                Route::put('update/{profile}',[ProfileController::class,'update'])->middleware('customer');

                Route::prefix('img')->name('img')->group(function (){
                    Route::post('store',[DashboardUserImage::class,'store'])->middleware('customer');
                });
            });

            //مشاوره
            Route::prefix('consulting/log')->name('consulting/log')->group(function (){
                Route::get('/',[FrontConsultingLogController::class,'index']);
                Route::post('/store',[FrontConsultingLogController::class,'store']);
                Route::get('/show/{id}',[FrontConsultingLogController::class,'show']);
                Route::get('/edit/{id}',[FrontConsultingLogController::class,'edit']);
                Route::put('/update/{id}',[FrontConsultingLogController::class,'update']);
            });

            //روت های مربوط به ticket
            Route::prefix('ticket')->name('ticket')->group(function (){
                Route::get('/',[DashboardUserTicket::class,'index'])->middleware('customer');
                Route::post('store',[DashboardUserTicket::class,'store'])->middleware('customer');
                Route::get('show/{ticket}',[DashboardUserTicket::class,'show'])->middleware('customer');
                Route::delete('delete/{ticket}',[DashboardUserTicket::class,'destroy'])->middleware('customer');
            });

        });
    });


    Route::name('front')->group(function () {
        //Employees
        Route::prefix('employees')->name('employees')->group(function () {
            Route::get('show/{employee}', [EmployeeController::class, 'show']);
            Route::get('edit/{employee}', [EmployeeController::class, 'edit']);
            Route::put('update/{employee}', [EmployeeController::class, 'update']);
            Route::delete('delete/{employee}', [EmployeeController::class, 'destroy']);
        });

        //comment
        Route::prefix('comment')->name('comment')->group(function (){
            Route::get('show/{id}',[CommentController::class,'show']);
        });

        //customer Club
        Route::prefix('customer')->name('customer')->group(function (){
            Route::get('/',[FrontUserCustomerClub::class,'index']);
            Route::get('/show/{id}',[FrontUserCustomerClub::class,'show']);
            //عضو شدن در باشگاه مشتریان
            Route::post('login/{id}',[CustomerClubLogController::class,'login']);
            Route::post('logout/{id}',[CustomerClubLogController::class,'logout']);
        });

    });


    Route::post('logout',[AuthController::class,'logout']);
});


//روت های که نیاز به api ندارند
Route::name('front')->group(function (){
    //Employees
    Route::prefix('employees')->name('employees')->group(function (){
        Route::post('store',[EmployeeController::class,'store']);
    });

    //project
    Route::prefix('project')->name('project')->group(function (){
        Route::get('/',[ProjectController::class,'index']);
        Route::post('store',[ProjectController::class,'store']);
        Route::get('show/{project}',[ProjectController::class,'show']);
    });

    //category
    Route::prefix('category')->name('category')->group(function (){
        Route::get('/',[CategoryController::class,'index']);
        Route::get('/show/{id}',[CategoryController::class,'show']);
    });

    //تیم همکاران
    Route::prefix('work/team')->name('work/team')->group(function (){
        Route::get('/',[WorkTeamController::class,'index']);
        Route::get('/show/{id}',[WorkTeamController::class,'show']);
    });

    // لیست مشاوره
    Route::prefix('consulting')->name('consulting')->group(function (){
        Route::get('/',[ConsultingController::class,'index']);
        Route::get('/show/{id}',[ConsultingController::class,'show']);
    });

    //ایجاد مشهوره
    Route::prefix('consulting/log')->name('consulting_log')->group(function (){
        Route::post('/store',[ConsultingLogController::class,'store']);
    });

    //page
    Route::prefix('page')->name('page')->group(function (){
        Route::get('show/{id}',[PageController::class,'show']);
    });
});
Route::post('register',[AuthController::class,'register']);
Route::post('login',[AuthController::class,'login']);

require __DIR__.'/V2/api.php';
