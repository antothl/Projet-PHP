@extends('template')
@section('title') Modifier une activité @endsection
@section('content')

<div class="modal fade" id="supprimerModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-dark" id="supprimerModalLabel">Suppression d'une activité</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-dark">
        Êtes-vous sûr de vouloir supprimer cette activité ?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Annuler</button>
        <button type="button" class="btn btn-outline-danger" onclick="javascript:confirmer('{{url('activite/')}}')">Confirmer</button>
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

<form action="{{url('activite', $activite->id)}}" method="post">
  @csrf
  @method('PUT')
  <div class="mb-3 row">
    <label for="titre" class="col-sm-2 col-form-label">Titre</label>

    <div class="col-sm-10">
      <input type="text" class="form-control" name="titre" id="titre" placeholder="Saisir le titre de l'activité" value="{{$activite->titre}}"/>
    </div>
  </div>

  <div class="mb-3 row">
    <label for="description" class="col-sm-2 col-form-label">Description</label>

    <div class="col-sm-10">
      <textarea class="form-control" id="description" name="description" rows="3" placeholder="Saisir le description de l'activité">{{$activite->description}}</textarea>
    </div>
  </div>

  <div class="mb-3 row">
    <label for="dateDebut" class="col-sm-2 col-form-label">Date de début</label>

    <div class="col-sm-10">
      <input type="datetime-local" class="form-control" name="dateDebut" id="dateDebut" placeholder="Saisir la date de début de l'activité"
             value="{{IntlDateFormatter::formatObject(new DateTime($activite->dateDebut), 'yyyy-MM-dd HH:mm', 'fr') }}"/>
    </div>
  </div>

<div class="mb-3 row">
  <label for="dateFin" class="col-sm-2 col-form-label">Date de fin</label>

  <div class="col-sm-10">
    <input type="datetime-local" class="form-control" name="dateFin" id="dateFin" placeholder="Saisir la date de début de l'activité"
           value="{{IntlDateFormatter::formatObject(new DateTime($activite->dateFin), 'yyyy-MM-dd HH:mm', 'fr') }}"/>
  </div>
</div>

<div class="mb-3 row">
  <label for="association_id" class="col-sm-2 col-form-label">Association</label>

  <div class="col-sm-10">
    <select class="form-control" name="association_id" id="association_id" placeholder="Saisir l'association">
      <?php
        $associations = DB::select('SELECT * FROM associations');
      ?>
      @foreach($associations as $asso)
        <option value="{{$asso->id}}" @if($asso->id === $activite->association_id) selected @endif>{{$asso->nom}}</option>
      @endforeach
    </select>
  </div>
</div>

<div class="mb-3 row">
  <label for="places" class="col-sm-2 col-form-label">Nombre de places</label>

  <div class="col-sm-10">
    <input type="number" class="form-control" name="places" id="places" placeholder="Saisir le nombre de places de l'activité" value="{{$activite->places}}"/>
  </div>
</div>

  <div class="mb-3">
    <div class="offset-sm-2 col-sm-10">
      
      <button type="button" data-bs-toggle="modal" data-bs-target="#supprimerModal" onclick="supprimer({{$activite->id}})" class="btn btn-danger mb-1">
        Supprimer
      </button>  &nbsp; 

      <button class="btn btn-success mb-1 mr-1" type="submit">Enregistrer</button>  &nbsp; 

      <a href="{{ url('activite') }}" class="btn btn-secondary mb-1">Annuler</a>  &nbsp; 

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