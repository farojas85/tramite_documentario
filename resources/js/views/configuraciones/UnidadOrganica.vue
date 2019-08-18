<template>
    <div>
        <div class="row mt-2">
            <div class="col-md-6">
                <button type="button" class="btn btn-primary btn-sm" @click="nuevo">
                    <i class="fas fa-plus"></i> Nueva Unidad Org&aacute;nica
                </button>
            </div>
            <div class="col-md-6 text-right">
                <div class="input-group input-group-sm">
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
        <div class="row mt-2">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-sm table-striped table-bordered table-hover">
                        <thead class="bg-dark">
                            <tr>
                                <th class="text-center">Id</th>
                                <th>Unidad Org&aacute;nica</th>
                                <th>Siglas</th>                                                 
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-show="total== 0">
                                <td colspan="4" class="text-center text-danger">
                                    -- Datos No Registrados - Tabla Vacía --
                                </td>
                            </tr>
                            <tr v-show="total>0" v-for="uo in modelos.data" :key="uo.id">
                                <td class="text-center">{{ uo.id }}</td>
                                <td>{{ uo.nombre }}</td>
                                <td>{{ uo.siglas }}</td>
                                <td>
                                    <button type="button" class="btn btn-success btn-circle"
                                        title="Mostrar Unidad Orgánica" @click="mostrar(uo.id)">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button type="button" class="btn btn-warning btn-circle"
                                        title="Editar Unidad Orgánica" @click="editar(uo.id)">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger btn-circle"
                                        title="Eliminar Unidad Orgánica" @click="eliminar(uo.id)">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <pagination :data="modelos" @pagination-change-page="getResults"></pagination>
            </div>
        </div>
         <div class="modal fade" id="modal-table">
            <div class="modal-dialog ">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modal-table-title">Nueva Unidad Orgánica</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <form  @submit.prevent="validatesubmit">
                    <div class="modal-body" id="modal-create-body">
                        <input type="hidden" name="id" v-model="form.id" id="id">
                        <div class="form-group">
                            <input type="text" name="nombre" v-model="form.nombre" id="nombre"
                                placeholder="Nombre de Unidad Orgánica" title="Nombre de Unidad Orgánica"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('nombre') }">
                            <has-error :form="form" field="nombre"></has-error>
                        </div>
                        <div class="form-group">
                            <input type="text" name="siglas" v-model="form.siglas" id="siglas"
                                placeholder="Siglas" title="siglas de Unidad Orgánica"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('siglas') }">
                            <has-error :form="form" field="siglas"></has-error>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">
                            <i class="fas fa-times"></i> Close
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
                <!-- /.modal-content -->
            </div>
        <!-- /.modal-dialog -->
        </div>
    </div>
</template>

<script>
    export default {
        created() {
            this.listarUnidadOrganica()
            this.getResults()
        },
        data() {
            return {
                crudmode:'',
                buscar:'',
                modelos: {},
                total:0,
                form : new form({
                    id:'',
                    nombre:'',
                    siglas:''
                })
            }
        },
        methods: {
            getResults(page=1) {
                axios.get('/api/unidadorganica?page=' + page)
                    .then(response => {
                        this.modelos = response.data
                        this.total = this.modelos.total
                    });                
            },
            listarUnidadOrganica() {
                axios.get('/api/unidadorganica').then(({ data }) => (this.modelos = data))
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
                 $('#modal-table-title').html('Nueva Unidad Orgánica')
                $('#modal-table').modal('show')
            },
            agregar() {
                this.$Progress.start()       
                this.form.post('api/unidadorganica')
                .then((response) => {                    
                    $('#modal-table').modal('hide')
                    toast.fire({
                        type:'success',title:'Datos Registrados Satisfactoriamente'
                    })
                    this.listarUnidadOrganica()
                    this.getResults()
                    this.$Progress.finish()
                })
                .catch(error => {
                    if(error.response.status == 422) {
                        swal.fire('Error','Datos No Validados','error')    
                    }
                    else {
                        swal.fire('Error', `Ocurrió un Error: ${error.response.status}`,'error')
                    }
                    this.$Progress.fail()
                })
            },
            cargarDatos(id,title) {
                axios.get('api/unidadorganica/'+id)
                    .then( response => {
                        let model = response.data
                        this.form.id = model.id
                        this.form.nombre = model.nombre
                        this.form.siglas = model.siglas
                        $('#modal-table-title').html(title)
                        $('#modal-table').modal('show')
                    }).catch(error => {
                        swal.fire('Error', `Ocurrió un Error: ${error.status}`,'error')
                    })
            },
            mostrar(id) {
                this.crudmode = 'show'
                this.cargarDatos(id,'Mostar Unidad Orgánica')
            },
            editar(id) {
                this.crudmode='update'
                this.cargarDatos(id,'Editar Unidad Orgánica')
            },
            actualizar() {
                this.$Progress.start()  
                this.form.put('api/unidadorganica/'+this.form.id)
                    .then((respuesta) => {
                        swal.fire({
                                title:"Unidad Orgánica",
                                text:'Datos Modificados Satisfactoriamente',
                                type:"success",
                                confirmButtonColor:"#148f77",
                                confirmButtonText:"Aceptar"
                            }).then(response => {
                                if(response.value) {
                                    $('#modal-table').modal('hide')
                                    this.listarUnidadOrganica()
                                    this.getResults()
                                    this.$Progress.finish()
                                }                                    
                            })
                    })
                    .catch(error => {
                        if(error.response.status == 422) {
                            swal.fire('Error','Datos No Validados','error')    
                        }
                        else {
                            swal.fire('Error', `Ocurrió un Error: ${error.response.status}`,'error')
                        }
                        this.$Progress.fail()
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
                    if(response.value){
                        this.form.delete('api/unidadorganica/'+id).then( (respuesta) => {
                            this.$Progress.start()
                            swal.fire({
                                title:"Unidad orgánica",
                                text:'Registro Eliminado Satisfactoriamente',
                                type:"success",
                                confirmButtonColor:"#148f77",
                                confirmButtonText:"Aceptar"
                            }).then(response => {
                                if(response.value) {
                                    this.listarUnidadOrganica()
                                    this.getResults()
                                    this.$Progress.finish()
                                }                                    
                            })
                            .catch(error => {
                                this.$Progress.fail()
                                if(error.response.status == 422) {
                                    swal.fire('Error','Datos No Validados','error')    
                                }
                                else {
                                    swal.fire('Error', `Ocurrió un Error: ${error.response.status}`,'error')
                                }                                
                            })
                        })
                        .catch( error => {
                            this.$Progress.fail()
                            if(error.response.status == 422) {
                                swal.fire('Error','Datos No Validados','error')    
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