@extends('TEMPLATES.administrador')

@section('title', 'Marketing | Inteligencia de Datos Meta - Cisnergia')

@section('css')
<style>
    :root {
        --cisnergia-dark: #1C3146; /* Azul Oscuro Corporativo */
        --cisnergia-light-green: #20c997; /* Verde claro para éxitos */
        --cisnergia-muted: #6c757d;
    }

    .kpi-card {
        border: none;
        border-radius: 15px;
        transition: transform 0.3s ease;
        overflow: hidden;
    }
    .kpi-card:hover { transform: translateY(-5px); }
    
    .bg-gradient-solar { background: linear-gradient(135deg, var(--cisnergia-dark) 0%, #2a4561 100%); color: white; }
    .bg-gradient-energy { background: linear-gradient(135deg, var(--cisnergia-light-green) 0%, #17a57a 100%); color: white; }

    .search-panel {
        background: white;
        border-radius: 20px;
        padding: 25px;
        box-shadow: 0 10px 15px -3px rgba(0,0,0,0.05);
        border-left: 5px solid var(--cisnergia-dark);
    }

    .comment-row {
        border-radius: 12px;
        border: 1px solid #f1f5f9;
        background: white;
        transition: 0.2s;
    }
    .comment-row:hover { border-color: var(--cisnergia-dark); background: #f8fafc; }

    .platform-badge {
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: bold;
        text-transform: uppercase;
        background-color: var(--cisnergia-dark);
        color: white;
    }
    
    .btn-custom { background-color: var(--cisnergia-dark); border-color: var(--cisnergia-dark); color: white; }
    .btn-custom:hover { background-color: #132435; border-color: #132435; color: white; }
    
    .avatar-sm { width: 35px; height: 35px; object-fit: cover; }
    .avatar-lg { width: 50px; height: 50px; object-fit: cover; }
    
    .text-cisnergia-dark { color: var(--cisnergia-dark) !important; }
    .text-cisnergia-green { color: var(--cisnergia-light-green) !important; }
    .text-muted-custom { padding-top: 0.85em; color: var(--cisnergia-muted); }
</style>
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-0 text-cisnergia-dark"><i class="bi bi-graph-up-arrow text-cisnergia-green me-2"></i> Inteligencia de Mercado</h2>
            <p class="mb-0 text-muted-custom">Análisis de sentimientos y captación Cisnergia Perú.</p>
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
            <div class="card kpi-card bg-white h-100 shadow-sm border-start border-5" style="border-color: #1C3146 !important;">
                <div class="card-body p-4 text-center">
                    <div class="display-6 fw-bold text-dark mb-1">{{ $allComments->sum('like_count') }}</div>
                    <div class="small fw-bold" style="color: #6c757d;">TOTAL REACCIONES</div>
                    <i class="bi bi-hand-thumbs-up fs-1 mt-3 d-block" style="color: #20c997; opacity: 0.8;"></i>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            @if($topFan)
            <div class="card kpi-card bg-gradient-energy h-100 shadow">
                <div class="card-body p-4 d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-3">
                        <div class="position-relative">
                            <img src="{{ $topFan['perfil']['profile_pic'] ?? asset('img/no-image.png') }}" class="rounded-circle avatar-lg border border-2 border-white shadow-sm" alt="Top Fan Avatar">
                            <span class="position-absolute bottom-0 start-100 translate-middle p-1 bg-white border border-light rounded-circle">
                                <i class="bi {{ $topFan['is_ig'] ? 'bi-instagram text-cisnergia-dark' : 'bi-facebook text-cisnergia-dark' }}" style="font-size: 0.65rem;"></i>
                            </span>
                        </div>
                        <div>
                            <div class="badge bg-white text-cisnergia-dark mb-1">TOP FAN (MÁS ACTIVO)</div>
                            <h3 class="fw-bold mb-0 text-white">
                                @if(isset($topFan['perfil']['is_fallback']) && $topFan['perfil']['is_fallback'] && isset($topFan['from']['name']))
                                    {{ $topFan['from']['name'] }}
                                @else
                                    {{ $topFan['perfil']['first_name'] ?? 'Usuario' }} {{ $topFan['perfil']['last_name'] ?? '' }}
                                @endif
                            </h3>
                            <div class="small mt-1 text-white fw-bold">
                                {{ $topFan['total_comentarios'] }} Interacciones
                                @if(isset($topFan['perfil']['is_fallback']) && $topFan['perfil']['is_fallback'])
                                    <span class="ms-2 opacity-75" style="font-size:0.7rem;"><i class="bi bi-hourglass-split"></i> ID: {{ $topFan['from']['id'] }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="text-end">
                        <i class="bi bi-star-fill display-4 text-white opacity-50"></i>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

    <div class="search-panel mb-4">
        <form action="{{ route('admin.marketing.metricas_globales') }}" method="GET" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label fw-bold small" style="color: #6c757d;">BÚSQUEDA POR PALABRA CLAVE</label>
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0"><i class="bi bi-search"></i></span>
                    <input type="text" name="keyword" value="{{ $keyword }}" class="form-control border-start-0" placeholder="Ej: Precio, Info, Stock...">
                </div>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-bold small" style="color: #6c757d;">FILTRAR POR CANAL</label>
                <select name="canal" class="form-select">
                    <option value="all" {{ $canal == 'all' ? 'selected' : '' }}>Todos los canales</option>
                    <option value="fb" {{ $canal == 'fb' ? 'selected' : '' }}>Facebook</option>
                    <option value="ig" {{ $canal == 'ig' ? 'selected' : '' }}>Instagram</option>
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-custom w-100 fw-bold rounded-pill shadow-sm">
                    <i class="bi bi-funnel-fill me-2"></i> Aplicar Inteligencia
                </button>
            </div>
            <div class="col-md-2 text-center">
                <a href="{{ route('admin.marketing.metricas_globales') }}" class="btn btn-link small px-0" style="color: #6c757d;">Limpiar filtros</a>
            </div>
        </form>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between">
                    <h5 class="mb-0 fw-bold text-cisnergia-dark">Auditoría de Interacciones</h5>
                    <span class="badge bg-light text-dark border">{{ $allComments->count() }} resultados</span>
                </div>
                <div class="card-body p-4 overflow-auto" style="max-height: 800px;">
                    @forelse($allComments as $comment)
                        <div class="comment-row p-3 mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div class="d-flex align-items-center gap-2">
                                    <span class="platform-badge {{ $comment['platform'] == 'Facebook' ? '' : 'bg-secondary' }}">
                                        {{ $comment['platform'] }}
                                    </span>
                                    <h6 class="mb-0 fw-bold small text-dark">{{ $comment['from']['name'] ?? 'Usuario' }}</h6>
                                </div>
                                <span class="badge small" style="background-color: #f1f5f9; color: #1C3146;"><i class="bi bi-heart-fill" style="color: #20c997;"></i> {{ $comment['like_count'] ?? 0 }}</span>
                            </div>
                            <p class="mb-2 text-dark" style="font-size: 0.95rem;">"{{ $comment['message'] }}"</p>
                            <hr class="my-2 opacity-25">
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="fw-bold" style="font-size: 0.7rem; color: #6c757d;">EN POST: {{ Str::limit($comment['post_message'], 50) }}</small>
                                <a href="javascript:void(0)" onclick="openInRadar('{{ $comment['post_id'] }}')" class="btn btn-sm btn-link p-0 fw-bold text-cisnergia-green" style="font-size: 0.75rem; text-decoration: none;">Gestionar <i class="bi bi-arrow-right-short"></i></a>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5">
                            <i class="bi bi-search fs-1" style="color: #6c757d;"></i>
                            <p class="mt-3" style="color: #6c757d;">No hay comentarios que coincidan con "{{ $keyword }}"</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 mb-4 bg-light">
                <div class="card-body p-4">
                    <h6 class="fw-bold text-uppercase small mb-4" style="color: #6c757d;"><i class="bi bi-trophy-fill text-cisnergia-green me-2"></i>Mejor Comentario</h6>
                    @if($mejorComentario)
                        <div class="p-3 bg-white rounded-3 border shadow-sm" style="border-color: #20c997 !important;">
                            <div class="d-flex align-items-center gap-3 mb-3 pb-2 border-bottom border-light">
                                <img src="{{ $mejorComentario['perfil']['profile_pic'] ?? asset('img/no-image.png') }}" class="rounded-circle avatar-sm shadow-sm border border-light" alt="Avatar">
                                <div>
                                    <div class="fw-bold small text-dark">
                                        @if(isset($mejorComentario['perfil']['is_fallback']) && $mejorComentario['perfil']['is_fallback'] && isset($mejorComentario['from']['name']))
                                            {{ $mejorComentario['from']['name'] }}
                                        @else
                                            {{ $mejorComentario['perfil']['first_name'] ?? 'Usuario' }} {{ $mejorComentario['perfil']['last_name'] ?? '' }}
                                        @endif
                                    </div>
                                    @if(isset($mejorComentario['perfil']['is_fallback']) && $mejorComentario['perfil']['is_fallback'])
                                        <div style="font-size: 0.65rem; color: #6c757d;"><i class="bi bi-hourglass-split"></i> ID: {{ $mejorComentario['from']['id'] }}</div>
                                    @endif
                                </div>
                            </div>
                            <p class="small mb-3 italic text-secondary">"{{ $mejorComentario['message'] }}"</p>
                            <div class="badge w-100 py-2" style="background-color: rgba(32, 201, 151, 0.1); color: #1C3146;"><i class="bi bi-heart-fill me-1" style="color: #20c997;"></i> {{ $mejorComentario['like_count'] }} Reacciones</div>
                        </div>
                    @else
                        <p class="small text-center py-4" style="color: #6c757d;">No hay data suficiente.</p>
                    @endif
                </div>
            </div>

            <div class="card bg-gradient-solar text-white border-0 shadow-sm rounded-4">
                <div class="card-body p-4 text-center">
                    <i class="bi bi-lightbulb-fill fs-1 text-cisnergia-green mb-3 d-block"></i>
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
        window.location.href = "{{ route('admin.marketing.metricas') }}?search=" + postId;
    }
</script>
@endpush