<?php
  use Illuminate\Support\Facades\Schema;
  use App\Models\AssociationUser;
  use App\Models\ActiviteEnfant;
  use App\Models\Activite;
  use App\Models\User;

if($_GET) {
  Schema::rename('association_user', 'association_users');
  
  Schema::rename('activite_enfant', 'activite_enfants');
  foreach(User::findorFail($_GET['user_id'])->enfant as $enfant) {
    foreach(Activite::where('association_id', $_GET['association_id'])->pluck('id') as $activite) {
      ActiviteEnfant::where('enfant_id', $enfant->id)->where('activite_id', $activite)->delete();
    }
  }
  Schema::rename('activite_enfants', 'activite_enfant');

  AssociationUser::where('association_id', $_GET['association_id'])->where('user_id', $_GET['user_id'])->delete();
  Schema::rename('association_users', 'association_user');

  switch($_GET['page']) {
    case 1:
      header("Location: ".route('association.show', ['association' => $_GET['association_id']]));
      break;
    case 2:
      header("Location: ".route('association.index'));
      break;
    case 3:
      header("Location: ".route('association.adherant', ['association' => $_GET['association_id']]));
      break;
  }
  exit();
}
else {
  header("Location: ".url('/'));
  exit();
}

?>