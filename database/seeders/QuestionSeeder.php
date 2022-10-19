<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Questions;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $question = new Questions();
        $question->user_id = 1;
        $question->technology = 18;
        $question->title = 'How to create a new Laravel project?';
        $question->body = 'I am new to Laravel and I want to create a new Laravel project. How can I do that?';
        $question->isFeatured = 0;
        $question->isActive = 1;
        $question->isSolved = 0;
        $question->save();
    }
}
