<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Answers;
use App\Models\Votes;
use App\Models\Reported_answers;
use App\Models\Questions;
class Answers_Controller extends Controller
{
    function getAnswerByQuestionId(Request $request){
        $question_id = $request->input('question_id');
        $answers = Answers::where('question_id',$question_id)->leftJoin('users','answers.user_id','=','users.id')->select('answers.*','users.username')->get();
        $final_answers = [];
        foreach($answers as $answer){
            $answer['vote'] = Votes::where('answer_id',$answer->id)->sum('vote');
            $final_answers[] = $answer;
        }
        return response()->json($final_answers) ;
    }

    function StoreAnswer(Request $request){
        $answer = new Answers;
        $answer->answer = $request->input('answer');
        $answer->question_id = $request->input('question_id');
        $answer->user_id = $request->input('user_id');
        $answer->save();
        return response()->json(['message'=>'Answer added successfully']);
    }

    function upvote(Request $request){
        $answer_id = $request->input('answer_id');
        $user_id = $request->input('user_id');
        $vote = Votes::where('answer_id',$answer_id)->where('user_id',$user_id)->first();
        if($vote){
            if($vote->vote == 1 || $vote->vote == -1){
                $vote->vote = 0;
            }else{
                $vote->vote = 1;
            }
            $vote->save();
        }else{
            $vote = new Votes;
            $vote->answer_id = $answer_id;
            $vote->user_id = $user_id;
            $vote->vote = 1;
            $vote->save();
        }
        return response()->json($vote);
    }

    function downvote(Request $request){
        $answer_id = $request->input('answer_id');
        $user_id = $request->input('user_id');
        $vote = Votes::where('answer_id',$answer_id)->where('user_id',$user_id)->first();
        if($vote){
            if($vote->vote == -1 || $vote->vote == 1){
                $vote->vote = 0;
            }else{
                $vote->vote = -1;
            }
            $vote->save();
        }else{
            $vote = new Votes;
            $vote->answer_id = $answer_id;
            $vote->user_id = $user_id;
            $vote->vote = -1;
            $vote->save();
        }
        return response()->json($vote);
    }

    function reportAnswer(Request $request){
        $answer_id = $request->input('answer_id');
        $user_id = $request->input('user_id');
        $reported_answer = Reported_answers::where('answer_id',$answer_id)->where('user_id',$user_id)->first();
        
        $reported_answer = new Reported_answers;
        $reported_answer->answer_id = $answer_id;
        $reported_answer->user_id = $user_id;
        $reported_answer->save();
    
        return response()->json($reported_answer);
    }

    function checkReported(Request $request){
        $answer_id = $request->input('answer_id');
        $user_id = $request->input('user_id');
        $reported_answer = Reported_answers::where('answer_id',$answer_id)->where('user_id',$user_id)->first();
        return response()->json($reported_answer);
    }

    function checkVoted(Request $request){
        $answer_id = $request->input('answer_id');
        $user_id = $request->input('user_id');
        $vote = Votes::where('answer_id',$answer_id)->where('user_id',$user_id)->first();
        return response()->json($vote);
    }

    function markAsCorrect(Request $request){
        $answer_id = $request->input('answer_id');
        $answer = Answers::find($answer_id);
        $answer->is_correct = 1;
        $answer->save();

        $question = Questions::find($answer->question_id);
        $question->isSOlved = 1;
        $question->save();
        return response()->json($answer);

    }
}
