<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\OrderController;


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

Auth::routes();

// // //?Items
// Route::prefix('admin')->group(function () {
//     Route::get('/items', [ItemController::class, 'index'])->name('itemList');
//     Route::post('/addItem', [ItemController::class, 'store']);
//     Route::put('/updateItems/{id}', [ItemController::class, 'update'])->name('item.update');
//     Route::delete('/deleteItems/{item}', [ItemController::class, 'destroy'])->name('item.destroy');
// });

// Route::prefix('order')->group(function () {
//     Route::get('/items', [ItemController::class, 'index'])->name('initialItems');
// });

//LOGGING IN


// Route::post("route-name", [ControllerName::class, 'nameofMethod']);

