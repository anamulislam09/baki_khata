<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*---------------- Admin route start here ------------------*/
// admin login route start here 

Route::get('/admin/login', [AdminController::class, 'Index'])->name('login_form');
Route::post('/admin/login/owner', [AdminController::class, 'Login'])->name('admin.login');

// admin register route start here 
Route::get('/admin/register', [AdminController::class, 'AdminRegister'])->name('register_form');
Route::post('/admin/register/store', [AdminController::class, 'Store'])->name('admin.store');
Route::get('/admin/register-verify', [AdminController::class, 'Verify'])->name('admin.verfy');
Route::post('/admin/register-verify/store', [AdminController::class, 'VerifyStore'])->name('admin.verfy.store');
Route::get('/admin/register-verified', [AdminController::class, 'Verified'])->name('admin.verfied');
// admin register route ends here 

// Customer Forgate password route start here 
Route::get('/admin/forgot-password', [AdminController::class, 'Forgot'])->name('admin.forgot-password');
Route::post('/admin/forgot-password/create', [AdminController::class, 'ForgotPassword'])->name('admin.forgot-password.create');
Route::get('/admin/reset/{token}', [AdminController::class, 'reset']);
Route::post('/admin/reset/{token}', [AdminController::class, 'PostReset']);
// Customer Forgate password route ends here 

Route::group(['prefix' => 'admin', 'middleware' => ['admin']], function () {
    Route::get('/dashboard', [AdminController::class, 'Dashboard'])->name('admin.dashboard');

    // Customer show 
    Route::get('/client', [AdminController::class, 'Client'])->name('client.all');
    Route::get('/client/edit/{id}', [AdminController::class, 'ClientEdit'])->name('client.edit');
    Route::post('/client/update', [AdminController::class, 'ClientUpdate'])->name('client.update');
    Route::get('/client/delete/{id}', [AdminController::class, 'ClientDelete'])->name('client.delete');

    // Packages route  
    Route::get('/packages', [PackageController::class, 'Index'])->name('packages.all');
    Route::get('/package/create', [PackageController::class, 'Create'])->name('package.create');
    Route::post('/package/store', [PackageController::class, 'Store'])->name('package.store');
    Route::get('/package/edit/{id}', [PackageController::class, 'Edit'])->name('package.edit');
    Route::post('/package/update', [PackageController::class, 'Update'])->name('package.update');
    Route::get('/package/delete/{id}', [PackageController::class, 'Delete'])->name('package.delete');

    // Payment route  
    Route::get('/client-collections', [PaymentController::class, 'Index'])->name('collections.all');
    Route::get('/collection/create', [PaymentController::class, 'Create'])->name('collection.create');
    Route::post('/get-package', [PaymentController::class, 'getPackage']); // get subcategory using ajex 
    Route::post('/collection/store', [PaymentController::class, 'Store'])->name('collection.store');
    Route::get('/collection/edit/{id}', [PaymentController::class, 'Edit'])->name('collection.edit');
    Route::post('/collection/update', [PaymentController::class, 'Update'])->name('collection.update');
    Route::get('/collection/delete/{id}', [PaymentController::class, 'Delete'])->name('collection.delete');

    // admin login route start here 
    Route::post('/logout', [AdminController::class, 'AdminLogout'])->name('admin.logout');
});

/*---------------- Admin route ends here ------------------*/
/*---------------- Customer route start here ------------------*/
Route::group(['prefix' => 'admin', 'middleware' => ['admin']], function () {
    //    users route 
    Route::get('/customers', [UserController::class, 'Index'])->name('customers.index');
    Route::get('/customers/create', [UserController::class, 'Create'])->name('customers.create');
    Route::post('/customers/store', [UserController::class, 'Store'])->name('customers.store');
    Route::post('/customers/store/model', [UserController::class, 'StoreCustomer'])->name('Storecustomer');
    Route::get('/customers/edit/{user_id}', [UserController::class, 'Edit']);
    Route::post('/customers/update', [UserController::class, 'Update'])->name('customers.update');
    Route::get('/customers/delete/{user_id}', [UserController::class, 'Destroy'])->name('customers.delete');

    //    Sales route 
    Route::get('/collections', [CollectionController::class, 'Index'])->name('collections.index');
    Route::get('/get-customers/{id}', [CollectionController::class, 'GetCustomer']);
    Route::get('/get-transaction/{date}', [CollectionController::class, 'GetTransaction']);
    Route::post('/sales-collections/store', [CollectionController::class, 'storeInvoice'])->name('sales.collection.store');
    Route::post('/due-collections', [CollectionController::class, 'dueCollection'])->name('due.collection');

    Route::get('/generate-invoice/{invoice_id}', [CollectionController::class, 'GenerateInv'])->name('invoice.create'); //generate voucher 

    //    Sales route 
    Route::get('/report', [ReportController::class, 'Index'])->name('report.index');
    Route::post('/report-show', [ReportController::class, 'AllReport'])->name('report.show');
    // Route::get('/get-transaction/{date}', [CollectionController::class, 'GetTransaction']);`
    // Route::post('/sales-collections/store', [CollectionController::class, 'storeInvoice'])->name('sales.collection.store');
    // Route::post('/due-collections', [CollectionController::class, 'dueCollection'])->name('due.collection');
});

Route::get('/', function () {
    return view('admin.pages.admin_login');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
