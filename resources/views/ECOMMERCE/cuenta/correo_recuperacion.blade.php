<!-- Forgot Password Modal (OTP Flow) -->
    <div class="modal fade" id="forgotPasswordModal" tabindex="-1" aria-labelledby="forgotPasswordLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header border-bottom-0 pb-0">
                    <div>
                        <h5 class="modal-title fw-bold text-secondary" id="forgotPasswordLabel">
                            <i class="bi bi-key me-2"></i><span id="modalTitle">Recuperar Contraseña</span>
                        </h5>
                        <p class="text-muted small mb-0" id="modalSubtitle">Ingresa tu correo para recibir un código de 6 dígitos</p>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <!-- Alert -->
                    <div class="alert d-none align-items-center mb-3" id="otpAlert" role="alert">
                        <i class="bi me-2" id="otpAlertIcon"></i>
                        <span id="otpAlertText"></span>
                    </div>

                    <!-- STEP 1: Email -->
                    <div id="otpStep1">
                        <div class="mb-4">
                            <label for="otpEmail" class="form-label fw-semibold text-secondary">
                                <i class="bi bi-envelope-fill text-primary me-2"></i>Correo Electrónico
                            </label>
                            <input type="email" class="form-control form-control-lg" id="otpEmail"
                                   placeholder="tu@email.com" autocomplete="email">
                        </div>
                    </div>

                    <!-- STEP 2: OTP + Nueva contraseña -->
                    <div id="otpStep2" class="d-none">
                        <p class="text-muted small mb-3">
                            <i class="bi bi-envelope-check text-success me-1"></i>
                            Código enviado a <strong id="otpEmailDisplay"></strong>
                            <a href="#" class="text-primary ms-2 small" id="btnChangeEmail">Cambiar</a>
                        </p>

                        <!-- 6-digit OTP inputs -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-secondary">
                                <i class="bi bi-shield-lock-fill text-primary me-2"></i>Código de 6 dígitos
                            </label>
                            <div class="d-flex gap-2 justify-content-between" id="otpInputsContainer">
                                @for($i = 0; $i < 6; $i++)
                                <input type="text" inputmode="numeric" maxlength="1"
                                       class="form-control text-center fw-bold otp-digit"
                                       style="width:48px; height:52px; font-size:1.4rem;"
                                       autocomplete="one-time-code">
                                @endfor
                            </div>
                            <input type="hidden" id="otpCode">
                        </div>

                        <!-- Nueva contraseña -->
                        <div class="mb-3">
                            <label for="otpNewPassword" class="form-label fw-semibold text-secondary">
                                <i class="bi bi-lock-fill text-primary me-2"></i>Nueva Contraseña
                            </label>
                            <div class="position-relative">
                                <input type="password" class="form-control form-control-lg pe-5"
                                       id="otpNewPassword" placeholder="Mínimo 8 caracteres">
                                <button type="button" class="btn btn-link position-absolute end-0 top-50 translate-middle-y text-muted"
                                        onclick="toggleOtpPass('otpNewPassword', 'iconNewPass')" style="z-index:10;">
                                    <i class="bi bi-eye" id="iconNewPass"></i>
                                </button>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="otpConfirmPassword" class="form-label fw-semibold text-secondary">
                                <i class="bi bi-lock-fill text-primary me-2"></i>Confirmar Contraseña
                            </label>
                            <div class="position-relative">
                                <input type="password" class="form-control form-control-lg pe-5"
                                       id="otpConfirmPassword" placeholder="Repite la contraseña">
                                <button type="button" class="btn btn-link position-absolute end-0 top-50 translate-middle-y text-muted"
                                        onclick="toggleOtpPass('otpConfirmPassword', 'iconConfirmPass')" style="z-index:10;">
                                    <i class="bi bi-eye" id="iconConfirmPass"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer border-top-0">
                    <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">
                        <i class="bi bi-x me-2"></i>Cancelar
                    </button>
                    <!-- Step 1 button -->
                    <button type="button" class="btn btn-primary rounded-pill" id="btnSendOtp">
                        <i class="bi bi-send me-2"></i>Enviar Código
                    </button>
                    <!-- Step 2 button -->
                    <button type="button" class="btn btn-success rounded-pill d-none" id="btnResetPassword">
                        <i class="bi bi-check-circle me-2"></i>Cambiar Contraseña
                    </button>
                </div>
            </div>
        </div>
    </div>

<script>
    (function () {
        const modal = document.getElementById('forgotPasswordModal');
        if (!modal) return;

        const step1 = document.getElementById('otpStep1');
        const step2 = document.getElementById('otpStep2');
        const sendBtn = document.getElementById('btnSendOtp');
        const resetBtn = document.getElementById('btnResetPassword');
        const emailInput = document.getElementById('otpEmail');
        const emailDisplay = document.getElementById('otpEmailDisplay');
        const newPasswordInput = document.getElementById('otpNewPassword');
        const confirmPasswordInput = document.getElementById('otpConfirmPassword');
        const otpInputs = Array.from(document.querySelectorAll('.otp-digit'));
        const changeEmailBtn = document.getElementById('btnChangeEmail');
        const alertBox = document.getElementById('otpAlert');
        const alertIcon = document.getElementById('otpAlertIcon');
        const alertText = document.getElementById('otpAlertText');
        const csrfToken = '{{ csrf_token() }}';

        const routeSend = '{{ route('ecommerce.otp.enviar') }}';
        const routeReset = '{{ route('ecommerce.otp.cambiar_password') }}';
        const currentEmail = '{{ Auth::user()->email }}';

        function showAlert(type, message) {
            const config = {
                success: { className: 'alert-success', icon: 'bi-check-circle-fill' },
                error: { className: 'alert-danger', icon: 'bi-exclamation-triangle-fill' },
                info: { className: 'alert-info', icon: 'bi-info-circle-fill' }
            };

            alertBox.className = 'alert align-items-center mb-3 ' + config[type].className;
            alertBox.classList.remove('d-none');
            alertIcon.className = 'bi me-2 ' + config[type].icon;
            alertText.textContent = message;
        }

        function hideAlert() {
            alertBox.classList.add('d-none');
        }

        function getOtpValue() {
            return otpInputs.map(input => input.value.trim()).join('');
        }

        function clearOtpInputs() {
            otpInputs.forEach(input => {
                input.value = '';
            });
            if (otpInputs[0]) otpInputs[0].focus();
        }

        function resetModalState() {
            hideAlert();
            step1.classList.remove('d-none');
            step2.classList.add('d-none');
            sendBtn.classList.remove('d-none');
            resetBtn.classList.add('d-none');
            emailInput.value = currentEmail;
            newPasswordInput.value = '';
            confirmPasswordInput.value = '';
            clearOtpInputs();
        }

        otpInputs.forEach((input, index) => {
            input.addEventListener('input', function () {
                this.value = this.value.replace(/\D/g, '').slice(0, 1);
                if (this.value && index < otpInputs.length - 1) {
                    otpInputs[index + 1].focus();
                }
            });

            input.addEventListener('keydown', function (event) {
                if (event.key === 'Backspace' && !this.value && index > 0) {
                    otpInputs[index - 1].focus();
                }
            });
        });

        sendBtn.addEventListener('click', async function () {
            hideAlert();
            const email = emailInput.value.trim().toLowerCase();

            if (!email) {
                showAlert('error', 'Ingresa un correo para continuar.');
                return;
            }

            sendBtn.disabled = true;
            sendBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Enviando...';

            try {
                const response = await fetch(routeSend, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ email })
                });

                const data = await response.json();
                if (!response.ok) {
                    showAlert('error', data.message || 'No se pudo enviar el código.');
                    return;
                }

                emailDisplay.textContent = email;
                step1.classList.add('d-none');
                step2.classList.remove('d-none');
                sendBtn.classList.add('d-none');
                resetBtn.classList.remove('d-none');
                showAlert('success', data.message || 'Código enviado correctamente.');
                clearOtpInputs();
            } catch (error) {
                showAlert('error', 'Ocurrió un error al enviar el código. Intenta nuevamente.');
            } finally {
                sendBtn.disabled = false;
                sendBtn.innerHTML = '<i class="bi bi-send me-2"></i>Enviar Código';
            }
        });

        resetBtn.addEventListener('click', async function () {
            hideAlert();

            const email = emailInput.value.trim().toLowerCase();
            const otp = getOtpValue();
            const new_password = newPasswordInput.value;
            const new_password_confirmation = confirmPasswordInput.value;

            if (otp.length !== 6) {
                showAlert('error', 'Ingresa el código completo de 6 dígitos.');
                return;
            }

            if (new_password.length < 8) {
                showAlert('error', 'La nueva contraseña debe tener al menos 8 caracteres.');
                return;
            }

            if (new_password !== new_password_confirmation) {
                showAlert('error', 'La confirmación de contraseña no coincide.');
                return;
            }

            resetBtn.disabled = true;
            resetBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Actualizando...';

            try {
                const response = await fetch(routeReset, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        email,
                        otp,
                        new_password,
                        new_password_confirmation
                    })
                });

                const data = await response.json();
                if (!response.ok) {
                    showAlert('error', data.message || 'No se pudo actualizar la contraseña.');
                    return;
                }

                showAlert('success', data.message || 'Contraseña actualizada correctamente.');

                setTimeout(function () {
                    const modalInstance = bootstrap.Modal.getOrCreateInstance(modal);
                    modalInstance.hide();
                    Swal.fire({
                        icon: 'success',
                        confirmButtonColor: '#1C3146',
                        title: '¡Éxito!',
                        text: 'Tu contraseña fue actualizada con código de verificación.'
                    });
                }, 700);
            } catch (error) {
                showAlert('error', 'Ocurrió un error al actualizar la contraseña.');
            } finally {
                resetBtn.disabled = false;
                resetBtn.innerHTML = '<i class="bi bi-check-circle me-2"></i>Cambiar Contraseña';
            }
        });

        changeEmailBtn.addEventListener('click', function (event) {
            event.preventDefault();
            step2.classList.add('d-none');
            step1.classList.remove('d-none');
            sendBtn.classList.remove('d-none');
            resetBtn.classList.add('d-none');
            clearOtpInputs();
            hideAlert();
            emailInput.focus();
        });

        modal.addEventListener('shown.bs.modal', function () {
            resetModalState();
            emailInput.focus();
        });

        modal.addEventListener('hidden.bs.modal', function () {
            resetModalState();
        });
    })();

    function toggleOtpPass(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);
        const isPassword = input.type === 'password';

        input.type = isPassword ? 'text' : 'password';
        icon.classList.toggle('bi-eye');
        icon.classList.toggle('bi-eye-slash');
    }
</script>