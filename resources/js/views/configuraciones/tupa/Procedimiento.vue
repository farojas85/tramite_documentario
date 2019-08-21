<template>
    <div class="container-fluid">
        <div class="row mt-2">
            <div class="col-md-6">
                <button type="button" class="btn btn-primary btn-sm" @click="nuevo">
                    <i class="fas fa-plus"></i> Nueva Procedimiento 
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
                                <th>denominaci&oacute;n</th>                                              
                                <th>Acciones</th>
                            </tr>
                        </thead>
                         <tr v-show="total== 0">
                            <td colspan="3" class="text-center text-danger">
                                -- Datos No Registrados - Tabla Vacía --
                            </td>
                        </tr>
                        <tr v-show="total>0" v-for="proc in modelos.data" :key="proc.id">
                                <td class="text-center">{{ proc.id }}</td>
                                <td>{{ proc.denominacion }}</td>
                                <td>
                                    <button type="button" class="btn btn-success btn-circle"
                                        title="Mostrar Procedimiento" @click="mostrar(proc.id)">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button type="button" class="btn btn-warning btn-circle"
                                        title="Editar Procedimiento" @click="editar(proc.id)">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger btn-circle"
                                        title="Eliminar Procedimiento" @click="eliminar(proc.id)">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                    </table>
                </div>
                <pagination :data="modelos" @pagination-change-page="getResults"></pagination>
            </div>
        </div>
        <div class="modal fade" id="modal-procedimiento">
            <div class="modal-dialog ">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modal-procedimiento-title">Nuevo Procemiento</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form  @submit.prevent="validatesubmit">
                        <div class="modal-body" id="modal-procedimiento-body">
                            <input type="hidden" name="id" v-model="form.id" id="id">
                            <div class="form-group">
                                <textarea name="denominacion" id="denominacion" 
                                    v-model="form.denominacion" placeholder="Ingrese Denominación" 
                                    title="Denominación" class="form-control" 
                                    :class="{ 'is-invalid': form.errors.has('denominacion') }"
                                    rows="3"></textarea>
                                <has-error :form="form" field="denominacion"></has-error>
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
        },
        data() {
            return {
                crudmode:'',
                buscar:'',
                modelos:{},
                total:0,
                form: new form({
                    id:'',
                    denominacion:''
                })
            }
        },
        methods: {
            listar() {
                axios.get('/api/procedimiento').then(({ data }) => (this.modelos = data))
            },
            getResults(page=1) {
                axios.get('/api/procedimiento?page=' + page)
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
                this.crudmode = 'create'
                $('#modal-procedimiento-title').html('Nuevo Procediminto')
                $('#modal-procedimiento').modal('show')
            },
            cargarDatos(id,title) {
                axios.get('api/procedimiento/'+id)
                    .then( response => {
                        let model = response.data
                        this.form.id = model.id
                        this.form.denominacion = model.denominacion
                        $('#modal-procedimiento-title').html(title)
                        $('#modal-procedimiento').modal('show')
                    }).catch(error => {
                        this.$Progress.fail()
                        swal.fire('Error', `Ocurrió un Error: ${error.response.status}`,'error')
                    })
            },
            mostrar(id) {
                this.crudmode = 'show'
                this.cargarDatos(id,'Mostrar Procedimiento')
            },
            editar(id) {
                this.crudmode = 'update'
                this.cargarDatos(id,'Editar Procedimiento')
            },
            agregar() {
                this.$Progress.start()       
                this.form.post('api/procedimiento')
                .then((response) => {                    
                    $('#modal-procedimiento').modal('hide')
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
                this.form.put('api/procedimiento/'+this.form.id)
                .then((respuesta) => {
                    $('#modal-procedimiento').modal('hide')
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
                        this.form.delete('api/procedimiento/'+id)
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