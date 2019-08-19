<template>
    <div>
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Institucional</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Trámites</a></li>
                        <li class="breadcrumb-item active">Configuración</li>
                        <li class="breadcrumb-item active">Institucional</li>
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
                            <i class="fas fa-building"></i> Configuraciones Institucional
                        </h3>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs " id="custom-content-below-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="unidad-organica-tab" 
                                    data-toggle="pill" role="tab" href="" @click="mostrarVista('unidadorganica')"
                                    aria-controls="unidad-organica" aria-selected="false">Unidad Org&aacute;nica</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="dependencias-tab" 
                                    data-toggle="pill" href="" role="tab" @click="mostrarVista('dependencia')"
                                    aria-controls="dependencias" aria-selected="false">Dependencias</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " id="custom-content-below-messages-tab" 
                                data-toggle="pill" href="" role="tab" @click="mostrarVista('cargo-calificado')"
                                aria-controls="custom-content-below-messages" aria-selected="true">Cargo Clasificados</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " id="custom-content-below-messages-tab" 
                                data-toggle="pill" href="" role="tab" @click="mostrarVista('cargo')"
                                aria-controls="custom-content-below-messages" aria-selected="true">Cargos</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="custom-content-below-settings-tab" 
                                data-toggle="pill" href="" role="tab" 
                                aria-controls="custom-content-below-settings" aria-selected="false">Ubigeo</a>
                            </li>
                        </ul>
                        <div class="tab-content container-fluid" id="content-tabcontent">
                            <unidad-organica v-show="entidad=='unidadorganica'"></unidad-organica>
                            <dependencia v-show="entidad == 'dependencia'"></dependencia>
                            <cargo v-show="entidad=='cargo'"></cargo>
                            <cargo-calificado v-show="entidad=='cargo-calificado'"></cargo-calificado>
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
            this.entidad='unidadorganica'          
        },
        data() {
            return {
                entidad:'unidadorganica'
            }
        },
        methods: {   
            mostrarVista(vista) {
                this.entidad=vista;
            },           
        }   
    }
</script>