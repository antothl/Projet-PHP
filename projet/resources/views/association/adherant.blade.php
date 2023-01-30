@extends('template')
@section('title') Adhérants de l'association @endsection
@section('content')
<?php
  $compteur = $association->user->count();
  ?>

<strong>{{$association->nom}}</strong>,

@if($compteur == 0)
  aucune adhérant.
@elseif($compteur == 1)
  un seule adhérant :
@else
  {{$compteur}} adhérants :
@endif

<br/>
<br/>
<ul>
@foreach($association->user as $adherant)
<li>
  <form method="get" action="{{url('script_desadhesion')}}">

    <a href="{{route('user.show', $adherant->id)}}" class="btn btn-sm btn-info mb-1"><i class="bi bi-eye"></i></a>
    &nbsp; 

    <input type="hidden" name="user_id" value="{{$adherant->id}}"/>
    <input type="hidden" name="association_id" value="{{$association->id}}"/>
    <input type="hidden" name="page" value="3"/>
    <button class="btn btn-sm btn-danger mb-1" type="submit">
      <i class="bi bi-trash"></i>
    </button>

    &nbsp; 
    {{$adherant->prenom}} 
    {{$adherant->nom}}

  </form> 

</li>
@endforeach
</ul>

<br/>
<br/>


<a href="javascript:window.print()" class="btn btn-block btn-outline-success mb-1">Imprimer</a>  &nbsp; 
<a href="{{route('association.show', $association->id)}}" class="btn btn-block btn-light mb-1 text-dark">Retour</a>  &nbsp; 
<a href="{{url('/')}}" class="btn btn-block btn-outline-light mb-1">Accueil</a>
@endsection