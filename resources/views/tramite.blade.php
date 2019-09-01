<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Tramite|Documentario</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link href="{{ mix('css/app.css') }}" type="text/css" rel="stylesheet" />
</head>
<body class="hold-transition sidebar-mini layout-fixed">
  <div  class="wrapper"id="app">
    @include('layouts.partials.navbar')
    @include('layouts.partials.sidebar')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      @if($usuario != null) 
        <router-view></router-view>
        <vue-progress-bar></vue-progress-bar>
      @else
        @if($expedientes!== null)
        <div class="card card-default color-palette-box">
          <div class="card-header">
              <h3 class="card-title">
                  <i class="fas fa-folder-open"></i> Listado Expedientes y Documentos
              </h3>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-sm table-striped table-bordered table-hover">
                  <thead class="bg-dark">
                      <tr>
                          <th>Id</th>
                          <th>Fecha/Hora</th>
                          <th>Expediente</th>
                          <th>Asunto</th>
                          <th>Estado</th>                                                    
                          <th>Seguir</th>
                      </tr>
                  </thead>
                  <tbody>
                    @forelse ($expedientes['expediente'] as $item)
                    <tr>
                      <td>{{ $item->id }}</td>
                      <td>{{ $item->fecha." ".$item->hora }}</td>
                      <td>{{ $item->cabecera." ".$item->numero_expediente }}</td>
                      <td>{{ $item->asunto }}</td>
                      <td>
                        @switch($item->estado)
                          @case('Pendiente')
                        <span class="badge bg-danger">{{ $item->estado }}</span>                                
                            @break
                          @case('Derivado')
                        <span class="badge bg-warning">{{ $item->estado }}</span> 
                            @break
                          @case('Proceso')
                        <span class="badge bg-primary">{{ $item->estado }}</span> 
                              @break
                          @case('Terminado')
                        <span class="badge bg-success">{{ $item->estado }}</span> 
                              @break   
                          @case('Archivado')
                        <span class="badge bg-info">{{ $item->estado }}</span> 
                              @break     
                        @endswitch
                      </td>
                      <td>
                        <button class="btn btn-primary btn-sm" title="Ver Movimientos" 
                          data-toggle="modal" data-target="#modal-expedientes">
                            <i class="fas fa-eye"></i>
                        </button>
                      </td>
                    </tr>
                    @empty
                        <tr>
                          <td colspan="6" class="text-center text-danger">-- Datos de Expediente No Encontrados --</td>
                        </tr>
                    @endforelse
                  </tbody>
              </table>
            </div>
          </div>
        </div>
        @endif
      @endif
    </div>
    @include('layouts.partials.modals')
    @include('layouts.partials.footer')
    @include('layouts.partials.rightbar')
    <div class="modal fade" id="modal-expedientes">
      <div class="modal-dialog modal-xl">
        <div class="modal-content">
          <div class="modal-header">
              <h4 class="modal-title" id="modal-expedientes-title">Mostrar Movimientos Expediente</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body" id="modal-expedientes-body">
        @if($expedientes != null)
            <div class="row">
              <div class="col-md-6">
                <div class="card card-primary">
                  <div class="card-header">
                      <h3 class="card-title">Movimiento</h3>
                  </div>
                  <div class="card-body">
                
                    @forelse ($expedientes['movimientos'] as $mov)
                      <div class="form-group row">
                          <label for="movimiento_tipo" class="col-form-label col-md-3">Tipo:</label>
                          <div class="col-md-9">
                              <input type="text" id="movimiento_tipo" class="form-control"
                                value="{{ $mov->tipo_movimiento }}" readonly >
                          </div>
                      </div>
                      <div class="form-group row">
                          <label for="unidad_desc" class="col-form-label col-md-3">Unidad:</label>
                          <div class="col-md-9">
                              <textarea name="unidad_desc" id="unidad_desc" rows="2" 
                                  class="form-control" readonly >{{ $mov->unidad_origen }}</textarea>
                                
                          </div>

                      </div>
                      <div class="form-group row">
                          <label for="dependencia_desc" class="col-form-label col-md-3">Dependencia:</label>
                          <div class="col-md-9">
                              <textarea name="dependencia_desc" id="dependencia_desc" rows="2" 
                                  class="form-control"  readonly >{{ $mov->dependencia_origen }}</textarea>
                                
                          </div>
                      </div>
                      <div class="form-group row">
                          <label class="col-form-label col-md-3">Estado:</label>
                          <div class="col-md-9">
                          @switch($mov->estado_actual)
                            @case('Pendiente')
                            <span class="badge bg-danger">{{ $mov->estado_actual }}</span>                                
                                @break
                              @case('Derivado')
                            <span class="badge bg-warning">{{ $mov->estado_actual }}</span> 
                                @break
                              @case('Proceso')
                            <span class="badge bg-primary">{{ $mov->estado_actual }}</span> 
                                  @break
                              @case('Terminado')
                            <span class="badge bg-success">{{ $mov->estado_actual }}</span> 
                                  @break   
                              @case('Archivado')
                            <span class="badge bg-info">{{ $mov->estado_actual }}</span> 
                                  @break     
                          @endswitch
                                
                          </div>
                      </div>
                    @empty
                        
                    @endforelse
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="card card-success">
                  <div class="card-header">
                      <h3 class="card-title">Motivos Movimiento</h3>
                  </div>
                  <div class="card-body">
                    <div class="form-group row">
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered">
                                <thead class="thead-dark">
                                    <th class="text-center text-white">Id</th>
                                    <th class="text-center text-white">Motivos</th>
                                </thead>
                                <tbody>
                                  @forelse ($expedientes['motivos'] as $mot)
                                    <tr>
                                      <td>{{ $mot->motivo_id }}</td>
                                      <td>{{ $mot->motivo }}</td>
                                    </tr>
                                  @empty
                                      
                                  @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                  <div class="card card-warning">
                    <div class="card-header">
                        <h3 class="card-title">Movimientos Internos</h3>
                    </div>
                    <div class="card-body">
                      <div class="table-responsive">
                        <table class="table table-sm table-bordered">
                            <thead class="thead-dark">
                                <tr>
                                    <th class="text-center text-white">Id</th>
                                    <th class="text-center text-white">Unidad Destino</th>
                                    <th class="text-center text-white">Dependendia Destino</th>
                                    <th class="text-center text-white">Cargo Destino</th>
                                    <th class="text-center text-white">Fecha Creada</th>
                                </tr>
                            </thead>
                            <tbody>
                              @forelse ($expedientes['movimiento_internos'] as $mi)
                              <tr>
                                <td>{{ $mi->id }}</td>
                                <td>{{ $mi->unidad_destino }}</td>
                                <td>{{ $mi->dependencia_destino }}</td>
                                <td>{{ $mi->cargo_destino }}</td>
                                <td>{{ $mi->fecha_creada }}</td>
                              </tr>
                              @empty
                                  
                              @endforelse
                            </tbody>
                          </table>
                      </div>
                    </div>
                  </div>
              </div>
            </div>
        @endif
          </div>            
          <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>                
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
    <!-- /.modal-dialog -->
    </div>
  </div> 

  <script src="{{ mix('js/app.js') }}"></script>

  @yield('scripties')
</body>
</html>
