@extends('TEMPLATES.administrador')

@section('title', 'Marketing | Radar Meta Cisnergia')

@section('css')
<style>
    :root { --cisnergia-dark: #1e293b; --cisnergia-sun: #f59e0b; --cisnergia-energy: #f97316; }
    .header-radar { background: linear-gradient(135deg, var(--cisnergia-dark) 0%, #334155 100%); border-radius: 15px; color: white; }
    .nav-pills .nav-link { color: var(--cisnergia-dark); font-weight: bold; border-radius: 30px; padding: 10px 25px; margin: 0 5px; transition: 0.3s; }
    .nav-pills .nav-link.active { background-color: var(--cisnergia-energy); color: white; box-shadow: 0 4px 10px rgba(249, 115, 22, 0.3); }
    
    /* Diseño de Burbuja Interactiva */
    .comment-bubble { 
        background: white; 
        border-radius: 15px; 
        padding: 15px; 
        margin-bottom: 12px; 
        border: 2px solid #e2e8f0; 
        transition: all 0.2s; 
        cursor: pointer;
        position: relative;
    }
    .comment-bubble:hover { border-color: var(--cisnergia-sun); box-shadow: 0 4px 10px rgba(245, 158, 11, 0.1); }
    
    /* Estado Seleccionado para Responder */
    .comment-bubble.selected-reply {
        border-color: var(--cisnergia-energy) !important;
        background-color: #fff8f1;
    }

    /* Acciones Ocultas (Hover) */
    .comment-actions {
        position: absolute;
        top: 15px;
        right: 15px;
        opacity: 0;
        transition: opacity 0.2s;
        display: flex;
        gap: 8px;
        background: rgba(255,255,255,0.9);
        padding: 4px 10px;
        border-radius: 20px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        align-items: center;
    }
    .comment-bubble:hover .comment-actions { opacity: 1; }

    .badge-likes { background: #eff6ff; color: #0866ff; border-radius: 10px; padding: 4px 8px; font-size: 0.75rem; transition: 0.3s;}
    .user-initials { width: 35px; height: 35px; border-radius: 50%; background: #e2e8f0; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 0.8rem; color: var(--cisnergia-dark); }
    
    /* Botón Like Animado */
    .btn-like-crm { border: none; background: transparent; font-size: 0.85rem; font-weight: 600; transition: 0.2s; }
    .btn-like-crm:hover { transform: scale(1.05); }
    .like-active { color: #0866ff; }
    .like-inactive { color: #64748b; }
</style>
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="header-radar p-4 mb-4 shadow-sm d-flex flex-column flex-md-row justify-content-between align-items-center">
        <div>
            <h2 class="fw-bold mb-1"><i class="bi bi-radar me-2"></i> Radar Meta: Comando Central</h2>
            <p class="mb-0 opacity-75">Gestión de interacciones Cisnergia Perú.</p>
        </div>
        <div class="mt-3 mt-md-0 d-flex gap-2">
            <a href="{{ route('admin.marketing.metricas_globales') }}" class="btn btn-light text-dark fw-bold rounded-pill border-warning border-2">
                <i class="bi bi-bar-chart-line-fill me-2 text-warning"></i> Métricas Globales
            </a>
        </div>
    </div>

    <ul class="nav nav-pills mb-4" id="radarTabs" role="tablist">
        <li class="nav-item">
            <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#fb-content"><i class="bi bi-facebook me-2"></i> Facebook</button>
        </li>
        <li class="nav-item">
            <button class="nav-link" data-bs-toggle="pill" data-bs-target="#ig-content"><i class="bi bi-instagram me-2"></i> Instagram</button>
        </li>
    </ul>

    <div class="tab-content bg-white p-4 rounded-4 shadow-sm">
        <div class="tab-pane fade show active" id="fb-content">
            @include('ADMINISTRADOR.MARKETING.facebook.index', ['fbData' => $fbData])
        </div>
        <div class="tab-pane fade" id="ig-content">
            @include('ADMINISTRADOR.MARKETING.instagram.index', ['igData' => $igData])
        </div>
    </div>
</div>

<div class="modal fade" id="modalComentarios" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content border-0 rounded-4 shadow-lg">
            <div class="modal-header bg-dark text-white py-3">
                <h5 class="modal-title fw-bold"><i class="bi bi-chat-dots-fill me-2 text-warning"></i> Gestión de Comentarios</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-0" style="background: #f8fafc;">
                <div class="row g-0">
                    <div class="col-lg-5 bg-white p-4 border-end">
                        <div id="postPreviewContainer" style="position: sticky; top: 0;"></div>
                    </div>
                    <div class="col-lg-7 d-flex flex-column" style="height: 75vh;">
                        <div class="p-3 bg-light border-bottom text-center">
                            <span class="small text-muted fw-bold"><i class="bi bi-info-circle me-1"></i> Haz clic en cualquier comentario para responder.</span>
                        </div>
                        <div class="flex-grow-1 overflow-auto p-4" id="commentsListContainer"></div>
                        <div class="p-3 bg-white border-top shadow-lg">
                            <div id="replyIndicator" class="mb-2 d-none">
                                <span class="badge bg-warning text-dark rounded-pill px-3 py-2 fw-bold shadow-sm">
                                    Respondiendo a: <span id="replyToName"></span> 
                                    <i class="bi bi-x-circle-fill ms-2 text-danger" style="cursor:pointer;" onclick="cancelReply(event)"></i>
                                </span>
                            </div>
                            <div class="input-group">
                                <textarea id="textNewComment" class="form-control rounded-4 bg-light border-0" rows="2" placeholder="Escribe tu comentario o respuesta..."></textarea>
                                <button class="btn btn-primary fw-bold px-4 rounded-4 ms-2" id="btnSendAction"><i class="bi bi-send-fill"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Configuración global de Axios para Laravel CSRF
    axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
    axios.defaults.headers.common['X-CSRF-TOKEN'] = '{{ csrf_token() }}';

    let currentObjectId = null;
    let replyToId = null;
    let allCommentsInModal = [];
    let currentPlatform = 'fb'; 

    function updateBadgeCount(postId, change) {
        const badgeSpan = document.getElementById(`badge-count-${postId}`);
        if(badgeSpan) {
            let currentCount = parseInt(badgeSpan.innerText) || 0;
            let newCount = currentCount + change;
            badgeSpan.innerText = newCount < 0 ? 0 : newCount;
            
            const btn = badgeSpan.closest('button');
            if(newCount > 0 && btn.classList.contains('btn-light')) {
                btn.classList.remove('btn-light', 'text-muted');
                btn.classList.add(currentPlatform === 'ig' ? 'btn-danger' : 'btn-primary', 'text-white');
            } else if(newCount === 0) {
                btn.classList.remove('btn-primary', 'btn-danger', 'btn-warning', 'text-white', 'text-dark');
                btn.classList.add('btn-light', 'text-muted');
            }
        }
    }

    window.openCommentModal = function(post, platform) {
        currentObjectId = post.id;
        currentPlatform = platform;
        cancelReply();
        
        document.getElementById('postPreviewContainer').innerHTML = `
            <img src="${post.full_picture || '{{ asset('img/no-image.png') }}'}" class="img-fluid rounded-4 shadow-sm mb-3">
            <h6 class="fw-bold text-dark">Descripción:</h6>
            <p class="text-secondary small mb-3">${post.message || post.caption || 'Sin texto'}</p>
            <a href="${post.permalink_url || post.permalink || '#'}" target="_blank" class="btn btn-sm btn-outline-dark rounded-pill w-100 fw-bold">Ver en Red Social <i class="bi bi-box-arrow-up-right"></i></a>
        `;

        allCommentsInModal = post.comments ? (post.comments.data || []) : [];
        renderModalComments(allCommentsInModal);
        new bootstrap.Modal(document.getElementById('modalComentarios')).show();
    }

    function renderModalComments(comments) {
        const container = document.getElementById('commentsListContainer');
        if(comments.length === 0) {
            container.innerHTML = `<div class="text-center py-5 text-muted"><i class="bi bi-chat-square-dots fs-1 opacity-25"></i><p class="mt-2">No hay comentarios aún.</p></div>`;
            return;
        }

        let html = '';
        comments.forEach(c => {
            let replies = c.comments ? c.comments.data : (c.replies ? c.replies.data : []);
            let hasReplies = replies.length > 0;
            let borderStyle = hasReplies ? 'border-left: 4px solid #f59e0b;' : '';

            // Lógica para pintar si ya le dimos Like o no
            let userLikes = c.user_likes === true;
            let btnLikeClass = userLikes ? 'like-active' : 'like-inactive';
            let btnLikeText = userLikes ? 'Te gusta' : 'Me gusta';
            let iconLikeClass = userLikes ? 'bi-hand-thumbs-up-fill' : 'bi-hand-thumbs-up';

            let likeActionHtml = currentPlatform === 'fb' 
                ? `<button class="btn-like-crm ${btnLikeClass}" onclick="toggleLikeAction('${c.id}', ${userLikes}, event)">
                     <i class="bi ${iconLikeClass}"></i> ${btnLikeText}
                   </button>` 
                : `<span class="badge bg-light text-secondary"><i class="bi bi-info-circle"></i> IG: Solo respuestas</span>`;

            let isSelected = (replyToId === c.id) ? 'selected-reply' : '';

            html += `
            <div class="comment-bubble mb-3 ${isSelected}" id="modal-c-${c.id}" style="${borderStyle}" onclick="prepareReply('${c.id}', '${c.from ? c.from.name : 'Usuario'}')">
                
                <div class="comment-actions">
                    ${likeActionHtml}
                    <div class="vr mx-1"></div>
                    <button class="btn btn-sm text-danger p-0 px-1" onclick="deleteComment('${c.id}', false, null, event)" title="Eliminar"><i class="bi bi-trash fs-6"></i></button>
                </div>

                <div class="d-flex justify-content-between mb-2">
                    <div class="d-flex gap-2 align-items-center">
                        <div class="user-initials bg-dark text-white">${(c.from && c.from.name ? c.from.name : 'U').substring(0,1)}</div>
                        <h6 class="mb-0 fw-bold small text-dark">${c.from ? c.from.name : 'Usuario'}</h6>
                    </div>
                </div>
                
                <p class="mb-2 text-dark small pe-5">"${c.message}"</p>
                
                <div class="d-flex align-items-center gap-2">
                    <span class="badge-likes" id="likes-count-${c.id}"><i class="bi ${currentPlatform === 'fb' ? 'bi-hand-thumbs-up-fill' : 'bi-heart-fill'}"></i> <span class="like-number">${c.like_count || 0}</span></span>
                </div>

                <div class="ps-4 ms-2 mt-2 border-start">
                    ${replies.map(r => `
                        <div class="bg-light p-2 rounded mb-2 position-relative" id="modal-c-${r.id}" onclick="event.stopPropagation()">
                            <div class="d-flex justify-content-between">
                                <strong class="small text-primary">${r.from ? r.from.name : 'Cisnergia'}</strong>
                                <button class="btn btn-sm text-danger p-0" onclick="deleteComment('${r.id}', true, '${c.id}', event)"><i class="bi bi-x-circle-fill"></i></button>
                            </div>
                            <p class="mb-0 small text-muted">${r.message}</p>
                        </div>
                    `).join('')}
                </div>
            </div>`;
        });
        container.innerHTML = html;
    }

    // SELECCIONAR PARA RESPONDER
    window.prepareReply = function(id, name) {
        replyToId = id;
        document.querySelectorAll('.comment-bubble').forEach(el => el.classList.remove('selected-reply'));
        document.getElementById(`modal-c-${id}`).classList.add('selected-reply');
        
        document.getElementById('replyIndicator').classList.remove('d-none');
        document.getElementById('replyToName').innerText = name;
        document.getElementById('textNewComment').focus();
    }

    window.cancelReply = function(event = null) {
        if(event) event.stopPropagation();
        replyToId = null;
        document.querySelectorAll('.comment-bubble').forEach(el => el.classList.remove('selected-reply'));
        document.getElementById('replyIndicator').classList.add('d-none');
        document.getElementById('textNewComment').value = '';
    }

    // PUBLICAR (Refactorizado con Axios)
    document.getElementById('btnSendAction').addEventListener('click', async function() {
        const message = document.getElementById('textNewComment').value;
        if(!message) return;

        const fakeId = 'temp-' + Date.now();
        const newObj = { id: fakeId, message: message, from: { name: 'Cisnergia (Tú)' }};
        
        if (replyToId) {
            let parent = allCommentsInModal.find(c => c.id === replyToId);
            if(parent) {
                if(currentPlatform === 'ig') {
                    if(!parent.replies) parent.replies = {data: []};
                    parent.replies.data.push(newObj);
                } else {
                    if(!parent.comments) parent.comments = {data: []};
                    parent.comments.data.push(newObj);
                }
            }
        } else {
            allCommentsInModal.unshift(newObj);
        }
        
        const currentReplyId = replyToId;
        cancelReply(); 
        renderModalComments(allCommentsInModal);
        updateBadgeCount(currentObjectId, 1);
        
        // Petición Axios al backend
        try {
            await axios.post("{{ route('admin.marketing.comment.publish') }}", {
                object_id: currentReplyId || currentObjectId,
                message: message,
                is_ig: currentPlatform === 'ig'
            });
        } catch (error) { 
            console.error('Error enviando a meta', error);
            Swal.fire('Error', 'No se pudo enviar la respuesta a Meta.', 'error');
        }
    });

    // ELIMINAR (Refactorizado con Axios)
    window.deleteComment = async function(id, isReply = false, parentId = null, event = null) {
        if(event) event.stopPropagation();
        
        if(confirm('¿Eliminar definitivamente de la red social?')) {
            if(isReply) {
                let parent = allCommentsInModal.find(c => c.id === parentId);
                if(parent) {
                    if(parent.comments) parent.comments.data = parent.comments.data.filter(r => r.id !== id);
                    if(parent.replies) parent.replies.data = parent.replies.data.filter(r => r.id !== id);
                }
            } else {
                allCommentsInModal = allCommentsInModal.filter(c => c.id !== id);
                if(replyToId === id) cancelReply();
            }
            
            renderModalComments(allCommentsInModal);
            updateBadgeCount(currentObjectId, -1);

            try {
                await axios.delete(`/administrador/marketing/comment/${id}`);
            } catch (error) {
                console.error('Error eliminando', error);
            }
        }
    }

    // TOGGLE LIKE (Nueva lógica Frontend -> Backend)
    window.toggleLikeAction = async function(commentId, currentlyLiked, event) {
        event.stopPropagation(); // Evita que se seleccione la burbuja al dar like
        
        if (currentPlatform === 'ig') {
            Swal.fire('Aviso', 'La API de Instagram no soporta dar likes a comentarios.', 'info');
            return;
        }

        // Optimistic UI: Actualizamos el array local y repintamos para que el usuario lo vea al instante
        let commentIndex = allCommentsInModal.findIndex(c => c.id === commentId);
        if (commentIndex !== -1) {
            allCommentsInModal[commentIndex].user_likes = !currentlyLiked;
            allCommentsInModal[commentIndex].like_count += currentlyLiked ? -1 : 1;
            renderModalComments(allCommentsInModal);
        }

        try {
            // NOTA: Asegúrate de crear esta ruta en web.php y apuntarla al MarketingController
            await axios.post(`/administrador/marketing/comment/${commentId}/toggle-like`, {
                is_ig: false,
                currently_liked: currentlyLiked
            });
            console.log("Toggle Like exitoso en Meta");
        } catch (error) {
            console.error('Error al reaccionar', error);
            // Si falla, revertimos visualmente
            if (commentIndex !== -1) {
                allCommentsInModal[commentIndex].user_likes = currentlyLiked;
                allCommentsInModal[commentIndex].like_count += currentlyLiked ? 1 : -1;
                renderModalComments(allCommentsInModal);
            }
            Swal.fire('Error', 'No se pudo registrar la reacción en Meta.', 'error');
        }
    }

    // Auto-Submit para Formularios de Filtro
    document.querySelectorAll('.auto-submit').forEach(input => {
        input.addEventListener('change', function() {
            this.closest('form').submit();
        });
    });
</script>
@endpush