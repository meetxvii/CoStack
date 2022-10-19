<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Answers;
class Answer extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $answer = new Answers();
        $answer->question_id = 1;
        $answer->user_id = 3;
        $answer->answer = 'Answer 1';
        $answer->is_correct = 0;
        $answer->save();
    }
}
