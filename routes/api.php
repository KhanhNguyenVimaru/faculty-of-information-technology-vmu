<?php
use App\Http\Controllers\ProfessorController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\MajorController;
use Illuminate\Support\Facades\Route;

Route::post('/professors-data', [ProfessorController::class, 'index']);
Route::post('/departments-data', [DepartmentController::class, 'index']);
Route::post('/majors-data', [MajorController::class, 'index']);
