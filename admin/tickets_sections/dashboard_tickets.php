<?php
// Datos simulados de tickets y estadísticas
$estadisticas = [
    'total_tickets' => 156,
    'pendientes' => 23,
    'en_proceso' => 31,
    'urgentes' => 8,
    'cerrados_hoy' => 12,
    'tiempo_promedio_resolucion' => '2.5 días',
    'satisfaccion_promedio' => 4.2
];

// Tickets recientes
$tickets_recientes = [
    [
        'id' => 'TK-2025-0234',
        'titulo' => 'Problema con el sistema de calificaciones',
        'categoria' => 'Tecnología',
        'prioridad' => 'Alta',
        'estado' => 'En Proceso',
        'asignado_a' => 'Carlos Mendoza',
        'creado_por' => 'María González',
        'fecha_creacion' => '2025-08-13 09:30',
        'plantel' => 'El Zapote'
    ],
    [
        'id' => 'TK-2025-0235',
        'titulo' => 'Incidente en el patio de preescolar',
        'categoria' => 'Situaciones de Estudiantes',
        'prioridad' => 'Urgente',
        'estado' => 'Asignado',
        'asignado_a' => 'Ana Ruiz',
        'creado_por' => 'Sandra López',
        'fecha_creacion' => '2025-08-13 11:15',
        'plantel' => 'El Zapote'
    ],
    [
        'id' => 'TK-2025-0236',
        'titulo' => 'Solicitud de capacitación en nuevas metodologías',
        'categoria' => 'Pedagógico',
        'prioridad' => 'Media',
        'estado' => 'Pendiente',
        'asignado_a' => 'Sin asignar',
        'creado_por' => 'Roberto Martínez',
        'fecha_creacion' => '2025-08-13 14:20',
        'plantel' => 'Insurgentes'
    ],
    [
        'id' => 'TK-2025-0237',
        'titulo' => 'Conflicto entre docentes de primaria',
        'categoria' => 'Relaciones Laborales',
        'prioridad' => 'Alta',
        'estado' => 'En Proceso',
        'asignado_a' => 'Diego Hernández',
        'creado_por' => 'Lucia Ramírez',
        'fecha_creacion' => '2025-08-13 16:45',
        'plantel' => 'Lindavista'
    ],
    [
        'id' => 'TK-2025-0238',
        'titulo' => 'Mejora para el área de juegos',
        'categoria' => 'Infraestructura',
        'prioridad' => 'Baja',
        'estado' => 'Pendiente',
        'asignado_a' => 'Sin asignar',
        'creado_por' => 'José Morales',
        'fecha_creacion' => '2025-08-12 17:30',
        'plantel' => 'El Zapote'
    ]
];

// Distribución por categorías
$distribucion_categorias = [
    ['categoria' => 'Tecnología', 'cantidad' => 32, 'porcentaje' => 20.5],
    ['categoria' => 'Situaciones de Estudiantes', 'cantidad' => 28, 'porcentaje' => 17.9],
    ['categoria' => 'Pedagógico', 'cantidad' => 25, 'porcentaje' => 16.0],
    ['categoria' => 'Relaciones Laborales', 'cantidad' => 22, 'porcentaje' => 14.1],
    ['categoria' => 'Infraestructura', 'cantidad' => 21, 'porcentaje' => 13.5],
    ['categoria' => 'Mejoras y Sugerencias', 'cantidad' => 18, 'porcentaje' => 11.5],
    ['categoria' => 'Otros', 'cantidad' => 10, 'porcentaje' => 6.4]
];

// Alertas importantes
$alertas = [
    [
        'tipo' => 'urgente',
        'mensaje' => '8 tickets marcados como urgentes requieren atención inmediata',
        'icono' => 'exclamation-triangle'
    ],
    [
        'tipo' => 'warning',
        'mensaje' => '5 tickets sin asignar desde hace más de 24 horas',
        'icono' => 'clock'
    ],
    [
        'tipo' => 'info',
        'mensaje' => 'Tiempo promedio de resolución ha mejorado un 15% esta semana',
        'icono' => 'chart-line'
    ]
];
?>

<!-- ===================== DASHBOARD DE TICKETS ===================== -->
<div class="dashboard-tickets">
    <!-- Header del Dashboard -->
    <div class="dashboard-header">
        <div class="header-content">
            <h1 style="color: var(--primary-color); margin-bottom: 0.5rem;">
                <i class="fas fa-tachometer-alt"></i> Dashboard de Tickets
            </h1>
            <p style="color: var(--gray-600);">
                Centro de control para la gestión de incidencias y seguimientos
            </p>
        </div>
        <div class="header-actions">
            <button class="btn btn-primary" onclick="crearTicket()">
                <i class="fas fa-plus"></i> Nuevo Ticket
            </button>
            <button class="btn btn-outline-primary" onclick="actualizarDashboard()">
                <i class="fas fa-sync-alt"></i> Actualizar
            </button>
        </div>
    </div>

    <!-- Alertas Importantes -->
    <?php if (!empty($alertas)): ?>
    <div class="alerts-section">
        <?php foreach ($alertas as $alerta): ?>
        <div class="alert alert-<?= $alerta['tipo'] ?>">
            <i class="fas fa-<?= $alerta['icono'] ?>"></i>
            <span><?= $alerta['mensaje'] ?></span>
            <button class="alert-close" onclick="this.parentElement.style.display='none'">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <!-- Estadísticas Principales -->
    <div class="stats-grid">
        <div class="stat-card total">
            <div class="stat-icon">
                <i class="fas fa-ticket-alt"></i>
            </div>
            <div class="stat-content">
                <div class="stat-number"><?= $estadisticas['total_tickets'] ?></div>
                <div class="stat-label">Total de Tickets</div>
                <div class="stat-trend">
                    <i class="fas fa-arrow-up"></i> +12% vs mes anterior
                </div>
            </div>
        </div>

        <div class="stat-card pendientes">
            <div class="stat-icon">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-content">
                <div class="stat-number"><?= $estadisticas['pendientes'] ?></div>
                <div class="stat-label">Pendientes</div>
                <div class="stat-trend">
                    <i class="fas fa-arrow-down"></i> -5% vs semana anterior
                </div>
            </div>
        </div>

        <div class="stat-card proceso">
            <div class="stat-icon">
                <i class="fas fa-cogs"></i>
            </div>
            <div class="stat-content">
                <div class="stat-number"><?= $estadisticas['en_proceso'] ?></div>
                <div class="stat-label">En Proceso</div>
                <div class="stat-trend">
                    <i class="fas fa-arrow-up"></i> +8% vs semana anterior
                </div>
            </div>
        </div>

        <div class="stat-card urgentes">
            <div class="stat-icon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div class="stat-content">
                <div class="stat-number"><?= $estadisticas['urgentes'] ?></div>
                <div class="stat-label">Urgentes</div>
                <div class="stat-trend">
                    <i class="fas fa-arrow-up"></i> +2 desde ayer
                </div>
            </div>
        </div>

        <div class="stat-card cerrados">
            <div class="stat-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-content">
                <div class="stat-number"><?= $estadisticas['cerrados_hoy'] ?></div>
                <div class="stat-label">Cerrados Hoy</div>
                <div class="stat-trend">
                    <i class="fas fa-check"></i> Meta: 15 diarios
                </div>
            </div>
        </div>

        <div class="stat-card tiempo">
            <div class="stat-icon">
                <i class="fas fa-stopwatch"></i>
            </div>
            <div class="stat-content">
                <div class="stat-number"><?= $estadisticas['tiempo_promedio_resolucion'] ?></div>
                <div class="stat-label">Tiempo Promedio</div>
                <div class="stat-trend">
                    <i class="fas fa-arrow-down"></i> -15% vs mes anterior
                </div>
            </div>
        </div>
    </div>

    <!-- Sección Principal de Contenido -->
    <div class="dashboard-content">
        <!-- Tickets Recientes -->
        <div class="recent-tickets">
            <div class="section-header">
                <h3><i class="fas fa-history"></i> Tickets Recientes</h3>
                <div class="section-actions">
                    <button class="btn btn-sm btn-outline-primary" onclick="verTodosTickets()">
                        <i class="fas fa-list"></i> Ver Todos
                    </button>
                </div>
            </div>
            
            <div class="tickets-list">
                <?php foreach ($tickets_recientes as $ticket): ?>
                <div class="ticket-item" onclick="verTicket('<?= $ticket['id'] ?>')">
                    <div class="ticket-header">
                        <div class="ticket-id"><?= $ticket['id'] ?></div>
                        <div class="ticket-priority priority-<?= strtolower($ticket['prioridad']) ?>">
                            <?= $ticket['prioridad'] ?>
                        </div>
                    </div>
                    
                    <div class="ticket-content">
                        <h4><?= $ticket['titulo'] ?></h4>
                        <div class="ticket-meta">
                            <span class="ticket-category">
                                <i class="fas fa-tag"></i> <?= $ticket['categoria'] ?>
                            </span>
                            <span class="ticket-location">
                                <i class="fas fa-map-marker-alt"></i> <?= $ticket['plantel'] ?>
                            </span>
                            <span class="ticket-creator">
                                <i class="fas fa-user"></i> <?= $ticket['creado_por'] ?>
                            </span>
                        </div>
                    </div>
                    
                    <div class="ticket-status">
                        <div class="status-badge status-<?= strtolower(str_replace(' ', '-', $ticket['estado'])) ?>">
                            <?= $ticket['estado'] ?>
                        </div>
                        <div class="ticket-assignee">
                            <?php if ($ticket['asignado_a'] !== 'Sin asignar'): ?>
                                <i class="fas fa-user-check"></i> <?= $ticket['asignado_a'] ?>
                            <?php else: ?>
                                <i class="fas fa-user-times"></i> Sin asignar
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <div class="ticket-time">
                        <i class="fas fa-clock"></i>
                        <?= date('d/m/Y H:i', strtotime($ticket['fecha_creacion'])) ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Distribución por Categorías -->
        <div class="categories-distribution">
            <div class="section-header">
                <h3><i class="fas fa-chart-pie"></i> Distribución por Categorías</h3>
            </div>
            
            <div class="categories-chart">
                <?php foreach ($distribucion_categorias as $cat): ?>
                <div class="category-item">
                    <div class="category-info">
                        <span class="category-name"><?= $cat['categoria'] ?></span>
                        <span class="category-count"><?= $cat['cantidad'] ?> tickets</span>
                    </div>
                    <div class="category-bar">
                        <div class="category-progress" style="width: <?= $cat['porcentaje'] ?>%"></div>
                    </div>
                    <div class="category-percentage"><?= $cat['porcentaje'] ?>%</div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Acciones Rápidas -->
    <div class="quick-actions">
        <h3 style="color: var(--primary-color); margin-bottom: 1.5rem;">
            <i class="fas fa-bolt"></i> Acciones Rápidas
        </h3>
        <div class="actions-grid">
            <button class="action-card" onclick="crearTicketRapido('urgente')">
                <i class="fas fa-exclamation-triangle"></i>
                <h4>Reporte Urgente</h4>
                <p>Crear ticket con prioridad urgente</p>
            </button>
            
            <button class="action-card" onclick="crearTicketRapido('estudiante')">
                <i class="fas fa-child"></i>
                <h4>Incidencia de Estudiante</h4>
                <p>Reportar situación con algún estudiante</p>
            </button>
            
            <button class="action-card" onclick="crearTicketRapido('infraestructura')">
                <i class="fas fa-tools"></i>
                <h4>Problema de Infraestructura</h4>
                <p>Reportar desperfecto o mantenimiento</p>
            </button>
            
            <button class="action-card" onclick="crearTicketRapido('tecnologia')">
                <i class="fas fa-laptop"></i>
                <h4>Soporte Técnico</h4>
                <p>Solicitar ayuda con tecnología</p>
            </button>
            
            <button class="action-card" onclick="crearTicketRapido('pedagogico')">
                <i class="fas fa-chalkboard-teacher"></i>
                <h4>Consulta Pedagógica</h4>
                <p>Dudas sobre métodos de enseñanza</p>
            </button>
            
            <button class="action-card" onclick="verReportes()">
                <i class="fas fa-chart-bar"></i>
                <h4>Ver Reportes</h4>
                <p>Analizar estadísticas y métricas</p>
            </button>
        </div>
    </div>
</div>

<!-- ===================== ESTILOS ESPECÍFICOS ===================== -->
<style>
    .dashboard-tickets {
        animation: fadeIn 0.5s ease;
    }

    .dashboard-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        background: var(--white);
        padding: 2rem;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        margin-bottom: 2rem;
        border-left: 4px solid var(--primary-color);
    }

    .header-actions {
        display: flex;
        gap: 1rem;
    }

    .alerts-section {
        margin-bottom: 2rem;
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .alert {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem 1.5rem;
        border-radius: var(--border-radius);
        border-left: 4px solid;
        position: relative;
    }

    .alert-urgente {
        background: var(--danger-light);
        border-left-color: var(--danger-color);
        color: var(--danger-color);
    }

    .alert-warning {
        background: var(--warning-light);
        border-left-color: var(--warning-color);
        color: var(--warning-color);
    }

    .alert-info {
        background: var(--info-light);
        border-left-color: var(--info-color);
        color: var(--info-color);
    }

    .alert-close {
        position: absolute;
        right: 1rem;
        background: none;
        border: none;
        color: inherit;
        cursor: pointer;
        padding: 0.25rem;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        display: flex;
        align-items: center;
        gap: 1.5rem;
        background: var(--white);
        padding: 2rem;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        border-left: 4px solid;
        transition: var(--transition);
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-lg);
    }

    .stat-card.total { border-left-color: var(--primary-color); }
    .stat-card.pendientes { border-left-color: var(--warning-color); }
    .stat-card.proceso { border-left-color: var(--info-color); }
    .stat-card.urgentes { border-left-color: var(--danger-color); }
    .stat-card.cerrados { border-left-color: var(--success-color); }
    .stat-card.tiempo { border-left-color: var(--purple); }

    .stat-icon {
        font-size: 2.5rem;
        opacity: 0.8;
    }

    .stat-card.total .stat-icon { color: var(--primary-color); }
    .stat-card.pendientes .stat-icon { color: var(--warning-color); }
    .stat-card.proceso .stat-icon { color: var(--info-color); }
    .stat-card.urgentes .stat-icon { color: var(--danger-color); }
    .stat-card.cerrados .stat-icon { color: var(--success-color); }
    .stat-card.tiempo .stat-icon { color: var(--purple); }

    .stat-content {
        flex: 1;
    }

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

    .stat-trend {
        font-size: 0.8rem;
        color: var(--gray-500);
    }

    .dashboard-content {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 2rem;
        margin-bottom: 2rem;
    }

    .recent-tickets,
    .categories-distribution {
        background: var(--white);
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        overflow: hidden;
    }

    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1.5rem;
        background: var(--primary-light);
        border-bottom: 1px solid var(--gray-200);
    }

    .section-header h3 {
        margin: 0;
        color: var(--primary-color);
    }

    .tickets-list {
        max-height: 600px;
        overflow-y: auto;
    }

    .ticket-item {
        padding: 1.5rem;
        border-bottom: 1px solid var(--gray-200);
        cursor: pointer;
        transition: var(--transition);
    }

    .ticket-item:hover {
        background: var(--gray-50);
    }

    .ticket-item:last-child {
        border-bottom: none;
    }

    .ticket-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }

    .ticket-id {
        font-weight: bold;
        color: var(--primary-color);
    }

    .ticket-priority {
        padding: 0.25rem 0.75rem;
        border-radius: 12px;
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
    }

    .priority-baja {
        background: var(--gray-200);
        color: var(--gray-600);
    }

    .priority-media {
        background: var(--warning-light);
        color: var(--warning-color);
    }

    .priority-alta {
        background: var(--danger-light);
        color: var(--danger-color);
    }

    .priority-urgente {
        background: var(--danger-color);
        color: var(--white);
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% { opacity: 1; }
        50% { opacity: 0.7; }
        100% { opacity: 1; }
    }

    .ticket-content h4 {
        margin: 0 0 0.5rem 0;
        color: var(--dark);
        font-size: 1rem;
    }

    .ticket-meta {
        display: flex;
        gap: 1rem;
        margin-bottom: 1rem;
        flex-wrap: wrap;
    }

    .ticket-meta span {
        font-size: 0.8rem;
        color: var(--gray-600);
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }

    .ticket-status {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.5rem;
    }

    .status-badge {
        padding: 0.25rem 0.75rem;
        border-radius: 12px;
        font-size: 0.8rem;
        font-weight: 600;
    }

    .status-pendiente {
        background: var(--warning-light);
        color: var(--warning-color);
    }

    .status-asignado {
        background: var(--info-light);
        color: var(--info-color);
    }

    .status-en-proceso {
        background: var(--primary-light);
        color: var(--primary-color);
    }

    .status-cerrado {
        background: var(--success-light);
        color: var(--success-color);
    }

    .ticket-assignee {
        font-size: 0.8rem;
        color: var(--gray-600);
    }

    .ticket-time {
        font-size: 0.8rem;
        color: var(--gray-500);
        text-align: right;
    }

    .categories-chart {
        padding: 1.5rem;
    }

    .category-item {
        display: grid;
        grid-template-columns: 1fr auto auto;
        gap: 1rem;
        align-items: center;
        margin-bottom: 1rem;
        padding: 0.75rem;
        border-radius: var(--border-radius);
        transition: var(--transition);
    }

    .category-item:hover {
        background: var(--gray-50);
    }

    .category-info {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }

    .category-name {
        font-weight: 600;
        color: var(--dark);
    }

    .category-count {
        font-size: 0.8rem;
        color: var(--gray-600);
    }

    .category-bar {
        background: var(--gray-200);
        height: 8px;
        border-radius: 4px;
        overflow: hidden;
        width: 100px;
    }

    .category-progress {
        height: 100%;
        background: var(--primary-color);
        transition: width 0.3s ease;
    }

    .category-percentage {
        font-weight: 600;
        color: var(--primary-color);
        font-size: 0.9rem;
        width: 40px;
        text-align: right;
    }

    .quick-actions {
        background: var(--white);
        padding: 2rem;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
    }

    .actions-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
    }

    .action-card {
        background: var(--gray-50);
        padding: 2rem;
        border-radius: var(--border-radius);
        border: 2px solid transparent;
        cursor: pointer;
        transition: var(--transition);
        text-align: center;
        border: none;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 1rem;
    }

    .action-card:hover {
        background: var(--primary-light);
        border-color: var(--primary-color);
        transform: translateY(-2px);
        box-shadow: var(--shadow);
    }

    .action-card i {
        font-size: 2.5rem;
        color: var(--primary-color);
    }

    .action-card h4 {
        margin: 0;
        color: var(--dark);
        font-size: 1rem;
    }

    .action-card p {
        margin: 0;
        color: var(--gray-600);
        font-size: 0.9rem;
        text-align: center;
    }

    @media (max-width: 768px) {
        .dashboard-header {
            flex-direction: column;
            gap: 1rem;
        }

        .header-actions {
            width: 100%;
            justify-content: center;
        }

        .stats-grid {
            grid-template-columns: 1fr;
        }

        .dashboard-content {
            grid-template-columns: 1fr;
        }

        .ticket-meta {
            flex-direction: column;
            gap: 0.5rem;
        }

        .ticket-status {
            flex-direction: column;
            gap: 0.5rem;
            align-items: flex-start;
        }

        .actions-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<!-- ===================== SCRIPTS ESPECÍFICOS ===================== -->
<script>
    // Funciones del dashboard
    function crearTicket() {
        window.location.href = '?section=crear_ticket';
    }

    function crearTicketRapido(tipo) {
        const tipos = {
            'urgente': 'Crear Ticket Urgente',
            'estudiante': 'Incidencia de Estudiante',
            'infraestructura': 'Problema de Infraestructura',
            'tecnologia': 'Soporte Técnico',
            'pedagogico': 'Consulta Pedagógica'
        };
        
        alert(`${tipos[tipo]}\n\nSe abrirá el formulario de creación de ticket con la categoría "${tipo}" preseleccionada.`);
        window.location.href = `?section=crear_ticket&tipo=${tipo}`;
    }

    function verTicket(ticketId) {
        alert(`Ver Ticket: ${ticketId}\n\nSe abrirá la vista detallada del ticket con toda la información y seguimiento.`);
        window.location.href = `?section=ver_ticket&id=${ticketId}`;
    }

    function verTodosTickets() {
        window.location.href = '?section=todos_tickets';
    }

    function verReportes() {
        window.location.href = '?section=reportes_tickets';
    }

    function actualizarDashboard() {
        showNotification('Actualizando dashboard...', 'info');
        setTimeout(() => {
            showNotification('Dashboard actualizado correctamente', 'success');
            location.reload();
        }, 1500);
    }

    // Animaciones al cargar
    document.addEventListener('DOMContentLoaded', function() {
        // Animar tarjetas de estadísticas
        const statCards = document.querySelectorAll('.stat-card');
        statCards.forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            setTimeout(() => {
                card.style.transition = 'all 0.3s ease';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, index * 100);
        });

        // Animar tickets
        const ticketItems = document.querySelectorAll('.ticket-item');
        ticketItems.forEach((item, index) => {
            item.style.opacity = '0';
            item.style.transform = 'translateX(-20px)';
            setTimeout(() => {
                item.style.transition = 'all 0.3s ease';
                item.style.opacity = '1';
                item.style.transform = 'translateX(0)';
            }, 500 + (index * 50));
        });

        // Auto-actualizar cada 5 minutos
        setInterval(function() {
            console.log('Auto-actualizando dashboard...');
            // Aquí iría la lógica de actualización automática
        }, 300000); // 5 minutos
    });
</script>
