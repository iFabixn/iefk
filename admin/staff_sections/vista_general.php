<?php
// Datos estadísticos simulados del personal
$stats_general = [
    'total_empleados' => 47,
    'empleados_activos' => 45,
    'empleados_inactivos' => 2,
    'nuevos_este_mes' => 3,
    'cumpleanos_mes' => 4,
    'contratos_por_vencer' => 2,
    'nomina_pendiente' => 2,
    'prestamos_activos' => 8,
    'total_nomina_mensual' => 487500.00,
    'presentes_hoy' => 42,
    'faltas_hoy' => 3,
    'promedio_antiguedad' => 3.2
];

$empleados_recientes = [
    [
        'id' => 1047,
        'nombre' => 'Ana García Mendoza',
        'puesto' => 'Maestra de Preescolar',
        'plantel' => 'El Zapote',
        'fecha_ingreso' => '2025-08-01',
        'salario' => 12500.00,
        'status' => 'Activo',
        'foto' => null
    ],
    [
        'id' => 1046,
        'nombre' => 'Carlos Rodríguez Silva',
        'puesto' => 'Conserje',
        'plantel' => 'Insurgentes',
        'fecha_ingreso' => '2025-07-15',
        'salario' => 8500.00,
        'status' => 'Activo',
        'foto' => null
    ],
    [
        'id' => 1045,
        'nombre' => 'María Fernández López',
        'puesto' => 'Recepcionista',
        'plantel' => 'Lindavista',
        'fecha_ingreso' => '2025-07-01',
        'salario' => 9800.00,
        'status' => 'Activo',
        'foto' => null
    ]
];

$cumpleanos_mes = [
    ['nombre' => 'Roberto Martínez', 'fecha' => '2025-08-15', 'puesto' => 'Director'],
    ['nombre' => 'Sandra López', 'fecha' => '2025-08-22', 'puesto' => 'Maestra'],
    ['nombre' => 'Diego Hernández', 'fecha' => '2025-08-28', 'puesto' => 'Coordinador'],
    ['nombre' => 'Lucia Ramírez', 'fecha' => '2025-08-30', 'puesto' => 'Administradora']
];

$alertas_urgentes = [
    [
        'tipo' => 'contrato',
        'mensaje' => '2 contratos vencen en los próximos 30 días',
        'urgencia' => 'alta',
        'fecha' => '2025-08-13'
    ],
    [
        'tipo' => 'nomina',
        'mensaje' => 'Nómina quincenal pendiente de procesar',
        'urgencia' => 'alta',
        'fecha' => '2025-08-13'
    ],
    [
        'tipo' => 'prestamo',
        'mensaje' => '3 empleados tienen pagos de préstamo atrasados',
        'urgencia' => 'media',
        'fecha' => '2025-08-12'
    ],
    [
        'tipo' => 'asistencia',
        'mensaje' => 'Alto ausentismo en plantel Insurgentes esta semana',
        'urgencia' => 'media',
        'fecha' => '2025-08-11'
    ]
];

$puestos_distribucion = [
    'Maestros' => 24,
    'Administrativos' => 8,
    'Directivos' => 6,
    'Personal de Limpieza' => 5,
    'Recepcionistas' => 3,
    'Coordinadores' => 1
];
?>

<!-- ===================== VISTA GENERAL DEL PERSONAL ===================== -->
<div class="vista-general-staff">
    <!-- Título y Acciones Principales -->
    <div class="page-header">
        <div>
            <h2 style="color: var(--primary-color); margin-bottom: 0.5rem;">
                <i class="fas fa-tachometer-alt"></i> Panel de Control de Personal
            </h2>
            <p style="color: var(--gray-600);">Resumen general del estado del personal y nómina</p>
        </div>
        <div style="display: flex; gap: 1rem;">
            <button class="btn btn-primary" onclick="quickPayroll()">
                <i class="fas fa-calculator"></i> Calcular Nómina
            </button>
            <button class="btn btn-success" onclick="markAttendance()">
                <i class="fas fa-check-circle"></i> Registrar Asistencia
            </button>
        </div>
    </div>

    <!-- Tarjetas de Estadísticas Principales -->
    <div class="stats-grid">
        <div class="stat-card total">
            <div class="stat-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-content">
                <div class="stat-number"><?= $stats_general['total_empleados'] ?></div>
                <div class="stat-label">Total Empleados</div>
                <div class="stat-detail">
                    <span class="text-success"><?= $stats_general['empleados_activos'] ?> activos</span> • 
                    <span class="text-danger"><?= $stats_general['empleados_inactivos'] ?> inactivos</span>
                </div>
            </div>
        </div>

        <div class="stat-card payroll">
            <div class="stat-icon">
                <i class="fas fa-money-bill-wave"></i>
            </div>
            <div class="stat-content">
                <div class="stat-number">$<?= number_format($stats_general['total_nomina_mensual'], 0) ?></div>
                <div class="stat-label">Nómina Mensual</div>
                <div class="stat-detail">
                    <span class="text-warning"><?= $stats_general['nomina_pendiente'] ?> pagos pendientes</span>
                </div>
            </div>
        </div>

        <div class="stat-card attendance">
            <div class="stat-icon">
                <i class="fas fa-calendar-check"></i>
            </div>
            <div class="stat-content">
                <div class="stat-number"><?= $stats_general['presentes_hoy'] ?>/<?= $stats_general['empleados_activos'] ?></div>
                <div class="stat-label">Presentes Hoy</div>
                <div class="stat-detail">
                    <span class="text-danger"><?= $stats_general['faltas_hoy'] ?> faltas</span> registradas
                </div>
            </div>
        </div>

        <div class="stat-card loans">
            <div class="stat-icon">
                <i class="fas fa-hand-holding-usd"></i>
            </div>
            <div class="stat-content">
                <div class="stat-number"><?= $stats_general['prestamos_activos'] ?></div>
                <div class="stat-label">Préstamos Activos</div>
                <div class="stat-detail">
                    <span class="text-info">En diferentes empleados</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Alertas Urgentes -->
    <div class="urgent-alerts">
        <h3 style="color: var(--primary-color); margin-bottom: 1rem;">
            <i class="fas fa-exclamation-triangle"></i> Alertas Urgentes
        </h3>
        <div class="alerts-grid">
            <?php foreach ($alertas_urgentes as $alerta): ?>
            <div class="alert-card alert-<?= $alerta['urgencia'] ?>">
                <div class="alert-icon">
                    <i class="fas fa-<?= $alerta['tipo'] === 'contrato' ? 'file-contract' : 
                                       ($alerta['tipo'] === 'nomina' ? 'money-bill-wave' : 
                                       ($alerta['tipo'] === 'prestamo' ? 'hand-holding-usd' : 'calendar-times')) ?>"></i>
                </div>
                <div class="alert-content">
                    <div class="alert-message"><?= $alerta['mensaje'] ?></div>
                    <div class="alert-date"><?= date('d/m/Y', strtotime($alerta['fecha'])) ?></div>
                </div>
                <div class="alert-actions">
                    <button class="btn btn-sm btn-outline-primary" onclick="resolveAlert('<?= $alerta['tipo'] ?>')">
                        <i class="fas fa-eye"></i> Ver
                    </button>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Distribución del Personal y Empleados Recientes -->
    <div class="content-row">
        <!-- Distribución por Puestos -->
        <div class="content-section">
            <h3 style="color: var(--primary-color); margin-bottom: 1rem;">
                <i class="fas fa-chart-pie"></i> Distribución por Puestos
            </h3>
            <div class="position-distribution">
                <?php foreach ($puestos_distribucion as $puesto => $cantidad): ?>
                <div class="position-item">
                    <div class="position-info">
                        <span class="position-name"><?= $puesto ?></span>
                        <span class="position-count"><?= $cantidad ?></span>
                    </div>
                    <div class="position-bar">
                        <div class="position-fill" style="width: <?= ($cantidad / max($puestos_distribucion)) * 100 ?>%"></div>
                    </div>
                    <div class="position-percentage">
                        <?= round(($cantidad / $stats_general['total_empleados']) * 100, 1) ?>%
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Empleados Recientes -->
        <div class="content-section">
            <h3 style="color: var(--primary-color); margin-bottom: 1rem;">
                <i class="fas fa-user-plus"></i> Empleados Recientes
            </h3>
            <div class="recent-employees">
                <?php foreach ($empleados_recientes as $empleado): ?>
                <div class="employee-card-mini" onclick="viewEmployeeFile(<?= $empleado['id'] ?>)">
                    <div class="employee-avatar">
                        <?= strtoupper(substr($empleado['nombre'], 0, 1) . substr(strstr($empleado['nombre'], ' '), 1, 1)) ?>
                    </div>
                    <div class="employee-info">
                        <div class="employee-name"><?= $empleado['nombre'] ?></div>
                        <div class="employee-position"><?= $empleado['puesto'] ?></div>
                        <div class="employee-details">
                            <span class="employee-plantel"><?= $empleado['plantel'] ?></span> • 
                            <span class="employee-salary">$<?= number_format($empleado['salario']) ?></span>
                        </div>
                        <div class="employee-date">
                            Ingreso: <?= date('d/m/Y', strtotime($empleado['fecha_ingreso'])) ?>
                        </div>
                    </div>
                    <div class="employee-status">
                        <span class="badge badge-active"><?= $empleado['status'] ?></span>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Cumpleaños del Mes y Acciones Rápidas -->
    <div class="content-row">
        <!-- Cumpleaños del Mes -->
        <div class="content-section">
            <h3 style="color: var(--primary-color); margin-bottom: 1rem;">
                <i class="fas fa-birthday-cake"></i> Cumpleaños de Agosto
            </h3>
            <div class="birthdays-list">
                <?php foreach ($cumpleanos_mes as $cumpleanos): ?>
                <div class="birthday-item">
                    <div class="birthday-icon">
                        <i class="fas fa-gift"></i>
                    </div>
                    <div class="birthday-info">
                        <div class="birthday-name"><?= $cumpleanos['nombre'] ?></div>
                        <div class="birthday-position"><?= $cumpleanos['puesto'] ?></div>
                    </div>
                    <div class="birthday-date">
                        <?= date('d/m', strtotime($cumpleanos['fecha'])) ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Acciones Rápidas -->
        <div class="content-section">
            <h3 style="color: var(--primary-color); margin-bottom: 1rem;">
                <i class="fas fa-bolt"></i> Acciones Rápidas
            </h3>
            <div class="quick-actions">
                <button class="quick-action-btn" onclick="changeSection('nomina_actual')">
                    <i class="fas fa-money-bill-wave"></i>
                    <span>Procesar Nómina</span>
                </button>
                <button class="quick-action-btn" onclick="changeSection('asistencias_hoy')">
                    <i class="fas fa-check-circle"></i>
                    <span>Ver Asistencias</span>
                </button>
                <button class="quick-action-btn" onclick="changeSection('lista_empleados')">
                    <i class="fas fa-users"></i>
                    <span>Lista Completa</span>
                </button>
                <button class="quick-action-btn" onclick="changeSection('contratos')">
                    <i class="fas fa-file-contract"></i>
                    <span>Contratos</span>
                </button>
                <button class="quick-action-btn" onclick="changeSection('prestamos')">
                    <i class="fas fa-hand-holding-usd"></i>
                    <span>Préstamos</span>
                </button>
                <button class="quick-action-btn" onclick="changeSection('reportes')">
                    <i class="fas fa-chart-bar"></i>
                    <span>Reportes</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Resumen de Actividad Reciente -->
    <div class="recent-activity">
        <h3 style="color: var(--primary-color); margin-bottom: 1rem;">
            <i class="fas fa-history"></i> Actividad Reciente
        </h3>
        <div class="activity-timeline">
            <div class="activity-item">
                <div class="activity-time">Hoy 09:15</div>
                <div class="activity-icon success">
                    <i class="fas fa-user-plus"></i>
                </div>
                <div class="activity-content">
                    <strong>Nuevo empleado registrado:</strong> Ana García Mendoza como Maestra de Preescolar
                </div>
            </div>
            <div class="activity-item">
                <div class="activity-time">Ayer 16:30</div>
                <div class="activity-icon warning">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
                <div class="activity-content">
                    <strong>Nómina procesada:</strong> Pagos quincenales del 1-15 de Agosto
                </div>
            </div>
            <div class="activity-item">
                <div class="activity-time">12/08 14:20</div>
                <div class="activity-icon info">
                    <i class="fas fa-file-contract"></i>
                </div>
                <div class="activity-content">
                    <strong>Contrato renovado:</strong> María Fernández López - Recepcionista
                </div>
            </div>
            <div class="activity-item">
                <div class="activity-time">11/08 11:45</div>
                <div class="activity-icon danger">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div class="activity-content">
                    <strong>Alerta generada:</strong> Alto ausentismo en plantel Insurgentes
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ===================== ESTILOS ESPECÍFICOS ===================== -->
<style>
    .vista-general-staff {
        animation: fadeIn 0.5s ease;
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 2rem;
        padding: 1.5rem;
        background: var(--white);
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: var(--white);
        padding: 2rem;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        display: flex;
        align-items: center;
        gap: 1.5rem;
        transition: var(--transition);
        position: relative;
        overflow: hidden;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
    }

    .stat-card.total::before { background: var(--primary-color); }
    .stat-card.payroll::before { background: var(--success-color); }
    .stat-card.attendance::before { background: var(--info-color); }
    .stat-card.loans::before { background: var(--warning-color); }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-lg);
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: var(--white);
    }

    .stat-card.total .stat-icon { background: var(--primary-color); }
    .stat-card.payroll .stat-icon { background: var(--success-color); }
    .stat-card.attendance .stat-icon { background: var(--info-color); }
    .stat-card.loans .stat-icon { background: var(--warning-color); }

    .stat-number {
        font-size: 2rem;
        font-weight: bold;
        color: var(--dark);
        margin-bottom: 0.25rem;
    }

    .stat-label {
        color: var(--gray-600);
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .stat-detail {
        font-size: 0.9rem;
        color: var(--gray-500);
    }

    .text-success { color: var(--success-color); }
    .text-danger { color: var(--danger-color); }
    .text-warning { color: var(--warning-color); }
    .text-info { color: var(--info-color); }

    .urgent-alerts {
        background: var(--white);
        padding: 2rem;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        margin-bottom: 2rem;
    }

    .alerts-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1rem;
    }

    .alert-card {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem;
        border-radius: var(--border-radius);
        border-left: 4px solid;
    }

    .alert-card.alert-alta {
        background: var(--danger-light);
        border-left-color: var(--danger-color);
    }

    .alert-card.alert-media {
        background: var(--warning-light);
        border-left-color: var(--warning-color);
    }

    .alert-card.alert-baja {
        background: var(--info-light);
        border-left-color: var(--info-color);
    }

    .alert-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--white);
    }

    .alert-card.alert-alta .alert-icon { background: var(--danger-color); }
    .alert-card.alert-media .alert-icon { background: var(--warning-color); }
    .alert-card.alert-baja .alert-icon { background: var(--info-color); }

    .alert-content {
        flex: 1;
    }

    .alert-message {
        font-weight: 600;
        color: var(--dark);
        margin-bottom: 0.25rem;
    }

    .alert-date {
        font-size: 0.8rem;
        color: var(--gray-600);
    }

    .content-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 2rem;
        margin-bottom: 2rem;
    }

    .content-section {
        background: var(--white);
        padding: 2rem;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
    }

    .position-distribution {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .position-item {
        display: grid;
        grid-template-columns: 1fr 2fr auto;
        gap: 1rem;
        align-items: center;
    }

    .position-info {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .position-name {
        font-weight: 600;
        color: var(--dark);
    }

    .position-count {
        font-weight: bold;
        color: var(--primary-color);
    }

    .position-bar {
        height: 8px;
        background: var(--gray-300);
        border-radius: 4px;
        overflow: hidden;
    }

    .position-fill {
        height: 100%;
        background: linear-gradient(90deg, var(--primary-color), var(--primary-dark));
        transition: width 1s ease;
    }

    .position-percentage {
        font-size: 0.9rem;
        color: var(--gray-600);
        font-weight: 600;
    }

    .recent-employees {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .employee-card-mini {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem;
        background: var(--gray-50);
        border-radius: var(--border-radius);
        cursor: pointer;
        transition: var(--transition);
    }

    .employee-card-mini:hover {
        background: var(--primary-light);
        transform: translateX(5px);
    }

    .employee-avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: var(--primary-color);
        color: var(--dark);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 1.1rem;
    }

    .employee-info {
        flex: 1;
    }

    .employee-name {
        font-weight: 600;
        color: var(--dark);
        margin-bottom: 0.25rem;
    }

    .employee-position {
        color: var(--gray-600);
        font-size: 0.9rem;
        margin-bottom: 0.25rem;
    }

    .employee-details {
        font-size: 0.8rem;
        color: var(--gray-500);
        margin-bottom: 0.25rem;
    }

    .employee-date {
        font-size: 0.8rem;
        color: var(--gray-500);
    }

    .birthdays-list {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .birthday-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem;
        background: var(--gray-50);
        border-radius: var(--border-radius);
    }

    .birthday-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: var(--warning-color);
        color: var(--white);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .birthday-info {
        flex: 1;
    }

    .birthday-name {
        font-weight: 600;
        color: var(--dark);
    }

    .birthday-position {
        font-size: 0.9rem;
        color: var(--gray-600);
    }

    .birthday-date {
        font-weight: bold;
        color: var(--warning-color);
        font-size: 1.1rem;
    }

    .quick-actions {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
        gap: 1rem;
    }

    .quick-action-btn {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.5rem;
        padding: 1.5rem 1rem;
        background: var(--gray-50);
        border: 2px solid var(--gray-300);
        border-radius: var(--border-radius);
        color: var(--dark);
        text-decoration: none;
        cursor: pointer;
        transition: var(--transition);
    }

    .quick-action-btn:hover {
        background: var(--primary-light);
        border-color: var(--primary-color);
        transform: translateY(-3px);
    }

    .quick-action-btn i {
        font-size: 1.5rem;
        color: var(--primary-color);
    }

    .quick-action-btn span {
        font-size: 0.8rem;
        font-weight: 600;
        text-align: center;
    }

    .recent-activity {
        background: var(--white);
        padding: 2rem;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
    }

    .activity-timeline {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .activity-item {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        padding: 1rem;
        background: var(--gray-50);
        border-radius: var(--border-radius);
    }

    .activity-time {
        font-size: 0.8rem;
        color: var(--gray-500);
        width: 80px;
        flex-shrink: 0;
    }

    .activity-icon {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--white);
        font-size: 0.8rem;
        flex-shrink: 0;
    }

    .activity-icon.success { background: var(--success-color); }
    .activity-icon.warning { background: var(--warning-color); }
    .activity-icon.info { background: var(--info-color); }
    .activity-icon.danger { background: var(--danger-color); }

    .activity-content {
        flex: 1;
        font-size: 0.9rem;
        color: var(--dark);
    }

    @media (max-width: 768px) {
        .content-row {
            grid-template-columns: 1fr;
        }

        .page-header {
            flex-direction: column;
            gap: 1rem;
        }

        .stats-grid {
            grid-template-columns: 1fr;
        }

        .alerts-grid {
            grid-template-columns: 1fr;
        }

        .quick-actions {
            grid-template-columns: repeat(2, 1fr);
        }
    }
</style>

<!-- ===================== SCRIPTS ESPECÍFICOS ===================== -->
<script>
    // Función para resolver alertas
    function resolveAlert(type) {
        let message = '';
        switch(type) {
            case 'contrato':
                message = 'Ver contratos próximos a vencer y programar renovaciones.';
                break;
            case 'nomina':
                message = 'Procesar nómina quincenal pendiente.';
                break;
            case 'prestamo':
                message = 'Revisar pagos de préstamos atrasados y contactar empleados.';
                break;
            case 'asistencia':
                message = 'Analizar causas del ausentismo y tomar medidas correctivas.';
                break;
        }
        alert(`Resolver Alerta: ${type}\n\n${message}`);
    }

    // Función para cálculo rápido de nómina
    function quickPayroll() {
        if(confirm('¿Calcular nómina actual?\n\nEsto procesará:\n• Sueldos base\n• Horas extras\n• Descuentos\n• Préstamos\n• Impuestos')) {
            alert('Calculando nómina...\n\nProcesando datos de 45 empleados activos.\nTiempo estimado: 2-3 minutos.');
        }
    }

    // Función para registro de asistencia
    function markAttendance() {
        alert('Registro de Asistencia\n\nOpciones disponibles:\n• Marcar entrada/salida manual\n• Escanear código QR\n• Ver reporte del día\n• Justificar ausencias');
    }

    // Animaciones al cargar
    document.addEventListener('DOMContentLoaded', function() {
        // Animar barras de progreso
        const progressBars = document.querySelectorAll('.position-fill');
        progressBars.forEach((bar, index) => {
            const width = bar.style.width;
            bar.style.width = '0%';
            setTimeout(() => {
                bar.style.width = width;
            }, index * 200);
        });

        // Animar números
        const statNumbers = document.querySelectorAll('.stat-number');
        statNumbers.forEach(stat => {
            const finalNumber = stat.textContent;
            const isMoneyFormat = finalNumber.includes('$');
            let finalNum = parseFloat(finalNumber.replace(/[^0-9.]/g, ''));
            
            if (!isNaN(finalNum)) {
                stat.textContent = isMoneyFormat ? '$0' : '0';
                
                const increment = finalNum / 30;
                let current = 0;
                
                const timer = setInterval(() => {
                    current += increment;
                    if (current >= finalNum) {
                        stat.textContent = finalNumber;
                        clearInterval(timer);
                    } else {
                        if (isMoneyFormat) {
                            stat.textContent = '$' + Math.floor(current).toLocaleString();
                        } else {
                            stat.textContent = Math.floor(current);
                        }
                    }
                }, 50);
            }
        });
    });
</script>
