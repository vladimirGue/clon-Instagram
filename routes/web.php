<?php

use Illuminate\Support\Facades\Route;

//controladores
use App\Http\Controllers\UserController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PageController;

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

Route::group(['middleware' => [
    'auth:sanctum',
    'verified'
]], function(){
    //dashboard
    Route::get('/dashboard', [HomeController::class, 'dashboard'])
    ->name('dashboard');

    //subir imagenes
    Route::get('/image/create', [ImageController::class, 'create'])
    ->name('image.create');
    Route::post('/image/save', [ImageController::class, 'save'])
        ->name('image.save');
    Route::get('/image/file/{filename}', [ImageController::class, 'getImage'])
        ->name('image.file');
    Route::get('/image/edit/{id}', [ImageController::class, 'edit'])
        ->name('image.edit');
    Route::post('/image/update', [ImageController::class, 'update'])
        ->name('image.update');

    //Detalle de imagenes
    Route::get('/image/detail/{id}', [ImageController::class, 'detail'])
                    ->name('image.detail');

    //Comentarios
    Route::post('/comment/save', [CommentController::class, 'save'])
    ->name('comment.save');  
    Route::post('/comment/delete/{id}', [CommentController::class, 'delete'])
        ->name('comment.delete');

    //Likes
    Route::get('/like/{id}', [LikeController::class, 'like'])
        ->name('like.save'); 
    Route::get('/dislike/{id}', [LikeController::class, 'dislike'])
        ->name('like.delete'); 
    Route::get('/favoritos', [LikeController::class, 'favoritos'])
        ->name('favoritos.index'); 
    
    //Usuario
    Route::get('/user/profile/{id}', [UserController::class, 'profile'])
        ->name('user.profile');
    Route::get('/gente', [UserController::class, 'index'])
        ->name('user.index');
        
    Route::get('/pages', [PageController::class,'index'])->name('pages');
});