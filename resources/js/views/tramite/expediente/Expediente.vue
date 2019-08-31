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
                                            <td class="text-center text-danger" colspan="6">-- Datos No Registrados - Tabla Vacía--</td>
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
                                                    class="btn btn-warning btn-sm" @click="movimiento(exp.id)">
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
        <div class="modal fade" id="modal-movimiento">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modal-movimiento-title">Registrar Movimiento de Expediente</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="validatesubmit" >
                        <div class="modal-body" id="modal-movimiento-body">
                            <input type="hidden" name="id" v-model="movInterno.id" id="id">
                            <div class="form-group">
                                <select name="unidad_destino" id="unidad_destino"
                                    class="form-control" title="Unidad Orgánica" 
                                    v-model="movInterno.unidad_destino" 
                                    :class="{ 'is-invalid': movInterno.errors.has('unidad_destino') }" 
                                    @change="seleccionar_dependencia($event)">
                                    <option value="">-Seleccione Unidad Orgánica-</option>
                                    <option v-for="uo in UnidadOrganicas" :key="uo.id" :value="uo.id">
                                        {{uo.nombre}}
                                    </option>
                                </select>
                                <has-error :form="movInterno" field="unidad_destino"></has-error>
                            </div>
                            <div class="form-group">
                                <select name="dependencia_destino" id="dependencia_destino"
                                    class="form-control" title="Dependencia Destino" 
                                    v-model="movInterno.dependencia_destino" 
                                    :class="{ 'is-invalid': movInterno.errors.has('dependencia_destino') }"
                                    @click="seleccionar_cargos($event)">
                                    <option value="">-Seleccione Dependencia-</option>
                                    <option v-for="dep in dependencias" :key="dep.id" :value="dep.id">
                                        {{dep.nombre}}
                                    </option>
                                </select>
                                <has-error :form="movInterno" field="dependencia_destino"></has-error>
                            </div>
                            <div class="form-group">
                                <select name="cargo_destino" id="cargo_destino"
                                    class="form-control" title="Cargo Destino" 
                                    v-model="movInterno.cargo_destino" 
                                    :class="{ 'is-invalid': movInterno.errors.has('cargo_destino') }">
                                    <option value="">-Seleccione Cargo-</option>
                                    <option v-for="car in cargos" :key="car.id" :value="car.id">
                                        {{car.nominativo_interno}}
                                    </option>
                                </select>
                                <has-error :form="movInterno" field="cargo_destino"></has-error>
                            </div>
                            <div class="form-group row">
                                <div class="table-responsive">
                                    <table class="table table-hover table-striped table-bordered table-sm">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th class="text-white text-center" width="10px">Sel.</th>
                                                <th class="text-white text-center">Motivo</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-show="total_motivos == 0" class="text-center text-danger">
                                                <td colspan="2">-- Motivos No Registrados --</td>
                                            </tr>
                                            <tr v-show="total_motivos >0" v-for="(mot,index) in motivos" :key="mot.id" >
                                                <td>
                                                    <input type="checkbox" :id="'motivo_id_'+mot.id" :name="'motivo_id_'+mot.id"
                                                            @change="seleccionar(index,mot.id,$event)" ></td>
                                                <td>{{ mot.motivo }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                             <button type="button" class="btn btn-danger" data-dismiss="modal">
                                <i class="fas fa-times"></i> Cerrar
                            </button>
                            <button type="submit" class="btn btn-success">
                                <span v-if="crudmode=='create'"><i class="fas fa-save"></i> Guardar</span>
                                <span v-else-if="crudmode=='update'"><i class="fas fa-sync-alt"></i> Actualizar</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>                    
    </div>
</template>

<script>
    export default {
        created() {
            this.listarUnidadOrganicas()
            this.listarDependencias()
            this.listarCargos()
            this.listarMotivos()
            this.listar()
        },
        data() {
            return {
                modocreate:false,
                buscar:'',
                expedientes:{},
                total:0,
                UnidadOrganicas:{},
                dependencias:{},
                cargos:{},
                motivos:{},
                total_motivos:0,
                unidad_seleccionada:{},
                motivo_id_eliminar:0,
                movInterno: new form({
                    id:'',
                    unidad_destino:'',
                    dependencia_destino:'',
                    cargo_destino:'',
                    motivo_id:[]
                })
            }
        },
        methods: {
            listarUnidadOrganicas() {
                 axios.get('api/unidadOrgListaMov').then(({ data }) => {
                     this.UnidadOrganicas = data;
                 })
            },
            listarDependencias() {
                axios.get('api/dependenciaListaMov').then(({ data }) => {
                     this.dependencias = data;
                 })
            },
            listarCargos() {
                axios.get('api/cargolist').then(({ data }) => {
                    this.cargos = data
                })
            },
            listarMotivos() {
                axios.get('api/motivoLista').then(({ data }) => {
                    this.motivos = data,
                    this.total_motivos=data.length
                })
            },
            listar() {
                axios.get('api/expediente').then(({ data }) => {
                    this.expedientes = data,
                    this.total = this.expedientes.total;
                })
            },           
            getResults() {

            },
            limpiar(){
                this.movInterno.reset()
                this.movInterno.clear()
            },
            nuevo() {
                this.modocreate=true
            },
            retornar() {
                this.modocreate=false
            },
            seleccionar_dependencia(event) {
                let id = event.target.value;
                axios.get('api/dependeciaid',{params:{id: id}}).then(({ data }) => {
                    this.dependencias = data;
                })
            },
            seleccionar_cargos(event) {
                let id = event.target.value
                axios.get('api/cargoid',{params:{id:id}}).then(({ data }) => {
                    this.cargos = data
                })
            },
            seleccionar(indice,id,event){
                let ev = event.target.checked;
                if(ev == true){        
                    this.movInterno.motivo_id.push(id)
                }
                else {
                   this.motivo_id_eliminar = id;
                   let indsel =-1;
                   this.movInterno.motivo_id.forEach(function(element,index){
                       if(element === id){
                           indsel = index
                       }
                   })
                   if(indsel !== -1) {
                       this.movInterno.motivo_id.splice(indsel,1)
                   }
                }            
            },
            movimiento(id){
                this.limpiar()
                $('#modal-movimiento').modal('show')
            }
        }
    }
</script>