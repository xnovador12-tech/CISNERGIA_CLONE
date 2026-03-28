{{-- Método de Pago --}}
<div class="mb-3">
    <label class="form-label small fw-bold">Método de Pago <span class="text-danger">*</span></label>
    <select name="mediopago_id" class="form-select select-metodo-pago" required>
        <option value="">Seleccionar...</option>
        @foreach($mediosPago as $medio)
            <option value="{{ $medio->id }}" data-tipo="{{ strtolower($medio->name) }}">{{ $medio->name }}</option>
        @endforeach
    </select>
</div>

{{-- Billetera Digital (solo si selecciona Billetera Digital) --}}
<div class="mb-3 div-billetera" style="display: none;">
    <label class="form-label small fw-bold">Billetera</label>
    <select name="billetera" class="form-select">
        <option value="">Seleccionar billetera...</option>
        <option value="Yape">Yape</option>
        <option value="Plin">Plin</option>
        <option value="Tunki">Tunki</option>
        <option value="BIM">BIM</option>
    </select>
</div>

{{-- Cuenta Bancaria (Transferencia o Billetera Digital) --}}
<div class="mb-3 div-cuenta-bancaria" style="display: none;">
    <label class="form-label small fw-bold">Cuenta Bancaria</label>
    <select name="cuenta_bancaria_id" class="form-select">
        <option value="">Seleccionar cuenta...</option>
        @foreach($cuentasBancarias as $cuenta)
            <option value="{{ $cuenta->id }}">
                {{ $cuenta->banco->name ?? 'Banco' }} - {{ $cuenta->numero_cuenta }} ({{ $cuenta->moneda->simbolo ?? 'S/' }})
            </option>
        @endforeach
    </select>
</div>

