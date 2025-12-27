<?php

namespace Database\Factories;

use App\Models\News;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class NewsFactory extends Factory
{
    protected $model = News::class;

    public function definition(): array
    {
        $title = $this->faker->sentence(6);

        return [
            'title'         => $title,
            'slug'          => Str::slug($title) . '-' . $this->faker->unique()->numberBetween(100, 999),
            'summary'       => $this->faker->sentence(12),
            'content'       => $this->faker->paragraphs(5, true),
            'thumbnail'     => 'default.jpg',
            'status'        => 'published',
            'published_at'  => now(),
            'created_by'    => User::factory(),
        ];
    }

    public function unpublished(): self
    {
        return $this->state(fn () => [
            'status' => 'draft',
            'published_at' => null,
        ]);
    }
}
