@extends('template')
@section('title') Ajout d'un enfant @endsection
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
<form action="{{url('enfant')}}" method="post"> @csrf

  <div class="mb-3 row">
    <label for="nom" class="col-sm-2 col-form-label">Nom</label>

    <div class="col-sm-10">
      <input value="{{ old('nom') }}" type="text" class="form-control @error('nom') is-invalid @enderror" name="nom" id="nom" placeholder="Saisir le nom de l'enfant"/>
    </div>
  </div>
  <div class="mb-3 row">
    <label for="prenom" class="col-sm-2 col-form-label">Prénom</label>

    <div class="col-sm-10">
      <input value="{{ old('prenom') }}" type="text" class="form-control @error('prenom') is-invalid @enderror" name="prenom" id="prenom" placeholder="Saisir le prénom de l'enfant"/>
    </div>
  </div>

 

  <div class="mb-3 row">
    <label for="birth" class="col-sm-2 col-form-label">Date de naissance</label>

    <div class="col-sm-10">
      <input value="{{ old('birth') }}" type="date" class="form-control @error('birth') is-invalid @enderror" name="birth" id="birth" placeholder="Saisir la date de naissance de l'enfant"/>
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
          <option value="{{$parent->id}}">{{$parent->prenom}} {{$parent->nom}}</option>
        @endforeach
      </select>
    </div>
</div>

  
  <div class="mb-3">
    <div class="offset-sm-2 col-sm-10">
    <button class="btn btn-success mb-1 mr-1" type="submit">Ajouter</button> &nbsp;

    <a href="{{url('enfant')}}" class="btn btn-danger mb-1">Annuler</a>
  </div>

</form>
@endsection