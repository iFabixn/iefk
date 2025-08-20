<?php
// Datos de ejemplo para horas extra
$horas_extra_registros = [
    [
        'id' => 'HE001',
        'persona_id' => 'STU001',
        'nombre' => 'Ana Sofia Martinez',
        'tipo' => 'Estudiante',
        'plantel' => 'El Zapote',
        'fecha' => '2024-01-15',
        'entrada_programada' => '08:00',
        'entrada_real' => '08:30',
        'salida_programada' => '14:00',
        'salida_real' => '14:45',
        'minutos_entrada' => 30,
        'minutos_salida' => 45,
        'total_minutos' => 75,
        'motivo_entrada' => 'Tráfico en la zona',
        'motivo_salida' => 'Actividad extraescolar',
        'autorizado_por' => 'Directora María López',
        'estado' => 'aprobado'
    ],
    [
        'id' => 'HE002',
        'persona_id' => 'MAE001',
        'nombre' => 'Profesora Laura Gonzalez',
        'tipo' => 'Maestro',
        'plantel' => 'El Zapote',
        'fecha' => '2024-01-15',
        'entrada_programada' => '07:30',
        'entrada_real' => '07:15',
        'salida_programada' => '15:00',
        'salida_real' => '17:30',
        'minutos_entrada' => -15,
        'minutos_salida' => 150,
        'total_minutos' => 135,
        'motivo_entrada' => 'Preparación de clases',
        'motivo_salida' => 'Reunión de padres',
        'autorizado_por' => 'Coordinación Académica',
        'estado' => 'aprobado'
    ],
    [
        'id' => 'HE003',
        'persona_id' => 'STU002',
        'nombre' => 'Diego Alejandro Ruiz',
        'tipo' => 'Estudiante',
        'plantel' => 'Insurgentes',
        'fecha' => '2024-01-16',
        'entrada_programada' => '08:00',
        'entrada_real' => '08:20',
        'salida_programada' => '14:00',
        'salida_real' => '14:00',
        'minutos_entrada' => 20,
        'minutos_salida' => 0,
        'total_minutos' => 20,
        'motivo_entrada' => 'Problema de transporte',
        'motivo_salida' => null,
        'autorizado_por' => null,
        'estado' => 'pendiente'
    ]
];

// Obtener filtros
$filtro_fecha_inicio = $_GET['fecha_inicio'] ?? date('Y-m-01');
$filtro_fecha_fin = $_GET['fecha_fin'] ?? date('Y-m-t');
$filtro_tipo = $_GET['tipo'] ?? 'todos';
$filtro_estado = $_GET['estado'] ?? 'todos';
$filtro_plantel = $_GET['plantel'] ?? 'todos';

// Filtrar registros
$registros_filtrados = array_filter($horas_extra_registros, function($registro) use ($filtro_tipo, $filtro_estado, $filtro_plantel) {
    $cumple_tipo = ($filtro_tipo === 'todos' || $registro['tipo'] === $filtro_tipo);
    $cumple_estado = ($filtro_estado === 'todos' || $registro['estado'] === $filtro_estado);
    $cumple_plantel = ($filtro_plantel === 'todos' || $registro['plantel'] === $filtro_plantel);
    
    return $cumple_tipo && $cumple_estado && $cumple_plantel;
});

function formatearMinutos($minutos) {
    if ($minutos == 0) return '0h 0m';
    
    $esNegativo = $minutos < 0;
    $minutos = abs($minutos);
    
    $horas = floor($minutos / 60);
    $mins = $minutos % 60;
    
    $resultado = '';
    if ($horas > 0) $resultado .= $horas . 'h ';
    if ($mins > 0) $resultado .= $mins . 'm';
    
    return $esNegativo ? '-' . $resultado : $resultado;
}

function obtenerColorEstado($estado) {
    switch ($estado) {
        case 'aprobado': return 'success';
        case 'pendiente': return 'warning';
        case 'rechazado': return 'danger';
        default: return 'secondary';
    }
}

function obtenerColorTiempo($minutos) {
    if ($minutos > 60) return 'danger';
    if ($minutos > 30) return 'warning';
    if ($minutos > 0) return 'info';
    return 'success';
}
?>

<!-- ===================== GESTIÓN DE HORAS EXTRA ===================== -->
<div class="horas-extra-gestion">
    <!-- Header -->
    <div class="horas-header">
        <div class="header-info">
            <h2 style="color: var(--primary-color); margin-bottom: 0.5rem;">
                <i class="fas fa-clock"></i> Gestión de Horas Extra
            </h2>
            <p style="color: var(--gray-600);">
                Control y seguimiento de horas extra por llegadas tardías y salidas posteriores
            </p>
        </div>
        
        <div class="header-acciones">
            <button class="btn btn-primary" onclick="abrirModalRegistro()">
                <i class="fas fa-plus"></i> Registrar Horas Extra
            </button>
            <button class="btn btn-success" onclick="exportarHorasExtra()">
                <i class="fas fa-file-excel"></i> Exportar
            </button>
        </div>
    </div>

    <!-- Estadísticas Rápidas -->
    <div class="estadisticas-horas">
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-business-time"></i>
            </div>
            <div class="stat-content">
                <div class="stat-number"><?= count($registros_filtrados) ?></div>
                <div class="stat-label">Registros del Período</div>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-hourglass-half"></i>
            </div>
            <div class="stat-content">
                <div class="stat-number">
                    <?= formatearMinutos(array_sum(array_column($registros_filtrados, 'total_minutos'))) ?>
                </div>
                <div class="stat-label">Total Horas Extra</div>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div class="stat-content">
                <div class="stat-number">
                    <?= count(array_filter($registros_filtrados, fn($r) => $r['estado'] === 'pendiente')) ?>
                </div>
                <div class="stat-label">Pendientes de Aprobación</div>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-chart-line"></i>
            </div>
            <div class="stat-content">
                <div class="stat-number">
                    <?= round(array_sum(array_column($registros_filtrados, 'total_minutos')) / max(count($registros_filtrados), 1), 0) ?>m
                </div>
                <div class="stat-label">Promedio por Registro</div>
            </div>
        </div>
    </div>

    <!-- Filtros Avanzados -->
    <div class="filtros-avanzados">
        <h3><i class="fas fa-filter"></i> Filtros de Búsqueda</h3>
        <div class="filtros-grid">
            <div class="filtro-item">
                <label for="fecha-inicio">Fecha Inicio:</label>
                <input type="date" id="fecha-inicio" value="<?= $filtro_fecha_inicio ?>" onchange="aplicarFiltros()">
            </div>
            
            <div class="filtro-item">
                <label for="fecha-fin">Fecha Fin:</label>
                <input type="date" id="fecha-fin" value="<?= $filtro_fecha_fin ?>" onchange="aplicarFiltros()">
            </div>
            
            <div class="filtro-item">
                <label for="filtro-tipo">Tipo de Usuario:</label>
                <select id="filtro-tipo" onchange="aplicarFiltros()">
                    <option value="todos">Todos</option>
                    <option value="Estudiante" <?= $filtro_tipo === 'Estudiante' ? 'selected' : '' ?>>Estudiantes</option>
                    <option value="Maestro" <?= $filtro_tipo === 'Maestro' ? 'selected' : '' ?>>Maestros</option>
                </select>
            </div>
            
            <div class="filtro-item">
                <label for="filtro-estado">Estado:</label>
                <select id="filtro-estado" onchange="aplicarFiltros()">
                    <option value="todos">Todos</option>
                    <option value="pendiente" <?= $filtro_estado === 'pendiente' ? 'selected' : '' ?>>Pendiente</option>
                    <option value="aprobado" <?= $filtro_estado === 'aprobado' ? 'selected' : '' ?>>Aprobado</option>
                    <option value="rechazado" <?= $filtro_estado === 'rechazado' ? 'selected' : '' ?>>Rechazado</option>
                </select>
            </div>
            
            <div class="filtro-item">
                <label for="filtro-plantel-horas">Plantel:</label>
                <select id="filtro-plantel-horas" onchange="aplicarFiltros()">
                    <option value="todos">Todos</option>
                    <option value="El Zapote" <?= $filtro_plantel === 'El Zapote' ? 'selected' : '' ?>>El Zapote</option>
                    <option value="Insurgentes" <?= $filtro_plantel === 'Insurgentes' ? 'selected' : '' ?>>Insurgentes</option>
                    <option value="Lindavista" <?= $filtro_plantel === 'Lindavista' ? 'selected' : '' ?>>Lindavista</option>
                </select>
            </div>
            
            <div class="filtro-acciones">
                <button class="btn btn-secondary" onclick="limpiarFiltros()">
                    <i class="fas fa-eraser"></i> Limpiar
                </button>
                <button class="btn btn-info" onclick="buscarAvanzado()">
                    <i class="fas fa-search"></i> Buscar
                </button>
            </div>
        </div>
    </div>

    <!-- Resumen Dividido por Tipo de Usuario -->
    <div class="resumen-tipos">
        <h3><i class="fas fa-users"></i> Desglose por Tipo de Usuario</h3>
        
        <!-- Sección de Estudiantes -->
        <div class="tipo-seccion">
            <div class="tipo-header">
                <h4><i class="fas fa-child"></i> Estudiantes</h4>
                <span class="contador-tipo">
                    <?php 
                    $estudiantes_count = count(array_filter($registros_filtrados, fn($r) => $r['tipo'] === 'Estudiante'));
                    echo $estudiantes_count . ' registros';
                    ?>
                </span>
            </div>
            
            <div class="metricas-tipo">
                <?php 
                $estudiantes_registros = array_filter($registros_filtrados, fn($r) => $r['tipo'] === 'Estudiante');
                $total_minutos_estudiantes = array_sum(array_column($estudiantes_registros, 'total_minutos'));
                $promedio_estudiantes = $estudiantes_count > 0 ? round($total_minutos_estudiantes / $estudiantes_count) : 0;
                $tardanzas_estudiantes = array_sum(array_column($estudiantes_registros, 'dias_tardanza'));
                ?>
                
                <div class="metrica-tipo">
                    <div class="metrica-icon estudiante">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="metrica-info">
                        <div class="metrica-numero"><?= formatearMinutos($total_minutos_estudiantes) ?></div>
                        <div class="metrica-label">Total Horas Extra</div>
                    </div>
                </div>
                
                <div class="metrica-tipo">
                    <div class="metrica-icon estudiante">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div class="metrica-info">
                        <div class="metrica-numero"><?= formatearMinutos($promedio_estudiantes) ?></div>
                        <div class="metrica-label">Promedio por Estudiante</div>
                    </div>
                </div>
                
                <div class="metrica-tipo">
                    <div class="metrica-icon estudiante">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <div class="metrica-info">
                        <div class="metrica-numero"><?= $tardanzas_estudiantes ?></div>
                        <div class="metrica-label">Total Tardanzas</div>
                    </div>
                </div>
            </div>
            
            <!-- Lista de estudiantes -->
            <div class="lista-personas">
                <?php 
                $estudiantes_resumen = [];
                foreach ($estudiantes_registros as $registro) {
                    $key = $registro['persona_id'];
                    if (!isset($estudiantes_resumen[$key])) {
                        $estudiantes_resumen[$key] = [
                            'nombre' => $registro['nombre'],
                            'plantel' => $registro['plantel'],
                            'total_registros' => 0,
                            'total_minutos' => 0,
                            'minutos_entrada' => 0,
                            'minutos_salida' => 0
                        ];
                    }
                    
                    $estudiantes_resumen[$key]['total_registros']++;
                    $estudiantes_resumen[$key]['total_minutos'] += $registro['total_minutos'];
                    $estudiantes_resumen[$key]['minutos_entrada'] += $registro['minutos_entrada'];
                    $estudiantes_resumen[$key]['minutos_salida'] += $registro['minutos_salida'];
                }
                
                foreach ($estudiantes_resumen as $estudiante):
                ?>
                <div class="persona-item estudiante">
                    <div class="persona-avatar">
                        <i class="fas fa-child"></i>
                    </div>
                    <div class="persona-datos">
                        <h5><?= $estudiante['nombre'] ?></h5>
                        <p><?= $estudiante['plantel'] ?></p>
                    </div>
                    <div class="persona-metricas-mini">
                        <div class="metrica-mini">
                            <span class="valor"><?= $estudiante['total_registros'] ?></span>
                            <span class="label">Registros</span>
                        </div>
                        <div class="metrica-mini total">
                            <span class="valor"><?= formatearMinutos($estudiante['total_minutos']) ?></span>
                            <span class="label">Total</span>
                        </div>
                        <div class="metrica-mini entrada">
                            <span class="valor"><?= formatearMinutos($estudiante['minutos_entrada']) ?></span>
                            <span class="label">Entradas</span>
                        </div>
                        <div class="metrica-mini salida">
                            <span class="valor"><?= formatearMinutos($estudiante['minutos_salida']) ?></span>
                            <span class="label">Salidas</span>
                        </div>
                    </div>
                    <div class="persona-acciones">
                        <button class="btn btn-sm btn-primary" onclick="verDetallePersona('<?= $estudiante_key ?? '' ?>', 'estudiante')">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
                <?php endforeach; ?>
                
                <?php if (empty($estudiantes_resumen)): ?>
                <div class="empty-tipo">
                    <i class="fas fa-child fa-2x"></i>
                    <p>No hay registros de estudiantes en este período</p>
                </div>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Sección de Maestros -->
        <div class="tipo-seccion">
            <div class="tipo-header">
                <h4><i class="fas fa-chalkboard-teacher"></i> Maestros</h4>
                <span class="contador-tipo">
                    <?php 
                    $maestros_count = count(array_filter($registros_filtrados, fn($r) => $r['tipo'] === 'Maestro'));
                    echo $maestros_count . ' registros';
                    ?>
                </span>
            </div>
            
            <div class="metricas-tipo">
                <?php 
                $maestros_registros = array_filter($registros_filtrados, fn($r) => $r['tipo'] === 'Maestro');
                $total_minutos_maestros = array_sum(array_column($maestros_registros, 'total_minutos'));
                $promedio_maestros = $maestros_count > 0 ? round($total_minutos_maestros / $maestros_count) : 0;
                $tardanzas_maestros = array_sum(array_column($maestros_registros, 'dias_tardanza'));
                ?>
                
                <div class="metrica-tipo">
                    <div class="metrica-icon maestro">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="metrica-info">
                        <div class="metrica-numero"><?= formatearMinutos($total_minutos_maestros) ?></div>
                        <div class="metrica-label">Total Horas Extra</div>
                    </div>
                </div>
                
                <div class="metrica-tipo">
                    <div class="metrica-icon maestro">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div class="metrica-info">
                        <div class="metrica-numero"><?= formatearMinutos($promedio_maestros) ?></div>
                        <div class="metrica-label">Promedio por Maestro</div>
                    </div>
                </div>
                
                <div class="metrica-tipo">
                    <div class="metrica-icon maestro">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <div class="metrica-info">
                        <div class="metrica-numero"><?= $tardanzas_maestros ?></div>
                        <div class="metrica-label">Total Tardanzas</div>
                    </div>
                </div>
            </div>
            
            <!-- Lista de maestros -->
            <div class="lista-personas">
                <?php 
                $maestros_resumen = [];
                foreach ($maestros_registros as $registro) {
                    $key = $registro['persona_id'];
                    if (!isset($maestros_resumen[$key])) {
                        $maestros_resumen[$key] = [
                            'nombre' => $registro['nombre'],
                            'plantel' => $registro['plantel'],
                            'total_registros' => 0,
                            'total_minutos' => 0,
                            'minutos_entrada' => 0,
                            'minutos_salida' => 0
                        ];
                    }
                    
                    $maestros_resumen[$key]['total_registros']++;
                    $maestros_resumen[$key]['total_minutos'] += $registro['total_minutos'];
                    $maestros_resumen[$key]['minutos_entrada'] += $registro['minutos_entrada'];
                    $maestros_resumen[$key]['minutos_salida'] += $registro['minutos_salida'];
                }
                
                foreach ($maestros_resumen as $maestro):
                ?>
                <div class="persona-item maestro">
                    <div class="persona-avatar">
                        <i class="fas fa-chalkboard-teacher"></i>
                    </div>
                    <div class="persona-datos">
                        <h5><?= $maestro['nombre'] ?></h5>
                        <p><?= $maestro['plantel'] ?></p>
                    </div>
                    <div class="persona-metricas-mini">
                        <div class="metrica-mini">
                            <span class="valor"><?= $maestro['total_registros'] ?></span>
                            <span class="label">Registros</span>
                        </div>
                        <div class="metrica-mini total">
                            <span class="valor"><?= formatearMinutos($maestro['total_minutos']) ?></span>
                            <span class="label">Total</span>
                        </div>
                        <div class="metrica-mini entrada">
                            <span class="valor"><?= formatearMinutos($maestro['minutos_entrada']) ?></span>
                            <span class="label">Entradas</span>
                        </div>
                        <div class="metrica-mini salida">
                            <span class="valor"><?= formatearMinutos($maestro['minutos_salida']) ?></span>
                            <span class="label">Salidas</span>
                        </div>
                    </div>
                    <div class="persona-acciones">
                        <button class="btn btn-sm btn-primary" onclick="verDetallePersona('<?= $maestro_key ?? '' ?>', 'maestro')">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
                <?php endforeach; ?>
                
                <?php if (empty($maestros_resumen)): ?>
                <div class="empty-tipo">
                    <i class="fas fa-chalkboard-teacher fa-2x"></i>
                    <p>No hay registros de maestros en este período</p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Resumen por Persona (sección anterior manteniéndola como backup) -->
    <div class="resumen-personas" style="display: none;"  id="resumen-personas-backup">
        <h3><i class="fas fa-users-clock"></i> Resumen por Persona</h3>
        <div class="personas-grid">
            <?php 
            $personas_resumen = [];
            foreach ($registros_filtrados as $registro) {
                $key = $registro['persona_id'];
                if (!isset($personas_resumen[$key])) {
                    $personas_resumen[$key] = [
                        'nombre' => $registro['nombre'],
                        'tipo' => $registro['tipo'],
                        'plantel' => $registro['plantel'],
                        'total_registros' => 0,
                        'total_minutos' => 0,
                        'minutos_entrada' => 0,
                        'minutos_salida' => 0
                    ];
                }
                
                $personas_resumen[$key]['total_registros']++;
                $personas_resumen[$key]['total_minutos'] += $registro['total_minutos'];
                $personas_resumen[$key]['minutos_entrada'] += $registro['minutos_entrada'];
                $personas_resumen[$key]['minutos_salida'] += $registro['minutos_salida'];
            }
            
            foreach ($personas_resumen as $persona):
            ?>
            <div class="persona-resumen-card">
                <div class="persona-header">
                    <div class="persona-avatar">
                        <i class="fas fa-<?= $persona['tipo'] === 'Maestro' ? 'chalkboard-teacher' : 'child' ?>"></i>
                    </div>
                    <div class="persona-info">
                        <h4><?= $persona['nombre'] ?></h4>
                        <p><?= $persona['tipo'] ?> • <?= $persona['plantel'] ?></p>
                    </div>
                </div>
                
                <div class="persona-metricas">
                    <div class="metrica">
                        <span class="metrica-valor"><?= $persona['total_registros'] ?></span>
                        <span class="metrica-label">Registros</span>
                    </div>
                    <div class="metrica">
                        <span class="metrica-valor"><?= formatearMinutos($persona['total_minutos']) ?></span>
                        <span class="metrica-label">Total</span>
                    </div>
                    <div class="metrica">
                        <span class="metrica-valor"><?= formatearMinutos($persona['minutos_entrada']) ?></span>
                        <span class="metrica-label">Entradas</span>
                    </div>
                    <div class="metrica">
                        <span class="metrica-valor"><?= formatearMinutos($persona['minutos_salida']) ?></span>
                        <span class="metrica-label">Salidas</span>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Lista de Registros -->
    <div class="registros-lista">
        <div class="lista-header">
            <h3><i class="fas fa-list"></i> Registros Detallados</h3>
            <div class="lista-controles">
                <select id="orden-lista" onchange="ordenarLista()">
                    <option value="fecha-desc">Fecha (Más reciente)</option>
                    <option value="fecha-asc">Fecha (Más antigua)</option>
                    <option value="horas-desc">Más horas extra</option>
                    <option value="horas-asc">Menos horas extra</option>
                    <option value="nombre">Nombre (A-Z)</option>
                </select>
            </div>
        </div>
        
        <?php if (empty($registros_filtrados)): ?>
        <div class="empty-state">
            <i class="fas fa-clock fa-3x"></i>
            <h3>No hay registros de horas extra</h3>
            <p>No se encontraron registros para el período y filtros seleccionados.</p>
        </div>
        <?php else: ?>
            <?php foreach ($registros_filtrados as $registro): ?>
            <div class="registro-card">
                <!-- Header del registro -->
                <div class="registro-header">
                    <div class="registro-persona">
                        <div class="persona-avatar">
                            <i class="fas fa-<?= $registro['tipo'] === 'Maestro' ? 'chalkboard-teacher' : 'child' ?>"></i>
                        </div>
                        <div class="persona-datos">
                            <h4><?= $registro['nombre'] ?></h4>
                            <p><?= $registro['tipo'] ?> • <?= $registro['plantel'] ?></p>
                            <span class="fecha-registro">
                                <i class="fas fa-calendar"></i> <?= date('d/m/Y', strtotime($registro['fecha'])) ?>
                            </span>
                        </div>
                    </div>
                    
                    <div class="registro-estado">
                        <span class="badge badge-<?= obtenerColorEstado($registro['estado']) ?>">
                            <?= ucfirst($registro['estado']) ?>
                        </span>
                        <div class="total-horas">
                            <span class="badge badge-<?= obtenerColorTiempo($registro['total_minutos']) ?>">
                                <?= formatearMinutos($registro['total_minutos']) ?>
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Desglose de horarios -->
                <div class="horarios-desglose">
                    <div class="horario-grupo">
                        <h5><i class="fas fa-sign-in-alt"></i> Entrada</h5>
                        <div class="horario-comparacion">
                            <div class="horario-item">
                                <span class="horario-label">Programada:</span>
                                <span class="horario-valor"><?= $registro['entrada_programada'] ?></span>
                            </div>
                            <div class="horario-item">
                                <span class="horario-label">Real:</span>
                                <span class="horario-valor <?= $registro['minutos_entrada'] > 0 ? 'tardanza' : 'temprano' ?>">
                                    <?= $registro['entrada_real'] ?>
                                </span>
                            </div>
                            <div class="horario-diferencia">
                                <span class="diferencia-valor <?= $registro['minutos_entrada'] > 0 ? 'tardanza' : 'temprano' ?>">
                                    <?= formatearMinutos($registro['minutos_entrada']) ?>
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="horario-grupo">
                        <h5><i class="fas fa-sign-out-alt"></i> Salida</h5>
                        <div class="horario-comparacion">
                            <div class="horario-item">
                                <span class="horario-label">Programada:</span>
                                <span class="horario-valor"><?= $registro['salida_programada'] ?></span>
                            </div>
                            <div class="horario-item">
                                <span class="horario-label">Real:</span>
                                <span class="horario-valor <?= $registro['minutos_salida'] > 0 ? 'tardanza' : 'temprano' ?>">
                                    <?= $registro['salida_real'] ?>
                                </span>
                            </div>
                            <div class="horario-diferencia">
                                <span class="diferencia-valor <?= $registro['minutos_salida'] > 0 ? 'tardanza' : 'temprano' ?>">
                                    <?= formatearMinutos($registro['minutos_salida']) ?>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Motivos y autorizaciones -->
                <div class="motivos-autorizaciones">
                    <?php if ($registro['motivo_entrada']): ?>
                    <div class="motivo-item">
                        <h6><i class="fas fa-info-circle"></i> Motivo de Tardanza en Entrada</h6>
                        <p><?= $registro['motivo_entrada'] ?></p>
                    </div>
                    <?php endif; ?>
                    
                    <?php if ($registro['motivo_salida']): ?>
                    <div class="motivo-item">
                        <h6><i class="fas fa-info-circle"></i> Motivo de Tardanza en Salida</h6>
                        <p><?= $registro['motivo_salida'] ?></p>
                    </div>
                    <?php endif; ?>
                    
                    <?php if ($registro['autorizado_por']): ?>
                    <div class="autorizacion-item">
                        <h6><i class="fas fa-user-check"></i> Autorizado por</h6>
                        <p><?= $registro['autorizado_por'] ?></p>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- Acciones del registro -->
                <div class="registro-acciones">
                    <?php if ($registro['estado'] === 'pendiente'): ?>
                    <button class="btn btn-success btn-sm" onclick="aprobarRegistro('<?= $registro['id'] ?>')">
                        <i class="fas fa-check"></i> Aprobar
                    </button>
                    <button class="btn btn-danger btn-sm" onclick="rechazarRegistro('<?= $registro['id'] ?>')">
                        <i class="fas fa-times"></i> Rechazar
                    </button>
                    <?php endif; ?>
                    
                    <button class="btn btn-primary btn-sm" onclick="editarRegistro('<?= $registro['id'] ?>')">
                        <i class="fas fa-edit"></i> Editar
                    </button>
                    <button class="btn btn-info btn-sm" onclick="verDetalleCompleto('<?= $registro['id'] ?>')">
                        <i class="fas fa-eye"></i> Ver Detalle
                    </button>
                    <button class="btn btn-warning btn-sm" onclick="duplicarRegistro('<?= $registro['id'] ?>')">
                        <i class="fas fa-copy"></i> Duplicar
                    </button>
                </div>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<!-- Modal de Registro de Horas Extra -->
<div id="modal-registro-horas" class="modal" style="display: none;">
    <div class="modal-content modal-lg">
        <div class="modal-header">
            <h3>Registrar Horas Extra</h3>
            <span class="modal-close" onclick="cerrarModalRegistro()">&times;</span>
        </div>
        <div class="modal-body">
            <form id="form-horas-extra">
                <div class="form-grid">
                    <div class="form-group">
                        <label for="persona-select">Persona:</label>
                        <select id="persona-select" required>
                            <option value="">Seleccionar persona</option>
                            <option value="STU001">Ana Sofia Martinez (Estudiante)</option>
                            <option value="STU002">Diego Alejandro Ruiz (Estudiante)</option>
                            <option value="MAE001">Profesora Laura Gonzalez (Maestro)</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="fecha-registro">Fecha:</label>
                        <input type="date" id="fecha-registro" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="entrada-programada">Entrada Programada:</label>
                        <input type="time" id="entrada-programada" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="entrada-real">Entrada Real:</label>
                        <input type="time" id="entrada-real" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="salida-programada">Salida Programada:</label>
                        <input type="time" id="salida-programada" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="salida-real">Salida Real:</label>
                        <input type="time" id="salida-real" required>
                    </div>
                </div>
                
                <div class="motivos-section">
                    <div class="form-group">
                        <label for="motivo-entrada">Motivo de tardanza en entrada:</label>
                        <textarea id="motivo-entrada" rows="3" placeholder="Explicar motivo de la tardanza..."></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="motivo-salida">Motivo de tardanza en salida:</label>
                        <textarea id="motivo-salida" rows="3" placeholder="Explicar motivo de la tardanza..."></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="autorizado-por">Autorizado por:</label>
                        <input type="text" id="autorizado-por" placeholder="Nombre del autorizador">
                    </div>
                </div>
                
                <div class="calculo-preview">
                    <h4>Resumen de Horas Extra</h4>
                    <div id="preview-calculo">
                        <p>Complete los horarios para ver el cálculo automático</p>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button class="btn btn-secondary" onclick="cerrarModalRegistro()">Cancelar</button>
            <button class="btn btn-primary" onclick="guardarRegistroHoras()">
                <i class="fas fa-save"></i> Guardar Registro
            </button>
        </div>
    </div>
</div>

<!-- ===================== ESTILOS ESPECÍFICOS ===================== -->
<style>
    .horas-extra-gestion {
        display: flex;
        flex-direction: column;
        gap: 2rem;
    }

    .horas-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: var(--primary-light);
        padding: 2rem;
        border-radius: var(--border-radius);
        border: 2px solid var(--primary-color);
    }

    .header-acciones {
        display: flex;
        gap: 1rem;
    }

    .estadisticas-horas {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
    }

    .filtros-avanzados {
        background: var(--white);
        padding: 1.5rem;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        border: 2px solid var(--secondary-color);
    }

    .filtros-avanzados h3 {
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

    .filtro-item label {
        font-weight: 600;
        color: var(--gray-700);
        font-size: 0.9rem;
    }

    .filtro-item input,
    .filtro-item select {
        padding: 0.75rem;
        border: 2px solid var(--gray-300);
        border-radius: var(--border-radius);
        font-size: 1rem;
        background: var(--white);
    }

    .filtro-acciones {
        display: flex;
        gap: 1rem;
        justify-content: center;
    }

    .resumen-tipos {
        background: var(--white);
        padding: 1.5rem;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        border: 2px solid var(--accent-color);
        margin-bottom: 2rem;
    }

    .resumen-tipos h3 {
        color: var(--primary-color);
        margin-bottom: 2rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-size: 1.3rem;
    }

    .tipo-seccion {
        background: var(--gray-50);
        border-radius: var(--border-radius);
        padding: 1.5rem;
        margin-bottom: 2rem;
        border: 2px solid var(--gray-200);
    }

    .tipo-seccion:last-child {
        margin-bottom: 0;
    }

    .tipo-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid var(--gray-200);
    }

    .tipo-header h4 {
        color: var(--gray-800);
        font-size: 1.2rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin: 0;
    }

    .contador-tipo {
        background: var(--primary-color);
        color: var(--white);
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.9rem;
        font-weight: 600;
    }

    .metricas-tipo {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .metrica-tipo {
        background: var(--white);
        padding: 1.5rem;
        border-radius: var(--border-radius);
        border: 2px solid var(--gray-200);
        display: flex;
        align-items: center;
        gap: 1rem;
        transition: var(--transition);
    }

    .metrica-tipo:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-hover);
    }

    .metrica-icon {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--white);
        font-size: 1.2rem;
    }

    .metrica-icon.estudiante {
        background: linear-gradient(135deg, #3b82f6, #1d4ed8);
    }

    .metrica-icon.maestro {
        background: linear-gradient(135deg, #10b981, #047857);
    }

    .lista-personas {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .persona-item {
        background: var(--white);
        padding: 1.5rem;
        border-radius: var(--border-radius);
        border: 2px solid var(--gray-200);
        display: flex;
        align-items: center;
        gap: 1.5rem;
        transition: var(--transition);
    }

    .persona-item:hover {
        border-color: var(--primary-color);
        transform: translateY(-1px);
        box-shadow: var(--shadow-hover);
    }

    .persona-item.estudiante .persona-avatar {
        background: linear-gradient(135deg, #3b82f6, #1d4ed8);
    }

    .persona-item.maestro .persona-avatar {
        background: linear-gradient(135deg, #10b981, #047857);
    }

    .persona-item .persona-avatar {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--white);
        font-size: 1.5rem;
        flex-shrink: 0;
    }

    .persona-datos {
        flex: 1;
    }

    .persona-datos h5 {
        margin: 0 0 0.25rem 0;
        color: var(--gray-800);
        font-size: 1.1rem;
    }

    .persona-datos p {
        margin: 0;
        color: var(--gray-600);
        font-size: 0.9rem;
    }

    .persona-metricas-mini {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1rem;
        margin-right: 1rem;
    }

    .metrica-mini {
        text-align: center;
        background: var(--gray-50);
        padding: 0.75rem;
        border-radius: var(--border-radius);
        border: 1px solid var(--gray-200);
        min-width: 80px;
    }

    .metrica-mini.total {
        background: var(--primary-light);
        border-color: var(--primary-color);
    }

    .metrica-mini.entrada {
        background: var(--info-light);
        border-color: var(--info-color);
    }

    .metrica-mini.salida {
        background: var(--warning-light);
        border-color: var(--warning-color);
    }

    .metrica-mini .valor {
        display: block;
        font-weight: 700;
        color: var(--gray-800);
        font-size: 1rem;
        margin-bottom: 0.25rem;
    }

    .metrica-mini.total .valor {
        color: var(--primary-color);
    }

    .metrica-mini.entrada .valor {
        color: var(--info-color);
    }

    .metrica-mini.salida .valor {
        color: var(--warning-color);
    }

    .metrica-mini .label {
        font-size: 0.75rem;
        color: var(--gray-600);
        font-weight: 500;
    }

    .persona-acciones {
        display: flex;
        gap: 0.5rem;
    }

    .btn-sm {
        padding: 0.5rem 1rem;
        font-size: 0.9rem;
    }

    .empty-tipo {
        text-align: center;
        padding: 3rem 1rem;
        color: var(--gray-500);
    }

    .empty-tipo i {
        color: var(--gray-400);
        margin-bottom: 1rem;
    }

    .empty-tipo p {
        margin: 0;
        font-style: italic;
    }

    .resumen-personas {
        background: var(--white);
        padding: 1.5rem;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        border: 2px solid var(--accent-color);
    }

    .resumen-personas h3 {
        color: var(--primary-color);
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .personas-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
    }

    .persona-resumen-card {
        background: var(--gray-50);
        border: 2px solid var(--gray-200);
        border-radius: var(--border-radius);
        padding: 1.5rem;
        transition: var(--transition);
    }

    .persona-resumen-card:hover {
        border-color: var(--primary-color);
        transform: translateY(-2px);
    }

    .persona-header {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .persona-avatar {
        width: 50px;
        height: 50px;
        background: var(--primary-color);
        color: var(--white);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
    }

    .persona-info h4 {
        margin: 0 0 0.25rem 0;
        color: var(--gray-800);
        font-size: 1.1rem;
    }

    .persona-info p {
        margin: 0;
        color: var(--gray-600);
        font-size: 0.9rem;
    }

    .persona-metricas {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
    }

    .metrica {
        text-align: center;
        background: var(--white);
        padding: 1rem;
        border-radius: var(--border-radius);
        border: 1px solid var(--gray-200);
    }

    .metrica-valor {
        display: block;
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--primary-color);
        margin-bottom: 0.25rem;
    }

    .metrica-label {
        font-size: 0.8rem;
        color: var(--gray-600);
    }

    .registros-lista {
        background: var(--white);
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        overflow: hidden;
        border: 2px solid var(--gray-200);
    }

    .lista-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1.5rem;
        background: var(--gray-50);
        border-bottom: 2px solid var(--gray-200);
    }

    .lista-header h3 {
        color: var(--primary-color);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .lista-controles select {
        padding: 0.5rem 1rem;
        border: 2px solid var(--gray-300);
        border-radius: var(--border-radius);
        background: var(--white);
    }

    .registro-card {
        border-bottom: 2px solid var(--gray-200);
        padding: 2rem;
        transition: var(--transition);
    }

    .registro-card:last-child {
        border-bottom: none;
    }

    .registro-card:hover {
        background: var(--gray-50);
    }

    .registro-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }

    .registro-persona {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .persona-datos h4 {
        margin: 0 0 0.25rem 0;
        color: var(--gray-800);
        font-size: 1.2rem;
    }

    .persona-datos p {
        margin: 0 0 0.25rem 0;
        color: var(--gray-600);
        font-size: 0.9rem;
    }

    .fecha-registro {
        color: var(--gray-500);
        font-size: 0.8rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .registro-estado {
        text-align: right;
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .total-horas {
        font-size: 1.2rem;
        font-weight: 700;
    }

    .horarios-desglose {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 2rem;
        margin-bottom: 1.5rem;
        padding: 1.5rem;
        background: var(--gray-50);
        border-radius: var(--border-radius);
        border: 2px solid var(--gray-200);
    }

    .horario-grupo h5 {
        color: var(--primary-color);
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .horario-comparacion {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    .horario-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: var(--white);
        padding: 0.75rem;
        border-radius: var(--border-radius);
        border: 1px solid var(--gray-200);
    }

    .horario-label {
        font-weight: 600;
        color: var(--gray-700);
    }

    .horario-valor {
        font-weight: 700;
        font-size: 1.1rem;
    }

    .horario-valor.tardanza {
        color: var(--danger-color);
    }

    .horario-valor.temprano {
        color: var(--success-color);
    }

    .horario-diferencia {
        text-align: center;
        margin-top: 0.75rem;
    }

    .diferencia-valor {
        padding: 0.5rem 1rem;
        border-radius: var(--border-radius);
        font-weight: 700;
        color: var(--white);
    }

    .diferencia-valor.tardanza {
        background: var(--danger-color);
    }

    .diferencia-valor.temprano {
        background: var(--success-color);
    }

    .motivos-autorizaciones {
        background: var(--white);
        padding: 1.5rem;
        border-radius: var(--border-radius);
        border: 2px solid var(--gray-200);
        margin-bottom: 1.5rem;
    }

    .motivo-item,
    .autorizacion-item {
        margin-bottom: 1rem;
    }

    .motivo-item:last-child,
    .autorizacion-item:last-child {
        margin-bottom: 0;
    }

    .motivo-item h6,
    .autorizacion-item h6 {
        color: var(--gray-700);
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.9rem;
    }

    .motivo-item p,
    .autorizacion-item p {
        margin: 0;
        color: var(--gray-600);
        font-style: italic;
        padding-left: 1.5rem;
    }

    .registro-acciones {
        display: flex;
        justify-content: center;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .motivos-section {
        margin-bottom: 2rem;
    }

    .calculo-preview {
        background: var(--gray-50);
        padding: 1.5rem;
        border-radius: var(--border-radius);
        border: 2px solid var(--gray-200);
    }

    .calculo-preview h4 {
        color: var(--primary-color);
        margin-bottom: 1rem;
    }

    #preview-calculo {
        font-size: 1.1rem;
        color: var(--gray-700);
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

    @media (max-width: 768px) {
        .horas-header {
            flex-direction: column;
            gap: 1.5rem;
        }

        .header-acciones {
            width: 100%;
            justify-content: center;
        }

        .filtros-grid {
            grid-template-columns: 1fr;
        }

        .filtro-acciones {
            grid-column: 1;
            justify-content: stretch;
            flex-direction: column;
        }

        .personas-grid {
            grid-template-columns: 1fr;
        }

        .horarios-desglose {
            grid-template-columns: 1fr;
            gap: 1rem;
        }

        .registro-header {
            flex-direction: column;
            gap: 1rem;
            text-align: center;
        }

        .registro-acciones {
            flex-direction: column;
        }

        .form-grid {
            grid-template-columns: 1fr;
        }

        .persona-metricas-mini {
            grid-template-columns: repeat(2, 1fr);
            margin-right: 0;
            width: 100%;
        }

        .tipo-header {
            flex-direction: column;
            gap: 1rem;
            text-align: center;
        }

        .metricas-tipo {
            grid-template-columns: 1fr;
        }

        .persona-item {
            flex-direction: column;
            text-align: center;
            gap: 1rem;
        }

        .lista-header {
            flex-direction: column;
            gap: 1rem;
        }
    }
</style>

<!-- ===================== SCRIPTS ESPECÍFICOS ===================== -->
<script>
    // Aplicar filtros
    function aplicarFiltros() {
        const fechaInicio = document.getElementById('fecha-inicio').value;
        const fechaFin = document.getElementById('fecha-fin').value;
        const tipo = document.getElementById('filtro-tipo').value;
        const estado = document.getElementById('filtro-estado').value;
        const plantel = document.getElementById('filtro-plantel-horas').value;
        
        const params = new URLSearchParams(window.location.search);
        
        if (fechaInicio) params.set('fecha_inicio', fechaInicio);
        if (fechaFin) params.set('fecha_fin', fechaFin);
        if (tipo !== 'todos') params.set('tipo', tipo);
        else params.delete('tipo');
        if (estado !== 'todos') params.set('estado', estado);
        else params.delete('estado');
        if (plantel !== 'todos') params.set('plantel', plantel);
        else params.delete('plantel');
        
        window.location.search = params.toString();
    }

    // Limpiar filtros
    function limpiarFiltros() {
        const params = new URLSearchParams();
        window.location.search = params.toString();
    }

    // Buscar avanzado
    function buscarAvanzado() {
        showNotification('Aplicando búsqueda avanzada...', 'info');
        aplicarFiltros();
    }

    // Ordenar lista
    function ordenarLista() {
        const orden = document.getElementById('orden-lista').value;
        showNotification('Reordenando registros por: ' + orden, 'info');
        // Aquí implementarías la lógica de ordenamiento
    }

    // Aprobar registro
    function aprobarRegistro(id) {
        if (confirm('¿Aprobar este registro de horas extra?')) {
            showNotification('Registro aprobado exitosamente', 'success');
            // Aquí actualizarías el estado en la base de datos
        }
    }

    // Rechazar registro
    function rechazarRegistro(id) {
        const motivo = prompt('Motivo del rechazo:');
        if (motivo) {
            showNotification('Registro rechazado', 'warning');
            // Aquí actualizarías el estado en la base de datos
        }
    }

    // Editar registro
    function editarRegistro(id) {
        showNotification('Abriendo editor de registro...', 'info');
        // Aquí abrirías el modal de edición con los datos precargados
        abrirModalRegistro();
    }

    // Ver detalle completo
    function verDetalleCompleto(id) {
        showNotification('Cargando detalle completo...', 'info');
        // Aquí mostrarías un modal con toda la información del registro
    }

    // Duplicar registro
    function duplicarRegistro(id) {
        if (confirm('¿Crear un nuevo registro basado en este?')) {
            showNotification('Creando registro duplicado...', 'info');
            abrirModalRegistro();
        }
    }

    // Abrir modal de registro
    function abrirModalRegistro() {
        const modal = document.getElementById('modal-registro-horas');
        
        // Establecer fecha actual por defecto
        document.getElementById('fecha-registro').value = new Date().toISOString().split('T')[0];
        
        modal.style.display = 'flex';
        
        // Configurar listeners para cálculo automático
        configurarCalculoAutomatico();
    }

    // Cerrar modal de registro
    function cerrarModalRegistro() {
        document.getElementById('modal-registro-horas').style.display = 'none';
        document.getElementById('form-horas-extra').reset();
    }

    // Configurar cálculo automático
    function configurarCalculoAutomatico() {
        const inputs = ['entrada-programada', 'entrada-real', 'salida-programada', 'salida-real'];
        
        inputs.forEach(id => {
            document.getElementById(id).addEventListener('change', calcularHorasExtra);
        });
    }

    // Calcular horas extra automáticamente
    function calcularHorasExtra() {
        const entradaProg = document.getElementById('entrada-programada').value;
        const entradaReal = document.getElementById('entrada-real').value;
        const salidaProg = document.getElementById('salida-programada').value;
        const salidaReal = document.getElementById('salida-real').value;
        
        if (entradaProg && entradaReal && salidaProg && salidaReal) {
            const minutosEntrada = calcularDiferenciaMinutos(entradaProg, entradaReal);
            const minutosSalida = calcularDiferenciaMinutos(salidaProg, salidaReal);
            const totalMinutos = minutosEntrada + minutosSalida;
            
            const preview = document.getElementById('preview-calculo');
            preview.innerHTML = `
                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem; text-align: center;">
                    <div>
                        <strong>Entrada:</strong><br>
                        <span style="color: ${minutosEntrada > 0 ? 'var(--danger-color)' : 'var(--success-color)'};">
                            ${formatearMinutos(minutosEntrada)}
                        </span>
                    </div>
                    <div>
                        <strong>Salida:</strong><br>
                        <span style="color: ${minutosSalida > 0 ? 'var(--danger-color)' : 'var(--success-color)'};">
                            ${formatearMinutos(minutosSalida)}
                        </span>
                    </div>
                    <div>
                        <strong>Total:</strong><br>
                        <span style="color: ${totalMinutos > 0 ? 'var(--danger-color)' : 'var(--success-color)'}; font-size: 1.2rem;">
                            ${formatearMinutos(totalMinutos)}
                        </span>
                    </div>
                </div>
            `;
        }
    }

    // Calcular diferencia en minutos
    function calcularDiferenciaMinutos(horaProgramada, horaReal) {
        const [hProg, mProg] = horaProgramada.split(':').map(Number);
        const [hReal, mReal] = horaReal.split(':').map(Number);
        
        const minutosProg = hProg * 60 + mProg;
        const minutosReal = hReal * 60 + mReal;
        
        return minutosReal - minutosProg;
    }

    // Formatear minutos a horas y minutos
    function formatearMinutos(minutos) {
        if (minutos == 0) return '0h 0m';
        
        const esNegativo = minutos < 0;
        minutos = Math.abs(minutos);
        
        const horas = Math.floor(minutos / 60);
        const mins = minutos % 60;
        
        let resultado = '';
        if (horas > 0) resultado += horas + 'h ';
        if (mins > 0) resultado += mins + 'm';
        
        return esNegativo ? '-' + resultado : resultado;
    }

    // Guardar registro de horas
    function guardarRegistroHoras() {
        const form = document.getElementById('form-horas-extra');
        
        if (form.checkValidity()) {
            showNotification('Guardando registro de horas extra...', 'info');
            
            setTimeout(() => {
                showNotification('Registro guardado exitosamente', 'success');
                cerrarModalRegistro();
                // Aquí recargarías la página o actualizarías la lista
            }, 2000);
        } else {
            showNotification('Por favor complete todos los campos requeridos', 'error');
        }
    }

    // Ver detalle de persona específica
    function verDetallePersona(personaId, tipo) {
        showNotification(`Cargando detalle de ${tipo}...`, 'info');
        
        // Aquí implementarías la lógica para mostrar el detalle específico
        // Por ahora simulamos la carga
        setTimeout(() => {
            showNotification(`Detalle de ${tipo} cargado`, 'success');
            // Podrías abrir un modal con información detallada
        }, 1500);
    }

    // Exportar horas extra
    function exportarHorasExtra() {
        showNotification('Generando reporte de horas extra...', 'info');
        
        setTimeout(() => {
            showNotification('Reporte exportado exitosamente', 'success');
        }, 2000);
    }
</script>
