@extends('TEMPLATES.administrador')
@section('title', 'Cotización ' . $cotizacione->codigo)

@section('content')
    <div class="header_section">
        <div class="bg-transparent mb-3" style="height: 67px"></div>
        <div class="container-fluid">
            <div data-aos="fade-right">
                <h1 class="titulo h2 text-uppercase fw-bold mb-0">{{ $cotizacione->codigo }}</h1>
                <div style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ route('admin-dashboard.index') }}">Principal</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="#">CRM</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none link" href="{{ route('admin.crm.cotizaciones.index') }}">Cotizaciones</a></li>
                        <li class="breadcrumb-item link" aria-current="page">{{ $cotizacione->codigo }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="container-fluid mb-3">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="container-fluid mb-3">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif

    <div class="container-fluid">
        <div class="row g-4">
            {{-- Columna Principal --}}
            <div class="col-lg-8">
                {{-- Estado y Acciones --}}
                <div class="card border-4 borde-top-secondary shadow-sm mb-4" style="border-radius: 20px" data-aos="fade-up">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                            <div>
                                @php
                                    $estadoColors = [
                                        'borrador' => 'secondary', 
                                        'enviada' => 'primary', 
                                        'vista' => 'info',
                                        'en_revision' => 'warning',
                                        'aceptada' => 'success', 
                                        'rechazada' => 'danger', 
                                        'vencida' => 'dark',
                                        'cancelada' => 'dark'
                                    ];
                                @endphp
                                <span class="badge bg-{{ $estadoColors[$cotizacione->estado] ?? 'secondary' }} fs-6 px-3 py-2">
                                    <i class="bi bi-circle-fill me-1"></i>{{ ucfirst(str_replace('_', ' ', $cotizacione->estado)) }}
                                </span>
                                @if($cotizacione->version > 1)
                                    <span class="badge bg-info ms-2">Versión {{ $cotizacione->version }}</span>
                                @endif
                            </div>
                            <div class="d-flex gap-2 flex-wrap">
                                <a href="{{ route('admin.crm.cotizaciones.pdf', $cotizacione) }}" class="btn btn-danger btn-sm">
                                    <i class="bi bi-file-pdf me-1"></i>Descargar PDF
                                </a>
                                @if(!in_array($cotizacione->estado, ['aceptada', 'rechazada']))
                                    <a href="{{ route('admin.crm.cotizaciones.edit', $cotizacione) }}" class="btn btn-warning btn-sm">
                                        <i class="bi bi-pencil me-1"></i>Editar
                                    </a>
                                @endif
                                @if($cotizacione->estado === 'borrador')
                                    <form action="{{ route('admin.crm.cotizaciones.enviar', $cotizacione) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            <i class="bi bi-send me-1"></i>Enviar
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Información del Cliente --}}
                <div class="card border-4 borde-top-secondary shadow-sm mb-4" style="border-radius: 20px" data-aos="fade-up">
                    <div class="card-header bg-transparent">
                        <h5 class="mb-0"><i class="bi bi-person me-2"></i>Información del Cliente</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Oportunidad:</strong></p>
                                @if($cotizacione->oportunidad)
                                    <a href="{{ route('admin.crm.oportunidades.show', $cotizacione->oportunidad->slug) }}" class="text-decoration-none">
                                        {{ $cotizacione->oportunidad->codigo }} - {{ $cotizacione->oportunidad->nombre }}
                                    </a>
                                @else
                                    <span class="text-muted">No asignada</span>
                                @endif
                            </div>
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Prospecto/Cliente:</strong></p>
                                @if($cotizacione->oportunidad && $cotizacione->oportunidad->prospecto)
                                    {{ $cotizacione->oportunidad->prospecto->nombre_completo }}
                                    <br><small class="text-muted">{{ $cotizacione->oportunidad->prospecto->email }}</small>
                                @else
                                    <span class="text-muted">No disponible</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Especificaciones Técnicas --}}
                <div class="card border-4 borde-top-secondary shadow-sm mb-4" style="border-radius: 20px" data-aos="fade-up">
                    <div class="card-header bg-transparent">
                        <h5 class="mb-0"><i class="bi bi-cpu me-2"></i>Especificaciones Técnicas</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-4">
                            {{-- Paneles --}}
                            <div class="col-md-6">
                                <h6 class="text-muted mb-3"><i class="bi bi-sun me-2"></i>Paneles Solares</h6>
                                <table class="table table-sm table-borderless">
                                    <tr>
                                        <td class="text-muted">Potencia Total:</td>
                                        <td class="fw-bold">{{ number_format($cotizacione->potencia_kw, 2) }} kWp</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Cantidad:</td>
                                        <td>{{ $cotizacione->cantidad_paneles }} paneles</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Marca:</td>
                                        <td>{{ $cotizacione->marca_panel ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Modelo:</td>
                                        <td>{{ $cotizacione->modelo_panel ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Potencia/Panel:</td>
                                        <td>{{ $cotizacione->potencia_panel_w ?? '-' }} W</td>
                                    </tr>
                                </table>
                            </div>
                            {{-- Inversor --}}
                            <div class="col-md-6">
                                <h6 class="text-muted mb-3"><i class="bi bi-lightning-charge me-2"></i>Inversor</h6>
                                <table class="table table-sm table-borderless">
                                    <tr>
                                        <td class="text-muted">Marca:</td>
                                        <td>{{ $cotizacione->marca_inversor ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Modelo:</td>
                                        <td>{{ $cotizacione->modelo_inversor ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Potencia:</td>
                                        <td>{{ $cotizacione->potencia_inversor_kw ?? '-' }} kW</td>
                                    </tr>
                                </table>
                            </div>
                            {{-- Baterías (si aplica) --}}
                            @if($cotizacione->incluye_baterias)
                                <div class="col-md-6">
                                    <h6 class="text-muted mb-3"><i class="bi bi-battery-charging me-2"></i>Sistema de Almacenamiento</h6>
                                    <table class="table table-sm table-borderless">
                                        <tr>
                                            <td class="text-muted">Marca:</td>
                                            <td>{{ $cotizacione->marca_bateria ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Modelo:</td>
                                            <td>{{ $cotizacione->modelo_bateria ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Capacidad:</td>
                                            <td>{{ $cotizacione->capacidad_baterias_kwh ?? '-' }} kWh</td>
                                        </tr>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Producción y Ahorro --}}
                <div class="card border-4 borde-top-secondary shadow-sm mb-4" style="border-radius: 20px" data-aos="fade-up">
                    <div class="card-header bg-transparent">
                        <h5 class="mb-0"><i class="bi bi-graph-up-arrow me-2"></i>Producción y Ahorro Estimado</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-4">
                            <div class="col-md-4">
                                <div class="text-center p-3 bg-light rounded">
                                    <i class="bi bi-sun fs-1 text-warning"></i>
                                    <h6 class="mt-2 mb-1">Producción Anual</h6>
                                    <h4 class="text-primary mb-0">{{ number_format($cotizacione->produccion_anual_kwh ?? 0, 0) }} kWh</h4>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="text-center p-3 bg-light rounded">
                                    <i class="bi bi-cash-stack fs-1 text-success"></i>
                                    <h6 class="mt-2 mb-1">Ahorro Anual</h6>
                                    <h4 class="text-success mb-0">S/ {{ number_format($cotizacione->ahorro_anual_soles ?? 0, 0) }}</h4>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="text-center p-3 bg-light rounded">
                                    <i class="bi bi-arrow-repeat fs-1 text-info"></i>
                                    <h6 class="mt-2 mb-1">Retorno Inversión</h6>
                                    <h4 class="text-info mb-0">{{ number_format($cotizacione->retorno_inversion_anos ?? 0, 1) }} años</h4>
                                </div>
                            </div>
                        </div>
                        
                        @if($cotizacione->ahorro_25_anos_soles)
                            <div class="mt-3 p-3 bg-success bg-opacity-10 rounded">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span>Ahorro total en 25 años:</span>
                                    <span class="h4 text-success mb-0">S/ {{ number_format($cotizacione->ahorro_25_anos_soles, 0) }}</span>
                                </div>
                            </div>
                        @endif
                        
                        @if($cotizacione->reduccion_co2_toneladas)
                            <div class="mt-2 p-3 bg-info bg-opacity-10 rounded">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span><i class="bi bi-tree me-2"></i>Reducción de CO₂ anual:</span>
                                    <span class="fw-bold">{{ number_format($cotizacione->reduccion_co2_toneladas, 2) }} toneladas</span>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Notas y Condiciones --}}
                @if($cotizacione->condiciones_comerciales || $cotizacione->observaciones)
                    <div class="card border-4 borde-top-secondary shadow-sm mb-4" style="border-radius: 20px" data-aos="fade-up">
                        <div class="card-header bg-transparent">
                            <h5 class="mb-0"><i class="bi bi-card-text me-2"></i>Notas y Condiciones</h5>
                        </div>
                        <div class="card-body">
                            @if($cotizacione->condiciones_comerciales)
                                <h6>Condiciones Comerciales:</h6>
                                <p class="text-muted">{{ $cotizacione->condiciones_comerciales }}</p>
                            @endif
                            @if($cotizacione->observaciones)
                                <h6>Observaciones:</h6>
                                <p class="text-muted mb-0">{{ $cotizacione->observaciones }}</p>
                            @endif
                        </div>
                    </div>
                @endif
            </div>

            {{-- Columna Lateral --}}
            <div class="col-lg-4">
                {{-- Detalle de Ítems --}}
                @if($cotizacione->detalles->count() > 0)
                <div class="card border-4 borde-top-secondary shadow-sm mb-4" style="border-radius: 20px" data-aos="fade-up">
                    <div class="card-header bg-transparent">
                        <h5 class="mb-0"><i class="bi bi-list-check me-2"></i>Detalle de la Cotización</h5>
                    </div>
                    <div class="card-body p-0">
                        @foreach($detallesPorCategoria as $categoria => $items)
                            @php
                                $catInfo = \App\Models\DetalleCotizacionCrm::CATEGORIAS[$categoria] ?? ['nombre' => ucfirst($categoria), 'color' => 'secondary', 'icono' => 'bi-box'];
                            @endphp
                            <div class="border-bottom">
                                <div class="px-3 py-2 bg-{{ $catInfo['color'] }} bg-opacity-10">
                                    <h6 class="mb-0 text-{{ $catInfo['color'] }}">
                                        <i class="bi {{ $catInfo['icono'] }} me-2"></i>{{ $catInfo['nombre'] }}
                                    </h6>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-sm table-hover mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="small">Descripción</th>
                                                <th class="small text-center">Cant.</th>
                                                <th class="small text-end">P.Unit</th>
                                                <th class="small text-end">Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($items as $item)
                                                <tr>
                                                    <td class="small">
                                                        {{ $item->descripcion }}
                                                        @if($item->especificaciones)
                                                            <br><small class="text-muted">{{ Str::limit($item->especificaciones, 50) }}</small>
                                                        @endif
                                                    </td>
                                                    <td class="small text-center">{{ number_format($item->cantidad, 2) }} {{ $item->unidad }}</td>
                                                    <td class="small text-end">S/ {{ number_format($item->precio_unitario, 2) }}</td>
                                                    <td class="small text-end fw-bold">S/ {{ number_format($item->subtotal, 2) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot class="table-light">
                                            <tr>
                                                <th colspan="3" class="small text-end">Subtotal {{ $catInfo['nombre'] }}:</th>
                                                <th class="small text-end">S/ {{ number_format($items->sum('subtotal'), 2) }}</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- Resumen de Precios --}}
                <div class="card border-4 borde-top-secondary shadow-sm mb-4" style="border-radius: 20px" data-aos="fade-up">
                    <div class="card-header bg-transparent">
                        <h5 class="mb-0"><i class="bi bi-receipt me-2"></i>Resumen de Inversión</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm table-borderless mb-0">
                            <tr>
                                <td>Equipos:</td>
                                <td class="text-end">S/ {{ number_format($cotizacione->precio_equipos ?? 0, 2) }}</td>
                            </tr>
                            <tr>
                                <td>Instalación:</td>
                                <td class="text-end">S/ {{ number_format($cotizacione->precio_instalacion ?? 0, 2) }}</td>
                            </tr>
                            @if($cotizacione->precio_estructura > 0)
                                <tr>
                                    <td>Estructura:</td>
                                    <td class="text-end">S/ {{ number_format($cotizacione->precio_estructura, 2) }}</td>
                                </tr>
                            @endif
                            @if($cotizacione->precio_tramites > 0)
                                <tr>
                                    <td>Trámites:</td>
                                    <td class="text-end">S/ {{ number_format($cotizacione->precio_tramites, 2) }}</td>
                                </tr>
                            @endif
                            @if($cotizacione->precio_otros > 0)
                                <tr>
                                    <td>Otros:</td>
                                    <td class="text-end">S/ {{ number_format($cotizacione->precio_otros, 2) }}</td>
                                </tr>
                            @endif
                            <tr class="border-top">
                                <td><strong>Subtotal:</strong></td>
                                <td class="text-end"><strong>S/ {{ number_format($cotizacione->subtotal ?? 0, 2) }}</strong></td>
                            </tr>
                            @if($cotizacione->descuento_monto > 0)
                                <tr class="text-danger">
                                    <td>Descuento ({{ $cotizacione->descuento_porcentaje }}%):</td>
                                    <td class="text-end">- S/ {{ number_format($cotizacione->descuento_monto, 2) }}</td>
                                </tr>
                            @endif
                            <tr>
                                <td>IGV (18%):</td>
                                <td class="text-end">S/ {{ number_format($cotizacione->igv ?? 0, 2) }}</td>
                            </tr>
                            <tr class="border-top">
                                <td><h5 class="mb-0">TOTAL:</h5></td>
                                <td class="text-end"><h5 class="mb-0 text-primary">S/ {{ number_format($cotizacione->total ?? 0, 2) }}</h5></td>
                            </tr>
                        </table>
                    </div>
                </div>

                {{-- Garantías --}}
                <div class="card border-4 borde-top-secondary shadow-sm mb-4" style="border-radius: 20px" data-aos="fade-up">
                    <div class="card-header bg-transparent">
                        <h5 class="mb-0"><i class="bi bi-shield-check me-2"></i>Garantías</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Paneles Solares:</span>
                            <span class="fw-bold">{{ $cotizacione->garantia_paneles_anos ?? 25 }} años</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Inversor:</span>
                            <span class="fw-bold">{{ $cotizacione->garantia_inversor_anos ?? 10 }} años</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Instalación:</span>
                            <span class="fw-bold">{{ $cotizacione->garantia_instalacion_anos ?? 2 }} años</span>
                        </div>
                        @if($cotizacione->incluye_baterias && $cotizacione->garantia_baterias_anos)
                            <div class="d-flex justify-content-between">
                                <span>Baterías:</span>
                                <span class="fw-bold">{{ $cotizacione->garantia_baterias_anos }} años</span>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Fechas y Vigencia --}}
                <div class="card border-4 borde-top-secondary shadow-sm mb-4" style="border-radius: 20px" data-aos="fade-up">
                    <div class="card-header bg-transparent">
                        <h5 class="mb-0"><i class="bi bi-calendar3 me-2"></i>Fechas</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Fecha Emisión:</span>
                            <span>{{ $cotizacione->fecha_emision ? $cotizacione->fecha_emision->format('d/m/Y') : '-' }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Válida Hasta:</span>
                            <span class="{{ $cotizacione->fecha_vigencia && $cotizacione->fecha_vigencia->isPast() ? 'text-danger fw-bold' : '' }}">
                                {{ $cotizacione->fecha_vigencia ? $cotizacione->fecha_vigencia->format('d/m/Y') : '-' }}
                            </span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Tiempo Instalación:</span>
                            <span>{{ $cotizacione->tiempo_instalacion_dias ?? 5 }} días</span>
                        </div>
                        @if($cotizacione->fecha_envio)
                            <div class="d-flex justify-content-between mb-2">
                                <span>Fecha Envío:</span>
                                <span>{{ $cotizacione->fecha_envio->format('d/m/Y H:i') }}</span>
                            </div>
                        @endif
                        @if($cotizacione->fecha_respuesta)
                            <div class="d-flex justify-content-between">
                                <span>Fecha Respuesta:</span>
                                <span>{{ $cotizacione->fecha_respuesta->format('d/m/Y H:i') }}</span>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Acciones de Estado --}}
                @if(in_array($cotizacione->estado, ['enviada', 'vista', 'en_revision']))
                    <div class="card border-4 borde-top-secondary shadow-sm mb-4" style="border-radius: 20px" data-aos="fade-up">
                        <div class="card-header bg-transparent">
                            <h5 class="mb-0"><i class="bi bi-check2-square me-2"></i>Acciones</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <form action="{{ route('admin.crm.cotizaciones.aprobar', $cotizacione) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-success w-100">
                                        <i class="bi bi-check-circle me-2"></i>Marcar como Aprobada
                                    </button>
                                </form>
                                <form action="{{ route('admin.crm.cotizaciones.rechazar', $cotizacione) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-danger w-100">
                                        <i class="bi bi-x-circle me-2"></i>Marcar como Rechazada
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Información de Auditoría --}}
                <div class="card border-0 shadow-sm" style="border-radius: 10px" data-aos="fade-up">
                    <div class="card-body small text-muted">
                        <div class="d-flex justify-content-between mb-1">
                            <span>Creado por:</span>
                            <span>{{ $cotizacione->usuario->persona->name ?? $cotizacione->usuario->email ?? '-' }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-1">
                            <span>Creado:</span>
                            <span>{{ $cotizacione->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Actualizado:</span>
                            <span>{{ $cotizacione->updated_at->format('d/m/Y H:i') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
