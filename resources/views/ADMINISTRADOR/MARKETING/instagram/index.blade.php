<div class="row mb-4">
    <div class="col-lg-4 mb-4 mb-lg-0">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold text-dark"><i class="bi bi-star-fill text-warning me-2"></i>Top Leads Instagram</h6>
            </div>
            <div class="card-body p-3 overflow-auto" style="max-height: 500px;">
                @forelse($igData['top_leads'] ?? [] as $lead)
                    <div class="d-flex align-items-center mb-3 p-2 border rounded shadow-sm bg-light">
                        <div class="position-relative">
                            <img src="{{ $lead['perfil']['profile_pic'] ?? asset('img/no-image.png') }}" 
                                 class="rounded-circle object-fit-cover border border-danger border-opacity-25" 
                                 style="width: 45px; height: 45px;" 
                                 alt="Avatar">
                            <span class="position-absolute bottom-0 start-100 translate-middle badge rounded-pill bg-danger p-1">
                                <i class="bi bi-instagram" style="font-size: 0.6rem;"></i>
                            </span>
                        </div>

                        <div class="ms-3 flex-grow-1">
                            <h6 class="mb-0 fw-bold text-dark" style="font-size: 0.9rem;">
                                {{ $lead['perfil']['first_name'] }} {{ $lead['perfil']['last_name'] }}
                            </h6>
                            
                            @if(isset($lead['perfil']['is_fallback']) && $lead['perfil']['is_fallback'])
                                <small class="text-warning fw-bold" style="font-size: 0.7rem;" title="Esperando permisos de Meta">
                                    <i class="bi bi-hourglass-split"></i> ID: {{ $lead['id'] }}
                                </small>
                            @else
                                <small class="text-success fw-bold" style="font-size: 0.7rem;">
                                    <i class="bi bi-check-circle-fill"></i> Perfil Verificado
                                </small>
                            @endif
                        </div>

                        <div class="text-end">
                            <span class="badge bg-danger text-white border">
                                Pts: {{ $lead['score_interes'] }}
                            </span>
                            <div class="small text-muted mt-1" style="font-size: 0.7rem;">
                                {{ $lead['total_comentarios'] }} <i class="bi bi-chat-dots"></i>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center text-muted py-4">
                        <i class="bi bi-people fs-1 opacity-25"></i>
                        <p class="mb-0 mt-2 small">No hay interacciones registradas aún.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <form action="{{ route('admin.marketing.metricas') }}" method="GET" class="bg-white p-3 rounded-4 shadow-sm border d-flex gap-3 flex-wrap align-items-center mb-4">
            <input type="hidden" name="periodo" value="{{ request('periodo', 'all') }}">
            <div class="flex-grow-1 d-flex gap-3 align-items-center">
                <i class="bi bi-funnel text-danger fs-5"></i>
                <div class="form-floating" style="min-width: 130px;">
                    <input type="date" name="fecha_inicio" value="{{ $fechaInicio ?? '' }}" class="form-control rounded-pill auto-submit border-danger border-opacity-25" id="igFI" placeholder="Inicio">
                    <label for="igFI">Fecha Inicio</label>
                </div>
                <div class="form-floating" style="min-width: 130px;">
                    <input type="date" name="fecha_fin" value="{{ $fechaFin ?? '' }}" class="form-control rounded-pill auto-submit border-danger border-opacity-25" id="igFF" placeholder="Fin">
                    <label for="igFF">Fecha Fin</label>
                </div>
                <div class="form-floating flex-grow-1">
                    <input type="text" name="search" value="{{ $search ?? '' }}" class="form-control rounded-pill auto-submit border-danger border-opacity-25" id="igSearch" placeholder="Buscar por palabra...">
                    <label for="igSearch"><i class="bi bi-search me-1"></i> Buscar en Publicaciones IG</label>
                </div>
            </div>
            <div>
                <a href="{{ route('admin.marketing.metricas') }}" class="btn btn-sm btn-light text-muted fw-bold rounded-pill px-3">Limpiar</a>
            </div>
        </form>

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold text-dark"><i class="bi bi-instagram text-danger me-2"></i>Media de Instagram</h6>
                <span class="badge bg-light text-secondary border rounded-pill px-3 py-2">Mostrando {{ count($igData['recent_posts'] ?? []) }} posts</span>
            </div>
            <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                <table class="table table-hover align-middle mb-0 border-0">
                    <thead class="bg-light text-muted small text-uppercase fw-bold sticky-top">
                        <tr>
                            <th class="ps-4 border-0" style="width: 90px;">Media</th>
                            <th class="border-0">Descripción</th>
                            <th class="text-center border-0">Alcance</th>
                            <th class="text-center border-0 pe-4">Gestión</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($igData['recent_posts'] ?? [] as $post)
                        <tr>
                            <td class="ps-4 py-3">
                                <img src="{{ $post['full_picture'] ?? asset('img/no-image.png') }}" class="rounded-3 shadow-sm border border-danger border-opacity-25 p-1" style="width: 60px; height: 60px; object-fit: cover;">
                            </td>
                            <td>
                                <p class="mb-1 fw-bold text-dark small" style="line-height: 1.4;">{{ Str::limit($post['message'] ?? 'Media sin texto', 100) }}</p>
                                <small class="text-muted"><i class="bi bi-instagram me-1 text-danger opacity-75"></i>{{ \Carbon\Carbon::parse($post['created_time'])->translatedFormat('d M - h:i A') }}</small>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-success bg-opacity-10 text-success border border-success rounded-pill px-2 py-1">
                                    <i class="bi bi-eye-fill"></i> {{ $post['alcance'] ?? 'N/D' }}
                                </span>
                            </td>
                            <td class="text-center pe-4">
                                @php 
                                    $cCount = collect($post['comments']['data'] ?? [])->reduce(function($total, $c) {
                                        return $total + 1 + count($c['replies']['data'] ?? []);
                                    }, 0);
                                    
                                    $hasReplies = collect($post['comments']['data'] ?? [])->contains(function($c) {
                                        return (isset($c['replies']['data']) && count($c['replies']['data']) > 0);
                                    });
                                    
                                    $btnClass = $hasReplies ? 'btn-warning text-dark border-warning' : ($cCount > 0 ? 'btn-danger text-white' : 'btn-light border text-muted');
                                @endphp
                                <button class="btn btn-sm rounded-pill fw-bold shadow-sm px-3 py-1 {{ $btnClass }}" 
                                        onclick="openCommentModal({{ json_encode($post) }}, 'ig')">
                                    <i class="bi bi-chat-heart-fill"></i> <span id="badge-count-{{ $post['id'] }}">{{ $cCount }}</span>
                                </button>
                                <a href="{{ $post['permalink'] ?? '#' }}" target="_blank" class="btn btn-sm btn-light border rounded-circle text-secondary ms-1" title="Ver en IG">
                                    <i class="bi bi-box-arrow-up-right"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">
                                <i class="bi bi-camera fs-2 d-block mb-2 opacity-25"></i>
                                <p class="mb-0 fw-bold small">No se encontraron publicaciones</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>