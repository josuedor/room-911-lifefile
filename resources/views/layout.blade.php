<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">    
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css">
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <title>Room 911 Access Control</title>
    
    @yield('styles')
</head>
<body>
    @admincheck
    <nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
          <a class="navbar-brand" href="/dashboard">Admin Room 911</a>
          <!--<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>-->
          <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link {{ (request()->is('dashboard*')) ? 'active' : '' }}" aria-current="page" href="/dashboard">Users</a>
              </li>
              <li class="nav-item">
                <a class="nav-link {{ (request()->is('access*')) ? 'active' : '' }}" href="/access">Access</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="/logout">Log out</a>
              </li>
            </ul>
          </div>
          <div class="d-flex" style="color: white;">
            Welcome: {{ Auth::user()->firstname }} ({{ Auth::user()->last_activity ?? '' }})
            
          </div>
        </div>
    </nav>
    @endadmincheck

    @yield('content')

    @yield('scripts')

</body>

</html>