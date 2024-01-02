<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\IpasumsController;
use App\Http\Controllers\LietotajiController;
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

Route::get('/', function () {
    return view('welcome');
});
/*Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');*/

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/dashboard', function()
{
   return View::make('pages.ipasumi');
});
Route::get('/dashboard',[IpasumsController::class,'GetAll']);
Route::get('/profilaiestatijumi', function()
{
   return View::make('pages.edit');
});

/*Route::get('/pardoti', function()
{
   return View::make('pages.pardoti');
});*/
Route::get('/pardoti',[IpasumsController::class,'GetSold']);

Route::get('/rezervetipardosanai', function()
{
   return View::make('pages.rezervetipardosanai');
});
Route::get('/rezervetipardosanai', [IpasumsController::class,'GetReservedSold']);

Route::get('/noma', function()
{
   return View::make('pages.noma');
});
Route::get('/noma', [IpasumsController::class,'GetRented']);

Route::get('/rezervetinoma', function()
{
   return View::make('pages.rezervetinoma');
});
Route::get('/rezervetinoma', [IpasumsController::class,'GetReservedRent']);

Route::get('/jaunsipasums', [IpasumsController::class, 'create']);

Route::post('/jaunsipasums', [IpasumsController::class, 'store'])->name('ipasums.store');
Route::get('/pievienotjaunulietotaju', function()
{
   return View::make('pages.pievienotjaunulietotaju');
});
Route::post('/pievienotjaunulietotaju', [LietotajiController::class, 'store'])->name('lietotajs.store');

require __DIR__.'/auth.php';
