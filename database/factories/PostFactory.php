<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    public function configure()
    {
        return $this->afterMaking(function (Post $post) {
            //
        })->afterCreating(function (Post $post) {
            $rand  = rand(1, 3);
            $post->subjects()->sync(Subject::inRandomOrder()->take($rand)->pluck('id'));
        });
    }
    public function definition()
    {
        return [
            'title'=>$this->faker->word,
            'body'=>$this->faker->sentence(6),
        ];
    }
}
