<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminAuth;
use App\Http\Controllers\AdminTasks;
use App\Http\Controllers\TechnologiesController;
use App\Http\Controllers\QuestionsController;
use App\Http\Controllers\Answers_Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Monolog\Handler\RotatingFileHandler;

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


Route::post('register',[\App\Http\Controllers\AuthController::class,'register']);
Route::post('login',[\App\Http\Controllers\AuthController::class,'login']);
Route::post('reset-password', [AuthController::class, 'resetPassword']);

Route::middleware('auth:sanctum')->group(function(){
    Route::get('user',[\App\Http\Controllers\AuthController::class,'user']);
    Route::post('logout',[\App\Http\Controllers\AuthController::class,'logout']);
    Route::get('admin',[\App\Http\Controllers\AdminAuth::class,'admin']);
    Route::post('admin/logout',[\App\Http\Controllers\AdminAuth::class,'logout']);
    Route::post('user/verify', [AuthController::class, 'verify']);
    // Route::post('delete/user',[\App\Http\Controllers\AdminTasks::class,'deleteUser']);

    Route::post('admin/add-technology',[TechnologiesController::class,'addTechnology']);
    Route::post('admin/delete-technology',[TechnologiesController::class,'delete']);

    //question api
    Route::post('ask-question',[QuestionsController::class,'StoreQuestion']);

    Route::post('question/report', [QuestionsController::class,'reportQuestion']);
    Route::get('question/check-reported', [QuestionsController::class,'checkReported']);
    Route::post('user/questions', [QuestionsController::class,'userQuestions']);


    //answer api
    Route::post('answer',[Answers_Controller::class,'StoreAnswer']);

    Route::post('answer/upvote',[Answers_Controller::class,'upvote']);
    Route::post('answer/downvote',[Answers_Controller::class,'downvote']);

    Route::post('answer/report',[Answers_Controller::class,'reportAnswer']);
    Route::post('answer/check-reported',[Answers_Controller::class,'checkReported']);
    Route::post('answer/check-voted',[Answers_Controller::class,'checkVoted']);

    Route::post('answer/mark-as-correct',[Answers_Controller::class,'markAsCorrect']);


    //admin apis
    Route::get('admin/reports',[AdminTasks::class,'getReports']);
    Route::post('admin/delete/question',[AdminTasks::class,'deleteQuestion']);

    Route::post('admin/delete/answer',[AdminTasks::class,'deleteAnswer']);

    Route::get('admin/dashboard', [AdminTasks::class,'dashboardData']);
    Route::get('admin/users/all', [AdminTasks::class,'allUsers']);
    Route::post('admin/users/deactivate', [AdminTasks::class,'deactivateUser']);
    Route::post('admin/users/activate', [AdminTasks::class,'activateUser']);
    
});

Route::post('check-username',[\App\Http\Controllers\UserData::class,'checkUsername']);
Route::post('check-email',[\App\Http\Controllers\UserData::class,'checkEmail']);

Route::post('admin/login',[\App\Http\Controllers\AdminAuth::class,'login']);

Route::get('technologies',[TechnologiesController::class,'getTechnologies']);
Route::get('technology',[TechnologiesController::class,'getTechnology']);

Route::post('questions',[QuestionsController::class,'getQuestions']);
Route::get('question',[QuestionsController::class,'getQuestionById']);
Route::get('total-questions',[QuestionsController::class,'getTotalByTechnology']);
Route::get('questions/featured', [QuestionsController::class,'getFeaturedQuestions']);

Route::get('answers',[Answers_Controller::class,'getAnswerByQuestionId']);

Route::post('search', [QuestionsController::class,'search']);

Route::post('check-token', [AuthController::class,'checkToken']);
Route::post('change-password', [AuthController::class, 'changePassword']);