<template>
    <div>
         <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Solicitantes</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/home">Home</a></li>
                        <li class="breadcrumb-item active">Trámite</li>
                        <li class="breadcrumb-item active">Solicitante</li>
                    </ol>
                </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content-header -->
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Listado de Solicitanes</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <button type="button" class="btn btn-primary" @click="nuevo">
                                        <i class="fas fa-plus"></i> Agregar Solicitante
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
                            <div class="row mt-2">
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
                                            <tbody>
                                                 <tr v-show="total== 0">
                                                    <td colspan="6" class="text-center text-danger">
                                                        -- Datos No Registrados - Tabla Vacía --
                                                    </td>
                                                </tr>
                                                <tr v-show="total>0" v-for="sol in modelos.data" :key="sol.id">
                                                    <td class="text-center">{{ sol.id }}</td>
                                                    <td v-if="sol.documento_identidad_id == 3">{{ sol.persona.razon_social }}</td>
                                                    <td v-else>{{  sol.apellidos}} {{ sol.nombres }}</td>
                                                    <td>{{ sol.documento_identidad.descripcion_corta }}</td>
                                                    <td>{{ sol.numero_documento }}</td>
                                                    <td v-show="sol.solicitante.estado == 1"><span class="badge bg-success">Activo</span></td>
                                                    <td v-show="sol.solicitante.estado == 0"><span class="badge bg-dark">Inactivo</span></td>
                                                    <td>
                                                        <button type="button" class="btn btn-success btn-circle"
                                                            title="Mostrar Solicitante" @click="mostrar(sol.id)">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-warning btn-circle"
                                                            title="Editar Solicitante" @click="editar(sol.id)">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-danger btn-circle"
                                                            title="Eliminar Solicitante" @click="eliminar(sol.id)">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <pagination :data="modelos" @pagination-change-page="getResults"></pagination>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div class="modal fade" id="modal-solicitante">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modal-solicitante-title">Nuevo Solicitante</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form  @submit.prevent="validatesubmit">
                        <div class="modal-body" id="modal-solicitante-body">
                            <input type="hidden" name="id" v-model="form.id" id="id">
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <select class="form-control" id="documento_identidad_id" name="documento_identidad_id"
                                        v-model="form.persona.documento_identidad_id" title="Seleccione Documento Identidad"
                                        placeholder="seleccione Tipo Documento Identidad"
                                        :class="{ 'is-invalid': form.errors.has('documento_identidad_id') }">
                                        <option value="">-Seleccione Tipo Documento-</option>
                                        <option v-for="tipo in documento_identidads" :key="tipo.id" :value="tipo.id" :title="tipo.descripcion_larga">
                                            {{ tipo.descripcion_corta }}
                                        </option>    
                                    </select>
                                    <has-error :form="form" field="documento_identidad_id"></has-error>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" name="numero_documento" v-model="form.persona.numero_documento" id="numero_documento"
                                        placeholder="Número Documento de Identidad" title="Número de Documento de Identidad"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('numero_documento') }">
                                    <has-error :form="form" field="numero_documento"></has-error>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12" v-show="this.form.persona.documento_identidad_id == 3">
                                     <input type="text" name="razon_social" v-model="form.persona.razon_social" id="razon_social"
                                        placeholder="razon_social" title="razon_social"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('razon_social') }">
                                    <has-error :form="form" field="razon_social"></has-error>
                                </div>
                                <div class="col-md-6" v-show="this.form.persona.documento_identidad_id != 3">
                                     <input type="text" name="nombres" v-model="form.persona.nombres" id="nombres"
                                        placeholder="nombres" title="nombres"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('nombres') }">
                                    <has-error :form="form" field="nombres"></has-error>
                                </div>
                                <div class="col-md-6" v-show="this.form.persona.documento_identidad_id != 3">
                                     <input type="text" name="apellidos" v-model="form.persona.apellidos" id="apellidos"
                                        placeholder="apellidos" title="apellidos"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('apellidos') }">
                                    <has-error :form="form" field="apellidos"></has-error>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12">
                                     <input type="text" name="razon_social" v-model="form.persona.correo" id="correo"
                                        placeholder="Correo Electrónico" title="Correo Electrónico"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('correo') }">
                                    <has-error :form="form" field="correo"></has-error>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <input type="text" name="direccion" v-model="form.persona.direccion" id="direccion"
                                        placeholder="Ingrese Dirección" title="Dirección"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('direccion') }">
                                    <has-error :form="form" field="direccion"></has-error>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="estado" v-model="form.estado">
                                        <label class="form-check-label" for="estado">Activo</label>
                                    </div>

                                </div>
                                <div class="col-md-6">
                                     <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="eliminado" v-model="form.eliminado">
                                        <label class="form-check-label" for="eliminado">Eliminado</label>
                                    </div>
                                </div>
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
            this.obtenerTipoDocumentos()
            this.listar()
            this.getResults()
        },
        data() {
            return {
                crudmode:'',
                form: new form({
                    id:'',
                    persona_id:'',
                    persona:{
                        documento_identidad_id:'',
                        numero_documento:'',
                        nombres:'',
                        apellidos:'',
                        razon_social:'',
                        correo:'',
                        direccion:''
                    },
                    estado:1,
                    eliminado:0,
                }),
                modelos:{},
                solicitante:{},
                buscar:'',
                documento_identidads:{},
                tipo_documento_seleccionado:'',
                total:0
            }
        },
        methods: {
            listar() {
                axios.get('api/solicitante').then(({ data }) => (this.modelos =data))
            },
            getResults(page=1) {
                // Using vue-resource as an example
                axios.get('/api/solicitante?page=' + page)
                    .then(response => {
                        this.modelos = response.data,
                        this.total = this.modelos.total
                    });
            },
            obtenerTipoDocumentos() {
                axios.get('api/documentoIdentidadList')
                .then(({data})=>(
                    this.documento_identidads = data
                ))
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
                this.obtenerTipoDocumentos()
                this.crudmode = 'create'
                $('#modal-solicitante-title').html('Nuevo Solicitante')
                $('#modal-solicitante').modal('show')
            },
            agregar() {
                this.$Progress.start()       
                this.form.post('api/solicitante')
                .then((response) => {         
                    console.log(response.data)           
                    $('#modal-solicitante').modal('hide')
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

            }
            
        
        }
    }
</script>