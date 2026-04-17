@extends('TEMPLATES.administrador')

@section('title', 'Marketing | Inteligencia de Datos Meta - Cisnergia')

@section('css')
<style>
    :root {
        --cisnergia-dark: #1e293b;
        --cisnergia-sun: #f59e0b;
        --cisnergia-energy: #f97316;
        --fb-blue: #0866ff;
        --ig-pink: #d62976;
    }

    .kpi-card {
        border: none;
        border-radius: 15px;
        transition: transform 0.3s ease;
        overflow: hidden;
    }
    .kpi-card:hover { transform: translateY(-5px); }
    
    .bg-gradient-solar { background: linear-gradient(135deg, var(--cisnergia-dark) 0%, #334155 100%); color: white; }
    .bg-gradient-energy { background: linear-gradient(135deg, var(--cisnergia-energy) 0%, #fb923c 100%); color: white; }

    .search-panel {
        background: white;
        border-radius: 20px;
        padding: 25px;
        box-shadow: 0 10px 15px -3px rgba(0,0,0,0.05);
    }

    .comment-row {
        border-radius: 12px;
        border: 1px solid #f1f5f9;
        background: white;
        transition: 0.2s;
    }
    .comment-row:hover { border-color: var(--cisnergia-sun); background: #fffcf5; }

    .platform-badge {
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: bold;
        text-transform: uppercase;
    }
</style>
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-0 text-cisnergia-dark"><i class="bi bi-graph-up-arrow text-warning me-2"></i> Inteligencia de Mercado</h2>
            <p class="text-muted mb-0">Análisis de sentimientos y captación Cisnergia Perú.</p>
        </div>
        <a href="{{ route('admin.marketing.metricas') }}" class="btn btn-outline-dark rounded-pill px-4 fw-bold">
            <i class="bi bi-arrow-left me-2"></i> Volver al Radar
        </a>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-md-3">
            <div class="card kpi-card bg-gradient-solar h-100 shadow">
                <div class="card-body text-center p-4">
                    <div class="display-6 fw-bold mb-1">{{ count($allComments) }}</div>
                    <div class="small opacity-75 fw-bold">COMENTARIOS ANALIZADOS</div>
                    <i class="bi bi-chat-square-text fs-1 opacity-25 mt-3 d-block"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card kpi-card bg-white h-100 shadow-sm border-start border-warning border-5">
                <div class="card-body p-4 text-center">
                    <div class="display-6 fw-bold text-dark mb-1">{{ $allComments->sum('like_count') }}</div>
                    <div class="small text-muted fw-bold">TOTAL REACCIONES</div>
                    <i class="bi bi-hand-thumbs-up fs-1 text-warning opacity-50 mt-3 d-block"></i>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            @if($topFan)
            <div class="card kpi-card bg-gradient-energy h-100 shadow">
                <div class="card-body p-4 d-flex align-items-center justify-content-between">
                    <div>
                        <div class="badge bg-white text-orange mb-2">TOP FAN (MÁS ACTIVO)</div>
                        <h3 class="fw-bold mb-0">{{ $topFan['from']['name'] ?? 'Usuario Meta' }}</h3>
                        <p class="mb-0 opacity-75">ID: {{ $topFan['from']['id'] ?? 'N/A' }}</p>
                    </div>
                    <div class="text-end">
                        <i class="bi bi-star-fill display-4"></i>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

    <div class="search-panel mb-4">
        <form action="{{ route('admin.marketing.metricas_globales') }}" method="GET" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label fw-bold small text-muted">BÚSQUEDA POR PALABRA CLAVE</label>
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0"><i class="bi bi-search"></i></span>
                    <input type="text" name="keyword" value="{{ $keyword }}" class="form-control border-start-0" placeholder="Ej: Precio, Info, Stock...">
                </div>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-bold small text-muted">FILTRAR POR CANAL</label>
                <select name="canal" class="form-select">
                    <option value="all" {{ $canal == 'all' ? 'selected' : '' }}>Todos los canales</option>
                    <option value="fb" {{ $canal == 'fb' ? 'selected' : '' }}>Facebook</option>
                    <option value="ig" {{ $canal == 'ig' ? 'selected' : '' }}>Instagram</option>
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-warning w-100 fw-bold rounded-pill shadow-sm">
                    <i class="bi bi-funnel-fill me-2"></i> Aplicar Inteligencia
                </button>
            </div>
            <div class="col-md-2 text-center">
                <a href="{{ route('admin.marketing.metricas_globales') }}" class="btn btn-link text-muted small px-0">Limpiar filtros</a>
            </div>
        </form>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between">
                    <h5 class="mb-0 fw-bold">Auditoría de Interacciones</h5>
                    <span class="badge bg-light text-dark">{{ $allComments->count() }} resultados</span>
                </div>
                <div class="card-body p-4 overflow-auto" style="max-height: 800px;">
                    @forelse($allComments as $comment)
                        <div class="comment-row p-3 mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div class="d-flex align-items-center gap-2">
                                    <span class="platform-badge {{ $comment['platform'] == 'Facebook' ? 'bg-primary text-white' : 'bg-danger text-white' }}">
                                        {{ $comment['platform'] }}
                                    </span>
                                    <h6 class="mb-0 fw-bold small">{{ $comment['from']['name'] ?? 'Usuario' }}</h6>
                                </div>
                                <span class="badge-likes small"><i class="bi bi-heart-fill"></i> {{ $comment['like_count'] ?? 0 }}</span>
                            </div>
                            <p class="mb-2 text-dark" style="font-size: 0.95rem;">"{{ $comment['message'] }}"</p>
                            <hr class="my-2 opacity-25">
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted fw-bold" style="font-size: 0.7rem;">EN POST: {{ Str::limit($comment['post_message'], 50) }}</small>
                                <a href="javascript:void(0)" onclick="openInRadar('{{ $comment['post_id'] }}')" class="btn btn-sm btn-link text-warning p-0 fw-bold" style="font-size: 0.75rem;">Gestionar <i class="bi bi-arrow-right-short"></i></a>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5">
                            <i class="bi bi-search fs-1 text-muted"></i>
                            <p class="mt-3">No hay comentarios que coincidan con "{{ $keyword }}"</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 mb-4 bg-light">
                <div class="card-body p-4">
                    <h6 class="fw-bold text-uppercase small text-muted mb-4"><i class="bi bi-trophy-fill text-warning me-2"></i>Mejor Comentario</h6>
                    @if($mejorComentario)
                        <div class="p-3 bg-white rounded-3 border border-warning">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <i class="bi bi-person-circle fs-4 text-warning"></i>
                                <div class="fw-bold small">{{ $mejorComentario['from']['name'] ?? 'Usuario' }}</div>
                            </div>
                            <p class="small mb-2 italic">"{{ $mejorComentario['message'] }}"</p>
                            <div class="badge bg-warning text-dark w-100">{{ $mejorComentario['like_count'] }} Reacciones</div>
                        </div>
                    @else
                        <p class="small text-muted text-center">No hay data suficiente.</p>
                    @endif
                </div>
            </div>

            <div class="card bg-gradient-solar text-white border-0 shadow-sm rounded-4">
                <div class="card-body p-4 text-center">
                    <i class="bi bi-lightbulb-fill fs-1 text-warning mb-3 d-block"></i>
                    <h5 class="fw-bold">Tips Cisnergia</h5>
                    <p class="small opacity-75">Busca la palabra <strong>"Precio"</strong> para identificar prospectos calientes y enviarles una campaña de Email Marketing inmediata.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function openInRadar(postId) {
        // Redirige al radar principal y podrías implementar una lógica para abrir el post automáticamente
        window.location.href = "{{ route('admin.marketing.metricas') }}?search=" + postId;
    }
</script>
@endpush