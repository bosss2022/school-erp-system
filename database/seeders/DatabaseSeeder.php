<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Student;

class DatabaseSeeder extends Seeder
{
    public function run()
    {

         $this->call([
         StudentSeeder::class,
        TeacherSeeder::class,
        GuardianSeeder::class,
    ]);
     
}
}