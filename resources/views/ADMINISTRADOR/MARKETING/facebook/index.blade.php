<div class="row">
    <div class="col-lg-4">
        <div class="card card-solar border-0 shadow-sm mb-4">
            <div class="card-header header-solar py-3">
                <h6 class="mb-0 fw-bold"><i class="bi bi-trophy me-2"></i>Top Leads Facebook</h6>
            </div>
            <div class="list-group list-group-flush">
                @forelse($fbData['top_leads'] ?? [] as $lead)
                    <div class="list-group-item d-flex justify-content-between align-items-center py-3">
                        <div class="d-flex align-items-center">
                            <div class="user-initials me-3">{{ substr($lead['nombre'], 0, 1) }}</div>
                            <div>
                                <div class="fw-bold small">{{ $lead['nombre'] }}</div>
                                <small class="text-muted">{{ $lead['total_comentarios'] }} interacciones</small>
                            </div>
                        </div>
                        <span class="badge bg-warning text-dark px-2">{{ $lead['score_interes'] }} pts</span>
                    </div>
                @empty
                    <div class="p-4 text-center text-muted small">Sin datos en el ranking.</div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        @forelse($fbData['recent_posts'] ?? [] as $post)
            <div class="post-wrapper shadow-sm">
                <div class="p-3 border-bottom bg-light d-flex gap-3 align-items-center">
                    @if(isset($post['full_picture']))
                        <img src="{{ $post['full_picture'] }}" class="post-img-header shadow-sm">
                    @endif
                    <div>
                        <p class="mb-1 fw-bold text-dark small">{{ Str::limit($post['message'] ?? 'Post de Cisnergia', 100) }}</p>
                        <small class="text-muted"><i class="bi bi-clock me-1"></i>{{ \Carbon\Carbon::parse($post['created_time'])->diffForHumans() }}</small>
                    </div>
                </div>
                <div class="bg-white">
                    @if(isset($post['comments']['data']) && count($post['comments']['data']) > 0)
                        @foreach($post['comments']['data'] as $comment)
                            <div class="comment-item" id="comment-{{ $comment['id'] }}">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <h6 class="mb-0 fw-bold small text-primary">{{ $comment['from']['name'] ?? 'Usuario' }}</h6>
                                    <div class="btn-group">
                                        <button onclick="replyTo('{{ $comment['id'] }}')" class="btn btn-sm btn-link p-0 me-2"><i class="bi bi-chat-dots-fill"></i></button>
                                        <button onclick="deleteComment('{{ $comment['id'] }}')" class="btn btn-sm btn-link text-danger p-0"><i class="bi bi-trash-fill"></i></button>
                                    </div>
                                </div>
                                <p class="mb-0 small text-secondary">"{{ $comment['message'] }}"</p>
                            </div>
                        @endforeach
                    @else
                        <div class="p-3 text-center text-muted small">Sin comentarios recientes.</div>
                    @endif
                </div>
            </div>
        @empty
            <div class="text-center py-5 bg-white rounded-4 shadow-sm">
                <p class="text-muted">No se encontraron publicaciones de Facebook.</p>
            </div>
        @endforelse
    </div>
</div>