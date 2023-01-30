@extends('template')
@section('title') Liste des utilisateurs @endsection
@section('content')

<div class="modal fade" id="supprimerModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-dark" id="supprimerModalLabel">Suppression d'un utilisateur</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-dark">
        Êtes-vous sûr de vouloir supprimer cet utilisateur ?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Annuler</button>
        <button type="button" class="btn btn-outline-danger" onclick="confirmer('{{url('user/')}}')">Confirmer</button>
      </div>
    </div>
  </div>
</div>

<!-- Sélection des utilisateurs -->
<?php
  $choix_user = 1;
  if($_GET) {
    $choix_user = $_GET['selection_user'];
  }
?>

  <form action="" method="get">
    <div class="mb-3 row">
      <label for="selection_user" class="col-sm-2 col-form-label">Sélection :</label>

      <div class="col-sm-10">
        <select onchange="this.form.submit()" class="form-control" name="selection_user" id="selection_user" style="color: #FFF; background-color:  rgba(var(--bs-dark-rgb),var(--bs-bg-opacity));">
            <option value="1" @if($choix_user == 1) selected @endif>Tous les utilisateurs</option>
            <option value="2" @if($choix_user == 2) selected @endif>Seulement les utilisateurs normaux</option>
            <option value="3" @if($choix_user == 3) selected @endif>Seulement les gestionnaires</option>
            <option value="4" @if($choix_user == 4) selected @endif>Seulement les administrateurs</option>
          </select>
        </div>
    </div>
  </form>

<hr/>
<br/>

<!-- Liste des utilisateurs -->
<table class="table table-striped-white text-white" id='userList' style="border-color: white;">
  <thead>
    <tr>
      <th scope="col">Pseudonyme</th>
      <th scope="col">Prenom</th>
      <th scope="col">Nom</th>
      <th scope="col">Email</th>
      <th scope="col">Statut</th>
      @if(Auth::user()->statut == 3)
        <th scope="col" style="text-align : right;">Actions  &nbsp;  &nbsp;  &nbsp; </th>
      @else
        <th scope="col" style="text-align : right;">Actions</th>
      @endif
      </tr>
  </thead>
  <tbody>


@switch($choix_user)
  @case(1)
    @foreach($userList as $user)
      <tr>
        
        <td data-sort="{{$user->pseudonyme}}">
          <strong>{{$user->pseudonyme}}</strong>
        </td>

        <td data-sort="{{$user->prenom}}">
          {{$user->prenom}}
        </td>

        <td data-sort="{{$user->nom}}">
          {{$user->nom}}
        </td>

        <td data-sort="{{$user->email}}">
          {{$user->email}}
        </td>
        
        <td data-sort="{{$user->statut}}">
          @if($user->statut === 1)
            <i>Utilisateur</i>
          @elseif($user->statut === 2)
            <i>Gestionnaire</i>
          @else
            <i>Administrateur</i>
          @endif
        </td>

        <td style="text-align : right;">
          <!--Voir-->
          <a href="{{route('user.show', $user->id)}}" class="btn btn-sm btn-info mb-1"><i class="bi bi-eye"></i></a>

          @auth
            @if (Auth::user()->statut > 2)
              <!--Editer-->
              <a href="{{route('user.edit', $user->id)}}" class="btn btn-sm btn-warning mb-1"><i class="bi bi-pencil-square"></i></a>

              <!--Supprimer-->
              <button type="button" data-bs-toggle="modal" data-bs-target="#supprimerModal" onclick="supprimer({{$user->id}})" class="btn btn-sm btn-danger mb-1">
                <i class="bi bi-trash"></i>
              </button>
            @endif
          @endauth
        </td>
      </tr>
    @endforeach
    @break

    @case(2)
    @foreach($userList as $user)
      @if($user->statut == 1)
        <tr>
          
          <td data-sort="{{$user->pseudonyme}}">
            <strong>{{$user->pseudonyme}}</strong>
          </td>

          <td data-sort="{{$user->prenom}}">
            {{$user->prenom}}
          </td>

          <td data-sort="{{$user->nom}}">
            {{$user->nom}}
          </td>

          <td data-sort="{{$user->email}}">
            {{$user->email}}
          </td>
          
          <td data-sort="{{$user->statut}}">
            @if($user->statut === 1)
              <i>Utilisateur</i>
            @elseif($user->statut === 2)
              <i>Gestionnaire</i>
            @else
              <i>Administrateur</i>
            @endif
          </td>

          <td style="text-align : right;">
            <!--Voir-->
            <a href="{{route('user.show', $user->id)}}" class="btn btn-sm btn-info mb-1"><i class="bi bi-eye"></i></a>

            @auth
              @if (Auth::user()->statut > 2)
                <!--Editer-->
                <a href="{{route('user.edit', $user->id)}}" class="btn btn-sm btn-warning mb-1"><i class="bi bi-pencil-square"></i></a>

                <!--Supprimer-->
                <button type="button" data-bs-toggle="modal" data-bs-target="#supprimerModal" onclick="supprimer({{$user->id}})" class="btn btn-sm btn-danger mb-1">
                  <i class="bi bi-trash"></i>
                </button>
              @endif
            @endauth
          </td>
        </tr>
        @endif
    @endforeach
    @break

@case(3)
@foreach($userList as $user)
  @if($user->statut == 2)
    <tr>
      
      <td data-sort="{{$user->pseudonyme}}">
        <strong>{{$user->pseudonyme}}</strong>
      </td>

      <td data-sort="{{$user->prenom}}">
        {{$user->prenom}}
      </td>

      <td data-sort="{{$user->nom}}">
        {{$user->nom}}
      </td>

      <td data-sort="{{$user->email}}">
        {{$user->email}}
      </td>
      
      <td data-sort="{{$user->statut}}">
        @if($user->statut === 1)
          <i>Utilisateur</i>
        @elseif($user->statut === 2)
          <i>Gestionnaire</i>
        @else
          <i>Administrateur</i>
        @endif
      </td>

      <td style="text-align : right;">
        <!--Voir-->
        <a href="{{route('user.show', $user->id)}}" class="btn btn-sm btn-info mb-1"><i class="bi bi-eye"></i></a>

        @auth
          @if (Auth::user()->statut > 2)
            <!--Editer-->
            <a href="{{route('user.edit', $user->id)}}" class="btn btn-sm btn-warning mb-1"><i class="bi bi-pencil-square"></i></a>

            <!--Supprimer-->
            <button type="button" data-bs-toggle="modal" data-bs-target="#supprimerModal" onclick="supprimer({{$user->id}})" class="btn btn-sm btn-danger mb-1">
              <i class="bi bi-trash"></i>
            </button>
          @endif
        @endauth
      </td>
    </tr>
    @endif
  @endforeach
  @break

@case(4)
@foreach($userList as $user)
  @if($user->statut == 3)
    <tr>
      
      <td data-sort="{{$user->pseudonyme}}">
        <strong>{{$user->pseudonyme}}</strong>
      </td>

      <td data-sort="{{$user->prenom}}">
        {{$user->prenom}}
      </td>

      <td data-sort="{{$user->nom}}">
        {{$user->nom}}
      </td>

      <td data-sort="{{$user->email}}">
        {{$user->email}}
      </td>
      
      <td data-sort="{{$user->statut}}">
        @if($user->statut === 1)
          <i>Utilisateur</i>
        @elseif($user->statut === 2)
          <i>Gestionnaire</i>
        @else
          <i>Administrateur</i>
        @endif
      </td>

      <td style="text-align : right;">
        <!--Voir-->
        <a href="{{route('user.show', $user->id)}}" class="btn btn-sm btn-info mb-1"><i class="bi bi-eye"></i></a>

        @auth
          @if (Auth::user()->statut > 2)
            <!--Editer-->
            <a href="{{route('user.edit', $user->id)}}" class="btn btn-sm btn-warning mb-1"><i class="bi bi-pencil-square"></i></a>

            <!--Supprimer-->
            <button type="button" data-bs-toggle="modal" data-bs-target="#supprimerModal" onclick="supprimer({{$user->id}})" class="btn btn-sm btn-danger mb-1">
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

  <div class="d-flex justify-content-center">

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
        $('#userList').DataTable({
                "pageLength": 10,
                "language": { "url": "{{ asset('storage/js/french.json') }}" },
                "stateSave": true,
                "columnDefs": [
                  { "targets": [5], "orderable": false, "searchable": false }
                ]
            });
    });

@endsection