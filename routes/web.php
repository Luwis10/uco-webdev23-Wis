<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleCategoryController;
use App\Http\Middleware\EnsureArticleCategoryExists;
use App\Enums\UserRoleEnum;
use App\Http\Middleware\EnsureUserRole;

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

Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::controller(\App\Http\Controllers\ArticleController::class)->middleware(['auth','has_article_category'])->group(function () {
        Route::get('/articles', 'list')->name('article.list');
        Route::match(['get', 'post'], '/articles/create', 'create')->name('article.create')->middleware('role:' . UserRoleEnum::Administrator->value . ',' . UserRoleEnum::Author->value);
        Route::get('/articles/{slug}', 'single')->name('article.single');
        Route::match(['get', 'post'], '/articles/{id}/edit', 'edit')->name('article.edit')->middleware('role:' . UserRoleEnum::Administrator->value . ',' . UserRoleEnum::Author->value);
        Route::post('/articles/{id}/delete', 'delete')->name('article.delete')->middleware('role:' . UserRoleEnum::Administrator->value . ',' . UserRoleEnum::Author->value);
        Route::post('/articles/{id}/comment', 'comment')->name('article.comment');
    });
Route::controller(ArticleCategoryController::class)->middleware('auth')->group(function () {
        Route::get('/article_categories', 'list')->name('article_category.list');
        Route::match(['get', 'post'], '/article_categories/create', 'create')->name('article_category.create')->middleware('can:isAdmin');
        // ->middleware('role:' . UserRoleEnum::Administrator->value);
        Route::match(['get', 'post'], '/article_categories/{id}/edit', 'edit')->name('article_category.edit')->middleware('can:isAdmin');
        // ->middleware('role:' . UserRoleEnum::Administrator->value);
        Route::post('/article_categories/{id}/delete', 'delete')->name('article_category.delete');
    });

Route::controller(\App\Http\Controllers\UserController::class)->middleware('auth')->group(function () {
        Route::get('/users', 'list')->name('user.list');
        Route::match(['get', 'post'], '/users/create', 'create')->name('user.create');
        Route::match(['get', 'post'], '/users/{id}/edit', 'edit')->name('user.edit');
        Route::post('/users/{id}/delete', 'delete')->name('user.delete');
    });

Route::match(['get', 'post'], '/login', [\App\Http\Controllers\LoginController::class, 'form'])->name('login')->middleware('guest');

Route::post('/logout', [\App\Http\Controllers\LoginController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');
