<?php

Route::group(['module' => 'Report', 'middleware' => ['web'], 'namespace' => 'App\Modules\Report\Controllers'], function() {

    Route::resource('report', 'ReportController');

});
