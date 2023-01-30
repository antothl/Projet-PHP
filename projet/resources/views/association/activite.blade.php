@extends('template')
@section('title') Activités de l'association @endsection
@section('content')
<?php
  $compteur = $association->activite->count();
  ?>

<strong>{{$association->nom}}</strong>,

@if($compteur == 0)
  aucune activité.
@elseif($compteur == 1)
  une seule activité :
@else
  {{$compteur}} activités :
@endif

<br/>
<br/>
<ul>
@foreach($association->activite as $activite)
<li>

  <a href="{{route('activite.show', $activite->id)}}" class="btn btn-sm btn-info mb-1"><i class="bi bi-eye"></i></a>
  &nbsp; 

  &nbsp; 
  {{$activite->titre}}

</li>
@endforeach
</ul>

<br/>
<br/>


<a href="javascript:window.print()" class="btn btn-block btn-outline-success mb-1">Imprimer</a>  &nbsp; 
<a href="{{route('association.show', $association->id)}}" class="btn btn-block btn-light mb-1 text-dark">Retour</a>  &nbsp; 
<a href="{{url('/')}}" class="btn btn-block btn-outline-light mb-1">Accueil</a>
@endsection