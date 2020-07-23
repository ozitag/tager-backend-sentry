<?php

use Illuminate\Support\Facades\Route;
use OZiTAG\Tager\Backend\Sentry\Controllers\SentryController;

Route::get('/tager/sentry-issue/{issue}',[SentryController::class, 'issue']);
