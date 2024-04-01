<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*---------------- Admin route start here ------------------*/
// admin login route start here 

Route::get('/admin/login', [AdminController::class, 'Index'])->name('login_form');
Route::post('/admin/login/owner', [AdminController::class, 'Login'])->name('admin.login');

// admin register route start here 
Route::get('/admin/register', [AdminController::class, 'AdminRegister'])->name('register_form');
Route::post('/admin/register/store', [AdminController::class, 'Store'])->name('admin.store');
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
    Route::get('/customers', [AdminController::class, 'Customer'])->name('customers.all');
    Route::get('/customers/edit/{id}', [AdminController::class, 'CustomerEdit'])->name('customer.edit');
    Route::post('/customers/update', [AdminController::class, 'CustomerUpdate'])->name('customers.update');

    // admin login route start here 
    Route::post('/logout', [AdminController::class, 'AdminLogout'])->name('admin.logout');
});

/*---------------- Admin route ends here ------------------*/
/*---------------- Customer route start here ------------------*/
Route::group(['prefix' => 'admin', 'middleware' => ['admin']], function () {
    //    users route 
    Route::get('/users', [UserController::class, 'Index'])->name('users.index');
    Route::get('/user/create', [UserController::class, 'Create'])->name('user.create');
    Route::post('/user/store', [UserController::class, 'Store'])->name('user.store');
    Route::get('/user/edit/{user_id}', [UserController::class, 'Edit']);
    Route::post('/user/update', [UserController::class, 'Update'])->name('user.update');
    Route::post('/user/delete', [UserController::class, 'Destroy'])->name('user.delete');

    //    Sales route 
    Route::get('/due-collections', [CollectionController::class, 'Index'])->name('collections.index');
    Route::get('/collections/create', [CollectionController::class, 'Create'])->name('collections.create');
    Route::post('/collections/store', [CollectionController::class, 'Store'])->name('collections.store');
    Route::get('/generate-invoice/{invoice_id}', [CollectionController::class, 'GenerateInv'])->name('sales.update'); //generate voucher 
});

Route::get('/', function () {
    return view('welcome');
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
