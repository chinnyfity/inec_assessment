<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

Auth::routes();

Route::get('/', [HomeController::class, 'index']);
Route::get('enter-results', [HomeController::class, 'enter_results']);
Route::get('analysis', [HomeController::class, 'analysis']);


Route::post('display_lgas', [HomeController::class, 'display_lgas']);
Route::post('display_wards', [HomeController::class, 'display_wards']);
Route::post('display_table_result', [HomeController::class, 'display_table_result']);
Route::post('fetch_ward_details', [HomeController::class, 'fetch_ward_details']);
Route::post('enter_score', [HomeController::class, 'enter_score']);
Route::post('fetch_results', [HomeController::class, 'fetch_results']);



