@extends('template')

@section('title')
Compte : {{Auth::user()->pseudonyme}} 
@endsection

@section('content')
<h2>Vos informations</h2>
<p>
<br/>
Pseudonyme : {{Auth::user()->pseudonyme}} 
<br/>
<br/>
Prénom : {{Auth::user()->prenom}} 
<br/>
<br/>
Nom : {{Auth::user()->nom}}
<br/>
<br/>
Adresse mail : {{Auth::user()->email}}
<br/>
<br/>
Statut : 
  @if (Auth::user()->statut === 1)
    Utilisateur
  @elseif (Auth::user()->statut === 2)
    Gestionnaire
  @else
    Administrateur
  @endif
</p>

<br/>
<a href="{{ url('compte/compte_enfant') }}" class="btn btn-block btn-light mb-2 mr-2">
  Voir vos enfants
</a> &nbsp; 

<a href="javascript:history.go(-1)" class="btn btn-block btn-secondary mb-2 mr-2">
  Retour
</a>

@endsection
