<!DOCTYPE html>
<html lang="en" ng-app="RedArrow">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Digital blood donation camp">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Red Arrow</title>

    <!-- Disable tap highlight on IE -->
    <meta name="msapplication-tap-highlight" content="no">

    <!-- Web Application Manifest -->
    <link rel="manifest" href="/manifest.json">

    <!-- Add to homescreen for Chrome on Android -->
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="application-name" content="Red Arrow">

    <!-- Add to homescreen for Safari on iOS -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-title" content="Red Arrow">

    <!-- Tile icon for Win8 (144x144 + tile color) -->
    <meta name="msapplication-TileColor" content="#2F3BA2">

    <!-- Color the status bar on mobile devices -->
    <meta name="theme-color" content="#2F3BA2">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Styles -->
    <link href="/css/app.css" rel="stylesheet">

    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>
<body>
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    Red Arrow
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    &nbsp;
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ url('/login') }}">Login</a></li>
                        <li><a href="{{ url('/register') }}">Register</a></li>
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                @if (Auth::user()->donor)
                                    <img src="{{ url('imagecache/avatar/' . Auth::user()->donor->avatar) }}" alt="avatar" class="avatar">
                                @elseif (Auth::user()->hospital)
                                    <img src="{{ url('imagecache/avatar/' . Auth::user()->hospital->avatar) }}" alt="avatar" class="avatar">
                                @endif
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                @if (Auth::user()->donor)
                                    <li><a href="{{ route('appointment.received') }}">Recieved Appointments</a></li>
                                    <li><a href="{{ route('appointment.accepted') }}">Accepted Appointments</a></li>
                                    <li><a href="{{ route('user.donation') }}">Donation History</a></li>

                                    <li class="divider"></li>

                                    <li><a href="{{ url('donor/' . Auth::user()->donor->id) }}">View Profile</a></li>
                                @elseif (Auth::user()->hospital)
                                    <li><a href="{{ route('appointment.sent') }}">Sent Appointments</a></li>
                                    <li><a href="{{ route('appointment.accepted') }}">Accepted Appointments</a></li>
                                    <li><a href="{{ route('appointment.approved') }}">Approved Appointments</a></li>

                                    <li class="divider"></li>

                                    <li><a href="{{ url('hospital/' . Auth::user()->hospital->id) }}">View Profile</a></li>
                                @endif
                                <li>
                                    <a href="{{ url('/logout') }}"
                                        onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>

                                    <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    @yield('content')

    <!-- Scripts -->
    <script src="https://www.gstatic.com/firebasejs/3.6.4/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/3.6.4/firebase-messaging.js"></script>
    <script defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDIO4lZGXUhTkuxgNUgda6_JeMXBKgegok&libraries=places,geometry&callback=initMap"></script>

    @if (App::isLocal())
        <script src="/js/vendor.js"></script>
    @else
        <script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    @endif

    <script src="/js/app.js"></script>
</body>
</html>
