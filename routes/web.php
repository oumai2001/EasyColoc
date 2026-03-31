<?php

use App\Http\Controllers\ProfileController;
<<<<<<< HEAD
use App\Http\Controllers\ColocationController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Page d'accueil publique
=======
use Illuminate\Support\Facades\Route;

>>>>>>> 8e94925080aafa664147f8b1fd6ee70babb48e2c
Route::get('/', function () {
    return view('welcome');
});

<<<<<<< HEAD
// Dashboard (protégé)
=======
>>>>>>> 8e94925080aafa664147f8b1fd6ee70babb48e2c
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

<<<<<<< HEAD
// ==================== ROUTES PUBLIQUES (SANS AUTH) ====================
// Invitations (accessibles sans authentification)
Route::get('/invitations/accept/{token}', [InvitationController::class, 'accept'])->name('invitations.accept');
Route::get('/invitations/decline/{token}', [InvitationController::class, 'decline'])->name('invitations.decline');

// Routes protégées par authentification
Route::middleware('auth')->group(function () {
    
    // ==================== PROFIL ====================
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // ==================== COLOCATIONS ====================
    // CRUD de base
    Route::resource('colocations', ColocationController::class);
    
    // Actions supplémentaires
    Route::post('/colocations/{colocation}/leave', [ColocationController::class, 'leave'])->name('colocations.leave');
    Route::patch('/colocations/{colocation}/cancel', [ColocationController::class, 'cancel'])->name('colocations.cancel');
    Route::get('/colocations/{colocation}/confirm-cancel', [ColocationController::class, 'confirmCancel'])->name('colocations.confirm-cancel');
    Route::delete('/colocations/{colocation}/members/{member}', [ColocationController::class, 'removeMember'])->name('colocations.remove-member');
    
    // ==================== INVITATIONS ====================
    Route::post('/colocations/{colocation}/invitations', [InvitationController::class, 'store'])->name('invitations.store');
    Route::get('/colocations/{colocation}/invitations', [InvitationController::class, 'index'])->name('invitations.index');
    Route::delete('/invitations/{invitation}', [InvitationController::class, 'destroy'])->name('invitations.destroy');
    
    // ==================== DÉPENSES ====================
    Route::get('/colocations/{colocation}/expenses/create', [ExpenseController::class, 'create'])->name('expenses.create');
    Route::post('/colocations/{colocation}/expenses', [ExpenseController::class, 'store'])->name('expenses.store');
    Route::get('/colocations/{colocation}/expenses/{expense}', [ExpenseController::class, 'show'])->name('expenses.show');
    Route::delete('/colocations/{colocation}/expenses/{expense}', [ExpenseController::class, 'destroy'])->name('expenses.destroy');
    Route::post('/colocations/{colocation}/expenses/{expense}/mark-paid/{debtor}', [ExpenseController::class, 'markAsPaid'])->name('expenses.mark-paid');
    
    // ==================== PAIEMENTS ====================
    Route::post('/colocations/{colocation}/payments/settlement', [ExpenseController::class, 'markSettlement'])->name('payments.settlement');
    
    // ==================== CATÉGORIES ====================
    Route::get('/colocations/{colocation}/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/colocations/{colocation}/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/colocations/{colocation}/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/colocations/{colocation}/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/colocations/{colocation}/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/colocations/{colocation}/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
});

// Routes d'authentification (Laravel Breeze)
require __DIR__.'/auth.php';
=======
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
>>>>>>> 8e94925080aafa664147f8b1fd6ee70babb48e2c
