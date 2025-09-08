<?php
use App\Http\Controllers\ProfessorController;
use Illuminate\Support\Facades\Route;

Route::post('/professors-data', [ProfessorController::class, 'index']);
