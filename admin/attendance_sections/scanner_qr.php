<?php
// Datos de configuración del escáner
$planteles = [
    'el_zapote' => 'El Zapote',
    'insurgentes' => 'Insurgentes',
    'lindavista' => 'Lindavista'
];

// Obtener plantel seleccionado
$plantel_actual = $_GET['plantel'] ?? 'el_zapote';
?>

<!-- ===================== ESCÁNER QR ===================== -->
<div class="scanner-qr">
    <!-- Header del Escáner -->
    <div class="scanner-header">
        <div class="header-info">
            <h2 style="color: var(--primary-color); margin-bottom: 0.5rem;">
                <i class="fas fa-qrcode"></i> Escáner QR - Control de Asistencias
            </h2>
            <p style="color: var(--gray-600);">
                Escanea las credenciales para registrar entradas y salidas
            </p>
        </div>
        
        <div class="header-controls">
            <div class="plantel-selector">
                <label for="plantel-select">Plantel:</label>
                <select id="plantel-select" onchange="cambiarPlantel(this.value)">
                    <?php foreach ($planteles as $key => $nombre): ?>
                    <option value="<?= $key ?>" <?= $plantel_actual === $key ? 'selected' : '' ?>>
                        <?= $nombre ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="fecha-hora-actual">
                <div class="fecha-display" id="fecha-actual"></div>
                <div class="hora-display" id="hora-actual"></div>
            </div>
        </div>
    </div>

    <!-- Panel Principal del Escáner -->
    <div class="scanner-container">
        <!-- Panel de Cámara/Escáner -->
        <div class="scanner-panel">
            <div class="scanner-title">
                <h3><i class="fas fa-camera"></i> Escáner de Credenciales</h3>
                <div class="scanner-status" id="scanner-status">
                    <span class="status-dot inactive"></span>
                    <span>Cámara Inactiva</span>
                </div>
            </div>
            
            <!-- Área de la Cámara -->
            <div class="camera-container">
                <div id="qr-reader" class="qr-reader-container"></div>
                <div id="qr-reader-placeholder" class="qr-reader-placeholder">
                    <div class="placeholder-content">
                        <i class="fas fa-camera fa-3x"></i>
                        <h4>Activar Cámara</h4>
                        <p>Haz clic en "Iniciar Escáner" para comenzar</p>
                    </div>
                </div>
            </div>
            
            <!-- Controles del Escáner -->
            <div class="scanner-controls">
                <button id="start-scanner" class="btn btn-primary" onclick="iniciarEscaner()">
                    <i class="fas fa-play"></i> Iniciar Escáner
                </button>
                <button id="stop-scanner" class="btn btn-danger" onclick="detenerEscaner()" style="display: none;">
                    <i class="fas fa-stop"></i> Detener Escáner
                </button>
                <button class="btn btn-outline-primary" onclick="escaneoManual()">
                    <i class="fas fa-keyboard"></i> Entrada Manual
                </button>
                <button class="btn btn-secondary" onclick="cambiarCamara()">
                    <i class="fas fa-sync-alt"></i> Cambiar Cámara
                </button>
            </div>

            <!-- Entrada Manual -->
            <div id="entrada-manual" class="entrada-manual" style="display: none;">
                <h4>Entrada Manual de Credencial</h4>
                <div class="manual-form">
                    <input type="text" id="codigo-manual" placeholder="Ingresa el código de la credencial..." maxlength="20">
                    <button class="btn btn-primary" onclick="procesarCodigoManual()">
                        <i class="fas fa-check"></i> Procesar
                    </button>
                    <button class="btn btn-secondary" onclick="cancelarManual()">
                        <i class="fas fa-times"></i> Cancelar
                    </button>
                </div>
            </div>
        </div>

        <!-- Panel de Información -->
        <div class="info-panel">
            <h3><i class="fas fa-info-circle"></i> Información del Escaneo</h3>
            
            <!-- Estado Actual -->
            <div class="scan-info" id="scan-info">
                <div class="info-placeholder">
                    <i class="fas fa-qrcode fa-2x"></i>
                    <p>Esperando escaneo de credencial...</p>
                </div>
            </div>

            <!-- Últimos Escaneos -->
            <div class="recent-scans">
                <h4><i class="fas fa-history"></i> Últimos Registros</h4>
                <div class="recent-scans-list" id="recent-scans-list">
                    <!-- Los registros se cargarán dinámicamente -->
                </div>
            </div>
        </div>
    </div>

    <!-- Panel de Estadísticas Rápidas -->
    <div class="stats-panel">
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-sign-in-alt"></i>
            </div>
            <div class="stat-info">
                <div class="stat-number" id="entradas-hoy">0</div>
                <div class="stat-label">Entradas Hoy</div>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-sign-out-alt"></i>
            </div>
            <div class="stat-info">
                <div class="stat-number" id="salidas-hoy">0</div>
                <div class="stat-label">Salidas Hoy</div>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-info">
                <div class="stat-number" id="horas-extras-hoy">0</div>
                <div class="stat-label">Horas Extras</div>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-info">
                <div class="stat-number" id="presentes-ahora">0</div>
                <div class="stat-label">Presentes Ahora</div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Confirmación de Registro -->
<div id="modal-confirmacion" class="modal" style="display: none;">
    <div class="modal-content">
        <div class="modal-header">
            <h3 id="modal-titulo">Confirmar Registro</h3>
            <span class="modal-close" onclick="cerrarModal()">&times;</span>
        </div>
        <div class="modal-body" id="modal-body">
            <!-- Contenido dinámico -->
        </div>
        <div class="modal-footer">
            <button class="btn btn-secondary" onclick="cerrarModal()">Cancelar</button>
            <button class="btn btn-primary" onclick="confirmarRegistro()">Confirmar</button>
        </div>
    </div>
</div>

<!-- ===================== ESTILOS ESPECÍFICOS ===================== -->
<style>
    .scanner-qr {
        display: flex;
        flex-direction: column;
        gap: 2rem;
        padding: 0;
    }

    .scanner-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        background: var(--primary-light);
        padding: 1.5rem;
        border-radius: var(--border-radius);
        border: 2px solid var(--primary-color);
    }

    .header-controls {
        display: flex;
        align-items: center;
        gap: 2rem;
    }

    .plantel-selector {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .plantel-selector label {
        font-weight: 600;
        color: var(--gray-700);
        font-size: 0.9rem;
    }

    .plantel-selector select {
        padding: 0.5rem;
        border: 2px solid var(--gray-300);
        border-radius: var(--border-radius);
        font-size: 1rem;
        background: var(--white);
    }

    .fecha-hora-actual {
        text-align: right;
    }

    .fecha-display {
        font-weight: 600;
        color: var(--primary-color);
        font-size: 1.1rem;
    }

    .hora-display {
        font-size: 2rem;
        font-weight: 700;
        color: var(--gray-800);
        font-family: 'Courier New', monospace;
    }

    .scanner-container {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 2rem;
    }

    .scanner-panel {
        background: var(--white);
        padding: 2rem;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        border: 2px solid var(--primary-color);
    }

    .scanner-title {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid var(--primary-light);
    }

    .scanner-title h3 {
        color: var(--primary-color);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .scanner-status {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.9rem;
        font-weight: 500;
    }

    .status-dot {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        animation: pulse 2s infinite;
    }

    .status-dot.active {
        background: var(--success-color);
    }

    .status-dot.inactive {
        background: var(--gray-400);
        animation: none;
    }

    @keyframes pulse {
        0% { opacity: 1; }
        50% { opacity: 0.5; }
        100% { opacity: 1; }
    }

    .camera-container {
        position: relative;
        margin-bottom: 2rem;
        border-radius: var(--border-radius);
        overflow: hidden;
        border: 3px solid var(--primary-color);
        background: var(--gray-900);
        min-height: 300px;
    }

    .qr-reader-container {
        width: 100%;
        height: 300px;
    }

    .qr-reader-placeholder {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--gray-100);
        color: var(--gray-600);
    }

    .placeholder-content {
        text-align: center;
    }

    .placeholder-content i {
        color: var(--primary-color);
        margin-bottom: 1rem;
    }

    .placeholder-content h4 {
        margin-bottom: 0.5rem;
        color: var(--gray-700);
    }

    .scanner-controls {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
        justify-content: center;
    }

    .entrada-manual {
        margin-top: 2rem;
        padding: 1.5rem;
        background: var(--gray-50);
        border-radius: var(--border-radius);
        border: 2px dashed var(--primary-color);
    }

    .entrada-manual h4 {
        color: var(--primary-color);
        margin-bottom: 1rem;
        text-align: center;
    }

    .manual-form {
        display: flex;
        gap: 1rem;
        align-items: center;
    }

    .manual-form input {
        flex: 1;
        padding: 0.75rem;
        border: 2px solid var(--gray-300);
        border-radius: var(--border-radius);
        font-size: 1rem;
    }

    .manual-form input:focus {
        outline: none;
        border-color: var(--primary-color);
    }

    .info-panel {
        background: var(--white);
        padding: 2rem;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        border: 2px solid var(--secondary-color);
    }

    .info-panel h3 {
        color: var(--primary-color);
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid var(--primary-light);
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .scan-info {
        margin-bottom: 2rem;
        padding: 1.5rem;
        background: var(--gray-50);
        border-radius: var(--border-radius);
        border: 2px solid var(--gray-300);
        min-height: 200px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .info-placeholder {
        text-align: center;
        color: var(--gray-600);
    }

    .info-placeholder i {
        color: var(--primary-color);
        margin-bottom: 1rem;
    }

    .scan-result {
        text-align: center;
    }

    .persona-foto {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: var(--primary-light);
        color: var(--primary-color);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        margin: 0 auto 1rem auto;
        border: 3px solid var(--primary-color);
    }

    .persona-info h4 {
        color: var(--gray-800);
        margin-bottom: 0.5rem;
    }

    .persona-meta {
        color: var(--gray-600);
        font-size: 0.9rem;
        margin-bottom: 1rem;
    }

    .accion-badge {
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.9rem;
    }

    .accion-entrada {
        background: var(--success-light);
        color: var(--success-color);
    }

    .accion-salida {
        background: var(--warning-light);
        color: var(--warning-color);
    }

    .recent-scans {
        border-top: 2px solid var(--gray-200);
        padding-top: 1.5rem;
    }

    .recent-scans h4 {
        color: var(--gray-700);
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .recent-scans-list {
        display: flex;
        flex-direction: column;
        gap: 1rem;
        max-height: 300px;
        overflow-y: auto;
    }

    .recent-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem;
        background: var(--gray-50);
        border-radius: var(--border-radius);
        border-left: 4px solid var(--primary-color);
    }

    .recent-item-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: var(--primary-light);
        color: var(--primary-color);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .recent-item-info {
        flex: 1;
    }

    .recent-item-name {
        font-weight: 600;
        color: var(--gray-800);
        margin-bottom: 0.25rem;
    }

    .recent-item-meta {
        font-size: 0.8rem;
        color: var(--gray-600);
    }

    .recent-item-time {
        font-weight: 500;
        color: var(--primary-color);
        font-size: 0.9rem;
    }

    .stats-panel {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
    }

    .stat-card {
        background: var(--white);
        padding: 2rem;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        border: 2px solid var(--primary-color);
        display: flex;
        align-items: center;
        gap: 1.5rem;
        transition: var(--transition);
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-hover);
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        background: var(--primary-color);
        color: var(--white);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }

    .stat-number {
        font-size: 2rem;
        font-weight: 700;
        color: var(--primary-color);
        line-height: 1;
    }

    .stat-label {
        color: var(--gray-600);
        font-size: 0.9rem;
        font-weight: 500;
    }

    /* Modal Styles */
    .modal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 1000;
    }

    .modal-content {
        background: var(--white);
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-hover);
        max-width: 500px;
        width: 90%;
        max-height: 80vh;
        overflow-y: auto;
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1.5rem;
        border-bottom: 2px solid var(--gray-200);
    }

    .modal-header h3 {
        margin: 0;
        color: var(--primary-color);
    }

    .modal-close {
        font-size: 1.5rem;
        color: var(--gray-600);
        cursor: pointer;
        padding: 0.5rem;
        border-radius: 50%;
        transition: var(--transition);
    }

    .modal-close:hover {
        background: var(--gray-100);
        color: var(--gray-800);
    }

    .modal-body {
        padding: 2rem;
    }

    .modal-footer {
        display: flex;
        justify-content: flex-end;
        gap: 1rem;
        padding: 1.5rem;
        border-top: 2px solid var(--gray-200);
    }

    @media (max-width: 768px) {
        .scanner-header {
            flex-direction: column;
            gap: 1rem;
        }

        .header-controls {
            width: 100%;
            justify-content: space-between;
        }

        .scanner-container {
            grid-template-columns: 1fr;
        }

        .stats-panel {
            grid-template-columns: repeat(2, 1fr);
        }

        .scanner-controls {
            flex-direction: column;
        }

        .manual-form {
            flex-direction: column;
        }
    }
</style>

<!-- ===================== SCRIPTS ESPECÍFICOS ===================== -->
<script>
    let html5QrCode;
    let scannerActivo = false;
    let ultimoEscaneo = null;
    let camaraActual = 0;

    // Actualizar fecha y hora
    function actualizarFechaHora() {
        const ahora = new Date();
        document.getElementById('fecha-actual').textContent = ahora.toLocaleDateString('es-MX', {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });
        document.getElementById('hora-actual').textContent = ahora.toLocaleTimeString('es-MX');
    }

    // Inicializar
    document.addEventListener('DOMContentLoaded', function() {
        actualizarFechaHora();
        setInterval(actualizarFechaHora, 1000);
        cargarEstadisticas();
        cargarUltimosRegistros();
    });

    // Iniciar escáner QR
    function iniciarEscaner() {
        const qrReader = document.getElementById('qr-reader');
        const placeholder = document.getElementById('qr-reader-placeholder');
        const startBtn = document.getElementById('start-scanner');
        const stopBtn = document.getElementById('stop-scanner');
        const status = document.getElementById('scanner-status');

        html5QrCode = new Html5Qrcode("qr-reader");
        
        Html5Qrcode.getCameras().then(devices => {
            if (devices && devices.length) {
                const cameraId = devices[camaraActual]?.id || devices[0].id;
                
                html5QrCode.start(
                    cameraId,
                    {
                        fps: 10,
                        qrbox: { width: 250, height: 250 }
                    },
                    onScanSuccess,
                    onScanFailure
                ).then(() => {
                    scannerActivo = true;
                    placeholder.style.display = 'none';
                    startBtn.style.display = 'none';
                    stopBtn.style.display = 'inline-flex';
                    
                    status.innerHTML = '<span class="status-dot active"></span><span>Cámara Activa</span>';
                    showNotification('Escáner QR activado correctamente', 'success');
                }).catch(err => {
                    console.error('Error al iniciar cámara:', err);
                    showNotification('Error al acceder a la cámara', 'error');
                });
            } else {
                showNotification('No se encontraron cámaras disponibles', 'error');
            }
        }).catch(err => {
            console.error('Error al obtener cámaras:', err);
            showNotification('Error al detectar cámaras', 'error');
        });
    }

    // Detener escáner
    function detenerEscaner() {
        if (html5QrCode && scannerActivo) {
            html5QrCode.stop().then(() => {
                scannerActivo = false;
                document.getElementById('qr-reader-placeholder').style.display = 'flex';
                document.getElementById('start-scanner').style.display = 'inline-flex';
                document.getElementById('stop-scanner').style.display = 'none';
                document.getElementById('scanner-status').innerHTML = '<span class="status-dot inactive"></span><span>Cámara Inactiva</span>';
                showNotification('Escáner QR desactivado', 'info');
            }).catch(err => {
                console.error('Error al detener cámara:', err);
            });
        }
    }

    // Éxito en escaneo
    function onScanSuccess(decodedText, decodedResult) {
        if (ultimoEscaneo === decodedText) return; // Evitar duplicados
        ultimoEscaneo = decodedText;
        
        console.log('Código escaneado:', decodedText);
        procesarCredencial(decodedText);
        
        // Resetear después de 2 segundos para permitir nuevo escaneo
        setTimeout(() => {
            ultimoEscaneo = null;
        }, 2000);
    }

    // Error en escaneo (no mostrar errores constantes)
    function onScanFailure(error) {
        // No mostrar errores de escaneo constantes
    }

    // Procesar credencial escaneada
    function procesarCredencial(codigo) {
        showNotification('Procesando credencial...', 'info');
        
        // Simular búsqueda en base de datos
        setTimeout(() => {
            const persona = buscarPersonaPorCodigo(codigo);
            if (persona) {
                mostrarInfoPersona(persona);
                mostrarModalConfirmacion(persona);
            } else {
                showNotification('Credencial no reconocida: ' + codigo, 'error');
                document.getElementById('scan-info').innerHTML = `
                    <div class="info-placeholder">
                        <i class="fas fa-exclamation-triangle fa-2x" style="color: var(--danger-color);"></i>
                        <h4 style="color: var(--danger-color);">Credencial No Reconocida</h4>
                        <p>Código: ${codigo}</p>
                    </div>
                `;
            }
        }, 1000);
    }

    // Buscar persona por código (simulación)
    function buscarPersonaPorCodigo(codigo) {
        const personas = [
            {
                id: 'STU001',
                codigo: 'STU001QR',
                nombre: 'Ana Sofia Martinez',
                tipo: 'estudiante',
                grado: '3er Grado',
                grupo: 'A',
                plantel: 'El Zapote',
                padre_nombre: 'Carlos Martinez',
                padre_id: 'PAD001',
                entrada_programada: '08:00',
                salida_programada: '14:00',
                foto: 'ana_sofia.jpg',
                ultimo_registro: null
            },
            {
                id: 'PAD001',
                codigo: 'PAD001QR',
                nombre: 'Carlos Martinez',
                tipo: 'padre',
                hijos: ['Ana Sofia Martinez'],
                plantel: 'El Zapote'
            },
            {
                id: 'MAE001',
                codigo: 'MAE001QR',
                nombre: 'Profesora Laura Gonzalez',
                tipo: 'maestra',
                grado: '2do Grado',
                plantel: 'El Zapote',
                entrada_programada: '07:00',
                salida_programada: '15:00',
                foto: 'laura_gonzalez.jpg',
                ultimo_registro: null
            }
        ];

        return personas.find(p => p.codigo === codigo);
    }

    // Mostrar información de la persona
    function mostrarInfoPersona(persona) {
        const scanInfo = document.getElementById('scan-info');
        const ahora = new Date();
        const horaActual = ahora.toTimeString().substr(0, 5);
        
        let contenido = '';
        
        if (persona.tipo === 'padre') {
            contenido = `
                <div class="scan-result">
                    <div class="persona-foto">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="persona-info">
                        <h4>${persona.nombre}</h4>
                        <div class="persona-meta">
                            Padre de Familia<br>
                            Hijos: ${persona.hijos.join(', ')}<br>
                            Plantel: ${persona.plantel}
                        </div>
                        <div class="accion-badge accion-entrada">
                            <i class="fas fa-child"></i> Gestionando hijo(a)
                        </div>
                    </div>
                </div>
            `;
        } else {
            const accion = determinarAccion(persona);
            const esEntrada = accion === 'entrada';
            
            contenido = `
                <div class="scan-result">
                    <div class="persona-foto">
                        <i class="fas fa-${persona.tipo === 'estudiante' ? 'child' : 'chalkboard-teacher'}"></i>
                    </div>
                    <div class="persona-info">
                        <h4>${persona.nombre}</h4>
                        <div class="persona-meta">
                            ${persona.tipo === 'estudiante' ? `${persona.grado} ${persona.grupo}` : persona.grado}<br>
                            Plantel: ${persona.plantel}<br>
                            Hora: ${horaActual}
                        </div>
                        <div class="accion-badge ${esEntrada ? 'accion-entrada' : 'accion-salida'}">
                            <i class="fas fa-${esEntrada ? 'sign-in-alt' : 'sign-out-alt'}"></i>
                            ${esEntrada ? 'Entrada' : 'Salida'}
                        </div>
                    </div>
                </div>
            `;
        }
        
        scanInfo.innerHTML = contenido;
    }

    // Determinar si es entrada o salida
    function determinarAccion(persona) {
        // Lógica simplificada: si no hay registro hoy, es entrada
        // En implementación real, verificar último registro del día
        return persona.ultimo_registro ? 'salida' : 'entrada';
    }

    // Mostrar modal de confirmación
    function mostrarModalConfirmacion(persona) {
        const modal = document.getElementById('modal-confirmacion');
        const titulo = document.getElementById('modal-titulo');
        const body = document.getElementById('modal-body');
        
        if (persona.tipo === 'padre') {
            titulo.textContent = 'Seleccionar Hijo(a)';
            body.innerHTML = `
                <div style="text-align: center; margin-bottom: 2rem;">
                    <h4>${persona.nombre}</h4>
                    <p>Selecciona al hijo(a) para registrar:</p>
                </div>
                <div class="hijos-lista">
                    ${persona.hijos.map(hijo => `
                        <div class="hijo-item" onclick="seleccionarHijo('${hijo}')">
                            <i class="fas fa-child"></i>
                            <span>${hijo}</span>
                        </div>
                    `).join('')}
                </div>
            `;
        } else {
            const accion = determinarAccion(persona);
            const esEntrada = accion === 'entrada';
            const horaActual = new Date().toTimeString().substr(0, 5);
            const horaProgramada = esEntrada ? persona.entrada_programada : persona.salida_programada;
            const horasExtra = calcularHorasExtra(horaActual, horaProgramada, esEntrada);
            
            titulo.textContent = `Confirmar ${esEntrada ? 'Entrada' : 'Salida'}`;
            body.innerHTML = `
                <div style="text-align: center;">
                    <div class="persona-foto" style="margin-bottom: 1rem;">
                        <i class="fas fa-${persona.tipo === 'estudiante' ? 'child' : 'chalkboard-teacher'}"></i>
                    </div>
                    <h4>${persona.nombre}</h4>
                    <p>${persona.tipo === 'estudiante' ? `${persona.grado} ${persona.grupo}` : persona.grado}</p>
                    
                    <div style="background: var(--gray-50); padding: 1rem; border-radius: var(--border-radius); margin: 1rem 0;">
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; text-align: left;">
                            <div>
                                <strong>Hora Programada:</strong><br>
                                ${horaProgramada}
                            </div>
                            <div>
                                <strong>Hora Actual:</strong><br>
                                ${horaActual}
                            </div>
                        </div>
                        ${horasExtra !== 0 ? `
                            <div style="margin-top: 1rem; padding: 0.5rem; background: var(--warning-light); border-radius: var(--border-radius);">
                                <strong style="color: var(--warning-color);">
                                    ⚠ ${Math.abs(horasExtra)} horas ${horasExtra > 0 ? 'extras' : 'de anticipación'}
                                </strong>
                            </div>
                        ` : ''}
                    </div>
                </div>
            `;
        }
        
        modal.style.display = 'flex';
        window.personaActual = persona;
    }

    // Calcular horas extra
    function calcularHorasExtra(horaActual, horaProgramada, esEntrada) {
        const actual = new Date(`2000-01-01 ${horaActual}`);
        const programada = new Date(`2000-01-01 ${horaProgramada}`);
        const diferencia = (actual - programada) / (1000 * 60 * 60); // en horas
        
        if (esEntrada) {
            return diferencia < 0 ? diferencia : 0; // Llegada temprana (negativo)
        } else {
            return diferencia > 0 ? diferencia : 0; // Salida tardía (positivo)
        }
    }

    // Cerrar modal
    function cerrarModal() {
        document.getElementById('modal-confirmacion').style.display = 'none';
        window.personaActual = null;
    }

    // Confirmar registro
    function confirmarRegistro() {
        const persona = window.personaActual;
        if (!persona) return;
        
        showNotification('Registrando asistencia...', 'info');
        
        // Simular registro en base de datos
        setTimeout(() => {
            const accion = persona.tipo === 'padre' ? 'gestion_hijo' : determinarAccion(persona);
            registrarAsistencia(persona, accion);
            cerrarModal();
            cargarEstadisticas();
            cargarUltimosRegistros();
            showNotification('Asistencia registrada correctamente', 'success');
        }, 1000);
    }

    // Registrar asistencia
    function registrarAsistencia(persona, accion) {
        const ahora = new Date();
        const registro = {
            persona_id: persona.id,
            nombre: persona.nombre,
            tipo: persona.tipo,
            accion: accion,
            hora: ahora.toTimeString().substr(0, 5),
            fecha: ahora.toISOString().substr(0, 10),
            plantel: persona.plantel
        };
        
        // En implementación real, enviar a la base de datos
        console.log('Registro guardado:', registro);
    }

    // Cambiar plantel
    function cambiarPlantel(plantel) {
        const params = new URLSearchParams(window.location.search);
        params.set('plantel', plantel);
        window.location.search = params.toString();
    }

    // Entrada manual
    function escaneoManual() {
        const entradaManual = document.getElementById('entrada-manual');
        entradaManual.style.display = entradaManual.style.display === 'none' ? 'block' : 'none';
        if (entradaManual.style.display === 'block') {
            document.getElementById('codigo-manual').focus();
        }
    }

    // Procesar código manual
    function procesarCodigoManual() {
        const codigo = document.getElementById('codigo-manual').value.trim();
        if (codigo) {
            procesarCredencial(codigo);
            document.getElementById('codigo-manual').value = '';
            cancelarManual();
        }
    }

    // Cancelar entrada manual
    function cancelarManual() {
        document.getElementById('entrada-manual').style.display = 'none';
        document.getElementById('codigo-manual').value = '';
    }

    // Cambiar cámara
    function cambiarCamara() {
        if (scannerActivo) {
            Html5Qrcode.getCameras().then(devices => {
                if (devices && devices.length > 1) {
                    camaraActual = (camaraActual + 1) % devices.length;
                    detenerEscaner();
                    setTimeout(() => {
                        iniciarEscaner();
                    }, 500);
                } else {
                    showNotification('Solo hay una cámara disponible', 'info');
                }
            });
        } else {
            showNotification('Inicia el escáner primero', 'warning');
        }
    }

    // Cargar estadísticas
    function cargarEstadisticas() {
        // Simular datos del día
        document.getElementById('entradas-hoy').textContent = '23';
        document.getElementById('salidas-hoy').textContent = '18';
        document.getElementById('horas-extras-hoy').textContent = '5';
        document.getElementById('presentes-ahora').textContent = '5';
    }

    // Cargar últimos registros
    function cargarUltimosRegistros() {
        const lista = document.getElementById('recent-scans-list');
        const registros = [
            { nombre: 'Ana Sofia Martinez', tipo: 'Estudiante', accion: 'Entrada', hora: '08:05' },
            { nombre: 'Prof. Laura Gonzalez', tipo: 'Maestra', accion: 'Entrada', hora: '06:55' },
            { nombre: 'Diego Alejandro Ruiz', tipo: 'Estudiante', accion: 'Entrada', hora: '07:32' }
        ];
        
        lista.innerHTML = registros.map(registro => `
            <div class="recent-item">
                <div class="recent-item-icon">
                    <i class="fas fa-${registro.tipo === 'Estudiante' ? 'child' : 'chalkboard-teacher'}"></i>
                </div>
                <div class="recent-item-info">
                    <div class="recent-item-name">${registro.nombre}</div>
                    <div class="recent-item-meta">${registro.tipo} • ${registro.accion}</div>
                </div>
                <div class="recent-item-time">${registro.hora}</div>
            </div>
        `).join('');
    }

    // Seleccionar hijo (para padres)
    function seleccionarHijo(nombre) {
        showNotification(`Procesando registro para ${nombre}...`, 'info');
        // Aquí iría la lógica para encontrar al hijo y procesar su entrada/salida
        setTimeout(() => {
            cerrarModal();
            showNotification(`Registro completado para ${nombre}`, 'success');
            cargarEstadisticas();
            cargarUltimosRegistros();
        }, 1000);
    }

    // Tecla Enter en entrada manual
    document.addEventListener('keypress', function(e) {
        if (e.key === 'Enter' && document.getElementById('entrada-manual').style.display === 'block') {
            procesarCodigoManual();
        }
    });
</script>

<style>
    .hijos-lista {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .hijo-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem;
        background: var(--gray-50);
        border: 2px solid var(--gray-300);
        border-radius: var(--border-radius);
        cursor: pointer;
        transition: var(--transition);
    }

    .hijo-item:hover {
        border-color: var(--primary-color);
        background: var(--primary-light);
    }

    .hijo-item i {
        color: var(--primary-color);
        font-size: 1.2rem;
    }
</style>
