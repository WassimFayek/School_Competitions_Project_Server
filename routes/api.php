<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\VisitorsController;
use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Mail;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('show_players', [VisitorsController::class, 'show_players']);
Route::get('show_teams', [VisitorsController::class, 'show_teams']);

Route::group([
   'middleware' => 'api',
    'prefix' => 'auth'

], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
    Route::post('register_coach', [AuthController::class, 'register_coach']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::get('user-profile', [AuthController::class, 'userProfile']);
    Route::post('add_teams', [AuthController::class, 'Add_teams']);
    Route::post('add_players', [AuthController::class, 'Add_players']);
    Route::post('add_schools', [AuthController::class, 'Add_schools']);
    Route::post('send_email', [AuthController::class, 'sendEmail']);
    Route::post('approve_account', [AuthController::class, 'approveAccount']);
    Route::post('decline_account', [AuthController::class, 'declineAccount']);
    Route::post('teams_match', [AuthController::class, 'teamsInmatch']);
    Route::post('create_competitions', [AuthController::class, 'create_competition']);
    Route::post('set_result', [AuthController::class, 'set_results']);
    Route::get('show_result', [AuthController::class, 'show_results']);
    Route::get('show_school', [AuthController::class, 'show_schools']);
    Route::get('show_competitions', [AuthController::class, 'show_competitions']);
    Route::get('get_enroll_comp', [AuthController::class, 'getPending_Comp']);
    Route::get('show_games', [AuthController::class, 'show_games']);
    
    Route::post('enroll_comp', [AuthController::class, 'enroll_in_competition']);
});





