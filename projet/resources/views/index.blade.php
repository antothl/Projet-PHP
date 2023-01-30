@extends('template')

@section('title')
Acti'scol
@endsection

@section('content')
<?php
  $dt = date( "Y-m-d H:i:s", time());
?>
@auth
  <h2>Bienvenue {{Auth::user()->prenom}} {{Auth::user()->nom}},
@else
  <h2>Bienvenue,
@endauth

nous sommes le {{ IntlDateFormatter::formatObject(new DateTime($dt), 'EEEE d MMMM Y', 'fr') }}.</h2>
<br/>

<a href="{{ url('activite') }}" class="btn btn-block btn-light mb-2 mr-2">
  Voir les activités
</a>&nbsp; 

<a href="{{ url('association') }}" class="btn btn-block btn-light mb-2 mr-2">
  Voir les associations
</a> <br/><br/>


<h4>Activité à la Une :</h3>
<?php
//header("Refresh:5");
  $aleatoire=DB::table('activites')->inRandomOrder()->first();
  $titre=$aleatoire->titre;
  $description=$aleatoire->description;
  $places=$aleatoire->places;
  ?>
  <div id="activiteUne" class="col-sm-5 mb-3 rounded border border-secondary p-3">

    <a href="{{route('activite.show', $aleatoire->id)}}" style="color: white;">
      <strong id="titre">{{$titre}}</strong>
    </a>&nbsp; ({{$places}} places)
    <br/><br/>

    Du
    <span class="badge rounded-pill bg-secondary">
      {{IntlDateFormatter::formatObject(new DateTime($aleatoire->dateDebut), 'EEEE d MMMM Y', 'fr')}}
       à 
      {{IntlDateFormatter::formatObject(new DateTime($aleatoire->dateDebut), 'H', 'fr')}}
      h
      {{IntlDateFormatter::formatObject(new DateTime($aleatoire->dateDebut), 'm', 'fr')}}
    </span><br/>

    Au
    <span class="badge rounded-pill bg-secondary">
      {{IntlDateFormatter::formatObject(new DateTime($aleatoire->dateFin), 'EEEE d MMMM Y', 'fr')}}
       à 
      {{IntlDateFormatter::formatObject(new DateTime($aleatoire->dateFin), 'H', 'fr')}}
      h
      {{IntlDateFormatter::formatObject(new DateTime($aleatoire->dateFin), 'm', 'fr')}}
    </span>
    <br/><br/>

    <div id="description" style="height: 3em; overflow: hidden;">{{$description}}</div>
  </div> <br/>

@auth
<form id="formLogout" action="{{url('/logout')}}" method="POST">
  @csrf
</form>

<a href="{{ url('compte') }}" class="btn btn-block btn-secondary bg-secondary bg-gradient text-white mb-2 mr-2">
  Votre compte
</a> &nbsp; 

<button type="submit" form="formLogout" class="btn btn-block btn-danger bg-danger bg-gradient text-white mb-2 mr-2">
  Se déconnecter
</button> &nbsp; 

<a href="{{ url('commune') }}" class="btn btn-block btn-dark bg-dark bg-gradient text-white mb-2 mr-2">
  Informations sur la commune
</a>
<br/>

@if (Auth::user()->statut >= 2)
<br/>
<h4>Gestion :</h3>
<a href="{{ url('/user') }}" class="btn btn-block btn btn-outline-light mb-2 mr-2">
  Liste des Utilisateurs
</a>&nbsp; 

<a href="{{ url('/enfant') }}" class="btn btn-block btn-outline-light mb-2 mr-2">
  Liste des enfants
</a>
@endif

@else
  <a href="{{ url('/login') }}" class="btn btn-block btn-outline-light mb-2 mr-2">
    Se connecter
  </a> &nbsp; 

  <a href="{{ url('/register') }}" class="btn btn-block btn-outline-light mb-2 mr-2">
    Créer un compte
  </a> &nbsp; 

  <a href="{{ url('commune') }}" class="btn btn-block btn-dark bg-dark bg-gradient text-white mb-2 mr-2">
    Informations sur la commune
  </a>
@endauth

@endsection
