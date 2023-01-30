@extends('template')
@section('title') Modifier un utilisateur @endsection
@section('content')

<div class="modal fade" id="supprimerModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-dark" id="supprimerModalLabel">Suppression d'un utilisateur</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-dark">
        Êtes-vous sûr de vouloir supprimer cet utilisateur ?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Annuler</button>
        <button type="button" class="btn btn-outline-danger" onclick="confirmer('{{url('user/')}}')">Confirmer</button>
      </div>
    </div>
  </div>
</div>

@if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{url('user', $user->id)}}" method="post">
  @csrf
  @method('PUT')
  <div class="mb-3 row">
    <label for="titre" class="col-sm-2 col-form-label">Pseudonyme</label>

    <div class="col-sm-10">
      <input type="text" class="form-control" name="pseudonyme" id="pseudonyme" placeholder="Saisir le pseudo de l'utilisateur" value="{{$user->pseudonyme}}"/>
    </div>
  </div>

  <div class="mb-3 row">
    <label for="prenom" class="col-sm-2 col-form-label">Prénom</label>

    <div class="col-sm-10">
      <textarea class="form-control" id="prenom" name="prenom" rows="3" placeholder="Saisir le prenom de l'utilisateur">{{$user->prenom}}</textarea>
    </div>
  </div>
  <div class="mb-3 row">
    <label for="nom" class="col-sm-2 col-form-label">Nom</label>

    <div class="col-sm-10">
      <textarea class="form-control" id="nom" name="nom" rows="3" placeholder="Saisir le nom de l'utilisateur">{{$user->nom}}</textarea>
    </div>
  </div>
  <div class="mb-3 row">
    <label for="email" class="col-sm-2 col-form-label">Adresse Email</label>

    <div class="col-sm-10">
      <textarea class="form-control" id="email" name="email" rows="3" placeholder="Saisir l'adresse Email de l'utilisateur">{{$user->email}}</textarea>
    </div>
  </div>

<div class="mb-3 row">
  <label for="statut" class="col-sm-2 col-form-label">Statut de l'utilisateur</label>

  <div class="col-sm-10">
    <select class="form-control" name="statut" id="statut" placeholder="Saisir le statut de l'utilisateur">
      <option value="1" @if($user->statut === 1) selected @endif>Utilisateur</option>
      <option value="2" @if($user->statut === 2) selected @endif>Gestionnaire</option>
      <option value="3" @if($user->statut === 3) selected @endif>Administrateur</option>
    </select>
  </div>
</div>


<div class="mb-3">
  <div class="offset-sm-2 col-sm-10">

    <button type="button" data-bs-toggle="modal" data-bs-target="#supprimerModal" onclick="supprimer({{$user->id}})" class="btn btn-danger mb-1">
      Supprimer
    </button>  &nbsp; 

    <button class="btn btn-success mb-1 mr-1" type="submit">Enregistrer</button>  &nbsp; 

    <a href="{{route('user.index')}}" class="btn btn-secondary mb-1">Annuler</a>
  </div>
</div>

</form>

<form id="deleteForm" action="" method="POST">
  @method('DELETE')
  @csrf
</form>

</div>
@endsection

@section('head')
<script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
<script defer src="{{asset('storage/js/delete.js')}}"></script>
@endsection