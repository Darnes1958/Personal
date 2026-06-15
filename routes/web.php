<?php

use App\Http\Controllers\UploadCheckController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect(route('filament.admin.auth.login'));
});

Route::middleware('auth')->get('/dev/upload-check', UploadCheckController::class);
