<?php

use App\Http\Controllers\TlabServerController;

use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::group(
    ['prefix' => 'tlabServer'],
    // ['prefix' => 'contacts', 'middleware' => 'auth'],
    function () {
        Route::get('/', function () {
            $tlab_server_data = TlabServerController::index();
            return view('home')->with('tlab_server_data',$tlab_server_data);
        });
        Route::get('/hard/{name}', function ($name) {
            $tlab_server_data = TlabServerController::show_hard($name);
            $columns = TlabServerController::table_columns("hard");
            return view('hard')->with([
                'tlab_server_data' => $tlab_server_data,
                "table_columns" => $columns,
            ]);
        });
        Route::get('/soft/{name}', function ($name) {
            $tlab_server_data = TlabServerController::show_soft($name);
            $columns = TlabServerController::table_columns("soft");
            return view('hard')->with([
                'tlab_server_data' => $tlab_server_data,
                "table_columns" => $columns,
            ]);
        });
        Route::get('/disk/{name}', function ($name) {
            $tlab_server_data = TlabServerController::show_disk($name);
            $columns = TlabServerController::table_columns("disk");
            return view('hard')->with([
                'tlab_server_data' => $tlab_server_data,
                "table_columns" => $columns,
            ]);
        });
        Route::get('/net/{name}', function ($name) {
            $tlab_server_data = TlabServerController::show_net($name);
            $columns = TlabServerController::table_columns("net");
            return view('hard')->with([
                'tlab_server_data' => $tlab_server_data,
                "table_columns" => $columns,
            ]);
        });
        Route::get('/cpu/{name}', function ($name) {
            [$data,$date] = TlabServerController::show_cpuused($name);
            return view('hello')->with([
                'y_array' => $data,
                "x_array" => $date,
            ]);
        });
    }
);

// Route::get('/server_home', function () {
//     $tlab_server_data = TlabServerController::index();
//     return view('home')->with('tlab_server_data',$tlab_server_data);
// });

Route::get('hello', 'App\Http\Controllers\HelloController@index');
Route::get('request-json1', 'App\Http\Controllers\RequestController@requestJson1');
Route::post('request-json2', 'App\Http\Controllers\RequestController@requestJson2');
