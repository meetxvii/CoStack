<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reported_questions;
use App\Models\Questions;
use App\Models\Reported_answers;
use App\Models\Answers;
use App\Models\User;
use App\Models\Technologies;
class AdminTasks extends Controller
{
 
    function getReports(){
        $reported_questions_ids = Reported_questions::groupBy('question_id')
        ->selectRaw('count(*) as total, question_id')
        ->orderBy('total', 'desc')->get();
        $reported_questions = array();
        foreach($reported_questions_ids as $question){
            $reported_question = Questions::find($question->question_id);
            array_push($reported_questions,['question' => $reported_question , 'total_reports' =>$question->total]);
        }
        
        // do same for answers
        $reported_answers_ids = Reported_answers::groupBy('answer_id')
        ->selectRaw('count(*) as total, answer_id')
        ->orderBy('total', 'desc')->get();
        $reported_answers = array();
        foreach($reported_answers_ids as $answer){
            $reported_answer = Answers::find($answer->answer_id);
            array_push($reported_answers,['answer' => $reported_answer , 'total_reports' =>$answer->total]);
        }
        return response()->json([
            'questions' => $reported_questions,
            'answers' => $reported_answers
        ]);
        
    }

    function deleteQuestion(Request $request){
        $question = Questions::find($request->question_id);
        $question->delete();
        return response()->json([
            'message' => 'question deleted successfully'
        ]);
    }

    function deleteAnswer(Request $request){
        $answer = Answers::find($request->answer_id);
        $answer->delete();
        return response()->json([
            'message' => 'answer deleted successfully'
        ]);
    }

    function dashboardData(){
        $users = User::all()->count();
        $technologies = Technologies::all()->count();
        $reported_question = Reported_answers::all()->count();
        $reported_answers = Reported_answers::all()->count();
        return response()->json([
            'users' => $users,
            'technologies' => $technologies,
            'reports'=> $reported_question + $reported_answers
        ]);
    }

    function allUsers(){
        $users = User::all();
        return response()->json([
            'users' => $users
        ]);
    }

    function deactivateUser(Request $request){
        $user = User::find($request->user_id);
        $user->is_active = 0;
        $user->save();
        return response()->json([
            'message' => 'user deactivated successfully'
        ]);
    }

    function activateUser(Request $request){
        $user = User::find($request->user_id);
        $user->is_active = 1;
        $user->save();
        return response()->json([
            'req'=>$request->user_id,
            'message' => 'user activated successfully'
        ]);
    }

}
