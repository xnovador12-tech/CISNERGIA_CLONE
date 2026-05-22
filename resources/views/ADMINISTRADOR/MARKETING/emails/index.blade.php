@extends('TEMPLATES.administrador')

@section('title', 'Email Marketing | Cisnergia')

@section('css')
<link href="https://fonts.googleapis.com/css2?family=Crimson+Pro:wght@400;600;700&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@300..600,0..1&display=swap" rel="stylesheet"/>
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

<style>
    :root {
        --cs-dark:     #212529;
        --cs-dark-2:   #343a40;
        --cs-mid:      #495057;
        --cs-muted:    #6c757d;
        --cs-border:   #dee2e6;
        --cs-light:    #f8f9fa;
        --cs-white:    #ffffff;
        --cs-accent:   #0d6efd;
        --cs-accent-h: #0a58ca;
        --cs-accent-lt:#e7f0ff;
        --cs-success:  #198754;
        --cs-danger:   #dc3545;
        --cs-radius:   10px;
    }

    .cs-composer-wrap {
        background: #eef0f3;
        min-height: calc(100vh - 80px);
        padding: 32px 16px;
    }

    .cs-panel {
        background: var(--cs-white);
        border: 1px solid var(--cs-border);
        border-radius: var(--cs-radius);
        box-shadow: 0 4px 24px rgba(33,37,41,.07);
        overflow: hidden;
    }

    .cs-panel-header {
        background: var(--cs-dark);
        color: var(--cs-white);
        padding: 20px 32px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .cs-panel-header h2 {
        font-family: 'Crimson Pro', Georgia, serif;
        font-size: 22px;
        font-weight: 600;
        margin: 0;
        letter-spacing: .3px;
    }
    .cs-badge-secure {
        font-family: 'DM Sans', sans-serif;
        font-size: 10px;
        font-weight: 600;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        background: rgba(255,255,255,.12);
        border: 1px solid rgba(255,255,255,.2);
        color: #ced4da;
        padding: 4px 12px;
        border-radius: 20px;
    }

    .cs-section {
        padding: 24px 32px;
        border-bottom: 1px solid var(--cs-border);
    }

    .cs-field-row {
        display: flex;
        align-items: center;
        gap: 16px;
    }
    .cs-label {
        width: 64px;
        font-family: 'DM Sans', sans-serif;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: .8px;
        color: var(--cs-muted);
        flex-shrink: 0;
    }
    .cs-input {
        flex: 1;
        border: 1px solid var(--cs-border);
        border-radius: 7px;
        padding: 9px 14px;
        font-family: 'DM Sans', sans-serif;
        font-size: 14px;
        color: var(--cs-dark);
        outline: none;
        transition: border-color .2s, box-shadow .2s;
        background: var(--cs-white);
    }
    .cs-input:focus {
        border-color: var(--cs-accent);
        box-shadow: 0 0 0 3px rgba(13,110,253,.12);
    }
    .cs-input-subject {
        font-size: 16px;
        font-weight: 600;
        color: var(--cs-dark-2);
    }

    .cs-section-label {
        font-family: 'DM Sans', sans-serif;
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        color: var(--cs-muted);
        margin-bottom: 12px;
    }
    .logos-row {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }
    .logo-upload-btn {
        width: 52px;
        height: 52px;
        border: 2px dashed #adb5bd;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all .2s;
        flex-shrink: 0;
        background: var(--cs-light);
    }
    .logo-upload-btn:hover {
        border-color: var(--cs-accent);
        background: var(--cs-accent-lt);
    }
    .logo-upload-btn .material-symbols-outlined { color: var(--cs-muted); font-size: 22px; }
    .logo-upload-btn:hover .material-symbols-outlined { color: var(--cs-accent); }

    .logo-divider { width: 1px; height: 40px; background: var(--cs-border); margin: 0 4px; flex-shrink: 0; }

    /* ── Logo item: SIN onclick en HTML, manejado por JS con data-path ── */
    .logo-item {
        width: 90px;
        height: 52px;
        border: 2px solid var(--cs-border);
        border-radius: 8px;
        cursor: pointer;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--cs-white);
        transition: all .2s;
        flex-shrink: 0;
    }
    .logo-item img { max-width: 85%; max-height: 85%; object-fit: contain; pointer-events: none; }
    .logo-item:hover { border-color: #adb5bd; }
    .logo-item.selected {
        border-color: var(--cs-accent) !important;
        background: var(--cs-accent-lt);
        box-shadow: 0 0 0 3px rgba(13,110,253,.15);
    }
    .logo-item.selected::after {
        content: '✓';
        position: absolute;
        top: -7px; right: -7px;
        background: var(--cs-accent);
        color: white;
        border-radius: 50%;
        width: 16px; height: 16px;
        font-size: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        box-shadow: 0 1px 4px rgba(13,110,253,.4);
    }
    .btn-del-logo {
        position: absolute;
        bottom: -6px; right: -6px;
        background: var(--cs-danger);
        color: white;
        border-radius: 50%;
        width: 16px; height: 16px;
        font-size: 9px;
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity .2s;
        border: none;
        cursor: pointer;
        padding: 0;
        line-height: 1;
        z-index: 10;
    }
    .logo-item:hover .btn-del-logo { opacity: 1; }

    .ql-toolbar.ql-snow {
        border: none !important;
        border-bottom: 1px solid var(--cs-border) !important;
        background: var(--cs-light);
        padding: 10px 32px !important;
    }
    .ql-container.ql-snow {
        border: none !important;
        font-size: 15px;
        font-family: 'DM Sans', sans-serif;
        min-height: 260px;
    }
    #editor-container { padding: 0 32px; }
    .ql-editor { padding: 24px 0 !important; }
    .ql-editor p { color: var(--cs-dark-2); line-height: 1.75; }

    .cs-form-footer {
        padding: 20px 32px;
        background: var(--cs-light);
        border-top: 1px solid var(--cs-border);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
    }
    .cs-file-input {
        font-family: 'DM Sans', sans-serif;
        font-size: 13px;
        color: var(--cs-muted);
        cursor: pointer;
    }
    .cs-file-input::file-selector-button {
        margin-right: 12px;
        padding: 6px 14px;
        border-radius: 6px;
        border: 1px solid var(--cs-border);
        background: var(--cs-white);
        font-size: 12px;
        font-weight: 600;
        font-family: 'DM Sans', sans-serif;
        color: var(--cs-dark-2);
        cursor: pointer;
        transition: all .15s;
    }
    .cs-file-input::file-selector-button:hover {
        background: var(--cs-dark);
        color: white;
        border-color: var(--cs-dark);
    }
    .btn-actions { display: flex; gap: 12px; align-items: center; flex-shrink: 0; }

    .btn-reset {
        font-family: 'DM Sans', sans-serif;
        font-size: 13px;
        font-weight: 600;
        color: var(--cs-muted);
        background: none;
        border: none;
        cursor: pointer;
        padding: 8px 12px;
        border-radius: 6px;
        transition: color .2s, background .2s;
    }
    .btn-reset:hover { color: var(--cs-dark); background: var(--cs-border); }

    .btn-send {
        font-family: 'DM Sans', sans-serif;
        font-size: 14px;
        font-weight: 600;
        background: var(--cs-dark);
        color: white;
        border: none;
        padding: 10px 28px;
        border-radius: 7px;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: background .2s, transform .15s, box-shadow .2s;
        box-shadow: 0 2px 8px rgba(33,37,41,.2);
    }
    .btn-send:hover {
        background: var(--cs-dark-2);
        transform: translateY(-1px);
        box-shadow: 0 4px 16px rgba(33,37,41,.25);
    }
    .btn-send:active { transform: translateY(0); }
    .btn-send .material-symbols-outlined { font-size: 17px; }
    .btn-send.sending { opacity: .65; pointer-events: none; }

    @keyframes spin { to { transform: rotate(360deg); } }

    .btn-plantillas {
        font-family: 'DM Sans', sans-serif;
        font-size: 12px;
        font-weight: 600;
        background: rgba(255,255,255,0.12);
        border: 1px solid rgba(255,255,255,0.25);
        color: white;
        padding: 6px 14px;
        border-radius: 20px;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: 0.2s;
    }
    .btn-plantillas:hover { background: rgba(255,255,255,0.22); }

    .btn-guardar-plantilla {
        font-family: 'DM Sans', sans-serif;
        font-size: 13px;
        font-weight: 600;
        color: var(--cs-accent);
        background: transparent;
        border: 1px solid var(--cs-accent);
        padding: 8px 14px;
        border-radius: 7px;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: 0.2s;
    }
    .btn-guardar-plantilla:hover { background: var(--cs-accent-lt); }

    .cs-toggle-programar {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-family: 'DM Sans', sans-serif;
        font-size: 12px;
        font-weight: 600;
        color: var(--cs-muted);
        cursor: pointer;
    }
    .cs-toggle-programar input[type="checkbox"] {
        width: 16px; height: 16px;
        accent-color: var(--cs-accent);
    }
    .cs-datetime-wrapper {
        display: none;
        margin-top: 12px;
    }
    .cs-datetime-wrapper.activo { display: flex; align-items: center; gap: 10px; }
    .cs-datetime-wrapper input[type="datetime-local"] {
        border: 1px solid var(--cs-border);
        border-radius: 7px;
        padding: 8px 12px;
        font-family: 'DM Sans', sans-serif;
        font-size: 13px;
        color: var(--cs-dark);
    }

    .panel-plantillas {
        position: fixed;
        top: 0; right: 0;
        width: 100%;
        max-width: 440px;
        height: 100vh;
        background: white;
        box-shadow: -10px 0 40px rgba(0,0,0,0.15);
        transform: translateX(110%);
        transition: transform 0.4s cubic-bezier(.25,.8,.25,1);
        z-index: 1060;
        display: flex;
        flex-direction: column;
    }
    .panel-plantillas.abierto { transform: translateX(0); }

    .panel-backdrop {
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.4);
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.3s ease;
        z-index: 1055;
    }
    .panel-backdrop.activo { opacity: 1; pointer-events: auto; }

    .panel-header {
        background: var(--cs-dark);
        color: white;
        padding: 18px 22px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-shrink: 0;
    }
    .panel-header h3 {
        font-family: 'Crimson Pro', serif;
        font-size: 19px;
        font-weight: 600;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .panel-close {
        background: none;
        border: none;
        color: white;
        cursor: pointer;
        padding: 4px 8px;
        border-radius: 50%;
        transition: 0.2s;
        line-height: 1;
    }
    .panel-close:hover { background: rgba(255,255,255,0.15); }

    .panel-body { flex: 1; overflow-y: auto; padding: 20px 22px; }

    .panel-footer {
        padding: 16px 22px;
        border-top: 1px solid var(--cs-border);
        background: var(--cs-light);
        flex-shrink: 0;
    }
    .btn-nueva-plantilla {
        width: 100%;
        background: var(--cs-accent);
        color: white;
        border: none;
        padding: 11px;
        border-radius: 8px;
        font-family: 'DM Sans', sans-serif;
        font-weight: 600;
        font-size: 13px;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: 0.2s;
    }
    .btn-nueva-plantilla:hover { background: var(--cs-accent-h); }

    .panel-buscar { position: relative; margin-bottom: 16px; }
    .panel-buscar input {
        width: 100%;
        border: 1px solid var(--cs-border);
        border-radius: 8px;
        padding: 9px 12px 9px 36px;
        font-family: 'DM Sans', sans-serif;
        font-size: 13px;
    }
    .panel-buscar svg {
        position: absolute;
        left: 10px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--cs-muted);
    }

    .chips-etiquetas {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        margin-bottom: 18px;
    }
    .chip-etiqueta {
        border-radius: 14px;
        padding: 4px 10px;
        font-family: 'DM Sans', sans-serif;
        font-size: 11px;
        font-weight: 600;
        cursor: pointer;
        background: var(--cs-light);
        color: var(--cs-dark);
        border: 1px solid var(--cs-border);
        transition: 0.2s;
    }
    .chip-etiqueta.activo {
        background: var(--cs-dark);
        color: white;
        border-color: var(--cs-dark);
    }

    .plantilla-card {
        background: white;
        border: 1px solid var(--cs-border);
        border-radius: 10px;
        padding: 14px;
        margin-bottom: 10px;
        transition: 0.2s;
        opacity: 0;
        transform: translateY(8px);
        animation: slideInUp 0.3s ease forwards;
    }
    @keyframes slideInUp {
        to { opacity: 1; transform: translateY(0); }
    }
    .plantilla-card:hover { border-color: var(--cs-accent); box-shadow: 0 4px 12px rgba(32,201,151,0.08); }

    .plantilla-card h6 {
        font-family: 'DM Sans', sans-serif;
        font-size: 14px;
        font-weight: 600;
        color: var(--cs-dark);
        margin: 0 0 4px;
    }
    .plantilla-card .asunto-preview {
        font-family: 'DM Sans', sans-serif;
        font-size: 12px;
        color: var(--cs-muted);
        margin: 0 0 8px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .plantilla-card .etiquetas-row {
        display: flex;
        flex-wrap: wrap;
        gap: 4px;
        margin-bottom: 10px;
    }
    .plantilla-card .etiqueta-chip-mini {
        border-radius: 10px;
        padding: 2px 8px;
        font-size: 10px;
        font-weight: 600;
        color: white;
    }
    .plantilla-card .actions { display: flex; gap: 6px; justify-content: flex-end; }
    .plantilla-card .btn-mini {
        border: 1px solid var(--cs-border);
        background: white;
        color: var(--cs-muted);
        padding: 4px 10px;
        border-radius: 6px;
        font-family: 'DM Sans', sans-serif;
        font-size: 11px;
        font-weight: 600;
        cursor: pointer;
        transition: 0.2s;
    }
    .plantilla-card .btn-mini.usar { background: var(--cs-accent); color: white; border-color: var(--cs-accent); }
    .plantilla-card .btn-mini.usar:hover { background: var(--cs-accent-h); }
    .plantilla-card .btn-mini:hover { border-color: var(--cs-dark); color: var(--cs-dark); }
    .plantilla-card .btn-mini.eliminar:hover { border-color: var(--cs-danger); color: var(--cs-danger); }

    .form-nueva-plantilla { display: none; }
    .form-nueva-plantilla.activo { display: block; }
    .form-nueva-plantilla input,
    .form-nueva-plantilla textarea {
        width: 100%;
        border: 1px solid var(--cs-border);
        border-radius: 7px;
        padding: 8px 12px;
        font-family: 'DM Sans', sans-serif;
        font-size: 13px;
        margin-bottom: 10px;
    }
    .form-nueva-plantilla label {
        display: block;
        font-family: 'DM Sans', sans-serif;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--cs-muted);
        margin-bottom: 4px;
    }

    .etiquetas-selector {
        display: flex;
        flex-wrap: wrap;
        gap: 5px;
        margin-bottom: 12px;
    }
    .etiquetas-selector .etiqueta-toggle {
        border: 1px solid var(--cs-border);
        background: white;
        padding: 4px 10px;
        border-radius: 12px;
        cursor: pointer;
        font-size: 11px;
        font-weight: 600;
        color: var(--cs-muted);
        transition: 0.2s;
    }
    .etiquetas-selector .etiqueta-toggle.activo {
        background: var(--cs-accent);
        color: white;
        border-color: var(--cs-accent);
    }
    .etiquetas-selector .btn-nueva-etiqueta {
        border: 1px dashed var(--cs-border);
        background: transparent;
        padding: 4px 10px;
        border-radius: 12px;
        cursor: pointer;
        font-size: 11px;
        font-weight: 600;
        color: var(--cs-muted);
    }
    .etiquetas-selector .btn-nueva-etiqueta:hover { border-color: var(--cs-accent); color: var(--cs-accent); }

    /* ── Campo "Para" con badge contador ── */
    .cs-para-wrap {
        flex: 1;
        display: flex;
        gap: 10px;
        align-items: center;
    }
    .cs-para-input { flex: 1; }
    .cs-para-badge {
        flex-shrink: 0;
        background: var(--cs-dark);
        color: white;
        border: none;
        padding: 9px 14px;
        border-radius: 7px;
        font-family: 'DM Sans', sans-serif;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: 0.2s;
        white-space: nowrap;
    }
    .cs-para-badge:hover { background: var(--cs-dark-2); }
    .cs-para-badge:disabled { opacity: 0.5; cursor: not-allowed; }
    .cs-para-badge.empty { background: #adb5bd; color: white; }

    /* ── Modal flotante destinatarios ── */
    .modal-destinatarios {
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 1070;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.25s;
    }
    .modal-destinatarios.activo { opacity: 1; pointer-events: auto; }

    .md-card {
        width: 100%;
        max-width: 520px;
        max-height: 80vh;
        background: white;
        border-radius: 14px;
        box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        overflow: hidden;
        display: flex;
        flex-direction: column;
        transform: scale(0.95);
        transition: transform 0.25s cubic-bezier(.25,.8,.25,1);
    }
    .modal-destinatarios.activo .md-card { transform: scale(1); }

    .md-header {
        background: var(--cs-dark);
        color: white;
        padding: 16px 22px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .md-header h4 {
        font-family: 'Crimson Pro', serif;
        font-size: 18px;
        font-weight: 600;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .md-close {
        background: none;
        border: none;
        color: white;
        cursor: pointer;
        line-height: 1;
        padding: 4px 8px;
        border-radius: 50%;
        transition: 0.15s;
    }
    .md-close:hover { background: rgba(255,255,255,0.15); }

    .md-search {
        padding: 14px 22px 8px;
        position: relative;
    }
    .md-search input {
        width: 100%;
        border: 1px solid var(--cs-border);
        border-radius: 8px;
        padding: 8px 12px 8px 34px;
        font-family: 'DM Sans', sans-serif;
        font-size: 13px;
        outline: none;
    }
    .md-search input:focus { border-color: var(--cs-accent); }
    .md-search svg {
        position: absolute;
        left: 32px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--cs-muted);
    }

    .md-body {
        flex: 1;
        overflow-y: auto;
        padding: 4px 14px 14px;
    }
    .md-empty {
        text-align: center;
        padding: 40px 20px;
        color: var(--cs-muted);
        font-family: 'DM Sans', sans-serif;
        font-size: 13px;
    }
    .md-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 9px 10px;
        border-radius: 7px;
        margin-bottom: 4px;
        transition: 0.15s;
    }
    .md-item:hover { background: var(--cs-light); }
    .md-item-info {
        flex: 1;
        min-width: 0;
        display: flex;
        flex-direction: column;
        gap: 1px;
    }
    .md-item-email {
        font-family: 'DM Sans', sans-serif;
        font-size: 13px;
        color: var(--cs-dark);
        font-weight: 500;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .md-item-origen {
        font-size: 10px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.4px;
        color: var(--cs-muted);
    }
    .md-item-origen.manual { color: #6c757d; }
    .md-item-origen.crm { color: var(--cs-accent); }
    .md-item-origen.meta { color: #20c997; }
    .md-item-del {
        background: none;
        border: none;
        color: var(--cs-muted);
        cursor: pointer;
        padding: 4px 8px;
        border-radius: 5px;
        line-height: 1;
        transition: 0.15s;
    }
    .md-item-del:hover { background: rgba(220,53,69,0.12); color: var(--cs-danger); }

    .md-pagination {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 4px;
        padding: 8px 14px 4px;
        font-family: 'DM Sans', sans-serif;
        font-size: 12px;
    }
    .md-pagination button {
        background: white;
        border: 1px solid var(--cs-border);
        color: var(--cs-dark);
        padding: 4px 10px;
        border-radius: 5px;
        cursor: pointer;
        font-size: 12px;
        font-weight: 600;
        transition: 0.15s;
    }
    .md-pagination button:hover:not(:disabled) { border-color: var(--cs-dark); }
    .md-pagination button:disabled { opacity: 0.4; cursor: not-allowed; }
    .md-pagination .md-page-info {
        color: var(--cs-muted);
        padding: 0 8px;
    }

    .md-footer {
        padding: 12px 22px;
        background: var(--cs-light);
        border-top: 1px solid var(--cs-border);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        flex-wrap: wrap;
    }
    .md-footer-stats {
        font-family: 'DM Sans', sans-serif;
        font-size: 12px;
        color: var(--cs-muted);
    }
    .md-btn-vaciar {
        background: none;
        border: 1px solid var(--cs-border);
        color: var(--cs-danger);
        padding: 6px 12px;
        border-radius: 6px;
        font-family: 'DM Sans', sans-serif;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: 0.15s;
    }
    .md-btn-vaciar:hover { background: rgba(220,53,69,0.08); border-color: var(--cs-danger); }

    .md-aviso-limite {
        margin: 0 22px 8px;
        padding: 8px 12px;
        background: rgba(255,193,7,0.12);
        border: 1px solid rgba(255,193,7,0.4);
        border-radius: 6px;
        font-family: 'DM Sans', sans-serif;
        font-size: 11px;
        color: #856404;
        display: none;
    }
    .md-aviso-limite.activo { display: block; }

    @media (max-width: 767px) {
        .cs-composer-wrap { padding: 16px 8px; }
        .cs-panel-header { padding: 16px 18px; flex-wrap: wrap; gap: 8px; }
        .cs-panel-header h2 { font-size: 18px; }
        .cs-section { padding: 16px 18px; }
        .cs-field-row { flex-direction: column; align-items: stretch; gap: 6px; }
        .cs-label { width: auto; }
        .ql-toolbar.ql-snow { padding: 8px 18px !important; }
        #editor-container { padding: 0 18px; }
        .cs-form-footer { padding: 16px 18px; flex-direction: column; align-items: stretch; gap: 12px; }
        .btn-actions { width: 100%; justify-content: flex-end; }
        .btn-send { width: 100%; justify-content: center; }
    }
</style>
@endsection

@section('content')
<div id="emailsConfig"
     data-csrf="{{ csrf_token() }}"
     data-url-plantillas="{{ route('admin.marketing.plantillas.index') }}"
     data-url-plantillas-store="{{ route('admin.marketing.plantillas.store') }}"
     data-url-plantillas-imagen="{{ route('admin.marketing.plantillas.imagen') }}"
     data-url-etiquetas="{{ route('admin.marketing.etiquetas.index') }}"
     data-url-etiquetas-store="{{ route('admin.marketing.etiquetas.store') }}"></div>

<div class="cs-composer-wrap">
    <div style="max-width:820px;margin:0 auto;">

        {{-- Título --}}
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;">
            <div>
                <h1 style="font-family:'Crimson Pro',serif;font-size:26px;font-weight:700;color:#212529;margin:0 0 2px;">
                    Email Marketing
                </h1>
                <p style="font-family:'DM Sans',sans-serif;font-size:13px;color:#6c757d;margin:0;">
                    Compositor de correos corporativos
                </p>
            </div>
            <a href="{{ route('admin.marketing.metricas') }}"
               style="font-family:'DM Sans',sans-serif;font-size:12px;font-weight:600;color:#6c757d;text-decoration:none;display:flex;align-items:center;gap:6px;">
                <i class="bi bi-arrow-left"></i> Volver a Métricas
            </a>
        </div>

        <div class="cs-panel">

            <div class="cs-panel-header">
                <h2><i class="bi bi-envelope-paper me-2" style="font-size:18px;opacity:.8;"></i>Nuevo mensaje</h2>
                <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
                    <button type="button" class="btn-plantillas" id="btnAbrirPanel">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg>
                        Plantillas
                    </button>
                    <span class="cs-badge-secure">Envío seguro</span>
                </div>
            </div>

            <form action="{{ route('admin.marketing.emails.send') }}" method="POST" id="emailForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="contenido"  id="contenidoHtml">
                <input type="hidden" name="logo_path"  id="selectedLogoPath">
                <input type="hidden" name="enviar_el"  id="enviarEl">
                <input type="hidden" name="destinatarios" id="destinatariosCsv">

                {{-- Para + Asunto --}}
                <div class="cs-section" style="background:#fafafa;">
                    <div class="cs-field-row" style="margin-bottom:14px;">
                        <span class="cs-label">Para</span>
                        <div class="cs-para-wrap">
                            <input type="email" id="paraInput" class="cs-input cs-para-input"
                                   placeholder="Escribe un correo y presiona Enter o coma">
                            <button type="button" class="cs-para-badge" id="btnAbrirDestinatarios" title="Ver lista de destinatarios">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                                <span id="contadorDestinatarios">0</span> destinatarios
                            </button>
                        </div>
                    </div>
                    <div class="cs-field-row">
                        <span class="cs-label">Asunto</span>
                        <input type="text" name="asunto" class="cs-input cs-input-subject"
                               placeholder="Escribe el asunto del correo…" required>
                    </div>
                </div>

                {{-- Logos --}}
                <div class="cs-section">
                    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:12px;">
                        <p class="cs-section-label" style="margin:0;">Membrete / Logo</p>
                        <span style="font-family:'DM Sans',sans-serif;font-size:10px;color:#adb5bd;">
                            Clic para seleccionar · clic de nuevo para deseleccionar
                        </span>
                    </div>
                    <div class="logos-row">
                        {{-- Botón subir --}}
                        <label class="logo-upload-btn" title="Subir logo">
                            <span class="material-symbols-outlined">add_photo_alternate</span>
                            <input type="file" class="d-none" id="logoInput" accept="image/*">
                        </label>
                        <div class="logo-divider"></div>

                        {{-- Contenedor logos: usa data-path, SIN onclick en HTML --}}
                        <div id="logosContainer" style="display:flex;gap:10px;flex-wrap:wrap;">
                            @forelse($logos ?? [] as $logo)
                                <div class="logo-item" data-path="{{ $logo['path'] }}">
                                    <img src="{{ $logo['url'] }}" alt="logo">
                                    <button type="button" class="btn-del-logo"
                                            data-path="{{ $logo['path'] }}">✕</button>
                                </div>
                            @empty
                                <span id="logoPlaceholder"
                                      style="font-family:'DM Sans',sans-serif;font-size:12px;color:#adb5bd;align-self:center;">
                                    Sin logos guardados — sube uno con el botón +
                                </span>
                            @endforelse
                        </div>
                    </div>
                </div>

                {{-- Editor Quill --}}
                <div>
                    <div id="editor-container" style="background:#fff;">
                        <p>Hola,</p>
                        <p>Adjunto encontrarás la cotización solicitada de <strong>Cisnergia Perú</strong>.</p>
                        <p>Quedamos atentos a cualquier consulta.</p>
                    </div>
                </div>

                <div class="cs-section">
                    <label class="cs-toggle-programar">
                        <input type="checkbox" id="toggleProgramar">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        Programar envío
                    </label>
                    <div class="cs-datetime-wrapper" id="datetimeWrapper">
                        <input type="datetime-local" id="datetimeProgramar" min="{{ now()->format('Y-m-d\TH:i') }}">
                        <small style="font-family:'DM Sans',sans-serif;font-size:11px;color:var(--cs-muted);">El correo se enviará automáticamente en la fecha y hora seleccionada.</small>
                    </div>
                </div>

                <div class="cs-form-footer">
                    <div>
                        <p class="cs-section-label" style="margin:0 0 6px;">Archivos adjuntos</p>
                        <input type="file" name="adjuntos[]" multiple class="cs-file-input">
                    </div>
                    <div class="btn-actions">
                        <button type="button" class="btn-guardar-plantilla" id="btnGuardarPlantilla">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                            Guardar plantilla
                        </button>
                        <button type="button" class="btn-reset" onclick="location.reload()">Limpiar</button>
                        <button type="submit" class="btn-send" id="btnSend">
                            <span id="btnSendLabel">Enviar propuesta</span>
                            <span class="material-symbols-outlined">send</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <p style="font-family:'DM Sans',sans-serif;font-size:11px;color:#adb5bd;text-align:center;margin-top:14px;">
            <i class="bi bi-info-circle me-1"></i>
            Separa múltiples destinatarios con coma. Los detalles de envío quedan registrados en los logs del sistema.
        </p>

    </div>
</div>

<div class="modal-destinatarios" id="modalDestinatarios" aria-hidden="true">
    <div class="md-card">
        <div class="md-header">
            <h4>
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                Lista de destinatarios
            </h4>
            <button type="button" class="md-close" id="btnCerrarDestinatarios" title="Cerrar">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>

        <div class="md-aviso-limite" id="mdAvisoLimite"></div>

        <div class="md-search">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            <input type="text" id="mdBusqueda" placeholder="Buscar correo en la lista…">
        </div>

        <div class="md-body" id="mdBody"></div>

        <div class="md-pagination" id="mdPaginacion"></div>

        <div class="md-footer">
            <span class="md-footer-stats" id="mdStats">0 destinatarios</span>
            <button type="button" class="md-btn-vaciar" id="btnVaciarDestinatarios">Vaciar lista</button>
        </div>
    </div>
</div>

<div class="panel-backdrop" id="panelBackdrop"></div>
<aside class="panel-plantillas" id="panelPlantillas" aria-hidden="true">
    <div class="panel-header">
        <h3>
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg>
            <span id="panelTitulo">Mis Plantillas</span>
        </h3>
        <button class="panel-close" id="btnCerrarPanel" title="Cerrar">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
        </button>
    </div>

    <div class="panel-body">
        <div id="vistaListado">
            <div class="panel-buscar">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                <input type="text" id="inputBusquedaPlantilla" placeholder="Buscar plantilla...">
            </div>

            <div class="chips-etiquetas" id="chipsFiltroEtiquetas">
                <span class="chip-etiqueta activo" data-etiqueta-id="">Todas</span>
            </div>

            <div id="listaPlantillas">
                <p style="text-align:center;color:var(--cs-muted);font-size:13px;padding:30px 0;">Cargando plantillas...</p>
            </div>
        </div>

        <div class="form-nueva-plantilla" id="formNuevaPlantilla">
            <label>Nombre</label>
            <input type="text" id="plantillaNombre" placeholder="Ej: Cotización solar 5kW" maxlength="120">

            <label>Asunto del correo</label>
            <input type="text" id="plantillaAsunto" placeholder="Asunto sugerido (opcional)" maxlength="255">

            <label>Descripción corta</label>
            <input type="text" id="plantillaDescripcion" placeholder="Para qué sirve esta plantilla (opcional)" maxlength="500">

            <label>Etiquetas</label>
            <div class="etiquetas-selector" id="etiquetasSelector">
                <button type="button" class="btn-nueva-etiqueta" id="btnNuevaEtiqueta">+ Nueva etiqueta</button>
            </div>

            <p style="font-family:'DM Sans',sans-serif;font-size:11px;color:var(--cs-muted);margin-top:8px;">
                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-1px;"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                Se guardará el contenido actual del editor (incluidas las imágenes) y el logo seleccionado.
            </p>
        </div>
    </div>

    <div class="panel-footer">
        <button type="button" class="btn-nueva-plantilla" id="btnAccionPanel">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            <span id="btnAccionLabel">Nueva plantilla</span>
        </button>
    </div>
</aside>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script>
    const EMAILS_CFG = document.getElementById('emailsConfig').dataset;
    axios.defaults.headers.common['X-CSRF-TOKEN'] = EMAILS_CFG.csrf;
    axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

    // ── DESTINATARIOS — estado + modal flotante con paginate ─────────────
    const LIMITE_GMAIL_DIARIO = 500;
    const POR_PAGINA = 10;
    let destinatariosList = [];
    let mdPaginaActual = 1;
    let mdBusquedaActual = '';

    const paraInput = document.getElementById('paraInput');
    const contadorEl = document.getElementById('contadorDestinatarios');
    const btnAbrirMd = document.getElementById('btnAbrirDestinatarios');
    const modalMd = document.getElementById('modalDestinatarios');
    const mdBody = document.getElementById('mdBody');
    const mdStats = document.getElementById('mdStats');
    const mdPaginacionEl = document.getElementById('mdPaginacion');
    const mdAvisoLimite = document.getElementById('mdAvisoLimite');
    const mdBusquedaInput = document.getElementById('mdBusqueda');

    function esEmailValido(s) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(s);
    }

    function agregarDestinatario(email, origen = 'manual', meta = {}) {
        email = String(email).trim().toLowerCase();
        if (!email) return false;
        if (!esEmailValido(email)) {
            Swal.fire('Correo inválido', email + ' no es un email válido.', 'warning');
            return false;
        }
        if (destinatariosList.some(d => d.email === email)) return false;
        destinatariosList.push({ email, origen, ...meta });
        actualizarUI();
        return true;
    }

    function eliminarDestinatario(email) {
        destinatariosList = destinatariosList.filter(d => d.email !== email);
        const totalPag = Math.max(1, Math.ceil(destinatariosFiltrados().length / POR_PAGINA));
        if (mdPaginaActual > totalPag) mdPaginaActual = totalPag;
        actualizarUI();
    }

    function vaciarDestinatarios() {
        destinatariosList = [];
        mdPaginaActual = 1;
        actualizarUI();
    }

    function destinatariosFiltrados() {
        const q = mdBusquedaActual.toLowerCase();
        if (!q) return destinatariosList;
        return destinatariosList.filter(d => d.email.includes(q));
    }

    function actualizarUI() {
        const n = destinatariosList.length;
        contadorEl.textContent = n;
        btnAbrirMd.classList.toggle('empty', n === 0);
        mdStats.textContent = n + ' destinatario' + (n === 1 ? '' : 's');

        if (n > LIMITE_GMAIL_DIARIO) {
            mdAvisoLimite.classList.add('activo');
            mdAvisoLimite.innerHTML = '⚠ Tienes <strong>' + n + '</strong> destinatarios. Gmail SMTP solo permite ~' + LIMITE_GMAIL_DIARIO + '/día. Los excedentes serán rechazados.';
        } else {
            mdAvisoLimite.classList.remove('activo');
        }

        renderModalLista();
    }

    function renderModalLista() {
        const lista = destinatariosFiltrados();
        if (lista.length === 0) {
            mdBody.innerHTML = '<div class="md-empty">' +
                (mdBusquedaActual ? 'No hay coincidencias para "' + mdBusquedaActual + '"' : 'Aún no has agregado destinatarios. Escribe un correo en el campo "Para" y presiona Enter.') +
                '</div>';
            mdPaginacionEl.innerHTML = '';
            return;
        }

        const totalPag = Math.ceil(lista.length / POR_PAGINA);
        if (mdPaginaActual > totalPag) mdPaginaActual = totalPag;
        const inicio = (mdPaginaActual - 1) * POR_PAGINA;
        const pagina = lista.slice(inicio, inicio + POR_PAGINA);

        mdBody.innerHTML = pagina.map(d => `
            <div class="md-item">
                <div class="md-item-info">
                    <span class="md-item-email">${escapeHtml(d.email)}</span>
                    <span class="md-item-origen ${d.origen}">${d.origen === 'manual' ? 'Manual' : (d.origen === 'crm' ? 'CRM' : 'Meta')}</span>
                </div>
                <button type="button" class="md-item-del" data-email="${escapeHtml(d.email)}" title="Quitar">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </button>
            </div>
        `).join('');

        if (totalPag > 1) {
            mdPaginacionEl.innerHTML = `
                <button type="button" data-accion="prev" ${mdPaginaActual === 1 ? 'disabled' : ''}>‹ Anterior</button>
                <span class="md-page-info">Página ${mdPaginaActual} de ${totalPag}</span>
                <button type="button" data-accion="next" ${mdPaginaActual === totalPag ? 'disabled' : ''}>Siguiente ›</button>
            `;
        } else {
            mdPaginacionEl.innerHTML = '';
        }
    }

    // Eventos del modal
    btnAbrirMd.addEventListener('click', () => {
        modalMd.classList.add('activo');
        modalMd.setAttribute('aria-hidden', 'false');
        renderModalLista();
    });

    document.getElementById('btnCerrarDestinatarios').addEventListener('click', () => {
        modalMd.classList.remove('activo');
        modalMd.setAttribute('aria-hidden', 'true');
    });

    modalMd.addEventListener('click', (e) => {
        if (e.target === modalMd) {
            modalMd.classList.remove('activo');
            modalMd.setAttribute('aria-hidden', 'true');
        }
    });

    mdBusquedaInput.addEventListener('input', (e) => {
        mdBusquedaActual = e.target.value;
        mdPaginaActual = 1;
        renderModalLista();
    });

    mdBody.addEventListener('click', (e) => {
        const btn = e.target.closest('.md-item-del');
        if (btn) eliminarDestinatario(btn.dataset.email);
    });

    mdPaginacionEl.addEventListener('click', (e) => {
        const btn = e.target.closest('button[data-accion]');
        if (!btn) return;
        const totalPag = Math.ceil(destinatariosFiltrados().length / POR_PAGINA);
        if (btn.dataset.accion === 'prev' && mdPaginaActual > 1) mdPaginaActual--;
        if (btn.dataset.accion === 'next' && mdPaginaActual < totalPag) mdPaginaActual++;
        renderModalLista();
    });

    document.getElementById('btnVaciarDestinatarios').addEventListener('click', async () => {
        if (destinatariosList.length === 0) return;
        const r = await Swal.fire({
            title: '¿Vaciar lista?',
            text: 'Se eliminarán ' + destinatariosList.length + ' destinatarios.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            confirmButtonText: 'Sí, vaciar',
            cancelButtonText: 'Cancelar',
        });
        if (r.isConfirmed) vaciarDestinatarios();
    });

    // Input "Para" — Enter o coma agrega a la lista
    paraInput.addEventListener('keydown', (e) => {
        if (e.key === 'Enter' || e.key === ',') {
            e.preventDefault();
            if (agregarDestinatario(paraInput.value, 'manual')) {
                paraInput.value = '';
            }
        }
    });

    paraInput.addEventListener('blur', () => {
        if (paraInput.value.trim()) {
            if (agregarDestinatario(paraInput.value, 'manual')) {
                paraInput.value = '';
            }
        }
    });

    // Pegar lista de correos separados por coma o salto de línea
    paraInput.addEventListener('paste', (e) => {
        const texto = (e.clipboardData || window.clipboardData).getData('text');
        if (texto.includes(',') || texto.includes('\n') || texto.includes(' ')) {
            e.preventDefault();
            const correos = texto.split(/[\s,;]+/).filter(Boolean);
            let agregados = 0;
            correos.forEach(c => { if (agregarDestinatario(c, 'manual')) agregados++; });
            paraInput.value = '';
            if (agregados > 0) {
                Swal.fire({ icon: 'success', title: agregados + ' agregados', timer: 1200, showConfirmButton: false });
            }
        }
    });

    actualizarUI();

    var quill = new Quill('#editor-container', {
        theme: 'snow',
        placeholder: 'Escribe el cuerpo del correo…',
        modules: {
            toolbar: {
                container: [
                    ['bold', 'italic', 'underline', 'strike'],
                    [{ 'header': [1, 2, 3, false] }],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    ['link', 'image', 'blockquote', 'clean']
                ],
                handlers: { image: imageHandlerQuill }
            }
        }
    });

    function imageHandlerQuill() {
        const input = document.createElement('input');
        input.setAttribute('type', 'file');
        input.setAttribute('accept', 'image/*');
        input.click();
        input.onchange = async () => {
            const file = input.files[0];
            if (!file) return;
            const formData = new FormData();
            formData.append('imagen', file);
            try {
                const { data } = await axios.post(EMAILS_CFG.urlPlantillasImagen, formData);
                if (data.success) {
                    const range = quill.getSelection(true);
                    quill.insertEmbed(range.index, 'image', data.url, 'user');
                    quill.setSelection(range.index + 1);
                }
            } catch (err) {
                Swal.fire('Error', 'No se pudo subir la imagen.', 'error');
            }
        };
    }

    // ── SELECCIÓN DE LOGO ────────────────────────────────────────────────
    // Usamos delegación de eventos desde el contenedor.
    // Esto funciona tanto para logos cargados desde PHP (blade)
    // como para los subidos dinámicamente vía Ajax.
    // NO usamos onclick en el HTML para evitar conflictos con jQuery/Bootstrap.
    document.getElementById('logosContainer').addEventListener('click', function(e) {

        // Si el clic fue en el botón de eliminar, no hacemos nada aquí
        // (lo maneja el listener de abajo)
        if (e.target.closest('.btn-del-logo')) return;

        // Buscar el .logo-item más cercano al elemento clickeado
        const item = e.target.closest('.logo-item');
        if (!item) return;

        const path = item.dataset.path;
        const isSelected = item.classList.contains('selected');

        // Deseleccionar todos primero
        document.querySelectorAll('.logo-item').forEach(el => el.classList.remove('selected'));

        if (!isSelected) {
            // Seleccionar este
            item.classList.add('selected');
            document.getElementById('selectedLogoPath').value = path;
            console.log('[Logo] Seleccionado:', path); // debug — verifica en consola
        } else {
            // Era el mismo, deseleccionar
            document.getElementById('selectedLogoPath').value = '';
            console.log('[Logo] Deseleccionado');
        }
    });

    // ── ELIMINAR LOGO ────────────────────────────────────────────────────
    document.getElementById('logosContainer').addEventListener('click', async function(e) {
        const btn = e.target.closest('.btn-del-logo');
        if (!btn) return;

        // Detener propagación para que el listener de selección no se active
        e.stopPropagation();
        e.preventDefault();

        const path = btn.dataset.path;
        if (!confirm('¿Eliminar este logo?')) return;

        try {
            await axios.delete("{{ route('admin.marketing.emails.logo.delete') }}", {
                data: { path: path }
            });
            btn.closest('.logo-item').remove();

            // Si era el logo seleccionado, limpiar el hidden
            if (document.getElementById('selectedLogoPath').value === path) {
                document.getElementById('selectedLogoPath').value = '';
            }

            // Mostrar placeholder si no quedan logos
            if (document.querySelectorAll('.logo-item').length === 0) {
                document.getElementById('logosContainer').innerHTML =
                    '<span id="logoPlaceholder" style="font-family:\'DM Sans\',sans-serif;font-size:12px;color:#adb5bd;align-self:center;">Sin logos guardados — sube uno con el botón +</span>';
            }
        } catch (err) {
            console.error('[Logo] Error al eliminar:', err);
            alert('Error al eliminar el logo.');
        }
    });

    // ── SUBIR LOGO VÍA AJAX ──────────────────────────────────────────────
    document.getElementById('logoInput').addEventListener('change', async function() {
        if (!this.files.length) return;

        const formData = new FormData();
        formData.append('logo', this.files[0]);

        try {
            const res = await axios.post("{{ route('admin.marketing.emails.logo.upload') }}", formData);
            console.log('[Logo] Respuesta del servidor:', res.data); // debug

            if (res.data.success) {
                // Quitar placeholder si existe
                const placeholder = document.getElementById('logoPlaceholder');
                if (placeholder) placeholder.remove();

                // Crear el elemento con data-path (NO onclick)
                const div = document.createElement('div');
                div.className = 'logo-item';
                div.dataset.path = res.data.path; // <-- aquí se guarda el path
                div.innerHTML = `
                    <img src="${res.data.url}" alt="logo">
                    <button type="button" class="btn-del-logo" data-path="${res.data.path}">✕</button>
                `;
                document.getElementById('logosContainer').prepend(div);

                console.log('[Logo] Añadido con path:', res.data.path); // debug
            }
        } catch (err) {
            console.error('[Logo] Error al subir:', err);
            alert('No se pudo subir la imagen. Verifica el formato y tamaño (máx. 5 MB).');
        }

        this.value = ''; // limpiar input para permitir subir el mismo archivo de nuevo
    });

    // ── TOGGLE PROGRAMAR ENVÍO ───────────────────────────────────────────
    const toggleProgramar = document.getElementById('toggleProgramar');
    const datetimeWrapper = document.getElementById('datetimeWrapper');
    const datetimeProgramar = document.getElementById('datetimeProgramar');
    const btnSendLabel = document.getElementById('btnSendLabel');

    toggleProgramar.addEventListener('change', () => {
        datetimeWrapper.classList.toggle('activo', toggleProgramar.checked);
        btnSendLabel.textContent = toggleProgramar.checked ? 'Programar envío' : 'Enviar propuesta';
    });

    document.getElementById('btnSend').addEventListener('click', async function(e) {
        e.preventDefault();
        const form = document.getElementById('emailForm');

        if (paraInput.value.trim()) {
            if (agregarDestinatario(paraInput.value, 'manual')) paraInput.value = '';
        }

        if (destinatariosList.length === 0) {
            Swal.fire('Atención', 'Agrega al menos un destinatario.', 'warning');
            return;
        }

        if (!document.querySelector('input[name="asunto"]').value.trim()) {
            Swal.fire('Atención', 'El asunto es obligatorio.', 'warning');
            return;
        }

        const total = destinatariosList.length;
        if (total > LIMITE_GMAIL_DIARIO) {
            const r = await Swal.fire({
                title: 'Excede el límite diario de Gmail',
                html: 'Tienes <strong>' + total + '</strong> destinatarios, pero Gmail SMTP solo permite ~' + LIMITE_GMAIL_DIARIO + ' al día.<br><br>Los excedentes serán rechazados automáticamente. ¿Continuar de todos modos?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, continuar',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: '#198754',
            });
            if (!r.isConfirmed) return;
        }

        const contenido = quill.root.innerHTML.trim();
        if (contenido === '<p><br></p>' || contenido === '') {
            Swal.fire('Atención', 'El cuerpo del correo no puede estar vacío.', 'warning');
            return;
        }

        if (toggleProgramar.checked) {
            if (!datetimeProgramar.value) {
                Swal.fire('Atención', 'Selecciona la fecha y hora del envío programado.', 'warning');
                return;
            }
            if (new Date(datetimeProgramar.value) <= new Date()) {
                Swal.fire('Atención', 'La fecha debe ser futura.', 'warning');
                return;
            }
            document.getElementById('enviarEl').value = datetimeProgramar.value;
        } else {
            document.getElementById('enviarEl').value = '';
        }

        document.getElementById('contenidoHtml').value = contenido;
        document.getElementById('destinatariosCsv').value = destinatariosList.map(d => d.email).join(',');

        this.classList.add('sending');
        this.innerHTML = '<span class="material-symbols-outlined" style="animation:spin 1s linear infinite;font-size:17px;">progress_activity</span> ' + (toggleProgramar.checked ? 'Programando…' : 'Enviando…');
        form.submit();
    });

    // ── PANEL PLANTILLAS ─────────────────────────────────────────────────
    const panel = document.getElementById('panelPlantillas');
    const panelBackdrop = document.getElementById('panelBackdrop');
    const vistaListado = document.getElementById('vistaListado');
    const formNueva = document.getElementById('formNuevaPlantilla');
    const panelTitulo = document.getElementById('panelTitulo');
    const btnAccionPanel = document.getElementById('btnAccionPanel');
    const btnAccionLabel = document.getElementById('btnAccionLabel');

    let modoPanel = 'listado';
    let plantillaEditandoId = null;
    let etiquetasGlobales = [];
    let etiquetasSeleccionadas = new Set();
    let filtroEtiquetaActual = '';
    let plantillasCache = [];

    function debounceLocal(fn, ms) {
        let t;
        return (...args) => { clearTimeout(t); t = setTimeout(() => fn(...args), ms); };
    }

    function abrirPanel() {
        panel.classList.add('abierto');
        panelBackdrop.classList.add('activo');
        panel.setAttribute('aria-hidden', 'false');
        cambiarModo('listado');
        cargarEtiquetas();
        cargarPlantillas();
    }

    function cerrarPanel() {
        panel.classList.remove('abierto');
        panelBackdrop.classList.remove('activo');
        panel.setAttribute('aria-hidden', 'true');
    }

    function cambiarModo(modo) {
        modoPanel = modo;
        if (modo === 'listado') {
            vistaListado.style.display = 'block';
            formNueva.classList.remove('activo');
            panelTitulo.textContent = 'Mis Plantillas';
            btnAccionLabel.textContent = 'Nueva plantilla';
            plantillaEditandoId = null;
            limpiarFormPlantilla();
        } else {
            vistaListado.style.display = 'none';
            formNueva.classList.add('activo');
            panelTitulo.textContent = plantillaEditandoId ? 'Editar plantilla' : 'Nueva plantilla';
            btnAccionLabel.textContent = plantillaEditandoId ? 'Actualizar' : 'Guardar plantilla';
        }
    }

    function limpiarFormPlantilla() {
        document.getElementById('plantillaNombre').value = '';
        document.getElementById('plantillaAsunto').value = '';
        document.getElementById('plantillaDescripcion').value = '';
        etiquetasSeleccionadas.clear();
        renderEtiquetasSelector();
    }

    document.getElementById('btnAbrirPanel').addEventListener('click', abrirPanel);
    document.getElementById('btnCerrarPanel').addEventListener('click', cerrarPanel);
    panelBackdrop.addEventListener('click', cerrarPanel);

    btnAccionPanel.addEventListener('click', async () => {
        if (modoPanel === 'listado') {
            const asunto = document.querySelector('input[name="asunto"]').value || '';
            document.getElementById('plantillaAsunto').value = asunto;
            cambiarModo('formulario');
        } else {
            await guardarPlantilla();
        }
    });

    document.getElementById('btnGuardarPlantilla').addEventListener('click', () => {
        const contenido = quill.root.innerHTML.trim();
        if (contenido === '<p><br></p>' || contenido === '') {
            Swal.fire('Atención', 'No puedes guardar una plantilla vacía.', 'warning');
            return;
        }
        abrirPanel();
        setTimeout(() => {
            const asunto = document.querySelector('input[name="asunto"]').value || '';
            document.getElementById('plantillaAsunto').value = asunto;
            cambiarModo('formulario');
        }, 100);
    });

    async function cargarEtiquetas() {
        try {
            const { data } = await axios.get(EMAILS_CFG.urlEtiquetas);
            if (data.success) {
                etiquetasGlobales = data.etiquetas;
                renderChipsFiltroEtiquetas();
                renderEtiquetasSelector();
            }
        } catch (err) {
            console.error('Error cargando etiquetas:', err);
        }
    }

    function renderChipsFiltroEtiquetas() {
        const cont = document.getElementById('chipsFiltroEtiquetas');
        cont.innerHTML = '<span class="chip-etiqueta ' + (filtroEtiquetaActual === '' ? 'activo' : '') + '" data-etiqueta-id="">Todas</span>';
        etiquetasGlobales.forEach(e => {
            const chip = document.createElement('span');
            chip.className = 'chip-etiqueta' + (String(filtroEtiquetaActual) === String(e.id) ? ' activo' : '');
            chip.dataset.etiquetaId = e.id;
            chip.textContent = e.nombre;
            chip.style.borderColor = e.color;
            cont.appendChild(chip);
        });
    }

    function renderEtiquetasSelector() {
        const cont = document.getElementById('etiquetasSelector');
        cont.querySelectorAll('.etiqueta-toggle').forEach(el => el.remove());
        etiquetasGlobales.forEach(e => {
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'etiqueta-toggle' + (etiquetasSeleccionadas.has(e.id) ? ' activo' : '');
            btn.dataset.etiquetaId = e.id;
            btn.textContent = e.nombre;
            cont.insertBefore(btn, document.getElementById('btnNuevaEtiqueta'));
        });
    }

    document.getElementById('chipsFiltroEtiquetas').addEventListener('click', (e) => {
        const chip = e.target.closest('.chip-etiqueta');
        if (!chip) return;
        filtroEtiquetaActual = chip.dataset.etiquetaId;
        renderChipsFiltroEtiquetas();
        cargarPlantillas();
    });

    document.getElementById('etiquetasSelector').addEventListener('click', async (e) => {
        const toggle = e.target.closest('.etiqueta-toggle');
        const nueva = e.target.closest('#btnNuevaEtiqueta');
        if (toggle) {
            const id = parseInt(toggle.dataset.etiquetaId);
            if (etiquetasSeleccionadas.has(id)) etiquetasSeleccionadas.delete(id);
            else etiquetasSeleccionadas.add(id);
            renderEtiquetasSelector();
        } else if (nueva) {
            const { value: nombre } = await Swal.fire({
                title: 'Nueva etiqueta',
                input: 'text',
                inputLabel: 'Nombre de la etiqueta',
                inputPlaceholder: 'Ej: Cotizaciones',
                showCancelButton: true,
                confirmButtonColor: '#20c997',
                inputValidator: (v) => !v && 'Escribe un nombre',
            });
            if (!nombre) return;
            try {
                const { data } = await axios.post(EMAILS_CFG.urlEtiquetasStore, { nombre });
                if (data.success) {
                    etiquetasGlobales.push(data.etiqueta);
                    etiquetasSeleccionadas.add(data.etiqueta.id);
                    renderEtiquetasSelector();
                    renderChipsFiltroEtiquetas();
                }
            } catch (err) {
                Swal.fire('Error', err.response?.data?.message || 'No se pudo crear.', 'error');
            }
        }
    });

    const buscarDebounced = debounceLocal(cargarPlantillas, 300);
    document.getElementById('inputBusquedaPlantilla').addEventListener('input', buscarDebounced);

    async function cargarPlantillas() {
        const busqueda = document.getElementById('inputBusquedaPlantilla').value;
        try {
            const { data } = await axios.get(EMAILS_CFG.urlPlantillas, {
                params: { busqueda, etiqueta_id: filtroEtiquetaActual || null }
            });
            if (data.success) {
                plantillasCache = data.plantillas;
                renderPlantillas(data.plantillas);
            }
        } catch (err) {
            console.error('Error cargando plantillas:', err);
        }
    }

    function renderPlantillas(plantillas) {
        const cont = document.getElementById('listaPlantillas');
        if (!plantillas.length) {
            cont.innerHTML = `
                <div style="text-align:center;padding:40px 0;color:var(--cs-muted);">
                    <svg width="42" height="42" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="opacity:0.3;"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg>
                    <p style="margin:12px 0 0;font-size:13px;">No hay plantillas todavía</p>
                </div>`;
            return;
        }
        cont.innerHTML = plantillas.map((p, i) => `
            <div class="plantilla-card" style="animation-delay:${i * 0.04}s;">
                <h6>${escapeHtml(p.nombre)}</h6>
                <p class="asunto-preview">${escapeHtml(p.asunto || 'Sin asunto')}</p>
                ${p.etiquetas.length ? `
                    <div class="etiquetas-row">
                        ${p.etiquetas.map(e => `<span class="etiqueta-chip-mini" style="background:${e.color};">${escapeHtml(e.nombre)}</span>`).join('')}
                    </div>
                ` : ''}
                <div class="actions">
                    <button type="button" class="btn-mini eliminar" data-action="eliminar" data-id="${p.id}">Eliminar</button>
                    <button type="button" class="btn-mini" data-action="editar" data-id="${p.id}">Editar</button>
                    <button type="button" class="btn-mini usar" data-action="usar" data-id="${p.id}">Usar</button>
                </div>
            </div>
        `).join('');
    }

    function escapeHtml(s) {
        return String(s ?? '')
            .replace(/&/g, '&amp;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;');
    }

    document.getElementById('listaPlantillas').addEventListener('click', async (e) => {
        const btn = e.target.closest('.btn-mini');
        if (!btn) return;
        const id = parseInt(btn.dataset.id);
        const plantilla = plantillasCache.find(p => p.id === id);
        if (!plantilla) return;

        if (btn.dataset.action === 'usar') {
            document.querySelector('input[name="asunto"]').value = plantilla.asunto || '';
            quill.root.innerHTML = plantilla.contenido_html;
            if (plantilla.logo_path) {
                document.querySelectorAll('.logo-item').forEach(el => {
                    el.classList.toggle('selected', el.dataset.path === plantilla.logo_path);
                });
                document.getElementById('selectedLogoPath').value = plantilla.logo_path;
            }
            cerrarPanel();
            Swal.fire({ icon: 'success', title: 'Plantilla cargada', timer: 1500, showConfirmButton: false });
        } else if (btn.dataset.action === 'editar') {
            plantillaEditandoId = plantilla.id;
            document.getElementById('plantillaNombre').value = plantilla.nombre;
            document.getElementById('plantillaAsunto').value = plantilla.asunto || '';
            document.getElementById('plantillaDescripcion').value = plantilla.descripcion || '';
            etiquetasSeleccionadas = new Set(plantilla.etiquetas.map(e => e.id));
            renderEtiquetasSelector();
            cambiarModo('formulario');
        } else if (btn.dataset.action === 'eliminar') {
            const r = await Swal.fire({
                title: '¿Eliminar plantilla?',
                text: plantilla.nombre,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
            });
            if (!r.isConfirmed) return;
            try {
                await axios.delete(EMAILS_CFG.urlPlantillas + '/' + id);
                cargarPlantillas();
            } catch (err) {
                Swal.fire('Error', 'No se pudo eliminar.', 'error');
            }
        }
    });

    async function guardarPlantilla() {
        const nombre = document.getElementById('plantillaNombre').value.trim();
        const asunto = document.getElementById('plantillaAsunto').value.trim();
        const descripcion = document.getElementById('plantillaDescripcion').value.trim();

        if (!nombre) {
            Swal.fire('Atención', 'El nombre es obligatorio.', 'warning');
            return;
        }

        const contenido = quill.root.innerHTML.trim();
        if (contenido === '<p><br></p>' || contenido === '') {
            Swal.fire('Atención', 'El contenido del editor está vacío.', 'warning');
            return;
        }

        const payload = {
            nombre,
            asunto: asunto || null,
            descripcion: descripcion || null,
            contenido_html: contenido,
            logo_path: document.getElementById('selectedLogoPath').value || null,
            es_global: true,
            etiquetas: Array.from(etiquetasSeleccionadas),
        };

        try {
            if (plantillaEditandoId) {
                await axios.put(EMAILS_CFG.urlPlantillas + '/' + plantillaEditandoId, payload);
            } else {
                await axios.post(EMAILS_CFG.urlPlantillasStore, payload);
            }
            Swal.fire({ icon: 'success', title: 'Plantilla guardada', timer: 1500, showConfirmButton: false });
            cambiarModo('listado');
            cargarPlantillas();
        } catch (err) {
            const msg = err.response?.data?.message || 'No se pudo guardar la plantilla.';
            Swal.fire('Error', msg, 'error');
        }
    }
</script>
@endsection