<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Book>
 */
class BookFactory extends Factory
{
    /**
     * Membuat data contoh buku.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = Str::title(fake()->unique()->words(3, true));

        return [
            'category_id' => Category::factory(),
            'title' => $title,
            'slug' => Str::slug($title),
            'author' => fake()->name(),
            'publisher' => fake()->company(),
            'published_year' => fake()->numberBetween(1950, 2024),
            'isbn' => fake()->isbn13(),
            'price' => fake()->numberBetween(45000, 250000),
            'stock' => fake()->numberBetween(1, 20),
            'description' => fake()->paragraph(),
            'cover_image' => null,
        ];
    }

    /**
     * Menandai buku sebagai buku yang stoknya habis.
     */
    public function outOfStock(): static
    {
        return $this->state(fn (array $attributes): array => [
            'stock' => 0,
        ]);
    }
}
