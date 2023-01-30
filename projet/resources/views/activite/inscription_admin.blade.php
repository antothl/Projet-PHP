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
          $lesEnfants = DB::select("SELECT * FROM enfants ORDER BY `user_id` ASC");
          $premierEnfant = current($lesEnfants);
          
        ?>

        @if(empty($lesEnfants))
          <option disable>Il n'y a pas d'enfant d'enregistré</option>
        @else
          @foreach($lesEnfants as $enfant)

            @if(DB::table('activite_enfant')->where('activite_id', $activite->id)->where('enfant_id', $enfant->id)->count() == 0)
                
              <?php
                $user = DB::select("SELECT * FROM users WHERE `id`=$enfant->user_id");
                $parent=current($user);
              ?>

              
              @if(DB::table('association_user')->where('user_id', $parent->id)->where('association_id', $activite->association_id)->count() == 1)
                
                @if($premierEnfant == current($lesEnfants))
                  <option disabled><strong>Parent :  {{$parent->prenom}} {{$parent->nom}} (id : {{$parent->id}})</strong></option>

                  <option value="{{$enfant->id}}"> &nbsp;  &nbsp; - {{$enfant->prenom}} {{$enfant->nom}} (id : {{$enfant->id}})</option>
                  <?php $compteur++; $premierEnfant=$enfant;  ?>
                @else

                  @if($premierEnfant->user_id == $enfant->user_id)
                    <option value="{{$enfant->id}}"> &nbsp;  &nbsp; - {{$enfant->prenom}} {{$enfant->nom}} (id : {{$enfant->id}})</option>
                    <?php $compteur++; ?>
                  @else
                    <option disabled><strong>Parent :  {{$parent->prenom}} {{$parent->nom}} (id : {{$parent->id}})</strong></option>

                    <option value="{{$enfant->id}}"> &nbsp;  &nbsp; - {{$enfant->prenom}} {{$enfant->nom}} (id : {{$enfant->id}})</option>
                    <?php $compteur++; $premierEnfant=$enfant;  ?>
                  @endif

                @endif

              @endif

            @endif
                    
          @endforeach

          @if($compteur==0)
            <option disable>Tous les enfants sont déjà inscrit à cette activité</option>
          @endif


        @endif
        </select>
      </div>
  </div>

  <input value="{{$activite->id}}" type="hidden" name="activite_id" id="activite_id"/>
  


  
  <div class="mb-3">
    <div class="offset-sm-2 col-sm-10">

      @if($compteur != 0)
        <button class="btn btn-success mb-1 mr-1" type="submit">Inscrire</button> &nbsp; 
      @endif

    <a href="{{route('enfant.index')}}" class="btn btn-block btn-secondary mb-1">
      Voir les enfants
    </a> &nbsp;

    <a href="{{ url('activite') }}" class="btn btn-danger mb-1">Annuler</a>
  </div>

</form>
@endsection