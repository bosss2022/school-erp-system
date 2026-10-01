<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Teacher;
use Illuminate\Support\Facades\Hash;

class TeacherSeeder extends Seeder
{
    public function run(): void
    {
        $genders = ['Male', 'Female'];
        $teachers = [];

        for ($i = 1; $i <= 15; $i++) {
            $first = fake()->firstName();
            $last = fake()->lastName();
            $email = strtolower($first . '.' . $last . $i . '@school.com');
            $gender = $genders[array_rand($genders)];

            // Create linked user
            $user = User::create([
                'name' => "{$first} {$last}",
                'email' => $email,
                'password' => Hash::make('password'),
                'role' => 'teacher',
            ]);

            // Create teacher record
            $teachers[] = [
                'user_id' => $user->id,
                'first_name' => $first,
                'last_name' => $last,
                'email' => $email,
                'phone' => fake()->phoneNumber(),
                'gender' => $gender,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        Teacher::insert($teachers);

        $this->command->info('✅ 15 teachers and their user accounts created successfully!');
    }
}
