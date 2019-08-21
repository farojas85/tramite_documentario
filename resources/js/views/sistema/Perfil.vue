<template>
    <div class="container-fluid">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Perfil</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/home">Trámites</a></li>
                        <li class="breadcrumb-item active">Sistema</li>
                        <li class="breadcrumb-item active">Perfil</li>
                    </ol>
                </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content-header -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-3">
                        <div class="card card-primary card-outline">
                            <div class="card-body box-profile">
                                <div class="text-center">
                                <img class="profile-user-img img-fluid img-circle" :src="form.foto" alt="User profile picture">
                                </div>

                                <h3 class="profile-username text-center" v-text="form.name"></h3>

                                <p class="text-muted text-center" v-text="role_descripcion">Software Engineer</p>

                                <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>Docs. Emitidos</b> <a class="float-right">1,322</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Docs. Aceptados</b> <a class="float-right">543</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Docs. Derivados</b> <a class="float-right">13,287</a>
                                </li>
                                </ul>

                                <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a>
                            </div>
                        <!-- /.card-body -->
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="card card-success card-outline">
                            <div class="card-header p-2">
                                <ul class="nav nav-pills">
                                    <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Datos Personales</a></li>
                                    <li class="nav-item"><a class="nav-link " href="#settings" data-toggle="tab">Datos de Usuario</a></li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="activity">
                                        <form class="form-horizontal"  @submit.prevent="submitPersonal">
                                            <input type="hidden" name="id_persona" id="id_persona" v-model="persona.id">
                                             <div class="form-group row">
                                                <label for="nombres" class="col-form-label col-md-2">Doc. Identi.:</label>
                                                <div class="col-md-3">
                                                    <select class="form-control" id="documento_identidad_id" 
                                                        placeholder="Documento de Identidad"
                                                        name="documento_identidad_id" v-model="persona.documento_identidad_id"
                                                        title="Seleccione Rol" :class="{ 'is-invalid': form.errors.has('documento_identidad_id') }">
                                                        <option value="">-Seleccione Rol-</option>
                                                        <option v-for="docu in documento_identidads" :key="docu.id" :value="docu.id">
                                                            {{docu.descripcion_corta}}
                                                        </option>
                                                    </select>
                                                    <has-error :form="form" field="documento_identidad_id"></has-error>
                                                </div>
                                                <label class="col-form-label col-md-2">N&uacute;mero Doc.:</label>
                                                <div class="col-md-4">
                                                    <input type="text" class="form-control" id="numero_documento" 
                                                            placeholder="Ingrese Número documento" name="numero_documento"
                                                            v-model="persona.numero_documento" title="numero_documento"
                                                            maxlength="20"
                                                            :class="{ 'is-invalid': form.errors.has('numero_documento') }">    
                                                    <has-error :form="form" field="numero_documento"></has-error>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="nombres" class="col-form-label col-md-3">Nombres:</label>
                                                <div class="col-md-8">
                                                    <input type="text" class="form-control" id="nombres" 
                                                            placeholder="Ingrese Nombres" name="nombres"
                                                            v-model="persona.nombres" title="Nombres "
                                                            :class="{ 'is-invalid': form.errors.has('nombres') }">    
                                                    <has-error :form="form" field="nombres"></has-error>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="apellidos" class="col-form-label col-md-3">apellidos:</label>
                                                <div class="col-md-8">
                                                    <input type="text" class="form-control" id="apellidos" 
                                                            placeholder="Ingrese Apellidos" name="apellidos"
                                                            v-model="persona.apellidos" title="Apellidos"
                                                            :class="{ 'is-invalid': form.errors.has('apellidos') }">    
                                                    <has-error :form="form" field="apellidos"></has-error>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="razon_social" class="col-form-label col-md-3">Raz&oacute;n Social:</label>
                                                <div class="col-md-8">
                                                    <input type="text" class="form-control" id="razon_social" 
                                                            placeholder="Ingrese Razón Social" name="razon_social"
                                                            v-model="persona.razon_social" title="razon_social"
                                                            :class="{ 'is-invalid': form.errors.has('razon_social') }">    
                                                    <has-error :form="form" field="razon_social"></has-error>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="correo" class="col-form-label col-md-3">Correo Elec.:</label>
                                                <div class="col-md-8">
                                                    <input type="email" class="form-control" id="correo" 
                                                            placeholder="Ingrese Correo Electrónico" name="correo"
                                                            v-model="persona.correo" title="correo"
                                                            :class="{ 'is-invalid': form.errors.has('correo') }">    
                                                    <has-error :form="form" field="correo"></has-error>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="direccion" class="col-form-label col-md-3">Direcci&oacute;n:</label>
                                                <div class="col-md-8">
                                                    <input type="text" class="form-control" id="direccion" 
                                                            placeholder="Ingrese Diredción" name="direccion"
                                                            v-model="persona.direccion" title="direccion"
                                                            :class="{ 'is-invalid': form.errors.has('direccion') }">    
                                                    <has-error :form="form" field="direccion"></has-error>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <button class="btn btn-success">
                                                    <span v-show="total_persona == 0" id="id_guardar">
                                                        <i  class="fas fa-save"></i> Guardar
                                                    </span>
                                                    <span v-show="total_persona > 0">
                                                        <i  class="fas fa-sync-alt"></i> Actualizar
                                                    </span>
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="tab-pane" id="settings">
                                        <form class="form-horizontal" @submit.prevent="submitUser">
                                            <div class="form-group row">
                                                <label for="name" class="col-form-label col-md-3">Nombre Usuario</label>
                                                <div class="col-md-8">
                                                    <input type="text" class="form-control" id="name" 
                                                            placeholder="Ingrese Nombre Usuario" name="name"
                                                            v-model="form.name" title="Nombre de Usuario"
                                                            :class="{ 'is-invalid': form.errors.has('name') }">    
                                                    <has-error :form="form" field="name"></has-error>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="email_user" class="col-form-label col-md-3">Correo Elect.:</label>
                                                <div class="col-md-8">
                                                    <input type="email" class="form-control" id="email_user" 
                                                            placeholder="Ingrese Correo Electrónico" email_user="email_user"
                                                            v-model="form.email" title="Correo Electrónico"
                                                            :class="{ 'is-invalid': form.errors.has('email_user') }">    
                                                    <has-error :form="form" field="email_user"></has-error>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="photo" class="col-md-3 col-form-labrl">Foto Usuario</label>
                                                <div class="col-md-8">
                                                    <div class="input-group">
                                                        <div class="custom-file">
                                                            <input type="file" class="custom-file-input btn btn-success" id="foto" name="foto" >
                                                            <label class="custom-file-label" for="exampleInputFile">Seleccione Archivo...</label>
                                                        </div>
                                                        <div class="input-group-append">
                                                            <span class="input-group-text" id="">Subir</span>
                                                        </div>
                                                    </div>
                                                    <!-- <input type="file" @change="updateProfile" name="photo" class="form-input"> -->
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-10">
                                                    <button type="submit" class="btn btn-success">
                                                        <span v-show="total_user == 0" id="id_guardar">
                                                        <i  class="fas fa-save"></i> Guardar
                                                        </span>
                                                        <span v-show="total_user > 0">
                                                            <i  class="fas fa-sync-alt"></i> Actualizar
                                                        </span>
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
    export default {
        created() {
            this.obtenerPerfilUsuario()
            this.obtenerRolUsuario()
            this.obtenerTipoDocumentos()
            this.listarRoles()
        },
        mounted() {
            
        },
        data() {
            return {
                imguser: 'img/users/user.png',
                crudmodepersonal:'',
                crudmodeuser:'',
                perfil: {},
                role_name:'',
                role_descripcion:'',
                documento_identidads:{},
                total_persona:0,
                total_user:0,
                persona:new form({
                    id:'',
                    nombres:'',
                    apellidos:'',
                    documento_identidad_id:'',
                    numero_documento:'',
                    razon_social:'',
                    correo:'',
                    direccion:''
                }),
                user_id :'',
                form: new form({
                    id:'',
                    name:'',
                    email:'',
                    password:'',
                    role_id:'',
                    foto:'',
                    remember:false
                }),
                roles:{}
            }
        },
        methods: {
            obtenerPerfilUsuario() {
               axios.get('api/perfil').then( response => {
                   this.form.fill(response.data),
                   this.total_user = Object.keys(response.data).length         
               })                
            },
            obtenerDatosPersonales() {
                axios.get('api/dataPersonalUser').then(({ data}) =>(
                    this.persona.fill(data),
                    this.total_persona = Object.keys(data).length
                ))
            },
            obtenerRolUsuario() {
                axios.get('api/rolebyUser')
                .then(({data}) => (
                   this.role_name = data[0]['nombre'],
                   this.role_descripcion = data[0]['descripcion']
                ))
            },
            obtenerTipoDocumentos() {
                axios.get('api/documentoIdentidadList')
                .then(({data})=>(
                    this.documento_identidads = data
                ))
            },
            listarRoles(){
                axios.get('api/rolelist')
                .then(({data}) => (
                    this.roles = data
                ))
            },
            submitPersonal() {

            },
            submitUser() {

            },
            updateProfile() {
                
            }
        }
    }
</script>