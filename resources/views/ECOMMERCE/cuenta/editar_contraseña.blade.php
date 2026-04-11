<div class="modal fade" id="passwordModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content" style="border-radius: 16px; border: none;">
        <div class="modal-header border-0">
            <h5 class="modal-title fw-bold">
            <i class="bi bi-shield-lock text-primary me-2"></i>
            Cambiar contraseña
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <form method="POST" action="{{ route('ecommerce.cambiar_contraseña') }}" enctype="multipart/form-data" autocomplete="off" class="needs-validation" novalidate>
            <div class="modal-body">
                @csrf
                @method('PUT')
                <div class="mb-3">
                <label class="form-label">Contraseña actual</label>
                <input type="password" name="current_password" class="form-control @error('current_password') is-invalid @enderror" placeholder="Ingresa tu contraseña actual" required>
                @error('current_password')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                </div>
                <div class="mb-3">
                <label class="form-label">Nueva contraseña</label>
                <input type="password" name="new_password" class="form-control @error('new_password') is-invalid @enderror" placeholder="Mínimo 8 caracteres" required>
                @error('new_password')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="text-muted">Debe contener mayúsculas, minúsculas y números</small>
                </div>
                <div class="mb-3">
                <label class="form-label">Confirmar nueva contraseña</label>
                <input type="password" name="new_password_confirmation" class="form-control @error('new_password_confirmation') is-invalid @enderror" placeholder="Repite tu nueva contraseña" required>
                @error('new_password_confirmation')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                </div>
                <div class="alert alert-info">
                <i class="bi bi-info-circle me-2"></i>
                <small>Tu contraseña debe tener al menos 8 caracteres e incluir letras y números.</small>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary">Cambiar contraseña</button>
            </div>
        </form>
    </div>
  </div>
</div>