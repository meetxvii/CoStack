<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\votes;
class vote extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $votes = new votes();
        $votes->user_id = 2;
        $votes->answer_id = 1;
        $votes->vote = 1;
        $votes->save();
    }
}
