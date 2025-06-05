<?php

use App\Livewire\Clients\CreateClients;
use App\Livewire\Clients\EditClients;
use App\Livewire\Clients\IndexClients;
use App\Livewire\Clients\ShowClients;
use App\Livewire\Invoices\EditInvoices;
use App\Livewire\Invoices\IndexInvoices;
use App\Livewire\Invoices\ShowInvoices;
use App\Livewire\Projects\ApprovedProjects;
use App\Livewire\Projects\CreateProject;
use App\Livewire\Projects\EditProjects;
use App\Livewire\Projects\IndexProjects;
use App\Livewire\Projects\ShowProjects;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'role:super_admin', 'verified'])
    ->name('dashboard');

Route::middleware(['auth', 'role:super_admin'])->group(function () {
    Route::get('/clients', IndexClients::class)->name('clients.index');
    Route::get('/clients/create', CreateClients::class)->name('clients.create');
    Route::get('/clients/{client}', ShowClients::class)->name('clients.show');
    Route::get('/clients/{client}/edit', EditClients::class)->name('clients.edit');

    Route::get('/projects', IndexProjects::class)->name('projects.index');
    Route::get('/projects/create', CreateProject::class)->name('projects.create');
    Route::get('/projects/{project}', ShowProjects::class)->name('projects.show');
    Route::get('/projects/{project}/edit', EditProjects::class)->name('projects.edit');
    
    Route::get('/approved-projects', ApprovedProjects::class)->name('approved-projects.index');

    Route::get('/invoices', IndexInvoices::class)->name('invoices.index');
    Route::get('/invoices/{invoice}', ShowInvoices::class)->name('invoices.show');
    Route::get('/invoices/{invoice}/edit', EditInvoices::class)->name('invoices.edit');

    Route::redirect('settings', 'settings/profile');
    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__ . '/auth.php';
