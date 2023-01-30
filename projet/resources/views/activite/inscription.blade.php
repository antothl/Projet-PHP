@extends('template')
@section('title') Inscrire un enfant @endsection
@section('content')
  <h2>
    {{$activite->titre}}
  </h2>
</br>
@if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<form action="{{url('script_inscription')}}" method="get"> @csrf

  <div class="mb-3 row">
      <label for="enfant_id" class="col-sm-2 col-form-label">Enfant : </label>
      
      <div class="col-sm-10">
        <select class="form-control" name="enfant_id" id="enfant_id" placeholder="Saisir l'enfant">
        <?php
          $compteur = 0;
          $IdParent = Auth::user()->id;
          $vosEnfants = DB::select("SELECT * FROM enfants WHERE user_id='$IdParent'");
        ?>

        @if(empty($vosEnfants))
          <option disable>Vous n'avez pas enregistré d'enfant</option>
        @else
          @foreach($vosEnfants as $enfant)

            @if(DB::table('activite_enfant')->where('activite_id', $activite->id)->where('enfant_id', $enfant->id)->count() == 0)
              <option value="{{$enfant->id}}">{{$enfant->prenom}} {{$enfant->nom}}</option>
              <?php $compteur++; ?>
            @endif
                    
          @endforeach

          @if($compteur==0)
            <option disable>Tous vos enfants sont déjà inscrit à cette activité</option>
          @endif


        @endif
        </select>
      </div>
  </div>

  <input value="{{$activite->id}}" type="hidden" name="activite_id" id="activite_id"/>
  


  
  <div class="mb-3">
    <div class="offset-sm-2 col-sm-10">
      
    @if(empty($vosEnfants))
    <a href="{{route('compte_enfant.create')}}" class="btn btn-block btn-success mb-1">
      Ajouter un enfant
    </a> &nbsp; 
    @else

      @if($compteur != 0)
      <button class="btn btn-success mb-1 mr-1" type="submit">Inscrire</button> &nbsp; 
      @endif

    <a href="{{route('compte_enfant.index')}}" class="btn btn-block btn-secondary mb-1">
      Voir vos enfants
    </a> &nbsp; 
    @endif

    <a href="{{ url('activite') }}" class="btn btn-danger mb-1">Annuler</a>
  </div>

</form>
@endsection