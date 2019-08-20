<template>
    <div class="container-fluid">
         <div class="row mt-2">
            <div class="col-md-6">
                <button type="button" v-show="processFile==false" 
                    class="btn btn-success btn-sm" @click="mostrarUbigeo">
                    <i class="fas fa-file-excel"></i> Mostrar Ubigeo 
                </button>
            </div>
            <div class="col-md-6 text-right">
                <button v-show="processFile==true" type="button" 
                    class="btn btn-primary btn-sm" @click="procesarUbigeo(1)">
                    <i class="fas fa-upload"></i> Subir Archivo 
                </button>
            </div>
        </div>
        <div class="row mt-2">
             <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-sm table-striped table-bordered table-hover">
                        <thead class="bg-dark">
                            <tr>
                                <th class="text-center">Proceso</th>
                                <th>Ubigeo</th>
                                <th>Distrito</th>
                                <th>Provincia</th>                                                 
                                <th>Departamento</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-if="processFile==false">
                                <td colspan="6" class="text-center">
                                    <h6 class="text-primary">-- Seleccione Archivo Excel --</h6>
                                    <h6 class="text-danger">-- Aqu&iacute; se mostrar&aacute; los Datos a Importar --</h6>
                                </td>
                            </tr>
                            <tr v-else v-for="(ubigeo,indice) in ubigeos" :key="ubigeo.Ubigeo" :id="'tr_'+(indice+1)">
                                <td>
                                    <div :id="'proceso_'+(indice+1)"></div>
                                    <input type="hidden" :name="'ubigeo_'+(indice+1)" :id="'ubigeo_'+(indice+1)" :value="ubigeo.Ubigeo">
                                    <input type="hidden" :name="'distrito_'+(indice+1)" :id="'distrito_'+(indice+1)" :value="ubigeo.Distrito">
                                    <input type="hidden" :name="'provincia_'+(indice+1)" :id="'provincia_'+(indice+1)" :value="ubigeo.Provincia">
                                    <input type="hidden" :name="'departamento_'+(indice+1)" :id="'departamento_'+(indice+1)" :value="ubigeo.Departamento">
                                </td>
                                <td>{{ ubigeo.Ubigeo}}</td>
                                <td>{{ ubigeo.Distrito }}</td>
                                <td>{{ ubigeo.Provincia }}</td>
                                <td>{{ ubigeo.Departamento }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
             </div>
        </div>
    </div>
</template>

<script>
    import UbigeoJson  from '../../../json/ubigeo-inei'
import { setTimeout } from 'timers';
    export default {
        created() {
            this.cargarUbigeo()
        },
        data() {
            return {
                processFile:false,
                total_ubigeo:0,
                ubigeos:{},
                rutaUbigeo:'/json/ubigeo-inei.json',
                fila_pinta: false
            }
        },
        methods: {
            cargarUbigeo() {
                this.ubigeos = UbigeoJson.ubigeo_inei
                this.total_ubigeo = this.ubigeos.length
            },
            mostrarUbigeo() {
                this.processFile=true
            },
            procesarUbigeo(fila) {
                let ubigeo = $('#ubigeo_'+fila).val()
                let distrito = $('#distrito_'+fila).val()
                let provincia = $('#provincia_'+fila).val()
                let departamento = $('#departamento_'+fila).val()

                $('#tr_'+fila).addClass('bg-warning')
                axios.post('api/ubigeoProcesar',{
                    ubigeo : ubigeo,
                    distrito : distrito,
                    provincia : provincia,
                    departamento : departamento
                }).then( respuesta => {
                    $('#proceso_'+fila).html(respuesta.data)
                    fila+=1
                    if(fila>=2 && fila <=this.total_ubigeo) {
                        let tempo = fila-1
                        $('#tr_'+tempo).removeClass('bg-warning')
                    }
                    if(this.total_ubigeo>=fila){
                        this.procesarUbigeo(fila)
                    }
                    else {
                        swal.fire('Proceso Finalizado','Datos Procesados Correctamente','success')
                    }
                })
            }
        }
    }
</script>