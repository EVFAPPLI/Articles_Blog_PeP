<?php

use App\Http\Controllers\Api\PostSyncController;
use Illuminate\Support\Facades\Route;

Route::post('/posts/sync', [PostSyncController::class, 'sync']);
