<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AddressController;

Route::get('/address/cep', [AddressController::class, 'getAddressByCep']);