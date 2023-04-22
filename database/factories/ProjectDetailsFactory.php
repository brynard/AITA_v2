<?php

namespace Database\Factories;

use Faker\Factory as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Project;
use App\Models\ProjectDetails;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProjectDetails>
 */
class ProjectDetailsFactory extends Factory
{
    protected $model = ProjectDetails::class;

    public function definition()
    {
        $faker = Faker::create();
        $logoUrl = $faker->imageUrl($width = 640, $height = 480);
        $logoData = base64_encode(file_get_contents($logoUrl));
        return [
            'project_id' => function () {
                return Project::all()->random()->id;
            },
            'item_name' => $faker->word,
            'type' => $faker->randomElement(['Asset', 'Inventory']),
            'price' => $faker->numberBetween(100, 10000),
            'date_received' => $faker->dateTimeBetween('-1 year', 'now'),
            'status' => $faker->randomElement(['In-Use', 'Available', 'Loaned']),
            'image'  => $logoData,
        ];
    }
}
