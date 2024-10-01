<?php

use App\Actions\Cats\CreateNewCat;
use App\Actions\Cats\DeleteExistingCat;
use App\Actions\Cats\GetCatsList;
use App\Actions\Cats\GetExistingCat;
use App\Actions\Cats\UpdateExistingCat;
use Illuminate\Support\Facades\Route;

Route::prefix('cats')->name('cats.')->middleware('auth:sanctum')->group(function () {
    Route::get('/', GetCatsList::class)->name('list');
    Route::post('/', CreateNewCat::class)->name('create');
    Route::get('/{cat}', GetExistingCat::class)->name('show');
    Route::put('/{cat}', UpdateExistingCat::class)->name('update');
    Route::delete('/{cat}', DeleteExistingCat::class)->name('delete');
});
