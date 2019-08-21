<template>
    <div class="container-fluid">
        <div class="row mt-2">
            <div class="col-md-6">
                <button type="button" class="btn btn-primary btn-sm" @click="nuevo">
                    <i class="fas fa-plus"></i> Nuevo Requisito Procedimiento 
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
                                <th>Procedimiento</th>
                                <th>Requisito</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                         <tr v-show="total== 0">
                            <td colspan="4" class="text-center text-danger">
                                -- Datos No Registrados - Tabla Vacía --
                            </td>
                        </tr>
                        <tr v-show="total>0" v-for="requ in modelos.data" :key="requ.id">
                            <td class="text-center">{{ requ.id }}</td>
                            <td>{{ requ.requisito }}</td>
                            <td>{{ requ.procedimiento }}</td>
                            <td>
                                <button type="button" class="btn btn-success btn-circle"
                                    title="Mostrar requisito" @click="mostrar(requ.id)">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button type="button" class="btn btn-warning btn-circle"
                                    title="Editar Requisito" @click="editar(requ.id)">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-danger btn-circle"
                                    title="Eliminar Requisito" @click="eliminar(requ.id)">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    </table>
                </div>
                <pagination :data="modelos" @pagination-change-page="getResults"></pagination>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        created() {
            this.listar()
            this.getResults()
            this.listarRequisitos()
            this.listarProcedimientos()
        },
        data() {
            return {
                crudmode:'',
                buscar:'',
                modelos:{},
                requisitos:{},
                procedimientos:{},
                total:0,
                form: new form({
                    id:'',
                    requisito_id:'',
                    procedimiento_id:''
                })
            }
        },
        methods: { 
            listarRequisitos() {
                axios.get('/api/requisitoLista').then(({data}) => (this.requisitos= data))
            },
            listarProcedimientos() {
                axios.get('/api/procedimientoLista').then(({data}) => (this.procedimientos = data))
            },
            listar() {
                axios.get('api/requiprocLista').then(({ data }) => (this.modelos = data))
            },
            getResults(page=1) {
                axios.get('api/requiprocLista?page=' + page)
                    .then(response => {
                        this.modelos = response.data
                        this.total = this.modelos.total
                    });                
            },           
            nuevo() {

            }
        }
    }
</script>