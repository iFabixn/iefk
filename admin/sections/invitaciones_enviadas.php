
<?php
// 🔒 Conexión a la base de datos
include('../db.php');

// � CONFIGURACIÓN DE PAGINACIÓN
$registros_por_pagina = 5; // Puedes cambiar esto a 25, 50, etc.
$pagina_actual = isset($_GET['pagina']) ? max(1, intval($_GET['pagina'])) : 1;
$offset = ($pagina_actual - 1) * $registros_por_pagina;

// 🔍 FILTROS DE BÚSQUEDA
$filtro_busqueda = isset($_GET['busqueda']) ? trim($_GET['busqueda']) : '';
$filtro_estado = isset($_GET['estado']) ? $_GET['estado'] : '';
$filtro_fecha = isset($_GET['fecha']) ? $_GET['fecha'] : '';

// 🏗️ CONSTRUIR CONDICIONES WHERE
$where_conditions = [];
$params = [];
$types = '';

// Filtro de búsqueda
if (!empty($filtro_busqueda)) {
    $where_conditions[] = "(ta.tutor_nombre LIKE ? OR ta.tutor_email LIKE ?)";
    $busqueda_param = '%' . $filtro_busqueda . '%';
    $params[] = $busqueda_param;
    $params[] = $busqueda_param;
    $types .= 'ss';
}

// Filtro de estado
if (!empty($filtro_estado)) {
    switch($filtro_estado) {
        case 'enviado':
            $where_conditions[] = "(ta.usado = 0 AND ta.expirado = 0)";
            break;
        case 'ingresado':
            $where_conditions[] = "(ta.usado = 1 AND pf.id IS NOT NULL)";
            break;
        case 'expirado':
            $where_conditions[] = "ta.expirado = 1";
            break;
    }
}

// Filtro de fecha
if (!empty($filtro_fecha)) {
    switch($filtro_fecha) {
        case 'hoy':
            $where_conditions[] = "DATE(ta.fecha_creacion) = CURDATE()";
            break;
        case 'semana':
            $where_conditions[] = "ta.fecha_creacion >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)";
            break;
        case 'mes':
            $where_conditions[] = "ta.fecha_creacion >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)";
            break;
    }
}

$where_clause = !empty($where_conditions) ? 'WHERE ' . implode(' AND ', $where_conditions) : '';

// 📊 CONTAR TOTAL DE REGISTROS (para paginación)
$count_query = "
    SELECT COUNT(DISTINCT ta.id) as total
    FROM tokens_acceso ta
    LEFT JOIN padres_familia pf ON ta.tutor_email = pf.email
    LEFT JOIN menores_admision ma ON pf.id = ma.padre_id
    $where_clause
";

if (!empty($params)) {
    $count_stmt = $conn->prepare($count_query);
    if (!empty($types)) {
        $count_stmt->bind_param($types, ...$params);
    }
    $count_stmt->execute();
    $count_result = $count_stmt->get_result();
} else {
    $count_result = $conn->query($count_query);
}

$total_registros = $count_result->fetch_assoc()['total'];
$total_paginas = ceil($total_registros / $registros_por_pagina);

// 📊 Consulta principal con LIMIT para paginación
$query = "
    SELECT 
        ta.id,
        ta.token,
        ta.tutor_email,
        ta.tutor_nombre,
        ta.tutor_telefono,
        ta.tutor_parentesco,
        ta.fecha_creacion,
        ta.fecha_limite,
        ta.usado,
        ta.expirado,
        ta.fecha_usado,
        pf.id as padre_registrado,
        pf.ultimo_acceso,
        COUNT(ma.id) as total_menores
    FROM tokens_acceso ta
    LEFT JOIN padres_familia pf ON ta.tutor_email = pf.email
    LEFT JOIN menores_admision ma ON pf.id = ma.padre_id
    $where_clause
    GROUP BY ta.id
    ORDER BY ta.fecha_creacion DESC
    LIMIT ? OFFSET ?
";

// Preparar y ejecutar consulta principal
$params[] = $registros_por_pagina;
$params[] = $offset;
$types .= 'ii';

$stmt = $conn->prepare($query);
if (!empty($types)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();

$invitaciones = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $invitaciones[] = $row;
    }
}

// 📈 Estadísticas generales
$stats_query = "
    SELECT 
        COUNT(*) as total,
        SUM(CASE WHEN usado = 0 AND expirado = 0 THEN 1 ELSE 0 END) as enviadas,
        SUM(CASE WHEN usado = 1 THEN 1 ELSE 0 END) as ingresadas,
        SUM(CASE WHEN expirado = 1 THEN 1 ELSE 0 END) as expiradas
    FROM tokens_acceso
";
$stats_result = $conn->query($stats_query);
$stats = $stats_result->fetch_assoc();

// 📅 Estadísticas de hoy
$hoy_query = "
    SELECT COUNT(*) as completadas_hoy
    FROM tokens_acceso ta
    JOIN padres_familia pf ON ta.tutor_email = pf.email
    WHERE DATE(pf.fecha_registro) = CURDATE()
";
$hoy_result = $conn->query($hoy_query);
$hoy_stats = $hoy_result->fetch_assoc();

// 🔢 Calcular tasa de respuesta
$tasa_respuesta = $stats['total'] > 0 ? round(($stats['ingresadas'] / $stats['total']) * 100) : 0;
?>

<!-- ===================== INVITACIONES ENVIADAS ===================== -->
<div class="content-header">
    <h1 class="content-title">
        <i class="fas fa-envelope"></i>
        Invitaciones Enviadas
    </h1>
    <p class="content-description">
        Gestiona las invitaciones de admisión enviadas por correo electrónico. Puedes reenviar o eliminar invitaciones según su estado.
    </p>
</div>

<div class="content-body">
    <!-- Filtros y búsqueda -->
    <div style="background: var(--gray-100); padding: 1.5rem; border-radius: 8px; margin-bottom: 2rem;">
        <form method="GET" action="" id="filtrosForm">
            <!-- Mantener la sección actual -->
            <input type="hidden" name="section" value="invitaciones">
            
            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label" for="buscar_invitacion">
                        <i class="fas fa-search"></i> Buscar por nombre o email
                    </label>
                    <input type="text" id="buscar_invitacion" name="busqueda" class="form-input" 
                           placeholder="Buscar tutor..." value="<?= htmlspecialchars($filtro_busqueda) ?>">
                </div>
                
                <div class="form-group">
                    <label class="form-label" for="filtro_estado">
                        <i class="fas fa-filter"></i> Filtrar por estado
                    </label>
                    <select id="filtro_estado" name="estado" class="form-input">
                        <option value="">Todos los estados</option>
                        <option value="enviado" <?= $filtro_estado === 'enviado' ? 'selected' : '' ?>>Enviado</option>
                        <option value="ingresado" <?= $filtro_estado === 'ingresado' ? 'selected' : '' ?>>Ingresado</option>
                        <option value="expirado" <?= $filtro_estado === 'expirado' ? 'selected' : '' ?>>Expirado</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label" for="filtro_fecha">
                        <i class="fas fa-calendar"></i> Filtrar por fecha de envío
                    </label>
                    <select id="filtro_fecha" name="fecha" class="form-input">
                        <option value="">Todas las fechas</option>
                        <option value="hoy" <?= $filtro_fecha === 'hoy' ? 'selected' : '' ?>>Enviadas hoy</option>
                        <option value="semana" <?= $filtro_fecha === 'semana' ? 'selected' : '' ?>>Esta semana</option>
                        <option value="mes" <?= $filtro_fecha === 'mes' ? 'selected' : '' ?>>Este mes</option>
                    </select>
                </div>
                
                <div class="form-group" style="display: flex; align-items: end; gap: 0.5rem;">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i>
                        Filtrar
                    </button>
                    <a href="?section=invitaciones" class="btn btn-secondary">
                        <i class="fas fa-times"></i>
                        Limpiar
                    </a>
                    <button type="button" class="btn btn-primary" onclick="exportarInvitaciones()">
                        <i class="fas fa-download"></i>
                        Exportar
                    </button>
                </div>
            </div>
        </form>
    </div>    <!-- Tabla de invitaciones -->
    <div class="table-container">
        <table class="table" id="tabla_invitaciones">
            <thead>
                <tr>
                    <th><i class="fas fa-user"></i> Tutor</th>
                    <th><i class="fas fa-envelope"></i> Email</th>
                    <th><i class="fas fa-child"></i> Menores</th>
                    <th><i class="fas fa-calendar"></i> Fecha Envío</th>
                    <th><i class="fas fa-info-circle"></i> Estado</th>
                    <th><i class="fas fa-cogs"></i> Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($invitaciones)): ?>
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 2rem; color: var(--gray-600);">
                            <i class="fas fa-inbox" style="font-size: 2rem; margin-bottom: 1rem; display: block;"></i>
                            No hay invitaciones registradas
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($invitaciones as $invitacion): 
                        // 🔄 Determinar estado
                        if ($invitacion['expirado']) {
                            $estado = 'expirado';
                            $estado_badge = '<span class="badge badge-rejected">Expirado</span>';
                        } elseif ($invitacion['usado'] && $invitacion['padre_registrado']) {
                            $estado = 'ingresado';
                            $estado_badge = '<span class="badge badge-approved">Ingresado</span>';
                        } else {
                            $estado = 'enviado';
                            $estado_badge = '<span class="badge badge-sent">Enviado</span>';
                        }
                        
                        // 📅 Formatear fechas
                        $fecha_envio = date('d/m/Y', strtotime($invitacion['fecha_creacion']));
                        $hora_envio = date('H:i', strtotime($invitacion['fecha_creacion']));
                        
                        // 👶 Información de menores
                        $menores_info = $invitacion['total_menores'] > 0 ? 
                            $invitacion['total_menores'] . ' menor(es) registrado(s)' : 
                            'Sin menores asociados';
                    ?>
                        <tr data-estado="<?= $estado ?>" data-fecha="<?= date('Y-m-d', strtotime($invitacion['fecha_creacion'])) ?>">
                            <td>
                                <strong><?= htmlspecialchars($invitacion['tutor_nombre']) ?></strong><br>
                                <small style="color: var(--gray-600);"><?= ucfirst($invitacion['tutor_parentesco']) ?></small>
                            </td>
                            <td><?= htmlspecialchars($invitacion['tutor_email']) ?></td>
                            <td>
                                <span style="background: var(--primary-light); padding: 0.25rem 0.5rem; border-radius: 4px; font-size: 0.8rem;">
                                    <?= $menores_info ?>
                                </span>
                            </td>
                            <td><?= $fecha_envio ?><br><small><?= $hora_envio ?></small></td>
                            <td><?= $estado_badge ?></td>
                            <td>
                                <button class="btn btn-secondary" onclick="verDetalles(<?= $invitacion['id'] ?>)" style="padding: 0.25rem 0.5rem; font-size: 0.8rem;">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Paginación -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 2rem; padding: 1rem; background: var(--gray-100); border-radius: 8px;">
        <div style="color: var(--gray-600);">
            Mostrando <?= min(($pagina_actual - 1) * $registros_por_pagina + 1, $total_registros) ?>-<?= min($pagina_actual * $registros_por_pagina, $total_registros) ?> de <?= $total_registros ?> invitaciones
        </div>
        
        <?php if ($total_paginas > 1): ?>
        <div style="display: flex; gap: 0.5rem;">
            <!-- Botón anterior -->
            <?php if ($pagina_actual > 1): ?>
                <a href="<?= construirUrlPaginacion($pagina_actual - 1) ?>" class="btn btn-secondary" style="padding: 0.5rem 0.75rem;">
                    <i class="fas fa-chevron-left"></i>
                </a>
            <?php else: ?>
                <button class="btn btn-secondary" style="padding: 0.5rem 0.75rem;" disabled>
                    <i class="fas fa-chevron-left"></i>
                </button>
            <?php endif; ?>
            
            <!-- Números de página -->
            <?php
            $inicio_paginacion = max(1, $pagina_actual - 2);
            $fin_paginacion = min($total_paginas, $pagina_actual + 2);
            
            // Mostrar primera página si no está en el rango
            if ($inicio_paginacion > 1): ?>
                <a href="<?= construirUrlPaginacion(1) ?>" class="btn btn-secondary" style="padding: 0.5rem 0.75rem;">1</a>
                <?php if ($inicio_paginacion > 2): ?>
                    <span style="padding: 0.5rem; color: var(--gray-600);">...</span>
                <?php endif; ?>
            <?php endif; ?>
            
            <!-- Páginas del rango actual -->
            <?php for ($i = $inicio_paginacion; $i <= $fin_paginacion; $i++): ?>
                <?php if ($i == $pagina_actual): ?>
                    <button class="btn btn-primary" style="padding: 0.5rem 0.75rem;"><?= $i ?></button>
                <?php else: ?>
                    <a href="<?= construirUrlPaginacion($i) ?>" class="btn btn-secondary" style="padding: 0.5rem 0.75rem;"><?= $i ?></a>
                <?php endif; ?>
            <?php endfor; ?>
            
            <!-- Mostrar última página si no está en el rango -->
            <?php if ($fin_paginacion < $total_paginas): ?>
                <?php if ($fin_paginacion < $total_paginas - 1): ?>
                    <span style="padding: 0.5rem; color: var(--gray-600);">...</span>
                <?php endif; ?>
                <a href="<?= construirUrlPaginacion($total_paginas) ?>" class="btn btn-secondary" style="padding: 0.5rem 0.75rem;"><?= $total_paginas ?></a>
            <?php endif; ?>
            
            <!-- Botón siguiente -->
            <?php if ($pagina_actual < $total_paginas): ?>
                <a href="<?= construirUrlPaginacion($pagina_actual + 1) ?>" class="btn btn-secondary" style="padding: 0.5rem 0.75rem;">
                    <i class="fas fa-chevron-right"></i>
                </a>
            <?php else: ?>
                <button class="btn btn-secondary" style="padding: 0.5rem 0.75rem;" disabled>
                    <i class="fas fa-chevron-right"></i>
                </button>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </div>

    <?php
    // 🔗 Función para construir URLs de paginación manteniendo filtros
    function construirUrlPaginacion($pagina) {
        global $filtro_busqueda, $filtro_estado, $filtro_fecha;
        
        $params = [
            'section' => 'invitaciones',
            'pagina' => $pagina
        ];
        
        if (!empty($filtro_busqueda)) $params['busqueda'] = $filtro_busqueda;
        if (!empty($filtro_estado)) $params['estado'] = $filtro_estado;
        if (!empty($filtro_fecha)) $params['fecha'] = $filtro_fecha;
        
        return '?' . http_build_query($params);
    }
    ?>
    
    <!-- Estadísticas rápidas -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-number"><?= $stats['enviadas'] ?></div>
            <div class="stat-label">Invitaciones enviadas</div>
        </div>
        <div class="stat-card">
            <div class="stat-number"><?= $hoy_stats['completadas_hoy'] ?></div>
            <div class="stat-label">Completadas hoy</div>
        </div>
        <div class="stat-card">
            <div class="stat-number"><?= $stats['expiradas'] ?></div>
            <div class="stat-label">Expiradas</div>
        </div>
        <div class="stat-card">
            <div class="stat-number"><?= $tasa_respuesta ?>%</div>
            <div class="stat-label">Tasa de respuesta</div>
        </div>
    </div>
</div>

<!-- Modal para ver detalles -->
<div id="modalDetalles" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;">
    <div style="background: white; border-radius: 12px; padding: 2rem; max-width: 700px; width: 90%; max-height: 80vh; overflow-y: auto;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
            <h3 style="color: var(--primary-color); margin: 0;" id="modalTitulo">Detalles de la Invitación</h3>
            <button onclick="cerrarModal()" style="background: none; border: none; font-size: 1.5rem; cursor: pointer;">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div id="contenidoModal">
            <!-- Contenido dinámico -->
        </div>
    </div>
</div>

<script>
// ️ Ver detalles de invitación
function verDetalles(id) {
    // Hacer solicitud AJAX para obtener detalles completos
    fetch('obtener_detalles_invitacion.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'id=' + id
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            mostrarDetallesModal(data.invitacion);
        } else {
            alert('Error al cargar los detalles: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al cargar los detalles de la invitación');
    });
}

// 🖥️ Mostrar detalles en modal
function mostrarDetallesModal(invitacion) {
    let estadoBadge = '';
    let acciones = '';
    
    if (invitacion.expirado == 1) {
        estadoBadge = '<span class="badge badge-rejected">Expirado</span>';
        acciones = `
            <button class="btn btn-primary" onclick="editarInvitacion(${invitacion.id})">
                <i class="fas fa-edit"></i> Editar
            </button>
            <button class="btn btn-danger" onclick="eliminarInvitacion(${invitacion.id})">
                <i class="fas fa-trash"></i> Eliminar
            </button>
        `;
    } else if (invitacion.usado == 1) {
        estadoBadge = '<span class="badge badge-approved">Ingresado</span>';
        acciones = `
            <button class="btn btn-primary" onclick="editarInvitacion(${invitacion.id})">
                <i class="fas fa-edit"></i> Editar
            </button>
            <button class="btn btn-danger" onclick="eliminarInvitacion(${invitacion.id})">
                <i class="fas fa-trash"></i> Eliminar
            </button>
        `;
    } else {
        estadoBadge = '<span class="badge badge-sent">Enviado</span>';
        acciones = `
            <button class="btn btn-primary" onclick="editarInvitacion(${invitacion.id})">
                <i class="fas fa-edit"></i> Editar
            </button>
            <button class="btn btn-primary" onclick="reenviarInvitacion(${invitacion.id})">
                <i class="fas fa-paper-plane"></i> Reenviar
            </button>
            <button class="btn btn-danger" onclick="eliminarInvitacion(${invitacion.id})">
                <i class="fas fa-trash"></i> Eliminar
            </button>
        `;
    }

    const contenido = `
        <div style="display: grid; gap: 1rem;">
            <div>
                <strong style="color: var(--primary-color);">Información del Tutor:</strong><br>
                <strong>Nombre:</strong> ${invitacion.tutor_nombre}<br>
                <strong>Email:</strong> ${invitacion.tutor_email}<br>
                <strong>Teléfono:</strong> ${invitacion.tutor_telefono}<br>
                <strong>Parentesco:</strong> ${invitacion.tutor_parentesco}
            </div>
            <div>
                <strong style="color: var(--primary-color);">Menores Registrados:</strong><br>
                ${invitacion.menores_info || 'Sin menores registrados aún'}
            </div>
            <div>
                <strong style="color: var(--primary-color);">Detalles de la Invitación:</strong><br>
                <strong>Fecha de envío:</strong> ${invitacion.fecha_creacion_formato}<br>
                <strong>Estado:</strong> ${estadoBadge}<br>
                <strong>Token:</strong> <code style="background: var(--gray-100); padding: 0.25rem; font-size: 0.8rem;">${invitacion.token}</code>
                ${invitacion.fecha_usado ? '<br><strong>Fecha de uso:</strong> ' + invitacion.fecha_usado_formato : ''}
            </div>
            <div style="display: flex; gap: 1rem; margin-top: 1rem; flex-wrap: wrap;">
                ${acciones}
            </div>
        </div>
    `;
    
    document.getElementById('contenidoModal').innerHTML = contenido;
    document.getElementById('modalTitulo').innerHTML = 'Detalles de la Invitación';
    document.getElementById('modalDetalles').style.display = 'flex';
}

// ✏️ Modo edición de invitación
function editarInvitacion(id) {
    // Hacer solicitud AJAX para obtener datos actuales
    fetch('obtener_detalles_invitacion.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'id=' + id
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            mostrarFormularioEdicion(data.invitacion);
        } else {
            alert('Error al cargar los datos: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al cargar los datos para edición');
    });
}

// 📝 Mostrar formulario de edición
function mostrarFormularioEdicion(invitacion) {
    const formulario = `
        <form id="formEditarInvitacion" onsubmit="guardarCambiosInvitacion(event, ${invitacion.id})">
            <div style="display: grid; gap: 1rem;">
                <div style="background: var(--primary-light); padding: 1rem; border-radius: 8px; margin-bottom: 1rem;">
                    <h4 style="color: var(--primary-color); margin: 0 0 0.5rem 0;">
                        <i class="fas fa-info-circle"></i> Información Importante
                    </h4>
                    <p style="margin: 0; font-size: 0.9rem;">
                        Los cambios se aplicarán inmediatamente y el padre podrá verlos en su panel.
                        ${invitacion.usado == 1 ? 'Los menores ya registrados también se actualizarán.' : ''}
                    </p>
                </div>
                
                <div>
                    <strong style="color: var(--primary-color);">Información del Tutor:</strong>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-top: 0.5rem;">
                        <div>
                            <label style="display: block; margin-bottom: 0.25rem; font-weight: 600;">Nombre:</label>
                            <input type="text" name="tutor_nombre" value="${invitacion.tutor_nombre}" 
                                   style="width: 100%; padding: 0.5rem; border: 1px solid var(--gray-300); border-radius: 4px;" required>
                        </div>
                        <div>
                            <label style="display: block; margin-bottom: 0.25rem; font-weight: 600;">Teléfono:</label>
                            <input type="text" name="tutor_telefono" value="${invitacion.tutor_telefono}" 
                                   style="width: 100%; padding: 0.5rem; border: 1px solid var(--gray-300); border-radius: 4px;" required>
                        </div>
                    </div>
                    <div style="margin-top: 1rem;">
                        <label style="display: block; margin-bottom: 0.25rem; font-weight: 600;">Email:</label>
                        <input type="email" name="tutor_email" value="${invitacion.tutor_email}" 
                               style="width: 100%; padding: 0.5rem; border: 1px solid var(--gray-300); border-radius: 4px;" 
                               ${invitacion.usado == 1 ? 'readonly title="No se puede cambiar el email de un usuario registrado"' : 'required'}>
                    </div>
                    <div style="margin-top: 1rem;">
                        <label style="display: block; margin-bottom: 0.25rem; font-weight: 600;">Parentesco:</label>
                        <select name="tutor_parentesco" style="width: 100%; padding: 0.5rem; border: 1px solid var(--gray-300); border-radius: 4px;" required>
                            <option value="madre" ${invitacion.tutor_parentesco === 'madre' ? 'selected' : ''}>Madre</option>
                            <option value="padre" ${invitacion.tutor_parentesco === 'padre' ? 'selected' : ''}>Padre</option>
                            <option value="abuelo" ${invitacion.tutor_parentesco === 'abuelo' ? 'selected' : ''}>Abuelo/a</option>
                            <option value="tio" ${invitacion.tutor_parentesco === 'tio' ? 'selected' : ''}>Tío/a</option>
                            <option value="tutor_legal" ${invitacion.tutor_parentesco === 'tutor_legal' ? 'selected' : ''}>Tutor Legal</option>
                            <option value="otro" ${invitacion.tutor_parentesco === 'otro' ? 'selected' : ''}>Otro</option>
                        </select>
                    </div>
                </div>
                
                <div style="display: flex; gap: 1rem; margin-top: 1rem; flex-wrap: wrap;">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Guardar Cambios
                    </button>
                    <button type="button" class="btn btn-secondary" onclick="verDetalles(${invitacion.id})">
                        <i class="fas fa-arrow-left"></i> Volver a Detalles
                    </button>
                </div>
            </div>
        </form>
    `;
    
    document.getElementById('contenidoModal').innerHTML = formulario;
    document.getElementById('modalTitulo').innerHTML = '<i class="fas fa-edit"></i> Editar Invitación';
}

// 💾 Guardar cambios de la invitación
function guardarCambiosInvitacion(event, id) {
    event.preventDefault();
    
    const formData = new FormData(event.target);
    formData.append('id', id);
    
    if (confirm('¿Estás seguro de que deseas guardar estos cambios?')) {
        fetch('editar_invitacion.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Cambios guardados correctamente');
                verDetalles(id); // Volver a mostrar detalles
                location.reload(); // Recargar la tabla
            } else {
                alert('Error al guardar: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al guardar los cambios');
        });
    }
}

// ❌ Cerrar modal
function cerrarModal() {
    document.getElementById('modalDetalles').style.display = 'none';
}

// 📧 Reenviar invitación
function reenviarInvitacion(id) {
    if (confirm('¿Estás seguro de que deseas reenviar la invitación por correo electrónico?')) {
        // Hacer solicitud AJAX para reenviar
        fetch('reenviar_invitacion.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'id=' + id
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Invitación reenviada correctamente');
                cerrarModal();
                location.reload();
            } else {
                alert('Error al reenviar: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al reenviar la invitación');
        });
    }
}

// 🗑️ Eliminar invitación (completa)
function eliminarInvitacion(id) {
    if (confirm('⚠️ ADVERTENCIA: Esta acción eliminará completamente la invitación y todos los datos asociados (padres, menores, sesiones, etc.). ¿Estás seguro de continuar?')) {
        if (confirm('Esta acción NO se puede deshacer. ¿Confirmas la eliminación definitiva?')) {
            // Hacer solicitud AJAX para eliminar completamente
            fetch('eliminar_invitacion_completa.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'id=' + id
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Invitación eliminada completamente del sistema');
                    cerrarModal();
                    location.reload();
                } else {
                    alert('Error al eliminar: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al eliminar la invitación');
            });
        }
    }
}

// 📁 Exportar invitaciones
function exportarInvitaciones() {
    // Construir URL con filtros actuales
    const urlParams = new URLSearchParams(window.location.search);
    const filtros = {
        busqueda: urlParams.get('busqueda') || '',
        estado: urlParams.get('estado') || '',
        fecha: urlParams.get('fecha') || ''
    };
    
    const queryString = Object.keys(filtros)
        .filter(key => filtros[key])
        .map(key => `${key}=${encodeURIComponent(filtros[key])}`)
        .join('&');
    
    window.open(`exportar_invitaciones.php?${queryString}`, '_blank');
}

// 🎭 Cerrar modal al hacer clic fuera
document.getElementById('modalDetalles').addEventListener('click', function(e) {
    if (e.target === this) {
        cerrarModal();
    }
});

// 🔍 Búsqueda en tiempo real (opcional - envía después de 1 segundo de inactividad)
let timeoutBusqueda;
document.getElementById('buscar_invitacion').addEventListener('input', function() {
    clearTimeout(timeoutBusqueda);
    timeoutBusqueda = setTimeout(() => {
        document.getElementById('filtrosForm').submit();
    }, 1000);
});
</script>