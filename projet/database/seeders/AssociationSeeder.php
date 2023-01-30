<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Association;
use App\Models\AssociationUser;
use Illuminate\Support\Facades\Schema;

class AssociationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      //Liste des associations
        Association::create([
            'nom' => 'Gaming-walk'
        ]);
        Association::create([
            'nom' => 'Exploration nature'
        ]);
        Association::create([
            'nom' => 'Culture & vous'
        ]);
        Association::create([
            'nom' => 'Sportoujours'
        ]);
        Association::create([
            'nom' => 'Asso-commune'
        ]);

      $association = DB::table('associations')->pluck('id');
      $user = DB::table('users')->pluck('id');
      $faker = \Faker\Factory::create();

      Schema::rename('association_user', 'association_users');
      foreach($association as $idAssociation) {
          for($i = 0; $i < rand(1,5000) ; $i++) {
                $genere = $faker->randomElement($user);
                if(DB::table('association_users')->where('association_id', $idAssociation)->where('user_id', $genere)->count() == 0) {
                    AssociationUser::create([
                    'association_id' => $idAssociation,
                    'user_id' => $genere
                    ]);
                }
            }
      }
      Schema::rename('association_users', 'association_user');

    }
}
