<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ForecastController;

Route::middleware(['cors'])->prefix('/forecast')->group(function(){
    Route::post('/getByCityName', function(Request $request){
        $key = env('APP_API_KEY');
        return ForecastController::getAllForecastData($request->all(), $key);
    });
    Route::post('/getMapsLocation', function(Request $request){
        $key = env('APP_API_MAPKEY');
        return ForecastController::getMapCoordinatate($request->all(), $key);
    });
});

