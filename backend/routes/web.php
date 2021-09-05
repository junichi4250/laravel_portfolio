<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\CommentController;

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

Auth::routes();

// ゲストユーザーログイン
Route::get('guest', [LoginController::class, 'guestLogin'])->name('login.guest');

// 記事関連
Route::get('/', [PortfolioController::class, 'index'])->name('portfolios.index');
Route::resource('/portfolios', PortfolioController::class)->except(['index', 'show'])->middleware('auth');
Route::resource('/portfolios', PortfolioController::class)->only(['show']);

// コメント関連
Route::resource('/comments', CommentController::class)->only(['store'])->middleware('auth');

Route::prefix('portfolios')->name('portfolios.')->group(function() {
    // いいね関連
    Route::put('/{portfolio}/like', [PortfolioController::class, 'like'])->name('like')->middleware('auth');
    Route::delete('/{portfolio}/like', [PortfolioController::class, 'unlike'])->name('unlike')->middleware('auth');
});

// ユーザー関連
Route::prefix('users')->name('users.')->group(function() {
    Route::get('/{name}', [UserController::class, 'show'])->name('show');
    Route::get('/{name}/likes', [UserController::class, 'likes'])->name('likes');

    // ユーザープロフィール編集画面
    Route::get('/{name}/edit', [UserController::class, 'edit'])->name('edit');
    // ユーザープロフィール更新
    Route::post('/{name}/update', [UserController::class, 'update'])->name('update');
    // ユーザー退会処理
    Route::delete('/{name}', [UserController::class, 'destroy'])->name('destroy');
    // パスワード変更画面の表示
    Route::get('/{name}/edit_password', [UserController::class, 'editPassword'])->name('edit_password');
    // パスワード変更
    Route::patch('/{name}/update_password', [UserController::class, 'updatePassword'])->name('update_password');

    // フォロー、フォロワー一覧
    Route::get('/{name}/followings', [UserController::class, 'followings'])->name('followings');
    Route::get('/{name}/followers', [UserController::class, 'followers'])->name('followers');

    // フォロー、フォロー解除
    Route::middleware('auth')->group(function() {
        Route::put('/{name}/follow', [UserController::class, 'follow'])->name('follow');
        Route::delete('/{name}/follow', [UserController::class, 'unfollow'])->name('unfollow');
    });
});

// タグ関連
Route::get('/tags/{name}', [TagController::class, 'show'])->name('tags.show');