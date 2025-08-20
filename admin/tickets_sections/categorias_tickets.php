<?php
// Obtener categoría actual
$categoria_actual = $_GET['cat'] ?? 'todas';

// Obtener filtros
$filtro_estado = $_GET['estado'] ?? 'todas';
$filtro_prioridad = $_GET['prioridad'] ?? 'todas';
$filtro_plantel = $_GET['plantel'] ?? 'todos';

// Definición de categorías
$categorias = [
    'todas' => [
        'nombre' => 'Todas las Categorías',
        'icono' => 'fas fa-list',
        'color' => 'primary'
    ],
    'tecnologia' => [
        'nombre' => 'Tecnología',
        'icono' => 'fas fa-laptop',
        'color' => 'info'
    ],
    'estudiantes' => [
        'nombre' => 'Situaciones de Estudiantes',
        'icono' => 'fas fa-child',
        'color' => 'warning'
    ],
    'pedagogico' => [
        'nombre' => 'Pedagógico',
        'icono' => 'fas fa-chalkboard-teacher',
        'color' => 'success'
    ],
    'relaciones_laborales' => [
        'nombre' => 'Relaciones Laborales',
        'icono' => 'fas fa-handshake',
        'color' => 'danger'
    ],
    'infraestructura' => [
        'nombre' => 'Infraestructura',
        'icono' => 'fas fa-building',
        'color' => 'secondary'
    ],
    'mejoras' => [
        'nombre' => 'Mejoras y Sugerencias',
        'icono' => 'fas fa-lightbulb',
        'color' => 'warning'
    ],
    'administrativo' => [
        'nombre' => 'Administrativo',
        'icono' => 'fas fa-clipboard-list',
        'color' => 'info'
    ]
];

// Datos de ejemplo para tickets
$tickets_ejemplo = [
    [
        'id' => 'TK-2024-0001',
        'titulo' => 'Problema con proyector en Aula 3B',
        'categoria' => 'tecnologia',
        'prioridad' => 'alta',
        'estado' => 'abierto',
        'plantel' => 'el_zapote',
        'creado_por' => 'María González',
        'asignado_a' => 'Soporte Técnico',
        'fecha_creacion' => '2024-01-15 08:30:00',
        'ultima_actualizacion' => '2024-01-15 14:20:00',
        'descripcion' => 'El proyector del aula 3B no enciende y las clases se están viendo afectadas.',
        'respuestas' => 3
    ],
    [
        'id' => 'TK-2024-0002',
        'titulo' => 'Incidente en el recreo - Estudiante lastimado',
        'categoria' => 'estudiantes',
        'prioridad' => 'urgente',
        'estado' => 'en_proceso',
        'plantel' => 'insurgentes',
        'creado_por' => 'Carlos Ramírez',
        'asignado_a' => 'Coordinación Académica',
        'fecha_creacion' => '2024-01-15 10:15:00',
        'ultima_actualizacion' => '2024-01-15 15:45:00',
        'descripcion' => 'Un estudiante de 3er grado se lastimó durante el recreo.',
        'respuestas' => 5
    ],
    [
        'id' => 'TK-2024-0003',
        'titulo' => 'Solicitud de capacitación en nuevos métodos pedagógicos',
        'categoria' => 'pedagogico',
        'prioridad' => 'media',
        'estado' => 'abierto',
        'plantel' => 'lindavista',
        'creado_por' => 'Ana Martínez',
        'asignado_a' => 'Coordinación Académica',
        'fecha_creacion' => '2024-01-14 16:20:00',
        'ultima_actualizacion' => '2024-01-15 09:10:00',
        'descripcion' => 'Solicito capacitación en metodologías innovadoras para preescolar.',
        'respuestas' => 1
    ],
    [
        'id' => 'TK-2024-0004',
        'titulo' => 'Conflicto entre docentes',
        'categoria' => 'relaciones_laborales',
        'prioridad' => 'alta',
        'estado' => 'cerrado',
        'plantel' => 'el_zapote',
        'creado_por' => 'Director El Zapote',
        'asignado_a' => 'Recursos Humanos',
        'fecha_creacion' => '2024-01-13 11:30:00',
        'ultima_actualizacion' => '2024-01-15 17:00:00',
        'descripcion' => 'Se reporta tensión entre dos docentes del área de primaria.',
        'respuestas' => 8
    ],
    [
        'id' => 'TK-2024-0005',
        'titulo' => 'Fuga de agua en baños de planta baja',
        'categoria' => 'infraestructura',
        'prioridad' => 'media',
        'estado' => 'en_proceso',
        'plantel' => 'insurgentes',
        'creado_por' => 'Conserje',
        'asignado_a' => 'Mantenimiento',
        'fecha_creacion' => '2024-01-15 07:45:00',
        'ultima_actualizacion' => '2024-01-15 16:30:00',
        'descripcion' => 'Se detectó fuga en los baños de la planta baja.',
        'respuestas' => 2
    ]
];

// Filtrar tickets según criterios
$tickets_filtrados = array_filter($tickets_ejemplo, function($ticket) use ($categoria_actual, $filtro_estado, $filtro_prioridad, $filtro_plantel) {
    $cumple_categoria = ($categoria_actual === 'todas' || $ticket['categoria'] === $categoria_actual);
    $cumple_estado = ($filtro_estado === 'todas' || $ticket['estado'] === $filtro_estado);
    $cumple_prioridad = ($filtro_prioridad === 'todas' || $ticket['prioridad'] === $filtro_prioridad);
    $cumple_plantel = ($filtro_plantel === 'todos' || $ticket['plantel'] === $filtro_plantel);
    
    return $cumple_categoria && $cumple_estado && $cumple_prioridad && $cumple_plantel;
});

function obtenerColorPrioridad($prioridad) {
    switch($prioridad) {
        case 'urgente': return 'danger';
        case 'alta': return 'warning';
        case 'media': return 'info';
        case 'baja': return 'success';
        default: return 'secondary';
    }
}

function obtenerColorEstado($estado) {
    switch($estado) {
        case 'abierto': return 'primary';
        case 'en_proceso': return 'warning';
        case 'cerrado': return 'success';
        case 'cancelado': return 'danger';
        default: return 'secondary';
    }
}

function formatearFecha($fecha) {
    return date('d/m/Y H:i', strtotime($fecha));
}
?>

<!-- ===================== CATEGORÍAS DE TICKETS ===================== -->
<div class="categorias-tickets">
    <!-- Header con filtros -->
    <div class="categorias-header">
        <div class="header-info">
            <h1 style="color: var(--primary-color); margin-bottom: 0.5rem;">
                <i class="<?= $categorias[$categoria_actual]['icono'] ?>"></i> 
                <?= $categorias[$categoria_actual]['nombre'] ?>
            </h1>
            <p style="color: var(--gray-600);">
                <?= count($tickets_filtrados) ?> ticket(s) encontrado(s)
            </p>
        </div>
        
        <div class="header-actions">
            <button class="btn btn-outline-primary" onclick="actualizarVista()">
                <i class="fas fa-sync-alt"></i> Actualizar
            </button>
            <button class="btn btn-primary" onclick="location.href='?section=crear_ticket'">
                <i class="fas fa-plus"></i> Nuevo Ticket
            </button>
        </div>
    </div>

    <!-- Tabs de Categorías -->
    <div class="category-tabs">
        <?php foreach ($categorias as $key => $categoria): ?>
        <div class="category-tab <?= $categoria_actual === $key ? 'active' : '' ?>"
             onclick="cambiarCategoria('<?= $key ?>')">
            <i class="<?= $categoria['icono'] ?>"></i>
            <span><?= $categoria['nombre'] ?></span>
            <div class="tab-badge badge-<?= $categoria['color'] ?>">
                <?= $key === 'todas' ? count($tickets_ejemplo) : count(array_filter($tickets_ejemplo, function($t) use ($key) { return $t['categoria'] === $key; })) ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Filtros Avanzados -->
    <div class="filtros-container">
        <div class="filtros-expandibles" id="filtros-expandibles">
            <div class="filtro-grupo">
                <label>Estado:</label>
                <select id="filtro-estado" onchange="aplicarFiltros()">
                    <option value="todas" <?= $filtro_estado === 'todas' ? 'selected' : '' ?>>Todos los estados</option>
                    <option value="abierto" <?= $filtro_estado === 'abierto' ? 'selected' : '' ?>>Abierto</option>
                    <option value="en_proceso" <?= $filtro_estado === 'en_proceso' ? 'selected' : '' ?>>En Proceso</option>
                    <option value="cerrado" <?= $filtro_estado === 'cerrado' ? 'selected' : '' ?>>Cerrado</option>
                    <option value="cancelado" <?= $filtro_estado === 'cancelado' ? 'selected' : '' ?>>Cancelado</option>
                </select>
            </div>

            <div class="filtro-grupo">
                <label>Prioridad:</label>
                <select id="filtro-prioridad" onchange="aplicarFiltros()">
                    <option value="todas" <?= $filtro_prioridad === 'todas' ? 'selected' : '' ?>>Todas las prioridades</option>
                    <option value="urgente" <?= $filtro_prioridad === 'urgente' ? 'selected' : '' ?>>Urgente</option>
                    <option value="alta" <?= $filtro_prioridad === 'alta' ? 'selected' : '' ?>>Alta</option>
                    <option value="media" <?= $filtro_prioridad === 'media' ? 'selected' : '' ?>>Media</option>
                    <option value="baja" <?= $filtro_prioridad === 'baja' ? 'selected' : '' ?>>Baja</option>
                </select>
            </div>

            <div class="filtro-grupo">
                <label>Plantel:</label>
                <select id="filtro-plantel" onchange="aplicarFiltros()">
                    <option value="todos" <?= $filtro_plantel === 'todos' ? 'selected' : '' ?>>Todos los planteles</option>
                    <option value="el_zapote" <?= $filtro_plantel === 'el_zapote' ? 'selected' : '' ?>>El Zapote</option>
                    <option value="insurgentes" <?= $filtro_plantel === 'insurgentes' ? 'selected' : '' ?>>Insurgentes</option>
                    <option value="lindavista" <?= $filtro_plantel === 'lindavista' ? 'selected' : '' ?>>Lindavista</option>
                </select>
            </div>

            <div class="filtro-grupo">
                <button class="btn btn-secondary" onclick="limpiarFiltros()">
                    <i class="fas fa-eraser"></i> Limpiar
                </button>
            </div>
        </div>

        <button class="btn btn-outline-primary filtros-toggle" onclick="toggleFiltros()">
            <i class="fas fa-filter"></i> Filtros Avanzados
            <i class="fas fa-chevron-down toggle-icon"></i>
        </button>
    </div>

    <!-- Lista de Tickets -->
    <div class="tickets-lista">
        <?php if (empty($tickets_filtrados)): ?>
        <div class="empty-state">
            <div class="empty-icon">
                <i class="fas fa-inbox"></i>
            </div>
            <h3>No se encontraron tickets</h3>
            <p>No hay tickets que coincidan con los filtros aplicados.</p>
            <button class="btn btn-primary" onclick="location.href='?section=crear_ticket'">
                <i class="fas fa-plus"></i> Crear Primer Ticket
            </button>
        </div>
        <?php else: ?>
            <?php foreach ($tickets_filtrados as $ticket): ?>
            <div class="ticket-item" onclick="verTicket('<?= $ticket['id'] ?>')">
                <div class="ticket-header">
                    <div class="ticket-id-titulo">
                        <div class="ticket-id"><?= $ticket['id'] ?></div>
                        <h3 class="ticket-titulo"><?= $ticket['titulo'] ?></h3>
                    </div>
                    
                    <div class="ticket-badges">
                        <span class="badge badge-<?= obtenerColorPrioridad($ticket['prioridad']) ?>">
                            <?= ucfirst($ticket['prioridad']) ?>
                        </span>
                        <span class="badge badge-<?= obtenerColorEstado($ticket['estado']) ?>">
                            <?= ucfirst(str_replace('_', ' ', $ticket['estado'])) ?>
                        </span>
                    </div>
                </div>

                <div class="ticket-descripcion">
                    <?= substr($ticket['descripcion'], 0, 150) ?><?= strlen($ticket['descripcion']) > 150 ? '...' : '' ?>
                </div>

                <div class="ticket-metadata">
                    <div class="metadata-left">
                        <div class="metadata-item">
                            <i class="fas fa-tag"></i>
                            <span><?= $categorias[$ticket['categoria']]['nombre'] ?></span>
                        </div>
                        <div class="metadata-item">
                            <i class="fas fa-building"></i>
                            <span><?= ucfirst(str_replace('_', ' ', $ticket['plantel'])) ?></span>
                        </div>
                        <div class="metadata-item">
                            <i class="fas fa-user"></i>
                            <span>Creado por: <?= $ticket['creado_por'] ?></span>
                        </div>
                        <div class="metadata-item">
                            <i class="fas fa-user-tie"></i>
                            <span>Asignado a: <?= $ticket['asignado_a'] ?></span>
                        </div>
                    </div>
                    
                    <div class="metadata-right">
                        <div class="metadata-item">
                            <i class="fas fa-clock"></i>
                            <span>Creado: <?= formatearFecha($ticket['fecha_creacion']) ?></span>
                        </div>
                        <div class="metadata-item">
                            <i class="fas fa-sync-alt"></i>
                            <span>Actualizado: <?= formatearFecha($ticket['ultima_actualizacion']) ?></span>
                        </div>
                        <div class="metadata-item">
                            <i class="fas fa-comments"></i>
                            <span><?= $ticket['respuestas'] ?> respuesta(s)</span>
                        </div>
                        <div class="ticket-actions">
                            <button class="btn-icon" onclick="event.stopPropagation(); editarTicket('<?= $ticket['id'] ?>')" title="Editar">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn-icon" onclick="event.stopPropagation(); asignarTicket('<?= $ticket['id'] ?>')" title="Asignar">
                                <i class="fas fa-user-plus"></i>
                            </button>
                            <button class="btn-icon" onclick="event.stopPropagation(); archivarTicket('<?= $ticket['id'] ?>')" title="Archivar">
                                <i class="fas fa-archive"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <!-- Paginación (si fuera necesaria) -->
    <div class="paginacion" style="display: none;">
        <button class="btn btn-outline-secondary">
            <i class="fas fa-chevron-left"></i> Anterior
        </button>
        <span class="pagina-info">Página 1 de 1</span>
        <button class="btn btn-outline-secondary">
            Siguiente <i class="fas fa-chevron-right"></i>
        </button>
    </div>
</div>

<!-- ===================== ESTILOS ESPECÍFICOS ===================== -->
<style>
    .categorias-tickets {
        animation: fadeIn 0.5s ease;
    }

    .categorias-header {
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

    .category-tabs {
        display: flex;
        gap: 0.5rem;
        margin-bottom: 2rem;
        overflow-x: auto;
        padding-bottom: 0.5rem;
    }

    .category-tab {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 1rem 1.5rem;
        background: var(--white);
        border: 2px solid var(--gray-300);
        border-radius: var(--border-radius);
        cursor: pointer;
        transition: var(--transition);
        white-space: nowrap;
        position: relative;
    }

    .category-tab:hover {
        border-color: var(--primary-color);
        background: var(--primary-light);
    }

    .category-tab.active {
        background: var(--primary-color);
        color: var(--white);
        border-color: var(--primary-color);
    }

    .tab-badge {
        padding: 0.25rem 0.5rem;
        border-radius: 12px;
        font-size: 0.8rem;
        font-weight: 600;
        margin-left: auto;
    }

    .category-tab.active .tab-badge {
        background: rgba(255, 255, 255, 0.2);
        color: var(--white);
    }

    .badge-primary { background: var(--primary-light); color: var(--primary-color); }
    .badge-info { background: var(--info-light); color: var(--info-color); }
    .badge-warning { background: var(--warning-light); color: var(--warning-color); }
    .badge-success { background: var(--success-light); color: var(--success-color); }
    .badge-danger { background: var(--danger-light); color: var(--danger-color); }
    .badge-secondary { background: var(--gray-200); color: var(--gray-700); }

    .filtros-container {
        background: var(--white);
        padding: 1.5rem;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        margin-bottom: 2rem;
    }

    .filtros-toggle {
        width: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 0.5rem;
    }

    .toggle-icon {
        transition: transform 0.3s ease;
    }

    .filtros-expandibles {
        display: none;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .filtros-expandibles.active {
        display: grid;
    }

    .filtros-expandibles.active + .filtros-toggle .toggle-icon {
        transform: rotate(180deg);
    }

    .filtro-grupo {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .filtro-grupo label {
        font-weight: 600;
        color: var(--gray-700);
        font-size: 0.9rem;
    }

    .filtro-grupo select {
        padding: 0.5rem;
        border: 2px solid var(--gray-300);
        border-radius: var(--border-radius);
        font-size: 0.9rem;
    }

    .tickets-lista {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .ticket-item {
        background: var(--white);
        padding: 2rem;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        cursor: pointer;
        transition: var(--transition);
        border-left: 4px solid var(--gray-300);
    }

    .ticket-item:hover {
        box-shadow: var(--shadow-hover);
        transform: translateY(-2px);
        border-left-color: var(--primary-color);
    }

    .ticket-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1rem;
    }

    .ticket-id-titulo {
        flex: 1;
    }

    .ticket-id {
        font-size: 0.9rem;
        color: var(--primary-color);
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .ticket-titulo {
        margin: 0;
        color: var(--dark);
        font-size: 1.2rem;
        line-height: 1.4;
    }

    .ticket-badges {
        display: flex;
        gap: 0.5rem;
        flex-shrink: 0;
    }

    .badge {
        padding: 0.25rem 0.75rem;
        border-radius: 12px;
        font-size: 0.8rem;
        font-weight: 600;
    }

    .ticket-descripcion {
        color: var(--gray-600);
        line-height: 1.6;
        margin-bottom: 1.5rem;
    }

    .ticket-metadata {
        display: grid;
        grid-template-columns: 1fr auto;
        gap: 2rem;
        align-items: end;
    }

    .metadata-left,
    .metadata-right {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .metadata-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.9rem;
        color: var(--gray-600);
    }

    .metadata-item i {
        width: 16px;
        color: var(--primary-color);
    }

    .ticket-actions {
        display: flex;
        gap: 0.5rem;
        margin-top: 0.5rem;
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
        background: var(--white);
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
    }

    .empty-icon {
        font-size: 4rem;
        color: var(--gray-400);
        margin-bottom: 1.5rem;
    }

    .empty-state h3 {
        color: var(--gray-700);
        margin-bottom: 1rem;
    }

    .empty-state p {
        color: var(--gray-600);
        margin-bottom: 2rem;
    }

    .paginacion {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 1rem;
        margin-top: 2rem;
        padding: 1.5rem;
        background: var(--white);
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
    }

    .pagina-info {
        color: var(--gray-600);
        font-weight: 500;
    }

    @media (max-width: 768px) {
        .categorias-header {
            flex-direction: column;
            gap: 1rem;
        }

        .header-actions {
            width: 100%;
            justify-content: center;
        }

        .category-tabs {
            flex-direction: column;
            gap: 0.5rem;
        }

        .ticket-metadata {
            grid-template-columns: 1fr;
            gap: 1rem;
        }

        .ticket-actions {
            justify-content: center;
        }

        .filtros-expandibles {
            grid-template-columns: 1fr;
        }
    }
</style>

<!-- ===================== SCRIPTS ESPECÍFICOS ===================== -->
<script>
    // Cambiar categoría
    function cambiarCategoria(categoria) {
        const params = new URLSearchParams(window.location.search);
        params.set('cat', categoria);
        window.location.search = params.toString();
    }

    // Toggle filtros
    function toggleFiltros() {
        const filtros = document.getElementById('filtros-expandibles');
        filtros.classList.toggle('active');
    }

    // Aplicar filtros
    function aplicarFiltros() {
        const params = new URLSearchParams(window.location.search);
        
        const estado = document.getElementById('filtro-estado').value;
        const prioridad = document.getElementById('filtro-prioridad').value;
        const plantel = document.getElementById('filtro-plantel').value;
        
        if (estado !== 'todas') params.set('estado', estado);
        else params.delete('estado');
        
        if (prioridad !== 'todas') params.set('prioridad', prioridad);
        else params.delete('prioridad');
        
        if (plantel !== 'todos') params.set('plantel', plantel);
        else params.delete('plantel');
        
        window.location.search = params.toString();
    }

    // Limpiar filtros
    function limpiarFiltros() {
        const params = new URLSearchParams(window.location.search);
        params.delete('estado');
        params.delete('prioridad');
        params.delete('plantel');
        window.location.search = params.toString();
    }

    // Actualizar vista
    function actualizarVista() {
        showNotification('Actualizando vista...', 'info');
        setTimeout(() => {
            location.reload();
        }, 1000);
    }

    // Ver ticket
    function verTicket(ticketId) {
        window.location.href = `?section=ver_ticket&id=${ticketId}`;
    }

    // Editar ticket
    function editarTicket(ticketId) {
        window.location.href = `?section=editar_ticket&id=${ticketId}`;
    }

    // Asignar ticket
    function asignarTicket(ticketId) {
        showNotification('Abriendo asignación de ticket...', 'info');
        // Aquí iría la lógica para asignar ticket
    }

    // Archivar ticket
    function archivarTicket(ticketId) {
        if (confirm('¿Estás seguro de que quieres archivar este ticket?')) {
            showNotification('Ticket archivado correctamente', 'success');
            // Aquí iría la lógica para archivar
        }
    }

    // Inicialización
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-actualizar cada 5 minutos
        setInterval(function() {
            console.log('Auto-actualizando vista de tickets...');
            // Aquí iría la lógica de auto-actualización sin reload
        }, 300000); // 5 minutos
    });
</script>
