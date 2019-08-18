<template>
    <div class="container-fluid">
        <div class="row mt-2">
            <div class="col-md-6">
                <button type="button" class="btn btn-primary btn-sm" @click="nuevo">
                    <i class="fas fa-plus"></i> Nueva Dependencia 
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
                                <th>Dependencia</th>
                                <th>Siglas</th>                                                 
                                <th>Unidad Org&aacute;nica</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-show="total== 0">
                                <td colspan="5" class="text-center text-danger">
                                    -- Datos No Registrados - Tabla Vacía --
                                </td>
                            </tr>
                            <tr v-show="total>0" v-for="dep in modelos.data" :key="dep.id">
                                <td class="text-center">{{ dep.id }}</td>
                                <td>{{ dep.nombre }}</td>
                                <td>{{ dep.siglas }}</td>
                                <td>{{ dep.unidad_organica.nombre }}  </td>
                                <td>
                                    <button type="button" class="btn btn-success btn-circle"
                                        title="Mostrar Unidad Orgánica" @click="mostrar(dep.id)">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button type="button" class="btn btn-warning btn-circle"
                                        title="Editar Unidad Orgánica" @click="editar(dep.id)">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger btn-circle"
                                        title="Eliminar Unidad Orgánica" @click="eliminar(dep.id)">
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
        <div class="modal fade" id="modal-dependencia">
            <div class="modal-dialog ">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modal-dependencia-title">Nueva Dependencia</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form  @submit.prevent="validatesubmit">
                        <div class="modal-body" id="modal-create-body">
                            <input type="hidden" name="id" v-model="form.id" id="id">
                            <div class="form-group">
                                <select name="unidad_organica_id" id="unidad_organica_id"
                                    class="form-control" title="Unidad Orgánica" 
                                    v-model="form.unidad_organica_id" 
                                    :class="{ 'is-invalid': form.errors.has('unidad_organica_id') }">
                                    <option value="">-Seleccione Unidad Orgánica-</option>
                                    <option v-for="uo in unidad_organicas" :key="uo.id" :value="uo.id">
                                        {{uo.nombre}}
                                    </option>
                                </select>
                                <has-error :form="form" field="unidad_organica_id"></has-error>
                            </div>
                            <div class="form-group">
                                <input type="text" name="nombre" v-model="form.nombre" id="nombre"
                                    placeholder="Nombre de Dependencia" title="Nombre de Dependencia"
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
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        created() {
            this.listar()
            this.getResults()
            this.listarUnidadOrganica()
        },
        data() {
            return {
                crudmode:'',
                buscar:'',
                modelos: {},
                unidad_organicas:{},
                total:0,
                form : new form({
                    id:'',
                    nombre:'',
                    unidad_organica_id:'',
                    siglas:''
                })
            }
        },
        methods: {
            listar() {
                axios.get('/api/dependencia').then(({ data }) => (this.modelos = data))
            },
            getResults(page=1) {
                axios.get('/api/dependencia?page=' + page)
                    .then(response => {
                        this.modelos = response.data
                        this.total = this.modelos.total
                    });                
            },
            listarUnidadOrganica() {
                axios.get('/api/unidadorganicalist').then(({ data }) => (this.unidad_organicas = data)) 
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
                this.listarUnidadOrganica()
                $('#modal-dependencia-title').html('Nueva Dependencia')
                $('#modal-dependencia').modal('show')
            },
            cargarDatos(id,title) {
                axios.get('api/dependencia/'+id)
                    .then( response => {
                        let model = response.data
                        this.form.id = model.id
                        this.form.nombre = model.nombre
                        this.form.siglas = model.siglas
                        this.form.unidad_organica_id = model.unidad_organica_id
                        $('#modal-dependencia-title').html(title)
                        $('#modal-dependencia').modal('show')
                    }).catch(error => {
                        this.$Progress.fail()
                        swal.fire('Error', `Ocurrió un Error: ${error.response.status}`,'error')
                    })
            },
            editar(id) {
                this.crudmode = 'update'
                this.listarUnidadOrganica()
                this.cargarDatos(id,'Editar Depedencia')
            },
            mostrar(id) {
                this.crudmode = 'show'
                this.cargarDatos(id,'Mostrar Depedencia')
            },
            agregar() {
                this.$Progress.start()       
                this.form.post('api/dependencia')
                .then((response) => {                    
                    $('#modal-dependencia').modal('hide')
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
                this.form.put('api/dependencia/'+this.form.id)
                .then((respuesta) => {
                    $('#modal-dependencia').modal('hide')
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
                        this.form.delete('api/dependencia/'+id)
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