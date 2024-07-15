<?php

namespace Database\Factories;

use App\Models\Setting;
use App\Models\Color; // Assuming your Color model namespace
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class SettingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Setting::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // Fetch 3 random colors in random order
        $colors = Color::inRandomOrder()->limit(3)->get()->pluck('id', 'name')->toArray();

        // Prepare selected colors data
        $selectedColors = [];
        foreach ($colors as $name => $id) {
            $selectedColors[] = [
                'id' => $id,
                'name' => $name,
            ];
        }

        return [
            'id' => (string) Str::uuid(),
            'colors' => json_encode($selectedColors),
            'price' => $this->faker->randomFloat(2, 10, 100), 
            'visibility' => $this->faker->boolean ? 1 : 0, 
            'main_picture' => $this->faker->imageUrl(640, 480, 'business', true, 'Faker'), 
            'product_id' => Product::inRandomOrder()->first()->id ?? Product::factory(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
