<template>
    <div class="container-fluid">
        <div class="row mt-2">
            <div class="col-md-6">
                <button type="button" class="btn btn-primary btn-sm" @click="nuevo">
                    <i class="fas fa-plus"></i> Nuevo Requisito 
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
                                <th>Requisito</th>
                                <th>Tipo Documento</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                         <tr v-show="total== 0">
                            <td colspan="4" class="text-center text-danger">
                                -- Datos No Registrados - Tabla Vacía --
                            </td>
                        </tr>
                        <tr v-show="total>0" v-for="req in modelos.data" :key="req.id">
                            <td class="text-center">{{ req.id }}</td>
                            <td>{{ req.descripcion }}</td>
                            <td>{{ req.tipo_documento.descripcion }}</td>
                            <td>
                                <button type="button" class="btn btn-success btn-circle"
                                    title="Mostrar requisito" @click="mostrar(req.id)">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button type="button" class="btn btn-warning btn-circle"
                                    title="Editar Requisito" @click="editar(req.id)">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-danger btn-circle"
                                    title="Eliminar Requisito" @click="eliminar(req.id)">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    </table>
                </div>
                <pagination :data="modelos" @pagination-change-page="getResults"></pagination>
            </div>
        </div>
        <div class="modal fade" id="modal-requisito">
            <div class="modal-dialog ">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modal-requisito-title">Nueva Ruta</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form  @submit.prevent="validatesubmit">
                        <div class="modal-body" id="modal-requisito-body">
                            <input type="hidden" name="id" v-model="form.id" id="id">
                            <div class="form-group">
                                <select class="form-control" id="tipo_documento_id" name="tipo_documento_id"
                                    v-model="form.tipo_documento_id" title="Seleccione Procedimiento"
                                    :class="{ 'is-invalid': form.errors.has('tipo_documento_id') }">
                                    <option value="">-Seleccione Tipo Documento-</option>
                                    <option v-for="tipo in tipo_documentos" :key="tipo.id" :value="tipo.id">
                                        {{ tipo.descripcion }}
                                    </option>    
                                </select>
                                <has-error :form="form" field="tipo_documento_id"></has-error>
                            </div>
                            <div class="form-group">
                                <textarea name="descripcion" id="descripcion" 
                                    v-model="form.descripcion" placeholder="Ingrese Descripción" 
                                    title="Descripción" class="form-control" rows='3' 
                                    :class="{ 'is-invalid': form.errors.has('descripcion') }"></textarea>
                                <has-error :form="form" field="descripcion"></has-error>
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
            this.listarTipoDocumentos()
            this.listar()
            this.getResults()
        },
        data() {
            return {
                crudmode:'',
                buscar:'',
                modelos:{},
                tipo_documentos:{},
                total:0,
                form: new form({
                    id:'',
                    descripcion:'',
                    tipo_documento_id:''
                })
            }
        },
        methods: {
            listarTipoDocumentos() {
                axios.get('api/tipoDocumentoLista').then(({data}) => (this.tipo_documentos = data))
            },
            listar() {
                axios.get('/api/requisito').then(({ data }) => (this.modelos = data))
            },
            getResults(page=1) {
                axios.get('/api/requisito?page=' + page)
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
                this.listarTipoDocumentos()
                this.crudmode = 'create'
                $('#modal-requisito-title').html('Nuevo Requisito')
                $('#modal-requisito').modal('show')
            },
            cargarDatos(id,title) {
                axios.get('api/requisito/'+id)
                    .then( response => {
                        let model = response.data
                        this.form.fill(model)
                        $('#modal-requisito-title').html(title)
                        $('#modal-requisito').modal('show')
                    }).catch(error => {
                        this.$Progress.fail()
                        swal.fire('Error', `Ocurrió un Error: ${error.response.status}`,'error')
                    })
            },
            mostrar(id) {
                this.crudmode = 'show'
                this.cargarDatos(id,'Mostrar Requisito')
            },
            editar(id) {
                this.crudmode = 'update'
                this.cargarDatos(id,'Editar Requisito')
            },
            agregar() {
                this.$Progress.start()       
                this.form.post('api/requisito')
                .then((response) => {                    
                    $('#modal-requisito').modal('hide')
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
                this.form.put('api/requisito/'+this.form.id)
                .then((respuesta) => {
                    $('#modal-requisito').modal('hide')
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
                        this.form.delete('api/requisito/'+id)
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