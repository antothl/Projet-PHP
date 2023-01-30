@extends('template')
@section('title') Enfants de l'utilisateur @endsection
@section('content')
<?php
  $compteur = $user->enfant->count();
  ?>

<strong>{{$user->nom}} {{$user->prenom}}</strong>, 

@if($compteur == 1)
a un seul enfant.
@elseif($compteur==0)
n'a aucun enfant.
@else
a {{$compteur}} enfants.
@endif

<br/>
<br/>
<ul>
    <form id="deleteForm" action="" method="POST">
      @method('DELETE')
      @csrf
    </form>
@foreach($user->enfant as $enfant)
<li>
  <a href="{{route('enfant.show', $enfant->id)}}" class="btn btn-sm btn-info mb-1"><i class="bi bi-eye"></i></a>
  &nbsp; 

  @if(Auth::user()->statut >2)
    <!--Supprimer-->
    <button type="submit" formaction="{{route('enfant.destroy', $enfant->id)}}" form="deleteForm" class="btn btn-sm btn-danger mb-1">
      <i class="bi bi-trash"></i>
    </button>
  @endif

  &nbsp; 
  {{$enfant->nom}} 
  {{$enfant->prenom}}
</li>
@endforeach
</ul>
   

<br/>
<br/>


<a href="javascript:window.print()" class="btn btn-block btn-outline-success mb-1">Imprimer</a>  &nbsp; 
<a href="{{route('user.show', $user->id)}}" class="btn btn-block btn-light mb-1 text-dark">Retour</a>  &nbsp; 
<a href="{{url('/')}}" class="btn btn-block btn-outline-light mb-1">Accueil</a>
@endsection