@extends('TEMPLATES.administrador')
@section('title', 'Nueva Cotización')

@section('content')
    <div class="header_section">
        <div class="bg-transparent mb-3" style="height: 67px"></div>
        <div class="container-fluid">
            <div data-aos="fade-right">
                <h1 class="titulo h2 text-uppercase fw-bold mb-0">NUEVA COTIZACIÓN</h1>
                <div style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ route('admin-dashboard.index') }}">Principal</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="#">CRM</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ route('admin.crm.cotizaciones.index') }}">Cotizaciones</a></li>
                        <li class="breadcrumb-item link" aria-current="page">Nueva</li>
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
        <form action="{{ route('admin.crm.cotizaciones.store') }}" method="POST">
            @csrf
            
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
                                                    {{ old('oportunidad_id', $oportunidadId) == $oportunidad->id ? 'selected' : '' }}
                                                    data-potencia="{{ $oportunidad->potencia_kw }}"
                                                    data-paneles="{{ $oportunidad->cantidad_paneles }}"
                                                    data-monto="{{ $oportunidad->monto_estimado }}">
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
                                    <label for="vigencia_dias" class="form-label">Vigencia (días) <span class="text-danger">*</span></label>
                                    <select name="vigencia_dias" id="vigencia_dias" class="form-select @error('vigencia_dias') is-invalid @enderror" required>
                                        <option value="15" {{ old('vigencia_dias') == 15 ? 'selected' : '' }}>15 días</option>
                                        <option value="30" {{ old('vigencia_dias', 30) == 30 ? 'selected' : '' }}>30 días</option>
                                        <option value="45" {{ old('vigencia_dias') == 45 ? 'selected' : '' }}>45 días</option>
                                        <option value="60" {{ old('vigencia_dias') == 60 ? 'selected' : '' }}>60 días</option>
                                        <option value="90" {{ old('vigencia_dias') == 90 ? 'selected' : '' }}>90 días</option>
                                    </select>
                                    @error('vigencia_dias')
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
                                           value="{{ old('potencia_kw') }}" required>
                                    @error('potencia_kw')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <label for="cantidad_paneles" class="form-label">Cantidad Paneles <span class="text-danger">*</span></label>
                                    <input type="number" name="cantidad_paneles" id="cantidad_paneles" 
                                           class="form-control @error('cantidad_paneles') is-invalid @enderror" 
                                           value="{{ old('cantidad_paneles') }}" required min="1">
                                    @error('cantidad_paneles')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <label for="potencia_panel_w" class="form-label">Potencia/Panel (W) <span class="text-danger">*</span></label>
                                    <input type="number" step="0.01" name="potencia_panel_w" id="potencia_panel_w" 
                                           class="form-control @error('potencia_panel_w') is-invalid @enderror" 
                                           value="{{ old('potencia_panel_w', 550) }}" required>
                                    @error('potencia_panel_w')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <label for="marca_panel" class="form-label">Marca Panel <span class="text-danger">*</span></label>
                                    <select name="marca_panel" id="marca_panel" class="form-select @error('marca_panel') is-invalid @enderror" required>
                                        <option value="">Seleccione...</option>
                                        <option value="Jinko Solar" {{ old('marca_panel') == 'Jinko Solar' ? 'selected' : '' }}>Jinko Solar</option>
                                        <option value="Trina Solar" {{ old('marca_panel') == 'Trina Solar' ? 'selected' : '' }}>Trina Solar</option>
                                        <option value="Canadian Solar" {{ old('marca_panel') == 'Canadian Solar' ? 'selected' : '' }}>Canadian Solar</option>
                                        <option value="LONGi" {{ old('marca_panel') == 'LONGi' ? 'selected' : '' }}>LONGi</option>
                                        <option value="JA Solar" {{ old('marca_panel') == 'JA Solar' ? 'selected' : '' }}>JA Solar</option>
                                        <option value="Risen" {{ old('marca_panel') == 'Risen' ? 'selected' : '' }}>Risen</option>
                                    </select>
                                    @error('marca_panel')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="modelo_panel" class="form-label">Modelo Panel</label>
                                    <input type="text" name="modelo_panel" id="modelo_panel" 
                                           class="form-control @error('modelo_panel') is-invalid @enderror" 
                                           value="{{ old('modelo_panel') }}" placeholder="Ej: Tiger Neo N-type 550W">
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
                                        <option value="Huawei" {{ old('marca_inversor') == 'Huawei' ? 'selected' : '' }}>Huawei</option>
                                        <option value="Growatt" {{ old('marca_inversor') == 'Growatt' ? 'selected' : '' }}>Growatt</option>
                                        <option value="Sungrow" {{ old('marca_inversor') == 'Sungrow' ? 'selected' : '' }}>Sungrow</option>
                                        <option value="Fronius" {{ old('marca_inversor') == 'Fronius' ? 'selected' : '' }}>Fronius</option>
                                        <option value="SMA" {{ old('marca_inversor') == 'SMA' ? 'selected' : '' }}>SMA</option>
                                        <option value="Goodwe" {{ old('marca_inversor') == 'Goodwe' ? 'selected' : '' }}>Goodwe</option>
                                        <option value="Deye" {{ old('marca_inversor') == 'Deye' ? 'selected' : '' }}>Deye</option>
                                    </select>
                                    @error('marca_inversor')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="modelo_inversor" class="form-label">Modelo Inversor</label>
                                    <input type="text" name="modelo_inversor" id="modelo_inversor" 
                                           class="form-control @error('modelo_inversor') is-invalid @enderror" 
                                           value="{{ old('modelo_inversor') }}" placeholder="Ej: SUN-10K-SG04LP3">
                                    @error('modelo_inversor')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="potencia_inversor_kw" class="form-label">Potencia Inversor (kW) <span class="text-danger">*</span></label>
                                    <input type="number" step="0.01" name="potencia_inversor_kw" id="potencia_inversor_kw" 
                                           class="form-control @error('potencia_inversor_kw') is-invalid @enderror" 
                                           value="{{ old('potencia_inversor_kw') }}" required>
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
                                    <input class="form-check-input" type="checkbox" id="incluye_baterias" name="incluye_baterias" value="1" {{ old('incluye_baterias') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="incluye_baterias">Incluir</label>
                                </div>
                            </div>
                        </div>
                        <div class="card-body" id="seccion-baterias" style="{{ old('incluye_baterias') ? '' : 'display: none;' }}">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label for="marca_bateria" class="form-label">Marca Batería</label>
                                    <select name="marca_bateria" id="marca_bateria" class="form-select @error('marca_bateria') is-invalid @enderror">
                                        <option value="">Seleccione...</option>
                                        <option value="Pylontech" {{ old('marca_bateria') == 'Pylontech' ? 'selected' : '' }}>Pylontech</option>
                                        <option value="BYD" {{ old('marca_bateria') == 'BYD' ? 'selected' : '' }}>BYD</option>
                                        <option value="Huawei LUNA" {{ old('marca_bateria') == 'Huawei LUNA' ? 'selected' : '' }}>Huawei LUNA</option>
                                        <option value="Tesla Powerwall" {{ old('marca_bateria') == 'Tesla Powerwall' ? 'selected' : '' }}>Tesla Powerwall</option>
                                        <option value="LG Chem" {{ old('marca_bateria') == 'LG Chem' ? 'selected' : '' }}>LG Chem</option>
                                    </select>
                                    @error('marca_bateria')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="modelo_bateria" class="form-label">Modelo Batería</label>
                                    <input type="text" name="modelo_bateria" id="modelo_bateria" 
                                           class="form-control @error('modelo_bateria') is-invalid @enderror" 
                                           value="{{ old('modelo_bateria') }}">
                                    @error('modelo_bateria')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="capacidad_baterias_kwh" class="form-label">Capacidad Total (kWh)</label>
                                    <input type="number" step="0.01" name="capacidad_baterias_kwh" id="capacidad_baterias_kwh" 
                                           class="form-control @error('capacidad_baterias_kwh') is-invalid @enderror" 
                                           value="{{ old('capacidad_baterias_kwh') }}">
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
                                               value="{{ old('precio_equipos', 0) }}" required>
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
                                               value="{{ old('precio_instalacion', 0) }}" required>
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
                                               value="{{ old('precio_estructura', 0) }}">
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
                                               value="{{ old('precio_tramites', 0) }}">
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
                                               value="{{ old('precio_otros', 0) }}">
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
                                               value="{{ old('descuento_porcentaje', 0) }}" min="0" max="50">
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
                                              class="form-control @error('condiciones_comerciales') is-invalid @enderror"
                                              placeholder="Condiciones de pago, plazos de entrega, etc.">{{ old('condiciones_comerciales') }}</textarea>
                                    @error('condiciones_comerciales')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="notas_internas" class="form-label">Notas Internas</label>
                                    <textarea name="notas_internas" id="notas_internas" rows="2" 
                                              class="form-control @error('notas_internas') is-invalid @enderror"
                                              placeholder="Notas visibles solo para el equipo interno">{{ old('notas_internas') }}</textarea>
                                    @error('notas_internas')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="observaciones" class="form-label">Observaciones</label>
                                    <textarea name="observaciones" id="observaciones" rows="2" 
                                              class="form-control @error('observaciones') is-invalid @enderror"
                                              placeholder="Observaciones generales">{{ old('observaciones') }}</textarea>
                                    @error('observaciones')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Columna Derecha - Resumen y Garantías --}}
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
                            
                            <hr>
                            
                            <h6 class="mt-3">Producción Estimada:</h6>
                            <div class="d-flex justify-content-between mb-1 small">
                                <span>Diaria:</span>
                                <span id="calc-prod-diaria">0 kWh</span>
                            </div>
                            <div class="d-flex justify-content-between mb-1 small">
                                <span>Mensual:</span>
                                <span id="calc-prod-mensual">0 kWh</span>
                            </div>
                            <div class="d-flex justify-content-between small">
                                <span>Anual:</span>
                                <span class="fw-bold text-success" id="calc-prod-anual">0 kWh</span>
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
                                               class="form-control" value="{{ old('garantia_paneles_anos', 25) }}" min="1" max="30">
                                        <span class="input-group-text">años</span>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <label for="garantia_inversor_anos" class="form-label small">Garantía Inversor</label>
                                    <div class="input-group input-group-sm">
                                        <input type="number" name="garantia_inversor_anos" id="garantia_inversor_anos" 
                                               class="form-control" value="{{ old('garantia_inversor_anos', 10) }}" min="1" max="15">
                                        <span class="input-group-text">años</span>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <label for="garantia_instalacion_anos" class="form-label small">Garantía Instalación</label>
                                    <div class="input-group input-group-sm">
                                        <input type="number" name="garantia_instalacion_anos" id="garantia_instalacion_anos" 
                                               class="form-control" value="{{ old('garantia_instalacion_anos', 2) }}" min="1" max="10">
                                        <span class="input-group-text">años</span>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <label for="tiempo_instalacion_dias" class="form-label small">Tiempo Instalación</label>
                                    <div class="input-group input-group-sm">
                                        <input type="number" name="tiempo_instalacion_dias" id="tiempo_instalacion_dias" 
                                               class="form-control" value="{{ old('tiempo_instalacion_dias', 5) }}" min="1">
                                        <span class="input-group-text">días</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Datos de Producción --}}
                    <div class="card border-4 borde-top-secondary shadow-sm mb-4" style="border-radius: 20px" >
                        <div class="card-header bg-transparent">
                            <h5 class="mb-0"><i class="bi bi-graph-up me-2"></i>Parámetros de Cálculo</h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-6">
                                    <label for="horas_sol_pico" class="form-label small">Horas Sol Pico</label>
                                    <div class="input-group input-group-sm">
                                        <input type="number" step="0.1" name="horas_sol_pico" id="horas_sol_pico" 
                                               class="form-control" value="{{ old('horas_sol_pico', 5.0) }}" min="1" max="10">
                                        <span class="input-group-text">h/día</span>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <label for="tarifa_electrica_kwh" class="form-label small">Tarifa Eléctrica</label>
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text">S/</span>
                                        <input type="number" step="0.01" name="tarifa_electrica_kwh" id="tarifa_electrica_kwh" 
                                               class="form-control" value="{{ old('tarifa_electrica_kwh', 0.65) }}" min="0">
                                        <span class="input-group-text">/kWh</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Botones --}}
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="bi bi-check-circle me-2"></i>Crear Cotización
                        </button>
                        <a href="{{ route('admin.crm.cotizaciones.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left me-2"></i>Cancelar
                        </a>
                    </div>
                </div>
            </div>
        </form>
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

    // Calcular producción estimada
    function calcularProduccion() {
        const potenciaKw = parseFloat($('#potencia_kw').val()) || 0;
        const horasSol = parseFloat($('#horas_sol_pico').val()) || 5;
        const eficiencia = 0.85; // Factor de eficiencia del sistema

        const prodDiaria = potenciaKw * horasSol * eficiencia;
        const prodMensual = prodDiaria * 30;
        const prodAnual = prodDiaria * 365;

        $('#calc-prod-diaria').text(prodDiaria.toFixed(1) + ' kWh');
        $('#calc-prod-mensual').text(prodMensual.toFixed(0) + ' kWh');
        $('#calc-prod-anual').text(prodAnual.toFixed(0) + ' kWh');
    }

    // Event listeners para cálculos
    $('#precio_equipos, #precio_instalacion, #precio_estructura, #precio_tramites, #precio_otros, #descuento_porcentaje').on('input', calcularTotales);
    $('#potencia_kw, #horas_sol_pico').on('input', calcularProduccion);

    // Cargar datos de oportunidad seleccionada
    $('#oportunidad_id').on('change', function() {
        const selected = $(this).find(':selected');
        const potencia = selected.data('potencia');
        const paneles = selected.data('paneles');
        
        if (potencia) $('#potencia_kw').val(potencia);
        if (paneles) $('#cantidad_paneles').val(paneles);
        
        calcularProduccion();
    });

    // Calcular potencia total desde cantidad de paneles
    $('#cantidad_paneles, #potencia_panel_w').on('input', function() {
        const cantidad = parseInt($('#cantidad_paneles').val()) || 0;
        const potenciaW = parseFloat($('#potencia_panel_w').val()) || 0;
        const potenciaKw = (cantidad * potenciaW) / 1000;
        
        $('#potencia_kw').val(potenciaKw.toFixed(2));
        calcularProduccion();
    });

    // Inicializar cálculos
    calcularTotales();
    calcularProduccion();

    // Si hay oportunidad preseleccionada, cargar sus datos
    if ($('#oportunidad_id').val()) {
        $('#oportunidad_id').trigger('change');
    }
});
</script>
@endsection
