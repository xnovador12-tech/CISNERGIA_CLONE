{{-- Tarjeta de Prospecto para vista Kanban --}}
<div class="card prospecto-card border-start border-4 mb-2" 
     draggable="true" 
     data-id="{{ $prospecto->id }}"
     style="border-color: {{ $prospecto->scoring == 'A' ? '#198754' : ($prospecto->scoring == 'B' ? '#ffc107' : '#dc3545') }} !important;">
    <div class="card-body p-3">
        <div class="d-flex justify-content-between align-items-start mb-2">
            <h6 class="fw-bold mb-0 text-truncate" style="max-width: 180px;" title="{{ $prospecto->nombre_completo }}">
                {{ Str::limit($prospecto->nombre_completo, 25) }}
            </h6>
            <span class="scoring-mini scoring-{{ $prospecto->scoring }}">{{ $prospecto->scoring }}</span>
        </div>
        
        <p class="text-muted small mb-2">{{ $prospecto->codigo }}</p>
        
        <div class="mb-2">
            @php
                $segmentoColors = [
                    'residencial' => 'info',
                    'comercial' => 'warning',
                    'industrial' => 'primary',
                    'agricola' => 'success',
                ];
            @endphp
            <span class="badge bg-{{ $segmentoColors[$prospecto->segmento] ?? 'secondary' }} text-dark small">
                {{ ucfirst($prospecto->segmento) }}
            </span>
            @if($prospecto->consumo_mensual_kwh)
                <span class="badge bg-light text-dark small">
                    <i class="bi bi-lightning-charge"></i> {{ number_format($prospecto->consumo_mensual_kwh, 0) }} kWh
                </span>
            @endif
        </div>
        
        <div class="d-flex justify-content-between align-items-center small text-muted">
            <span>
                <i class="bi bi-person me-1"></i>
                {{ Str::limit($prospecto->asignadoA->name ?? 'Sin asignar', 10) }}
            </span>
            <span>
                <i class="bi bi-calendar3 me-1"></i>
                {{ $prospecto->created_at->diffForHumans(null, true) }}
            </span>
        </div>
        
        <div class="mt-2 pt-2 border-top d-flex justify-content-between">
            <a href="{{ route('admin.crm.prospectos.show', $prospecto) }}" 
               class="btn btn-sm btn-outline-primary py-0 px-2">
                <i class="bi bi-eye"></i>
            </a>
            <a href="{{ route('admin.crm.prospectos.edit', $prospecto) }}" 
               class="btn btn-sm btn-outline-secondary py-0 px-2">
                <i class="bi bi-pencil"></i>
            </a>
            @if($prospecto->estado === 'calificado')
                <form action="{{ route('admin.crm.prospectos.crear-oportunidad', $prospecto) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-success py-0 px-2" title="Crear Oportunidad">
                        <i class="bi bi-arrow-right-circle"></i>
                    </button>
                </form>
            @endif
        </div>
    </div>
</div>
