<?php

use App\Http\Controllers\TeamController;
use Illuminate\Support\Facades\Route;


Route::apiResource('teams', TeamController::class);
