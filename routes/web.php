<?php

use App\Http\Controllers\SubscriptionsPlansController as SubscriptionsPlans;
use App\Http\Controllers\SubscribersController as Subscribers;
use App\Http\Controllers\InvocesController as Invoces;
use App\Http\Controllers\GetWay\GetWayController;

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::controller(SubscriptionsPlans::class)->group(function () {
        Route::get('/dashboard/planos', 'index')->name('dash.planos');
        Route::get('/dashboard/plano/criar', 'create')->name('dash.plano.criar');
    });

    Route::controller(Subscribers::class)->group(function () {
        Route::get('/dashboard/assinantes',     'index')->name('dash.assinantes');
        Route::get('/dashboard/assinar-plano',  'create')->name('dash.assinar.plano');
        Route::get('/dashboard/assinatura/{subscriber}',  'show')->name('dash.assinatura.plano');
    });

});



require __DIR__.'/auth.php';
