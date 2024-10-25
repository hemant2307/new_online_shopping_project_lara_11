<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\support\str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\product>
 */
class productFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->unique()->name;
        $slug = str::slug($title);

        $description = fake()->text;

        // $Categories = [1,3,7,8,27,28,29,30];
        // $CateRandKey = array_rand($Categories);

        $subCategories = [1,3,4,5,6,7,8,9,10,11];
        $subCateRandKey = array_rand($subCategories);

        $brands = [1,2,4,6,7,8,9,10];
        $brandRandKey = array_rand($brands);


        return [
           'title' => $title ,
           'slug' => $slug ,
           'description' => $description ,
        //    'category_id' => $Categories[$CateRandKey] ,
           'category_id' => 30 ,
           'sub_Category_id' => $subCategories[$subCateRandKey],
           'brand_id' => $brands[$brandRandKey],
           'price' => rand(200,1000),
           'sku' => rand(1000,10000),
           'track_qty' => 'yes',
           'qty'=> 10,
           'is_featured' =>'yes',
           'status'=> 1

        ];
    }
}
