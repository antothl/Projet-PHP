@extends('template')

@section('title') Affichage d'un enfant @endsection

@section('content')

    Nom : <strong>{{$enfant->nom}}</strong>

<br/>
<br/>

    Prénom : <strong>{{$enfant->prenom}}</strong>

<br/>
<br/>

    Date de naissance :
    <i>{{ IntlDateFormatter::formatObject(new DateTime($enfant->birth), 'EEEE d MMMM Y', 'fr') }}</i>
    à <i>{{ IntlDateFormatter::formatObject(new DateTime($enfant->birth), 'H', 'fr') }}</i>h 
    <i>{{ IntlDateFormatter::formatObject(new DateTime($enfant->birth), 'm', 'fr') }}</i>

<br/>
<br/>

    Parent :
    <a href="{{route('user.show', $enfant->user->id)}}" class="badge rounded-pill bg-secondary" style="text-decoration: none;">
        {{$enfant->user->prenom}} {{$enfant->user->nom}}
    </a>

<br/>
<br/>

<a href="{{route('enfant.inscrit', $enfant->id)}}" class="btn btn-block btn-warning mb-1">Voir ses inscriptions</a>  &nbsp; 
<a href="{{url('enfant/')}}" class="btn btn-block btn-secondary mb-1">Retour</a>  &nbsp; 
<a href="{{url('/')}}" class="btn btn-block btn-outline-light mb-1">Accueil</a>  &nbsp; 
          <a href="javascript:history.go(-1)" class="btn btn-block btn-outline-light mb-1" style="float: right;">Page précédente</a>

@endsection