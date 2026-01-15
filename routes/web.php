<?php

use App\Http\Controllers\PagesController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\ForumAnswerController;
use App\Http\Controllers\BlogArticleController;
use App\Http\Controllers\DashboardArticleController;
use App\Http\Controllers\UserController;
//debugging
use App\Models\Blogarticle; 
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Artisan;
Route::get('/', [PagesController::class, 'home']);
Route::get('/about', [PagesController::class, 'about']);
//so übergebe ich Werte an eine Seite
// Route::get('/hello/{name}', function ($name) {
//     return "Hello, $name!";
// });
Route::get('/forum', [PagesController::class, 'forum']);
Route::get('/forumposts', [PagesController::class, 'forumposts']);
Route::get('/blogArticles', [BlogArticleController::class, 'showArticles']);
Route::get('/dashboard', [PagesController::class, 'dashboard']);

Route::get('/myAccount', [PagesController::class, 'myAccount']);
//auth
Route::get('/register', [PagesController::class, 'register']);
Route::get('/login', [PagesController::class, 'login'])->middleware('guest');
Route::get('/password-forgotten', [PagesController::class, 'passwordForgotten']);
Route::get('/password-reset', [PagesController::class, 'passwordReset']);
//for http requests
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
//passwordreset
Route::get('/forgot-password', [PasswordResetController::class, 'requestForm'])
    ->name('password.request');

Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLink'])
    ->name('password.email');

Route::get('/reset-password/{token}', [PasswordResetController::class, 'resetForm'])
    ->name('password.reset');

Route::post('/reset-password', [PasswordResetController::class, 'resetPassword'])
    ->name('password.update');
//forum
Route::prefix('forumposts')->name('forumposts.')->group(function () {
    // READ: list posts by ressort
    Route::get('/{ressort}', [ForumController::class, 'showPosts'])
        ->name('show');
    // CREATE: show form
    Route::get('/{ressort}/create', [ForumController::class, 'create'])
        ->name('create');
    // READ: single post detail
    Route::get('/{ressort}/{id}', [ForumController::class, 'showPostDetail'])
        ->name('detail');

    // CREATE: store new post
    Route::post('/{ressort}', [ForumController::class, 'store'])
        ->name('store')->middleware(['auth:sanctum']);

    // UPDATE: show edit form
    Route::get('/{ressort}/{id}/edit', [ForumController::class, 'edit'])
        ->name('edit')->middleware(['auth:sanctum']);

    // UPDATE: apply changes
    Route::put('/{ressort}/{id}', [ForumController::class, 'update'])
        ->name('update')->middleware(['auth:sanctum']);

    // DELETE: remove post
    Route::delete('/{ressort}/{id}', [ForumController::class, 'destroy'])
        ->name('destroy')->middleware(['auth:sanctum']);
});
//forumAnswer
Route::prefix('forumanswer')->name('forumanswer.')->group(function () {
    // CREATE: show form
    Route::get('/{post}/createAnswer', [ForumAnswerController::class, 'create'])
        ->name('create');

    // CREATE: store new post
    Route::post('/{post}', [ForumAnswerController::class, 'store'])
        ->name('store')->middleware(['auth:sanctum']);

    // UPDATE: show edit form
    Route::get('/{id}/edit', [ForumAnswerController::class, 'edit'])
        ->name('edit')->middleware(['auth:sanctum']);

    // UPDATE: apply changes
    Route::put('/{id}', [ForumAnswerController::class, 'update'])
        ->name('update')->middleware(['auth:sanctum']);

    // DELETE: remove post
    Route::delete('/{id}', [ForumAnswerController::class, 'destroy'])
        ->name('destroy')->middleware(['auth:sanctum']);
});
//blogArticles
Route::prefix('blogarticle')->name('blogarticle.')->group(function () {
    
     //show all
    Route::get('/blogArticles', [BlogArticleController::class, 'showArticles'])
        ->name('showArticles');
        //show one
    Route::get('/{id}', [BlogArticleController::class, 'showArticleDetail'])
        ->name('article_detail');
});
Route::prefix('myAccount')->name('myAccount.')->group(function () {
      Route::get('/{id}', [userController::class, 'editUser'])
        ->name('edit');
      Route::put('/{id}', [userController::class, 'updateUser'])
        ->name('update');
      Route::delete('/{id}', [userController::class, 'deleteUser'])
        ->name('delete');
      Route::get('/{id}', [userController::class, 'showAllQuestionsFromUser'])
        ->name('showAllQuestions');

});
//for deploy migrations
Route::get('/run-migrations', function () {
    Artisan::call('migrate', ['--force' => true]);
    return 'Migrations completed';
});
//for debugging in web
Route::get('/debug', function () { try { return Blogarticle::count(); } catch (\Throwable $e) { return [ 'message' => $e->getMessage(), 'file' => $e->getFile(), 'line' => $e->getLine(), ]; } });
Route::get('/debug-migrations', function () {
    try {
        return DB::table('migrations')->get();
    } catch (\Throwable $e) {
        return [
            'message' => $e->getMessage(),
            'file'    => $e->getFile(),
            'line'    => $e->getLine(),
        ];
    }
});
Route::get('/debug-blog', function () {
    try {
        return \App\Models\Blogarticle::first();
    } catch (\Throwable $e) {
        return [
            'message' => $e->getMessage(),
            'file'    => $e->getFile(),
            'line'    => $e->getLine(),
        ];
    }
});


Route::get('/debug-blog-schema', function () {
    return \Illuminate\Support\Facades\DB::select('SELECT column_name, data_type FROM information_schema.columns WHERE table_name = \'blogarticles\'');
});

