<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Activite>
 */
class ActiviteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $choix = $this->faker->numberBetween($min = 1, $max = 10);
        $date1 =$this->faker->dateTimeBetween('now', '+1 month');

        $associationID = DB::table('associations')->pluck('id');

        switch($choix) {
            case 1:
                return [
                    'titre' => 'Séance Pokémon GO',
                    'description' => "Nous allons chercher des pokémons dans la ville !!",
                    'dateDebut' => $date1,
                    'dateFin' => date( "Y-m-d H:i:s", strtotime("+3 hour", strtotime($date1->format("Y-m-d H:i:s")))),
                    'places' => $this->faker->numberBetween($min = 1, $max = 50),
                    'association_id' => 1
                ];
                break;
            case 2:
                return [
                    'titre' => 'Visite du lac',
                    'description' => "Nous allons visiter le lac de l'Ailette.",
                    'dateDebut' => $date1,
                    'dateFin' => date( "Y-m-d H:i:s", strtotime("+4 hour", strtotime($date1->format("Y-m-d H:i:s")))),
                    'places' => $this->faker->numberBetween($min = 1, $max = 60),
                    'association_id' => 2
                ];
                break;
            case 3:
                return [
                    'titre' => 'Balade en vélo',
                    'description' => "Nous allons visiter faire une balade en vélo dans la forêt.",
                    'dateDebut' => $date1,
                    'dateFin' => date( "Y-m-d H:i:s", strtotime("+2 hour", strtotime($date1->format("Y-m-d H:i:s")))),
                    'places' => $this->faker->numberBetween($min = 1, $max = 30),
                    'association_id' => 4
                ];
                break;
            case 4:
                return [
                    'titre' => 'Atelier peinture',
                    'description' => "Rendez-vous à la salle des fêtes pour une activite manuelle avec de la peinture!!",
                    'dateDebut' => $date1,
                    'dateFin' => date( "Y-m-d H:i:s", strtotime("+1 hour", strtotime($date1->format("Y-m-d H:i:s")))),
                    'places' => $this->faker->numberBetween($min = 1, $max = 45),
                    'association_id' => 3
                ];
                break;
            case 5:
                return [
                    'titre' => 'Piscine',
                    'description' => "Séance piscine pour tous les âges.",
                    'dateDebut' => $date1,
                    'dateFin' => date( "Y-m-d H:i:s", strtotime("+2 hour", strtotime($date1->format("Y-m-d H:i:s")))),
                    'places' => $this->faker->numberBetween($min = 1, $max = 60),
                    'association_id' => 4
                ];
                break;
            case 6:
                return [
                    'titre' => 'Match de football',
                    'description' => "Rendez-vous au terrain de football derrière la mairie.",
                    'dateDebut' => $date1,
                    'dateFin' => date( "Y-m-d H:i:s", strtotime("+3 hour", strtotime($date1->format("Y-m-d H:i:s")))),
                    'places' => $this->faker->numberBetween($min = 1, $max = 25),
                    'association_id' => 4
                ];
                break;
            case 7:
                return [
                    'titre' => 'Garderie',
                    'description' => "Se déroule dans la salle garderie au 1er étage de la mediatheque",
                    'dateDebut' => $date1,
                    'dateFin' => date( "Y-m-d H:i:s", strtotime("+4 hour", strtotime($date1->format("Y-m-d H:i:s")))),
                    'places' => $this->faker->numberBetween($min = 1, $max = 30),
                    'association_id' => 5
                ];
                break;
            case 8:
                return [
                    'titre' => 'Innitiation au badminton',
                    'description' => "Découverte du badminton au gymnase de la commune.",
                    'dateDebut' => $date1,
                    'dateFin' => date( "Y-m-d H:i:s", strtotime("+3 hour", strtotime($date1->format("Y-m-d H:i:s")))),
                    'places' => $this->faker->numberBetween($min = 1, $max = 50),
                    'association_id' => 4
                ];
                break;
            case 9:
                return [
                    'titre' => 'Balade en forêt',
                    'description' => "Etudes de la faune et de la flore locale, départ de la balade à la mairie.",
                    'dateDebut' => $date1,
                    'dateFin' => date( "Y-m-d H:i:s", strtotime("+2 hour", strtotime($date1->format("Y-m-d H:i:s")))),
                    'places' => $this->faker->numberBetween($min = 1, $max = 50),
                    'association_id' => 2
                ];
                break;
            case 10:
                return [
                    'titre' => 'Atelier photographie',
                    'description' => "Venez apprendre l'art de la photographie, pour les grands et les petits. Rendez vous à la salle des fêtes.",
                    'dateDebut' => $date1,
                    'dateFin' => date( "Y-m-d H:i:s", strtotime("+2 hour", strtotime($date1->format("Y-m-d H:i:s")))),
                    'places' => $this->faker->numberBetween($min = 1, $max = 50),
                    'association_id' => 3
                ];
                break;
        }
    }
}
