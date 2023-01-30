@extends('template')
@section('title') Liste des enfants @endsection
@section('content')

<div class="modal fade" id="supprimerModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-dark" id="supprimerModalLabel">Suppression d'un enfant</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-dark">
        Êtes-vous sûr de vouloir supprimer cet enfant ?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Annuler</button>
        <button type="button" class="btn btn-outline-danger" onclick="javascript:confirmer('{{url('enfant/')}}')">Confirmer</button>
      </div>
    </div>
  </div>
</div>

<!-- Sélection des enfants -->
<?php
  use Illuminate\Support\Facades\DB;
  use App\Models\User;
  $choix_enfant = 1;
  $premierParent = User::orderBy('id')->pluck('id')->first();
  $choix_parent = $premierParent;
  if($_GET) {
    $choix_enfant = $_GET['selection_enfant'];
    if($choix_enfant == 2) {
      $choix_parent = $_GET['selection_parent'];
    }
  }
?>

<form action="" method="get">
  <div class="mb-3 row">
    <label for="selection_enfant" class="col-sm-2 col-form-label">Sélection :</label>

    <div class="col-sm-10">
      <select onchange="this.form.submit()" class="form-control" name="selection_enfant" id="selection_enfant" style="color: #FFF; background-color:  rgba(var(--bs-dark-rgb),var(--bs-bg-opacity));">
        <option value="1" @if($choix_enfant == 2) selected @endif>Tous les enfants</option>
        <option value="2" @if($choix_enfant == 2) selected @endif>Choisir le parent</option>
      </select>
      <input type="hidden" id="selection_parent" name="selection_parent" value="{{$premierParent}}">
    </div>
  </div>
</form>

@if($choix_enfant == 2)
<form action="" method="get">
    <div class="mb-3 row">
      <label for="selection_parent" class="col-sm-2 col-form-label">Parent :</label>

      <div class="col-sm-10">
        <select onchange="this.form.submit()" class="form-control" name="selection_parent" id="selection_parent"  style="color: #FFF; background-color:  rgba(var(--bs-dark-rgb),var(--bs-bg-opacity));">
          <?php
            $parentsList = DB::select('SELECT * FROM users');
          ?>
          @foreach($parentsList as $parent)
            <?php
              $sesEnfants = DB::select('SELECT * FROM enfants');
              $compteur = 0;
              foreach($sesEnfants as $element) {
                if($element->user_id == $parent->id)
                  $compteur++;
              }
            ?>
            <option value="{{$parent->id}}" 
              @if($choix_parent == $parent->id) selected @endif
              @if($compteur == 0) disabled @endif
            >
              {{$parent->prenom}} {{$parent->nom}} 
              @if($compteur == 0) (n'a pas d'enfant) @endif
            </option>
          @endforeach
        </select>
        <input type="hidden" id="selection_enfant" name="selection_enfant" value="2">
      </div>
    </div>
  </form>
@endif

<hr/>
<br/>

<!-- Liste des enfants -->
<table class="table table-striped-white text-white" id='enfantList' style="border-color: white;">
  <thead>
    <tr>
      <th scope="col">Prenom</th>
      <th scope="col">Nom</th>
      <th scope="col">Date de naissance</th>
      <th scope="col">Parent</th>
      @if(Auth::user()->statut == 3)
        <th scope="col" style="text-align : right;">Actions  &nbsp;  &nbsp;  &nbsp; </th>
      @else
        <th scope="col" style="text-align : right;">Actions</th>
      @endif
      </tr>
  </thead>
  <tbody>

@switch($choix_enfant)
  @case(1)
      
    @foreach($enfantList as $enfant)
      <tr>
        
        <td data-sort="{{$enfant->nom}}">
          {{$enfant->nom}}
        </td>
        
        <td data-sort="{{$enfant->prenom}}">
          {{$enfant->prenom}}
        </td>

        <td data-sort="{{$enfant->birth}}">
          {{ IntlDateFormatter::formatObject(new DateTime($enfant->birth), 'EEEE d MMMM Y', 'fr') }}
        </td>

        <td data-sort="{{$enfant->parent}}">
          {{$enfant->user->prenom}} {{$enfant->user->nom}} 
        </td>

        <td style="text-align : right;">
          <!--Voir-->
          <a href="{{route('enfant.show', $enfant->id)}}" class="btn btn-sm btn-info mb-1"><i class="bi bi-eye"></i></a>

          @auth
            @if (Auth::user()->statut > 2)
              <!--Editer-->
              <a href="{{route('enfant.edit', $enfant->id)}}" class="btn btn-sm btn-warning mb-1"><i class="bi bi-pencil-square"></i></a>

              <!--Supprimer-->
              <button type="button" data-bs-toggle="modal" data-bs-target="#supprimerModal" onclick="supprimer({{$enfant->id}})" class="btn btn-sm btn-danger mb-1">
                  <i class="bi bi-trash"></i>
              </button>
            @endif
          @endauth
        </td>
        
      </tr>
    @endforeach
    @break


  @case(2)
      
    @foreach($enfantList as $enfant)
      @if($enfant->user_id == $choix_parent)
        <tr>
          
          <td data-sort="{{$enfant->nom}}">
            {{$enfant->nom}}
          </td>
          
          <td data-sort="{{$enfant->prenom}}">
            {{$enfant->prenom}}
          </td>

          <td data-sort="{{$enfant->birth}}">
            {{ IntlDateFormatter::formatObject(new DateTime($enfant->birth), 'EEEE d MMMM Y', 'fr') }}
          </td>

          <td data-sort="{{$enfant->parent}}">
            {{$enfant->user->prenom}} {{$enfant->user->nom}} 
          </td>

          <td style="text-align : right;">
            <!--Voir-->
            <a href="{{route('enfant.show', $enfant->id)}}" class="btn btn-sm btn-info mb-1"><i class="bi bi-eye"></i></a>

            @auth
              @if (Auth::user()->statut > 2)
                <!--Editer-->
                <a href="{{route('enfant.edit', $enfant->id)}}" class="btn btn-sm btn-warning mb-1"><i class="bi bi-pencil-square"></i></a>

                <!--Supprimer-->
                <button type="button" data-bs-toggle="modal" data-bs-target="#supprimerModal" onclick="supprimer({{$enfant->id}})" class="btn btn-sm btn-danger mb-1">
                    <i class="bi bi-trash"></i>
                </button>
              @endif
            @endauth
          </td>
          
        </tr>
      @endif
    @endforeach
    @break

  @endswitch

  </tbody>

</table>
        

<form id="deleteForm" action="" method="POST">
  @method('DELETE')
  @csrf
</form>

  @auth
  <div class="d-flex justify-content-center">
    @if(Auth::user()->statut > 2)
      <a href="{{route('enfant.create')}}" class="btn btn-block btn-success mb-1">
        Ajout d'un nouvel enfant
      </a>  &nbsp; &nbsp;
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
        $('#enfantList').DataTable({
                "pageLength": 10,
                "language": { "url": "{{ asset('storage/js/french.json') }}" },
                "stateSave": true,
                "columnDefs": [
                  { "targets": [3], "orderable": false, "searchable": false },
                  { "targets": [4], "orderable": false, "searchable": false }
                ]
            });
    });

@endsection