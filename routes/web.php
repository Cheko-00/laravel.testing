<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PriorityController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TeamMemberController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();

Route::middleware(['auth'])->group(function (){
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::resource('teams', TeamController::class);
    Route::prefix('teams/{team}/members')->group(function () {
        Route::get('/create', [TeamMemberController::class, 'create'])->name('teams.members.create');
        Route::post('/', [TeamMemberController::class, 'store'])->name('teams.members.store');
        Route::delete('/{user}', [TeamMemberController::class, 'destroy'])->name('teams.members.destroy');
        Route::put('/{user}/role', [TeamMemberController::class, 'updateRole'])->name('teams.members.update-role');
    });
    Route::resource('users', UserController::class);
    Route::resource('categories', CategoryController::class);
    Route::get('/priority-leves', [PriorityController::class, 'index'])->name('priorities.index');

    Route::resource('tickets', TicketController::class);
});
