@extends('TEMPLATES.administrador')

@section('title', 'Marketing | Radar Meta Cisnergia')

@section('css')
    <style>
        :root { --cisnergia-dark: #1e293b; --cisnergia-sun: #f59e0b; --cisnergia-energy: #f97316; --fb-blue: #0866ff; }
        .card-solar { border: none; border-radius: 15px; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); }
        .header-solar { background: linear-gradient(135deg, var(--cisnergia-dark) 0%, #334155 100%); color: white; border-radius: 15px 15px 0 0; }
        .header-ig { background: linear-gradient(45deg, #f09433, #dc2743, #bc1888); color: white; border-radius: 15px 15px 0 0; }
        .filter-active { background-color: var(--cisnergia-energy) !important; color: white !important; border-color: var(--cisnergia-energy) !important; }
        .nav-pills .nav-link.active { background-color: var(--cisnergia-energy); color: white; }
        .nav-pills .nav-link { color: var(--cisnergia-dark); font-weight: bold; border-radius: 30px; margin: 0 5px; }
        .post-wrapper { background: white; border-radius: 15px; border-left: 5px solid var(--cisnergia-energy); margin-bottom: 2rem; overflow: hidden; transition: 0.3s; }
        .post-img-header { width: 80px; height: 80px; object-fit: cover; border-radius: 10px; border: 1px solid #eee; }
        .user-initials { width: 35px; height: 35px; border-radius: 50%; background: #e2e8f0; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 0.8rem; }
        .comment-item { border-bottom: 1px solid #f1f5f9; padding: 12px 15px; }
    </style>
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-0 text-cisnergia-dark"><i class="bi bi-radar text-primary me-2"></i> Radar Meta</h2>
            <p class="text-muted mb-0">Prospectos de Cisnergia Perú en tiempo real.</p>
        </div>
        <div class="btn-group shadow-sm bg-white p-1 rounded-pill">
            <a href="?periodo=day" class="btn btn-sm rounded-pill px-3 {{ request('periodo')=='day' ? 'filter-active' : '' }}">Hoy</a>
            <a href="?periodo=month" class="btn btn-sm rounded-pill px-3 {{ request('periodo')=='month' ? 'filter-active' : '' }}">Mes</a>
            <a href="?periodo=all" class="btn btn-sm rounded-pill px-3 {{ !request('periodo') || request('periodo')=='all' ? 'filter-active' : '' }}">Todo</a>
        </div>
    </div>

    <ul class="nav nav-pills mb-4 bg-white p-2 rounded-pill d-inline-flex shadow-sm" id="pills-tab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="fb-tab" data-bs-toggle="pill" data-bs-target="#fb-pane" type="button" role="tab"><i class="bi bi-facebook me-2"></i>Facebook</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="ig-tab" data-bs-toggle="pill" data-bs-target="#ig-pane" type="button" role="tab"><i class="bi bi-instagram me-2"></i>Instagram</button>
        </li>
    </ul>

    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="fb-pane" role="tabpanel" aria-labelledby="fb-tab">
            @include('ADMINISTRADOR.MARKETING.facebook.index')
        </div>

        <div class="tab-pane fade" id="ig-pane" role="tabpanel" aria-labelledby="ig-tab">
            @include('ADMINISTRADOR.MARKETING.instagram.index')
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    async function replyTo(commentId) {
        const { value: text } = await Swal.fire({ 
            title: 'Responder Comentario', 
            input: 'textarea', 
            inputPlaceholder: 'Escribe tu respuesta técnica...',
            showCancelButton: true,
            confirmButtonColor: '#f97316'
        });

        if (text) {
            Swal.fire({ title: 'Enviando...', allowOutsideClick: false, didOpen: () => { Swal.showLoading(); } });
            const res = await fetch('{{ route("admin.marketing.reply") }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify({ comment_id: commentId, message: text })
            });
            if(res.ok) Swal.fire('¡Éxito!', 'Tu respuesta se ha publicado.', 'success');
            else Swal.fire('Error', 'No se pudo publicar la respuesta.', 'error');
        }
    }

    async function deleteComment(id) {
        const result = await Swal.fire({
            title: '¿Eliminar comentario?',
            text: "Se borrará permanentemente de la red social.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            confirmButtonText: 'Sí, eliminar'
        });

        if(result.isConfirmed) {
            const res = await fetch(`/administrador/marketing/delete/${id}`, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
            });
            if(res.ok) {
                const el = document.getElementById(`comment-${id}`);
                if(el) el.remove();
                Swal.fire('Eliminado', 'El comentario ha sido removido.', 'success');
            }
        }
    }
</script>
@endpush