@extends('TEMPLATES.administrador')
@section('title', 'Editar Cotización ' . $cotizacione->codigo)

@section('content')
    <div class="header_section">
        <div class="bg-transparent mb-3" style="height: 67px"></div>
        <div class="container-fluid">
            <div data-aos="fade-right">
                <h1 class="titulo h2 text-uppercase fw-bold mb-0">EDITAR COTIZACIÓN</h1>
                <div style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ route('admin-dashboard.index') }}">Principal</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="#">CRM</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ route('admin.crm.cotizaciones.index') }}">Cotizaciones</a></li>
                        <li class="breadcrumb-item link" aria-current="page">Editar {{ $cotizacione->codigo }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    @if ($errors->any())
        <div class="container-fluid mb-3">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong><i class="bi bi-exclamation-triangle me-2"></i>Errores de validación:</strong>
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif

    <div class="container-fluid">
        <form action="{{ route('admin.crm.cotizaciones.update', $cotizacione) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="row g-4">
                {{-- Columna Izquierda --}}
                <div class="col-lg-8">
                    {{-- Oportunidad y Vigencia --}}
                    <div class="card border-4 borde-top-secondary shadow-sm mb-4" style="border-radius: 20px" >
                        <div class="card-header bg-transparent">
                            <h5 class="mb-0"><i class="bi bi-link-45deg me-2"></i>Oportunidad Vinculada</h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-8">
                                    <label for="oportunidad_id" class="form-label">Oportunidad <span class="text-danger">*</span></label>
                                    <select name="oportunidad_id" id="oportunidad_id" class="form-select @error('oportunidad_id') is-invalid @enderror" required>
                                        <option value="">Seleccione una oportunidad...</option>
                                        @foreach($oportunidades as $oportunidad)
                                            <option value="{{ $oportunidad->id }}" 
                                                    {{ old('oportunidad_id', $cotizacione->oportunidad_id) == $oportunidad->id ? 'selected' : '' }}>
                                                {{ $oportunidad->codigo }} - {{ $oportunidad->nombre }} 
                                                @if($oportunidad->prospecto)
                                                    ({{ $oportunidad->prospecto->nombre_completo }})
                                                @endif
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('oportunidad_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="fecha_vigencia" class="form-label">Válido Hasta <span class="text-danger">*</span></label>
                                    <input type="date" name="fecha_vigencia" id="fecha_vigencia" 
                                           class="form-control @error('fecha_vigencia') is-invalid @enderror" 
                                           value="{{ old('fecha_vigencia', $cotizacione->fecha_vigencia?->format('Y-m-d')) }}" required>
                                    @error('fecha_vigencia')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Sistema Solar - Paneles --}}
                    <div class="card border-4 borde-top-secondary shadow-sm mb-4" style="border-radius: 20px" >
                        <div class="card-header bg-transparent">
                            <h5 class="mb-0"><i class="bi bi-sun me-2"></i>Paneles Solares</h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <label for="potencia_kw" class="form-label">Potencia Total (kW) <span class="text-danger">*</span></label>
                                    <input type="number" step="0.01" name="potencia_kw" id="potencia_kw" 
                                           class="form-control @error('potencia_kw') is-invalid @enderror" 
                                           value="{{ old('potencia_kw', $cotizacione->potencia_kw) }}" required>
                                    @error('potencia_kw')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <label for="cantidad_paneles" class="form-label">Cantidad Paneles <span class="text-danger">*</span></label>
                                    <input type="number" name="cantidad_paneles" id="cantidad_paneles" 
                                           class="form-control @error('cantidad_paneles') is-invalid @enderror" 
                                           value="{{ old('cantidad_paneles', $cotizacione->cantidad_paneles) }}" required min="1">
                                    @error('cantidad_paneles')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <label for="potencia_panel_w" class="form-label">Potencia/Panel (W) <span class="text-danger">*</span></label>
                                    <input type="number" step="0.01" name="potencia_panel_w" id="potencia_panel_w" 
                                           class="form-control @error('potencia_panel_w') is-invalid @enderror" 
                                           value="{{ old('potencia_panel_w', $cotizacione->potencia_panel_w) }}" required>
                                    @error('potencia_panel_w')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <label for="marca_panel" class="form-label">Marca Panel <span class="text-danger">*</span></label>
                                    <select name="marca_panel" id="marca_panel" class="form-select @error('marca_panel') is-invalid @enderror" required>
                                        <option value="">Seleccione...</option>
                                        <option value="Jinko Solar" {{ old('marca_panel', $cotizacione->marca_panel) == 'Jinko Solar' ? 'selected' : '' }}>Jinko Solar</option>
                                        <option value="Trina Solar" {{ old('marca_panel', $cotizacione->marca_panel) == 'Trina Solar' ? 'selected' : '' }}>Trina Solar</option>
                                        <option value="Canadian Solar" {{ old('marca_panel', $cotizacione->marca_panel) == 'Canadian Solar' ? 'selected' : '' }}>Canadian Solar</option>
                                        <option value="LONGi" {{ old('marca_panel', $cotizacione->marca_panel) == 'LONGi' ? 'selected' : '' }}>LONGi</option>
                                        <option value="JA Solar" {{ old('marca_panel', $cotizacione->marca_panel) == 'JA Solar' ? 'selected' : '' }}>JA Solar</option>
                                        <option value="Risen" {{ old('marca_panel', $cotizacione->marca_panel) == 'Risen' ? 'selected' : '' }}>Risen</option>
                                    </select>
                                    @error('marca_panel')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="modelo_panel" class="form-label">Modelo Panel</label>
                                    <input type="text" name="modelo_panel" id="modelo_panel" 
                                           class="form-control @error('modelo_panel') is-invalid @enderror" 
                                           value="{{ old('modelo_panel', $cotizacione->modelo_panel) }}">
                                    @error('modelo_panel')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Sistema Solar - Inversor --}}
                    <div class="card border-4 borde-top-secondary shadow-sm mb-4" style="border-radius: 20px" >
                        <div class="card-header bg-transparent">
                            <h5 class="mb-0"><i class="bi bi-lightning-charge me-2"></i>Inversor</h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label for="marca_inversor" class="form-label">Marca Inversor <span class="text-danger">*</span></label>
                                    <select name="marca_inversor" id="marca_inversor" class="form-select @error('marca_inversor') is-invalid @enderror" required>
                                        <option value="">Seleccione...</option>
                                        <option value="Huawei" {{ old('marca_inversor', $cotizacione->marca_inversor) == 'Huawei' ? 'selected' : '' }}>Huawei</option>
                                        <option value="Growatt" {{ old('marca_inversor', $cotizacione->marca_inversor) == 'Growatt' ? 'selected' : '' }}>Growatt</option>
                                        <option value="Sungrow" {{ old('marca_inversor', $cotizacione->marca_inversor) == 'Sungrow' ? 'selected' : '' }}>Sungrow</option>
                                        <option value="Fronius" {{ old('marca_inversor', $cotizacione->marca_inversor) == 'Fronius' ? 'selected' : '' }}>Fronius</option>
                                        <option value="SMA" {{ old('marca_inversor', $cotizacione->marca_inversor) == 'SMA' ? 'selected' : '' }}>SMA</option>
                                        <option value="Goodwe" {{ old('marca_inversor', $cotizacione->marca_inversor) == 'Goodwe' ? 'selected' : '' }}>Goodwe</option>
                                        <option value="Deye" {{ old('marca_inversor', $cotizacione->marca_inversor) == 'Deye' ? 'selected' : '' }}>Deye</option>
                                    </select>
                                    @error('marca_inversor')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="modelo_inversor" class="form-label">Modelo Inversor</label>
                                    <input type="text" name="modelo_inversor" id="modelo_inversor" 
                                           class="form-control @error('modelo_inversor') is-invalid @enderror" 
                                           value="{{ old('modelo_inversor', $cotizacione->modelo_inversor) }}">
                                    @error('modelo_inversor')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="potencia_inversor_kw" class="form-label">Potencia Inversor (kW) <span class="text-danger">*</span></label>
                                    <input type="number" step="0.01" name="potencia_inversor_kw" id="potencia_inversor_kw" 
                                           class="form-control @error('potencia_inversor_kw') is-invalid @enderror" 
                                           value="{{ old('potencia_inversor_kw', $cotizacione->potencia_inversor_kw) }}" required>
                                    @error('potencia_inversor_kw')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Sistema de Almacenamiento (Opcional) --}}
                    <div class="card border-4 borde-top-secondary shadow-sm mb-4" style="border-radius: 20px" >
                        <div class="card-header bg-transparent">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0"><i class="bi bi-battery-charging me-2"></i>Baterías (Opcional)</h5>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="incluye_baterias" name="incluye_baterias" value="1" 
                                           {{ old('incluye_baterias', $cotizacione->incluye_baterias) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="incluye_baterias">Incluir</label>
                                </div>
                            </div>
                        </div>
                        <div class="card-body" id="seccion-baterias" style="{{ old('incluye_baterias', $cotizacione->incluye_baterias) ? '' : 'display: none;' }}">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label for="marca_bateria" class="form-label">Marca Batería</label>
                                    <select name="marca_bateria" id="marca_bateria" class="form-select @error('marca_bateria') is-invalid @enderror">
                                        <option value="">Seleccione...</option>
                                        <option value="Pylontech" {{ old('marca_bateria', $cotizacione->marca_bateria) == 'Pylontech' ? 'selected' : '' }}>Pylontech</option>
                                        <option value="BYD" {{ old('marca_bateria', $cotizacione->marca_bateria) == 'BYD' ? 'selected' : '' }}>BYD</option>
                                        <option value="Huawei LUNA" {{ old('marca_bateria', $cotizacione->marca_bateria) == 'Huawei LUNA' ? 'selected' : '' }}>Huawei LUNA</option>
                                        <option value="Tesla Powerwall" {{ old('marca_bateria', $cotizacione->marca_bateria) == 'Tesla Powerwall' ? 'selected' : '' }}>Tesla Powerwall</option>
                                        <option value="LG Chem" {{ old('marca_bateria', $cotizacione->marca_bateria) == 'LG Chem' ? 'selected' : '' }}>LG Chem</option>
                                    </select>
                                    @error('marca_bateria')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="modelo_bateria" class="form-label">Modelo Batería</label>
                                    <input type="text" name="modelo_bateria" id="modelo_bateria" 
                                           class="form-control @error('modelo_bateria') is-invalid @enderror" 
                                           value="{{ old('modelo_bateria', $cotizacione->modelo_bateria) }}">
                                    @error('modelo_bateria')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="capacidad_baterias_kwh" class="form-label">Capacidad Total (kWh)</label>
                                    <input type="number" step="0.01" name="capacidad_baterias_kwh" id="capacidad_baterias_kwh" 
                                           class="form-control @error('capacidad_baterias_kwh') is-invalid @enderror" 
                                           value="{{ old('capacidad_baterias_kwh', $cotizacione->capacidad_baterias_kwh) }}">
                                    @error('capacidad_baterias_kwh')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Precios --}}
                    <div class="card border-4 borde-top-secondary shadow-sm mb-4" style="border-radius: 20px" >
                        <div class="card-header bg-transparent">
                            <h5 class="mb-0"><i class="bi bi-currency-dollar me-2"></i>Precios (Sin IGV)</h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label for="precio_equipos" class="form-label">Equipos <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">S/</span>
                                        <input type="number" step="0.01" name="precio_equipos" id="precio_equipos" 
                                               class="form-control @error('precio_equipos') is-invalid @enderror" 
                                               value="{{ old('precio_equipos', $cotizacione->precio_equipos) }}" required>
                                    </div>
                                    @error('precio_equipos')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="precio_instalacion" class="form-label">Instalación <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">S/</span>
                                        <input type="number" step="0.01" name="precio_instalacion" id="precio_instalacion" 
                                               class="form-control @error('precio_instalacion') is-invalid @enderror" 
                                               value="{{ old('precio_instalacion', $cotizacione->precio_instalacion) }}" required>
                                    </div>
                                    @error('precio_instalacion')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="precio_estructura" class="form-label">Estructura</label>
                                    <div class="input-group">
                                        <span class="input-group-text">S/</span>
                                        <input type="number" step="0.01" name="precio_estructura" id="precio_estructura" 
                                               class="form-control @error('precio_estructura') is-invalid @enderror" 
                                               value="{{ old('precio_estructura', $cotizacione->precio_estructura) }}">
                                    </div>
                                    @error('precio_estructura')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="precio_tramites" class="form-label">Trámites</label>
                                    <div class="input-group">
                                        <span class="input-group-text">S/</span>
                                        <input type="number" step="0.01" name="precio_tramites" id="precio_tramites" 
                                               class="form-control @error('precio_tramites') is-invalid @enderror" 
                                               value="{{ old('precio_tramites', $cotizacione->precio_tramites) }}">
                                    </div>
                                    @error('precio_tramites')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="precio_otros" class="form-label">Otros</label>
                                    <div class="input-group">
                                        <span class="input-group-text">S/</span>
                                        <input type="number" step="0.01" name="precio_otros" id="precio_otros" 
                                               class="form-control @error('precio_otros') is-invalid @enderror" 
                                               value="{{ old('precio_otros', $cotizacione->precio_otros) }}">
                                    </div>
                                    @error('precio_otros')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="descuento_porcentaje" class="form-label">Descuento (%)</label>
                                    <div class="input-group">
                                        <input type="number" step="0.01" name="descuento_porcentaje" id="descuento_porcentaje" 
                                               class="form-control @error('descuento_porcentaje') is-invalid @enderror" 
                                               value="{{ old('descuento_porcentaje', $cotizacione->descuento_porcentaje) }}" min="0" max="50">
                                        <span class="input-group-text">%</span>
                                    </div>
                                    @error('descuento_porcentaje')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Notas y Condiciones --}}
                    <div class="card border-4 borde-top-secondary shadow-sm mb-4" style="border-radius: 20px" >
                        <div class="card-header bg-transparent">
                            <h5 class="mb-0"><i class="bi bi-card-text me-2"></i>Notas y Condiciones</h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-12">
                                    <label for="condiciones_comerciales" class="form-label">Condiciones Comerciales</label>
                                    <textarea name="condiciones_comerciales" id="condiciones_comerciales" rows="3" 
                                              class="form-control @error('condiciones_comerciales') is-invalid @enderror">{{ old('condiciones_comerciales', $cotizacione->condiciones_comerciales) }}</textarea>
                                    @error('condiciones_comerciales')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="notas_internas" class="form-label">Notas Internas</label>
                                    <textarea name="notas_internas" id="notas_internas" rows="2" 
                                              class="form-control @error('notas_internas') is-invalid @enderror">{{ old('notas_internas', $cotizacione->notas_internas) }}</textarea>
                                    @error('notas_internas')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="observaciones" class="form-label">Observaciones</label>
                                    <textarea name="observaciones" id="observaciones" rows="2" 
                                              class="form-control @error('observaciones') is-invalid @enderror">{{ old('observaciones', $cotizacione->observaciones) }}</textarea>
                                    @error('observaciones')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Columna Derecha --}}
                <div class="col-lg-4">
                    {{-- Resumen Calculado --}}
                    <div class="card border-4 borde-top-secondary shadow-sm mb-4" style="border-radius: 20px" >
                        <div class="card-header bg-transparent">
                            <h5 class="mb-0"><i class="bi bi-calculator me-2"></i>Resumen</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Subtotal:</span>
                                <span class="fw-bold" id="calc-subtotal">S/ 0.00</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2 text-danger">
                                <span>Descuento:</span>
                                <span id="calc-descuento">- S/ 0.00</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Base Imponible:</span>
                                <span id="calc-base">S/ 0.00</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>IGV (18%):</span>
                                <span id="calc-igv">S/ 0.00</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between">
                                <span class="h5 mb-0">TOTAL:</span>
                                <span class="h5 mb-0 text-primary fw-bold" id="calc-total">S/ 0.00</span>
                            </div>
                        </div>
                    </div>

                    {{-- Garantías y Tiempos --}}
                    <div class="card border-4 borde-top-secondary shadow-sm mb-4" style="border-radius: 20px" >
                        <div class="card-header bg-transparent">
                            <h5 class="mb-0"><i class="bi bi-shield-check me-2"></i>Garantías y Tiempos</h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-6">
                                    <label for="garantia_paneles_anos" class="form-label small">Garantía Paneles</label>
                                    <div class="input-group input-group-sm">
                                        <input type="number" name="garantia_paneles_anos" id="garantia_paneles_anos" 
                                               class="form-control" value="{{ old('garantia_paneles_anos', $cotizacione->garantia_paneles_anos ?? 25) }}" min="1" max="30">
                                        <span class="input-group-text">años</span>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <label for="garantia_inversor_anos" class="form-label small">Garantía Inversor</label>
                                    <div class="input-group input-group-sm">
                                        <input type="number" name="garantia_inversor_anos" id="garantia_inversor_anos" 
                                               class="form-control" value="{{ old('garantia_inversor_anos', $cotizacione->garantia_inversor_anos ?? 10) }}" min="1" max="15">
                                        <span class="input-group-text">años</span>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <label for="garantia_instalacion_anos" class="form-label small">Garantía Instalación</label>
                                    <div class="input-group input-group-sm">
                                        <input type="number" name="garantia_instalacion_anos" id="garantia_instalacion_anos" 
                                               class="form-control" value="{{ old('garantia_instalacion_anos', $cotizacione->garantia_instalacion_anos ?? 2) }}" min="1" max="10">
                                        <span class="input-group-text">años</span>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <label for="tiempo_instalacion_dias" class="form-label small">Tiempo Instalación</label>
                                    <div class="input-group input-group-sm">
                                        <input type="number" name="tiempo_instalacion_dias" id="tiempo_instalacion_dias" 
                                               class="form-control" value="{{ old('tiempo_instalacion_dias', $cotizacione->tiempo_instalacion_dias ?? 5) }}" min="1">
                                        <span class="input-group-text">días</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Botones --}}
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="bi bi-check-circle me-2"></i>Guardar Cambios
                        </button>
                        <a href="{{ route('admin.crm.cotizaciones.show', $cotizacione) }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left me-2"></i>Cancelar
                        </a>
                    </div>
                </div>
            </div>
        </form>

        {{-- Sección de Ítems (fuera del formulario principal) --}}
        <div class="row g-4 mt-2">
            <div class="col-12">
                <div class="card border-4 borde-top-secondary shadow-sm mb-4" style="border-radius: 20px">
                    <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="bi bi-list-check me-2"></i>Detalle de Ítems</h5>
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalAgregarItem">
                            <i class="bi bi-plus-circle me-1"></i>Agregar Ítem
                        </button>
                    </div>
                    <div class="card-body">
                        @if($cotizacione->detalles->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="table-dark">
                                        <tr>
                                            <th class="small">Categoría</th>
                                            <th class="small">Descripción</th>
                                            <th class="small text-center">Cantidad</th>
                                            <th class="small text-center">Unidad</th>
                                            <th class="small text-end">P. Unitario</th>
                                            <th class="small text-end">Subtotal</th>
                                            <th class="small text-center">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($cotizacione->detalles as $item)
                                            @php
                                                $catInfo = \App\Models\DetalleCotizacionCrm::CATEGORIAS[$item->categoria] ?? ['nombre' => ucfirst($item->categoria), 'color' => 'secondary'];
                                            @endphp
                                            <tr>
                                                <td>
                                                    <span class="badge bg-{{ $catInfo['color'] }}">{{ $catInfo['nombre'] }}</span>
                                                </td>
                                                <td>
                                                    <strong>{{ $item->descripcion }}</strong>
                                                    @if($item->especificaciones)
                                                        <br><small class="text-muted">{{ Str::limit($item->especificaciones, 60) }}</small>
                                                    @endif
                                                </td>
                                                <td class="text-center">{{ number_format($item->cantidad, 2) }}</td>
                                                <td class="text-center">{{ $item->unidad }}</td>
                                                <td class="text-end">S/ {{ number_format($item->precio_unitario, 2) }}</td>
                                                <td class="text-end fw-bold">S/ {{ number_format($item->subtotal, 2) }}</td>
                                                <td class="text-center">
                                                    <form action="{{ route('admin.crm.cotizaciones.eliminarItem', [$cotizacione, $item->id]) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Eliminar este ítem?')">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot class="table-light">
                                        <tr>
                                            <th colspan="5" class="text-end">Total Ítems:</th>
                                            <th class="text-end">S/ {{ number_format($cotizacione->detalles->sum('subtotal'), 2) }}</th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="bi bi-inbox fs-1 text-muted d-block mb-2"></i>
                                <p class="text-muted">No hay ítems agregados</p>
                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalAgregarItem">
                                    <i class="bi bi-plus-circle me-1"></i>Agregar primer ítem
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Agregar Ítem --}}
    <div class="modal fade" id="modalAgregarItem" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{ route('admin.crm.cotizaciones.agregarItem', $cotizacione) }}" method="POST">
                    @csrf
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title"><i class="bi bi-plus-circle me-2"></i>Agregar Ítem</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Categoría <span class="text-danger">*</span></label>
                                <select name="categoria" class="form-select" required>
                                    @foreach($categorias as $key => $cat)
                                        <option value="{{ $key }}">{{ $cat['nombre'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Producto (opcional)</label>
                                <select name="producto_id" class="form-select" id="selectProducto">
                                    <option value="">-- Seleccionar producto --</option>
                                    @foreach($productos as $producto)
                                        <option value="{{ $producto->id }}" 
                                                data-descripcion="{{ $producto->name }}"
                                                data-precio="{{ $producto->precio }}">
                                            {{ $producto->codigo }} - {{ $producto->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Descripción <span class="text-danger">*</span></label>
                                <input type="text" name="descripcion" class="form-control" required maxlength="255" id="inputDescripcion">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Especificaciones técnicas</label>
                                <textarea name="especificaciones" class="form-control" rows="2"></textarea>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Cantidad <span class="text-danger">*</span></label>
                                <input type="number" name="cantidad" class="form-control" required min="0.01" step="0.01" value="1" id="inputCantidad">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Unidad <span class="text-danger">*</span></label>
                                <select name="unidad" class="form-select" required>
                                    @foreach($unidades as $key => $nombre)
                                        <option value="{{ $key }}">{{ $nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Precio Unitario <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">S/</span>
                                    <input type="number" name="precio_unitario" class="form-control" required min="0" step="0.01" id="inputPrecio">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Descuento %</label>
                                <div class="input-group">
                                    <input type="number" name="descuento_porcentaje" class="form-control" min="0" max="100" step="0.01" value="0">
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-plus-circle me-1"></i>Agregar Ítem
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script>
$(document).ready(function() {
    // Toggle sección de baterías
    $('#incluye_baterias').on('change', function() {
        $('#seccion-baterias').toggle(this.checked);
    });

    // Calcular totales en tiempo real
    function calcularTotales() {
        const equipos = parseFloat($('#precio_equipos').val()) || 0;
        const instalacion = parseFloat($('#precio_instalacion').val()) || 0;
        const estructura = parseFloat($('#precio_estructura').val()) || 0;
        const tramites = parseFloat($('#precio_tramites').val()) || 0;
        const otros = parseFloat($('#precio_otros').val()) || 0;
        const descuentoPct = parseFloat($('#descuento_porcentaje').val()) || 0;

        const subtotal = equipos + instalacion + estructura + tramites + otros;
        const descuento = subtotal * (descuentoPct / 100);
        const base = subtotal - descuento;
        const igv = base * 0.18;
        const total = base + igv;

        $('#calc-subtotal').text('S/ ' + subtotal.toLocaleString('es-PE', {minimumFractionDigits: 2}));
        $('#calc-descuento').text('- S/ ' + descuento.toLocaleString('es-PE', {minimumFractionDigits: 2}));
        $('#calc-base').text('S/ ' + base.toLocaleString('es-PE', {minimumFractionDigits: 2}));
        $('#calc-igv').text('S/ ' + igv.toLocaleString('es-PE', {minimumFractionDigits: 2}));
        $('#calc-total').text('S/ ' + total.toLocaleString('es-PE', {minimumFractionDigits: 2}));
    }

    // Event listeners para cálculos
    $('#precio_equipos, #precio_instalacion, #precio_estructura, #precio_tramites, #precio_otros, #descuento_porcentaje').on('input', calcularTotales);

    // Inicializar cálculos
    calcularTotales();

    // Autocompletar desde producto seleccionado
    $('#selectProducto').on('change', function() {
        const option = $(this).find(':selected');
        const descripcion = option.data('descripcion');
        const precio = option.data('precio');
        
        if (descripcion) {
            $('#inputDescripcion').val(descripcion);
        }
        if (precio) {
            $('#inputPrecio').val(precio);
        }
    });

    // Limpiar modal al cerrar
    $('#modalAgregarItem').on('hidden.bs.modal', function() {
        $(this).find('form')[0].reset();
    });
});
</script>
@endsection
