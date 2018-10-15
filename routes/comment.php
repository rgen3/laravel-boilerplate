<?php
declare(strict_types = 1);

Route::group(
    [
        'namespace'  => 'Comment',
        'prefix'     => 'comment',
        'middleware' => ['auth'],
    ],
    function () {
        Route::post('update', 'CommentController@update')->name('comment.update');
        Route::post('create/post', 'CommentController@createPostComment')->name('comment.create.post');
    }
);
