@extends('template')
@section('title') Modifier un enfant @endsection
@section('content')

<div class="modal fade" id="supprimerModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-dark" id="supprimerModalLabel">Suppression d'un enfant</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-dark">
        Êtes-vous sûr de vouloir supprimer cet enfant ?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Annuler</button>
        <button type="button" class="btn btn-outline-danger" onclick="confirmer('{{url('enfant/')}}')">Confirmer</button>
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

<form action="{{url('enfant', $enfant->id)}}" method="post">
  @csrf
  @method('PUT')
  <div class="mb-3 row">
    <label for="nom" class="col-sm-2 col-form-label">Nom</label>

    <div class="col-sm-10">
      <input type="text" class="form-control @error('nom') is-invalid @enderror" name="nom" id="nom" placeholder="Saisir le nom de l'enfant" value="{{$enfant->nom}}" />
    </div>
  </div>

  <div class="mb-3 row">
    <label for="prenom" class="col-sm-2 col-form-label">Prénom</label>

    <div class="col-sm-10">
      <input value="{{$enfant->prenom}}" type="text" class="form-control @error('prenom') is-invalid @enderror" name="prenom" id="prenom" placeholder="Saisir le prénom de l'enfant"/>
    </div>
  </div>

  <div class="mb-3 row">
    <label for="birth" class="col-sm-2 col-form-label">Date de naissance</label>

    <div class="col-sm-10">
      <input type="datetime-local" class="form-control @error('birth') is-invalid @enderror" name="birth" id="birth" placeholder="Saisir la date de naissance de l'enfant"
      value="{{IntlDateFormatter::formatObject(new DateTime($enfant->birth), 'yyyy-MM-dd HH:mm', 'fr') }}"/>
    </div>
  </div>

  <div class="mb-3 row">
    <label for="user_id" class="col-sm-2 col-form-label">Parent</label>
    
    <div class="col-sm-10">
      <select class="form-control" name="user_id" id="user_id" placeholder="Saisir le parent">
        <?php
          $users = DB::select('SELECT * FROM users');
        ?>
        @foreach($users as $parent)
          <option value="{{$parent->id}}" @if($parent->id === $enfant->user->id) selected @endif>{{$parent->prenom}} {{$parent->nom}}</option>
        @endforeach
      </select>
    </div>
</div>

  <div class="mb-3">
    <div class="offset-sm-2 col-sm-10">
      
      <button type="button" data-bs-toggle="modal" data-bs-target="#supprimerModal" onclick="supprimer({{$enfant->id}})" class="btn btn-danger mb-1">
        Supprimer
      </button>  &nbsp; 

      <button class="btn btn-success mb-1 mr-1" type="submit">Enregistrer</button>  &nbsp; 

      <a href="{{route('enfant.index')}}" class="btn btn-secondary mb-1">Annuler</a>
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