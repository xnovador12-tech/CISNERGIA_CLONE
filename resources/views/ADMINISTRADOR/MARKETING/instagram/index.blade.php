<div class="row">
    <div class="col-lg-4">
        <div class="card card-solar border-0 shadow-sm mb-4">
            <div class="card-header header-ig py-3">
                <h6 class="mb-0 fw-bold"><i class="bi bi-instagram me-2"></i>Top Leads Instagram</h6>
            </div>
            <div class="list-group list-group-flush">
                @forelse($igData['top_leads'] ?? [] as $lead)
                    <div class="list-group-item d-flex justify-content-between align-items-center py-3">
                        <div class="fw-bold small">{{ $lead['nombre'] }}</div>
                        <span class="badge bg-danger text-white rounded-pill">{{ $lead['score_interes'] }} pts</span>
                    </div>
                @empty
                    <div class="p-4 text-center text-muted small">Sin datos de Instagram.</div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        @forelse($igData['recent_posts'] ?? [] as $post)
            <div class="post-wrapper shadow-sm" style="border-left-color: #dc2743;">
                <div class="p-3 border-bottom bg-light d-flex gap-3 align-items-center">
                    @if(isset($post['full_picture']))
                        <img src="{{ $post['full_picture'] }}" class="post-img-header shadow-sm border-danger">
                    @endif
                    <div>
                        <p class="mb-1 fw-bold text-dark small">{{ Str::limit($post['message'] ?? 'Media de Instagram', 100) }}</p>
                        <small class="text-muted"><i class="bi bi-instagram me-1"></i>Instagram Post</small>
                    </div>
                </div>
                <div class="bg-white">
                    @if(isset($post['comments']['data']))
                        @foreach($post['comments']['data'] as $comment)
                            <div class="comment-item" id="comment-{{ $comment['id'] }}">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0 fw-bold small text-danger">{{ $comment['from']['name'] ?? 'Usuario IG' }}</h6>
                                    <button onclick="replyTo('{{ $comment['id'] }}')" class="btn btn-sm btn-link text-danger p-0"><i class="bi bi-chat-heart-fill"></i></button>
                                </div>
                                <p class="mb-0 small text-secondary">"{{ $comment['message'] }}"</p>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        @empty
            <div class="text-center py-5 bg-white rounded-4 shadow-sm">
                <p class="text-muted">No se encontraron publicaciones de Instagram.</p>
            </div>
        @endforelse
    </div>
</div>