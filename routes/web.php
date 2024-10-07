<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/posts', [\App\Http\Controllers\PostController::class, 'getAllPosts']);

Route::get('/show-post/{id}', [\App\Http\Controllers\PostController::class, 'getPostById'])->name('post.show');

Route::post('/create-post', [\App\Http\Controllers\PostController::class, 'createPost']);

Route::get('/edit-post/{id}', [\App\Http\Controllers\PostController::class, 'editPost'])->name('post.edit');

Route::post('/update-post/{id}', [\App\Http\Controllers\PostController::class, 'updatePost'])->name('post.update');

Route::get('/get-comments/{id}', [\App\Http\Controllers\CommentController::class, 'getAllPostComments'])->name('post.comment');

Route::post('/set-comment/{id}', [\App\Http\Controllers\CommentController::class, 'setCommentToSelectedPost'])->name('comment.create');

Route::delete('/delete-post/{id}', [\App\Http\Controllers\PostController::class, 'deletePost'])->name('post.delete');
