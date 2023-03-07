<?php

use App\Http\Controllers\Admin\RecordController;
use App\Http\Livewire\Admin\Genres;
use App\Http\Livewire\Shop;
use Illuminate\Support\Facades\Route;

/*
Uitvouwen
php.txt
2 KB
﻿
<?php

use App\Http\Controllers\Admin\RecordController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/contact', function () {
    return view('contact');
});

Route::view('/', 'home')->name('home');
Route::view('contact', 'contact')->name('contact');

Route::get('playground', [RecordController::class, 'playground'])->name('playground');


Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::redirect('/', '/admin/records');
    Route::get('genres', Genres::class)->name('genres');
    Route::get('records', [RecordController::class, 'index'])->name('records.index');
});

Route::get('shop', Shop::class)->name('shop');




Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::get('/profile/show', function () {
        return view('profile.show');
    })->name('show');
});


