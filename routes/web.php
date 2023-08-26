<?php

use App\Http\Controllers\IngredientController;
use App\Http\Controllers\PizzaController;
use App\Http\Controllers\PizzaIngredientController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::post('/pizzas', [PizzaController::class, 'store']);
Route::delete('/pizzas/{pizza}', [PizzaController::class, 'destroy']);

Route::post('/ingredients', [IngredientController::class, 'store']);

Route::post('/pizza_ingredient/{pizza}/{ingredient}', [PizzaIngredientController::class, 'attach']);
Route::delete('/pizza_ingredient/{pizza}/{ingredient}', [PizzaIngredientController::class, 'detach']);