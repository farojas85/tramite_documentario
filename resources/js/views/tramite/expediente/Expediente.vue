<template>
    <div>
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Expedientes y Documentos</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/home">Home</a></li>
                        <li class="breadcrumb-item active">Trámite</li>
                        <li class="breadcrumb-item active">Expedientes</li>
                    </ol>
                </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content-header -->
        <section class="content">
            <div class="container-fluid"  v-show='modocreate==false'>
                <div class="card card-default color-palette-box">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-folder-open"></i> Listado Expedientes y Documentos
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <button type="button" class="btn btn-primary" @click="nuevo">
                                    <i class="fas fa-plus"></i> Nuevo Expediente
                                </button>
                            </div>
                            <div class="col-md-6 text-right">
                                <div class="input-group">
                                    <input type="text" name="table-search" id="table-search"
                                        class="form-control" v-model="buscar" placeholder="Buscar...">
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-info">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2" >
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-sm table-striped table-bordered table-hover">
                                        <thead class="bg-dark">
                                            <tr>
                                                <th>Id</th>
                                                <th>Fecha/Hora</th>
                                                <th>Expediente</th>
                                                <th>Asunto</th>
                                                <th>Estado</th>                                                    
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tr v-if="total == 0">
                                            <td class="text-center text-danger">-- Datos No Registrados - Tabla Vacía--</td>
                                        </tr>
                                        <tr v-else-if="total >=1" v-for="exp in expedientes.data" :key="exp.id">
                                            <td>{{ exp.id }}</td>
                                            <td>{{ exp.fecha }} {{ exp.hora }}</td>
                                            <td>{{ exp.cabecera }} {{ exp.numero_expediente }}</td>
                                            <td>{{ exp.documento.asunto }}</td>
                                            <td v-show="exp.estado == 'Pendiente'">
                                                <span class="badge bg-danger">{{ exp.estado }}</span>
                                            </td>
                                            <td>
                                                <button v-show="exp.estado == 'Pendiente'"
                                                    class="btn btn-warning btn-sm">
                                                    <i class="fas fa-paper-plane"></i> Enviar
                                                </button>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                       
                    </div>
                </div>
            </div>
            <div class="container-fluid" v-show="modocreate==true">
                <button type="button" class="btn btn-danger" @click="retornar">
                    <i class="fas fa-reply"></i> Retornar
                </button>
                <expediente-nuevo></expediente-nuevo>
            </div>
        </section>
    </div>
</template>

<script>
    export default {
        created() {
            this.listar();
        },
        data() {
            return {
                modocreate:false,
                buscar:'',
                expedientes:{},
                total:0
            }
        },
        methods: {
            listar() {
                axios.get('api/expediente').then(({ data }) => {
                    this.expedientes = data,
                    this.total = this.expedientes.total;
                })
            },
            getResults() {

            },
            nuevo() {
                this.modocreate=true
            },
            retornar() {
                this.modocreate=false
            },
          
        }
    }
</script>