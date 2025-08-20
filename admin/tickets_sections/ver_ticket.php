<?php
// Obtener ID del ticket
$ticket_id = $_GET['id'] ?? 'TK-2024-0001';

// Datos de ejemplo del ticket (normalmente vendría de la base de datos)
$ticket = [
    'id' => $ticket_id,
    'titulo' => 'Problema con proyector en Aula 3B',
    'categoria' => 'tecnologia',
    'prioridad' => 'alta',
    'estado' => 'en_proceso',
    'plantel' => 'el_zapote',
    'creado_por' => [
        'nombre' => 'María González',
        'rol' => 'Maestra de Primaria',
        'email' => 'maria.gonzalez@iefk.edu.mx'
    ],
    'asignado_a' => [
        'nombre' => 'Carlos Técnico',
        'rol' => 'Soporte Técnico',
        'email' => 'soporte@iefk.edu.mx'
    ],
    'fecha_creacion' => '2024-01-15 08:30:00',
    'fecha_limite' => '2024-01-16 18:00:00',
    'ultima_actualizacion' => '2024-01-15 14:20:00',
    'descripcion' => 'El proyector del aula 3B no enciende desde esta mañana. He intentado verificar las conexiones y cambiar el cable HDMI pero el problema persiste. Las clases de matemáticas de 4to grado se están viendo afectadas y necesitamos una solución urgente.',
    'pasos_reproducir' => '1. Encender el proyector con el botón de encendido\n2. Conectar laptop con cable HDMI\n3. El proyector no muestra ninguna imagen\n4. La luz de encendido parpadea en rojo',
    'impacto' => 'Las clases de matemáticas de 4to grado no pueden utilizar el material visual programado. Aproximadamente 25 estudiantes afectados.',
    'personas_involucradas' => 'Estudiantes de 4to grado grupo A, Maestra María González',
    'archivos' => [
        [
            'nombre' => 'foto_proyector.jpg',
            'tipo' => 'image/jpeg',
            'tamaño' => '2.3 MB',
            'fecha' => '2024-01-15 08:35:00'
        ],
        [
            'nombre' => 'manual_proyector.pdf',
            'tipo' => 'application/pdf',
            'tamaño' => '1.8 MB',
            'fecha' => '2024-01-15 08:40:00'
        ]
    ]
];

// Historial de seguimiento
$seguimiento = [
    [
        'id' => 1,
        'usuario' => 'María González',
        'rol' => 'Maestra de Primaria',
        'accion' => 'creacion',
        'fecha' => '2024-01-15 08:30:00',
        'descripcion' => 'Ticket creado',
        'detalles' => 'Se reporta problema con proyector del aula 3B'
    ],
    [
        'id' => 2,
        'usuario' => 'Sistema',
        'rol' => 'Automático',
        'accion' => 'asignacion',
        'fecha' => '2024-01-15 08:32:00',
        'descripcion' => 'Ticket asignado automáticamente',
        'detalles' => 'Asignado a Carlos Técnico del departamento de Soporte Técnico'
    ],
    [
        'id' => 3,
        'usuario' => 'Carlos Técnico',
        'rol' => 'Soporte Técnico',
        'accion' => 'comentario',
        'fecha' => '2024-01-15 09:15:00',
        'descripcion' => 'Primer diagnóstico',
        'detalles' => 'He revisado el reporte. Iré al aula 3B en cuanto termine con el ticket actual. Tiempo estimado: 1 hora.'
    ],
    [
        'id' => 4,
        'usuario' => 'Carlos Técnico',
        'rol' => 'Soporte Técnico',
        'accion' => 'estado',
        'fecha' => '2024-01-15 10:30:00',
        'descripcion' => 'Estado cambiado a En Proceso',
        'detalles' => 'Iniciando revisión física del equipo en el aula'
    ],
    [
        'id' => 5,
        'usuario' => 'Carlos Técnico',
        'rol' => 'Soporte Técnico',
        'accion' => 'comentario',
        'fecha' => '2024-01-15 11:00:00',
        'descripcion' => 'Diagnóstico preliminar',
        'detalles' => 'El problema parece ser la lámpara del proyector. Voy a verificar las horas de uso y revisar si tenemos una de repuesto en almacén.'
    ],
    [
        'id' => 6,
        'usuario' => 'Carlos Técnico',
        'rol' => 'Soporte Técnico',
        'accion' => 'comentario',
        'fecha' => '2024-01-15 14:20:00',
        'descripción' => 'Actualización de progreso',
        'detalles' => 'Confirmado: la lámpara está quemada (3,200 horas de uso). He solicitado una lámpara nueva al proveedor. Llegará mañana por la mañana. Mientras tanto, he trasladado un proyector portátil al aula.'
    ]
];

// Función para obtener icono según el tipo de acción
function obtenerIconoAccion($accion) {
    switch($accion) {
        case 'creacion': return 'fas fa-plus-circle text-primary';
        case 'asignacion': return 'fas fa-user-plus text-info';
        case 'comentario': return 'fas fa-comment text-warning';
        case 'estado': return 'fas fa-exchange-alt text-success';
        case 'archivo': return 'fas fa-paperclip text-secondary';
        case 'cierre': return 'fas fa-check-circle text-success';
        default: return 'fas fa-circle text-gray';
    }
}

function formatearFecha($fecha) {
    return date('d/m/Y H:i', strtotime($fecha));
}

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
?>

<!-- ===================== VER TICKET ===================== -->
<div class="ver-ticket">
    <!-- Header del Ticket -->
    <div class="ticket-header-completo">
        <div class="header-left">
            <div class="ticket-id-badge"><?= $ticket['id'] ?></div>
            <div class="header-info">
                <h1><?= $ticket['titulo'] ?></h1>
                <div class="header-meta">
                    <span><i class="fas fa-calendar"></i> Creado: <?= formatearFecha($ticket['fecha_creacion']) ?></span>
                    <span><i class="fas fa-clock"></i> Última actualización: <?= formatearFecha($ticket['ultima_actualizacion']) ?></span>
                    <?php if (isset($ticket['fecha_limite'])): ?>
                    <span><i class="fas fa-exclamation-triangle"></i> Fecha límite: <?= formatearFecha($ticket['fecha_limite']) ?></span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <div class="header-right">
            <div class="ticket-badges-principales">
                <span class="badge badge-<?= obtenerColorPrioridad($ticket['prioridad']) ?> badge-lg">
                    <i class="fas fa-flag"></i> <?= ucfirst($ticket['prioridad']) ?>
                </span>
                <span class="badge badge-<?= obtenerColorEstado($ticket['estado']) ?> badge-lg">
                    <i class="fas fa-circle"></i> <?= ucfirst(str_replace('_', ' ', $ticket['estado'])) ?>
                </span>
            </div>
            
            <div class="header-actions">
                <button class="btn btn-outline-secondary" onclick="imprimirTicket()">
                    <i class="fas fa-print"></i> Imprimir
                </button>
                <button class="btn btn-outline-primary" onclick="editarTicket('<?= $ticket['id'] ?>')">
                    <i class="fas fa-edit"></i> Editar
                </button>
                <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle" onclick="toggleDropdown('acciones-dropdown')">
                        <i class="fas fa-cog"></i> Acciones
                    </button>
                    <div class="dropdown-menu" id="acciones-dropdown">
                        <a href="#" onclick="cambiarEstado()"><i class="fas fa-exchange-alt"></i> Cambiar Estado</a>
                        <a href="#" onclick="reasignarTicket()"><i class="fas fa-user-plus"></i> Reasignar</a>
                        <a href="#" onclick="duplicarTicket()"><i class="fas fa-copy"></i> Duplicar</a>
                        <a href="#" onclick="archivarTicket()"><i class="fas fa-archive"></i> Archivar</a>
                        <div class="dropdown-divider"></div>
                        <a href="#" onclick="eliminarTicket()" class="text-danger"><i class="fas fa-trash"></i> Eliminar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Contenido Principal -->
    <div class="ticket-contenido">
        <!-- Información del Ticket -->
        <div class="ticket-info-section">
            <h3><i class="fas fa-info-circle"></i> Información del Ticket</h3>
            
            <div class="info-grid">
                <div class="info-item">
                    <label>Categoría:</label>
                    <span class="categoria-badge">
                        <i class="fas fa-laptop"></i> Tecnología
                    </span>
                </div>
                
                <div class="info-item">
                    <label>Plantel:</label>
                    <span><i class="fas fa-building"></i> <?= ucfirst(str_replace('_', ' ', $ticket['plantel'])) ?></span>
                </div>
                
                <div class="info-item">
                    <label>Creado por:</label>
                    <div class="usuario-info">
                        <div class="usuario-avatar">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="usuario-detalles">
                            <div class="usuario-nombre"><?= $ticket['creado_por']['nombre'] ?></div>
                            <div class="usuario-rol"><?= $ticket['creado_por']['rol'] ?></div>
                        </div>
                    </div>
                </div>
                
                <div class="info-item">
                    <label>Asignado a:</label>
                    <div class="usuario-info">
                        <div class="usuario-avatar">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <div class="usuario-detalles">
                            <div class="usuario-nombre"><?= $ticket['asignado_a']['nombre'] ?></div>
                            <div class="usuario-rol"><?= $ticket['asignado_a']['rol'] ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Descripción -->
        <div class="ticket-descripcion-section">
            <h3><i class="fas fa-file-alt"></i> Descripción</h3>
            <div class="descripcion-contenido">
                <?= nl2br($ticket['descripcion']) ?>
            </div>
        </div>

        <!-- Detalles Adicionales -->
        <?php if (!empty($ticket['pasos_reproducir']) || !empty($ticket['impacto']) || !empty($ticket['personas_involucradas'])): ?>
        <div class="ticket-detalles-section">
            <h3><i class="fas fa-list-ul"></i> Detalles Adicionales</h3>
            
            <?php if (!empty($ticket['pasos_reproducir'])): ?>
            <div class="detalle-item">
                <h4>Pasos para Reproducir:</h4>
                <div class="detalle-contenido">
                    <?= nl2br($ticket['pasos_reproducir']) ?>
                </div>
            </div>
            <?php endif; ?>
            
            <?php if (!empty($ticket['impacto'])): ?>
            <div class="detalle-item">
                <h4>Impacto:</h4>
                <div class="detalle-contenido">
                    <?= nl2br($ticket['impacto']) ?>
                </div>
            </div>
            <?php endif; ?>
            
            <?php if (!empty($ticket['personas_involucradas'])): ?>
            <div class="detalle-item">
                <h4>Personas Involucradas:</h4>
                <div class="detalle-contenido">
                    <?= nl2br($ticket['personas_involucradas']) ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <!-- Archivos Adjuntos -->
        <?php if (!empty($ticket['archivos'])): ?>
        <div class="ticket-archivos-section">
            <h3><i class="fas fa-paperclip"></i> Archivos Adjuntos</h3>
            <div class="archivos-lista">
                <?php foreach ($ticket['archivos'] as $archivo): ?>
                <div class="archivo-item">
                    <div class="archivo-icon">
                        <?php if (strpos($archivo['tipo'], 'image') !== false): ?>
                            <i class="fas fa-image"></i>
                        <?php elseif (strpos($archivo['tipo'], 'pdf') !== false): ?>
                            <i class="fas fa-file-pdf"></i>
                        <?php else: ?>
                            <i class="fas fa-file"></i>
                        <?php endif; ?>
                    </div>
                    <div class="archivo-info">
                        <div class="archivo-nombre"><?= $archivo['nombre'] ?></div>
                        <div class="archivo-meta">
                            <?= $archivo['tamaño'] ?> • <?= formatearFecha($archivo['fecha']) ?>
                        </div>
                    </div>
                    <div class="archivo-acciones">
                        <button class="btn-icon" onclick="descargarArchivo('<?= $archivo['nombre'] ?>')" title="Descargar">
                            <i class="fas fa-download"></i>
                        </button>
                        <button class="btn-icon" onclick="previsualizarArchivo('<?= $archivo['nombre'] ?>')" title="Ver">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <!-- Seguimiento y Comentarios -->
    <div class="ticket-seguimiento">
        <div class="seguimiento-header">
            <h3><i class="fas fa-history"></i> Seguimiento del Ticket</h3>
            <button class="btn btn-primary" onclick="agregarComentario()">
                <i class="fas fa-comment-plus"></i> Agregar Comentario
            </button>
        </div>

        <div class="seguimiento-timeline">
            <?php foreach (array_reverse($seguimiento) as $evento): ?>
            <div class="timeline-item">
                <div class="timeline-marker">
                    <i class="<?= obtenerIconoAccion($evento['accion']) ?>"></i>
                </div>
                <div class="timeline-content">
                    <div class="timeline-header">
                        <div class="timeline-usuario">
                            <strong><?= $evento['usuario'] ?></strong>
                            <span class="timeline-rol"><?= $evento['rol'] ?></span>
                        </div>
                        <div class="timeline-fecha">
                            <?= formatearFecha($evento['fecha']) ?>
                        </div>
                    </div>
                    <div class="timeline-descripcion">
                        <strong><?= $evento['descripcion'] ?></strong>
                    </div>
                    <div class="timeline-detalles">
                        <?= nl2br($evento['detalles']) ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Formulario para nuevo comentario -->
        <div class="nuevo-comentario" id="form-comentario" style="display: none;">
            <div class="comentario-header">
                <h4>Agregar Comentario</h4>
                <button class="btn btn-outline-secondary" onclick="cancelarComentario()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <form onsubmit="enviarComentario(event)">
                <div class="form-group">
                    <label for="tipo-comentario">Tipo de Actualización:</label>
                    <select id="tipo-comentario" required>
                        <option value="">Selecciona un tipo...</option>
                        <option value="comentario">Comentario General</option>
                        <option value="progreso">Actualización de Progreso</option>
                        <option value="solucion">Propuesta de Solución</option>
                        <option value="estado">Cambio de Estado</option>
                        <option value="derivacion">Derivación</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="comentario-texto">Comentario:</label>
                    <textarea id="comentario-texto" rows="5" placeholder="Describe la actualización, progreso o comentario..." required></textarea>
                </div>
                
                <div class="form-group">
                    <label>
                        <input type="checkbox" id="notificar-usuarios"> 
                        Notificar a usuarios involucrados
                    </label>
                </div>
                
                <div class="comentario-actions">
                    <button type="button" class="btn btn-secondary" onclick="cancelarComentario()">
                        Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-paper-plane"></i> Enviar Comentario
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ===================== ESTILOS ESPECÍFICOS ===================== -->
<style>
    .ver-ticket {
        animation: fadeIn 0.5s ease;
        max-width: 1200px;
        margin: 0 auto;
    }

    .ticket-header-completo {
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

    .header-left {
        display: flex;
        align-items: flex-start;
        gap: 1.5rem;
        flex: 1;
    }

    .ticket-id-badge {
        background: var(--primary-color);
        color: var(--white);
        padding: 1rem 1.5rem;
        border-radius: var(--border-radius);
        font-weight: 600;
        font-size: 1.1rem;
        white-space: nowrap;
    }

    .header-info h1 {
        margin: 0 0 1rem 0;
        color: var(--dark);
        font-size: 1.5rem;
        line-height: 1.3;
    }

    .header-meta {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
        font-size: 0.9rem;
        color: var(--gray-600);
    }

    .header-meta span {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .header-right {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 1.5rem;
    }

    .ticket-badges-principales {
        display: flex;
        gap: 0.75rem;
    }

    .badge-lg {
        padding: 0.75rem 1.25rem;
        font-size: 0.95rem;
        font-weight: 600;
        border-radius: var(--border-radius);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .header-actions {
        display: flex;
        gap: 1rem;
        position: relative;
    }

    .dropdown {
        position: relative;
    }

    .dropdown-menu {
        display: none;
        position: absolute;
        top: 100%;
        right: 0;
        background: var(--white);
        border: 1px solid var(--gray-300);
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        min-width: 200px;
        z-index: 1000;
        margin-top: 0.5rem;
    }

    .dropdown-menu.show {
        display: block;
    }

    .dropdown-menu a {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem 1rem;
        color: var(--dark);
        text-decoration: none;
        transition: var(--transition);
    }

    .dropdown-menu a:hover {
        background: var(--gray-100);
    }

    .dropdown-divider {
        height: 1px;
        background: var(--gray-300);
        margin: 0.5rem 0;
    }

    .ticket-contenido {
        display: grid;
        gap: 2rem;
        margin-bottom: 2rem;
    }

    .ticket-info-section,
    .ticket-descripcion-section,
    .ticket-detalles-section,
    .ticket-archivos-section {
        background: var(--white);
        padding: 2rem;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
    }

    .ticket-info-section h3,
    .ticket-descripcion-section h3,
    .ticket-detalles-section h3,
    .ticket-archivos-section h3 {
        color: var(--primary-color);
        margin-bottom: 1.5rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid var(--primary-light);
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
    }

    .info-item {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    .info-item label {
        font-weight: 600;
        color: var(--gray-700);
        font-size: 0.9rem;
    }

    .categoria-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: var(--info-light);
        color: var(--info-color);
        padding: 0.5rem 1rem;
        border-radius: var(--border-radius);
        font-weight: 500;
    }

    .usuario-info {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .usuario-avatar {
        width: 50px;
        height: 50px;
        background: var(--primary-light);
        color: var(--primary-color);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
    }

    .usuario-nombre {
        font-weight: 600;
        color: var(--dark);
    }

    .usuario-rol {
        font-size: 0.9rem;
        color: var(--gray-600);
    }

    .descripcion-contenido {
        background: var(--gray-50);
        padding: 1.5rem;
        border-radius: var(--border-radius);
        border-left: 4px solid var(--primary-color);
        line-height: 1.7;
        color: var(--gray-700);
    }

    .detalle-item {
        margin-bottom: 1.5rem;
    }

    .detalle-item:last-child {
        margin-bottom: 0;
    }

    .detalle-item h4 {
        color: var(--primary-color);
        margin-bottom: 0.75rem;
        font-size: 1rem;
    }

    .detalle-contenido {
        background: var(--gray-50);
        padding: 1rem;
        border-radius: var(--border-radius);
        border-left: 3px solid var(--gray-400);
        line-height: 1.6;
        color: var(--gray-700);
    }

    .archivos-lista {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .archivo-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem;
        background: var(--gray-50);
        border-radius: var(--border-radius);
        border: 1px solid var(--gray-300);
    }

    .archivo-icon {
        font-size: 2rem;
        color: var(--primary-color);
        width: 50px;
        text-align: center;
    }

    .archivo-info {
        flex: 1;
    }

    .archivo-nombre {
        font-weight: 600;
        color: var(--dark);
        margin-bottom: 0.25rem;
    }

    .archivo-meta {
        font-size: 0.9rem;
        color: var(--gray-600);
    }

    .archivo-acciones {
        display: flex;
        gap: 0.5rem;
    }

    .ticket-seguimiento {
        background: var(--white);
        padding: 2rem;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
    }

    .seguimiento-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid var(--primary-light);
    }

    .seguimiento-header h3 {
        color: var(--primary-color);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .seguimiento-timeline {
        position: relative;
        padding-left: 2rem;
    }

    .seguimiento-timeline::before {
        content: '';
        position: absolute;
        left: 1rem;
        top: 0;
        bottom: 0;
        width: 2px;
        background: var(--gray-300);
    }

    .timeline-item {
        position: relative;
        margin-bottom: 2rem;
        background: var(--gray-50);
        border-radius: var(--border-radius);
        padding: 1.5rem;
        margin-left: 1rem;
    }

    .timeline-marker {
        position: absolute;
        left: -2.5rem;
        top: 1.5rem;
        width: 2rem;
        height: 2rem;
        background: var(--white);
        border: 3px solid var(--primary-color);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.8rem;
    }

    .timeline-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 0.75rem;
    }

    .timeline-usuario {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }

    .timeline-rol {
        font-size: 0.8rem;
        color: var(--gray-600);
        font-weight: normal;
    }

    .timeline-fecha {
        font-size: 0.9rem;
        color: var(--gray-600);
    }

    .timeline-descripcion {
        margin-bottom: 0.5rem;
        color: var(--primary-color);
    }

    .timeline-detalles {
        color: var(--gray-700);
        line-height: 1.6;
    }

    .nuevo-comentario {
        margin-top: 2rem;
        padding: 1.5rem;
        background: var(--gray-50);
        border-radius: var(--border-radius);
        border: 2px dashed var(--primary-color);
    }

    .comentario-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }

    .comentario-header h4 {
        margin: 0;
        color: var(--primary-color);
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 600;
        color: var(--gray-700);
    }

    .form-group select,
    .form-group textarea {
        width: 100%;
        padding: 0.75rem;
        border: 2px solid var(--gray-300);
        border-radius: var(--border-radius);
        font-size: 1rem;
    }

    .form-group select:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: var(--primary-color);
    }

    .comentario-actions {
        display: flex;
        justify-content: flex-end;
        gap: 1rem;
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

    @media (max-width: 768px) {
        .ticket-header-completo {
            flex-direction: column;
            gap: 1.5rem;
        }

        .header-left {
            flex-direction: column;
            gap: 1rem;
        }

        .header-right {
            width: 100%;
            align-items: center;
        }

        .ticket-badges-principales {
            flex-direction: column;
            width: 100%;
        }

        .header-actions {
            flex-direction: column;
            width: 100%;
        }

        .info-grid {
            grid-template-columns: 1fr;
        }

        .timeline-header {
            flex-direction: column;
            gap: 0.5rem;
        }

        .comentario-actions {
            flex-direction: column;
        }
    }
</style>

<!-- ===================== SCRIPTS ESPECÍFICOS ===================== -->
<script>
    // Toggle dropdown
    function toggleDropdown(id) {
        const dropdown = document.getElementById(id);
        dropdown.classList.toggle('show');
        
        // Cerrar otros dropdowns
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.dropdown')) {
                dropdown.classList.remove('show');
            }
        });
    }

    // Funciones de acción
    function imprimirTicket() {
        window.print();
    }

    function editarTicket(ticketId) {
        window.location.href = `?section=editar_ticket&id=${ticketId}`;
    }

    function cambiarEstado() {
        showNotification('Abriendo cambio de estado...', 'info');
        // Aquí iría la lógica para cambiar estado
    }

    function reasignarTicket() {
        showNotification('Abriendo reasignación...', 'info');
        // Aquí iría la lógica para reasignar
    }

    function duplicarTicket() {
        if (confirm('¿Crear un nuevo ticket basado en este?')) {
            showNotification('Creando ticket duplicado...', 'info');
            // Aquí iría la lógica para duplicar
        }
    }

    function archivarTicket() {
        if (confirm('¿Archivar este ticket?')) {
            showNotification('Ticket archivado correctamente', 'success');
            // Aquí iría la lógica para archivar
        }
    }

    function eliminarTicket() {
        if (confirm('¿ELIMINAR permanentemente este ticket? Esta acción no se puede deshacer.')) {
            showNotification('Ticket eliminado', 'error');
            setTimeout(() => {
                window.location.href = '?section=categorias_tickets';
            }, 2000);
        }
    }

    // Funciones de archivos
    function descargarArchivo(nombre) {
        showNotification('Descargando archivo: ' + nombre, 'info');
        // Aquí iría la lógica para descargar
    }

    function previsualizarArchivo(nombre) {
        showNotification('Abriendo previsualización: ' + nombre, 'info');
        // Aquí iría la lógica para previsualizar
    }

    // Funciones de comentarios
    function agregarComentario() {
        const form = document.getElementById('form-comentario');
        form.style.display = 'block';
        form.scrollIntoView({ behavior: 'smooth' });
        document.getElementById('comentario-texto').focus();
    }

    function cancelarComentario() {
        const form = document.getElementById('form-comentario');
        form.style.display = 'none';
        form.querySelector('form').reset();
    }

    function enviarComentario(event) {
        event.preventDefault();
        
        const tipo = document.getElementById('tipo-comentario').value;
        const texto = document.getElementById('comentario-texto').value;
        const notificar = document.getElementById('notificar-usuarios').checked;
        
        if (!tipo || !texto) {
            showNotification('Por favor completa todos los campos', 'error');
            return;
        }
        
        showNotification('Enviando comentario...', 'info');
        
        // Simular envío
        setTimeout(() => {
            showNotification('Comentario agregado exitosamente', 'success');
            
            // Agregar nuevo evento al timeline
            const timeline = document.querySelector('.seguimiento-timeline');
            const nuevoEvento = document.createElement('div');
            nuevoEvento.className = 'timeline-item';
            nuevoEvento.innerHTML = `
                <div class="timeline-marker">
                    <i class="fas fa-comment text-warning"></i>
                </div>
                <div class="timeline-content">
                    <div class="timeline-header">
                        <div class="timeline-usuario">
                            <strong>Usuario Actual</strong>
                            <span class="timeline-rol">Tu Rol</span>
                        </div>
                        <div class="timeline-fecha">
                            ${new Date().toLocaleString('es-MX')}
                        </div>
                    </div>
                    <div class="timeline-descripcion">
                        <strong>${tipo.charAt(0).toUpperCase() + tipo.slice(1)}</strong>
                    </div>
                    <div class="timeline-detalles">
                        ${texto.replace(/\n/g, '<br>')}
                    </div>
                </div>
            `;
            
            timeline.insertBefore(nuevoEvento, timeline.firstChild);
            cancelarComentario();
            
        }, 1500);
    }

    // Inicialización
    document.addEventListener('DOMContentLoaded', function() {
        // Cerrar dropdowns al hacer clic fuera
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.dropdown')) {
                document.querySelectorAll('.dropdown-menu').forEach(menu => {
                    menu.classList.remove('show');
                });
            }
        });
    });
</script>
