<template>
        <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/" class="brand-link">
        <img src="img/logo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">Tr&aacute;mite Docu</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
            <img src="img/user-1.png" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
            <a href="#" class="d-block">Fredy Rojas</a>
        </div>
        <div class="info">
            <a href="#" class="d-block text-right">
                <i class="fas fa-power-off fa-lg text-danger"></i>
            </a>
        </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
                with font-awesome or any other icon font library -->
            <router-link to="/home" tag="li" class="nav-item">
                <a class="nav-link">
                    <i class="nav-icon fas fa-th"></i>
                    <p>Inicio</p>
                </a>
            </router-link>
            <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-users-cog"></i>
                    <p>
                    Sistema
                    <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <router-link to="/role" tag="li" class="nav-item">
                        <a class="nav-link">
                            <i class="fas fa-user-tag nav-icon"></i>
                            <p>Roles</p>
                        </a>
                    </router-link>
                    <router-link to="/permiso" tag="li" class="nav-item">
                        <a class="nav-link">
                            <i class="fas fa-user-lock nav-icon"></i>
                            <p>Permisos</p>
                        </a>
                    </router-link>
                    <router-link to="/personal" tag="li" class="nav-item">
                        <a class="nav-link" > 
                            <i class="fas fa-user-tie nav-icon"></i>
                            <p>Personal</p>
                        </a>
                    </router-link>
                </ul>
            </li>
            <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-cogs"></i>
                <p>
                Configuraciones
                <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                <a href="./index.html" class="nav-link">
                    <i class="fas fa-building nav-icon"></i>
                    <p>Institucional</p>
                </a>
                </li>
                <li class="nav-item">
                <a href="./index2.html" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Dashboard v2</p>
                </a>
                </li>
                <li class="nav-item">
                <a href="./index3.html" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Dashboard v3</p>
                </a>
                </li>
            </ul>
            </li>
            
            <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-copy"></i>
                <p>
                Trámite
                <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                <a href="pages/layout/top-nav.html" class="nav-link">
                    <i class="fas fa-users nav-icon"></i>
                    <p>Solicitantes</p>
                </a>
                </li>
                <li class="nav-item">
                <a href="pages/layout/boxed.html" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Boxed</p>
                </a>
                </li>
                <li class="nav-item">
                <a href="pages/layout/fixed.html" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Fixed</p>
                </a>
                </li>
                <li class="nav-item">
                <a href="pages/layout/fixed-topnav.html" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Fixed Navbar</p>
                </a>
                </li>
                <li class="nav-item">
                <a href="pages/layout/fixed-footer.html" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Fixed Footer</p>
                </a>
                </li>
                <li class="nav-item">
                <a href="pages/layout/collapsed-sidebar.html" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Collapsed Sidebar</p>
                </a>
                </li>
            </ul>
            </li>
            <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-chart-pie"></i>
                <p>
                Movimiento
                <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                <a href="pages/charts/chartjs.html" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Mantenimiento</p>
                </a>
                </li>
                <li class="nav-item">
                <a href="pages/charts/flot.html" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Estado Movimiento</p>
                </a>
                </li>
                <li class="nav-item">
                <a href="pages/charts/inline.html" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Inline</p>
                </a>
                </li>
            </ul>
            </li>
            <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-tree"></i>
                <p>
                Documentación
                <i class="fas fa-angle-left right"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                <a href="pages/UI/general.html" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Expedientes</p>
                </a>
                </li>
                <li class="nav-item">
                <a href="pages/UI/icons.html" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Asignaciones</p>
                </a>
                </li>
                <li class="nav-item">
                <a href="pages/UI/buttons.html" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Buttons</p>
                </a>
                </li>
                <li class="nav-item">
                <a href="pages/UI/sliders.html" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Sliders</p>
                </a>
                </li>
                <li class="nav-item">
                <a href="pages/UI/modals.html" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Modals & Alerts</p>
                </a>
                </li>
            </ul>
            </li>
        </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
    </aside>
</template>
