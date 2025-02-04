<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Impact', sans-serif;
                font-weight: 200;
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
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}" class="btn btn-primary">Home</a>
                    @else
                        <a href="{{ route('login') }}"  class="btn btn-danger">Iniciar Sesión</a>
                       <!-- @if (Route::has('register'))
                            <a href="{{ route('register') }}"  class="btn btn-danger">Reg</a>
                        @endif-->
                    @endauth
                </div>
            @endif
            <div class="content">
                <div class="title" vali>
                    Municipalidad Provincial de Pachitea
                    <div><img src="img/logo.png" width="80" ></div>
                    Sistema de Gestión de Tramite Documentario
                </div>
                <div class="title">
                    <font style="font-size:12pt">Buscar Expediente: <input type="text" placeholder="Ingrese Nro. Expediente"></font>
                    <button>Buscar</button>
                </div>
            </div>
        </div>
    </body>
</html>
