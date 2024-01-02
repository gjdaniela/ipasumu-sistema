<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\IpasumsController;
use App\Http\Controllers\LietotajiController;
use App\Http\Controllers\AgentsController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\VestureController;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

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
    return view('auth.login');
});
/*Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');*/

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    /********************************* */

    Auth::routes(['verify' => true]);

    Route::middleware(['web', 'auth', 'verified'])->group(function () {
   

   

  /***************************************** */
    Route::get('/dashboard', function()
         {
            return View::make('pages.ipasumi');
         });
    Route::get('/dashboard',[IpasumsController::class,'GetAll2'])->name('ipasums.getall');
    //Route::get('/dashboard', [IpasumsController::class, 'create']);
         

      Route::post('/dashboard', [IpasumsController::class, 'store'])->name('ipasums.store');
   // Route::get('/dashboard',[AgentsController::class,'newall']);

         Route::post('/change_status_and_delete', [IpasumsController::class, 'changeStatusAndDelete'])->name('ipasums.changeStatusAndDelete');
         Route::post('/changeStatusAndDeleteEmail',[IpasumsController::class,'changeStatusAndDeleteEmail'])->name('ipasums.changeStatusAndDeleteEmail');

         Route::post('/updatedata',[IpasumsController::class,'updatedata'])->name('ipasums.updatedata');
           Route::post('/updatedataEmail',[IpasumsController::class,'updatedataEmail'])->name('ipasums.updatedataEmail');
         Route::get('/profilaiestatijumi', function()
         {
            return View::make('pages.edit');
         });

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
         Route::get('/iestatijumi', function()
         {
            return View::make('pages.iestatijumi');
         });
         
         
         Route::get('/iestatijumi', [AgentsController::class,'all'])->name('agents.getall');
         Route::post('/iestatijumi/lietotaji', [LietotajiController::class, 'store'])->name('lietotajs.store');
         //Route::get('/iestatijumi', [LietotajiController::class, 'all'])->name('lietotajs.all');
         Route::post('/iestatijumi/agenti', [AgentsController::class, 'store'])->name('agents.store');
        
        

         

         Route::get('/statistika', function()
         {
            return View::make('pages.statistika');
         });
         Route::get('/darbibuvesture', function()
         {
            return View::make('pages.darbibuvesture');
         });
          Route::get('/darbibuvesture', [VestureController::class,'Getall']);
         
          Route::post('/darbibuvesture', [VestureController::class,'filterByDate'])->name('vesture.filtred');
         
         Route::get('/rezervetlidz',function()
         {
            return View::make('pages.rezervetslidz');
         });
         Route::get('/rezervetlidz', [IpasumsController::class,'Getlidz']);
});
});

require __DIR__.'/auth.php';
