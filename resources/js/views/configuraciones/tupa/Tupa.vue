<template>
    <div class="container-fluid">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Tupa</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/home">Trámites</a></li>
                        <li class="breadcrumb-item active">Configuración</li>
                        <li class="breadcrumb-item active">Tupa</li>
                    </ol>
                </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <section class="content">
             <div class="container-fluid">
                <div class="card card-default color-palette-box">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-book"></i> Configuraciones Tupa
                        </h3>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs " id="custom-content-below-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="unidad-organica-tab" 
                                    data-toggle="pill" role="tab" href="" @click="mostrarVista('procedimiento')"
                                    aria-controls="unidad-organica" aria-selected="false">Procedimientos</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="dependencias-tab" 
                                    data-toggle="pill" href="" role="tab" @click="mostrarVista('ruta')"
                                    aria-controls="dependencias" aria-selected="false">Rutas</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " id="custom-content-below-messages-tab" 
                                data-toggle="pill" href="" role="tab" @click="mostrarVista('requisito')"
                                aria-controls="custom-content-below-messages" aria-selected="true">Requisitos</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " id="custom-content-below-messages-tab" 
                                data-toggle="pill" href="" role="tab" @click="mostrarVista('requisito-procedimiento')"
                                aria-controls="custom-content-below-messages" aria-selected="true">Requisitos - Procedimientos</a>
                            </li>
                        </ul>
                        <div class="tab-content container-fluid" id="content-tabcontent">
                            <procedimiento v-show="entidad=='procedimiento'"></procedimiento>
                            <ruta v-show="entidad=='ruta'"></ruta>
                        </div>
                    </div>
                </div>
             </div>
        </section>
    </div>
</template>

<script>
    export default {
        created() {
            this.entidad='procedimiento'          
        },
        data() {
            return {
                entidad:'procedimiento'
            }
        },
        methods: {
            mostrarVista(vista) {
                this.entidad=vista;
            },           
        }  
    }
</script>