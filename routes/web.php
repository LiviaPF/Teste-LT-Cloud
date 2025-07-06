<?php

use App\Livewire\Articles;
use App\Livewire\CreateArticle;
use App\Livewire\Developers;
use App\Livewire\EditArticle;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Livewire\Skills;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('developers', Developers::class)->name('developers');
    Route::get('articles', Articles::class)->name('articles');
    Route::get('/articles/create', CreateArticle::class)->name('articles.create');
    Route::get('/articles/{id}/edit', EditArticle::class)->name('articles.edit');
    Route::get('skills', Skills::class)->name('skills');
    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});

require __DIR__.'/auth.php';
