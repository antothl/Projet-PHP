<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Enfants>
 */
class EnfantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $usersID = DB::table('users')->pluck('id');
        return [
            'nom' => $this->faker->lastName(),
            'prenom' => $this->faker->firstName(),
            'birth' =>  $this->faker->date('Y-m-d'),
            'user_id' => $this->faker->randomElement($usersID)
          ];
    }
}
