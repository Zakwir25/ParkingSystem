<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ParkingController;

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

// Route::get('/', function () {
//     return view('welcome');
// });
 
// Route::get('/admin', function () {
//     return view('k');
// });

Route::get('/', [ParkingController::class, 'index']);
Route::post('/parkir/masuk', [ParkingController::class, 'masuk'])->name('home');
// Route::post('/parkir/keluar', [ParkirController::class, 'keluar']);
// Route::get('/admin/laporan', [ParkirController::class, 'laporan']);
// Route::get('/admin/export-laporan', [ParkirController::class, 'exportLaporan']);
