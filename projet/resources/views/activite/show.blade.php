@extends('template')
@section('title') Affichage d'une activité @endsection
@section('content')
<?php
  date_default_timezone_set('Europe/Paris');
  $ajd = date( "Y-m-d H:i:s", time());
  $dt = date( "Y-m-d H:i:s", strtotime("+7 day", time()));
?>
<strong>{{$activite->titre}}</strong>
<br/>
<br/>

Début : <i>{{ IntlDateFormatter::formatObject(new DateTime($activite->dateDebut), 'EEEE d MMMM Y', 'fr') }}</i>
à <i>{{ IntlDateFormatter::formatObject(new DateTime($activite->dateDebut), 'H', 'fr') }}</i>h 
<i>{{ IntlDateFormatter::formatObject(new DateTime($activite->dateDebut), 'm', 'fr') }}</i>.
<br/>

Fin : <i>{{ IntlDateFormatter::formatObject(new DateTime($activite->dateFin), 'EEEE d MMMM Y', 'fr') }}</i>
à <i>{{ IntlDateFormatter::formatObject(new DateTime($activite->dateFin), 'H', 'fr') }}</i>h 
<i>{{ IntlDateFormatter::formatObject(new DateTime($activite->dateFin), 'm', 'fr') }}</i>.
<br/>
<br/>

Places : {{$activite->places}}.
<br/>
<br/>

<?php
  $compteur=$activite->enfants->count();
  ?>
Inscrits : {{$compteur}}.
<br/>
<br/>

Association : 
<a href="{{route('association.show', $activite->association_id)}}" class="badge rounded-pill bg-secondary" style="text-decoration: none;">
  {{$activite->association->nom}}
</a>
<br/>
<br/>

{{$activite->description}}
<br/>
<br/>
@auth
  @if (Auth::user()->statut > 1)
    <a href="{{route('activite.inscrit', $activite->id)}}" class="btn btn-block btn-warning mb-1">Voir les enfants inscrits</a>  &nbsp; 
    <a href="{{route('activite.edit',$activite->id)}}" class="btn btn-block btn-outline-warning mb-1">Modifier l'activité</i></a>
  @else
    &nbsp; 
  @endif

  @if($activite->dateDebut > $dt)
    <?php
      $adhere = 0;
    ?>
    @foreach($activite->association->user as $user)
      @if($user->id == Auth::user()->id)
        <?php
          $adhere = 1
        ?>
      @endif
    @endforeach

    @if($activite->places <= $activite->enfants->count())
      <br/><br/>
      <p class="btn btn-block btn-secondary mb-1 disabled">Aucune place restante</p>
    @elseif($adhere == 1)
      @if(Auth::user()->statut>2)
        &nbsp; <a href="{{route('activite.inscription_admin', $activite->id)}}" class="btn btn-block btn-outline-danger mb-1">Inscrire un enfant (admin)</a>
      @endif
      <br/><br/>
      <a href="{{route('activite.inscription', $activite->id)}}" class="btn btn-block btn-success mb-1">Inscrire un de vos enfants</a>
    @else
      @if(Auth::user()->statut>2)
        &nbsp; <a href="{{route('activite.inscription_admin', $activite->id)}}" class="btn btn-block btn-outline-danger mb-1">Inscrire un enfant (admin)</a>
      @endif
      <br/><br/>
      <p class="btn btn-block btn-secondary mb-1 disabled">Vous n'adhérez pas</p>
    @endif
  @else
    <br/><br/>
    <p class="btn btn-block btn-secondary mb-1 disabled">Inscriptions fermées</p>
  @endif

&nbsp; 
@endauth
<a href="{{ url('activite') }}" class="btn btn-block btn-secondary mb-1">Retour</a>  &nbsp; 
<a href="{{url('/')}}" class="btn btn-block btn-outline-light mb-1">Accueil</a>
<a href="javascript:history.go(-1)" class="btn btn-block btn-outline-light mb-1" style="float: right;">Page précédente</a>
@endsection