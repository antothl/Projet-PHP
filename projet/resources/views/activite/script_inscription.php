<?php 
  use App\Models\ActiviteEnfant;

if($_GET) {
  Schema::rename('activite_enfant', 'activite_enfants');
  ActiviteEnfant::create([
    'activite_id' => $_GET['activite_id'],
    'enfant_id' => $_GET['enfant_id']
  ]);
  Schema::rename('activite_enfants', 'activite_enfant');

  header("Location: ".route('activite.show', ['activite' => $_GET['activite_id']]));
  exit();
}
else {
  header("Location: ".url('/'));
  exit();
}

?>