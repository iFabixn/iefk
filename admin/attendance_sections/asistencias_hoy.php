<?php
// Datos de ejemplo para asistencias del día
$fecha_actual = date('Y-m-d');
$asistencias_hoy = [
    [
        'id' => 'STU001',
        'nombre' => 'Ana Sofia Martinez',
        'tipo' => 'estudiante',
        'grado' => '3er Grado',
        'grupo' => 'A',
        'plantel' => 'El Zapote',
        'entrada_programada' => '08:00',
        'salida_programada' => '14:00',
        'entrada_real' => '08:05',
        'salida_real' => null,
        'estado' => 'presente',
        'horas_extra_entrada' => 5, // minutos
        'horas_extra_salida' => 0,
        'escaneado_por' => 'Carlos Martinez (Padre)',
        'foto' => 'ana_sofia.jpg'
    ],
    [
        'id' => 'STU002',
        'nombre' => 'Diego Alejandro Ruiz',
        'tipo' => 'estudiante',
        'grado' => '1er Grado',
        'grupo' => 'B',
        'plantel' => 'Insurgentes',
        'entrada_programada' => '07:30',
        'salida_programada' => '13:30',
        'entrada_real' => '07:32',
        'salida_real' => '13:45',
        'estado' => 'completo',
        'horas_extra_entrada' => 2,
        'horas_extra_salida' => 15,
        'escaneado_por' => 'Maria Elena Ruiz (Padre)',
        'foto' => 'diego_alejandro.jpg'
    ],
    [
        'id' => 'MAE001',
        'nombre' => 'Profesora Laura Gonzalez',
        'tipo' => 'maestra',
        'grado' => '2do Grado',
        'plantel' => 'El Zapote',
        'entrada_programada' => '07:00',
        'salida_programada' => '15:00',
        'entrada_real' => '06:55',
        'salida_real' => null,
        'estado' => 'presente',
        'horas_extra_entrada' => -5, // llegó 5 min antes
        'horas_extra_salida' => 0,
        'escaneado_por' => 'Auto-registro',
        'foto' => 'laura_gonzalez.jpg'
    ],
    [
        'id' => 'STU003',
        'nombre' => 'Maria Fernanda Lopez',
        'tipo' => 'estudiante',
        'grado' => '2do Grado',
        'grupo' => 'A',
        'plantel' => 'El Zapote',
        'entrada_programada' => '08:00',
        'salida_programada' => '14:00',
        'entrada_real' => null,
        'salida_real' => null,
        'estado' => 'ausente',
        'horas_extra_entrada' => 0,
        'horas_extra_salida' => 0,
        'escaneado_por' => null,
        'foto' => 'maria_fernanda.jpg'
    ]
];

// Obtener filtros
$filtro_plantel = $_GET['plantel'] ?? 'todos';
$filtro_tipo = $_GET['tipo'] ?? 'todos';
$filtro_estado = $_GET['estado'] ?? 'todos';

// Filtrar datos
$asistencias_filtradas = array_filter($asistencias_hoy, function($asistencia) use ($filtro_plantel, $filtro_tipo, $filtro_estado) {
    $cumple_plantel = ($filtro_plantel === 'todos' || $asistencia['plantel'] === $filtro_plantel);
    $cumple_tipo = ($filtro_tipo === 'todos' || $asistencia['tipo'] === $filtro_tipo);
    $cumple_estado = ($filtro_estado === 'todos' || $asistencia['estado'] === $filtro_estado);
    
    return $cumple_plantel && $cumple_tipo && $cumple_estado;
});

function obtenerEstadoBadge($estado) {
    switch($estado) {
        case 'presente': return '<span class="badge badge-warning"><i class="fas fa-clock"></i> Presente</span>';
        case 'completo': return '<span class="badge badge-success"><i class="fas fa-check-circle"></i> Completo</span>';
        case 'ausente': return '<span class="badge badge-danger"><i class="fas fa-times-circle"></i> Ausente</span>';
        default: return '<span class="badge badge-secondary">Sin Estado</span>';
    }
}

function formatearMinutos($minutos) {
    if ($minutos == 0) return '<span class="text-success">A tiempo</span>';
    
    $horas = floor(abs($minutos) / 60);
    $mins = abs($minutos) % 60;
    
    $texto = '';
    if ($horas > 0) $texto .= $horas . 'h ';
    if ($mins > 0) $texto .= $mins . 'm';
    
    if ($minutos > 0) {
        return '<span class="text-danger">+' . $texto . '</span>';
    } else {
        return '<span class="text-info">-' . $texto . '</span>';
    }
}
?>

<!-- ===================== ASISTENCIAS DE HOY ===================== -->
<div class="asistencias-hoy">
    <!-- Header con estadísticas -->
    <div class="asistencias-header">
        <div class="header-stats">
            <div class="stat-item">
                <div class="stat-number"><?= count(array_filter($asistencias_hoy, fn($a) => $a['estado'] === 'presente' || $a['estado'] === 'completo')) ?></div>
                <div class="stat-label">Presentes</div>
            </div>
            <div class="stat-item">
                <div class="stat-number"><?= count(array_filter($asistencias_hoy, fn($a) => $a['estado'] === 'ausente')) ?></div>
                <div class="stat-label">Ausentes</div>
            </div>
            <div class="stat-item">
                <div class="stat-number"><?= count(array_filter($asistencias_hoy, fn($a) => $a['horas_extra_entrada'] > 0 || $a['horas_extra_salida'] > 0)) ?></div>
                <div class="stat-label">Con Horas Extra</div>
            </div>
            <div class="stat-item">
                <div class="stat-number"><?= count(array_filter($asistencias_hoy, fn($a) => $a['estado'] === 'completo')) ?></div>
                <div class="stat-label">Jornada Completa</div>
            </div>
        </div>
        
        <div class="header-info">
            <h2 style="color: var(--primary-color); margin-bottom: 0.5rem;">
                <i class="fas fa-calendar-day"></i> Asistencias de Hoy
            </h2>
            <p style="color: var(--gray-600);">
                <?= date('l, d \d\e F \d\e Y', strtotime($fecha_actual)) ?>
            </p>
        </div>
    </div>

    <!-- Filtros -->
    <div class="filtros-container">
        <h3><i class="fas fa-filter"></i> Filtros</h3>
        <div class="filtros-grid">
            <div class="filtro-item">
                <label for="filtro-plantel">Plantel:</label>
                <select id="filtro-plantel" onchange="aplicarFiltros()">
                    <option value="todos">Todos los planteles</option>
                    <option value="El Zapote" <?= $filtro_plantel === 'El Zapote' ? 'selected' : '' ?>>El Zapote</option>
                    <option value="Insurgentes" <?= $filtro_plantel === 'Insurgentes' ? 'selected' : '' ?>>Insurgentes</option>
                    <option value="Lindavista" <?= $filtro_plantel === 'Lindavista' ? 'selected' : '' ?>>Lindavista</option>
                </select>
            </div>
            
            <div class="filtro-item">
                <label for="filtro-tipo">Tipo:</label>
                <select id="filtro-tipo" onchange="aplicarFiltros()">
                    <option value="todos">Todos</option>
                    <option value="estudiante" <?= $filtro_tipo === 'estudiante' ? 'selected' : '' ?>>Estudiantes</option>
                    <option value="maestra" <?= $filtro_tipo === 'maestra' ? 'selected' : '' ?>>Maestras</option>
                </select>
            </div>
            
            <div class="filtro-item">
                <label for="filtro-estado">Estado:</label>
                <select id="filtro-estado" onchange="aplicarFiltros()">
                    <option value="todos">Todos los estados</option>
                    <option value="presente" <?= $filtro_estado === 'presente' ? 'selected' : '' ?>>Presente</option>
                    <option value="completo" <?= $filtro_estado === 'completo' ? 'selected' : '' ?>>Completo</option>
                    <option value="ausente" <?= $filtro_estado === 'ausente' ? 'selected' : '' ?>>Ausente</option>
                </select>
            </div>
            
            <div class="filtro-item">
                <button class="btn btn-secondary" onclick="limpiarFiltros()">
                    <i class="fas fa-eraser"></i> Limpiar
                </button>
                <button class="btn btn-primary" onclick="exportarReporte()">
                    <i class="fas fa-download"></i> Exportar
                </button>
            </div>
        </div>
    </div>

    <!-- Lista de Asistencias -->
    <div class="asistencias-lista">
        <?php if (empty($asistencias_filtradas)): ?>
        <div class="empty-state">
            <i class="fas fa-inbox fa-3x"></i>
            <h3>No se encontraron registros</h3>
            <p>No hay asistencias que coincidan con los filtros aplicados.</p>
        </div>
        <?php else: ?>
            <?php foreach ($asistencias_filtradas as $asistencia): ?>
            <div class="asistencia-card">
                <!-- Header de la tarjeta -->
                <div class="card-header">
                    <div class="persona-info">
                        <div class="persona-avatar">
                            <i class="fas fa-<?= $asistencia['tipo'] === 'estudiante' ? 'child' : 'chalkboard-teacher' ?>"></i>
                        </div>
                        <div class="persona-detalles">
                            <h4><?= $asistencia['nombre'] ?></h4>
                            <p>
                                <?= $asistencia['tipo'] === 'estudiante' ? 
                                    $asistencia['grado'] . ' ' . $asistencia['grupo'] : 
                                    $asistencia['grado'] ?>
                                • <?= $asistencia['plantel'] ?>
                            </p>
                        </div>
                    </div>
                    
                    <div class="card-badges">
                        <?= obtenerEstadoBadge($asistencia['estado']) ?>
                        <span class="badge badge-info">
                            <i class="fas fa-<?= $asistencia['tipo'] === 'estudiante' ? 'graduation-cap' : 'user-tie' ?>"></i>
                            <?= ucfirst($asistencia['tipo']) ?>
                        </span>
                    </div>
                </div>

                <!-- Horarios -->
                <div class="horarios-grid">
                    <!-- Entrada -->
                    <div class="horario-item">
                        <div class="horario-header">
                            <i class="fas fa-sign-in-alt"></i>
                            <span>Entrada</span>
                        </div>
                        <div class="horario-detalles">
                            <div class="hora-programada">
                                Programada: <strong><?= $asistencia['entrada_programada'] ?></strong>
                            </div>
                            <div class="hora-real">
                                Real: 
                                <?php if ($asistencia['entrada_real']): ?>
                                    <strong><?= $asistencia['entrada_real'] ?></strong>
                                    <?= formatearMinutos($asistencia['horas_extra_entrada']) ?>
                                <?php else: ?>
                                    <span class="text-muted">No registrada</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Salida -->
                    <div class="horario-item">
                        <div class="horario-header">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Salida</span>
                        </div>
                        <div class="horario-detalles">
                            <div class="hora-programada">
                                Programada: <strong><?= $asistencia['salida_programada'] ?></strong>
                            </div>
                            <div class="hora-real">
                                Real: 
                                <?php if ($asistencia['salida_real']): ?>
                                    <strong><?= $asistencia['salida_real'] ?></strong>
                                    <?= formatearMinutos($asistencia['horas_extra_salida']) ?>
                                <?php else: ?>
                                    <span class="text-muted">No registrada</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer con información adicional -->
                <div class="card-footer">
                    <div class="footer-info">
                        <?php if ($asistencia['escaneado_por']): ?>
                        <span><i class="fas fa-user"></i> Registrado por: <?= $asistencia['escaneado_por'] ?></span>
                        <?php endif; ?>
                        
                        <?php if ($asistencia['horas_extra_entrada'] > 0 || $asistencia['horas_extra_salida'] > 0): ?>
                        <span class="horas-extra-indicator">
                            <i class="fas fa-clock"></i> 
                            Horas extra: <?= $asistencia['horas_extra_entrada'] + $asistencia['horas_extra_salida'] ?> min
                        </span>
                        <?php endif; ?>
                    </div>
                    
                    <div class="card-actions">
                        <button class="btn-icon" onclick="verDetalles('<?= $asistencia['id'] ?>')" title="Ver detalles">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button class="btn-icon" onclick="editarRegistro('<?= $asistencia['id'] ?>')" title="Editar">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn-icon" onclick="enviarNotificacion('<?= $asistencia['id'] ?>')" title="Notificar">
                            <i class="fas fa-bell"></i>
                        </button>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <!-- Resumen del día -->
    <div class="resumen-dia">
        <h3><i class="fas fa-chart-pie"></i> Resumen del Día</h3>
        <div class="resumen-grid">
            <div class="resumen-item">
                <h4>Total de Personas</h4>
                <div class="resumen-numero"><?= count($asistencias_hoy) ?></div>
            </div>
            <div class="resumen-item">
                <h4>Estudiantes</h4>
                <div class="resumen-numero"><?= count(array_filter($asistencias_hoy, fn($a) => $a['tipo'] === 'estudiante')) ?></div>
            </div>
            <div class="resumen-item">
                <h4>Maestras</h4>
                <div class="resumen-numero"><?= count(array_filter($asistencias_hoy, fn($a) => $a['tipo'] === 'maestra')) ?></div>
            </div>
            <div class="resumen-item">
                <h4>Asistencia %</h4>
                <div class="resumen-numero">
                    <?= round((count(array_filter($asistencias_hoy, fn($a) => $a['estado'] !== 'ausente')) / count($asistencias_hoy)) * 100, 1) ?>%
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ===================== ESTILOS ESPECÍFICOS ===================== -->
<style>
    .asistencias-hoy {
        display: flex;
        flex-direction: column;
        gap: 2rem;
        padding: 0;
    }

    .asistencias-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: var(--primary-light);
        padding: 2rem;
        border-radius: var(--border-radius);
        border: 2px solid var(--primary-color);
    }

    .header-stats {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 2rem;
    }

    .stat-item {
        text-align: center;
        background: var(--white);
        padding: 1.5rem;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
    }

    .stat-number {
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--primary-color);
        line-height: 1;
        margin-bottom: 0.5rem;
    }

    .stat-label {
        color: var(--gray-600);
        font-weight: 500;
        font-size: 0.9rem;
    }

    .filtros-container {
        background: var(--white);
        padding: 1.5rem;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        border: 2px solid var(--secondary-color);
    }

    .filtros-container h3 {
        color: var(--primary-color);
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .filtros-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        align-items: end;
    }

    .filtro-item {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .filtro-item:last-child {
        flex-direction: row;
        gap: 1rem;
    }

    .filtro-item label {
        font-weight: 600;
        color: var(--gray-700);
        font-size: 0.9rem;
    }

    .filtro-item select {
        padding: 0.75rem;
        border: 2px solid var(--gray-300);
        border-radius: var(--border-radius);
        font-size: 1rem;
        background: var(--white);
    }

    .filtro-item select:focus {
        outline: none;
        border-color: var(--primary-color);
    }

    .asistencias-lista {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .asistencia-card {
        background: var(--white);
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        border: 2px solid var(--gray-200);
        overflow: hidden;
        transition: var(--transition);
    }

    .asistencia-card:hover {
        border-color: var(--primary-color);
        box-shadow: var(--shadow-hover);
        transform: translateY(-2px);
    }

    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1.5rem;
        background: var(--gray-50);
        border-bottom: 2px solid var(--gray-200);
    }

    .persona-info {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .persona-avatar {
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

    .persona-detalles h4 {
        margin: 0 0 0.25rem 0;
        color: var(--gray-800);
        font-size: 1.2rem;
    }

    .persona-detalles p {
        margin: 0;
        color: var(--gray-600);
        font-size: 0.9rem;
    }

    .card-badges {
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
    }

    .badge {
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .badge-success {
        background: var(--success-light);
        color: var(--success-color);
    }

    .badge-warning {
        background: var(--warning-light);
        color: var(--warning-color);
    }

    .badge-danger {
        background: var(--danger-light);
        color: var(--danger-color);
    }

    .badge-info {
        background: var(--info-light);
        color: var(--info-color);
    }

    .badge-secondary {
        background: var(--gray-200);
        color: var(--gray-700);
    }

    .horarios-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        padding: 1.5rem;
        gap: 2rem;
    }

    .horario-item {
        background: var(--gray-50);
        padding: 1.5rem;
        border-radius: var(--border-radius);
        border: 2px solid var(--gray-200);
    }

    .horario-header {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 1rem;
        color: var(--primary-color);
        font-weight: 600;
        font-size: 1.1rem;
    }

    .horario-detalles {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    .hora-programada,
    .hora-real {
        font-size: 0.95rem;
    }

    .text-success {
        color: var(--success-color);
        font-weight: 600;
    }

    .text-danger {
        color: var(--danger-color);
        font-weight: 600;
    }

    .text-info {
        color: var(--info-color);
        font-weight: 600;
    }

    .text-muted {
        color: var(--gray-500);
        font-style: italic;
    }

    .card-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem 1.5rem;
        background: var(--gray-50);
        border-top: 2px solid var(--gray-200);
    }

    .footer-info {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
        font-size: 0.9rem;
        color: var(--gray-600);
    }

    .footer-info span {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .horas-extra-indicator {
        color: var(--warning-color);
        font-weight: 600;
    }

    .card-actions {
        display: flex;
        gap: 0.5rem;
    }

    .btn-icon {
        background: none;
        border: 1px solid var(--gray-300);
        padding: 0.5rem;
        border-radius: var(--border-radius);
        cursor: pointer;
        transition: var(--transition);
        color: var(--gray-600);
    }

    .btn-icon:hover {
        background: var(--primary-color);
        color: var(--white);
        border-color: var(--primary-color);
    }

    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        color: var(--gray-600);
    }

    .empty-state i {
        color: var(--gray-400);
        margin-bottom: 1.5rem;
    }

    .empty-state h3 {
        color: var(--gray-700);
        margin-bottom: 1rem;
    }

    .resumen-dia {
        background: var(--white);
        padding: 2rem;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        border: 2px solid var(--accent-color);
    }

    .resumen-dia h3 {
        color: var(--primary-color);
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .resumen-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 1.5rem;
    }

    .resumen-item {
        text-align: center;
        background: var(--gray-50);
        padding: 1.5rem;
        border-radius: var(--border-radius);
        border: 2px solid var(--gray-200);
    }

    .resumen-item h4 {
        margin: 0 0 1rem 0;
        color: var(--gray-700);
        font-size: 0.9rem;
    }

    .resumen-numero {
        font-size: 2rem;
        font-weight: 700;
        color: var(--primary-color);
    }

    @media (max-width: 768px) {
        .asistencias-header {
            flex-direction: column;
            gap: 2rem;
        }

        .header-stats {
            grid-template-columns: repeat(2, 1fr);
            width: 100%;
        }

        .filtros-grid {
            grid-template-columns: 1fr;
        }

        .filtro-item:last-child {
            flex-direction: column;
            gap: 1rem;
        }

        .horarios-grid {
            grid-template-columns: 1fr;
        }

        .card-footer {
            flex-direction: column;
            gap: 1rem;
            align-items: flex-start;
        }

        .card-actions {
            align-self: center;
        }

        .resumen-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
</style>

<!-- ===================== SCRIPTS ESPECÍFICOS ===================== -->
<script>
    // Aplicar filtros
    function aplicarFiltros() {
        const plantel = document.getElementById('filtro-plantel').value;
        const tipo = document.getElementById('filtro-tipo').value;
        const estado = document.getElementById('filtro-estado').value;
        
        const params = new URLSearchParams(window.location.search);
        
        if (plantel !== 'todos') params.set('plantel', plantel);
        else params.delete('plantel');
        
        if (tipo !== 'todos') params.set('tipo', tipo);
        else params.delete('tipo');
        
        if (estado !== 'todos') params.set('estado', estado);
        else params.delete('estado');
        
        window.location.search = params.toString();
    }

    // Limpiar filtros
    function limpiarFiltros() {
        const params = new URLSearchParams(window.location.search);
        params.delete('plantel');
        params.delete('tipo');
        params.delete('estado');
        window.location.search = params.toString();
    }

    // Ver detalles
    function verDetalles(id) {
        showNotification('Abriendo detalles de asistencia...', 'info');
        // Aquí iría la lógica para mostrar detalles
    }

    // Editar registro
    function editarRegistro(id) {
        showNotification('Abriendo editor de registro...', 'info');
        // Aquí iría la lógica para editar
    }

    // Enviar notificación
    function enviarNotificacion(id) {
        if (confirm('¿Enviar notificación a los tutores?')) {
            showNotification('Notificación enviada correctamente', 'success');
            // Aquí iría la lógica para enviar notificación
        }
    }

    // Exportar reporte
    function exportarReporte() {
        showNotification('Generando reporte...', 'info');
        
        // Simular generación de reporte
        setTimeout(() => {
            showNotification('Reporte generado y descargado', 'success');
            // Aquí iría la lógica real de exportación
        }, 2000);
    }

    // Auto-actualizar cada 30 segundos
    setInterval(function() {
        console.log('Auto-actualizando asistencias...');
        // Aquí iría la lógica para actualizar datos sin recargar
    }, 30000);
</script>
