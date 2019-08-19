<template>
    <div class="container-fluid">
        <div class="row mt-2">
            <div class="col-md-6">
                <button type="button" class="btn btn-primary btn-sm" @click="nuevo">
                    <i class="fas fa-plus"></i> Nuevo Cargo Clasificado
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
                                <th>Nombre</th>
                                <th>Abreviatura</th>                                              
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-show="total== 0">
                                <td colspan="4" class="text-center text-danger">
                                    -- Datos No Registrados - Tabla Vacía --
                                </td>
                            </tr>
                            <tr v-show="total>0" v-for="car in modelos.data" :key="car.id">
                                <td class="text-center">{{ car.id }}</td>
                                <td>{{ car.nombre }}</td>
                                <td>{{ car.abreviatura }}  </td>
                                <td>
                                    <button type="button" class="btn btn-success btn-circle"
                                        title="Mostrar Unidad Orgánica" @click="mostrar(car.id)">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button type="button" class="btn btn-warning btn-circle"
                                        title="Editar Unidad Orgánica" @click="editar(car.id)">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger btn-circle"
                                        title="Eliminar Unidad Orgánica" @click="eliminar(car.id)">
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
        <div class="modal fade" id="modal-cargo-calificado">
            <div class="modal-dialog ">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modal-cargo-calificado-title">Nuevo Cargo</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form  @submit.prevent="validatesubmit">
                        <div class="modal-body" id="modal-cargo-calificado-body">
                            <input type="hidden" name="id" v-model="form.id" id="id">
                            <div class="form-group">
                                <input type="text" name="nombre" v-model="form.nombre" id="nombre"
                                    placeholder="Nombre de Cargo Clasificado" title="Nombre de Cargo Clasificado"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('nombre') }">
                                <has-error :form="form" field="nombre"></has-error>
                            </div>
                            <div class="form-group">
                                <input type="text" name="abreviatura" v-model="form.abreviatura" id="abreviatura"
                                    placeholder="Abreviatura" title="Abreviatura"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('abreviatura') }">
                                <has-error :form="form" field="abreviatura"></has-error>
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
                modelos:'',
                form: new form({
                    id:'',
                    nombre:'',
                    abreviatura:''
                }),
                total:0
            }
        },
        methods: {
            listar() {
                axios.get('/api/cargocalificado').then(({ data }) => (this.modelos = data))
            },
            getResults(page=1) {
                 axios.get('/api/cargocalificado?page=' + page)
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
                $('#modal-cargo-calificado-title').html('Nuevo Cargo Clasificado')
                $('#modal-cargo-calificado').modal('show')
            },
            cargarDatos(id,title) {
                this.limpiar()
                axios.get('api/cargocalificado/'+id)
                    .then( response => {
                        let model = response.data
                        this.form.id = model.id
                        this.form.nombre = model.nombre
                        this.form.abreviatura = model.abreviatura
                        $('#modal-cargo-calificado-title').html(title)
                        $('#modal-cargo-calificado').modal('show')
                    }).catch(error => {
                        this.$Progress.fail()
                        swal.fire('Error', `Ocurrió un Error: ${error.response.status}`,'error')
                    })
            },
            mostrar(id) {
                this.crudmode = 'show'
                this.cargarDatos(id,'Mostrar Cargo Clasificado')
            },
            editar(id) {
                this.crudmode = 'update'
                this.cargarDatos(id,'Editar Cargo Clasificado')
            },
            agregar() {
                this.$Progress.start()       
                this.form.post('api/cargocalificado')
                .then((response) => {                    
                    $('#modal-cargo-calificado').modal('hide')
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
                this.form.put('api/cargocalificado/'+this.form.id)
                .then((respuesta) => {
                    $('#modal-cargo-calificado').modal('hide')
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
                        this.form.delete('api/cargocalificado/'+id)
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