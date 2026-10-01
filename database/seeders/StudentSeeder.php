<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Student;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
       for ($i = 1; $i <= 50; $i++) {
            $gender = $i % 2 === 0 ? 'Male' : 'Female';

            $user = User::create([
                'name' => "Student $i",
                'email' => "student$i@example.com",
                'password' => Hash::make('password'),
                'role' => 'student',
            ]);

            Student::create([
                'admission_no' => 'ADM' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'first_name' => 'Student',
                'last_name' => (string) $i,
                'gender' => $gender,
                'email' => "student$i@example.com",
                'phone' => '07' . rand(10000000, 99999999),
                'user_id' => $user->id,
            ]);
        }

        echo "✅ Seeded 50 Students Successfully!\n";
        echo "Login as Admin: admin@example.com | password\n";
    }
}