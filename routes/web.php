<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return ['Laravel' => App()->version(), "Status" => "Running"];
});
