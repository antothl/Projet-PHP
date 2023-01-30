@extends('template')
@section('title') Enfants inscrits @endsection
@section('content')
<?php
  $compteur = $activite->enfants->count();
  ?>

<strong>{{$activite->titre}}</strong>, 

@if($compteur==$activite->places)
toutes les places sont reservées.
@elseif($compteur==0)
aucun enfant n'est inscrit.
@else
il reste {{$activite->places - $compteur}} places sur {{$activite->places}}. 
@endif

<br/>
<br/>
<ul>
@foreach($activite->enfants as $enfant)
<li>
  <form method="get" action="{{url('script_desinscription')}}">

    <a href="{{route('enfant.show', $enfant->id)}}" class="btn btn-sm btn-info mb-1"><i class="bi bi-eye"></i></a>
    &nbsp; 

    <input type="hidden" name="enfant_id" value="{{$enfant->id}}"/>
    <input type="hidden" name="activite_id" value="{{$activite->id}}"/>
    <input type="hidden" name="page" value="1"/>
    <button class="btn btn-sm btn-danger mb-1" type="submit">
      <i class="bi bi-trash"></i>
    </button>

    &nbsp; 
    {{$enfant->prenom}} 
    {{$enfant->nom}}

  </form> 

</li>
@endforeach
</ul>

<br/>
<br/>


<a href="javascript:window.print()" class="btn btn-block btn-outline-success mb-1">Imprimer</a>  &nbsp; 
<a href="{{route('activite.show', $activite->id)}}" class="btn btn-block btn-light mb-1 text-dark">Retour</a>  &nbsp; 
<a href="{{url('/')}}" class="btn btn-block btn-outline-light mb-1">Accueil</a>
@endsection