<template>
    <div class="container-fluid">
        <div class="row mt-2">
            <div class="col-md-6">
                <button type="button" class="btn btn-success btn-sm" @click="nuevo">
                    <i class="fas fa-plus"></i> Nuevo Procedimiento-Requisito 
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
            <div class="col-md-5">
                <div class="card card-primary" style="border: 1px #3490dc solid">
                    <div class="card-header">
                        <h3 class="card-title">Procedimientos</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm table-bordered table-hover">
                            <thead class="bg-dark">
                                <tr>
                                    <th class="text-center">Id</th>
                                    <th>Procedimiento</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tr v-show="total_procedimiento== 0">
                                <td colspan="3" class="text-center text-danger">
                                    -- Datos No Registrados - Tabla Vacía --
                                </td>
                            </tr>
                            <tr v-show="total_procedimiento>0" 
                                v-for="proc in procedimientos.data" :key="proc.id"
                                class="mouse-pointer" 
                                @click="selecccionarProcedimiento(proc.id)">
                                <td class="text-center">{{ proc.id }}</td>
                                <td>{{ proc.denominacion }}</td>
                                <td>
                                    <i class="fas fa-eye text-red"></i>
                                </td>
                            </tr>
                        </table>
                        <pagination :data="procedimientos" @pagination-change-page="getResultsProcedimientos"></pagination>
                    </div>                
                </div>
            </div>
            <div class="col-md-7">
                <div class="card card-danger" style="border: 1px #e3342f solid"> 
                    <div class="card-header">
                        <h3 class="card-title">Requisitos</h3>
                    </div>
                    <div class="card-body">
                        <span v-show="procedimiento_seleccionado==-1">
                            <h5 class="text-blue text-center">--Seleccione un Procedimiento--</h5>
                            <h6 class="text-success text-center">-- Se Mostrará Los Requisitos del Procedimiento --</h6>
                        </span>
                        <span v-show="procedimiento_seleccionado>0">
                            <div class="form-group row">
                                <h6 class="text-blue" ><b>{{ procedimiento_requisitos.denominacion}}</b></h6>
                            </div>
                            <span v-if="procedimiento_requisitos.requisitos && procedimiento_requisitos.requisitos.length >=1 ">
                                <div  v-for="req in procedimiento_requisitos.requisitos" :key="req.id">
                                    <div class="form-group row" >
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="requisito_id[]" checked >
                                            <label class="form-check-label">{{ req.descripcion }}</label>
                                        </div>
                                    </div>                                        
                                </div>
                                <div class="form-group text-center">
                                    <!-- <button type="submit" class="btn btn-success">
                                        <i class="fas fa-sync-alt"></i> Editar
                                    </button> -->
                                </div>
                            </span>
                            <span v-else >
                                <div class="form-group text-center text-orange">
                                    -- Requisitos no Registrados --
                                </div>
                            </span>                                    
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modal-proc-requisito">
            <div class="modal-dialog modal-lg ">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modal-proc-requisito-title">Nueva Ruta</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form  @submit.prevent="guardarSeleccionados">
                        <div class="modal-body" id="modal-proc-requisito-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <select class="form-control" id="procedimiento_id" name="procedimiento_id"
                                            v-model="form.procedimiento_id" title="Seleccione Procedimiento"
                                            :class="{ 'is-invalid': form.errors.has('procedimiento_id') }">
                                            <option value="">-Seleccione Procedimiento-</option>
                                            <option v-for="proce in procedimiento_nuevos" :key="proce.id" :value="proce.id">
                                                {{ proce.denominacion }}
                                            </option> 
                                        </select>
                                        <has-error :form="form" field="procedimiento_id"></has-error>
                                    </div>
                                    <div class="input-group">
                                        <select class="form-control" id="requisito_id" name="requisito_id"
                                            v-model="requisito_seleccionado" title="Seleccione Procedimiento"
                                            :class="{ 'is-invalid': form.errors.has('requisito_id') }">
                                            <option value="">-Seleccione requisito-</option>
                                            <option v-for="requ in requisitos" :key="requ.id" :value="requ">
                                                {{ requ.descripcion }}
                                            </option> 
                                        </select>
                                        <div class="input-group-append">
                                            <button type="button"  class="btn btn-info" title="Añadir Requisito" @click="anadirSeleccionado()">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                        <has-error :form="form" field="requisito_id"></has-error>
                                    </div>
                                    <div class="form-group">
                                        
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-sm table-bordered">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>#</th>
                                                <th>Requisito</th>
                                                <th>Acci&oacute;n</th>
                                            </tr>                    
                                        </thead>
                                        <tbody>
                                            <tr v-if="requisitos_seleccionados.length <1">
                                                <td colspan="3" class="text-center text-danger"> -- Requisitos No Seleccionados -- </td>
                                            </tr>                        
                                            <tr v-for="(rs,index) in requisitos_seleccionados" :key="rs.id">
                                                <td>{{ rs.id }}</td>
                                                <td>{{ rs.descripcion }}</td>
                                                <td>
                                                    <button class="btn btn-danger btn-sm" @click="eliminarRequisitoSeleccionado(index,rs.id)">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
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
            this.listarProcedimientos()
            this.getResultsProcedimientos()
            this.listarRequisitos()
        },
        data() {
            return {
                crudmode:'',
                buscar:'',
                modelos:{},
                requisitos:{},
                procedimientos:{},
                procedimiento_seleccionado:-1,
                total_procedimiento:0,
                tota_requisito_select:0,
                form: new form({
                    id:'',
                    requisito_id:[],
                    procedimiento_id:''
                }),
                procedimiento_requisitos:{},
                procedimiento_nuevos:{},
                requisito_seleccionado:{},
                requisitos_seleccionados:[]
            }
        },
        methods: { 
            listarRequisitos() {
                axios.get('/api/requisitoLista').then(({data}) => (
                    this.requisitos= data
                ))
            },
            listarProdecimientosNuevo() {
                axios.get('/api/procedimientoLista').then(({data}) => (this.procedimiento_nuevos = data))
            },
            listarProcedimientos() {
                axios.get('/api/procedimiento').then(({data}) => (this.procedimientos = data))
            },
            getResultsProcedimientos(page=1) {
                axios.get('api/procedimiento?page=' + page)
                    .then(response => {
                        this.procedimientos = response.data
                        this.total_procedimiento = this.procedimientos.total
                    });                
            },
            limpiar() {
                this.form.clear()
                this.form.reset()
            },
            selecccionarProcedimiento(id) {
                this.procedimiento_seleccionado= id
                axios.get('/api/procedimiento/'+id).then(({data}) => (
                    this.procedimiento_requisitos = data
                ) )
            },       
            nuevo() {
                this.limpiar()
                this.listarProdecimientosNuevo()
                this.requisitos_seleccionados=[]
                this.crudmode = 'create'
                $('#modal-proc-requisito-title').html('Nuevo Procediento-Requisito')
                $('#modal-proc-requisito').modal('show')
            },
            anadirSeleccionado(){  
                if(!this.requisitos_seleccionados.find(r => r.id === this.requisito_seleccionado.id))
                {
                    this.requisitos_seleccionados.push(this.requisito_seleccionado)
                    this.form.requisito_id.push(this.requisito_seleccionado.id)
                } 
                else{
                    swal.fire('Requisito Ya está Añadido!','Seleccione Otro','error')
                }
            },
            eliminarRequisitoSeleccionado(ind,id) {
                this.requisitos_seleccionados.splice(ind,1)
                this.form.requisito_id.splice(ind,1)

            },
            guardarSeleccionados() {
                this.form.post('api/guardarProcRequi').then( response =>{
                    swal.fire('Requisitos Añadidos','al procedimiento Seleccionado',
                            'success').then( (respuesta) => {
                        this.$Progress.start()
                        if(respuesta.value) {
                            $('#modal-proc-requisito').modal('hide')
                            this.listarProcedimientos()
                            this.getResultsProcedimientos()
                            this.$Progress.finish()
                        }
                    })

                }).catch(error =>  {
                    this.$Progress.fail()
                    if(error.response.status == 422) {
                        console.clear() 
                    }
                    else {
                        swal.fire('Error', `Ocurrió un Error: ${error.response.status}`,'error')
                    }  
                })
            }

        }
    }
</script>