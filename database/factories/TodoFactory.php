<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class TodoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $users = User::pluck('id')->toArray();
        return [
            'user_id' => $this->faker->randomElement($users),
            'description'=>$this->faker->realText(30),
            'status'=>$this->faker->randomElement(['todo','in_progress','done']),
        ];
    }
}
