<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Trámite | Documentario</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
        <meta content="Coderthemes" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

        <!-- App favicon -->
        <link rel="shortcut icon" href="landing/images/favicon.ico">

        <!-- Bootstrap core CSS -->
        <link rel="stylesheet" href="landing/css/bootstrap.min.css" type="text/css">

        <!--Material Icon -->
        <link rel="stylesheet" type="text/css" href="landing/css/materialdesignicons.min.css" />

        <!-- Custom  sCss -->
        <link rel="stylesheet" type="text/css" href="landing/css/style.css" />

    </head>

    <body>

        <!--Navbar Start-->
        <nav class="navbar navbar-expand-lg fixed-top navbar-custom sticky sticky-dark">
            <div class="container-fluid">
                <!-- LOGO -->
                <a class="logo text-uppercase" href="index.html">
                    <img src="img/logo_mpp.png" alt="" class="logo-light" height="64" /> 
                    <img src="landing/images/pachiteamuni.png" alt="" class="logo-dark" height="48" /> 
                </a>

                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="mdi mdi-menu"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <ul class="navbar-nav mx-auto navbar-center" id="mySidenav">
                        
                    </ul>
                    @auth
                        <a href="{{ url('/home') }}" class="btn btn-secondary">Inicio</a>
                    @else
                        <a href="{{ route('login') }}"  class="btn btn-success">Iniciar Sesión</a>
                    @endauth
                </div>
            </div>
        </nav>
        <!-- Navbar End -->

        <!-- home start -->
        <section class="bg-home bg-gradient" id="home">
            <div class="home-center">
                <div class="home-desc-center">
                    <div class="container-fluid">
                        <div class="row align-items-center">
                            <div class="col-lg-6">
                                <div class="home-title mo-mb-20">
                                    <h1 class="mb-4 text-white">Sistema de Gestión de trámite Documentario</h1>
                                    <p class="text-white home-desc mb-5">Municipalidad Provincial de Pachitea </p>
                                    <div class="subscribe">
                                        <form action="/home">
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div class="mb-2">
                                                        <input type="text"   style="background-color:aliceblue;border:1px solid #000;color:#000" id="buscar_expediente" name="buscar_expediente" class="form-control" 
                                                            value="expediente"
                                                         placeholder="Ingrese Número Expediente">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <button type="submit" class="btn btn-secondary" id="btn-buscar-expediente" >Buscar</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 offset-xl-2 col-lg-5 offset-lg-1 col-md-7">
                                <div class="home-img position-relative">
                                    <img src="landing/images/pachiteamuni.png" alt="" class="home-first-img">
                                </div>
                            </div>
                        </div>                        
                    </div>
                </div>
            </div>
        </section>
        <footer class="bg-dark footer">
            <div class="container-fluid">    
                <div class="row">
                    <div class="col-lg-12">
                        <div class="float-left pull-none">
                            <p class="text-white-50">2019 &copy;  Tr&aacute;mite Documentario 
                        </div>
                        <div class="float-right pull-none">
                            <ul class="list-inline social-links">
                                <li class="list-inline-item text-white-50">
                                    Social :
                                </li>
                                <li class="list-inline-item"><a href="#"><i class="mdi mdi-facebook"></i></a></li>
                                <li class="list-inline-item"><a href="#"><i class="mdi mdi-twitter"></i></a></li>
                                <li class="list-inline-item"><a href="#"><i class="mdi mdi-instagram"></i></a></li>
                                <li class="list-inline-item"><a href="#"><i class="mdi mdi-google-plus"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
   
        <a href="#" class="back-to-top" id="back-to-top"> <i class="mdi mdi-chevron-up"> </i> </a>

        <!-- javascript -->
        <script src="landing/js/jquery.min.js"></script>
        <script src="landing/js/bootstrap.bundle.min.js"></script>
        <script src="landing/js/jquery.easing.min.js"></script>
        <script src="landing/js/scrollspy.min.js"></script>
        <script src="js/bienvenido.js"></script>

        <!-- custom js -->
        <script src="landing/js/app.js"></script>
    </body>

</html>