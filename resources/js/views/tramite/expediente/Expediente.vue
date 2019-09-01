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
                                            <td v-show="exp.estado == 'Derivado'">
                                                <span class="badge bg-warning">{{ exp.estado }}</span>
                                            </td>
                                            <td v-show="exp.estado == 'Proceso'">
                                                <span class="badge bg-primary">{{ exp.estado }}</span>
                                            </td>
                                            <td v-show="exp.estado == 'Terminado'">
                                                <span class="badge bg-success">{{ exp.estado }}</span>
                                            </td>
                                            <td v-show="exp.estado == 'Archivado'">
                                                <span class="badge bg-info">{{ exp.estado }}</span>
                                            </td>
                                            <td>
                                                <button v-if="exp.estado != 'Terminado' "
                                                    class="btn btn-warning btn-sm" @click="movimiento_internos(exp.id)"
                                                    title="Enviar Movimiento Interno">
                                                    <i class="fas fa-paper-plane"></i>
                                                </button>
                                                <button v-show="exp.movimientos"
                                                    class="btn btn-primary btn-sm" @click="verMovimientos(exp.id)"
                                                    title="Ver Movimientos" >
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>                       
                    </div>
                    <div class="card-footer">
                        <pagination :data="expedientes" @pagination-change-page="getResults"></pagination>
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
        <div class="modal fade" id="modal-movimiento-interno">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modal-movimiento-interno-title">Registrar Movimiento de Expediente</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="movimientoSubmit" >
                        <div class="modal-body" id="modal-movimiento-interno-body">
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
        <div class="modal fade" id="modal-movimiento">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modal-movimiento-title">Mostrar Movimientos del Expediente</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form >
                        <div class="modal-body" id="modal-movimiento-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title">Movimiento</h3>
                                        <!-- /.card-tools -->
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body" v-show="mostrarMovimientos">

                                        <div class="form-group row">
                                            <label for="movimiento_tipo" class="col-form-label col-md-3">Tipo:</label>
                                            <div class="col-md-9">
                                                <input type="text" id="movimiento_tipo" class="form-control"
                                                  v-model="mostrarMovimientos.movimientos.movimiento_tipo" readonly >
                                            </div>

                                        </div>
                                        <div class="form-group row">
                                            <label for="unidad_desc" class="col-form-label col-md-3">Unidad:</label>
                                            <div class="col-md-9">
                                                <textarea name="unidad_desc" id="unidad_desc" rows="2" 
                                                    class="form-control" v-model="mostrarMovimientos.movimientos.unidad_desc" readonly ></textarea>
                                                  
                                            </div>

                                        </div>
                                        <div class="form-group row">
                                            <label for="dependencia_desc" class="col-form-label col-md-3">Dependencia:</label>
                                            <div class="col-md-9">
                                                <textarea name="dependencia_desc" id="dependencia_desc" rows="2" 
                                                    class="form-control" v-model="mostrarMovimientos.movimientos.dependencia_desc" readonly ></textarea>
                                                  
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="dependencia_desc" class="col-form-label col-md-3">Estado:</label>
                                            <div class="col-md-9">
                                                <span v-show="mostrarMovimientos.estado=='Pendiente'" class="badge bg-danger">
                                                    {{ mostrarMovimientos.estado}}
                                                </span>
                                                <span v-show="mostrarMovimientos.estado=='Derivado'" class="badge bg-warning">
                                                    {{ mostrarMovimientos.estado}}
                                                </span>
                                                <span v-show="mostrarMovimientos.estado=='Proceso'" class="badge bg-primary">
                                                    {{ mostrarMovimientos.estado}}
                                                </span>
                                                <span v-show="mostrarMovimientos.estado=='Terminado'" class="badge bg-success">
                                                    {{ mostrarMovimientos.estado}}
                                                </span>
                                                  
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card card-success">
                                        <div class="card-header">
                                            <h3 class="card-title">Motivos Movimientos</h3>
                                        </div>
                                        <div class="card-body">
                                            <div class="form-group row">
                                                <div class="table-responsive">
                                                    <table class="table table-sm table-bordered">
                                                        <thead class="thead-dark">
                                                            <th class="text-center text-white">Id</th>
                                                            <th class="text-center text-white">Motivos</th>
                                                        </thead>
                                                        <tbody>
                                                            <tr v-show="!mostrarMovimientos.motivos">
                                                                <td class="text-center" colspan="2"> -- Motivos No registrados--</td>
                                                            </tr>
                                                            <tr v-show="mostrarMovimientos.motivos" v-for="mot in mostrarMovimientos.motivos" :key="mot.id">
                                                                <td>{{ mot.id }}</td>
                                                                <td>{{ mot.motivo }}</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card card-warning">
                                        <div class="card-header">
                                            <h3 class="card-title">Movimientos Internos</h3>
                                        </div>
                                        <div class="card-body">
                                           <div class="table-responsive">
                                               <table class="table table-sm table-bordered">
                                                   <thead class="thead-dark">
                                                       <tr>
                                                           <th class="text-center text-white">Id</th>
                                                           <th class="text-center text-white">Unidad Destino</th>
                                                           <th class="text-center text-white">Dependendia Destino</th>
                                                           <th class="text-center text-white">Cargo Destino</th>
                                                           <th class="text-center text-white">Fecha Creada</th>
                                                       </tr>
                                                   </thead>
                                                   <tbody>
                                                       <tr v-for="mi in mostrarMovimientos.movimientoInternos" :key="mi.id">
                                                           <td>{{ mi.id }}</td>
                                                           <td>{{ mi.unidad_destino }}</td>
                                                           <td>{{ mi.dependencia_destino }}</td>
                                                           <td>{{ mi.cargo_destino }}</td>
                                                           <td>{{ mi.created_at | miFicha}}</td>
                                                       </tr>
                                                   </tbody>
                                               </table>
                                           </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">
                                <i class="fas fa-times"></i> Cerrar
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
            this.getResults()
        },
        data() {
            return {
                crudmode:'',
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
                    expediente_id:'',
                    movimiento_id:'',
                    unidad_destino:'',
                    dependencia_destino:'',
                    cargo_destino:'',
                    motivo_id:[]
                }),
                mostrarMovimientos:{
                    movimientos:{
                        id:'',
                        estado_actual:'',
                        unidad_origen:'',
                        unidad_desc:'',
                        dependencia_origen:'',
                        dependencia_desc:'',
                        tipo_movimiento_id:'',
                        movimiento_tipo:''
                    },
                    motivos:{},
                    movimientoInternos:{},
                    estado:''
                }
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
            getResults(page=1) {
                // Using vue-resource as an example
                axios.get('api/expediente?page=' + page)
                    .then(response => {
                        this.expedientes = response.data
                        //this.total = this.expedientes.total
                    });
            },
            limpiar(){
                this.movInterno.reset()
                this.movInterno.clear()
                this.desmarcar()
            },
            desmarcar() {
                let checkboxes = document.getElementsByTagName('input');
                for(let i=0;i<checkboxes.length;i++) //recoremos todos los controles
                {
                    if(checkboxes[i].type == "checkbox") //solo si es un checkbox entramos
                    {
                        checkboxes[i].checked=false; //si es un checkbox le damos el valor del checkbox que lo llamó (Marcar/Desmarcar Todos)
                    }
                }
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
            movimiento_internos(id){
                this.crudmode='create'
                this.limpiar()

                axios.get('api/movExpeditente',{params:{ id:id}})
                    .then(({ data }) => {
                        this.movInterno.movimiento_id = data.id
                        this.movInterno.expediente_id = data.expediente_id
                    })
                $('#modal-movimiento-interno').modal('show')
            },
            movimientoSubmit() {
                this.$Progress.start()
                this.movInterno.post('api/movimiento_interno').then( response => {
                    if(response.data.mensaje !='') {
                        $('#modal-movimiento-interno').modal('hide')
                        toast.fire({type:'success',title:response.data.mensaje})
                        this.$Progress.finish()
                    }
                }).catch(error => {
                    this.$Progress.fail()
                    if(error.response.status == 422) {
                        console.clear() 
                    }
                    else {
                        swal.fire('Error', `Ocurrió un Error: ${error.response.status}`,'error')
                    }
                    
                })
            },
            verMovimientos(id){
                let idtipomov=''
                axios.get('api/expediente/'+id).then(({data}) => {
                    this.mostrarMovimientos.estado = data.estado
                    this.mostrarMovimientos.movimientos.tipo_movimiento_id = data.movimientos[0].tipo_movimiento_id
                    this.mostrarMovimientos.movimientos.estado_actual = data.movimientos[0].estado_actual
                    this.mostrarMovimientos.movimientos.unidad_origen = data.movimientos[0].unidad_origen
                    this.mostrarMovimientos.movimientos.dependencia_origen = data.movimientos[0].dependencia_origen
                    this.mostrarMovimientos.movimientos.id = data.movimientos[0].id

                    idtipomov = data.movimientos[0].tipo_movimiento_id
                    axios.get('api/tipomovMostrar', { params:{idtipomov :idtipomov}}).then(({ data}) => {
                        this.mostrarMovimientos.movimientos.movimiento_tipo = data.descripcion
                    })

                    axios.get('api/unidadorganica/'+this.mostrarMovimientos.movimientos.unidad_origen)
                    .then(({ data }) => {
                       this.mostrarMovimientos.movimientos.unidad_desc = data.nombre;
                    })

                    axios.get('api/dependencia/'+this.mostrarMovimientos.movimientos.dependencia_origen)
                    .then(({ data }) => {
                        this.mostrarMovimientos.movimientos.dependencia_desc = data.nombre
                    })

                    axios.get('api/movMotivos/',{ params: {id :this.mostrarMovimientos.movimientos.id }})
                    .then(({ data }) => {
                        this.mostrarMovimientos.motivos = data.motivos
                    })
                    axios.get('api/movmovInterno',{params:{ movimiento_id : this.mostrarMovimientos.movimientos.id}})
                    .then(({ data })=> {
                        this.mostrarMovimientos.movimientoInternos = data;
                        console.log(data)
                    })
                   
                })            
               
                $('#modal-movimiento').modal('show')
            }
        }
    }
</script>