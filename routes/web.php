<?php

use Illuminate\Support\Facades\Route;

Route::get('/', fn() => view('welcome'))->name('home');

Route::get('/dashboard', \App\Livewire\Dashboard::class)->name('dashboard');
Route::view('/settings', 'pages.settings')->name('settings');
Route::view('/help', 'pages.help')->name('help');
Route::view('/profile', 'pages.profile')->name('profile');

Route::prefix('users')->name('users.')->group(function () {
    Route::view('/', 'pages.users.index')->name('index');
});

Route::prefix('roles')->name('roles.')->group(function () {
//    Route::view('/', 'pages.roles.index')->name('index');
    Route::get('/dashboard', \App\Livewire\Dashboard::class)->name('index');
});

Route::prefix('units')->name('units.')->group(function () {
    Route::view('/', 'pages.units.index')->name('index');
});

Route::prefix('tickets')->name('tickets.')->group(function () {
    Route::view('/', 'pages.tickets.index')->name('index');
});

Route::prefix('reports')->name('reports.')->group(function () {
    Route::view('/', 'pages.reports.index')->name('index');
});