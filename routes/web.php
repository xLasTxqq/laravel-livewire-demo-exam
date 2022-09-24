<?php

use App\Http\Livewire\About;
use App\Http\Livewire\Admin;
use App\Http\Livewire\Basket;
use App\Http\Livewire\Contacts;
use App\Http\Livewire\Orders;
use App\Http\Livewire\Poster;
use App\Http\Livewire\Session;
use Illuminate\Support\Facades\Route;

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

Route::get('/', About::class)->name('about');
Route::get('poster', Poster::class)->name('poster');
Route::get('contacts', Contacts::class)->name('contacts');
Route::get('session/{id}', Session::class)->name('session');

Route::middleware(['auth'])->group(function(){

    Route::get('basket', Basket::class)->name('basket');
    Route::get('orders', Orders::class)->name('orders');

    // Route::get('/dashboard', function () {
    //     return view('dashboard');
    // })->name('dashboard');

    Route::middleware(['role:admin'])->group(function(){
        Route::get('admin', Admin::class)->name('admin_panel');
    });
});

require __DIR__.'/auth.php';
