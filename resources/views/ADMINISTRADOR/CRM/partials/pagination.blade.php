{{-- Paginación estilo DataTables compacta --}}
@if($paginator->hasPages())
    <div class="d-flex justify-content-between align-items-center mt-3">
        <div class="text-muted small">
            Mostrando página {{ $paginator->currentPage() }} de {{ $paginator->lastPage() }}
        </div>
        <nav aria-label="Paginación">
            <ul class="pagination pagination-sm mb-0">
                {{-- Primero --}}
                <li class="page-item {{ $paginator->onFirstPage() ? 'disabled' : '' }}">
                    <a class="page-link" href="{{ $paginator->url(1) }}" aria-label="Primero">&laquo;</a>
                </li>
                {{-- Anterior --}}
                <li class="page-item {{ $paginator->onFirstPage() ? 'disabled' : '' }}">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}" aria-label="Anterior">&lsaquo;</a>
                </li>
                {{-- Números de página --}}
                @php
                    $start = max(1, $paginator->currentPage() - 2);
                    $end = min($paginator->lastPage(), $paginator->currentPage() + 2);
                @endphp
                @for($i = $start; $i <= $end; $i++)
                    <li class="page-item {{ $paginator->currentPage() == $i ? 'active' : '' }}">
                        <a class="page-link" href="{{ $paginator->url($i) }}">{{ $i }}</a>
                    </li>
                @endfor
                {{-- Siguiente --}}
                <li class="page-item {{ !$paginator->hasMorePages() ? 'disabled' : '' }}">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}" aria-label="Siguiente">&rsaquo;</a>
                </li>
                {{-- Último --}}
                <li class="page-item {{ !$paginator->hasMorePages() ? 'disabled' : '' }}">
                    <a class="page-link" href="{{ $paginator->url($paginator->lastPage()) }}" aria-label="Último">&raquo;</a>
                </li>
            </ul>
        </nav>
    </div>
@endif
