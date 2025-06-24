<?php

use App\Http\Controllers\CommissionController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\FreelancerController;
use App\Http\Controllers\InsuranceController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserAccessController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/dashboard', [UserController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::prefix('users/')->controller(UserController::class)->group(function () {
        Route::get('all', 'index')->name('user.index');
        Route::get('create', 'create')->name('user.create');
        Route::post('store', 'store')->name('user.store');
        Route::get('edit/{users}', 'edit')->name('user.edit');
        Route::patch('update/{user}', 'update')->name('user.update');
        Route::delete('destroy/{user}', 'destroy')->name('user.destroy');
        Route::get('district/filter','districtFilters' )->name('district-filters');
        Route::get('position/filter','positionFilters' )->name('position-filters');

        Route::any('positions', 'all_position')->name('all_positions_configured');
        Route::any('add_position', 'add_position')->name('configure_user_position');
        Route::any('delete_position/{id}', 'delete_position')->name('delete_position');

        Route::get('all-id-types', 'indexIds')->name('ids.index');
        Route::post('store-id-types', 'storeIds')->name('identification.store');
        Route::post('destroy-id-types/{id}', 'destroyIds')->name('identification.destroy');

        Route::get('all_credentials/{option}/{id}', 'resend_credentials')->name('users.resend_credentials');
        Route::get('resend_credentials/{option}/{id}', 'resend_credentials')->name('single_user.resend_credentials');

    });
    Route::get('manage/role',[UserAccessController::class,'index_users_role'])->name('users-role.index');
    Route::get('manage/role{id}',[UserAccessController::class,'edit'])->name('users-access.edit');
    Route::get('update/{id}',[UserAccessController::class,'update'])->name('users-access.update');

    Route::prefix('insurance/')->controller(InsuranceController::class)->group(function () {

        Route::get('/types/index', 'indexTypes')->name('insurance_types.index');
        Route::post('/types/store', 'storeTypes')->name('insurance_types.store');
        Route::post('/types/destroy', 'destroyTypes')->name('delete_insurance_type');

        Route::get('/application/index', 'index')->name('insurance-applications.index');

        Route::get('/types/filter', 'insurance_filter')->name('insurance_type-filters');
        Route::post('store', 'store')->name('insurance.store');

        Route::post('fee-payment', 'application_fee_payment')->name('application_fee-payment');

        Route::get('education/requests', 'education_insurance_requests')->name('education_insurance-requests');
        Route::get('bodaboda/requests', 'bodaboda_insurance_requests')->name('bodaboda-insurances-requests');
        Route::get('business/requests', 'business_insurance_requests')->name('business-insurances-requests');
        Route::post('approve-education/requests', 'approve_insurance_requests')->name('approve-insurance-requests');

        Route::get('info/view/{id}', 'view_insurance_application')->name('insurance_info.view');
        Route::get('/application/fetch-info', 'fetch_application_details')->name('fetch-application-details');

        Route::post('payment/monthly', 'monthly_insurance_payment')->name('insurance_monthly_payment');
    });


    Route::prefix('freelancer/')->controller(FreelancerController::class)->group(function () {
        Route::get('index', 'index')->name('freelancers.index');
        Route::get('create', 'create')->name('freelancer.create');
        Route::post('store', 'store')->name('freelancer.store');
        Route::get('edit/{id}', 'edit')->name('freelancer.edit');
        Route::post('update/{id}', 'update')->name('freelancer.update');
        Route::get('assignment', 'all_assignment')->name('supervisor_freelancers');
    });

    Route::resources([
        'department' => DepartmentController::class,
        'roles' => RoleController::class,
        'permissions' => PermissionController::class,
    ]);
    Route::prefix('customers/')->controller(CustomerController::class)->group(function () {
        Route::get('all', 'index')->name('customer.index');
        Route::get('create', 'create')->name('customer.create');
        Route::get('show-info/{id}', 'show')->name('customer.show');
        Route::post('store', 'store')->name('customer.store');
        Route::get('edit/{users}', 'edit')->name('user.edit');
        Route::post('update/{customer}', 'update')->name('update_customer');
        Route::delete('destroy/{customer}', 'destroy')->name('customer.destroy');

        Route::get('all_registrations', 'all_registration')->name('all_customers.index');

        Route::get('public/index', 'public_customers')->name('public.customer.index');
        Route::get('public/create', 'public_customers_create')->name('public.customer.create');
        Route::get('public/all_registration', 'all_public_sector_registrations')->name('public.customer.all_registration');

    });

    Route::prefix('commission/')->controller(CommissionController::class)->group(function () {
        Route::get('configuration/index', 'index_configuration')->name('commission-configuration.index');
        Route::post('configuration/store', 'store_configuration')->name('save_commission_configuration');

        Route::get('payment-type/filter','paymentTypeFilter' )->name('payment-type-filters');
        Route::get('individual/index','individual_commissions_payment' )->name('individual-commissions.index');
        Route::get('all/index','all_commissions_payment' )->name('all-commissions.index');

        Route::post('confirm/single_commission', 'confirm_commission')->name('confirm-commission-payment');


    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/{id}', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/change_passsword', [ProfileController::class, 'change_password'])->name('profile.change-password');
    Route::post('/update-password', [ProfileController::class, 'save_new_password'])->name('save_new_password');
});

require __DIR__.'/auth.php';
