<div class="row">
    <div class="col-12 mb-4">
        <form action="{{ route('admin.marketing.metricas') }}" method="GET" class="bg-white p-3 rounded-4 shadow-sm border d-flex gap-3 flex-wrap align-items-center">
            <input type="hidden" name="periodo" value="{{ request('periodo', 'all') }}">
            <div class="flex-grow-1 d-flex gap-3 align-items-center">
                <i class="bi bi-funnel text-danger fs-5"></i>
                <div class="form-floating" style="min-width: 150px;">
                    <input type="date" name="fecha_inicio" value="{{ $fechaInicio ?? '' }}" class="form-control rounded-pill auto-submit border-danger border-opacity-25" id="igFI" placeholder="Inicio">
                    <label for="igFI">Fecha Inicio</label>
                </div>
                <div class="form-floating" style="min-width: 150px;">
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
    </div>

    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold text-dark"><i class="bi bi-instagram text-danger me-2"></i>Media de Instagram</h6>
                <span class="badge bg-light text-secondary border rounded-pill px-3 py-2">Mostrando {{ count($igData['recent_posts'] ?? []) }} posts de Meta</span>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 border-0">
                    <thead class="bg-light text-muted small text-uppercase fw-bold">
                        <tr>
                            <th class="ps-4 border-0" style="width: 100px;">Media</th>
                            <th class="border-0">Descripción del Post</th>
                            <th class="text-center border-0">Alcance</th>
                            <th class="text-center border-0 pe-4">Gestión</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($igData['recent_posts'] ?? [] as $post)
                        <tr>
                            <td class="ps-4 py-3">
                                <img src="{{ $post['full_picture'] ?? asset('img/no-image.png') }}" class="rounded-3 shadow-sm border border-danger border-opacity-25 p-1" style="width: 70px; height: 70px; object-fit: cover;">
                            </td>
                            <td>
                                <p class="mb-1 fw-bold text-dark small" style="line-height: 1.4;">{{ Str::limit($post['message'] ?? 'Media de Instagram sin texto', 150) }}</p>
                                <small class="text-muted"><i class="bi bi-instagram me-1 text-danger opacity-75"></i>{{ \Carbon\Carbon::parse($post['created_time'])->translatedFormat('d M, Y - h:i A') }}</small>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-success bg-opacity-10 text-success border border-success rounded-pill px-3 py-1">
                                    <i class="bi bi-eye-fill me-1"></i> {{ $post['alcance'] ?? 'N/D' }}
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
                                <button class="btn btn-sm rounded-pill fw-bold shadow-sm px-4 py-1 {{ $btnClass }}" 
                                        onclick="openCommentModal({{ json_encode($post) }}, 'ig')">
                                    <i class="bi bi-chat-heart-fill me-1"></i> <span id="badge-count-{{ $post['id'] }}">{{ $cCount }}</span>
                                </button>
                                <a href="{{ $post['permalink'] ?? '#' }}" target="_blank" class="btn btn-sm btn-light border rounded-circle text-secondary ms-1" title="Ver en IG">
                                    <i class="bi bi-box-arrow-up-right"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">
                                <i class="bi bi-camera fs-1 d-block mb-3 opacity-25"></i>
                                <p class="mb-0 fw-bold">No se encontraron publicaciones de Instagram</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer bg-white py-3 border-top text-center text-muted small">
                Mostrando <strong>{{ count($igData['recent_posts'] ?? []) }}</strong> publicaciones recientes cargadas. Para ver más historial, ajusta el rango de fechas.
            </div>
        </div>
    </div>
</div>