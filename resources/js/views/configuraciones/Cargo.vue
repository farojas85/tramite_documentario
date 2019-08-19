<template>
    <div class="container-fluid">
        <div class="row mt-2">
            <div class="col-md-6">
                <button type="button" class="btn btn-primary btn-sm" @click="nuevo">
                    <i class="fas fa-plus"></i> Nuevo Cargo 
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
                                <th>Nombre Cargo</th>
                                <th>Cargo Clasificado</th>
                                <th>Dependencia</th>                                                 
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-show="total== 0">
                                <td colspan="5" class="text-center text-danger">
                                    -- Datos No Registrados - Tabla Vacía --
                                </td>
                            </tr>
                            <tr v-show="total>0" v-for="car in modelos.data" :key="car.id">
                                <td class="text-center">{{ car.id }}</td>
                                <td>{{ car.nombre_cargo }}</td>
                                <td v-bind:title="car.cargo_calificado.nombre">{{ car.cargo_calificado.abreviatura}}</td>
                                <td>{{ car.dependencia.nombre }}  </td>
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
        <div class="modal fade" id="modal-cargo">
            <div class="modal-dialog ">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modal-cargo-title">Nuevo Cargo</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form  @submit.prevent="validatesubmit">
                        <div class="modal-body" id="modal-cargo-body">
                            <input type="hidden" name="id" v-model="form.id" id="id">
                            <div class="form-group">
                                <input type="text" name="nombre_cargo" v-model="form.nombre_cargo" id="nombre_cargo"
                                    placeholder="Nombre de Cargo" title="Nombre de Cargo"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('nombre_cargo') }">
                                <has-error :form="form" field="nombre_cargo"></has-error>
                            </div>
                            <div class="form-group">
                                <input type="text" name="nominativo_interno" v-model="form.nominativo_interno" id="nominativo_interno"
                                    placeholder="Nominativo Interno" title="Nominativo Interno"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('nominativo_interno') }">
                                <has-error :form="form" field="nominativo_interno"></has-error>
                            </div>
                            <div class="form-group">
                                <select name="cargo_calificado_id" id="cargo_calificado_id"
                                    class="form-control" title="Cargo Calificado" 
                                    v-model="form.cargo_calificado_id" 
                                    :class="{ 'is-invalid': form.errors.has('cargo_calificado_id') }">
                                    <option value="">-Seleccione Cargo Clasificado-</option>
                                    <option v-for="cc in cargo_calificados" :key="cc.id" :value="cc.id">
                                        {{cc.abreviatura}} -> {{cc.nombre}}
                                    </option>
                                </select>
                                <has-error :form="form" field="cargo_calificado_id"></has-error>
                            </div>
                            <div class="form-group">
                                <select name="dependencia_id" id="dependencia_id"
                                    class="form-control" title="Unidad Orgánica" 
                                    v-model="form.dependencia_id" 
                                    :class="{ 'is-invalid': form.errors.has('dependencia_id') }">
                                    <option value="">-Seleccione Depedencia-</option>
                                    <option v-for="dep in dependencias" :key="dep.id" :value="dep.id">
                                        {{dep.nombre}}
                                    </option>
                                </select>
                                <has-error :form="form" field="dependencia_id"></has-error>
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
                modelos: {},
                dependencias:{},
                cargo_calificados:{},
                total:0,
                form : new form({
                    id:'',
                    nombre_cargo:'',
                    nominativo_interno:'',
                    dependencia_id:'',
                    cargo_calificado_id:'',
                    siglas:''
                })
            }
        },
        methods: {
            listar() {
                axios.get('/api/cargo').then(({ data }) => (this.modelos = data))
            },
            getResults(page=1) {
                axios.get('/api/cargo?page=' + page)
                    .then(response => {
                        this.modelos = response.data
                        this.total = this.modelos.total
                    });                
            },
            listarCargoCalificados() {
                axios.get('/api/cargocalificadolist').then(({ data }) => (this.cargo_calificados = data)) 
            },
            listarDependencia() {
                axios.get('/api/dependencialist').then(({ data }) => (this.dependencias = data)) 
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
                this.listarCargoCalificados()
                this.listarDependencia()
                $('#modal-cargo-title').html('Nuevo Cargo')
                $('#modal-cargo').modal('show')
            },
            cargarDatos(id,title) {
                axios.get('api/cargo/'+id)
                    .then( response => {
                        let model = response.data
                        this.form.id = model.id
                        this.form.nombre_cargo = model.nombre_cargo
                        this.form.nominativo_interno = model.nominativo_interno
                        this.form.siglas = model.siglas
                        this.form.dependencia_id = model.dependencia_id
                        this.form.cargo_calificado_id = model.cargo_calificado_id
                        $('#modal-cargo-title').html(title)
                        $('#modal-cargo').modal('show')
                    }).catch(error => {
                        this.$Progress.fail()
                        swal.fire('Error', `Ocurrió un Error: ${error.response.status}`,'error')
                    })
            },
            editar(id) {
                this.crudmode = 'update'
                this.listarDependencia()
                this.listarCargoCalificados();
                this.cargarDatos(id,'Editar Cargo')
            },
            mostrar(id) {
                this.crudmode = 'show'
                this.listarDependencia()
                this.listarCargoCalificados()
                this.cargarDatos(id,'Mostrar Cargo')
            },
            agregar() {
                this.$Progress.start()       
                this.form.post('api/cargo')
                .then((response) => {                    
                    $('#modal-cargo').modal('hide')
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
                this.form.put('api/cargo/'+this.form.id)
                .then((respuesta) => {
                    $('#modal-cargo').modal('hide')
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
                        this.form.delete('api/cargo/'+id)
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