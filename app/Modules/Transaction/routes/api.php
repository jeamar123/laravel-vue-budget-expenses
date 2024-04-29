<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Transaction\Http\Controllers\ListTransactionsController;
use App\Modules\Transaction\Http\Controllers\SummaryTransactionsController;
use App\Modules\Transaction\Http\Controllers\GetTransactionController;
use App\Modules\Transaction\Http\Controllers\CreateTransactionController;
use App\Modules\Transaction\Http\Controllers\UpdateTransactionController;
use App\Modules\Transaction\Http\Controllers\DeleteTransactionController;
use App\Modules\Transaction\Http\Controllers\LoginTransactionController;
use App\Modules\Transaction\Http\Controllers\CurrentTransactionController;
use App\Modules\Transaction\Http\Controllers\ImportTransactionController;

use App\Modules\Transaction\Http\Controllers\Category\ListCategoriesController;
use App\Modules\Transaction\Http\Controllers\Category\CreateCategoryController;
use App\Modules\Transaction\Http\Controllers\Category\UpdateCategoryController;
use App\Modules\Transaction\Http\Controllers\Category\DeleteCategoryController;

use App\Modules\Transaction\Http\Controllers\Budget\ListBudgetsController;

use App\Modules\Transaction\Models\Transaction;
use App\Modules\Transaction\Models\Category;
use App\Modules\User\Models\User;


Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::group(['prefix' => 'budget'], function () {
        Route::get('/', ListBudgetsController::class)
            ->name('budget.list')
            ->can('list', Category::class);
    });

    Route::group(['prefix' => 'category'], function () {
        Route::get('/', ListCategoriesController::class)
            ->name('category.list')
            ->can('list', Category::class);
        Route::post('/', CreateCategoryController::class)
            ->name('category.create')
            ->can('create', Category::class);
        Route::patch('/{category}', UpdateCategoryController::class)
            ->name('category.update')
            ->can('update', Category::class);
        Route::delete('/{category}', DeleteCategoryController::class)
            ->name('category.delete')
            ->can('delete', Category::class);
    }); 

    Route::get('/', ListTransactionsController::class)
        ->name('transaction.list')
        ->can('list', Transaction::class);
    Route::get('/summary', SummaryTransactionsController::class)
        ->name('transaction.summary')
        ->can('list', Transaction::class);
    Route::get('/{transaction}', GetTransactionController::class)
        ->name('transaction.show')
        ->can('show', Transaction::class);
    Route::post('/', CreateTransactionController::class)
        ->name('transaction.create')
        ->can('create', Transaction::class);
    Route::patch('/{transaction}', UpdateTransactionController::class)
        ->name('transaction.update')
        ->can('update', 'transaction');
    Route::delete('/{transaction}', DeleteTransactionController::class)
        ->name('transaction.delete')
        ->can('delete', 'transaction');
});
