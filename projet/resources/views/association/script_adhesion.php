<?php 
  use App\Models\AssociationUser;

if($_GET) {
  Schema::rename('association_user', 'association_users');
  AssociationUser::create([
    'association_id' => $_GET['association_id'],
    'user_id' => $_GET['user_id']
  ]);
  Schema::rename('association_users', 'association_user');

  switch($_GET['page']) {
    case 1:
      header("Location: ".route('association.show', ['association' => $_GET['association_id']]));
      break;
    case 2:
      header("Location: ".route('association.index'));
      break;
  }
  exit();
}
else {
  header("Location: ".url('/'));
  exit();
}
?>