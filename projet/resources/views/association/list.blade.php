@extends('template')
@section('title') Liste des associations @endsection
@section('content')

<div class="modal fade" id="supprimerModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-dark" id="supprimerModalLabel">Suppression d'un association</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-dark">
        Êtes-vous sûr de vouloir supprimer cette association ?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Annuler</button>
        <button type="button" class="btn btn-outline-danger" onclick="javascript:confirmer('{{url('association/')}}')">Confirmer</button>
      </div>
    </div>
  </div>
</div>

<!-- Sélection des associations -->
<?php
  $choix_asso = 1;
  if($_GET) {
    $choix_asso = $_GET['selection_asso'];
  }
?>

<form action="" method="get">
  <div class="mb-3 row">
    <label for="selection_asso" class="col-sm-2 col-form-label">Sélection :</label>

    <div class="col-sm-10">
      <select onchange="this.form.submit()" class="form-control" name="selection_asso" id="selection_asso" style="color: #FFF; background-color:  rgba(var(--bs-dark-rgb),var(--bs-bg-opacity));">
          <option value="1" @if($choix_asso == 1) selected @endif>Toutes les associations</option>
          @auth
            <option value="2" @if($choix_asso == 2) selected @endif>Seulement les associations auxquelles j'adhère</option>
          @endauth
        </select>
      </div>
  </div>
</form>

<hr/>
<br/>

<!-- Liste des associations -->
<table class="table table-striped-white text-white" id='associationList' style="border-color: white;">
  <thead>
    <tr>
      <th scope="col">Nom</th>
      @auth
        @switch(Auth::user()->statut)
          @case(1)
          @case(2)
            <th scope="col" style="text-align : right;">Actions  &nbsp;  </th>
            @break;
          @default
            <th scope="col" style="text-align : right;">Actions  &nbsp; &nbsp;  &nbsp;  &nbsp;  &nbsp; </th>
            @break;
        @endswitch
      @else
        <th scope="col" style="text-align : right;">Actions</th>
      @endauth
      </tr>
  </thead>
  <tbody>
    
@switch($choix_asso)
  @case(1)
    @foreach($associationList as $association)
      <tr>
        
        <td data-sort="{{$association->nom}}">
          {{$association->nom}}
        </td>
        

        <td style="text-align : right;">
          
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

                <!--Voir-->
                <a href="{{route('association.show', $association->id)}}" class="btn btn-sm btn-info mb-1"><i class="bi bi-eye"></i></a>
              
                <input type="hidden" name="association_id" value="{{$association->id}}"/>
                <input type="hidden" name="user_id" value="{{Auth::user()->id}}"/>
                <input type="hidden" name="page" value="2"/>
                <!--Adherer-->
                <button class="btn btn-sm btn-success mb-1" type="submit">
                  <i class="bi bi-bookmark-check"></i>
                </button>

                @if (Auth::user()->statut == 3)
                <!--Editer-->
                <a href="{{route('association.edit', $association->id)}}" class="btn btn-sm btn-warning mb-1"><i class="bi bi-pencil-square"></i></a>

                <!--Supprimer-->
                <button type="button" data-bs-toggle="modal" data-bs-target="#supprimerModal" onclick="supprimer({{$association->id}})" class="btn btn-sm btn-danger mb-1">
                    <i class="bi bi-trash"></i>
                </button>
                @endif

              </form> 
            @else
              <form method="get" action="{{url('script_adhesion')}}">

                <!--Voir-->
                <a href="{{route('association.show', $association->id)}}" class="btn btn-sm btn-info mb-1"><i class="bi bi-eye"></i></a>
              
                <input type="hidden" name="association_id" value="{{$association->id}}"/>
                <input type="hidden" name="user_id" value="{{Auth::user()->id}}"/>
                <input type="hidden" name="page" value="2"/>
                <!--Adherer-->
                <button class="btn btn-sm btn-light mb-1" type="submit">
                  <i class="bi bi-bookmark-plus"></i>
                </button>

                @if (Auth::user()->statut == 3)
                <!--Editer-->
                <a href="{{route('association.edit', $association->id)}}" class="btn btn-sm btn-warning mb-1"><i class="bi bi-pencil-square"></i></a>

                <!--Supprimer-->
                <button type="button" data-bs-toggle="modal" data-bs-target="#supprimerModal" onclick="supprimer({{$association->id}})" class="btn btn-sm btn-danger mb-1">
                    <i class="bi bi-trash"></i>
                </button>
                @endif

              </form> 
            @endif

          @else 
          
            <!--Voir-->
            <a href="{{route('association.show', $association->id)}}" class="btn btn-sm btn-info mb-1"><i class="bi bi-eye"></i></a>
          
          @endauth
        </td>
        
      </tr>
    @endforeach
    @break

  @case(2)
    @foreach($associationList as $association)

      <?php
        $adhere = 0;
      ?>
      @foreach($association->user as $user)
        @if($user->id == Auth::user()->id)
          <?php
            $adhere = 1
          ?>
        @endif
      @endforeach

      @if($adhere == 1)
        <tr>
          
          <td data-sort="{{$association->nom}}">
            {{$association->nom}}
          </td>
          

          <td style="text-align : right;">
            
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

                  <!--Voir-->
                  <a href="{{route('association.show', $association->id)}}" class="btn btn-sm btn-info mb-1"><i class="bi bi-eye"></i></a>
                
                  <input type="hidden" name="association_id" value="{{$association->id}}"/>
                  <input type="hidden" name="user_id" value="{{Auth::user()->id}}"/>
                  <input type="hidden" name="page" value="2"/>
                  <!--Adherer-->
                  <button class="btn btn-sm btn-success mb-1" type="submit">
                    <i class="bi bi-bookmark-check"></i>
                  </button>

                  @if (Auth::user()->statut == 3)
                  <!--Editer-->
                  <a href="{{route('association.edit', $association->id)}}" class="btn btn-sm btn-warning mb-1"><i class="bi bi-pencil-square"></i></a>

                  <!--Supprimer-->
                  <button type="button" data-bs-toggle="modal" data-bs-target="#supprimerModal" onclick="supprimer({{$association->id}})" class="btn btn-sm btn-danger mb-1">
                      <i class="bi bi-trash"></i>
                  </button>
                  @endif

                </form> 
              @else
                <form method="get" action="{{url('script_adhesion')}}">

                  <!--Voir-->
                  <a href="{{route('association.show', $association->id)}}" class="btn btn-sm btn-info mb-1"><i class="bi bi-eye"></i></a>
                
                  <input type="hidden" name="association_id" value="{{$association->id}}"/>
                  <input type="hidden" name="user_id" value="{{Auth::user()->id}}"/>
                  <input type="hidden" name="page" value="2"/>
                  <!--Adherer-->
                  <button class="btn btn-sm btn-light mb-1" type="submit">
                    <i class="bi bi-bookmark-plus"></i>
                  </button>

                  @if (Auth::user()->statut == 3)
                  <!--Editer-->
                  <a href="{{route('association.edit', $association->id)}}" class="btn btn-sm btn-warning mb-1"><i class="bi bi-pencil-square"></i></a>

                  <!--Supprimer-->
                  <button type="button" data-bs-toggle="modal" data-bs-target="#supprimerModal" onclick="supprimer({{$association->id}})" class="btn btn-sm btn-danger mb-1">
                      <i class="bi bi-trash"></i>
                  </button>
                  @endif

                </form> 
              @endif

            @else 
            
              <!--Voir-->
              <a href="{{route('association.show', $association->id)}}" class="btn btn-sm btn-info mb-1"><i class="bi bi-eye"></i></a>
            
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
    @auth
      @if(Auth::user()->statut > 2)
        <a href="{{route('association.create')}}" class="btn btn-block btn-success mb-1">
          Ajouter une nouvelle association
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
        $('#associationList').DataTable({
                "pageLength": 10,
                "language": { "url": "{{ asset('storage/js/french.json') }}" },
                "stateSave": true,
                "columnDefs": [
                  { "targets": [1], "orderable": false, "searchable": false }
                ]
            });
    });

@endsection