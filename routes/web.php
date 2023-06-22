<?php

use Illuminate\Support\Facades\Auth;


// Controllers
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\ValidationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('admin/', [HomeController::class, 'index'])->name('home');

Route::prefix('auth')->group(function () {
    Route::get('signin', [EmployeeController::class, 'signin'])->name('signin');
    Route::get('signout', [EmployeeController::class, 'logout'])->name('signout');
    Route::get('newpass', [EmployeeController::class, 'newpass'])->name('newPassword');
    Route::get('changepass/{idnumber}', [EmployeeController::class, 'changepass'])->name('changePassword');
    Route::post("check", [EmployeeController::class, 'checkAuth'])->name('auth.check');
    Route::post("checknew", [EmployeeController::class, 'checkPass'])->name('auth.checknew');
    Route::post("signout", [EmployeeController::class, 'logout'])->name('auth.signout');
});

Route::prefix('admin')->group(function () {
    //ITEMS
    Route::get('/items', [ItemController::class, 'index'])->name('itemList');
    Route::get('/employee-cart', [ReportController::class, 'employeeCart'])->name('employeeCart');
    Route::post('/addItem', [ItemController::class, 'store'])->name('itemAdding');
    Route::post('/updateItems/{id}', [ItemController::class, 'update'])->name('itemUpdating');
    Route::delete('/deleteItems/{id}', [ItemController::class, 'destroy'])->name('itemDeleting');
    //CSV FILE UPLOAD
    Route::post('/uploadCSV', [ItemController::class, 'csvUpload'])->name('massUploadCSV');
    //EMPLOYEES
    Route::get('/employees', [EmployeeController::class, 'index'])->name('employeeList');
    //VALIDATION
    Route::get('/validation', [ValidationController::class, 'index'])->name('validateLists');
    Route::get('/orders', [OrderController::class, 'admin'])->name('orderAdmin');
    Route::post('/filter-order', [OrderController::class, 'adminFilter'])->name('orderFilter');
    //REPORTS
    // Route::get('order/employees', [ReportController::class, 'emporders'])->name('listEmployees');
    // Route::get('order/forpurchase', [ReportController::class, 'forPurchase'])->name('forPurchase');
    // Route::get('order/forreleasing', [ReportController::class, 'forRelease'])->name('forReleasing');
    //ORDER STATUS
    Route::get('/orderstats', [OrderController::class, 'stats'])->name('orderstatus');
});

Route::prefix('order')->group(function () {
    Route::get('/items', [OrderController::class, 'index'])->name('initialItems');
    Route::get('/carts', [OrderController::class, 'cartIndex'])->name('viewCart');
    Route::get('/uploads', [OrderController::class, 'imguploads'])->name('uploadImages');
    Route::post('/submituploads', [OrderController::class, 'submituploads'])->name('submitUploads');
    Route::post('/receive/{id}', [OrderController::class, 'received'])->name('orderReceived');
    Route::post('/process/{id}', [OrderController::class, 'processed'])->name('orderProcessed');
});

Route::prefix('wishlist')->group(function () {
    Route::post('/add', [WishlistController::class, 'addWish'])->name('wishlistAdd');
    Route::post('/remove/{id}', [WishlistController::class, 'removeWish'])->name('wishlistRemove');
    // Route::get('/check/{id}', [WishlistController::class, 'checkWish'])->name('wishlistCheck');
});

Route::prefix('cart')->group(function () {
    Route::get('getItems', [CartController::class, 'getItems'])->name('getcartItems');
    Route::get('adminCartItems/{id}', [CartController::class, 'adminCartItems'])->name('adminCartItems');
    Route::get('getWishes', [CartController::class, 'getWishes'])->name('getwishItems');
    Route::post('/add', [CartController::class, 'addCart'])->name('cartlistAdd');
    Route::post('/confirm', [CartController::class, 'confirmCart'])->name('confirmCart');
    Route::delete('/remove/{barcode}', [CartController::class, 'removeCart'])->name('cartlistRemove');
    Route::get('/search', [CartController::class, 'search'])->name('searchCart');
    Route::get('/show/{id}', [CartController::class, 'showCart'])->name('showCartItems');
});

Route::prefix('error')->group(function () {
    Route::get('notfound', [HomeController::class, 'notfound'])->name('notfound');
});

Route::prefix('user')->group(function () {
    Route::get('/profile', [OrderController::class, 'profile'])->name('userProfile');
    Route::post('/validate/{id}', [ValidationController::class, 'validation'])->name('userValidate');
});

Route::prefix('reports')->group(function () {
    Route::get('/printstub/{location}', [ReportController::class, 'printstub'])->name('printstub');
    Route::get('/itemqtysummary', [ReportController::class, 'itemqtysummary'])->name('ItemQuantitySummary');
    Route::get('/itemorder', [ReportController::class, 'itemOrder'])->name('itemOrderReports');
    Route::get('/cut-off', [ReportController::class, 'cutOff'])->name('cutOffReport');
    Route::post('/generate-cut-off', [ReportController::class, 'generateCutOff'])->name('GeneratecutOffReport');
    Route::post('/selectlocation', [ReportController::class, 'locations'])->name('itemOrderReportsLocation');
    Route::post('/selectlocationEmloyeeCart', [ReportController::class, 'locationsEmployeeCart'])->name('itemOrderReportsLocation');
    Route::post('/printclaimstub', [ReportController::class, 'claimstub'])->name('claimstubprint');
    Route::get('/printcheckout/{location}', [ReportController::class, 'checkout'])->name('checkoutStub');
});
