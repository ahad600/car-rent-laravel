<?php

use App\Http\Controllers\Admin\CarController;
use App\Http\Controllers\Frontend\CarController as UserCarController;
use App\Http\Controllers\Frontend\RentalController as UserRentalController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\RentalController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\TokenAuthenticate;
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

// admin pages
Route::get('/', [PageController::class, 'Home']);
Route::get('/carList', [PageController::class, 'carList']);
Route::get('/rentList', [PageController::class, 'rentListPage']);
Route::get('/customerList', [PageController::class, 'customerListPage']);
Route::get('/dashboard', [PageController::class, 'DashboardPage']);
Route::get('/login', [PageController::class, 'LoginPage']);



// user pages
Route::get('/browse/carList', [UserCarController::class, 'carList']);
Route::get('/make-a-booking/{id}', [PageController::class, 'MakeBookingPage']);
Route::get('/manage-booking', [PageController::class, 'ManageBookingPage']);
Route::get('/contact', [PageController::class, 'ContactPage']);
Route::get('/singup', [PageController::class, 'SingupPage']);
Route::get('/about', [PageController::class, 'AboutPage']);


// user urls
Route::post('/user/singup', [UserController::class, 'UserSingup']);
Route::post('/user/login', [UserController::class, 'UserLogin']);
Route::get('/user/logout', [UserController::class, 'UserLogout']);
Route::get('/user/check', [UserController::class, 'userCheck']);

Route::post('/user/contact', [ContactController::class, 'sendMail']);

Route::post('/user/rental', [UserRentalController::class, 'create'])->middleware([TokenAuthenticate::class])->name('userRental.create');
Route::get('/user/rental', [UserRentalController::class, 'rentalList'])->middleware([TokenAuthenticate::class])->name('userRental.list');
Route::get('/user/rental/cancel/{id}', [UserRentalController::class, 'rentalCancel'])->middleware([TokenAuthenticate::class])->name('userRental.rentalCancel');



// car urls
Route::get('admin/car', [CarController::class, 'carList'])->name('carList');
Route::get('admin/car/{id}', [CarController::class, 'carGetById'])->name('carGetById');

Route::post('admin/car', [CarController::class, 'create'])->middleware([TokenAuthenticate::class])->name('car.create');
Route::post('admin/car/{id}/update', [CarController::class, 'update'])->middleware([TokenAuthenticate::class])->name('car.update');
Route::delete('admin/car/{id}/delete', [CarController::class, 'delete'])->middleware([TokenAuthenticate::class])->name('car.delete');

// retal urls
Route::get('admin/rental', [RentalController::class, 'rentalList'])->name('rentalList');
Route::get('admin/rental/{id}', [RentalController::class, 'rentalsGetById'])->name('rentalsGetById');
Route::get('admin/rental/{id}/history', [RentalController::class, 'rentalHistory'])->middleware([TokenAuthenticate::class])->name('rental.history');
Route::post('admin/rental', [RentalController::class, 'create'])->middleware([TokenAuthenticate::class])->name('rental.create');
Route::post('admin/rental/{id}/update', [RentalController::class, 'update'])->middleware([TokenAuthenticate::class])->name('rental.update');
Route::delete('admin/rental/{id}/delete', [RentalController::class, 'delete'])->middleware([TokenAuthenticate::class])->name('rental.delete');





// customer urls
Route::get('admin/customer', [CustomerController::class, 'customerList'])->name('customerList');
Route::get('admin/customer/{id}', [CustomerController::class, 'customerGetById'])->name('carGetById');

Route::post('admin/customer', [CustomerController::class, 'create'])->middleware([TokenAuthenticate::class])->name('customer.create');
Route::post('admin/customer/{id}/update', [CustomerController::class, 'update'])->middleware([TokenAuthenticate::class])->name('customer.update');
Route::delete('admin/customer/{id}/delete', [CustomerController::class, 'delete'])->middleware([TokenAuthenticate::class])->name('customer.delete');
