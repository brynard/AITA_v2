<?php

namespace Database\Seeders;

use Database\Factories\ProjectFactory;
use Illuminate\Database\Seeder;
use Database\Factories\ProjectDetailsFactory;


use App\Models\Project;
use App\Models\ProjectDetails;

class MySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Project::factory()
            ->count(10)
            ->create()
            ->each(function ($project) {
                $details = ProjectDetailsFactory::new()
                    ->count(5)
                    ->make(['project_id' => $project->id]);
                $project->projectDetails()->saveMany($details);
            });
    }
}
