@extends('template')
@section('title') Ajout d'une association @endsection
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
<form action="{{url('association')}}" method="post"> @csrf

  <div class="mb-3 row">
    <label for="nom" class="col-sm-2 col-form-label">Nom</label>

    <div class="col-sm-10">
      <input value="{{ old('nom') }}" type="text" class="form-control @error('nom') is-invalid @enderror" name="nom" id="nom" placeholder="Saisir le nom de l'association"/>
    </div>
  </div>
 
 

  
  <div class="mb-3">
    <div class="offset-sm-2 col-sm-10">
    <button class="btn btn-success mb-1 mr-1" type="submit">Ajouter</button> &nbsp;

    <a href="{{url('association')}}" class="btn btn-danger mb-1">Annuler</a>
  </div>

</form>
@endsection