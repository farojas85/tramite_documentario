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
                        <li class="breadcrumb-item"><a href="/">Trámites</a></li>
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
                                    <button type="button" class="btn btn-primary" @click="nuevoUsuario">
                                        <i class="fas fa-plus"></i> Agregar Usuario
                                    </button>
                                </div>
                                <div class="col-md-6 text-right">
                                    <div class="input-group">
                                        <input type="text" name="table-search" id="table-search"
                                            class="form-control" v-model="buscar" @change="busqueda"
                                            placeholder="Buscar...">
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
                                                    <th>Usuario</th>
                                                    <th>Correo Electrónico</th>
                                                    <th>Rol</th>
                                                    <th>Fecha Creada</th>                                                    
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="us in users.data" :key="us.id">
                                                    <td>{{ us.id }} </td>
                                                    <td>{{ us.name | capitalText}}</td>
                                                    <td>{{ us.email }}</td>
                                                    <td v-for="r in us.roles" :key="r.id">
                                                        <span v-if="r.slug == 'admin'" class="badge badge-success">{{ r.nombre | capitalText }}</span>
                                                        <span v-if="r.slug == 'user'" class="badge badge-primary">{{ r.nombre | capitalText }}</span>
                                                    </td>
                                                    <td>{{ us.created_at | miFecha }}</td>
                                                    <td>
                                                        <button type="button" class="btn btn-success btn-circle"
                                                            title="Mostrar Usuario" @click="showUser(us.id)">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-warning btn-circle"
                                                            title="Editar Usuario">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-info btn-circle"
                                                            title="Cambiar Contraseña">
                                                            <i class="fas fa-key"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-danger btn-circle"
                                                            title="Eliminar Usuario" @click="deleteUser(us.id)">
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
                            <pagination :data="users" @pagination-change-page="getResults"></pagination>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="modal fade" id="modal-create">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" v-show="!editmode" id="modal-create-title">Nuevo Usuario</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                     <form @submit.prevent="createUser" id="form-user" >
                        <div class="modal-body" id="modal-create-body">
                            <input type="hidden" name="id" v-model="form.id" id="id">
                            <div class="form-group">
                                <input type="text" name="name" v-model="form.name" id="name"
                                    placeholder="Nombre de Usuario" title="Nombre de Usuario"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                                <has-error :form="form" field="name"></has-error>
                            </div>
                            <div class="form-group">
                                <select name="role_id" id="role_id" class="form-control"
                                    v-model="form.role_id" title="Seleccione Rol"
                                    :class="{ 'is-invalid': form.errors.has('role_id') }">
                                    <option value="">-Seleccione Rol-</option>
                                    <option v-for="rol in roles" :key="rol.id" :value="rol.id">
                                        {{rol.nombre}}
                                    </option>
                                </select>
                                <has-error :form="form" field="role_id"></has-error>
                            </div>
                            <div class="form-group">
                                <input type="email" name="email" v-model="form.email"
                                    placeholder="Correo Electrónico" title="Correo Electrónico"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                                <has-error :form="form" field="email"></has-error>
                            </div>
                            <div class="form-group">
                                <input type="password" name="password" v-model="form.password"
                                    placeholder="Contraseña" title="Contraseña"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('password') }">
                                <has-error :form="form" field="password"></has-error>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">
                                <i class="fas fa-times"></i> Close
                            </button>
                            <button type="submit" class="btn btn-success">
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
    import axios from 'axios'
    
    export default {
        created() {
            this.listarRoles()
            this.listarUsers()
            this.getResults()
        },
        data() {
            return {
                crudmode: '',
                users:{},
                form: new form({
                    id:'',
                    name:'',
                    email:'',
                    password:'',
                    role_id:'',
                    foto:'',
                    remember:false
                }),
                roles:{},
                buscar:''
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
            listarRoles() {
                axios.get('api/rolelist')
                    .then(response => {
                        this.roles = response.data
                    })
            },
            listarUsers() {
                axios.get('api/user').then(({ data }) => (this.users =data))
            },
            getResults(page=1) {
                // Using vue-resource as an example
                axios.get('/api/user?page=' + page)
                    .then(response => {
                        this.users = response.data
                    });
            },
            limpiar() {
                this.form.reset
                $("input.is-invalid").removeClass('is-invalid')
            },
            nuevoUsuario() {
                this.form.reset
                this.limpiar()
                this.crudmode = 'create'
                $('#form-user').trigger('reset');
                $('#modal-create').modal('show')
            },
            createUser() {                
                this.form.post('api/user')
                .then(() => {
                    this.$Progress.start()
                    $('#modal-create').modal('hide')
                    toast.fire({type:'success',title:'Usuario Registrado Satisfactoriamente'})
                    this.listarUsers()
                    this.getResults()
                    this.$Progress.finish()
                })
                .catch( () => {
                    
                })
                
            },
            showUser(id){
                this.crudmode == 'show'
                axios.get('api/user/'+id)
                    .then( response => {
                        let user = response.data
                        let role = user.roles
                        for(let i=0;i<role.length;i++) {
                            this.form.role_id = role[0]['id'];
                        }

                        this.form.id = user.id
                        this.form.name = user.name
                        this.form.email = user.email
                        this.form.password = user.password
                        $('#modal-create-title').html('Mostrar Usuario')
                        $('#modal-create').modal('show')
                    })
            },
            deleteUser(id) {
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
                        axios.post('/api/user/delete/'+id)
                        .then(response => {
                            swal.fire({
                                title:"Componente",
                                text:response.data,
                                type:"success",
                                confirmButtonColor:"#148f77",
                                confirmButtonText:"Aceptar"
                            }).then(response => {
                                if(response.value) {
                                    this.listarUsers();
                                    this.getResults();
                                }                                    
                            });
                            
                        });                        
                    }
                });         
            }, 
        }
    }
</script>

