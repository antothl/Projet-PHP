<!DOCTYPE html>
<html lang="fr">
  <head>
    <title>@yield('title')</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="icon" type="image/png" sizes="64x64" href="{{asset('storage/images/logo.png')}}">
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    @yield('head')
  </head>
  <body style="background: url({{asset('storage/images/background.jpg')}}) no-repeat;background-position: center;background-size: cover; background-attachment: fixed;">
    
    <div class="container">

      <div class="card mt-4" style="--bs-card-border-radius: none;">

        <div class="card-header bg-white text-dark text-center" style="display:flex; align-items: center; justify-content: flex-start;">
          
          <a href="{{url('/')}}">
            <img src="{{asset('storage/images/logo.png')}}" title="Acti'scol" style="max-width: 4vw; width: auto;"/>
          </a>

          <h3 style="margin-left: auto;  margin-right: auto;"><strong>@yield('title')</strong></h3>

        </div>

        <div class="card-body bg-dark bg-gradient text-white">
          @yield('content')
        </div>

      </div>

    </div>

    <div>
      <br/>
    </div>

    <script type="text/javascript"> @yield('javascript') </script>

  </body>
</html>
