@extends('template')
@section('title') Affichage d'un utilsateur @endsection
@section('content')
<strong>{{$user->pseudonyme}}</strong>
<br/>
<br/>
Email : {{$user->email}}
<br/>
<br/>
Prénom : {{$user->prenom}}
<br/>
Nom : {{$user->nom}}
<br/>
<br/>
<i>Statut ({{$user->statut}}) :
    @if($user->statut === 1)
        Utilisateur
    @elseif($user->statut === 2)
        Gestionnaire
    @else
        Administrateur
    @endif
</i>
<br/>
<br/>
<a href="{{route('user.enfant', $user->id)}}" class="btn btn-block btn-warning mb-1 text-dark">Voir ses enfants</a>  &nbsp; 
<a href="{{url('user/')}}" class="btn btn-block btn-light mb-1 text-dark">Retour à la liste</a>  &nbsp; 
<a href="{{url('/')}}" class="btn btn-block btn-outline-light mb-1">Accueil</a>
          <a href="javascript:history.go(-1)" class="btn btn-block btn-outline-light mb-1" style="float: right;">Page précédente</a>
@endsection