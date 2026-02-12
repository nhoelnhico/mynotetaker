<?php
use App\Http\Controllers\NoteController;
use Illuminate\Support\Facades\Route;

Route::get('/', [NoteController::class, 'index'])->name('notes.index');
Route::post('/store', [NoteController::class, 'store'])->name('notes.store');
Route::delete('/delete-multiple', [NoteController::class, 'massDelete'])->name('notes.massDelete');
Route::get('/export', [NoteController::class, 'exportCsv'])->name('notes.export');
Route::get('/edit/{id}', [NoteController::class, 'edit'])->name('notes.edit');
Route::put('/update/{id}', [NoteController::class, 'update'])->name('notes.update');