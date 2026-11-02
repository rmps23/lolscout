<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\SocialLinkController;
use App\Http\Controllers\InviteController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\TeamSearchController;
use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\RiotAccountController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'create'])->name('register');
    Route::post('/register', [RegisterController::class, 'store'])->middleware('throttle:10,1');

    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->middleware('throttle:10,1');

    Route::get('/forgot-password', [PasswordResetController::class, 'request'])->name('password.request');
    Route::post('/forgot-password', [PasswordResetController::class, 'email'])->middleware('throttle:6,1')->name('password.email');
    Route::get('/reset-password/{token}', [PasswordResetController::class, 'reset'])->name('password.reset');
    Route::post('/reset-password', [PasswordResetController::class, 'update'])->middleware('throttle:6,1')->name('password.update');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');

    Route::get('/email/verify', [EmailVerificationController::class, 'notice'])->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', [EmailVerificationController::class, 'verify'])
        ->middleware('signed')->name('verification.verify');
    Route::post('/email/verification-notification', [EmailVerificationController::class, 'send'])
        ->middleware('throttle:6,1')->name('verification.send');

    Route::middleware('verified')->prefix('settings')->name('settings.')->group(function () {
        Route::get('/account', [AccountController::class, 'edit'])->name('account');
        Route::put('/profile', [AccountController::class, 'updateProfile'])->name('profile');
        Route::put('/email', [AccountController::class, 'updateEmail'])->name('email');
        Route::put('/password', [AccountController::class, 'updatePassword'])->name('password');
        Route::delete('/account', [AccountController::class, 'destroy'])->name('destroy');

        Route::get('/riot', [RiotAccountController::class, 'show'])->name('riot');
        Route::post('/riot', [RiotAccountController::class, 'link'])->middleware('throttle:10,1')->name('riot.link');
        Route::post('/riot/verify', [RiotAccountController::class, 'verify'])->middleware('throttle:10,1')->name('riot.verify');
        Route::post('/riot/refresh', [RiotAccountController::class, 'refresh'])->middleware('throttle:10,1')->name('riot.refresh');
        Route::delete('/riot', [RiotAccountController::class, 'destroy'])->name('riot.destroy');

        Route::get('/social', [SocialLinkController::class, 'edit'])->name('social');
        Route::put('/social', [SocialLinkController::class, 'update'])->name('social.update');
    });

    Route::middleware('verified')->group(function () {
        Route::get('/teams', [TeamController::class, 'mine'])->name('teams.mine');
        Route::get('/teams/create', [TeamController::class, 'create'])->name('teams.create');
        Route::post('/teams', [TeamController::class, 'store'])->middleware('throttle:10,1')->name('teams.store');
        Route::get('/teams/search', TeamSearchController::class)->name('teams.search');

        Route::prefix('/teams/{team}')->whereNumber('team')->name('teams.')->group(function () {
            Route::get('/', [TeamController::class, 'show'])->name('show');
            Route::get('/edit', [TeamController::class, 'edit'])->name('edit');
            Route::put('/', [TeamController::class, 'update'])->name('update');
            Route::delete('/', [TeamController::class, 'destroy'])->name('destroy');
            Route::post('/logo', [TeamController::class, 'logo'])->middleware('throttle:10,1')->name('logo');
            Route::post('/invite', [TeamController::class, 'regenerateInvite'])->name('invite.regenerate');
            Route::delete('/members/{member}', [TeamController::class, 'kick'])->whereNumber('member')->name('members.kick');
            Route::delete('/leave', [TeamController::class, 'leave'])->name('leave');
            Route::put('/social', [SocialLinkController::class, 'updateTeam'])->name('social');
            Route::post('/apply', [ApplicationController::class, 'store'])->middleware('throttle:20,1')->name('apply');
        });

        Route::get('/applications', [ApplicationController::class, 'mine'])->name('applications.mine');
        Route::delete('/applications/{application}', [ApplicationController::class, 'destroy'])->name('applications.destroy');
        Route::get('/notifications', [ApplicationController::class, 'inbox'])->name('applications.inbox');
        Route::post('/applications/{application}/accept', [ApplicationController::class, 'accept'])->name('applications.accept');
        Route::post('/applications/{application}/decline', [ApplicationController::class, 'decline'])->name('applications.decline');

        Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
        Route::post('/favorites/{user:username}', [FavoriteController::class, 'store'])->name('favorites.store');
        Route::delete('/favorites/{user:username}', [FavoriteController::class, 'destroy'])->name('favorites.destroy');

        Route::get('/invite/{code}', [InviteController::class, 'show'])->name('invite.show');
        Route::post('/invite/{code}', [InviteController::class, 'accept'])->middleware('throttle:20,1')->name('invite.accept');
    });

    Route::middleware('verified')->get('/players/{user:username}', [PlayerController::class, 'show'])->name('players.show');
});
