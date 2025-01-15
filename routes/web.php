<?php

use App\Http\Controllers\ExportController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/portal');
});
Route::get('export', [ExportController::class, 'semester_export']);
