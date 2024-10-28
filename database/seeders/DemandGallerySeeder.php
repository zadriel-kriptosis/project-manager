<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DemandGallery;
use App\Models\Demand;
use Illuminate\Support\Str;

class DemandGallerySeeder extends Seeder
{
    public function run()
    {
        $faker = \Faker\Factory::create();

        // Get all demands
        $demands = Demand::all();

        // Image paths for demand gallery
        $imgPaths = [
            'uploads/demandgallery/demand1.jpg',
            'uploads/demandgallery/demand2.jpg',
            'uploads/demandgallery/demand3.jpg',
        ];

        foreach ($demands as $demand) {
            // Randomly decide if this demand will have galleries (50% chance)
            if ($faker->boolean(50)) {
                // Create random number of galleries for this demand (you can adjust the number if needed)
                $galleryCount = $faker->numberBetween(1, 3); // Between 1 and 3 galleries

                for ($i = 0; $i < $galleryCount; $i++) {
                    DemandGallery::create([
                        'id' => Str::uuid(),
                        'demand_id' => $demand->id,
                        'img' => $faker->randomElement($imgPaths), // Randomly choose an image path
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
    }
}
