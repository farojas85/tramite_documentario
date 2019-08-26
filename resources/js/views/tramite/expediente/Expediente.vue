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
            <div class="container-fluid">
                <div class="card card-default color-palette-box">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-folder-open"></i> Listado Expedientes y Documentos
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="row" v-show="modocreate==false">
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
                        <div class="row mt-2" v-show="modocreate==false">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-sm table-striped table-bordered table-hover">
                                        <thead class="bg-dark">
                                            <tr>
                                                <th>Id</th>
                                                <th>Solicitante</th>
                                                <th>Tipo Documento</th>
                                                <th>Documento Número</th>
                                                <th>Estado</th>                                                    
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                         <div class="row" v-show="modocreate==true">
                            <div class="col-md-6">
                                <button type="button" class="btn btn-danger" @click="retornar">
                                    <i class="fas fa-reply"></i> Retornar
                                </button>
                                <button type="button" class="btn btn-success" @click="guardar">
                                    <i class="fas fa-save"></i> Guardar
                                </button>
                            </div>
                        </div>
                        <div class="row mt-2" v-show="modocreate==true">
                            <expediente-nuevo></expediente-nuevo>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                modocreate:false,
                buscar:''
            }
        },
        methods: {
            nuevo() {
                this.modocreate=true
            },
            retornar() {
                this.modocreate=false
            },
            guardar() {

            }
        }
    }
</script>