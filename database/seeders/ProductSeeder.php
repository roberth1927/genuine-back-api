<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;


class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $faker = Faker::create();
        $categories = Category::all();

        foreach ($categories as $category) {
            for ($i = 0; $i < 10; $i++) {
                Product::create([
                    'name' => $faker->word,
                    'description' => $faker->sentence,
                    'quantity' => $faker->numberBetween(1, 100),
                    'category_id' => $category->id,
                ]);
            }
        }
    }
}
