<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Management System</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <style>
        html,
        body {
            background-image: url('{{ asset('images/welcomebg.jpg') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            font-family: 'Raleway';
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
            color: white;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 100px;
        }

        .links>a {
            color: white;
            padding: 0 10px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin: 10px;
            color: white;
            font-weight: 500;
            text-align: center;
            /* Center align the title */
        }

         @media (max-width: 768px) {
            .title {
                font-size: 12vw;
            }
            .content {
                padding: 1.5rem 0.5rem;
            }
            .top-right {
                font-size: 0.95rem;
                top: 10px;
                right: 5px;
            }
        }

        @media (max-width: 480px) {
            .title {
                font-size: 2.2rem;
            }
            .content {
                padding: 1rem 0.2rem;
            }
            .links > a {
                font-size: 0.9rem;
                padding: 0 5px;
            }
        }
    </style>
</head>

<body>
    <div class="flex-center position-ref full-height">

        @if (Route::has('login') && Auth::check())
        <div class="top-right links">
            <a href="{{ url('/dashboard') }}">Dashboard</a>
        </div>
        @elseif (Route::has('login') && !Auth::check())
        <div class="top-right links">
            <a href="{{ url('/login') }}">Login</a>
        </div>
        @endif

        <div class="content">
            <div class="title m-b-md">
                AMD SYNERGY
            </div>

            <div class="links">
                <a href="https://linktr.ee/AMDSYNERGY">Details</a>
            </div>
        </div>
    </div>
</body>

</html>