@extends('template')
@section('title') Création d'une activité @endsection
@section('content')
@if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<form action="{{url('activite')}}" method="post"> @csrf

  <div class="mb-3 row">
    <label for="titre" class="col-sm-2 col-form-label">Titre</label>

    <div class="col-sm-10">
      <input value="{{ old('titre') }}" type="text" class="form-control @error('titre') is-invalid @enderror" name="titre" id="titre" placeholder="Saisir le titre de l'activité"/>
    </div>
  </div>

  <div class="mb-3 row">
    <label for="description" class="col-sm-2 col-form-label">Description</label>

    <div class="col-sm-10">
      <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3" placeholder="Saisir la description de l'activité">{{ old('description') }}</textarea>
    </div>
  </div>

  <div class="mb-3 row">
    <label for="dateDebut" class="col-sm-2 col-form-label">Date de début</label>

    <div class="col-sm-10">
      <input value="{{ old('dateDebut') }}" type="datetime-local" class="form-control @error('dateDebut') is-invalid @enderror" name="dateDebut" id="dateDebut" placeholder="Saisir la date de début l'activité"/>
    </div>
  </div>

  <div class="mb-3 row">
    <label for="dateFin" class="col-sm-2 col-form-label">Date de fin</label>

    <div class="col-sm-10">
      <input value="{{ old('dateFin') }}" type="datetime-local" class="form-control @error('dateFin') is-invalid @enderror" name="dateFin" id="dateFin" placeholder="Saisir la date de fin de l'activité"/>
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
        <option value="{{$asso->id}}">{{$asso->nom}}</option>
      @endforeach
    </select>
  </div>
  </div>

  <div class="mb-3 row">
    <label for="places" class="col-sm-2 col-form-label">Nombre de places</label>

    <div class="col-sm-10">
      <input value="{{ old('places') }}" type="number" class="form-control @error('places') is-invalid @enderror" name="places" id="places" min="1" max="999" placeholder="Saisir le nombre de places l'activité"/>
    </div>
  </div>

  
  <div class="mb-3">
    <div class="offset-sm-2 col-sm-10">
    <button class="btn btn-success mb-1 mr-1" type="submit">Ajouter</button> &nbsp;

    <a href="{{url('activite')}}" class="btn btn-danger mb-1">Annuler</a>
  </div>

</form>
@endsection