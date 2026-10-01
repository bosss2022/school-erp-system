<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Guardian;
use Faker\Factory as Faker;

class GuardianSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 0; $i < 50; $i++) {
            Guardian::create([
                'first_name' => $faker->firstName,
                'last_name'  => $faker->lastName,
                'email'      => $faker->unique()->safeEmail,
                'phone'      => $faker->phoneNumber,
            ]);
        }

        $this->command->info('✅ Seeded 50 Guardians Successfully!');
    }
}
