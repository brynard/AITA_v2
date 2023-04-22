<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as Faker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = Faker::create();
        $logoUrl = $faker->imageUrl($width = 640, $height = 480);
        $logoData = base64_encode(file_get_contents($logoUrl));
        return [
            'name' => $faker->company,
            'budget' => $faker->numberBetween(1000, 10000),
            'status' => $faker->randomElement(['working', 'completed']),
            'completion' => $faker->numberBetween(0, 100),
            'logo' => $logoData,
        ];
    }
}
