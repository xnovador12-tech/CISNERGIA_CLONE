<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>{{ $cotizacion->codigo }}</title>
<style>
/* ── PÁGINA ──────────────────────────────────────── */
@page {
    margin: 0;
}
* { margin:0; padding:0; box-sizing:border-box; }
body {
    font-family: 'DejaVu Sans', sans-serif;
    font-size: 8.5px;
    color: #222;
    line-height: 1.5;
    padding: 18mm 20mm 20mm 20mm;
}

/* ── ENCABEZADO ──────────────────────────────────── */
.header-table { width:100%; border-collapse:collapse; margin-bottom:10px; }
.header-table td { vertical-align:middle; }
.logo img { max-height:38px; max-width:130px; }
.logo .brand { font-size:17px; font-weight:700; color:#1C3146; letter-spacing:1px; }
.doc-info { text-align:right; }
.doc-tipo {
    font-size:18px; font-weight:700; color:#1C3146;
    letter-spacing:3px; line-height:1;
}
.doc-codigo {
    font-size:10px; color:#444; font-weight:600;
    margin-top:3px; letter-spacing:0.5px;
}
.doc-version { font-size:8px; color:#999; margin-top:1px; }

/* Línea divisora */
.divider {
    border:none; border-top:1.5px solid #1C3146;
    margin:8px 0 10px;
}
.divider-gold {
    border:none; border-top:2px solid #E8A723;
    margin:0 0 10px;
}

/* ── NOMBRE PROYECTO ─────────────────────────────── */
.project-name {
    font-size:10px; font-weight:700; color:#1C3146;
    margin-bottom:10px;
    padding-left:8px;
    border-left:3px solid #E8A723;
}

/* ── BLOQUES INFO ─────────────────────────────────── */
.info-table { width:100%; border-collapse:collapse; margin-bottom:10px; }
.info-table td { vertical-align:top; }
.info-block { font-size:8px; }
.info-block .block-title {
    font-size:7px; font-weight:700; text-transform:uppercase;
    letter-spacing:0.8px; color:#1C3146;
    border-bottom:1px solid #ddd;
    padding-bottom:3px; margin-bottom:5px;
}
.info-block p { margin:1.5px 0; }
.info-block .lbl { color:#888; }
.info-block .val { font-weight:600; color:#111; }
.info-block .name { font-size:9.5px; font-weight:700; color:#1C3146; margin-bottom:2px; }

/* ── META DATOS (fila compacta) ──────────────────── */
.meta-table {
    width:100%; border-collapse:collapse;
    border:1px solid #ddd; border-radius:3px;
    margin-bottom:12px; font-size:8px;
}
.meta-table td {
    padding:5px 8px;
    border-right:1px solid #ddd;
    text-align:center;
}
.meta-table td:last-child { border-right:none; }
.meta-lbl { color:#888; font-size:7px; display:block; }
.meta-val { font-weight:700; color:#1C3146; display:block; margin-top:1px; }

/* ── TABLA ÍTEMS ─────────────────────────────────── */
.section-label {
    font-size:8px; font-weight:700; text-transform:uppercase;
    letter-spacing:0.8px; color:#1C3146;
    border-bottom:1.5px solid #1C3146;
    padding-bottom:3px; margin-bottom:6px;
}
.items-table {
    width:100%; border-collapse:collapse;
    margin-bottom:12px; font-size:8px;
}
.items-table th {
    background:#1C3146; color:#fff;
    padding:5px 7px; font-size:7px;
    text-transform:uppercase; font-weight:700;
    letter-spacing:0.3px;
}
.items-table th.c { text-align:center; }
.items-table th.r { text-align:right; }

.items-table td {
    padding:5px 7px;
    border-bottom:1px solid #eee;
    vertical-align:top;
}
.items-table tr:nth-child(even) td { background:#fafafa; }
.items-table .c { text-align:center; }
.items-table .r { text-align:right; }

/* Cabecera categoría */
.cat-row td {
    background:#f4f6f9 !important;
    font-weight:700; font-size:7.5px; color:#444;
    padding:4px 7px;
    border-top:1px solid #ddd;
    border-bottom:1px solid #ddd;
    text-transform:uppercase; letter-spacing:0.4px;
}
/* Subtotal cat */
.subcat-row td {
    text-align:right; font-weight:700;
    font-size:7.8px; color:#1C3146;
    background:#eef1f5 !important;
    padding:4px 7px;
    border-bottom:1.5px solid #ccd3dc;
}
.item-desc { font-weight:600; }
.item-spec { color:#888; font-size:7.5px; margin-top:1px; }
.dto-badge { color:#c0392b; font-weight:700; }

/* ── TOTALES + CONDICIONES ───────────────────────── */
.lower-table { width:100%; border-collapse:collapse; }
.lower-table td { vertical-align:top; }

/* Condiciones */
.cond { font-size:7.8px; color:#333; }
.cond .cond-title {
    font-size:7.5px; font-weight:700; text-transform:uppercase;
    letter-spacing:0.7px; color:#1C3146;
    border-bottom:1px solid #ddd;
    padding-bottom:3px; margin-bottom:5px;
}
.cond p { margin:2.5px 0; }
.cond .cl { font-weight:700; color:#333; }
.cond .cv { color:#555; }
.cond .nota {
    margin-top:6px; font-size:7px; color:#aaa;
    border-top:1px dashed #ddd; padding-top:5px;
}

/* Totales */
.totales { width:100%; border-collapse:collapse; }
.totales td { padding:4px 8px; font-size:8.5px; }
.totales .tl { text-align:right; color:#666; }
.totales .tv { text-align:right; font-weight:700; }
.totales .sep td { border-top:1px solid #ddd; }
.totales .dto td { color:#c0392b; }
.totales .igv-row td { color:#666; font-size:8px; }
.totales .total-row td {
    border-top:2px solid #1C3146;
    font-size:11px; font-weight:700;
    color:#1C3146; padding-top:6px;
}
.total-row .tv { color:#1C3146; }
.letras {
    margin-top:6px; font-size:7.5px; color:#555;
    font-style:italic; border-top:1px dashed #ddd; padding-top:5px;
}

/* ── FIRMAS ──────────────────────────────────────── */
.firmas { width:100%; border-collapse:collapse; margin-top:22px; }
.firmas td { text-align:center; vertical-align:bottom; padding:0 20px; width:50%; }
.firma-space { height:40px; }
.firma-line { border-top:1px solid #555; padding-top:5px; }
.firma-name { font-weight:700; font-size:8.5px; color:#1C3146; }
.firma-rol  { font-size:7.5px; color:#888; margin-top:1px; }

/* ── NOTA FINAL ──────────────────────────────────── */
.nota-legal {
    margin-top:14px; font-size:7px; color:#bbb;
    text-align:center; border-top:1px dashed #eee; padding-top:6px;
}

/* ── PIE DE PÁGINA ───────────────────────────────── */
.page-footer {
    position:fixed; bottom:0; left:20mm; right:20mm;
    border-top:1px solid #ddd;
    padding:5px 0 8px;
    font-size:7px; color:#aaa;
}
.page-footer table { width:100%; border-collapse:collapse; }
.page-footer td { vertical-align:middle; padding:0 2px; }
</style>
</head>
<body>

{{-- PIE FIJO --}}
<div class="page-footer">
    <table>
        <tr>
            <td style="text-align:left;">CISNERGIA S.A.C. &mdash; Pisco, Ica, Perú</td>
            <td style="text-align:center;">{{ $cotizacion->codigo }}{{ $cotizacion->version > 1 ? ' · Rev.'.$cotizacion->version : '' }}</td>
            <td style="text-align:right;">Vigente hasta {{ $cotizacion->fecha_vigencia?->format('d/m/Y') }}</td>
        </tr>
    </table>
</div>

@php
    $prospecto   = $cotizacion->oportunidad?->prospecto;
    $oportunidad = $cotizacion->oportunidad;
    $vendedor    = $cotizacion->usuario;
    $catInfo     = \App\Models\DetalleCotizacionCrm::CATEGORIAS;
    $conDto      = $cotizacion->detalles->sum(fn($d)=>(float)$d->descuento_monto) > 0;
    $cols        = $conDto ? 7 : 6;

    $segmentos = ['residencial'=>'Residencial','comercial'=>'Comercial','industrial'=>'Industrial','agricola'=>'Agrícola'];

    function cifraEnLetras(float $n): string {
        $ent = (int)$n;
        $cts = (int)round(($n - $ent)*100);
        $u = ['','UNO','DOS','TRES','CUATRO','CINCO','SEIS','SIETE','OCHO','NUEVE',
              'DIEZ','ONCE','DOCE','TRECE','CATORCE','QUINCE','DIECISÉIS',
              'DIECISIETE','DIECIOCHO','DIECINUEVE'];
        $d = ['','','VEINTE','TREINTA','CUARENTA','CINCUENTA','SESENTA','SETENTA','OCHENTA','NOVENTA'];
        $c = ['','CIENTO','DOSCIENTOS','TRESCIENTOS','CUATROCIENTOS','QUINIENTOS',
              'SEISCIENTOS','SETECIENTOS','OCHOCIENTOS','NOVECIENTOS'];
        $f = function(int $x) use($u,$d,$c,&$f):string {
            if($x==0) return '';
            if($x==100) return 'CIEN';
            if($x<20)   return $u[$x];
            if($x<100)  return $d[(int)($x/10)].($x%10?' Y '.$u[$x%10]:'');
            if($x<1000) return $c[(int)($x/100)].($x%100?' '.$f($x%100):'');
            $m=(int)($x/1000); $r=$x%1000;
            return ($m==1?'MIL':$f($m).' MIL').($r?' '.$f($r):'');
        };
        return ($ent==0?'CERO':$f($ent)).' CON '.str_pad($cts,2,'0',STR_PAD_LEFT).'/100 SOLES';
    }
@endphp

{{-- ╔══════════════════════════════════════════════╗ --}}
{{-- ║  ENCABEZADO                                  ║ --}}
{{-- ╚══════════════════════════════════════════════╝ --}}
<table class="header-table">
    <tr>
        <td class="logo" style="width:50%;">
            @php
                $logo = public_path('images/cisnergia_v.png');
            @endphp
            @if(file_exists($logo))
                <img src="{{ $logo }}" alt="Cisnergia">
            @else
                <span class="brand">CISNERGIA</span>
            @endif
            <div style="font-size:7px; color:#888; margin-top:3px;">Energía Solar · Pisco, Ica, Perú</div>
        </td>
        <td class="doc-info">
            <div class="doc-tipo">COTIZACIÓN</div>
            <div class="doc-codigo">{{ $cotizacion->codigo }}</div>
            @if($cotizacion->version > 1)
                <div class="doc-version">Revisión {{ $cotizacion->version }}</div>
            @endif
        </td>
    </tr>
</table>

<hr class="divider">
<div class="divider-gold" style="margin-top:-9px;"></div>

{{-- NOMBRE DEL PROYECTO --}}
<div class="project-name">{{ $cotizacion->nombre_proyecto }}</div>

{{-- ╔══════════════════════════════════════════════╗ --}}
{{-- ║  EMISOR / RECEPTOR                           ║ --}}
{{-- ╚══════════════════════════════════════════════╝ --}}
<table class="info-table">
    <tr>
        {{-- Datos Cisnergia --}}
        <td style="width:48%; padding-right:10px;">
            <div class="info-block">
                <div class="block-title">Empresa Oferente</div>
                <p class="name">CISNERGIA S.A.C.</p>
                <p><span class="lbl">RUC: </span><span class="val">20XXXXXXXXX</span></p>
                <p><span class="lbl">Dirección: </span>Pisco, Ica, Perú</p>
                <p><span class="lbl">Responsable: </span>
                    <span class="val">{{ $vendedor?->persona?->name ?? $vendedor?->email ?? '—' }}</span>
                </p>
                <p><span class="lbl">Emisión: </span>
                    <span class="val">{{ $cotizacion->fecha_emision?->isoFormat('D [de] MMMM [de] Y') }}</span>
                </p>
            </div>
        </td>
        {{-- Datos Cliente --}}
        <td style="width:52%;">
            <div class="info-block">
                <div class="block-title">Cliente</div>
                @if($prospecto)
                    <p class="name">{{ $prospecto->nombre_completo }}</p>
                    @if($prospecto->razon_social)
                        <p><span class="lbl">Razón Social: </span><span class="val">{{ $prospecto->razon_social }}</span></p>
                    @endif
                    @if($prospecto->ruc)
                        <p><span class="lbl">RUC: </span><span class="val">{{ $prospecto->ruc }}</span></p>
                    @elseif($prospecto->dni)
                        <p><span class="lbl">DNI: </span><span class="val">{{ $prospecto->dni }}</span></p>
                    @endif
                    @if($prospecto->email)
                        <p><span class="lbl">Email: </span>{{ $prospecto->email }}</p>
                    @endif
                    @if($prospecto->telefono || $prospecto->celular)
                        <p><span class="lbl">Teléfono: </span>{{ $prospecto->telefono ?? $prospecto->celular }}</p>
                    @endif
                    @if($prospecto->direccion)
                        <p><span class="lbl">Dirección: </span>{{ $prospecto->direccion }}</p>
                    @endif
                    @if($oportunidad?->tipo_proyecto)
                        <p><span class="lbl">Segmento: </span>
                            <span class="val">{{ $segmentos[$oportunidad->tipo_proyecto] ?? '' }}</span>
                        </p>
                    @endif
                @else
                    <p style="color:#aaa;">Sin datos de cliente.</p>
                @endif
            </div>
        </td>
    </tr>
</table>

{{-- ╔══════════════════════════════════════════════╗ --}}
{{-- ║  META DATOS                                  ║ --}}
{{-- ╚══════════════════════════════════════════════╝ --}}
<table class="meta-table">
    <tr>
        <td>
            <span class="meta-lbl">N° Cotización</span>
            <span class="meta-val">{{ $cotizacion->codigo }}</span>
        </td>
        <td>
            <span class="meta-lbl">Fecha Emisión</span>
            <span class="meta-val">{{ $cotizacion->fecha_emision?->format('d/m/Y') }}</span>
        </td>
        <td>
            <span class="meta-lbl">Válida Hasta</span>
            <span class="meta-val">{{ $cotizacion->fecha_vigencia?->format('d/m/Y') }}</span>
        </td>
        <td>
            <span class="meta-lbl">Ejecución</span>
            <span class="meta-val">{{ $cotizacion->tiempo_ejecucion_dias }} días hábiles</span>
        </td>
        <td>
            <span class="meta-lbl">Moneda</span>
            <span class="meta-val">S/ (PEN)</span>
        </td>
        <td>
            <span class="meta-lbl">IGV</span>
            <span class="meta-val">{{ $cotizacion->incluye_igv ? 'Incluido' : 'No incluido' }}</span>
        </td>
    </tr>
</table>

{{-- ╔══════════════════════════════════════════════╗ --}}
{{-- ║  DETALLE DE ÍTEMS                            ║ --}}
{{-- ╚══════════════════════════════════════════════╝ --}}
<div class="section-label">Detalle de la Oferta</div>

<table class="items-table">
    <thead>
        <tr>
            <th style="width:24px;" class="c">N°</th>
            <th>Descripción</th>
            <th style="width:40px;" class="c">Cant.</th>
            <th style="width:38px;" class="c">Und.</th>
            <th style="width:68px;" class="r">P. Unit.</th>
            @if($conDto)
                <th style="width:36px;" class="c">Dto.</th>
            @endif
            <th style="width:72px;" class="r">Subtotal</th>
        </tr>
    </thead>
    <tbody>
        @php $n = 1; @endphp
        @foreach($detallesPorCategoria as $cat => $items)
            <tr class="cat-row">
                <td colspan="{{ $cols }}">
                    {{ $catInfo[$cat]['nombre'] ?? ucfirst($cat) }}s
                </td>
            </tr>

            @foreach($items as $item)
                <tr>
                    <td class="c" style="color:#aaa;">{{ $n++ }}</td>
                    <td>
                        <span class="item-desc">{{ $item->descripcion }}</span>
                        @if($item->especificaciones)
                            <div class="item-spec">{{ $item->especificaciones }}</div>
                        @endif
                    </td>
                    <td class="c">{{ rtrim(rtrim(number_format((float)$item->cantidad,4,'.',''),'0'),'.') }}</td>
                    <td class="c">{{ $item->nombre_unidad }}</td>
                    <td class="r">S/ {{ number_format((float)$item->precio_unitario,2) }}</td>
                    @if($conDto)
                        <td class="c">
                            @if((float)$item->descuento_porcentaje > 0)
                                <span class="dto-badge">{{ number_format((float)$item->descuento_porcentaje,0) }}%</span>
                            @else
                                <span style="color:#ddd;">—</span>
                            @endif
                        </td>
                    @endif
                    <td class="r" style="font-weight:700;">S/ {{ number_format((float)$item->subtotal,2) }}</td>
                </tr>
            @endforeach

            <tr class="subcat-row">
                <td colspan="{{ $cols - 1 }}">Subtotal {{ $catInfo[$cat]['nombre'] ?? '' }}s:</td>
                <td style="text-align:right;">S/ {{ number_format((float)$items->sum('subtotal'),2) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

{{-- ╔══════════════════════════════════════════════╗ --}}
{{-- ║  CONDICIONES + TOTALES                       ║ --}}
{{-- ╚══════════════════════════════════════════════╝ --}}
<table class="lower-table">
    <tr>
        {{-- Condiciones --}}
        <td style="width:57%; padding-right:14px; vertical-align:top;">
            <div class="cond">
                <div class="cond-title">Términos y Condiciones</div>

                <p><span class="cl">Condiciones de pago: </span>
                    <span class="cv">{{ $cotizacion->condiciones_comerciales ?: '50% anticipo, 50% contra entrega.' }}</span>
                </p>

                <p><span class="cl">Garantía: </span>
                    <span class="cv">{{ $cotizacion->garantia_servicio ?: 'Según fabricante — paneles 25 años rendimiento, inversor 5 años.' }}</span>
                </p>

                <p><span class="cl">Tiempo de ejecución: </span>
                    <span class="cv">{{ $cotizacion->tiempo_ejecucion_dias }} días hábiles desde confirmación del pedido.</span>
                </p>

                <p><span class="cl">Validez de la oferta: </span>
                    <span class="cv">Hasta el {{ $cotizacion->fecha_vigencia?->format('d/m/Y') }}.</span>
                </p>

                @if($cotizacion->observaciones)
                    <p style="margin-top:4px;"><span class="cl">Observaciones: </span>
                        <span class="cv">{{ $cotizacion->observaciones }}</span>
                    </p>
                @endif

                <p class="nota">
                    Precios en Soles {{ $cotizacion->incluye_igv ? 'incluyen IGV (18%)' : 'no incluyen IGV' }}.
                    Incluye materiales, mano de obra y trámites indicados.
                    Equipos y modelos sujetos a disponibilidad en almacén.
                </p>
            </div>
        </td>

        {{-- Totales --}}
        <td style="width:43%; vertical-align:top;">
            <table class="totales">
                <tr>
                    <td class="tl">Subtotal:</td>
                    <td class="tv">S/ {{ number_format((float)$cotizacion->subtotal,2) }}</td>
                </tr>

                @if((float)$cotizacion->descuento_monto > 0)
                    <tr class="dto">
                        <td class="tl">Descuento ({{ number_format((float)$cotizacion->descuento_porcentaje,1) }}%):</td>
                        <td class="tv">– S/ {{ number_format((float)$cotizacion->descuento_monto,2) }}</td>
                    </tr>
                    <tr class="sep">
                        <td class="tl">Base imponible:</td>
                        <td class="tv">S/ {{ number_format((float)$cotizacion->subtotal - (float)$cotizacion->descuento_monto,2) }}</td>
                    </tr>
                @endif

                @if($cotizacion->incluye_igv)
                    <tr class="igv-row">
                        <td class="tl">IGV (18%):</td>
                        <td class="tv">S/ {{ number_format((float)$cotizacion->igv,2) }}</td>
                    </tr>
                @endif

                <tr class="total-row">
                    <td class="tl">TOTAL:</td>
                    <td class="tv">S/ {{ number_format((float)$cotizacion->total,2) }}</td>
                </tr>
            </table>
            <div class="letras">
                <strong>Son:</strong> {{ cifraEnLetras((float)$cotizacion->total) }}
            </div>
        </td>
    </tr>
</table>

{{-- ╔══════════════════════════════════════════════╗ --}}
{{-- ║  FIRMAS                                      ║ --}}
{{-- ╚══════════════════════════════════════════════╝ --}}
<table class="firmas">
    <tr>
        <td>
            <div class="firma-space"></div>
            <div class="firma-line">
                <div class="firma-name">{{ $vendedor?->persona?->name ?? $vendedor?->email ?? 'Representante Comercial' }}</div>
                <div class="firma-rol">Por: CISNERGIA S.A.C.</div>
            </div>
        </td>
        <td>
            <div class="firma-space"></div>
            <div class="firma-line">
                <div class="firma-name">{{ $prospecto?->nombre_completo ?? 'Cliente' }}</div>
                <div class="firma-rol">
                    {{ $prospecto?->ruc ? 'RUC: '.$prospecto->ruc : ($prospecto?->dni ? 'DNI: '.$prospecto->dni : 'Documento: _______________') }}
                </div>
            </div>
        </td>
    </tr>
</table>

<p class="nota-legal">
    Documento referencial emitido por CISNERGIA S.A.C. La aceptación se formaliza con firma y pago de anticipo.
    Generado el {{ now()->format('d/m/Y H:i') }}.
</p>

</body>
</html>
