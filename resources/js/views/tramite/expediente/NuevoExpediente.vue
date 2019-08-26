<template>
    <div class="container-fluid">
        <ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="custom-content-below-home-tab" 
                    data-toggle="pill" href="#custom-content-below-home" role="tab" 
                    aria-controls="custom-content-below-home" aria-selected="true">Datos del Solicitante</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="custom-content-below-profile-tab" data-toggle="pill" 
                    href="#custom-content-below-profile" role="tab" 
                    aria-controls="custom-content-below-profile" aria-selected="false">Datos de Expediente</a>
            </li>         
        </ul>
        <form @submit.prevent="validatesubmit">
            <div class="tab-content" id="custom-content-below-tabContent">
                <div class="tab-pane fade active show" id="custom-content-below-home" role="tabpanel" aria-labelledby="custom-content-below-home-tab">
                    <input type="hidden" name="id" v-model="form.id" id="id">
                    <div class="form-group row mt-2">
                        <div class="col-xl-3">
                            <select class="form-control" id="documento_identidad_id" name="documento_identidad_id"
                                v-model="form.persona.documento_identidad_id" title="Seleccione Documento Identidad"
                                placeholder="seleccione Tipo Documento Identidad"
                                :class="{ 'is-invalid': form.errors.has('documento_identidad_id') }">
                                <option value="">-Tipo Documento-</option>
                                <option v-for="tipo in documento_identidads" :key="tipo.id" :value="tipo.id" :title="tipo.descripcion_larga">
                                    {{ tipo.descripcion_corta }}
                                </option>    
                            </select>
                            <has-error :form="form" field="documento_identidad_id"></has-error>
                        </div>
                        <div class="col-xl-3">
                            <input type="text" name="numero_documento" v-model="form.persona.numero_documento" id="numero_documento"
                                placeholder="Número Documento" title="Número de Documento de Identidad"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('numero_documento') }"
                                @change="buscarpersona">
                            <has-error :form="form" field="numero_documento"></has-error>
                        </div>
                        <div class="col-xl-3">
                            <div class="custom-control custom-switch custom-switch-on-success">
                                <input type="checkbox" class="custom-control-input" id="estado" 
                                    v-model="form.solicitante.estado">
                                <label class="custom-control-label" for="estado">Activo</label>
                            </div>
                        </div>
                        <div class="col-xl-3">
                            <div class="custom-control custom-switch custom-switch-on-danger">
                                <input type="checkbox" class="custom-control-input" id="eliminado" 
                                    v-model="form.solicitante.eliminado">
                                <label class="custom-control-label" for="eliminado">Eliminado</label>
                            </div>
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
                       
                    </div>
                </div>
                <div class="tab-pane fade" id="custom-content-below-profile" role="tabpanel" aria-labelledby="custom-content-below-profile-tab">
                    <div class="form-group row mt-2">
                        <label class="col-form-label col-md-2 text-right">Movimiento</label>
                         <div class="col-md-3">
                            <select class="form-control" id="tipo_movimiento" name="tipo_movimiento"
                                v-model="form.movimiento.tipo_movimiento_id" title="Seleccione Documento Identidad"
                                placeholder="seleccione Tipo Documento Identidad"
                                :class="{ 'is-invalid': form.errors.has('tipo_movimiento') }">
                                <option value="">Tipo Movimiento-</option>
                                <option v-for="mov in tipo_movimientos" :key="mov.id" :value="mov.id" :title="mov.descripcion_larga">
                                    {{ mov.descripcion }}
                                </option>   
                            </select>
                            <has-error :form="form" field="tipo_movimiento"></has-error>
                        </div>
                        <label class="col-form-label col-md-2 text-right">Tipo Documento</label>
                        <div class="col-md-3">
                            <select class="form-control" id="tipo_documento_id" name="tipo_documento_id"
                                v-model="form.documento.tipo_documento_id" title="Seleccione Documento Identidad"
                                placeholder="seleccione Tipo Documento Identidad"
                                :class="{ 'is-invalid': form.errors.has('tipo_documento_id') }">
                                <option value="">Tipo Documento-</option>
                                <option v-for="tipo in tipo_documentos" :key="tipo.id" :value="tipo.id" :title="tipo.descripcion_larga">
                                    {{ tipo.descripcion }}
                                </option>   
                            </select>
                            <has-error :form="form" field="tipo_documento_id"></has-error>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-md-2 text-right">N&deg; Expediente</label>
                        <div class="col-md-3">
                            <input type="text" name="numero_expediente" v-model="form.expediente.numero_expediente" id="numero_expediente"
                                placeholder="Número Expediente" title="Número Expediente"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('numero_expediente') }">
                            <has-error :form="form" field="numero_expediente"></has-error>
                        </div>
                        <label class="col-form-label col-md-2 text-right">Cabecera</label>
                        <div class="col-md-5">
                            <input type="text" name="cabecera" v-model="form.expediente.cabecera" id="cabecera"
                                placeholder="Cabecera Expediente" title="Cabecera Expediente"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('cabecera') }">
                            <has-error :form="form" field="cabecera"></has-error>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
    export default {
        created() {
            this.listarTipoDocumentos()
            this.listarDocumentoIdentidads()
            this.listarTipoMovimientos()
            this.form.reset()
            this.form.clear()
        },
        data() {
            return {
                documento_identidads:{},
                tipo_documentos:{},
                tipo_movimientos:{},
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
                    solicitante:{
                        id:'',
                        estado:1,
                        eliminado:0
                    },
                    documento:{
                        id:'',
                        tipo_documento_id:''
                    },
                    movimiento:{
                        tipo_movimiento_id:''
                    },
                    expediente:{
                        cabecera:'',
                    }
                }),
            }
        },
        methods: {
            listarTipoDocumentos() {
                axios.get('api/tipoDocumentoLista').then(({ data }) => {
                    this.tipo_documentos= data
                })
            },
            listarTipoMovimientos() {
                axios.get('api/tipoMovimientoLista').then(({ data }) => {
                    this.tipo_movimientos = data
                })
            },
            listarDocumentoIdentidads() {
                axios.get('api/documentoIdentidadList')
                .then(({data})=>(
                    this.documento_identidads = data
                ))
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
                                this.form.persona.apellidos = persona.apellidoPaterno+' '+persona.apellidoMaterno
                            }
                        })
                    }
                    else if( this.form.persona.documento_identidad_id == 3) {
                        axios.get('api/buscarruc', {
                            params:{
                                documento: this.form.persona.numero_documento
                            }
                        }).then(response => {
                            let persona = response.data
                            this.form.persona.razon_social = persona.razonSocial
                        })
                    }
                }
            }
        }
    }
</script>