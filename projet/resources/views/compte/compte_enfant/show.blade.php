@extends('template')

@section('title') Affichage d'un enfant @endsection

@section('content')

    Nom : <strong>{{$compte_enfant->nom}}</strong>

<br/>
<br/>

    Prénom : <strong>{{$compte_enfant->prenom}}</strong>

<br/>
<br/>

    Date de naissance :
    <i>{{ IntlDateFormatter::formatObject(new DateTime($compte_enfant->birth), 'EEEE d MMMM Y', 'fr') }}</i>
    à <i>{{ IntlDateFormatter::formatObject(new DateTime($compte_enfant->birth), 'H', 'fr') }}</i>h 
    <i>{{ IntlDateFormatter::formatObject(new DateTime($compte_enfant->birth), 'm', 'fr') }}</i>

<br/>
<br/>

<a href="{{route('compte/compte_enfant.inscrit', $compte_enfant->id)}}" class="btn btn-block btn-warning mb-1 text-dark">Voir ses inscriptions</a>  &nbsp; 
<a href="{{url('compte/compte_enfant')}}" class="btn btn-block btn-light mb-1 text-dark">Retour à la liste</a>  &nbsp; 
<a href="{{url('/')}}" class="btn btn-block btn-outline-light mb-1">Accueil</a>

@endsection