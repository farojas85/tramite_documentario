<template>
    <div>
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Usuarios</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="/home"><a href="#">Trámites</a></li>
                        <li class="breadcrumb-item active">Sistema</li>
                        <li class="breadcrumb-item active">Usuarios</li>
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
                            <h3 class="card-title">Listado de Usuarios</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <button type="button" class="btn btn-primary btn-rounded" @click="nuevoUsuario">
                                        <i class="fas fa-plus"></i> Agregar Usuario
                                    </button>
                                </div>
                                <div class="col-md-6 text-right">
                                    <div class="input-group">
                                        <input type="text" name="table-search" id="table-search"
                                            class="form-control"
                                            placeholder="Buscar...">
                                        <div class="input-group-append col-md-4">
                                            <button type="button" class="btn btn-default">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-sm table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Id</th>
                                                    <th>Usuario</th>
                                                    <th>Correo Electrónico</th>
                                                    <th>Creado En..</th>
                                                    <th>Tipo</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>123</td>
                                                    <td>fredyrb</td>
                                                    <td>farojas851@gmail.com</td>
                                                    <td>11-07-2019</td>
                                                    <td>
                                                        <span class="badge badge-success">Aprobado</span>
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-circle btn-warning"
                                                            title="Editar Usuario">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-circle btn-primary"
                                                            title="Cambiar Contraseña Usuario">
                                                            <i class="fas fa-key"></i>
                                                        </button>      
                                                        <button type="button" class="btn btn-danger btn-circle"
                                                            title="Eliminar Usuario">
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
                    </div>
                </div>
            </div>
        </section>

        <div class="modal fade" id="modal-create">
            <div class="modal-dialog ">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" v-show="!editmode" id="modal-create-title">Nuevo Usuario</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                     <form @submit.prevent="validatesubmit()" id="form-user" >
                        <div class="modal-body" id="modal-create-body">
                            <div class="form-group">
                                <input type="text" name="name" v-model="user.name"
                                    placeholder="Nombre de Usuario"
                                    v-validate="'required'"
                                    class="form-control" :class="{ 'is-invalid': errors.has('name') }">
                                <span class="text-danger" v-if="errors.has('name')">{{ errors.first('name') }}</span>
                            </div>
                            <div class="form-group">
                                <input type="email" name="email" v-model="user.email"
                                    placeholder="Correo Electrónico"
                                    v-validate="'required'"
                                    class="form-control" :class="{ 'is-invalid': errors.has('email') }">
                                <span class="text-danger" v-if="errors.has('email')">{{ errors.first('email') }}</span>
                            </div>
                            <div class="form-group">
                                <input type="password" name="password" v-model="user.password"
                                    placeholder="Contraseña"
                                    v-validate="'required'"
                                    class="form-control" :class="{ 'is-invalid': errors.has('password') }">
                                <span class="text-danger" v-if="errors.has('password')">{{ errors.first('password') }}</span>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">
                                <i class="fas fa-times"></i> Close
                            </button>
                            <button class="btn btn-success">
                                <i class="fas fa-save"></i> Guardar
                            </button>
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

        },
        data() {
            return {
                editmode: false,
                users:{},
                form: new Form({
                    id:'',
                    name:'',
                    email:'',
                    password:'',
                    tipo:''
                })
            }
        },
        methods: {
            validatesubmit() {
                swal.fire('text','titulo')
                this.$validator.validate().then(valid => {
                    if(valid){
                        
                    }
                });
            },
            nuevoUsuario(){
                this.user=""
                this.editmode = false
                $('#form-user').trigger('reset');
                $('#modal-create').modal('show')
            },
        }
    }
</script>

