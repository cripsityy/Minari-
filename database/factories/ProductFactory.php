<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        $price = $this->faker->numberBetween(50000, 500000);
        $hasDiscount = $this->faker->boolean(30);
        
        return [
            'name' => $this->faker->words(3, true),
            'slug' => $this->faker->unique()->slug,
            'description' => $this->faker->paragraphs(3, true),
            'price' => $price,
            'discount_price' => $hasDiscount ? $price * 0.8 : null,
            'stock' => $this->faker->numberBetween(0, 100),
            'sku' => 'MIN' . $this->faker->unique()->numberBetween(1000, 9999),
            'size' => implode(',', $this->faker->randomElements(['S', 'M', 'L', 'XL'], 2)),
            'color' => $this->faker->colorName,
            'material' => $this->faker->randomElement(['Cotton', 'Linen', 'Denim', 'Polyester', 'Wool']),
            'category_id' => Category::inRandomOrder()->first()->id,
            'status' => $this->faker->randomElement(['available', 'out_of_stock', 'pre_order']),
            'sold_count' => $this->faker->numberBetween(0, 500),
            'view_count' => $this->faker->numberBetween(0, 1000)
        ];
    }
}