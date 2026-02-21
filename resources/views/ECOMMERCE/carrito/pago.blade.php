@extends('TEMPLATES.ecommerce')

@section('title', 'PAGO')

@section('css')
  <style>
    .step-indicator {
      position: relative;
      display: flex;
      justify-content: space-between;
      margin-bottom: 3rem;
    }
    
    .step-indicator::before {
      content: '';
      position: absolute;
      top: 20px;
      left: 0;
      right: 0;
      height: 2px;
      background: #e9ecef;
      z-index: 0;
    }
    
    .step {
      position: relative;
      z-index: 1;
      text-align: center;
      flex: 1;
    }
    
    .step-circle {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      background: #e9ecef;
      color: #6c757d;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 8px;
      font-weight: bold;
      transition: all 0.3s;
    }
    
    .step.active .step-circle {
      background: #0066cc;
      color: white;
      box-shadow: 0 0 0 4px rgba(0, 102, 204, 0.2);
    }
    
    .step.completed .step-circle {
      background: #28a745;
      color: white;
    }
    
    .payment-method {
      transition: all 0.3s;
      cursor: pointer;
      position: relative;
    }
    
    .payment-method:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 30px rgba(0,0,0,0.1) !important;
    }
    
    .payment-method input[type="radio"] {
      position: absolute;
      opacity: 0;
    }
    
    .payment-method input[type="radio"]:checked + .card {
      border: 2px solid #0066cc !important;
      background: #f0f7ff;
    }
    
    .payment-method input[type="radio"]:checked + .card::after {
      content: '\f26b';
      font-family: 'bootstrap-icons';
      position: absolute;
      top: 10px;
      right: 10px;
      color: #0066cc;
      font-size: 1.5rem;
    }
    
    .secure-badge {
      animation: pulse 2s infinite;
    }
    
    @keyframes pulse {
      0%, 100% { opacity: 1; }
      50% { opacity: 0.7; }
    }
    
    .card-logos img {
      height: 30px;
      margin: 0 5px;
      opacity: 0.7;
      transition: opacity 0.3s;
    }
    
    .card-logos img:hover {
      opacity: 1;
    }
  </style>
@endsection

@section('content')
<!-- INDICADOR DE PASOS -->
<section class="py-4 bg-light">
  <div class="container">
    <div class="step-indicator">
      <div class="step completed">
        <div class="step-circle">
          <i class="bi bi-check-lg"></i>
        </div>
        <small class="text-muted">Carrito</small>
      </div>
      <div class="step active">
        <div class="step-circle">2</div>
        <small class="fw-bold text-primary">Pago</small>
      </div>
      <div class="step">
        <div class="step-circle">3</div>
        <small class="text-muted">Confirmación</small>
      </div>
    </div>
  </div>
</section>

<!-- FORMULARIO DE PAGO -->
<section class="py-5">
  <div class="container">
    <div class="row g-4">
      <!-- COLUMNA IZQUIERDA: FORMULARIO -->
      <div class="col-lg-8">
        
        <!-- DATOS DE CONTACTO -->
        <div class="card border-0 shadow-sm rounded-4 mb-4">
          <div class="card-body p-4">
            <div class="d-flex align-items-center mb-4">
              <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-3">
                <i class="bi bi-person-fill text-primary fs-4"></i>
              </div>
              <h4 class="fw-bold mb-0">Datos de Contacto</h4>
            </div>

            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label">Nombre <span class="text-danger">*</span></label>
                <input type="text" class="form-control" placeholder="Juan" required>
              </div>
              <div class="col-md-6">
                <label class="form-label">Apellido <span class="text-danger">*</span></label>
                <input type="text" class="form-control" placeholder="Pérez" required>
              </div>
              <div class="col-md-6">
                <label class="form-label">Email <span class="text-danger">*</span></label>
                <input type="email" class="form-control" placeholder="tu@email.com" required>
              </div>
              <div class="col-md-6">
                <label class="form-label">Teléfono <span class="text-danger">*</span></label>
                <input type="tel" class="form-control" placeholder="+51 999 999 999" required>
              </div>
              <div class="col-md-6">
                <label class="form-label">DNI/RUC <span class="text-danger">*</span></label>
                <input type="text" class="form-control" placeholder="12345678" required>
              </div>
              <div class="col-md-6">
                <label class="form-label">Tipo de comprobante</label>
                <select class="form-select">
                  <option>Boleta</option>
                  <option>Factura</option>
                </select>
              </div>
            </div>
          </div>
        </div>

        <!-- DIRECCIÓN DE ENVÍO -->
        <div class="card border-0 shadow-sm rounded-4 mb-4">
          <div class="card-body p-4">
            <div class="d-flex align-items-center mb-4">
              <div class="bg-success bg-opacity-10 rounded-circle p-2 me-3">
                <i class="bi bi-geo-alt-fill text-success fs-4"></i>
              </div>
              <h4 class="fw-bold mb-0">Dirección de Envío</h4>
            </div>

            <div class="row g-3">
              <div class="col-md-8">
                <label class="form-label">Dirección <span class="text-danger">*</span></label>
                <input type="text" class="form-control" placeholder="Av. Principal 123, Piso 4" required>
              </div>
              <div class="col-md-4">
                <label class="form-label">Número/Dpto</label>
                <input type="text" class="form-control" placeholder="401">
              </div>
              <div class="col-md-6">
                <label class="form-label">Departamento <span class="text-danger">*</span></label>
                <select class="form-select" required>
                  <option selected disabled>Seleccionar...</option>
                  <option>Lima</option>
                  <option>Arequipa</option>
                  <option>Cusco</option>
                  <option>Trujillo</option>
                  <option>Piura</option>
                  <option>Chiclayo</option>
                </select>
              </div>
              <div class="col-md-6">
                <label class="form-label">Distrito <span class="text-danger">*</span></label>
                <input type="text" class="form-control" placeholder="San Isidro" required>
              </div>
              <div class="col-12">
                <label class="form-label">Referencia (opcional)</label>
                <input type="text" class="form-control" placeholder="Frente al parque Kennedy">
              </div>
            </div>
          </div>
        </div>

        <!-- MÉTODO DE PAGO -->
        <div class="card border-0 shadow-sm rounded-4 mb-4">
          <div class="card-body p-4">
            <div class="d-flex align-items-center mb-4">
              <div class="bg-warning bg-opacity-10 rounded-circle p-2 me-3">
                <i class="bi bi-credit-card-fill text-warning fs-4"></i>
              </div>
              <h4 class="fw-bold mb-0">Método de Pago</h4>
            </div>

            <!-- Tarjeta de Crédito/Débito -->
            <div class="payment-method mb-3">
              <input type="radio" name="payment" id="card" checked>
              <label for="card" class="w-100">
                <div class="card border shadow-sm rounded-4 position-relative">
                  <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                      <div class="d-flex align-items-center">
                        <i class="bi bi-credit-card-2-front text-primary fs-3 me-3"></i>
                        <div>
                          <h5 class="mb-0 fw-bold">Tarjeta de Crédito/Débito</h5>
                          <small class="text-muted">Visa, Mastercard, American Express</small>
                        </div>
                      </div>
                      <div class="card-logos">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/0/04/Visa.svg" alt="Visa">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/2/2a/Mastercard-logo.svg" alt="Mastercard">
                      </div>
                    </div>

                    <div class="card-details mt-3" id="cardDetails">
                      <div class="row g-3">
                        <div class="col-12">
                          <label class="form-label">Número de tarjeta</label>
                          <input type="text" class="form-control" placeholder="1234 5678 9012 3456" maxlength="19">
                        </div>
                        <div class="col-md-8">
                          <label class="form-label">Nombre en la tarjeta</label>
                          <input type="text" class="form-control" placeholder="JUAN PEREZ">
                        </div>
                        <div class="col-md-4">
                          <label class="form-label">Vencimiento</label>
                          <input type="text" class="form-control" placeholder="MM/AA" maxlength="5">
                        </div>
                        <div class="col-md-6">
                          <label class="form-label">CVV</label>
                          <input type="text" class="form-control" placeholder="123" maxlength="4">
                          <small class="text-muted">3 o 4 dígitos en el reverso</small>
                        </div>
                        <div class="col-md-6">
                          <label class="form-label">Cuotas</label>
                          <select class="form-select">
                            <option>1 cuota sin interés</option>
                            <option>3 cuotas sin interés</option>
                            <option>6 cuotas sin interés</option>
                            <option>12 cuotas con interés</option>
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </label>
            </div>

            <!-- Yape -->
            <div class="payment-method mb-3">
              <input type="radio" name="payment" id="yape">
              <label for="yape" class="w-100">
                <div class="card border shadow-sm rounded-4 position-relative">
                  <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                      <div class="bg-purple bg-opacity-10 rounded-circle p-2 me-3" style="background-color: #722C85 !important; opacity: 0.1;">
                        <i class="bi bi-phone-fill fs-3 me-2" style="color: #722C85;"></i>
                      </div>
                      <div>
                        <h5 class="mb-0 fw-bold">Yape</h5>
                        <small class="text-muted">Pago instantáneo desde tu app</small>
                      </div>
                    </div>
                    <div class="mt-3 d-none" id="yapeInstructions">
                      <div class="alert alert-info mb-0">
                        <i class="bi bi-info-circle me-2"></i>
                        <strong>Instrucciones:</strong> Al confirmar, recibirás un código QR para escanear con tu app Yape.
                      </div>
                    </div>
                  </div>
                </div>
              </label>
            </div>

            <!-- Plin -->
            <div class="payment-method mb-3">
              <input type="radio" name="payment" id="plin">
              <label for="plin" class="w-100">
                <div class="card border shadow-sm rounded-4 position-relative">
                  <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                      <div class="bg-info bg-opacity-10 rounded-circle p-2 me-3">
                        <i class="bi bi-phone-fill text-info fs-3 me-2"></i>
                      </div>
                      <div>
                        <h5 class="mb-0 fw-bold">Plin</h5>
                        <small class="text-muted">Pago desde tu celular</small>
                      </div>
                    </div>
                    <div class="mt-3 d-none" id="plinInstructions">
                      <div class="alert alert-info mb-0">
                        <i class="bi bi-info-circle me-2"></i>
                        <strong>Instrucciones:</strong> Recibirás un número de operación para completar tu pago.
                      </div>
                    </div>
                  </div>
                </div>
              </label>
            </div>

            <!-- Transferencia Bancaria -->
            <div class="payment-method mb-3">
              <input type="radio" name="payment" id="transfer">
              <label for="transfer" class="w-100">
                <div class="card border shadow-sm rounded-4 position-relative">
                  <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                      <div class="bg-success bg-opacity-10 rounded-circle p-2 me-3">
                        <i class="bi bi-bank text-success fs-3 me-2"></i>
                      </div>
                      <div>
                        <h5 class="mb-0 fw-bold">Transferencia Bancaria</h5>
                        <small class="text-muted">BCP, BBVA, Interbank, Scotiabank</small>
                      </div>
                    </div>
                    <div class="mt-3 d-none" id="transferInstructions">
                      <div class="alert alert-warning mb-0">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        <strong>Nota:</strong> Tu pedido será procesado después de confirmar el pago (1-2 días hábiles).
                      </div>
                    </div>
                  </div>
                </div>
              </label>
            </div>

            <!-- Pago contra entrega -->
            <div class="payment-method">
              <input type="radio" name="payment" id="cash">
              <label for="cash" class="w-100">
                <div class="card border shadow-sm rounded-4 position-relative">
                  <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                      <div class="bg-secondary bg-opacity-10 rounded-circle p-2 me-3">
                        <i class="bi bi-cash-coin text-secondary fs-3 me-2"></i>
                      </div>
                      <div>
                        <h5 class="mb-0 fw-bold">Pago contra entrega</h5>
                        <small class="text-muted">Solo en Lima Metropolitana</small>
                      </div>
                    </div>
                  </div>
                </div>
              </label>
            </div>
          </div>
        </div>

        <!-- TÉRMINOS Y CONDICIONES -->
        <div class="card border-0 bg-light rounded-4 mb-4">
          <div class="card-body p-4">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="terms" required>
              <label class="form-check-label" for="terms">
                He leído y acepto los <a href="#" class="text-primary">Términos y Condiciones</a>, 
                <a href="#" class="text-primary">Política de Privacidad</a> y 
                <a href="#" class="text-primary">Política de Envíos</a>.
              </label>
            </div>
          </div>
        </div>

      </div>

      <!-- COLUMNA DERECHA: RESUMEN -->
      <div class="col-lg-4">
        <div class="card border-0 shadow-lg rounded-4 sticky-top" style="top: 20px;">
          <div class="card-body p-4">
            <h4 class="fw-bold mb-4">Resumen del Pedido</h4>

            <!-- Productos -->
            <div class="mb-4">
              <div class="d-flex mb-3">
                <img src="https://images.pexels.com/photos/356036/pexels-photo-356036.jpeg?auto=compress&cs=tinysrgb&w=100" 
                     class="rounded" style="width: 60px; height: 60px; object-fit: cover;" alt="Producto">
                <div class="ms-3 flex-grow-1">
                  <p class="mb-1 fw-bold small">Panel Solar Monocristalino 550W</p>
                  <small class="text-muted">Cantidad: 2</small>
                </div>
                <div class="text-end">
                  <p class="mb-0 fw-bold">S/ 1,200</p>
                </div>
              </div>

              <div class="d-flex mb-3">
                <img src="https://images.pexels.com/photos/433308/pexels-photo-433308.jpeg?auto=compress&cs=tinysrgb&w=100" 
                     class="rounded" style="width: 60px; height: 60px; object-fit: cover;" alt="Producto">
                <div class="ms-3 flex-grow-1">
                  <p class="mb-1 fw-bold small">Inversor Híbrido 5kW</p>
                  <small class="text-muted">Cantidad: 1</small>
                </div>
                <div class="text-end">
                  <p class="mb-0 fw-bold">S/ 3,500</p>
                </div>
              </div>
            </div>

            <hr>

            <!-- Código de descuento -->
            <div class="mb-3">
              <label class="form-label small fw-bold">¿Tienes un código de descuento?</label>
              <div class="input-group">
                <input type="text" class="form-control" placeholder="Ingresa tu código">
                <button class="btn btn-outline-primary" type="button">Aplicar</button>
              </div>
            </div>

            <hr>

            <!-- Totales -->
            <div class="mb-2 d-flex justify-content-between">
              <span class="text-muted">Subtotal</span>
              <span class="fw-bold">S/ 4,700.00</span>
            </div>
            <div class="mb-2 d-flex justify-content-between">
              <span class="text-muted">Envío</span>
              <span class="fw-bold text-success">Gratis</span>
            </div>
            <div class="mb-3 d-flex justify-content-between">
              <span class="text-muted">IGV (18%)</span>
              <span class="fw-bold">S/ 846.00</span>
            </div>

            <hr>

            <div class="mb-4 d-flex justify-content-between">
              <span class="fs-5 fw-bold">Total</span>
              <span class="fs-4 fw-bold text-primary">S/ 5,546.00</span>
            </div>

            <!-- Botón de pago -->
            <button class="btn btn-primary btn-lg w-100 mb-3">
              <i class="bi bi-lock-fill me-2"></i>Confirmar y Pagar
            </button>

            <!-- Badges de seguridad -->
            <div class="text-center">
              <div class="d-flex align-items-center justify-content-center gap-3 mb-3">
                <div class="secure-badge">
                  <i class="bi bi-shield-check text-success fs-3"></i>
                </div>
                <small class="text-muted">Pago 100% seguro y encriptado</small>
              </div>
              
              <div class="d-flex justify-content-center gap-2 flex-wrap">
                <span class="badge bg-light text-dark border">
                  <i class="bi bi-shield-lock me-1"></i>SSL
                </span>
                <span class="badge bg-light text-dark border">
                  <i class="bi bi-check-circle me-1"></i>Certificado
                </span>
                <span class="badge bg-light text-dark border">
                  <i class="bi bi-truck me-1"></i>Envío Gratis
                </span>
              </div>
            </div>
          </div>
        </div>

        <!-- Garantías -->
        <div class="card border-0 bg-light rounded-4 mt-4">
          <div class="card-body p-4">
            <h6 class="fw-bold mb-3">Compra con Confianza</h6>
            <ul class="list-unstyled small mb-0">
              <li class="mb-2">
                <i class="bi bi-check-circle-fill text-success me-2"></i>
                Garantía de fábrica incluida
              </li>
              <li class="mb-2">
                <i class="bi bi-check-circle-fill text-success me-2"></i>
                Devolución gratis en 30 días
              </li>
              <li class="mb-2">
                <i class="bi bi-check-circle-fill text-success me-2"></i>
                Instalación profesional disponible
              </li>
              <li class="mb-0">
                <i class="bi bi-check-circle-fill text-success me-2"></i>
                Soporte técnico 24/7
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection

@section('js')
@endsection