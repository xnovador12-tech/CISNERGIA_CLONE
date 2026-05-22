@extends('TEMPLATES.administrador')

@section('title', 'Debug Queue | Email Marketing')

@section('css')
<style>
    :root {
        --dq-dark:    #1C3146;
        --dq-green:   #20c997;
        --dq-danger:  #dc3545;
        --dq-warning: #fd7e14;
        --dq-muted:   #6c757d;
        --dq-border:  #dee2e6;
        --dq-bg:      #f8f9fa;
    }
    body { background: #eef0f3; }
    .dq-wrap { max-width: 1200px; margin: 24px auto; padding: 0 16px; }
    .dq-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 12px; }
    .dq-header h1 { font-family: 'Crimson Pro', serif; font-size: 24px; color: var(--dq-dark); margin: 0; }
    .dq-btn-volver { background: white; border: 1px solid var(--dq-border); padding: 7px 14px; border-radius: 7px; font-size: 12px; font-weight: 600; color: var(--dq-dark); text-decoration: none; display: inline-flex; align-items: center; gap: 6px; }
    .dq-btn-volver:hover { background: var(--dq-bg); }
    .dq-btn-refresh { background: var(--dq-dark); color: white; border: none; padding: 8px 16px; border-radius: 7px; font-size: 12px; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; text-decoration: none; }
    .dq-btn-refresh:hover { background: #132435; color: white; }

    .dq-cards { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 14px; margin-bottom: 24px; }
    .dq-card { background: white; border-radius: 10px; padding: 16px; border-left: 4px solid var(--dq-dark); }
    .dq-card.danger  { border-left-color: var(--dq-danger); }
    .dq-card.warning { border-left-color: var(--dq-warning); }
    .dq-card.success { border-left-color: var(--dq-green); }
    .dq-card-label { font-size: 10px; font-weight: 700; text-transform: uppercase; color: var(--dq-muted); letter-spacing: .8px; }
    .dq-card-value { font-size: 28px; font-weight: 700; color: var(--dq-dark); line-height: 1.2; }
    .dq-card-sub { font-size: 11px; color: var(--dq-muted); }

    .dq-section { background: white; border-radius: 10px; padding: 20px; margin-bottom: 18px; }
    .dq-section h2 { font-family: 'Crimson Pro', serif; font-size: 17px; color: var(--dq-dark); margin: 0 0 14px; display: flex; align-items: center; gap: 8px; }
    .dq-section h2 .badge { background: var(--dq-bg); color: var(--dq-muted); font-size: 11px; padding: 2px 10px; border-radius: 12px; font-weight: 600; }

    .dq-table { width: 100%; font-size: 12px; border-collapse: collapse; }
    .dq-table th { background: var(--dq-bg); padding: 8px 10px; text-align: left; font-weight: 600; color: var(--dq-muted); text-transform: uppercase; font-size: 10px; letter-spacing: .5px; border-bottom: 1px solid var(--dq-border); }
    .dq-table td { padding: 9px 10px; border-bottom: 1px solid #f1f3f5; color: var(--dq-dark); vertical-align: top; }
    .dq-table tr:last-child td { border-bottom: none; }
    .dq-table .mono { font-family: 'Courier New', monospace; font-size: 11px; }

    .dq-estado { display: inline-block; padding: 2px 8px; border-radius: 10px; font-size: 10px; font-weight: 700; text-transform: uppercase; }
    .dq-estado.pendiente { background: rgba(253,126,20,0.12); color: var(--dq-warning); }
    .dq-estado.procesando { background: rgba(13,110,253,0.12); color: #0d6efd; }
    .dq-estado.enviado { background: rgba(32,201,151,0.12); color: var(--dq-green); }
    .dq-estado.fallido { background: rgba(220,53,69,0.12); color: var(--dq-danger); }
    .dq-estado.parcial { background: rgba(255,193,7,0.18); color: #856404; }

    .dq-empty { text-align: center; padding: 28px; color: var(--dq-muted); font-size: 13px; }
    .dq-empty svg { opacity: 0.3; margin-bottom: 8px; }

    .dq-config { background: var(--dq-bg); border-radius: 6px; padding: 12px 14px; font-family: 'Courier New', monospace; font-size: 12px; line-height: 1.8; color: var(--dq-dark); }
    .dq-config .k { color: var(--dq-muted); }

    .dq-exception { background: #1e1e1e; color: #f8f9fa; padding: 12px; border-radius: 6px; font-family: 'Courier New', monospace; font-size: 11px; white-space: pre-wrap; word-break: break-word; max-height: 200px; overflow-y: auto; }
    .dq-exception-toggle { background: none; border: 1px solid var(--dq-border); padding: 3px 9px; border-radius: 5px; font-size: 11px; cursor: pointer; color: var(--dq-muted); }
    .dq-exception-toggle:hover { color: var(--dq-dark); border-color: var(--dq-dark); }
    .dq-exception-wrap { display: none; margin-top: 8px; }
    .dq-exception-wrap.activo { display: block; }

    .dq-actions { display: inline-flex; gap: 6px; }
    .dq-actions form { margin: 0; display: inline; }
    .dq-actions button { background: white; border: 1px solid var(--dq-border); padding: 4px 10px; border-radius: 5px; font-size: 11px; cursor: pointer; font-weight: 600; }
    .dq-actions button.retry { color: #0d6efd; border-color: rgba(13,110,253,0.4); }
    .dq-actions button.retry:hover { background: rgba(13,110,253,0.08); }
    .dq-actions button.del { color: var(--dq-danger); border-color: rgba(220,53,69,0.4); }
    .dq-actions button.del:hover { background: rgba(220,53,69,0.08); }

    .dq-flash { padding: 10px 14px; border-radius: 8px; margin-bottom: 16px; font-size: 13px; }
    .dq-flash.success { background: rgba(32,201,151,0.12); color: #0f7053; border: 1px solid rgba(32,201,151,0.4); }
</style>
@endsection

@section('content')
<div class="dq-wrap">
    <div class="dq-header">
        <h1>🔍 Debug del envío de correos</h1>
        <div style="display:flex;gap:8px;">
            <a href="{{ route('admin.marketing.emails') }}" class="dq-btn-volver">← Volver al composer</a>
            <a href="{{ route('admin.marketing.emails.debug-queue') }}" class="dq-btn-refresh">↻ Refrescar</a>
        </div>
    </div>

    @if(session('success'))
        <div class="dq-flash success">✓ {{ session('success') }}</div>
    @endif

    {{-- ─── CARDS DE RESUMEN ─── --}}
    <div class="dq-cards">
        <div class="dq-card {{ $resumen['pendientes_total'] > 0 ? 'warning' : 'success' }}">
            <div class="dq-card-label">Pendientes en cola</div>
            <div class="dq-card-value">{{ $resumen['pendientes_total'] }}</div>
            <div class="dq-card-sub">Esperando al worker</div>
        </div>
        <div class="dq-card {{ $resumen['fallidos_total'] > 0 ? 'danger' : 'success' }}">
            <div class="dq-card-label">Fallidos</div>
            <div class="dq-card-value">{{ $resumen['fallidos_total'] }}</div>
            <div class="dq-card-sub">Reintentos agotados</div>
        </div>
        <div class="dq-card {{ $resumen['programadas_pendientes'] > 0 ? 'warning' : 'success' }}">
            <div class="dq-card-label">Programadas a futuro</div>
            <div class="dq-card-value">{{ $resumen['programadas_pendientes'] }}</div>
            <div class="dq-card-sub">Campañas en outbox</div>
        </div>
    </div>

    {{-- ─── CONFIG ACTUAL ─── --}}
    <div class="dq-section">
        <h2>⚙ Configuración activa</h2>
        <div class="dq-config">
            <div><span class="k">MAIL_HOST:</span> {{ $resumen['mail_host'] ?? 'NO DEFINIDO' }}</div>
            <div><span class="k">MAIL_PORT:</span> {{ $resumen['mail_port'] ?? 'NO DEFINIDO' }}</div>
            <div><span class="k">MAIL_USERNAME:</span> {{ $resumen['mail_username'] ? substr($resumen['mail_username'], 0, 4) . '****' : 'NO DEFINIDO' }}</div>
            <div><span class="k">MAIL_FROM:</span> {{ $resumen['mail_from'] ?? 'NO DEFINIDO' }}</div>
            <div><span class="k">MAIL_TIMEOUT:</span> {{ $resumen['mail_timeout'] ?? 'sin límite' }}s</div>
            <div><span class="k">QUEUE_CONNECTION:</span> {{ $resumen['queue_connection'] }}</div>
            <div><span class="k">LOG_CHANNEL:</span> {{ $resumen['log_channel'] }}</div>
        </div>
    </div>

    {{-- ─── JOBS FALLIDOS ─── --}}
    <div class="dq-section">
        <h2>❌ Jobs fallidos <span class="badge">{{ count($fallidos) }} mostrados</span></h2>
        @if(count($fallidos) === 0)
            <div class="dq-empty">
                <svg width="44" height="44" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M20 6L9 17l-5-5"/></svg>
                <div>No hay jobs fallidos. ¡Buen indicio!</div>
            </div>
        @else
            <table class="dq-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tipo</th>
                        <th>Cola</th>
                        <th>Fallado en</th>
                        <th>Excepción</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($fallidos as $f)
                    <tr>
                        <td class="mono">{{ Str::limit($f['id'], 10, '…') }}</td>
                        <td>{{ Str::limit($f['display'], 40) }}</td>
                        <td>{{ $f['queue'] }}</td>
                        <td class="mono">{{ \Carbon\Carbon::parse($f['failed_at'])->format('d M H:i:s') }}</td>
                        <td>
                            <button class="dq-exception-toggle" onclick="this.nextElementSibling.classList.toggle('activo')">Ver excepción ▾</button>
                            <div class="dq-exception-wrap">
                                <div class="dq-exception">{{ $f['exception'] }}</div>
                            </div>
                        </td>
                        <td>
                            <div class="dq-actions">
                                <form action="{{ route('admin.marketing.emails.debug-queue.reintentar', $f['id']) }}" method="POST" onsubmit="return confirm('¿Reintentar este job?')">
                                    @csrf
                                    <button type="submit" class="retry">↻ Reintentar</button>
                                </form>
                                <form action="{{ route('admin.marketing.emails.debug-queue.eliminar', $f['id']) }}" method="POST" onsubmit="return confirm('¿Eliminar definitivamente?')">
                                    @csrf
                                    <button type="submit" class="del">✕ Eliminar</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>

    {{-- ─── JOBS PENDIENTES ─── --}}
    <div class="dq-section">
        <h2>⏳ Jobs pendientes en cola <span class="badge">{{ count($pendientes) }} mostrados de {{ $resumen['pendientes_total'] }}</span></h2>
        @if(count($pendientes) === 0)
            <div class="dq-empty">
                <svg width="44" height="44" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                <div>Cola vacía. El worker procesó todo.</div>
            </div>
        @else
            <table class="dq-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tipo</th>
                        <th>Cola</th>
                        <th>Intentos</th>
                        <th>Disponible desde</th>
                        <th>Encolado en</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($pendientes as $p)
                    <tr>
                        <td class="mono">{{ $p['id'] }}</td>
                        <td>{{ Str::limit($p['display'], 40) }}</td>
                        <td>{{ $p['queue'] }}</td>
                        <td>{{ $p['attempts'] }}</td>
                        <td class="mono">{{ $p['available_at'] }}</td>
                        <td class="mono">{{ $p['created_at'] }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>

    {{-- ─── CAMPAÑAS PROGRAMADAS A FUTURO ─── --}}
    <div class="dq-section">
        <h2>📅 Campañas programadas (outbox) <span class="badge">últimas {{ count($programadas) }}</span></h2>
        @if(count($programadas) === 0)
            <div class="dq-empty">
                <svg width="44" height="44" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                <div>Aún no hay campañas programadas a futuro.</div>
            </div>
        @else
            <table class="dq-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Asunto</th>
                        <th>Estado</th>
                        <th>Destinatarios</th>
                        <th>Enviar el</th>
                        <th>Procesado en</th>
                        <th>Resultado</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($programadas as $c)
                    <tr>
                        <td class="mono">{{ $c->id }}</td>
                        <td>{{ Str::limit($c->asunto, 30) }}</td>
                        <td><span class="dq-estado {{ $c->estado }}">{{ $c->estado }}</span></td>
                        <td>{{ is_array($c->destinatarios) ? count($c->destinatarios) : 0 }}</td>
                        <td class="mono">{{ \Carbon\Carbon::parse($c->enviar_el)->format('d M Y H:i') }}</td>
                        <td class="mono">{{ $c->procesado_en ? \Carbon\Carbon::parse($c->procesado_en)->format('d M H:i:s') : '—' }}</td>
                        <td>
                            @if($c->enviados_count || $c->fallidos_count)
                                <span style="color:var(--dq-green);">✓{{ $c->enviados_count }}</span>
                                @if($c->fallidos_count)
                                    <span style="color:var(--dq-danger);"> ✘{{ $c->fallidos_count }}</span>
                                @endif
                            @else
                                —
                            @endif
                            @if($c->detalle_error)
                                <div style="font-size:10px;color:var(--dq-danger);margin-top:4px;">{{ Str::limit($c->detalle_error, 60) }}</div>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <p style="font-size:11px;color:var(--dq-muted);text-align:center;margin-top:18px;">
        Esta vista es de solo diagnóstico. No envía correos por sí misma — solo lee el estado de las tablas <code>jobs</code>, <code>failed_jobs</code> y <code>campanas_email_programadas</code>.
    </p>
</div>
@endsection
