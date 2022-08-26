<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'nom' => 'AVOTRINIAINA',
            'prenom' => 'Mialison',
            'cin' => '{"numero":"201031053130","date_delivrance":"2019-05-22","date_naissance":"2001-05-15","lieu_naissance":"Fandriana","date_duplicata":"","lieu_duplicata":"","pere":"","mere":"RANORO"}',
            'telephone' => '+261 34 95 681 80',
            'email' => 'avotriniainamialison1106@gmail.com',
            'password' => bcrypt('01234'),
            'photo' => 'profiles/mialison.jpg',
            'mot_de_passe' => '01234',
            'adresse' => 'Lot 0025/3608 à Sahalava Sud Fianarantsoa',
            'type_user_id' => 1,
            'online' => true,
            'status' => 0,
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            // 'name' => '',
            // 'email' => $this->faker->unique()->safeEmail(),
            // 'email_verified_at' => now(),
            // 'password' => 'mldevy', // password
            // 'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
