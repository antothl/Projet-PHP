@extends('template')

@section('title')
Informations sur la commune
@endsection

@section('content')
<h2>Acti'scol</h2>
<br/> 

<p>
  
  Sur ce site vous pouvez créer un compte, ou vous connecter, pour ensuite adhérer aux différentes associations présentes au sein de la commune, dans le but d'inscrire vos enfants aux activités proposées.
  <br/> <br/>

  Des gestionnaires peuvent créer une activité sur le site, ou modifier/supprimer celles existantes, et les administrateurs peuvent gérer toute la base de données.
  <br/> <br/>

  Site Web réalisé par Antoine Duval & Antoine Théologien (S3F3) dans le cadre du projet final en INFO0303.
  <br/> <br/> <br/> <br/> 
  
  <img src="{{asset('storage/images/logo.png')}}" title="Logo Acti'scol" style="max-height: 8vw; height: auto;"/> &nbsp;  &nbsp;  &nbsp;  &nbsp; 
  <img src="{{asset('storage/images/laravel.png')}}" title="Logo Laravel" style="max-height: 8vw; height: auto;"/> &nbsp;  &nbsp;  &nbsp;  &nbsp; 
  <img src="{{asset('storage/images/php.png')}}" title="Logo PHP" style="max-height: 8vw; height: auto;"/> &nbsp;  &nbsp;  &nbsp;  &nbsp; 
  <img src="{{asset('storage/images/pma.png')}}" title="Logo PHP My Admin" style="max-height: 8vw; height: auto;"/> &nbsp;  &nbsp;  &nbsp;  &nbsp; 
  <img src="{{asset('storage/images/urca.png')}}" title="Logo URCA" style="max-height: 8vw; height: auto;"/>
  <br/>

</p>
  
<br/> <br/> <br/> <br/> 

<a href="{{url('/')}}" class="btn btn-block btn-secondary mb-2 mr-2">
  Retour
</a>

@endsection
