<?php

use App\Http\Controllers\Followups\FollowupController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Branches\BranchController;
use App\Http\Controllers\ClassRooms\ClassRoomController;
use App\Http\Controllers\Kids\KidController;
use App\Http\Controllers\Meals\MealController;
use App\Http\Controllers\Newsletters\NewsletterController;
use App\Http\Controllers\Nurseries\NurseryController;
use App\Http\Controllers\Parents\ParentController;
use App\Http\Controllers\PaymentBills\PaymentBillController;
use App\Http\Controllers\PaymentBills\PaymentBillsHistoryController;
use App\Http\Controllers\Schedules\ScheduleController;
use App\Http\Controllers\Subjects\SubjectController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Authentication -- API Routes
|--------------------------------------------------------------------------
*/

Route::group(['middleware' => 'api'], function () {
    Route::group(['prefix' => 'auth', 'controller' => AuthController::class], function () {
        // Authentication
        Route::post('/register', 'register');
        Route::post('/login', 'login');
        Route::post('/password/forget', 'passwordForget');
        Route::post('/password/reset', 'passwordReset');

        //Authorization
        Route::group(['middleware' => 'auth:api'], function () {
            Route::post('/me', 'me');
            Route::post('/logout', 'logout');
        });
    });

    /*
    |--------------------------------------------------------------------------
    | Authorization -- API Routes
    |--------------------------------------------------------------------------
    */
    Route::group(['middleware' => 'auth:api'], function () {

        // Branch Controller
        Route::apiResource('branches', BranchController::class);

        // ClassRoom Controller
        Route::apiResource('classrooms', ClassRoomController::class);
        Route::post('classrooms/assign/subject/{classroom}', [ClassRoomController::class, 'assignSubject'])->name('classrooms.assignSubject');
        Route::get('classroom/subjects/{classroom}', [ClassRoomController::class, 'classSubjects'])->name('classrooms.classSubjects');

        // Parent Controller
        Route::apiResource('parents', ParentController::class);
        Route::post('parents/{parent}', [ParentController::class, 'update'])->name('parents.update');

        // Kid Controller
        Route::apiResource('kids', KidController::class);
        Route::get('kids/birthday/comming', [KidController::class, 'birthday']);
        Route::post('kids/{kid}', [KidController::class, 'update'])->name('kids.update');

        // Newsletter Controller
        Route::apiResource('newsletters', NewsletterController::class);
        Route::post('newsletters/{newsletter}', [NewsletterController::class, 'update'])->name('newsletters.update');

        // Subject Controller
        Route::apiResource('subjects', SubjectController::class);

        // Meal Controller
        Route::apiResource('meals', MealController::class);

        // Meal Controller
        Route::apiResource('payemntbills', PaymentBillController::class);
        Route::post('payemntbills/{paymentBill}', [PaymentBillController::class, 'update'])->name('payemntbills.update');

        // Meal Controller
        Route::apiResource('payment/histories', PaymentBillsHistoryController::class);

        // Folloup Controller
        Route::apiResource('followups', FollowupController::class);
        Route::post('followups/attendance', [FollowupController::class, 'store'])->name('followups.store');
        Route::post('followups/{followUp}', [FollowupController::class, 'update'])->name('followups.update');

        // Nursery Controller
        Route::apiResource('nurseries', NurseryController::class);
        Route::post('nurseries/{nurseries}', [NurseryController::class, 'update'])->name('nurseries.update');

        // Nursery Controller
        Route::apiResource('schedules', ScheduleController::class);
        Route::post('schedules/{classRoom}', [ScheduleController::class, 'store'])->name('schedules.store');
    });
});
