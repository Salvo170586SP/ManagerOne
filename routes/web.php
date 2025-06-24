<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'role:super_admin', 'verified'])
    ->name('dashboard');

Route::middleware(['auth', 'role:super_admin'])->group(function () {
    //clients
    Volt::route('/clients', 'clients.index-clients')->name('clients.index');
    Volt::route('/clients/create', 'clients.create-clients')->name('clients.create');
    Volt::route('/clients/{client}', 'clients.show-clients')->name('clients.show');
    Volt::route('/clients/{client}/edit', 'clients.edit-clients')->name('clients.edit');

    //projects
    Volt::route('/projects', 'projects.index-projects')->name('projects.index');
    Volt::route('/projects/create', 'projects.create-project')->name('projects.create');
    Volt::route('/projects/{project}', 'projects.show-projects')->name('projects.show');
    Volt::route('/projects/{project}/edit', 'projects.edit-projects')->name('projects.edit');
    Volt::route('/approved-projects', 'projects.approved-projects')->name('approved-projects.index');
    Volt::route('/delivered-projects', 'projects.approved-projects')->name('delivered-projects.index');

    //documents
    Volt::route('/documents', 'documents.index-document')->name('documents.index');
    Volt::route('/documents/{user}', 'documents.show-document')->name('documents.show');
    
    //tasks
    Volt::route('/tasks', 'tasks.index-tasks')->name('tasks.index-tasks');
    Volt::route('/tasks/{project}/show', 'tasks.show-tasks')->name('tasks.show-tasks');
    Volt::route('/tasks/{project}/create', 'tasks.create-task')->name('tasks.create-task');
    Volt::route('/tasks/{task}/{project}/edit', 'tasks.edit-task')->name('tasks.edit-tasks');
    
    //invoices
    Volt::route('/invoices', 'invoices.index-invoices')->name('invoices.index');
    Volt::route('/invoices/{invoice}', 'invoices.show-invoices')->name('invoices.show');
    Volt::route('/invoices/{invoice}/edit', 'invoices.edit-invoices')->name('invoices.edit');
    
    //developers
    Volt::route('/developers', 'developers.index-developers')->name('developers.index');
    Volt::route('/developers/create', 'developers.create-developers')->name('developers.create');
    Volt::route('/developers/{developer}', 'developers.show-developers')->name('developers.show');
    Volt::route('/developers/{developer}/edit', 'developers.edit-developers')->name('developers.edit');
    
    //teams
    Volt::route('/teams', 'teams.index-teams')->name('teams.index');
    Volt::route('/teams/create', 'teams.create-team')->name('teams.create');
    Volt::route('/teams/{team}/edit', 'teams.edit-team')->name('teams.edit');
    
    //calendar
    Volt::route('/calendar', 'calendar.index-calendar')->name('calendar.index');
    
    //logs
    Volt::route('/logs', 'logs.index-logs')->name('logs.index');
    
    //settings
    Route::redirect('settings', 'settings/profile');
    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__ . '/auth.php';
