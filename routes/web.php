<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\Simulation\SimulationController;

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

Route::get('/import', [ImportController::class, 'index'])->name('import.index');
Route::post('/import/components-questions', [ImportController::class, 'importComQues'])->name('import.components-questions');
Route::post('/import/questions-answers', [ImportController::class, 'importQuesAns'])->name('import.questions-answers');
Route::post('/import/questions-indicators', [ImportController::class, 'importQuesInd'])->name('import.questions-indicators');
Route::post('/import/indicators-documents', [ImportController::class, 'importIndDoc'])->name('import.indicators-documents');

Route::get('/testing', [ImportController::class, 'testing'])->name('import.testing');
Route::get('/testing-simulation', [ImportController::class, 'testingSimulation'])->name('import.testingSimulation');


Route::get('/simulation', [SimulationController::class, 'index'])->name('simulation.index');
Route::get('/simulation/result/{id}', [SimulationController::class, 'result'])->name('simulation.result');
Route::post('/simulation/store', [SimulationController::class, 'store'])->name('simulation.store');
Route::delete('/simulation/delete/{id}', [SimulationController::class, 'destroy'])->name('simulation.delete');
