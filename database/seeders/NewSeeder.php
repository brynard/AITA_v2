<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Project;
use App\Models\ProjectDetails;
use Faker\Factory as Faker;
class NewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $projects = Project::all();

        foreach ($projects as $project) {
            $count = $faker->numberBetween(1, 5);
            for ($i = 0; $i < $count; $i++) {
                ProjectDetails::create([
                    'project_id' => $project->id,
                    'item_name' => $faker->word(),
                    'type' => $faker->randomElement(['asset', 'inventory']),
                    'price' => $faker->randomFloat(2, 10, 1000),
                    'date_received' => $faker->dateTimeBetween('-1 year', 'now'),
                ]);
            }
        }
    }
}
