<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Activite;
use App\Models\Enfant;
use App\Models\ActiviteEnfant;
use Illuminate\Support\Facades\Schema;

class ActiviteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Activite::factory()->count(75)->create();

        $activite = DB::table('activites')->pluck('id');
        $enfant = DB::table('enfants')->pluck('id');
        $faker = \Faker\Factory::create();

        foreach($activite as $idActivite) {
            for($i = 0; $i < rand(1, Activite::findorFail($idActivite)->places)*5 ; $i++) {
                $inscription = ActiviteEnfant::where('activite_id', $idActivite)->count();
                if ($inscription<Activite::findorFail($idActivite)->places) {
                    $genere = $faker->randomElement($enfant);
                    $user = DB::table('users')->where('id', Enfant::findorFail($genere)->user_id)->pluck('id');
                    $association = DB::table('associations')->where('id', Activite::findorFail($idActivite)->association_id)->pluck('id');
                    
                    if(DB::table('association_user')->where('association_id', $association)->where('user_id', $user)->count() != 0) {
                        ActiviteEnfant::create([
                            'activite_id' => $idActivite,
                            'enfant_id' => $genere
                        ]);
                    }
                }
            }
        }
        
        Schema::rename('activite_enfants', 'activite_enfant');
    }
}
