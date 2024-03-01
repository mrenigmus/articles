<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CommentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix("articles")->controller(ArticleController::class)->group(function (){
    Route::get("/", "index");
    Route::post("/", "store");
    Route::get("/{slug}", "show");
    Route::put("/{id}", "update")->whereNumber("id");
    Route::delete("{id}", "destroy")->whereNumber("id");
    Route::prefix("/{id}/comments")->controller(CommentController::class)->group(function (){
        Route::post("/", "store");
        Route::get("/", "index");
    });
});
