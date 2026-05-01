<?php

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;

Route::get('/storage/reports/{filename}', function ($filename) {
    $path = storage_path('ap/public/reports/' . $filename);

    if (!File::exists($path)) {
        abort(404, 'Fotonya hilang');
    }

    $file = File::get($path);
    $type = File::mimesType($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response;
});

Route::get('/', function () {
    return view('welcome');
});
