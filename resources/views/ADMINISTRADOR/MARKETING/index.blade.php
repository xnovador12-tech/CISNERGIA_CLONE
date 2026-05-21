@extends('TEMPLATES.administrador')

@section('title', 'Marketing | Radar Meta Cisnergia')

@section('css')
<style>
    :root {
        --cisnergia-dark: #1C3146;
        --cisnergia-light-green: #20c997;
        --cisnergia-soft: #f8fafc;
    }

    .header-radar {
        background: linear-gradient(135deg, var(--cisnergia-dark) 0%, #2a4968 100%);
        border-radius: 15px;
        color: white;
    }

    .filtros-radar {
        background: white;
        border-radius: 16px;
        border-left: 5px solid var(--cisnergia-dark);
        box-shadow: 0 4px 12px rgba(0,0,0,0.04);
    }
    .filtros-radar .form-floating > .form-control,
    .filtros-radar .form-floating > .form-select { border-radius: 12px; }
    .filtros-radar .form-floating > label { font-size: 0.85rem; color: #6c757d; }

    .chip-filtro {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: var(--cisnergia-soft);
        color: var(--cisnergia-dark);
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        padding: 5px 12px;
        font-size: 0.78rem;
        font-weight: 600;
        transition: 0.2s;
    }
    .chip-filtro:hover { border-color: var(--cisnergia-dark); }
    .chip-filtro .chip-close {
        cursor: pointer;
        color: #94a3b8;
        font-weight: bold;
        transition: 0.2s;
        line-height: 1;
    }
    .chip-filtro .chip-close:hover { color: #dc3545; transform: scale(1.2); }

    .btn-limpiar-todo {
        background: transparent;
        border: 1px dashed #cbd5e1;
        color: #64748b;
        border-radius: 20px;
        padding: 5px 14px;
        font-size: 0.78rem;
        font-weight: 600;
        transition: 0.2s;
    }
    .btn-limpiar-todo:hover { border-color: #dc3545; color: #dc3545; }

    .nav-pills .nav-link {
        color: var(--cisnergia-dark);
        font-weight: bold;
        border-radius: 30px;
        padding: 10px 25px;
        margin: 0 5px;
        transition: 0.3s;
    }
    .nav-pills .nav-link.active {
        background-color: var(--cisnergia-dark);
        color: white;
        box-shadow: 0 4px 10px rgba(28, 49, 70, 0.3);
    }

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
    .comment-bubble:hover {
        border-color: var(--cisnergia-light-green);
        box-shadow: 0 4px 10px rgba(32, 201, 151, 0.1);
    }
    .comment-bubble.selected-reply {
        border-color: var(--cisnergia-dark) !important;
        background-color: var(--cisnergia-soft);
    }

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

    .badge-likes {
        background: #eff6ff;
        color: var(--cisnergia-dark);
        border-radius: 10px;
        padding: 4px 8px;
        font-size: 0.75rem;
    }
    .user-initials {
        width: 35px; height: 35px;
        border-radius: 50%;
        background: #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 0.8rem;
        color: var(--cisnergia-dark);
    }

    .btn-like-crm {
        border: none;
        background: transparent;
        font-size: 0.85rem;
        font-weight: 600;
        transition: 0.2s;
    }
    .btn-like-crm:hover { transform: scale(1.05); }
    .like-active { color: var(--cisnergia-light-green); }
    .like-inactive { color: #64748b; }

    .loader-feed {
        position: absolute;
        inset: 0;
        background: rgba(255,255,255,0.7);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 5;
        border-radius: 12px;
    }
    .loader-feed.active { display: flex; }
    .loader-feed .spinner {
        width: 32px; height: 32px;
        border: 3px solid #e2e8f0;
        border-top-color: var(--cisnergia-light-green);
        border-radius: 50%;
        animation: spin 0.8s linear infinite;
    }
    @keyframes spin { to { transform: rotate(360deg); } }

    @media (max-width: 767px) {
        .filtros-radar .row > [class*="col-"] { margin-bottom: 8px; }
        .nav-pills .nav-link { padding: 8px 16px; font-size: 0.85rem; }
        .header-radar h2 { font-size: 1.4rem; }
    }
</style>
@endsection

@section('content')
<div id="marketingConfig"
     data-csrf="{{ csrf_token() }}"
     data-url-data="{{ route('admin.marketing.metricas.data') }}"
     data-url-publish="{{ route('admin.marketing.comment.publish') }}"
     data-fallback-img="{{ asset('img/no-image.png') }}"></div>

<div class="container-fluid py-4">

    <div class="header-radar p-4 mb-4 shadow-sm d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
        <div>
            <h2 class="fw-bold mb-1"><i class="bi bi-radar me-2" style="color: var(--cisnergia-light-green);"></i> Radar Meta: Comando Central</h2>
            <p class="mb-0 opacity-75">Gestión de interacciones Cisnergia Perú.</p>
        </div>
        <a href="{{ route('admin.marketing.metricas_globales') }}" class="btn btn-light text-dark fw-bold rounded-pill border-2 align-self-md-center" style="border-color: var(--cisnergia-light-green) !important;">
            <i class="bi bi-bar-chart-line-fill me-2" style="color: var(--cisnergia-light-green);"></i> Métricas Globales
        </a>
    </div>

    <div class="filtros-radar p-3 p-md-4 mb-3" id="barraFiltros">
        <div class="row g-2 g-md-3 align-items-end">
            <div class="col-12 col-md-3">
                <div class="form-floating">
                    <select class="form-select filtro-input" id="filtroCanal" data-filtro="canal">
                        <option value="all">Todos los canales</option>
                        <option value="fb">Solo Facebook</option>
                        <option value="ig">Solo Instagram</option>
                    </select>
                    <label for="filtroCanal"><i class="bi bi-broadcast me-1"></i> Canal</label>
                </div>
            </div>
            <div class="col-6 col-md-2">
                <div class="form-floating">
                    <input type="date" class="form-control filtro-input" id="filtroFechaInicio" data-filtro="fecha_inicio">
                    <label for="filtroFechaInicio">Desde</label>
                </div>
            </div>
            <div class="col-6 col-md-2">
                <div class="form-floating">
                    <input type="date" class="form-control filtro-input" id="filtroFechaFin" data-filtro="fecha_fin">
                    <label for="filtroFechaFin">Hasta</label>
                </div>
            </div>
            <div class="col-12 col-md-5">
                <div class="form-floating">
                    <input type="text" class="form-control filtro-input" id="filtroSearch" data-filtro="search" placeholder="Buscar...">
                    <label for="filtroSearch"><i class="bi bi-search me-1"></i> Buscar palabra en publicaciones</label>
                </div>
            </div>
        </div>

        <div class="d-flex flex-wrap gap-2 mt-3 align-items-center" id="chipsContainer">
            <span class="small fw-bold me-2" style="color: #6c757d;">
                <i class="bi bi-funnel-fill me-1" style="color: var(--cisnergia-dark);"></i>
                Filtros activos:
            </span>
            <span class="text-muted small" id="chipsVacios">ninguno</span>
        </div>
    </div>

    <ul class="nav nav-pills mb-4" id="radarTabs" role="tablist">
        <li class="nav-item">
            <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#fb-content" data-canal="fb">
                <i class="bi bi-facebook me-2"></i> Facebook
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link" data-bs-toggle="pill" data-bs-target="#ig-content" data-canal="ig">
                <i class="bi bi-instagram me-2"></i> Instagram
            </button>
        </li>
    </ul>

    <div class="tab-content bg-white p-3 p-md-4 rounded-4 shadow-sm position-relative">
        <div class="loader-feed" id="loaderFeed"><div class="spinner"></div></div>

        <div class="tab-pane fade show active" id="fb-content">
            @include('ADMINISTRADOR.MARKETING.facebook.index', ['fbData' => $fbData ?? ['top_leads' => [], 'recent_posts' => []]])
        </div>
        <div class="tab-pane fade" id="ig-content">
            @include('ADMINISTRADOR.MARKETING.instagram.index', ['igData' => $igData ?? ['top_leads' => [], 'recent_posts' => []]])
        </div>
    </div>
</div>

<div class="modal fade" id="modalComentarios" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content border-0 rounded-4 shadow-lg">
            <div class="modal-header text-white py-3" style="background-color: var(--cisnergia-dark);">
                <h5 class="modal-title fw-bold"><i class="bi bi-chat-dots-fill me-2" style="color: var(--cisnergia-light-green);"></i> Gestión de Comentarios</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-0" style="background: var(--cisnergia-soft);">
                <div class="row g-0">
                    <div class="col-lg-5 bg-white p-4 border-end">
                        <div id="postPreviewContainer" style="position: sticky; top: 0;"></div>
                    </div>
                    <div class="col-lg-7 d-flex flex-column" style="height: 75vh;">
                        <div class="p-3 bg-light border-bottom text-center">
                            <span class="small fw-bold" style="color: #6c757d;"><i class="bi bi-info-circle me-1"></i> Haz clic en cualquier comentario para responder.</span>
                        </div>
                        <div class="flex-grow-1 overflow-auto p-4" id="commentsListContainer"></div>
                        <div class="p-3 bg-white border-top shadow-lg">
                            <div id="replyIndicator" class="mb-2 d-none">
                                <span class="badge rounded-pill px-3 py-2 fw-bold shadow-sm" style="background-color: var(--cisnergia-light-green); color: var(--cisnergia-dark);">
                                    Respondiendo a: <span id="replyToName"></span>
                                    <i class="bi bi-x-circle-fill ms-2 text-danger" style="cursor:pointer;" onclick="cancelReply(event)"></i>
                                </span>
                            </div>
                            <div class="input-group">
                                <textarea id="textNewComment" class="form-control rounded-4 bg-light border-0" rows="2" placeholder="Escribe tu comentario o respuesta..."></textarea>
                                <button class="btn fw-bold px-4 rounded-4 ms-2 text-white" style="background-color: var(--cisnergia-dark);" id="btnSendAction"><i class="bi bi-send-fill"></i></button>
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
    const CFG = document.getElementById('marketingConfig').dataset;

    axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
    axios.defaults.headers.common['X-CSRF-TOKEN'] = CFG.csrf;

    let currentObjectId = null;
    let replyToId = null;
    let allCommentsInModal = [];
    let currentPlatform = 'fb';

    const STORAGE_KEY = 'cisnergia_marketing_filtros';
    const URL_DATA = CFG.urlData;
    const URL_PUBLISH = CFG.urlPublish;
    const FALLBACK_IMG = CFG.fallbackImg;

    const CANAL_LABEL = { all: 'Todos', fb: 'Facebook', ig: 'Instagram' };

    const filtros = {
        canal: 'all',
        fecha_inicio: '',
        fecha_fin: '',
        search: '',
    };

    function debounce(fn, ms) {
        let t;
        return (...args) => { clearTimeout(t); t = setTimeout(() => fn(...args), ms); };
    }

    function guardarFiltrosLocal() {
        localStorage.setItem(STORAGE_KEY, JSON.stringify(filtros));
    }

    function cargarFiltrosLocal() {
        try {
            const data = JSON.parse(localStorage.getItem(STORAGE_KEY) || '{}');
            Object.keys(filtros).forEach(k => {
                if (data[k] !== undefined) filtros[k] = data[k];
            });
        } catch (e) { /* ignorar */ }

        document.getElementById('filtroCanal').value = filtros.canal;
        document.getElementById('filtroFechaInicio').value = filtros.fecha_inicio;
        document.getElementById('filtroFechaFin').value = filtros.fecha_fin;
        document.getElementById('filtroSearch').value = filtros.search;
    }

    function renderChips() {
        const cont = document.getElementById('chipsContainer');
        cont.querySelectorAll('.chip-filtro, #btnLimpiarTodo').forEach(el => el.remove());
        const vacio = document.getElementById('chipsVacios');

        const activos = [];
        if (filtros.canal !== 'all') activos.push({ k: 'canal', label: 'Canal: ' + CANAL_LABEL[filtros.canal], reset: 'all' });
        if (filtros.fecha_inicio) activos.push({ k: 'fecha_inicio', label: 'Desde: ' + filtros.fecha_inicio, reset: '' });
        if (filtros.fecha_fin) activos.push({ k: 'fecha_fin', label: 'Hasta: ' + filtros.fecha_fin, reset: '' });
        if (filtros.search) activos.push({ k: 'search', label: 'Buscar: "' + filtros.search + '"', reset: '' });

        if (activos.length === 0) {
            vacio.style.display = 'inline';
            return;
        }
        vacio.style.display = 'none';

        activos.forEach(f => {
            const chip = document.createElement('span');
            chip.className = 'chip-filtro';
            chip.innerHTML = `${f.label} <span class="chip-close" data-key="${f.k}" data-reset="${f.reset}">&times;</span>`;
            cont.appendChild(chip);
        });

        const btn = document.createElement('button');
        btn.id = 'btnLimpiarTodo';
        btn.className = 'btn-limpiar-todo';
        btn.innerHTML = '<i class="bi bi-x-lg me-1"></i> Limpiar todo';
        cont.appendChild(btn);
    }

    async function aplicarFiltros() {
        document.getElementById('loaderFeed').classList.add('active');
        try {
            const { data } = await axios.get(URL_DATA, { params: filtros });
            if (data.success) {
                renderFeedFacebook(data.fb.posts);
                renderFeedInstagram(data.ig.posts);
                actualizarContadores(data.fb.total, data.ig.total);
            }
        } catch (e) {
            console.error('Error al filtrar:', e);
        } finally {
            document.getElementById('loaderFeed').classList.remove('active');
        }
    }

    function actualizarContadores(totalFb, totalIg) {
        const fbCount = document.getElementById('fb-count');
        const igCount = document.getElementById('ig-count');
        if (fbCount) fbCount.textContent = 'Mostrando ' + totalFb + ' posts';
        if (igCount) igCount.textContent = 'Mostrando ' + totalIg + ' posts';
    }

    function renderFeedFacebook(posts) {
        renderFeedGenerico(posts, 'fbFeedBody', 'fb', 'comments');
    }
    function renderFeedInstagram(posts) {
        renderFeedGenerico(posts, 'igFeedBody', 'ig', 'replies');
    }

    function escapeAttr(s) {
        return String(s)
            .replace(/&/g, '&amp;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;');
    }

    function renderFeedGenerico(posts, tbodyId, plataforma, replyKey) {
        const tbody = document.getElementById(tbodyId);
        if (!tbody) return;
        if (!posts.length) {
            tbody.innerHTML = `
                <tr><td colspan="4" class="text-center py-5" style="color: #6c757d;">
                    <i class="bi bi-search fs-2 d-block mb-2 opacity-25"></i>
                    <p class="mb-0 fw-bold small">No se encontraron publicaciones con esos filtros</p>
                </td></tr>`;
            return;
        }
        tbody.innerHTML = posts.map(p => {
            const cCount = (p.comments?.data || []).reduce((acc, c) => acc + 1 + ((c[replyKey]?.data || []).length), 0);
            const hasReplies = (p.comments?.data || []).some(c => (c[replyKey]?.data || []).length > 0);
            const fecha = new Date(p.created_time).toLocaleDateString('es-PE', { day: '2-digit', month: 'short', hour: '2-digit', minute: '2-digit' });
            const iconChat = plataforma === 'ig' ? 'bi-chat-heart-fill' : 'bi-chat-text-fill';
            const btnClass = cCount > 0 ? 'text-white' : 'btn-light border';
            const btnStyle = cCount > 0
                ? (hasReplies ? 'background-color: #20c997; border:none;' : 'background-color: #1C3146; border:none;')
                : 'color: #6c757d;';
            const img = p.full_picture || FALLBACK_IMG;
            const postAttr = escapeAttr(JSON.stringify(p));
            return `
                <tr>
                    <td class="ps-4 py-3"><img src="${img}" class="rounded-3 shadow-sm border" style="width: 60px; height: 60px; object-fit: cover;"></td>
                    <td>
                        <p class="mb-1 fw-bold text-dark small" style="line-height: 1.4;">${(p.message || 'Post sin texto').substring(0, 100)}</p>
                        <small style="color: #6c757d;"><i class="bi bi-calendar-check me-1"></i>${fecha}</small>
                    </td>
                    <td class="text-center d-none d-md-table-cell">
                        <span class="badge rounded-pill px-2 py-1" style="background-color: rgba(32,201,151,0.1); color: #20c997; border:1px solid #20c997;">
                            <i class="bi bi-eye-fill"></i> ${p.alcance ?? 'N/D'}
                        </span>
                    </td>
                    <td class="text-center pe-4">
                        <button class="btn btn-sm rounded-pill fw-bold shadow-sm px-3 py-1 ${btnClass}" style="${btnStyle}" data-post="${postAttr}" data-plataforma="${plataforma}">
                            <i class="bi ${iconChat}"></i> <span>${cCount}</span>
                        </button>
                        <a href="${p.permalink || p.permalink_url || '#'}" target="_blank" class="btn btn-sm btn-light border rounded-circle ms-1" style="color: #6c757d;">
                            <i class="bi bi-box-arrow-up-right"></i>
                        </a>
                    </td>
                </tr>`;
        }).join('');

    }

    document.querySelector('.tab-content').addEventListener('click', (e) => {
        const btn = e.target.closest('button[data-post]');
        if (!btn) return;
        try {
            const post = JSON.parse(btn.dataset.post);
            openCommentModal(post, btn.dataset.plataforma);
        } catch (err) {
            console.error('Error al parsear post:', err);
        }
    });

    const aplicarFiltrosDebounced = debounce(aplicarFiltros, 350);

    document.querySelectorAll('.filtro-input').forEach(el => {
        const key = el.dataset.filtro;
        el.addEventListener('input', () => {
            filtros[key] = el.value;
            renderChips();
            guardarFiltrosLocal();
            if (el.type === 'text') aplicarFiltrosDebounced();
            else aplicarFiltros();
        });
        el.addEventListener('change', () => {
            filtros[key] = el.value;
            renderChips();
            guardarFiltrosLocal();
            aplicarFiltros();
        });
    });

    document.getElementById('chipsContainer').addEventListener('click', (e) => {
        const close = e.target.closest('.chip-close');
        const limpiar = e.target.closest('#btnLimpiarTodo');
        if (close) {
            const k = close.dataset.key;
            filtros[k] = close.dataset.reset;
            document.querySelector(`[data-filtro="${k}"]`).value = filtros[k];
            renderChips();
            guardarFiltrosLocal();
            aplicarFiltros();
        } else if (limpiar) {
            filtros.canal = 'all';
            filtros.fecha_inicio = '';
            filtros.fecha_fin = '';
            filtros.search = '';
            document.getElementById('filtroCanal').value = 'all';
            document.getElementById('filtroFechaInicio').value = '';
            document.getElementById('filtroFechaFin').value = '';
            document.getElementById('filtroSearch').value = '';
            renderChips();
            guardarFiltrosLocal();
            aplicarFiltros();
        }
    });

    document.addEventListener('DOMContentLoaded', () => {
        cargarFiltrosLocal();
        renderChips();
        const hayFiltros = Object.values(filtros).some(v => v && v !== 'all');
        if (hayFiltros) aplicarFiltros();
    });

    function updateBadgeCount(postId, change) {
        const badgeSpan = document.querySelector(`button[data-post*='"id":"${postId}"'] span`);
        if (badgeSpan) {
            let n = parseInt(badgeSpan.innerText) || 0;
            badgeSpan.innerText = Math.max(0, n + change);
        }
    }

    window.openCommentModal = function(post, platform) {
        currentObjectId = post.id;
        currentPlatform = platform;
        cancelReply();

        document.getElementById('postPreviewContainer').innerHTML = `
            <img src="${post.full_picture || FALLBACK_IMG}" class="img-fluid rounded-4 shadow-sm mb-3 border border-secondary border-opacity-25">
            <h6 class="fw-bold" style="color: #1C3146;">Descripción:</h6>
            <p class="text-secondary small mb-3">${post.message || post.caption || 'Sin texto'}</p>
            <a href="${post.permalink_url || post.permalink || '#'}" target="_blank" class="btn btn-sm rounded-pill w-100 fw-bold text-white" style="background-color: #1C3146;">Ver en Red Social <i class="bi bi-box-arrow-up-right"></i></a>
        `;

        allCommentsInModal = post.comments ? (post.comments.data || []) : [];
        renderModalComments(allCommentsInModal);
        new bootstrap.Modal(document.getElementById('modalComentarios')).show();
    }

    function renderModalComments(comments) {
        const container = document.getElementById('commentsListContainer');
        if (!comments.length) {
            container.innerHTML = `<div class="text-center py-5" style="color: #6c757d;"><i class="bi bi-chat-square-dots fs-1 opacity-25"></i><p class="mt-2">No hay comentarios aún.</p></div>`;
            return;
        }

        let html = '';
        comments.forEach(c => {
            const replies = c.comments ? c.comments.data : (c.replies ? c.replies.data : []);
            const hasReplies = replies.length > 0;
            const borderStyle = hasReplies ? 'border-left: 4px solid #20c997;' : '';
            const userLikes = c.user_likes === true;
            const btnLikeClass = userLikes ? 'like-active' : 'like-inactive';
            const btnLikeText = userLikes ? 'Te gusta' : 'Me gusta';
            const iconLikeClass = userLikes ? 'bi-hand-thumbs-up-fill' : 'bi-hand-thumbs-up';

            const likeActionHtml = currentPlatform === 'fb'
                ? `<button class="btn-like-crm ${btnLikeClass}" onclick="toggleLikeAction('${c.id}', ${userLikes}, event)">
                     <i class="bi ${iconLikeClass}"></i> ${btnLikeText}
                   </button>`
                : `<span class="badge bg-light" style="color: #6c757d;"><i class="bi bi-info-circle"></i> IG: Solo respuestas</span>`;

            const isSelected = (replyToId === c.id) ? 'selected-reply' : '';

            html += `
            <div class="comment-bubble mb-3 ${isSelected}" id="modal-c-${c.id}" style="${borderStyle}" onclick="prepareReply('${c.id}', '${(c.from?.name || 'Usuario').replace(/'/g, "\\'")}')">
                <div class="comment-actions">
                    ${likeActionHtml}
                    <div class="vr mx-1"></div>
                    <button class="btn btn-sm text-danger p-0 px-1" onclick="deleteComment('${c.id}', false, null, event)" title="Eliminar"><i class="bi bi-trash fs-6"></i></button>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <div class="d-flex gap-2 align-items-center">
                        <div class="user-initials text-white" style="background-color: #1C3146;">${(c.from?.name || 'U').substring(0,1)}</div>
                        <h6 class="mb-0 fw-bold small text-dark">${c.from?.name || 'Usuario'}</h6>
                    </div>
                </div>
                <p class="mb-2 text-dark small pe-5">"${c.message}"</p>
                <div class="d-flex align-items-center gap-2">
                    <span class="badge-likes"><i class="bi ${currentPlatform === 'fb' ? 'bi-hand-thumbs-up-fill' : 'bi-heart-fill'}"></i> ${c.like_count || 0}</span>
                </div>
                <div class="ps-4 ms-2 mt-2 border-start">
                    ${replies.map(r => `
                        <div class="bg-light p-2 rounded mb-2 position-relative" id="modal-c-${r.id}" onclick="event.stopPropagation()">
                            <div class="d-flex justify-content-between">
                                <strong class="small" style="color: #1C3146;">${r.from?.name || 'Cisnergia'}</strong>
                                <button class="btn btn-sm text-danger p-0" onclick="deleteComment('${r.id}', true, '${c.id}', event)"><i class="bi bi-x-circle-fill"></i></button>
                            </div>
                            <p class="mb-0 small" style="color: #6c757d;">${r.message}</p>
                        </div>
                    `).join('')}
                </div>
            </div>`;
        });
        container.innerHTML = html;
    }

    window.prepareReply = function(id, name) {
        replyToId = id;
        document.querySelectorAll('.comment-bubble').forEach(el => el.classList.remove('selected-reply'));
        document.getElementById(`modal-c-${id}`)?.classList.add('selected-reply');
        document.getElementById('replyIndicator').classList.remove('d-none');
        document.getElementById('replyToName').innerText = name;
        document.getElementById('textNewComment').focus();
    }

    window.cancelReply = function(event = null) {
        if (event) event.stopPropagation();
        replyToId = null;
        document.querySelectorAll('.comment-bubble').forEach(el => el.classList.remove('selected-reply'));
        document.getElementById('replyIndicator').classList.add('d-none');
        document.getElementById('textNewComment').value = '';
    }

    document.getElementById('btnSendAction').addEventListener('click', async function() {
        const message = document.getElementById('textNewComment').value;
        if (!message) return;

        const fakeId = 'temp-' + Date.now();
        const newObj = { id: fakeId, message: message, from: { name: 'Cisnergia (Tú)' } };

        if (replyToId) {
            const parent = allCommentsInModal.find(c => c.id === replyToId);
            if (parent) {
                if (currentPlatform === 'ig') {
                    parent.replies ||= { data: [] };
                    parent.replies.data.push(newObj);
                } else {
                    parent.comments ||= { data: [] };
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

        try {
            await axios.post(URL_PUBLISH, {
                object_id: currentReplyId || currentObjectId,
                message: message,
                is_ig: currentPlatform === 'ig'
            });
        } catch (error) {
            console.error('Error enviando a meta', error);
            Swal.fire('Error', 'No se pudo enviar la respuesta a Meta.', 'error');
        }
    });

    window.deleteComment = async function(id, isReply = false, parentId = null, event = null) {
        if (event) event.stopPropagation();
        if (!confirm('¿Eliminar definitivamente de la red social?')) return;

        if (isReply) {
            const parent = allCommentsInModal.find(c => c.id === parentId);
            if (parent) {
                if (parent.comments) parent.comments.data = parent.comments.data.filter(r => r.id !== id);
                if (parent.replies) parent.replies.data = parent.replies.data.filter(r => r.id !== id);
            }
        } else {
            allCommentsInModal = allCommentsInModal.filter(c => c.id !== id);
            if (replyToId === id) cancelReply();
        }

        renderModalComments(allCommentsInModal);
        updateBadgeCount(currentObjectId, -1);

        try {
            await axios.delete(`/administrador/marketing/comment/${id}`);
        } catch (error) {
            console.error('Error eliminando', error);
        }
    }

    window.toggleLikeAction = async function(commentId, currentlyLiked, event) {
        event.stopPropagation();
        if (currentPlatform === 'ig') {
            Swal.fire('Aviso', 'La API de Instagram no soporta dar likes a comentarios.', 'info');
            return;
        }

        const idx = allCommentsInModal.findIndex(c => c.id === commentId);
        if (idx !== -1) {
            allCommentsInModal[idx].user_likes = !currentlyLiked;
            allCommentsInModal[idx].like_count += currentlyLiked ? -1 : 1;
            renderModalComments(allCommentsInModal);
        }

        try {
            await axios.post(`/administrador/marketing/comment/${commentId}/toggle-like`, {
                is_ig: false,
                currently_liked: currentlyLiked
            });
        } catch (error) {
            if (idx !== -1) {
                allCommentsInModal[idx].user_likes = currentlyLiked;
                allCommentsInModal[idx].like_count += currentlyLiked ? 1 : -1;
                renderModalComments(allCommentsInModal);
            }
            Swal.fire('Error', 'No se pudo registrar la reacción en Meta.', 'error');
        }
    }
</script>
@endpush
