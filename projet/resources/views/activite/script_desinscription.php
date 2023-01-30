<?php
  use Illuminate\Support\Facades\Schema;
  use App\Models\ActiviteEnfant;
if($_GET) {
  Schema::rename('activite_enfant', 'activite_enfants');
  ActiviteEnfant::where('enfant_id', $_GET['enfant_id'])->where('activite_id', $_GET['activite_id'])->delete();
  Schema::rename('activite_enfants', 'activite_enfant');

  switch($_GET['page']) {
    case 1:
      header("Location: ".route('activite.inscrit', ['activite' => $_GET['activite_id']]));
      break;
    case 2:
      header("Location: ".route('enfant.inscrit', ['enfant' => $_GET['enfant_id']]));
      break;
    case 3:
      header("Location: ".route('compte/compte_enfant.inscrit', ['compte_enfant' => $_GET['enfant_id']]));
      break;
  }
  exit();
} 
else {
  header("Location: ".url('/'));
  exit();

}

?>