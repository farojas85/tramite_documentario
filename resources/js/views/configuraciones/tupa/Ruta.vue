<template>
    <div class="container-fluid">
        <div class="row mt-2">
            <div class="col-md-6">
                <button type="button" class="btn btn-primary btn-sm" @click="nuevo">
                    <i class="fas fa-plus"></i> Nueva Ruta 
                </button>
            </div>
            <div class="col-md-6 text-right">
                <div class="input-group input-group-sm">
                    <input type="text" name="table-search" id="table-search"
                        class="form-control"  placeholder="Buscar...">
                    <div class="input-group-append">
                        <button type="button" class="btn btn-info">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-sm table-striped table-bordered table-hover">
                        <thead class="bg-dark">
                            <tr>
                                <th class="text-center">Id</th>
                                <th>Orden</th>
                                <th>Denominaci&oacute;n</th>
                                <th>Oficina Origen</th>
                                <th>Oficina Destino</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                         <tr v-show="total== 0">
                            <td colspan="6" class="text-center text-danger">
                                -- Datos No Registrados - Tabla Vacía --
                            </td>
                        </tr>
                        <tr v-show="total>0" v-for="ruta in modelos.data" :key="ruta.id">
                                <td class="text-center">{{ ruta.id }}</td>
                                <td>{{ ruta.orden }}</td>
                                <td :title="ruta.procedimiento.denominacion">{{ ruta.procedimiento.denominacion | subStr}}</td>
                                <td>{{ ruta.oficina_origen | subStr }}</td>
                                <td>{{ ruta.oficina_destino | subStr }}</td>
                                <td>
                                    <button type="button" class="btn btn-success btn-circle"
                                        title="Mostrar Ruta" @click="mostrar(ruta.id)">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button type="button" class="btn btn-warning btn-circle"
                                        title="Editar Ruta" @click="editar(ruta.id)">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger btn-circle"
                                        title="Eliminar Ruta" @click="eliminar(ruta.id)">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                    </table>
                </div>
                <pagination :data="modelos" @pagination-change-page="getResults"></pagination>
            </div>
        </div>
        <div class="modal fade" id="modal-ruta">
            <div class="modal-dialog ">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modal-ruta-title">Nueva Ruta</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form  @submit.prevent="validatesubmit">
                        <div class="modal-body" id="modal-ruta-body">
                            <input type="hidden" name="id" v-model="form.id" id="id">
                            <div class="form-group">
                                <select class="form-control" id="procedimiento_id" name="procedimiento_id"
                                    v-model="form.procedimiento_id" title="Seleccione Procedimiento"
                                    :class="{ 'is-invalid': form.errors.has('procedimiento_id') }">
                                    <option value="">-Seleccione Procedimiento-</option>
                                    <option v-for="proc in procedimientos" :key="proc.id" :value="proc.id">
                                        {{proc.denominacion}}
                                    </option>    
                                </select>
                                <has-error :form="form" field="procedimiento_id"></has-error>
                            </div>
                            <div class="form-group">
                                <input type="text" name="oficina_origen" id="oficina_origen" 
                                    v-model="form.oficina_origen" placeholder="Ingrese Oficina Origen" 
                                    title="Oficina Origen" class="form-control" 
                                    :class="{ 'is-invalid': form.errors.has('oficina_origen') }">
                                <has-error :form="form" field="oficina_origen"></has-error>
                            </div>
                            <div class="form-group">
                                <input type="text" name="oficina_destino" id="oficina_destino" 
                                    v-model="form.oficina_destino" placeholder="Ingrese Oficina Destino" 
                                    title="Oficina Destibo" class="form-control" 
                                    :class="{ 'is-invalid': form.errors.has('oficina_destino') }">
                                <has-error :form="form" field="oficina_destino"></has-error>
                            </div>
                            <div class="form-group">
                                <input type="number" name="orden" id="orden" 
                                    v-model="form.orden" placeholder="Ingrese Orden" 
                                    title="Orden" class="form-control" min="1"
                                    :class="{ 'is-invalid': form.errors.has('orden') }">
                                <has-error :form="form" field="orden"></has-error>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">
                                <i class="fas fa-times"></i> Cerrar
                            </button>
                            <span v-if="crudmode!='show'">
                                <button type="submit" class="btn btn-success">
                                    <span v-if="crudmode=='create'"><i class="fas fa-save"></i> Guardar</span>
                                    <span v-else-if="crudmode=='update'"><i class="fas fa-sync-alt"></i> Actualizar</span>
                                </button>
                            </span>
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
            this.listar()
            this.getResults()
            this.listarProcedimiento()
        },
        data() {
            return {
                crudmode:'',
                buscar:'',
                modelos:{},
                procedimientos:{},
                total:0,
                form: new form({
                    id:'',
                    oficina_origen:'',
                    oficina_destino:'',
                    orden:0,
                    procedimiento_id:''
                })
            }
        },
        methods: {
            listarProcedimiento() {
                axios.get('/api/procedimientoLista').then(({ data }) => (this.procedimientos = data))
            },
            listar() {
                axios.get('/api/ruta').then(({ data }) => (this.modelos = data))
            },
            getResults(page=1) {
                axios.get('/api/ruta?page=' + page)
                    .then(response => {
                        this.modelos = response.data
                        this.total = this.modelos.total
                    });                
            },
            validatesubmit() {
                switch(this.crudmode) {
                    case 'create':this.agregar();break;
                    case 'update':this.actualizar();break;
                }
            },
            limpiar() {
                this.form.clear()
                this.form.reset()
            },
            nuevo() {
                this.limpiar()
                this.listarProcedimiento()
                this.crudmode = 'create'
                $('#modal-ruta-title').html('Nueva Ruta')
                $('#modal-ruta').modal('show')
            },
            cargarDatos(id,title) {
                axios.get('api/ruta/'+id)
                    .then( response => {
                        let model = response.data
                        this.form.fill(model)
                        $('#modal-ruta-title').html(title)
                        $('#modal-ruta').modal('show')
                    }).catch(error => {
                        this.$Progress.fail()
                        swal.fire('Error', `Ocurrió un Error: ${error.response.status}`,'error')
                    })
            },
            mostrar(id) {
                this.crudmode = 'show'
                this.cargarDatos(id,'Mostrar Ruta')
            },
            editar(id) {
                this.crudmode = 'update'
                this.cargarDatos(id,'Editar Ruta')
            },
            agregar() {
                this.$Progress.start()       
                this.form.post('api/ruta')
                .then((response) => {                    
                    $('#modal-ruta').modal('hide')
                    toast.fire({type:'success',title:'Datos Registrados Satisfactoriamente'})
                    this.listar()
                    this.getResults()
                    this.$Progress.finish()
                })
                .catch(error => {
                    this.$Progress.fail()
                    if(error.response.status == 422) {
                        console.clear() 
                    }
                    else {
                        swal.fire('Error', `Ocurrió un Error: ${error.response.status}`,'error')
                    }                    
                })
            },
            actualizar() {
                this.$Progress.start()  
                this.form.put('api/ruta/'+this.form.id)
                .then((respuesta) => {
                    $('#modal-ruta').modal('hide')
                    toast.fire({type:'success',title:'Datos Modificados Satisfactoriamente'})
                    this.listar()
                    this.getResults()
                    this.$Progress.finish()
                })
                .catch(error => {
                    this.$Progress.fail()
                    if(error.response.status == 422) {
                        console.clear()   
                    }
                    else {
                        swal.fire('Error', `Ocurrió un Error: ${error.response.status}`,'error')
                    }  
                })
            },
            eliminar(id) {
                swal.fire({
                    title:"¿Está Seguro de Eliminar?",
                    text:'No podrás revertirlo',
                    type:"question",
                    showCancelButton: true,
                    confirmButtonText:"Si",
                    confirmButtonColor:"#38c172",
                    cancelButtonText:"No",
                    cancelButtonColor:"#e3342f"
                }).then( response => {
                    this.$Progress.start()
                    if(response.value){
                        this.form.delete('api/ruta/'+id)
                        .then( (respuesta) => {
                            toast.fire({type:'success',title:'Registro Eliminado Satisfactoriamente'})
                            this.listar()
                            this.getResults()
                            this.$Progress.finish()
                        })
                        .catch( error => {
                            this.$Progress.fail()
                            if(error.response.status == 422) {
                                console.clear()
                            }
                            else {
                                swal.fire('Error', `Ocurrió un Error: ${error.response.status}`,'error')
                            }                            
                        })                       
                    }
                }).catch(error => {
                    this.$Progress.fail()
                    swal.showValidationError(
                        `Ocurrió un Error: ${error.response.status}`
                    )
                })   
            }
        }
    }
</script>