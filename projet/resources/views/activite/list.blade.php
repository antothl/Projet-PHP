@extends('template')
@section('title') Les activités @endsection
@section('content')
<?php
  //Initialisation des dates
  date_default_timezone_set('Europe/Paris');
  $ajd = date( "Y-m-d H:i:s", time());
  $dt = date( "Y-m-d H:i:s", strtotime("+7 day", time()));
?>

<!-- Confirmation de suppression -->
<div class="modal fade" id="supprimerModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-dark" id="supprimerModalLabel">Suppression d'une activité</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-dark">
        Êtes-vous sûr de vouloir supprimer cette activité ?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Annuler</button>
        <button type="button" class="btn btn-outline-danger" onclick="javascript:confirmer('{{url('activite/')}}')">Confirmer</button>
      </div>
    </div>
  </div>
</div>

<!-- Sélection des activités -->
<?php
  $choix = 1;
  $assoc = 1;
  if($_GET) {
    $choix = $_GET['selection'];
    if($choix == 5) {
      $assoc = $_GET['association'];
    }
  }
?>

<form action="" method="get">
  <div class="mb-3 row">
    <label for="selection" class="col-sm-2 col-form-label">Sélection :</label>

    <div class="col-sm-10">
      <select onchange="this.form.submit()" class="form-control" name="selection" id="selection" style="color: #FFF; background-color:  rgba(var(--bs-dark-rgb),var(--bs-bg-opacity));">
          <option value="1" @if($choix == 1) selected @endif>Toutes les prochaines activités</option>
          <option value="2" @if($choix == 2) selected @endif>Toutes les prochaines activités encore disponibles</option>
          @auth
            <option value="3" @if($choix == 3) selected @endif>Toutes les prochaines activités auxquelles j'adhère</option>
            <option value="4" @if($choix == 4) selected @endif>Toutes les prochaines activités encore disponibles auxquelles j'adhère</option>
          @endauth
          <option value="5" @if($choix == 5) selected @endif>Toutes les prochaines activités d'une association</option>
        </select>
        <input type="hidden" id="association" name="association" value="1">
      </div>
  </div>
</form>

@if($choix == 5)
  <form action="" method="get">
    <div class="mb-3 row">
      <label for="association" class="col-sm-2 col-form-label">Association :</label>

      <div class="col-sm-10">
        <select onchange="this.form.submit()" class="form-control" name="association" id="association"  style="color: #FFF; background-color:  rgba(var(--bs-dark-rgb),var(--bs-bg-opacity));">
          <?php
            $associations = DB::select('SELECT * FROM associations');
          ?>
          @foreach($associations as $asso)
            <option value="{{$asso->id}}" @if($assoc == $asso->id) selected @endif>{{$asso->nom}}</option>
          @endforeach
        </select>
        <input type="hidden" id="selection" name="selection" value="5">
      </div>
    </div>
  </form>
@endif

<hr/>
<br/>

<!-- Liste des activités -->
 <table class="table table-striped-white text-white" id='listeActivite' style="border-color: white;">
  <thead style="border-color: white;">
    <tr>
      <th scope="col">Titre</th>
      <th scope="col">Places restantes</th>
      <th scope="col">Date de début</th>
      <th scope="col">Date de fin</th>
      <th scope="col">Association</th>
      <th scope="col">Description</th>
      @auth
        @switch(Auth::user()->statut)
          @case(1)
            <th scope="col" style="text-align : right;">Actions  &nbsp;</th>
            @break;
          @case(2)
            <th scope="col" style="text-align : right;">Actions  &nbsp;  </th>
            @break;
          @default
            <th scope="col" style="text-align : right;">Actions  &nbsp; &nbsp;  &nbsp; </th>
            @break;
        @endswitch
      @else
        <th scope="col" style="text-align : right;">Actions</th>
      @endauth
      </tr>
  </thead>
  <tbody>

  @switch($choix)
    @case(1)
      <!-- Choix 1 : Toutes les prochaines activités -->
      <!-- Date de début postérieure à la date actuelle -->
      @foreach($activiteList as $activite)
        @if($activite->dateDebut > $ajd)
        <tr>
          
          <td data-sort="{{$activite->titre}}">
              <strong>{{$activite->titre}}</strong>
          </td>
          
          <td data-sort="{{$activite->places}}">
            @if($activite->dateDebut < $dt)
              Inscriptions<br/>fermées
            @elseif($activite->places <= $activite->enfants->count())
              Aucune
            @else
              {{$activite->places - $activite->enfants->count()}} / {{$activite->places}}
            @endif
          </td>

          <td data-sort="{{$activite->dateDebut}}">
            {{ IntlDateFormatter::formatObject(new DateTime($activite->dateDebut), 'd MMMM', 'fr') }}
            <br/>
            {{ IntlDateFormatter::formatObject(new DateTime($activite->dateDebut), 'Y', 'fr') }}
            à {{ IntlDateFormatter::formatObject(new DateTime($activite->dateDebut), 'H', 'fr') }}h 
            {{ IntlDateFormatter::formatObject(new DateTime($activite->dateDebut), 'm', 'fr') }}
          </td>

          <td data-sort="{{$activite->dateFin}}">
            {{ IntlDateFormatter::formatObject(new DateTime($activite->dateFin), 'd MMMM', 'fr') }}
            <br/>
            {{ IntlDateFormatter::formatObject(new DateTime($activite->dateFin), 'Y', 'fr') }}
            à {{ IntlDateFormatter::formatObject(new DateTime($activite->dateFin), 'H', 'fr') }}h 
            {{ IntlDateFormatter::formatObject(new DateTime($activite->dateFin), 'm', 'fr') }}
          </td>

          <td data-sort="{{$activite->association->nom}}">
            {{$activite->association->nom}}
          </td>

          <td data-sort="{{$activite->description}}">
            @if(strlen($activite->description) > 35)
              {{substr($activite->description, 0, 35)}}...
            @else
              {{$activite->description}}
            @endif
          </td>

          <td style="text-align : right;">
              <a href="{{route('activite.show', $activite->id)}}" class="btn btn-sm btn-info mb-1"><i class="bi bi-eye"></i></a>
            @auth

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

                @if($adhere == 1)
                  @if($activite->places <= $activite->enfants->count())
                    <p class="btn btn-sm btn-secondary mb-1 disabled"><i class="bi bi-box-arrow-in-right"></i></p>
                  @else
                    <a href="{{route('activite.inscription', $activite->id)}}" class="btn btn-sm btn-success mb-1"><i class="bi bi-box-arrow-in-right"></i></a>
                  @endif
                @else
                  <p class="btn btn-sm btn-secondary mb-1 disabled"><i class="bi bi-box-arrow-in-right"></i></p>
                @endif
              @else
                <p class="btn btn-sm btn-secondary mb-1 disabled"><i class="bi bi-box-arrow-in-right"></i></p>
              @endif

              @if (Auth::user()->statut > 1)
                @if (Auth::user()->statut > 2)
                  &nbsp;  &nbsp; 
                @endif
              <br/>

              <a href="{{route('activite.edit',$activite->id)}}" class="btn btn-sm btn-warning mb-1"><i class="bi bi-pencil-square"></i></a>
              
              <button type="button" data-bs-toggle="modal" data-bs-target="#supprimerModal" onclick="supprimer({{$activite->id}})" class="btn btn-sm btn-danger mb-1">
                <i class="bi bi-trash"></i>
              </button>

              @if (Auth::user()->statut > 2)

                @if($activite->dateDebut > $dt)

                  @if($activite->places > $activite->enfants->count())
                    <a href="{{route('activite.inscription_admin', $activite->id)}}" class="btn btn-sm btn-light mb-1"><i class="bi bi-clipboard-plus"></i></a>
                  @else
                    <p class="btn btn-sm btn-secondary mb-1 disabled"><i class="bi bi-clipboard-plus"></i></p>
                  @endif

                @else
                  <p class="btn btn-sm btn-secondary mb-1 disabled"><i class="bi bi-clipboard-plus"></i></p>
                @endif
              
              @endif

            @endif
            @endauth
          </td>
        </tr>
        @endif
    @endforeach
    @break;
  
    @case(2)
      <!-- Choix 2 : Toutes les prochaines activités encore disponibles -->
      <!-- Dans plus d'une semaine, et il reste au moins 1 place -->
      @foreach($activiteList as $activite)
        @if($activite->dateDebut > $dt && $activite->places > $activite->enfants->count())
        <tr>
          
          <td data-sort="{{$activite->titre}}">
              <strong>{{$activite->titre}}</strong>
          </td>
          
          <td data-sort="{{$activite->places}}">
            {{$activite->places - $activite->enfants->count()}} / {{$activite->places}}
          </td>

          <td data-sort="{{$activite->dateDebut}}">
            {{ IntlDateFormatter::formatObject(new DateTime($activite->dateDebut), 'd MMMM', 'fr') }}
            <br/>
            {{ IntlDateFormatter::formatObject(new DateTime($activite->dateDebut), 'Y', 'fr') }}
            à {{ IntlDateFormatter::formatObject(new DateTime($activite->dateDebut), 'H', 'fr') }}h 
            {{ IntlDateFormatter::formatObject(new DateTime($activite->dateDebut), 'm', 'fr') }}
          </td>

          <td data-sort="{{$activite->dateFin}}">
            {{ IntlDateFormatter::formatObject(new DateTime($activite->dateFin), 'd MMMM', 'fr') }}
            <br/>
            {{ IntlDateFormatter::formatObject(new DateTime($activite->dateFin), 'Y', 'fr') }}
            à {{ IntlDateFormatter::formatObject(new DateTime($activite->dateFin), 'H', 'fr') }}h 
            {{ IntlDateFormatter::formatObject(new DateTime($activite->dateFin), 'm', 'fr') }}
          </td>

          <td data-sort="{{$activite->association->nom}}">
            {{$activite->association->nom}}
          </td>

          <td data-sort="{{$activite->description}}">
            @if(strlen($activite->description) > 35)
              {{substr($activite->description, 0, 35)}}...
            @else
              {{$activite->description}}
            @endif
          </td>

          <td style="text-align : right;">
              <a href="{{route('activite.show', $activite->id)}}" class="btn btn-sm btn-info mb-1"><i class="bi bi-eye"></i></a>
            @auth

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

                @if($adhere == 1)
                  @if($activite->places <= $activite->enfants->count())
                    <p class="btn btn-sm btn-secondary mb-1 disabled"><i class="bi bi-box-arrow-in-right"></i></p>
                  @else
                    <a href="{{route('activite.inscription', $activite->id)}}" class="btn btn-sm btn-success mb-1"><i class="bi bi-box-arrow-in-right"></i></a>
                  @endif
                @else
                  <p class="btn btn-sm btn-secondary mb-1 disabled"><i class="bi bi-box-arrow-in-right"></i></p>
                @endif
              @else
                <p class="btn btn-sm btn-secondary mb-1 disabled"><i class="bi bi-box-arrow-in-right"></i></p>
              @endif

              @if (Auth::user()->statut > 1)
              <br/>

              <a href="{{route('activite.edit',$activite->id)}}" class="btn btn-sm btn-warning mb-1"><i class="bi bi-pencil-square"></i></a>
              
              <button type="button" data-bs-toggle="modal" data-bs-target="#supprimerModal" onclick="supprimer({{$activite->id}})" class="btn btn-sm btn-danger mb-1">
                <i class="bi bi-trash"></i>
              </button>

            @endif
            @endauth
          </td>
        </tr>
        @endif
    @endforeach
    @break;
  
  @case(3)
    <!-- Choix 3 : Toutes les prochaines activités auxquelles j'adhère -->
    <!-- Date de début postérieure à la date actuelle, et adhésion à l'association de l'activité -->
    @foreach($activiteList as $activite)
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

      @if($activite->dateDebut > $ajd && $adhere == 1)
      <tr>
        
        <td data-sort="{{$activite->titre}}">
            <strong>{{$activite->titre}}</strong>
        </td>
        
        <td data-sort="{{$activite->places}}">
          @if($activite->dateDebut < $dt)
            Inscriptions<br/>fermées
          @elseif($activite->places <= $activite->enfants->count())
            Aucune
          @else
            {{$activite->places - $activite->enfants->count()}} / {{$activite->places}}
          @endif
        </td>

        <td data-sort="{{$activite->dateDebut}}">
          {{ IntlDateFormatter::formatObject(new DateTime($activite->dateDebut), 'd MMMM', 'fr') }}
          <br/>
          {{ IntlDateFormatter::formatObject(new DateTime($activite->dateDebut), 'Y', 'fr') }}
          à {{ IntlDateFormatter::formatObject(new DateTime($activite->dateDebut), 'H', 'fr') }}h 
          {{ IntlDateFormatter::formatObject(new DateTime($activite->dateDebut), 'm', 'fr') }}
        </td>

        <td data-sort="{{$activite->dateFin}}">
          {{ IntlDateFormatter::formatObject(new DateTime($activite->dateFin), 'd MMMM', 'fr') }}
          <br/>
          {{ IntlDateFormatter::formatObject(new DateTime($activite->dateFin), 'Y', 'fr') }}
          à {{ IntlDateFormatter::formatObject(new DateTime($activite->dateFin), 'H', 'fr') }}h 
          {{ IntlDateFormatter::formatObject(new DateTime($activite->dateFin), 'm', 'fr') }}
        </td>

        <td data-sort="{{$activite->association->nom}}">
          {{$activite->association->nom}}
        </td>

        <td data-sort="{{$activite->description}}">
          @if(strlen($activite->description) > 35)
            {{substr($activite->description, 0, 35)}}...
          @else
            {{$activite->description}}
          @endif
        </td>

        <td style="text-align : right;">
            <a href="{{route('activite.show', $activite->id)}}" class="btn btn-sm btn-info mb-1"><i class="bi bi-eye"></i></a>
          @auth

            @if($activite->dateDebut > $dt)
              @if($activite->places <= $activite->enfants->count())
                <p class="btn btn-sm btn-secondary mb-1 disabled"><i class="bi bi-box-arrow-in-right"></i></p>
              @else
                <a href="{{route('activite.inscription', $activite->id)}}" class="btn btn-sm btn-success mb-1"><i class="bi bi-box-arrow-in-right"></i></a>
              @endif
            @else
              <p class="btn btn-sm btn-secondary mb-1 disabled"><i class="bi bi-box-arrow-in-right"></i></p>
            @endif

            @if (Auth::user()->statut > 1)
            <br/>

            <a href="{{route('activite.edit',$activite->id)}}" class="btn btn-sm btn-warning mb-1"><i class="bi bi-pencil-square"></i></a>
            
            <button type="button" data-bs-toggle="modal" data-bs-target="#supprimerModal" onclick="supprimer({{$activite->id}})" class="btn btn-sm btn-danger mb-1">
              <i class="bi bi-trash"></i>
            </button>

          @endif
          @endauth
        </td>
      </tr>
      @endif
  @endforeach
  @break;
  
  @case(4)
    <!-- Choix 4 : Toutes les prochaines activités encore disponibles auxquelles j'adhère -->
    <!-- Début dans une semaine, au moins une place, et adhésion à l'association de l'activité -->
    @foreach($activiteList as $activite)
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

      @if($activite->dateDebut > $dt && $adhere == 1 && $activite->places > $activite->enfants->count())
      <tr>
        
        <td data-sort="{{$activite->titre}}">
            <strong>{{$activite->titre}}</strong>
        </td>
        
        <td data-sort="{{$activite->places}}">
          {{$activite->places - $activite->enfants->count()}} / {{$activite->places}}
        </td>

        <td data-sort="{{$activite->dateDebut}}">
          {{ IntlDateFormatter::formatObject(new DateTime($activite->dateDebut), 'd MMMM', 'fr') }}
          <br/>
          {{ IntlDateFormatter::formatObject(new DateTime($activite->dateDebut), 'Y', 'fr') }}
          à {{ IntlDateFormatter::formatObject(new DateTime($activite->dateDebut), 'H', 'fr') }}h 
          {{ IntlDateFormatter::formatObject(new DateTime($activite->dateDebut), 'm', 'fr') }}
        </td>

        <td data-sort="{{$activite->dateFin}}">
          {{ IntlDateFormatter::formatObject(new DateTime($activite->dateFin), 'd MMMM', 'fr') }}
          <br/>
          {{ IntlDateFormatter::formatObject(new DateTime($activite->dateFin), 'Y', 'fr') }}
          à {{ IntlDateFormatter::formatObject(new DateTime($activite->dateFin), 'H', 'fr') }}h 
          {{ IntlDateFormatter::formatObject(new DateTime($activite->dateFin), 'm', 'fr') }}
        </td>

        <td data-sort="{{$activite->association->nom}}">
          {{$activite->association->nom}}
        </td>

        <td data-sort="{{$activite->description}}">
          @if(strlen($activite->description) > 35)
            {{substr($activite->description, 0, 35)}}...
          @else
            {{$activite->description}}
          @endif
        </td>

        <td style="text-align : right;">
            <a href="{{route('activite.show', $activite->id)}}" class="btn btn-sm btn-info mb-1"><i class="bi bi-eye"></i></a>
          @auth

            @if($activite->dateDebut > $dt)
              @if($activite->places <= $activite->enfants->count())
                <p class="btn btn-sm btn-secondary mb-1 disabled"><i class="bi bi-box-arrow-in-right"></i></p>
              @else
                <a href="{{route('activite.inscription', $activite->id)}}" class="btn btn-sm btn-success mb-1"><i class="bi bi-box-arrow-in-right"></i></a>
              @endif
            @else
              <p class="btn btn-sm btn-secondary mb-1 disabled"><i class="bi bi-box-arrow-in-right"></i></p>
            @endif

            @if (Auth::user()->statut > 1)
            <br/>

            <a href="{{route('activite.edit',$activite->id)}}" class="btn btn-sm btn-warning mb-1"><i class="bi bi-pencil-square"></i></a>
            
            <button type="button" data-bs-toggle="modal" data-bs-target="#supprimerModal" onclick="supprimer({{$activite->id}})" class="btn btn-sm btn-danger mb-1">
              <i class="bi bi-trash"></i>
            </button>

          @endif
          @endauth
        </td>
      </tr>
      @endif
  @endforeach
  @break;

  @case(5)
    <!-- Choix 5 : Toutes les prochaines activités d'une association -->
    @foreach($activiteList as $activite)
      <!-- Date de début postérieure à la date actuelle et associaton = $assoc -->
      @if($activite->dateDebut > $ajd && $activite->association_id == $assoc)
      <tr>
        
        <td data-sort="{{$activite->titre}}">
            <strong>{{$activite->titre}}</strong>
        </td>
        
        <td data-sort="{{$activite->places}}">
          @if($activite->dateDebut < $dt)
            Inscriptions<br/>fermées
          @elseif($activite->places <= $activite->enfants->count())
            Aucune
          @else
            {{$activite->places - $activite->enfants->count()}} / {{$activite->places}}
          @endif
        </td>

        <td data-sort="{{$activite->dateDebut}}">
          {{ IntlDateFormatter::formatObject(new DateTime($activite->dateDebut), 'd MMMM', 'fr') }}
          <br/>
          {{ IntlDateFormatter::formatObject(new DateTime($activite->dateDebut), 'Y', 'fr') }}
          à {{ IntlDateFormatter::formatObject(new DateTime($activite->dateDebut), 'H', 'fr') }}h 
          {{ IntlDateFormatter::formatObject(new DateTime($activite->dateDebut), 'm', 'fr') }}
        </td>

        <td data-sort="{{$activite->dateFin}}">
          {{ IntlDateFormatter::formatObject(new DateTime($activite->dateFin), 'd MMMM', 'fr') }}
          <br/>
          {{ IntlDateFormatter::formatObject(new DateTime($activite->dateFin), 'Y', 'fr') }}
          à {{ IntlDateFormatter::formatObject(new DateTime($activite->dateFin), 'H', 'fr') }}h 
          {{ IntlDateFormatter::formatObject(new DateTime($activite->dateFin), 'm', 'fr') }}
        </td>

        <td data-sort="{{$activite->association->nom}}">
          {{$activite->association->nom}}
        </td>

        <td data-sort="{{$activite->description}}">
          @if(strlen($activite->description) > 35)
            {{substr($activite->description, 0, 35)}}...
          @else
            {{$activite->description}}
          @endif
        </td>

        <td style="text-align : right;">
            <a href="{{route('activite.show', $activite->id)}}" class="btn btn-sm btn-info mb-1"><i class="bi bi-eye"></i></a>
          @auth

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

              @if($adhere == 1)
                @if($activite->places <= $activite->enfants->count())
                  <p class="btn btn-sm btn-secondary mb-1 disabled"><i class="bi bi-box-arrow-in-right"></i></p>
                @else
                  <a href="{{route('activite.inscription', $activite->id)}}" class="btn btn-sm btn-success mb-1"><i class="bi bi-box-arrow-in-right"></i></a>
                @endif
              @else
                <p class="btn btn-sm btn-secondary mb-1 disabled"><i class="bi bi-box-arrow-in-right"></i></p>
              @endif
            @else
              <p class="btn btn-sm btn-secondary mb-1 disabled"><i class="bi bi-box-arrow-in-right"></i></p>
            @endif

            @if (Auth::user()->statut > 1)
            <br/>

            <a href="{{route('activite.edit',$activite->id)}}" class="btn btn-sm btn-warning mb-1"><i class="bi bi-pencil-square"></i></a>
            
            <button type="button" data-bs-toggle="modal" data-bs-target="#supprimerModal" onclick="supprimer({{$activite->id}})" class="btn btn-sm btn-danger mb-1">
              <i class="bi bi-trash"></i>
            </button>

          @endif
          @endauth
        </td>
      </tr>
      @endif
    @endforeach
    @break;

  @endswitch

  </tbody>

</table>

  <form id="deleteForm" action="" method="POST">
    @method('DELETE')
    @csrf
  </form>
  <br>

  <div class="d-flex justify-content-center">

  @auth
  @if (Auth::user()->statut > 1)
  <a href="{{route('activite.create')}}" class="btn btn-block btn-success mb-1">
    Ajout d'une nouvelle activité
  </a> &nbsp; &nbsp;
  @endif
  @endauth

  <a href="{{ url('/') }}" class="btn btn-block btn-secondary mb-1">
    Retour
  </a>

</div>
@endsection

@section('head')
<script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
<script defer src="{{asset('storage/js/delete.js')}}"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
<script defer type="text/javascript" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<style>
  .dataTables_wrapper .dataTables_length, .dataTables_wrapper .dataTables_filter, .dataTables_wrapper .dataTables_info, .dataTables_wrapper .dataTables_processing, .dataTables_wrapper .dataTables_paginate {
    color: #FFF;
  }
  .dataTables_wrapper .dataTables_length select {
    color: #FFF;
    background-color:  rgba(var(--bs-dark-rgb),var(--bs-bg-opacity));
  }
  .dataTables_wrapper .dataTables_filter input {
    color: #FFF;
    background-color:  rgba(var(--bs-dark-rgb),var(--bs-bg-opacity));
  }
  .dataTables_wrapper .dataTables_paginate .paginate_button.disabled, .dataTables_wrapper .dataTables_paginate .paginate_button.disabled:hover, .dataTables_wrapper .dataTables_paginate .paginate_button.disabled:active {
    color: #FFF !important;
  }
  .dataTables_wrapper .dataTables_paginate .paginate_button.current, .dataTables_wrapper .dataTables_paginate .paginate_button.current .paginate_button.current:hover {
    color: #FFF !important;
  }
  .dataTables_wrapper .dataTables_paginate .paginate_button {
    color: #FFF !important;
  }
  .dataTables_wrapper .dataTables_paginate .paginate_button.current, .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
    color: #FFF !important;
  }
  table.dataTable thead th, table.dataTable thead td {
    border-bottom: 1px solid rgba(255, 255, 255, 1);;
  }
</style>

@endsection

@section('javascript')

$(document).ready(function (){
        $('#listeActivite').DataTable({
                "pageLength": 10,
                "language": { "url": "{{ asset('storage/js/french.json') }}" },
                "stateSave": true,
                "columnDefs": [
                  { "targets": [5], "orderable": false, "searchable": false },
                  { "targets": [6], "orderable": false, "searchable": false }
                ]
            });
    });

@endsection