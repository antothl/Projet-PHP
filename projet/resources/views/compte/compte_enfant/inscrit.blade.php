@extends('template')
@section('title') Inscriptions de l'enfant @endsection
@section('content')
<?php
  date_default_timezone_set('Europe/Paris');
  $ajd = date( "Y-m-d H:i:s", time());
  $dt = date( "Y-m-d H:i:s", strtotime("+7 day", time()));
  $compteur=0;
  ?>
  
@foreach($compte_enfant->activite as $activite)
  @if($activite->dateDebut > $ajd)
    <?php
      $compteur++;
    ?>
  @endif
@endforeach

<strong>{{$compte_enfant->nom}} {{$compte_enfant->prenom}}</strong>, 

@if($compteur == 1)
est inscrit à une seule activité.
@elseif($compteur==0)
n'est inscrit à aucune activité.
@else
est inscrit à {{$compteur}} activités.
@endif

<br/>
<br/>
<ul>
@foreach($compte_enfant->activite as $activite)
  @if($activite->dateDebut > $ajd)
    <li>

    <form method="get" action="{{url('script_desinscription')}}">

    <a href="{{route('activite.show', $activite->id)}}" class="btn btn-sm btn-info mb-1"><i class="bi bi-eye"></i></a>
    &nbsp; 

    <input type="hidden" name="enfant_id" value="{{$compte_enfant->id}}"/>
    <input type="hidden" name="activite_id" value="{{$activite->id}}"/>
    <input type="hidden" name="page" value="3"/>
    <button class="btn btn-sm btn-danger mb-1" type="submit">
      <i class="bi bi-trash"></i>
    </button>

    &nbsp; 
      {{$activite->titre}}

    </form> 

    </li>
    @endif
@endforeach
</ul>

<br/>
<br/>


<a href="javascript:window.print()" class="btn btn-block btn-outline-success mb-1">Imprimer</a>  &nbsp; 
<a href="{{route('compte_enfant.show', $compte_enfant->id)}}" class="btn btn-block btn-light mb-1 text-dark">Retour</a>  &nbsp; 
<a href="{{url('/')}}" class="btn btn-block btn-outline-light mb-1">Accueil</a>
@endsection