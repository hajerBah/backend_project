<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

class SupplierFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Supplier::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id' => (string) Str::uuid(),
            'name' => $this->faker->company,
            'email' => $this->faker->unique()->safeEmail,
            'password' => static::$password ??= Hash::make('password'),
            'address' => $this->faker->address,
            'phone' => $this->faker->unique()->phoneNumber,
            'logo' => $this->faker->imageUrl(640, 480, 'business', true, 'Faker'), 
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

     /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterCreating(function (Supplier $supplier) {
            $categories = Category::inRandomOrder()->limit(3)->get();
            $supplier->categories()->attach($categories);
        });
    }
}
