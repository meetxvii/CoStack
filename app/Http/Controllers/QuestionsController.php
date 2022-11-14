<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Questions;
use App\Models\Technologies;
use App\Models\User;
use App\Models\Reported_questions;
use Symfony\Component\Console\Question\Question;

class QuestionsController extends Controller
{
    function getQuestions(Request $request){
        // $questions = Questions::where('technology', $request->technology)->leftjoin('users', 'questions.user_id', '=', 'users.id')->select('questions.*', 'users.username')->get();

        // go through each question and check if question is 3 or more days older than mark it as Featured
        
        $new_questions = Questions::where('technology', $request->technology)->get();

        foreach($new_questions as $question){
            $username = User::where('id', $question->user_id)->first();
            $question->username = $username->username;
            if($question->created_at->diffInDays() >= 3 && $question->isSolved ==0){
                $question->isFeatured = 1;
            }else{
                $question->isFeatured = 0;    
            }
        }

        $questions = $new_questions->empty();
               
        foreach($new_questions as $question){
            
            if($question->isFeatured == 1){
                $questions->prepend($question);
            }else{
                $questions->push($question);
            }
        }

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

    function search(Request $request){
        $question = Questions::where('title', 'like', '%'.$request->searchQuery.'%')->get();
        foreach($question as $q){
            $username = User::where('id', $q->user_id)->first();
            $q->username = $username->username;

            $technology = Technologies::where('id', $q->technology)->first();
            $q->technology = $technology->name;
        }
        return response()->json($question);
    }

    function getFeaturedQuestions(Request $request){
        $questions = Questions::where('isSolved', 0)->where('created_at', '<=', now()->subDays(3))->get();

        foreach($questions as $question){
            $username = User::where('id', $question->user_id)->first();
            $question->username = $username->username;

            $technology_name = Technologies::where('id', $question->technology)->first();
            $question->technology_name = $technology_name->name;
        }
        
        return response()->json($questions);
    }
    
    function userQuestions(Request $request){
        $questions = Questions::where('user_id', $request->user_id)->get();
        foreach($questions as $question){
            $technology_name = Technologies::where('id', $question->technology)->first();
            $question->technology_name = $technology_name->name;
        }
        $username = User::where('id', $request->user_id)->first()->username;
        return response()->json([
            'questions' => $questions,
            'username' => $username
        ]);
    }

}
