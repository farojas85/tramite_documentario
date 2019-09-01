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
                        <li class="breadcrumb-item"><a href="/home">Trámites</a></li>
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
                                                            title="Editar Usuario" @click="editUser(us.id)">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <!--<button type="button" class="btn btn-info btn-circle"
                                                            title="Cambiar Contraseña">
                                                            <i class="fas fa-key"></i>
                                                        </button>-->
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
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modal-create-title">Nuevo Usuario</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                     <form @submit.prevent="validatesubmit" id="form-user" >
                        <div class="modal-body" id="modal-create-body">
                            <input type="hidden" name="id" v-model="form.id" id="id">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="card card-success">
                                        <div class="card-header">
                                            <h3 class="card-title">Datos Personales</h3>
                                        </div>
                                        <div class="card-body">
                                            <input type="hidden" name="id_persona" id="id_persona" v-model="form.persona.id">
                                            <div class="form-group row">
                                                <div class="col-md-5">
                                                    <select class="form-control" id="documento_identidad_id" 
                                                        placeholder="Documento de Identidad"
                                                        name="documento_identidad_id" v-model="form.persona.documento_identidad_id"
                                                        title="Seleccione Rol" :class="{ 'is-invalid': form.errors.has('documento_identidad_id') }">
                                                        <option value="">-Tipo Doc.-</option>
                                                        <option v-for="docu in documento_identidads" :key="docu.id" :value="docu.id">
                                                            {{docu.descripcion_corta}}
                                                        </option>
                                                    </select>
                                                    <has-error :form="form" field="documento_identidad_id"></has-error>
                                                </div>
                                                <div class="col-md-7">
                                                    <input type="text" class="form-control" id="numero_documento" 
                                                            placeholder="Número documento" name="numero_documento"
                                                            v-model="form.persona.numero_documento" title="numero_documento"
                                                            maxlength="8"
                                                            :class="{ 'is-invalid': form.errors.has('numero_documento') }"
                                                            @change="buscarpersona" >    
                                                    <has-error :form="form" field="numero_documento"></has-error>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-12">
                                                    <input type="text" class="form-control" id="nombres" 
                                                            placeholder="Ingrese Nombres" name="nombres"
                                                            v-model="form.persona.nombres" title="Nombres "
                                                            :class="{ 'is-invalid': form.errors.has('nombres') }">    
                                                    <has-error :form="form" field="nombres"></has-error>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-12">
                                                    <input type="text" class="form-control" id="apellidos" 
                                                            placeholder="Ingrese Apellidos" name="apellidos"
                                                            v-model="form.persona.apellidos" title="Apellidos"
                                                            :class="{ 'is-invalid': form.errors.has('apellidos') }">    
                                                    <has-error :form="form" field="apellidos"></has-error>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-12">
                                                    <input type="email" class="form-control" id="correo" 
                                                            placeholder="Ingrese Correo Electrónico" name="correo"
                                                            v-model="form.email" title="correo"
                                                            :class="{ 'is-invalid': form.errors.has('correo') }">    
                                                    <has-error :form="form" field="correo"></has-error>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-12">
                                                    <input type="text" class="form-control" id="direccion" 
                                                            placeholder="Ingrese Diredción" name="direccion"
                                                            v-model="form.persona.direccion" title="direccion"
                                                            :class="{ 'is-invalid': form.errors.has('direccion') }">    
                                                    <has-error :form="form" field="direccion"></has-error>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card card-danger">
                                        <div class="card-header">
                                            <h3 class="card-title">Cargo y Dependencia</h3>
                                        </div>
                                        <div class="card-body">
                                            <div class="form-group">
                                                <select name="unidad_organica_id" id="unidad_organica_id"
                                                    class="form-control" title="Unidad Orgánica" 
                                                    v-model="form.empleado.unidad_organica_id" 
                                                    :class="{ 'is-invalid': form.errors.has('unidad_organica_id') }" 
                                                    @change="seleccionar_dependencia($event)">
                                                    <option value="">-Seleccione Unidad Orgánica-</option>
                                                    <option v-for="uo in UnidadOrganicas" :key="uo.id" :value="uo.id">
                                                        {{uo.nombre}}
                                                    </option>
                                                </select>
                                                <has-error :form="form" field="unidad_organica_id"></has-error>
                                            </div>
                                            <div class="form-group">
                                                <select name="dependencia_id" id="dependencia_id"
                                                    class="form-control" title="Dependencia Destino" 
                                                    v-model="form.empleado.dependencia_id" 
                                                    :class="{ 'is-invalid': form.errors.has('dependencia_id') }"
                                                    @click="seleccionar_cargos($event)">
                                                    <option value="">-Seleccione Dependencia-</option>
                                                    <option v-for="dep in dependencias" :key="dep.id" :value="dep.id">
                                                        {{dep.nombre}}
                                                    </option>
                                                </select>
                                                <has-error :form="form" field="dependencia_id"></has-error>
                                            </div>
                                            <div class="form-group">
                                                <select name="cargo_id" id="cargo_id"
                                                    class="form-control" title="Cargo Destino" 
                                                    v-model="form.empleado.cargo_id" 
                                                    :class="{ 'is-invalid': form.errors.has('cargo_id') }">
                                                    <option value="">-Seleccione Cargo-</option>
                                                    <option v-for="car in cargos" :key="car.id" :value="car.id">
                                                        {{car.nominativo_interno}}
                                                    </option>
                                                </select>
                                                <has-error :form="form" field="cargo_id"></has-error>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card card-info">
                                        <div class="card-header">
                                            <h3 class="card-title">Datos de usuario</h3>
                                        </div>
                                        <div class="card-body">
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
                                    </div>
                                </div>
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
   // import axios from 'axios'
    
    export default {
        created() {
            this.listarRoles()
            this.listarUsers()
            this.getResults()
            this.obtenerTipoDocumentos()
            this.listarUnidadOrganicas()
            this.listarDependencias()
            this.listarCargos()
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
                    remember:false,
                    persona:{
                        id:'',
                        documento_identidad_id:'',
                        numero_documento:'',
                        nombres:'',
                        apellidos:'',
                        correo:'',
                        direccion:''
                    },
                    empleado:{
                        id:'',
                        user_id:'',
                        persona_id:'',
                        unidad_organica_id:'',
                        dependencia_id:'',
                        cargo_id:'',
                    }
                }),
                roles:{},
                buscar:'',
                documento_identidads:{},
                UnidadOrganicas:{},
                dependencias:{},
                cargos:{}
            }
        },
        methods: {
            obtenerTipoDocumentos() {
                axios.get('api/documentoIdentidadList')
                .then(({data})=>(
                    this.documento_identidads = data
                ))
            },
            listarUnidadOrganicas() {
                 axios.get('api/unidadOrgListaMov').then(({ data }) => {
                     this.UnidadOrganicas = data;
                 })
            },
            listarDependencias() {
                axios.get('api/dependenciaListaMov').then(({ data }) => {
                     this.dependencias = data;
                 })
            },
            listarCargos() {
                axios.get('api/cargolist').then(({ data }) => {
                    this.cargos = data
                })
            },
            validatesubmit() {
                switch(this.crudmode){
                    case 'create' : this.createUser();break;
                    case 'update' : this.updateUser();break;
                }
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
            seleccionar_dependencia(event) {
                let id = event.target.value;
                axios.get('api/dependeciaid',{params:{id: id}}).then(({ data }) => {
                    this.dependencias = data;
                })
            },
            seleccionar_cargos(event) {
                let id = event.target.value
                axios.get('api/cargoid',{params:{id:id}}).then(({ data }) => {
                    this.cargos = data
                })
            },
            buscarpersona() {
                if(this.form.persona.numero_documento.length >0) {
                    if(this.form.persona.documento_identidad_id ==1 ){
                        axios.get('api/buscardni', {
                            params:{
                                documento: this.form.persona.numero_documento
                            }
                        }).then(response => {
                            if(response.data == "No Encontrado") {
                                swal.fire('DNI No Encontrado','Nro. de DNI no es Válido y/o No Existe','error')
                            } 
                            else {
                                let persona = response.data
                                this.form.persona.nombres = persona.nombres
                                this.form.persona.apellidos = persona.apellidos
                                this.form.persona.correo = persona.correo
                                this.form.persona.direccion = persona.direccion
                            }
                        })
                    }
                }
            },
            limpiar() {
                this.form.reset()
                this.form.clear()
            },
            nuevoUsuario() {
                this.limpiar()
                this.crudmode = 'create'
                $('#form-user').trigger('reset');
                $('#modal-create').modal('show')
            },
            createUser() {
                this.form.persona.correo = this.form.email
                this.$Progress.start()       
                this.form.post('api/user')
                .then( response => {                 
                   $('#modal-create').modal('hide')
                    toast.fire({type:'success',title:'Usuario Registrado Satisfactoriamente'})
                    this.listarUsers()
                    this.getResults()
                    this.$Progress.finish()
                })
                .catch(() => {
                    this.$Progress.fail()
                })                
            },
            loadUserData(id,title) {
                axios.get('api/mostraruser',{ params: {id : id}})
                    .then( response => {
                        console.log(response.data[0])
                        let user = response.data[0]
                        this.form.id = user.user_id
                        this.form.persona.documento_identidad_id = user.documento_identidad_id
                        this.form.persona.numero_documento = user.numero_documento
                        this.form.persona.nombres = user.nombres
                        this.form.persona.apellidos = user.apellidos
                        this.form.persona.correo = user.user_email
                        this.form.persona.direccion = user.direccion
                        this.form.empleado.id = user.empleado_id
                        this.form.empleado.user_id = user.user_id
                        this.form.empleado.empleado_id = user.empleado_id
                        this.form.empleado.unidad_organica_id = user.unidad_organica_id
                        this.form.empleado.dependencia_id = user.dependencia_id
                        this.form.empleado.cargo_id = user.cargo_id
                        this.form.name = user.user_name
                        this.form.email = user.user_email
                        this.form.role_id = user.role_id
                        $('#modal-create-title').html(title)
                        $('#modal-create').modal('show')
                    })/*.catch(error => {
                        swal.fire('Error', `Ocurrió un Error: ${error.status}`,'error')
                    })*/
            },
            showUser(id){
                this.crudmode = 'show'
                this.loadUserData(id,'Mostrar Usuario')
            },
            editUser(id) {
                this.crudmode = 'update'
                this.loadUserData(id,'Editar Usuario')
            },
            updateUser(id){
                this.$Progress.start()  
                this.form.put('api/user/'+this.form.id)
                    .then((respuesta) => {
                        console.log(respuesta.data)
                        swal.fire({
                                title:"Usuario",
                                text:respuesta.data,
                                type:"success",
                                confirmButtonColor:"#148f77",
                                confirmButtonText:"Aceptar"
                            }).then(response => {
                                if(response.value) {
                                    $('#modal-create').modal('hide')
                                    this.listarUsers()
                                    this.getResults()
                                    this.$Progress.finish()
                                }                                    
                            })
                    })
                    .catch(() => {
                        this.$Progress.fail()
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
                        this.form.delete('api/user/'+id).then( (respuesta) => {
                            this.$Progress.start()
                            swal.fire({
                                title:"Usuario",
                                text:respuesta.data,
                                type:"success",
                                confirmButtonColor:"#148f77",
                                confirmButtonText:"Aceptar"
                            }).then(response => {
                                if(response.value) {
                                    this.listarUsers()
                                    this.getResults()
                                    this.$Progress.finish()
                                }                                    
                            })
                            .catch(() => {
                                
                            })
                        })
                        .catch( error => {
                            swal.fire('Error', `Ocurrió un Error: ${error.status}`,'error')
                        })                       
                    }
                }).catch(error => {
                    swal.showValidationError(
                        `Ocurrió un Error: ${error.status}`
                    )
                })         
            }, 
        }
    }
</script>

