<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id' => (string) Str::uuid(),
            'name' => $this->faker->words(3, true),
            'description' => $this->faker->paragraph(),
            'category_id' => Category::inRandomOrder()->first()->id ?? Category::factory(), // Fetch a random category_id or create a new one if none exist
            'supplier_id' => Supplier::inRandomOrder()->first()->id ?? Supplier::factory(), // Fetch a random supplier_id or create a new one if none exist
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
