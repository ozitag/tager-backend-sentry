<?php

use Illuminate\Support\Facades\Route;

Route::get('/tager/sentry-issue/{issue}',\OZiTAG\Tager\Backend\Sentry\Controllers\SentryController::class . '@page');
