<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AddAdmin extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = new User();
        $admin->username = 'meet';
        $admin->email = 'meetxvii@gmail.com';
        $admin->password = Hash::make('Monster@1');
        $admin->role = 'admin';
        $admin->is_active = true;
        $admin->is_verified = true;
        $admin->info = true;
        $admin->save();
    }
}
