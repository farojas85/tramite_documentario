<div class="row mt-2">
    <div class="col-md-6">
        <button type="button" class="btn btn-primary btn-sm" @click="nuevaUnidadOrganica()">
            <i class="fas fa-plus"></i> Nueva Unidad Org&aacute;nica
        </button>
    </div>
    <div class="col-md-6 text-right">
        <div class="input-group input-group-sm">
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
                        <th>Unidad Org&aacute;nica</th>
                        <th>Abreviatura</th>                                                 
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-show="modelos.data == null">
                        <td colspan="4" class="text-center text-danger">
                            -- Datos No Registrados - Tabla Vacía --
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <pagination :data="modelos" @pagination-change-page="getResults"></pagination>
    </div>
</div>