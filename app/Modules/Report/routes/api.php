<?php

Route::group(['module' => 'Report', 'middleware' => ['api'], 'namespace' => 'App\Modules\Report\Controllers'], function() {

    Route::resource('report', 'ReportController');

});
