<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'nom' => 'compte',
            'prenom' => 'Utilisateur',
            'pseudonyme' => 'Utilisateur',
            'statut' => '1',
            'email' => 'ex@utilisateur',
            'email_verified_at' => now(),
            'password' => bcrypt('motdepasse'),
            'remember_token' => '', 
          ]);
          User::create([
              'nom' => 'compte',
              'prenom' => 'Gestionnaire',
              'pseudonyme' => 'Gestionnaire',
              'statut' => '2',
              'email' => 'ex@gestionnaire',
              'email_verified_at' => now(),
              'password' => bcrypt('motdepasse'),
              'remember_token' => '', 
            ]);
            User::create([
                'nom' => 'compte',
                'prenom' => 'Administrateur',
                'pseudonyme' => 'Administrateur',
                'statut' => '3',
                'email' => 'ex@administrateur',
                'email_verified_at' => now(),
                'password' => bcrypt('motdepasse'),
                'remember_token' => '', 
              ]);
        User::factory()->count(35)->create();
    }
}
