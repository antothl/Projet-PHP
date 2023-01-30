@extends('template')
@section('title') Vos enfants @endsection
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
        <button type="button" class="btn btn-outline-danger" onclick="javascript:confirmer('{{url('compte/compte_enfant/')}}')">Confirmer</button>
      </div>
    </div>
  </div>
</div>

<table class="table table-striped-white text-white" id='compte_enfantList' style="border-color: white;">
  <thead>
    <tr>
      <th scope="col">Prenom</th>
      <th scope="col">Nom</th>
      <th scope="col">Date de naissance</th>
      <th scope="col" style="text-align : right;">Actions  &nbsp;  &nbsp;  &nbsp; </th>
    </tr>
  </thead>
  <tbody>
    
  @foreach($compte_enfantList as $compte_enfant)
    <tr>
      
      <td data-sort="{{$compte_enfant->prenom}}">
        {{$compte_enfant->prenom}}
      </td>
      
      <td data-sort="{{$compte_enfant->nom}}">
        {{$compte_enfant->nom}}
      </td>
      <td data-sort="{{$compte_enfant->birth}}">
        {{ IntlDateFormatter::formatObject(new DateTime($compte_enfant->birth), 'EEEE d MMMM Y', 'fr') }}
      </td>

      <td style="text-align : right;">
        <!--Voir-->
        <a href="{{route('compte_enfant.show', $compte_enfant->id)}}" class="btn btn-sm btn-info mb-1"><i class="bi bi-eye"></i></a>

        @auth
        <!--Editer-->
        <a href="{{route('compte_enfant.edit', $compte_enfant->id)}}" class="btn btn-sm btn-warning mb-1"><i class="bi bi-pencil-square"></i></a>

        <!--Supprimer-->
        <button type="button" data-bs-toggle="modal" data-bs-target="#supprimerModal" onclick="supprimer({{$compte_enfant->id}})" class="btn btn-sm btn-danger mb-1">
            <i class="bi bi-trash"></i>
        </button>
        @endauth
      </td>
      
    </tr>
@endforeach

  </tbody>

</table>
        

<form id="deleteForm" action="" method="POST">
  @method('DELETE')
  @csrf
</form>

  @auth
  <div class="d-flex justify-content-center">
  <a href="{{route('compte_enfant.create')}}" class="btn btn-block btn-success mb-1">
    Ajout d'un nouvel enfant
  </a>  &nbsp; &nbsp;
  @endauth
  <a href="{{ url('compte') }}" class="btn btn-block btn-secondary mb-1">
    Retour
  </a>  &nbsp; &nbsp;
  
  <a href="{{url('/')}}" class="btn btn-block btn-outline-light mb-1">Accueil</a>
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
        $('#compte_enfantList').DataTable({
                "pageLength": 10,
                "language": { "url": "{{ asset('storage/js/french.json') }}" },
                "stateSave": true,
                "columnDefs": [
                  { "targets": [3], "orderable": false, "searchable": false }
                ]
            });
    });

@endsection