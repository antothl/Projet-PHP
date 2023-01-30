@extends('template')

@section('title') Affichage d'une association @endsection

@section('content')

    Nom : <strong>{{$association->nom}}</strong>

<br/>
<br/>

@auth
    <?php
        $adhesions = $association->user->pluck('id');
        $adherer = 0;
    ?>

    @foreach($adhesions as $verif)
        @if(Auth::user()->id == $verif)
            <?php
            $adherer=1;
            ?>
        @endif
    @endforeach

    @if($adherer == 1)
    <form method="get" action="{{url('script_desadhesion')}}">

        <input type="hidden" name="association_id" value="{{$association->id}}"/>
        <input type="hidden" name="user_id" value="{{Auth::user()->id}}"/>
        <input type="hidden" name="page" value="1"/>
        <button class="btn btn-block btn-danger mb-1" type="submit">
            Desadhérer
        </button>&nbsp; 

        <a href="{{route('association.activite', $association->id)}}" class="btn btn-block btn-info mb-1 text-dark">Voir les activités correspondantes</a>&nbsp;

        @if(Auth::user()->statut >= 2)
            <br/> <br/> <a href="{{route('association.adherant', $association->id)}}" class="btn btn-block btn-warning mb-1 text-dark">Voir les adhérants</a>&nbsp; 
            <a href="{{route('association.edit', $association->id)}}" class="btn btn-block btn-outline-warning mb-1">Modifier l'association</a>&nbsp; 
        @endif <br/><br/>
        <a href="{{route('association.index')}}" class="btn btn-block btn-secondary mb-1">Retour</a>&nbsp; 
        <a href="{{url('/')}}" class="btn btn-block btn-outline-light mb-1">Accueil</a>
        <a href="javascript:history.go(-1)" class="btn btn-block btn-outline-light mb-1" style="float: right;">Page précédente</a>

    </form> 

    @else
    <form method="get" action="{{url('script_adhesion')}}">

        <input type="hidden" name="association_id" value="{{$association->id}}"/>
        <input type="hidden" name="user_id" value="{{Auth::user()->id}}"/>
        <input type="hidden" name="page" value="1"/>
        <button class="btn btn-block btn-success mb-1" type="submit">
            Adhérer
        </button>&nbsp;

        <a href="{{route('association.activite', $association->id)}}" class="btn btn-block btn-info mb-1 text-dark">Voir les activités correspondantes</a>&nbsp;

        @if(Auth::user()->statut >= 2)
            <br/><br/><a href="{{route('association.adherant', $association->id)}}" class="btn btn-block btn-warning mb-1 text-dark">Voir les adhérants</a>&nbsp; 
            <a href="{{route('association.edit', $association->id)}}" class="btn btn-block btn-outline-warning mb-1">Modifier l'association</a>&nbsp; 
        @endif <br/><br/>
        <a href="{{route('association.index')}}" class="btn btn-block btn-secondary mb-1">Retour</a>&nbsp; 
        <a href="{{url('/')}}" class="btn btn-block btn-outline-light mb-1">Accueil</a>
        <a href="javascript:history.go(-1)" class="btn btn-block btn-outline-light mb-1" style="float: right;">Page précédente</a>

    </form> 
    @endif

@else
    <a href="{{route('association.activite', $association->id)}}" class="btn btn-block btn-info mb-1 text-dark">Voir les activités correspondantes</a>&nbsp; 
    <a href="{{route('association.index')}}" class="btn btn-block btn-secondary mb-1">Retour</a>&nbsp; 
    <a href="{{url('/')}}" class="btn btn-block btn-outline-light mb-1">Accueil</a>
    <a href="javascript:history.go(-1)" class="btn btn-block btn-outline-light mb-1" style="float: right;">Page précédente</a>
@endauth

@endsection