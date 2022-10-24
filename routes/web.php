<?php

use App\Http\Livewire\Users\CreateOrUpdateUser;
use App\Http\Livewire\Users\User;
use App\Http\Livewire\Users\UserDetail;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
})->middleware('guest');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::group(['prefix' => 'usuarios', 'as' => 'user.', 'middleware' => ['role:user'],], function () {
        Route::get('/',User::class)->name('index');
        Route::get('/crear',CreateOrUpdateUser::class)->name('create');
        Route::get('/{user}/detalles',UserDetail::class)->name('show');
        Route::get('/{user}/actualizar',CreateOrUpdateUser::class)->name('update');
    });
    Route::get('/perfil/{user}',UserDetail::class)->name('profile')->middleware('role:profile');
});

