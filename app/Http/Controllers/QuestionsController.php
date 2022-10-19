<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Questions;
use App\Models\Technologies;
use App\Models\User;
use App\Models\Reported_questions;
class QuestionsController extends Controller
{
    function getQuestions(Request $request){
        $questions = Questions::where('technology', $request->technology)->leftjoin('users', 'questions.user_id', '=', 'users.id')->select('questions.*', 'users.username')->get();
        return response()->json($questions);
    }

    function getTotalByTechnology(Request $request){
        $total = Questions::where('technology', $request->technology)->count();
        return response()->json($total);
    }

    function getQuestionById(Request $request){
        $question = Questions::where('id', $request->id)->first();
        return response()->json([
            'username' => User::where('id', $question->user_id)->first()->username,
            'technology' => Technologies::where('id', $question->technology)->first()->name,
            'question' => $question
        ]);
    }

    function StoreQuestion(Request $request){
        $question = new Questions;
        $question->user_id = $request->user_id;
        $question->technology = $request->technology;
        $question->title = $request->title;
        $question->body = $request->description;
        
        $question->save();
        return response()->json($question);
    }

    function reportQuestion(Request $request){
        $question_id = $request->input('question_id');
        $user_id = $request->input('user_id');
        $reported_question = Reported_questions::where('question_id',$question_id)->where('user_id',$user_id)->first();
        
        $reported_question = new Reported_questions();
        $reported_question->question_id = $question_id;
        $reported_question->user_id = $user_id;
        $reported_question->save();
    
        return response()->json($reported_question);
    }

    function checkReported(Request $request){
        $question_id = $request->input('question_id');
        $user_id = $request->input('user_id');
        $reported_question = Reported_questions::where('question_id',$question_id)->where('user_id',$user_id)->first();
        if($reported_question){
            return response()->json(true);
        }
        return response()->json(false);
    }

}
