<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/home" class="brand-link">
        <img src="img/logo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">Tr&aacute;mite Docu</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                @guest
                    <img src="img/user-1.png" class="img-circle elevation-2" alt="User Image">
                @else    
                    <img src="{{ $usuario->foto}}" class="img-circle elevation-2" alt="User Image">
                @endguest
            </div>
            <div class="info">
                <a href="" class="d-block">
                    @guest
                        Invitado
                    @else
                        {{ Auth::user()->name}}
                    @endguest
                </a>
            </div>
            @guest
            @else
            <div class="info text-right">
                <a href="{{ route('logout') }}" class="d-block" 
                onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                <i class="fas fa-power-off fa-lg text-danger"></i>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>           
            </div>
            @endguest
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
                with font-awesome or any other icon font library -->
            <router-link to="/home" tag="li" class="nav-item">
                <a class="nav-link">
                    <i class="nav-icon fas fa-th text-cyan"></i>
                    <p>Inicio</p>
                </a>
            </router-link>
            @guest

            @else
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-users-cog text-red"></i>
                        <p>
                        Sistema
                        <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <router-link to="/users" tag="li" class="nav-item">
                            <a class="nav-link">
                                <i class="fas fa-users nav-icon"></i>
                                <p>Usuarios</p>
                            </a>
                        </router-link>                    
                        <router-link to="/perfil" tag="li" class="nav-item">
                            <a class="nav-link">
                                <i class="fas fa-address-card nav-icon"></i>
                                <p>Perfil</p>
                            </a>
                        </router-link>
                        <router-link to="/desarrollador" tag="li" class="nav-item">
                            <a class="nav-link" > 
                                <i class="fas fa-laptop-code nav-icon"></i>
                                <p>Desarrollador</p>
                            </a>
                        </router-link>
                    </ul>
                </li>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-cogs text-orange"></i>
                        <p>
                        Configuraciones
                        <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <router-link to="/institucional" tag="li" class="nav-item">
                            <a class="nav-link">
                                <i class="fas fa-building nav-icon"></i>
                                <p>Institucional</p>
                            </a>
                        </router-link>
                        <router-link to="/tupa" tag="li" class="nav-item">
                            <a class="nav-link">
                                <i class="fas fa-book nav-icon"></i>
                                <p>Tupa</p>
                            </a>
                        </router-link>
                    </ul>
                </li>            
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-copy text-teal"></i>
                        <p>
                            Trámite
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <router-link to="/solicitante" tag="li" class="nav-item">
                            <a class="nav-link">
                                <i class="fas fa-users nav-icon"></i>
                                <p>Solicitantes</p>
                            </a>
                        </router-link>
                        <router-link to="/expediente" tag="li" class="nav-item">
                            <a class="nav-link">
                                <i class="fas fa-folder-open nav-icon"></i>
                                <p>Expedientes</p>
                            </a>
                        </router-link>
                        <li class="nav-item">
                        <a href="pages/layout/boxed.html" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Movimiento</p>
                        </a>
                        </li>
                    </ul>
                </li>
            @endguest
        </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>