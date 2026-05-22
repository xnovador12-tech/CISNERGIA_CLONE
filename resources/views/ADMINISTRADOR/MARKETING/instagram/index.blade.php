<div class="row g-3 g-md-4">
    <div class="col-12 col-lg-4">
        <div class="card border-0 shadow-sm rounded-4 h-100" style="border-top: 4px solid #1C3146;">
            <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold" style="color: #1C3146;"><i class="bi bi-star-fill me-2" style="color: #20c997;"></i>Top Leads Instagram</h6>
            </div>
            <div class="card-body p-3 overflow-auto" style="max-height: 500px;">
                @forelse($igData['top_leads'] ?? [] as $lead)
                    @php
                        $nombreLead = isset($lead['perfil']['is_fallback']) && $lead['perfil']['is_fallback']
                            ? ($lead['nombre'] ?? 'Usuario')
                            : trim(($lead['perfil']['first_name'] ?? '') . ' ' . ($lead['perfil']['last_name'] ?? ''));
                    @endphp
                    <div class="d-flex align-items-center mb-3 p-2 border rounded shadow-sm bg-light flex-wrap gap-2">
                        <div class="position-relative flex-shrink-0">
                            <img src="{{ $lead['perfil']['profile_pic'] ?? asset('img/no-image.png') }}"
                                 class="rounded-circle object-fit-cover border"
                                 style="width: 45px; height: 45px; border-color: #1C3146 !important;" alt="Avatar">
                            <span class="position-absolute bottom-0 start-100 translate-middle badge rounded-pill p-1" style="background-color: #1C3146;">
                                <i class="bi bi-instagram" style="font-size: 0.6rem;"></i>
                            </span>
                        </div>
                        <div class="ms-2 flex-grow-1 min-w-0">
                            <h6 class="mb-0 fw-bold text-dark text-truncate" style="font-size: 0.9rem;">{{ $nombreLead ?: 'Usuario' }}</h6>
                            @if(isset($lead['perfil']['is_fallback']) && $lead['perfil']['is_fallback'])
                                <small class="fw-bold" style="font-size: 0.7rem; color: #6c757d;">
                                    <i class="bi bi-hourglass-split"></i> ID: {{ $lead['id'] }}
                                </small>
                            @else
                                <small class="fw-bold" style="font-size: 0.7rem; color: #20c997;">
                                    <i class="bi bi-check-circle-fill"></i> Perfil Verificado
                                </small>
                            @endif
                        </div>
                        <div class="text-end flex-shrink-0">
                            <span class="badge text-white" style="background-color: #1C3146;">Pts: {{ $lead['score_interes'] }}</span>
                            <div class="small mt-1" style="font-size: 0.7rem; color: #6c757d;">
                                {{ $lead['total_comentarios'] }} <i class="bi bi-chat-dots"></i>
                            </div>
                        </div>
                        <button class="btn btn-sm rounded-pill fw-bold w-100 mt-1 btn-convertir-lead"
                                style="background-color: #20c997; color: white; border: none; font-size: 0.75rem;"
                                data-plataforma="instagram"
                                data-social-id="{{ $lead['id'] }}"
                                data-nombre="{{ $nombreLead ?: 'Usuario' }}"
                                data-puntaje="{{ $lead['score_interes'] }}">
                            <i class="bi bi-person-plus-fill me-1"></i> Convertir a Prospecto
                        </button>
                    </div>
                @empty
                    <div class="text-center py-4" style="color: #6c757d;">
                        <i class="bi bi-people fs-1 opacity-25"></i>
                        <p class="mb-0 mt-2 small">No hay interacciones registradas aún.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center flex-wrap gap-2">
                <h6 class="mb-0 fw-bold" style="color: #1C3146;"><i class="bi bi-instagram me-2"></i>Media de Instagram</h6>
                <span class="badge bg-light border rounded-pill px-3 py-2" id="ig-count" style="color: #6c757d;">
                    Mostrando {{ count($igData['recent_posts'] ?? []) }} posts
                </span>
            </div>
            <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
                <table class="table table-hover align-middle mb-0 border-0">
                    <thead class="bg-light small text-uppercase fw-bold sticky-top" style="color: #6c757d;">
                        <tr>
                            <th class="ps-4 border-0" style="width: 90px;">Media</th>
                            <th class="border-0">Descripción</th>
                            <th class="text-center border-0 d-none d-md-table-cell">Alcance</th>
                            <th class="text-center border-0 pe-4">Gestión</th>
                        </tr>
                    </thead>
                    <tbody id="igFeedBody">
                        @forelse($igData['recent_posts'] ?? [] as $post)
                        <tr>
                            <td class="ps-4 py-3">
                                <img src="{{ $post['full_picture'] ?? asset('img/no-image.png') }}" class="rounded-3 shadow-sm border" style="width: 60px; height: 60px; object-fit: cover; border-color: #1C3146 !important;">
                            </td>
                            <td>
                                <p class="mb-1 fw-bold text-dark small" style="line-height: 1.4;">{{ Str::limit($post['message'] ?? 'Media sin texto', 100) }}</p>
                                <small style="color: #6c757d;"><i class="bi bi-instagram me-1" style="color: #1C3146;"></i>{{ \Carbon\Carbon::parse($post['created_time'])->translatedFormat('d M - h:i A') }}</small>
                            </td>
                            <td class="text-center d-none d-md-table-cell">
                                <span class="badge rounded-pill px-2 py-1" style="background-color: rgba(32, 201, 151, 0.1); color: #20c997; border:1px solid #20c997;">
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
                                    $btnPostStyle = $hasReplies
                                        ? ['class' => 'text-white', 'style' => 'background-color: #20c997; border: none;']
                                        : ($cCount > 0
                                            ? ['class' => 'text-white', 'style' => 'background-color: #1C3146; border: none;']
                                            : ['class' => 'btn-light border', 'style' => 'color: #6c757d;']);
                                    $postPayload = e(json_encode($post));
                                @endphp
                                <button class="btn btn-sm rounded-pill fw-bold shadow-sm px-3 py-1 {{ $btnPostStyle['class'] }}" style="{{ $btnPostStyle['style'] }}" data-post="{{ $postPayload }}" data-plataforma="ig">
                                    <i class="bi bi-chat-heart-fill"></i> <span>{{ $cCount }}</span>
                                </button>
                                <a href="{{ $post['permalink'] ?? '#' }}" target="_blank" class="btn btn-sm btn-light border rounded-circle ms-1" style="color: #6c757d;" title="Ver en IG">
                                    <i class="bi bi-box-arrow-up-right"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-5" style="color: #6c757d;">
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
