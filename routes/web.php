<?php

use App\Enum\Roles;
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
Route::middleware('CheckUserRole:' . Roles::CHEF)->group(function () {
    Route::post('/pizzas', [PizzaController::class, 'store'])->name('pizzas.store');
    Route::delete('/pizzas/{pizza}', [PizzaController::class, 'destroy'])->name('pizzas.destroy');

    Route::post('/ingredients', [IngredientController::class, 'store'])->name('ingredients.store');
    Route::delete('/ingredients/{ingredient}', [IngredientController::class, 'destroy'])->name('ingredients.destroy');
});



Route::post('/pizza_ingredients/{pizza}/{ingredient}', [PizzaIngredientController::class, 'attach'])->name('pizza_ingredients.attach');
Route::delete('/pizza_ingredients/{pizza}/{ingredient}', [PizzaIngredientController::class, 'detach'])->name('pizza_ingredients.detach');
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');