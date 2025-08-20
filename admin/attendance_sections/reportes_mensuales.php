<?php
// Obtener mes y año actual o seleccionado
$mes_actual = $_GET['mes'] ?? date('n');
$ano_actual = $_GET['ano'] ?? date('Y');

// Datos de ejemplo para reportes mensuales
$estudiantes_reporte = [
    [
        'id' => 'STU001',
        'nombre' => 'Ana Sofia Martinez',
        'grado' => '3er Grado',
        'grupo' => 'A',
        'plantel' => 'El Zapote',
        'dias_asistencia' => 18,
        'dias_ausencia' => 2,
        'dias_tardanza' => 3,
        'horas_extra_entrada' => 45, // minutos acumulados
        'horas_extra_salida' => 120,
        'porcentaje_asistencia' => 90,
        'detalles_diarios' => [
            '2024-01-01' => ['entrada' => '08:05', 'salida' => '14:00', 'estado' => 'presente'],
            '2024-01-02' => ['entrada' => '08:00', 'salida' => '14:15', 'estado' => 'presente'],
            '2024-01-03' => ['entrada' => null, 'salida' => null, 'estado' => 'ausente'],
            // ... más días
        ]
    ],
    [
        'id' => 'STU002',
        'nombre' => 'Diego Alejandro Ruiz',
        'grado' => '1er Grado',
        'grupo' => 'B',
        'plantel' => 'Insurgentes',
        'dias_asistencia' => 20,
        'dias_ausencia' => 0,
        'dias_tardanza' => 1,
        'horas_extra_entrada' => 15,
        'horas_extra_salida' => 60,
        'porcentaje_asistencia' => 100,
        'detalles_diarios' => []
    ],
    [
        'id' => 'MAE001',
        'nombre' => 'Profesora Laura Gonzalez',
        'grado' => '2do Grado',
        'plantel' => 'El Zapote',
        'dias_asistencia' => 20,
        'dias_ausencia' => 0,
        'dias_tardanza' => 0,
        'horas_extra_entrada' => -30, // llegó antes
        'horas_extra_salida' => 180, // se quedó después
        'porcentaje_asistencia' => 100,
        'detalles_diarios' => []
    ]
];

// Obtener filtros
$filtro_plantel = $_GET['plantel'] ?? 'todos';
$filtro_grado = $_GET['grado'] ?? 'todos';
$ver_detalle = $_GET['detalle'] ?? null;

// Filtrar estudiantes
$estudiantes_filtrados = array_filter($estudiantes_reporte, function($estudiante) use ($filtro_plantel, $filtro_grado) {
    $cumple_plantel = ($filtro_plantel === 'todos' || $estudiante['plantel'] === $filtro_plantel);
    $cumple_grado = ($filtro_grado === 'todos' || $estudiante['grado'] === $filtro_grado);
    
    return $cumple_plantel && $cumple_grado;
});

// Función para obtener nombres de meses
function obtenerNombreMes($numero) {
    $meses = [
        1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril',
        5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto',
        9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'
    ];
    return $meses[$numero];
}

function formatearHorasMinutos($minutos) {
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

function obtenerColorPorcentaje($porcentaje) {
    if ($porcentaje >= 95) return 'success';
    if ($porcentaje >= 85) return 'warning';
    return 'danger';
}
?>

<!-- ===================== REPORTES MENSUALES ===================== -->
<div class="reportes-mensuales">
    <!-- Header con selector de período -->
    <div class="reportes-header">
        <div class="header-info">
            <h2 style="color: var(--primary-color); margin-bottom: 0.5rem;">
                <i class="fas fa-chart-bar"></i> Reportes Mensuales de Asistencia
            </h2>
            <p style="color: var(--gray-600);">
                Análisis detallado de asistencias, horas extras y patrones de comportamiento
            </p>
        </div>
        
        <div class="periodo-selector">
            <div class="selector-grupo">
                <label for="mes-select">Mes:</label>
                <select id="mes-select" onchange="cambiarPeriodo()">
                    <?php for($i = 1; $i <= 12; $i++): ?>
                    <option value="<?= $i ?>" <?= $mes_actual == $i ? 'selected' : '' ?>>
                        <?= obtenerNombreMes($i) ?>
                    </option>
                    <?php endfor; ?>
                </select>
            </div>
            
            <div class="selector-grupo">
                <label for="ano-select">Año:</label>
                <select id="ano-select" onchange="cambiarPeriodo()">
                    <?php for($i = date('Y'); $i >= date('Y') - 3; $i--): ?>
                    <option value="<?= $i ?>" <?= $ano_actual == $i ? 'selected' : '' ?>>
                        <?= $i ?>
                    </option>
                    <?php endfor; ?>
                </select>
            </div>
        </div>
    </div>

    <!-- Estadísticas Generales -->
    <div class="estadisticas-generales">
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-content">
                <div class="stat-number"><?= count($estudiantes_filtrados) ?></div>
                <div class="stat-label">Total Personas</div>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-percentage"></i>
            </div>
            <div class="stat-content">
                <div class="stat-number">
                    <?= round(array_sum(array_column($estudiantes_filtrados, 'porcentaje_asistencia')) / count($estudiantes_filtrados), 1) ?>%
                </div>
                <div class="stat-label">Asistencia Promedio</div>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-content">
                <div class="stat-number">
                    <?= formatearHorasMinutos(array_sum(array_column($estudiantes_filtrados, 'horas_extra_entrada')) + array_sum(array_column($estudiantes_filtrados, 'horas_extra_salida'))) ?>
                </div>
                <div class="stat-label">Horas Extra Total</div>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div class="stat-content">
                <div class="stat-number"><?= array_sum(array_column($estudiantes_filtrados, 'dias_tardanza')) ?></div>
                <div class="stat-label">Total Tardanzas</div>
            </div>
        </div>
    </div>

    <!-- Filtros -->
    <div class="filtros-container">
        <h3><i class="fas fa-filter"></i> Filtros de Reporte</h3>
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
                <label for="filtro-grado">Grado:</label>
                <select id="filtro-grado" onchange="aplicarFiltros()">
                    <option value="todos">Todos los grados</option>
                    <option value="Guardería" <?= $filtro_grado === 'Guardería' ? 'selected' : '' ?>>Guardería</option>
                    <option value="Preescolar" <?= $filtro_grado === 'Preescolar' ? 'selected' : '' ?>>Preescolar</option>
                    <option value="1er Grado" <?= $filtro_grado === '1er Grado' ? 'selected' : '' ?>>1er Grado</option>
                    <option value="2do Grado" <?= $filtro_grado === '2do Grado' ? 'selected' : '' ?>>2do Grado</option>
                    <option value="3er Grado" <?= $filtro_grado === '3er Grado' ? 'selected' : '' ?>>3er Grado</option>
                </select>
            </div>
            
            <div class="filtro-acciones">
                <button class="btn btn-secondary" onclick="limpiarFiltros()">
                    <i class="fas fa-eraser"></i> Limpiar
                </button>
                <button class="btn btn-success" onclick="exportarExcel()">
                    <i class="fas fa-file-excel"></i> Excel
                </button>
                <button class="btn btn-danger" onclick="exportarPDF()">
                    <i class="fas fa-file-pdf"></i> PDF
                </button>
            </div>
        </div>
    </div>

    <!-- Lista de Reportes Individuales -->
    <div class="reportes-lista">
        <?php if (empty($estudiantes_filtrados)): ?>
        <div class="empty-state">
            <i class="fas fa-chart-bar fa-3x"></i>
            <h3>No hay datos para mostrar</h3>
            <p>No se encontraron registros para el período y filtros seleccionados.</p>
        </div>
        <?php else: ?>
            <?php foreach ($estudiantes_filtrados as $estudiante): ?>
            <div class="reporte-card">
                <!-- Header del estudiante -->
                <div class="reporte-header">
                    <div class="estudiante-info">
                        <div class="estudiante-avatar">
                            <i class="fas fa-<?= strpos($estudiante['nombre'], 'Profesora') !== false ? 'chalkboard-teacher' : 'child' ?>"></i>
                        </div>
                        <div class="estudiante-detalles">
                            <h4><?= $estudiante['nombre'] ?></h4>
                            <p><?= $estudiante['grado'] ?> • <?= $estudiante['plantel'] ?></p>
                        </div>
                    </div>
                    
                    <div class="reporte-badges">
                        <span class="badge badge-<?= obtenerColorPorcentaje($estudiante['porcentaje_asistencia']) ?>">
                            <?= $estudiante['porcentaje_asistencia'] ?>% Asistencia
                        </span>
                        <?php if ($estudiante['dias_tardanza'] > 0): ?>
                        <span class="badge badge-warning">
                            <i class="fas fa-clock"></i> <?= $estudiante['dias_tardanza'] ?> Tardanzas
                        </span>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Métricas del mes -->
                <div class="metricas-mes">
                    <div class="metrica-item">
                        <div class="metrica-icon success">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="metrica-info">
                            <div class="metrica-numero"><?= $estudiante['dias_asistencia'] ?></div>
                            <div class="metrica-label">Días Asistencia</div>
                        </div>
                    </div>
                    
                    <div class="metrica-item">
                        <div class="metrica-icon danger">
                            <i class="fas fa-times-circle"></i>
                        </div>
                        <div class="metrica-info">
                            <div class="metrica-numero"><?= $estudiante['dias_ausencia'] ?></div>
                            <div class="metrica-label">Días Ausencia</div>
                        </div>
                    </div>
                    
                    <div class="metrica-item">
                        <div class="metrica-icon warning">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <div class="metrica-info">
                            <div class="metrica-numero"><?= $estudiante['dias_tardanza'] ?></div>
                            <div class="metrica-label">Tardanzas</div>
                        </div>
                    </div>
                    
                    <div class="metrica-item">
                        <div class="metrica-icon info">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="metrica-info">
                            <div class="metrica-numero">
                                <?= formatearHorasMinutos($estudiante['horas_extra_entrada'] + $estudiante['horas_extra_salida']) ?>
                            </div>
                            <div class="metrica-label">Horas Extra</div>
                        </div>
                    </div>
                </div>

                <!-- Desglose de horas extra -->
                <div class="horas-extra-desglose">
                    <h5><i class="fas fa-clock"></i> Desglose de Horas Extra</h5>
                    <div class="horas-grid">
                        <div class="hora-item">
                            <span class="hora-label">Entrada:</span>
                            <span class="hora-valor <?= $estudiante['horas_extra_entrada'] > 0 ? 'text-danger' : ($estudiante['horas_extra_entrada'] < 0 ? 'text-info' : 'text-success') ?>">
                                <?= formatearHorasMinutos($estudiante['horas_extra_entrada']) ?>
                            </span>
                        </div>
                        <div class="hora-item">
                            <span class="hora-label">Salida:</span>
                            <span class="hora-valor <?= $estudiante['horas_extra_salida'] > 0 ? 'text-danger' : 'text-success' ?>">
                                <?= formatearHorasMinutos($estudiante['horas_extra_salida']) ?>
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Gráfico de asistencia semanal -->
                <div class="grafico-semanal">
                    <h5><i class="fas fa-chart-line"></i> Patrón de Asistencia Semanal</h5>
                    <div class="semana-grid">
                        <?php 
                        $dias_semana = ['Lun', 'Mar', 'Mié', 'Jue', 'Vie'];
                        $asistencia_semanal = [95, 100, 85, 90, 100]; // Datos de ejemplo
                        foreach ($dias_semana as $index => $dia): 
                        ?>
                        <div class="dia-asistencia">
                            <div class="dia-barra">
                                <div class="barra-fill" style="height: <?= $asistencia_semanal[$index] ?>%"></div>
                            </div>
                            <div class="dia-label"><?= $dia ?></div>
                            <div class="dia-porcentaje"><?= $asistencia_semanal[$index] ?>%</div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Acciones -->
                <div class="reporte-acciones">
                    <button class="btn btn-outline-primary" onclick="verDetalleCompleto('<?= $estudiante['id'] ?>')">
                        <i class="fas fa-eye"></i> Ver Detalle Diario
                    </button>
                    <button class="btn btn-outline-success" onclick="exportarIndividual('<?= $estudiante['id'] ?>')">
                        <i class="fas fa-download"></i> Exportar
                    </button>
                    <button class="btn btn-outline-warning" onclick="enviarReporte('<?= $estudiante['id'] ?>')">
                        <i class="fas fa-paper-plane"></i> Enviar a Tutores
                    </button>
                </div>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <!-- Análisis Comparativo -->
    <div class="analisis-comparativo">
        <h3><i class="fas fa-chart-pie"></i> Análisis Comparativo del Mes</h3>
        <div class="comparativo-grid">
            <div class="comparativo-item">
                <h4>Mejor Asistencia</h4>
                <div class="comparativo-valor">
                    <?php 
                    $mejor = array_reduce($estudiantes_filtrados, function($carry, $item) {
                        return ($carry === null || $item['porcentaje_asistencia'] > $carry['porcentaje_asistencia']) ? $item : $carry;
                    });
                    ?>
                    <?= $mejor ? $mejor['nombre'] : 'N/A' ?><br>
                    <small><?= $mejor ? $mejor['porcentaje_asistencia'] . '%' : '' ?></small>
                </div>
            </div>
            
            <div class="comparativo-item">
                <h4>Más Horas Extra</h4>
                <div class="comparativo-valor">
                    <?php 
                    $masHoras = array_reduce($estudiantes_filtrados, function($carry, $item) {
                        $horas = $item['horas_extra_entrada'] + $item['horas_extra_salida'];
                        return ($carry === null || $horas > ($carry['horas_extra_entrada'] + $carry['horas_extra_salida'])) ? $item : $carry;
                    });
                    ?>
                    <?= $masHoras ? $masHoras['nombre'] : 'N/A' ?><br>
                    <small><?= $masHoras ? formatearHorasMinutos($masHoras['horas_extra_entrada'] + $masHoras['horas_extra_salida']) : '' ?></small>
                </div>
            </div>
            
            <div class="comparativo-item">
                <h4>Más Puntual</h4>
                <div class="comparativo-valor">
                    <?php 
                    $masPuntual = array_reduce($estudiantes_filtrados, function($carry, $item) {
                        return ($carry === null || $item['dias_tardanza'] < $carry['dias_tardanza']) ? $item : $carry;
                    });
                    ?>
                    <?= $masPuntual ? $masPuntual['nombre'] : 'N/A' ?><br>
                    <small><?= $masPuntual ? $masPuntual['dias_tardanza'] . ' tardanzas' : '' ?></small>
                </div>
            </div>
            
            <div class="comparativo-item">
                <h4>Promedio General</h4>
                <div class="comparativo-valor">
                    Asistencia: <?= round(array_sum(array_column($estudiantes_filtrados, 'porcentaje_asistencia')) / count($estudiantes_filtrados), 1) ?>%<br>
                    <small>Tardanzas: <?= round(array_sum(array_column($estudiantes_filtrados, 'dias_tardanza')) / count($estudiantes_filtrados), 1) ?></small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Detalle Diario -->
<div id="modal-detalle-diario" class="modal" style="display: none;">
    <div class="modal-content modal-lg">
        <div class="modal-header">
            <h3 id="modal-detalle-titulo">Detalle Diario de Asistencia</h3>
            <span class="modal-close" onclick="cerrarModal()">&times;</span>
        </div>
        <div class="modal-body" id="modal-detalle-body">
            <!-- Contenido dinámico -->
        </div>
        <div class="modal-footer">
            <button class="btn btn-secondary" onclick="cerrarModal()">Cerrar</button>
            <button class="btn btn-primary" onclick="exportarDetalleDiario()">
                <i class="fas fa-download"></i> Exportar Detalle
            </button>
        </div>
    </div>
</div>

<!-- ===================== ESTILOS ESPECÍFICOS ===================== -->
<style>
    .reportes-mensuales {
        display: flex;
        flex-direction: column;
        gap: 2rem;
        padding: 0;
    }

    .reportes-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: var(--primary-light);
        padding: 2rem;
        border-radius: var(--border-radius);
        border: 2px solid var(--primary-color);
    }

    .periodo-selector {
        display: flex;
        gap: 1.5rem;
        align-items: end;
    }

    .selector-grupo {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .selector-grupo label {
        font-weight: 600;
        color: var(--gray-700);
        font-size: 0.9rem;
    }

    .selector-grupo select {
        padding: 0.75rem;
        border: 2px solid var(--gray-300);
        border-radius: var(--border-radius);
        font-size: 1rem;
        background: var(--white);
        min-width: 120px;
    }

    .estadisticas-generales {
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
        grid-template-columns: 1fr 1fr auto;
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
    }

    .reportes-lista {
        display: flex;
        flex-direction: column;
        gap: 2rem;
    }

    .reporte-card {
        background: var(--white);
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        border: 2px solid var(--gray-200);
        overflow: hidden;
        transition: var(--transition);
    }

    .reporte-card:hover {
        border-color: var(--primary-color);
        box-shadow: var(--shadow-hover);
    }

    .reporte-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1.5rem;
        background: var(--gray-50);
        border-bottom: 2px solid var(--gray-200);
    }

    .estudiante-info {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .estudiante-avatar {
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

    .estudiante-detalles h4 {
        margin: 0 0 0.25rem 0;
        color: var(--gray-800);
        font-size: 1.2rem;
    }

    .estudiante-detalles p {
        margin: 0;
        color: var(--gray-600);
        font-size: 0.9rem;
    }

    .reporte-badges {
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
    }

    .metricas-mes {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 1.5rem;
        padding: 1.5rem;
        background: var(--gray-50);
    }

    .metrica-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        background: var(--white);
        padding: 1rem;
        border-radius: var(--border-radius);
        border: 2px solid var(--gray-200);
    }

    .metrica-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--white);
        font-size: 1.2rem;
    }

    .metrica-icon.success {
        background: var(--success-color);
    }

    .metrica-icon.danger {
        background: var(--danger-color);
    }

    .metrica-icon.warning {
        background: var(--warning-color);
    }

    .metrica-icon.info {
        background: var(--info-color);
    }

    .metrica-numero {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--gray-800);
        line-height: 1;
    }

    .metrica-label {
        color: var(--gray-600);
        font-size: 0.8rem;
    }

    .horas-extra-desglose {
        padding: 1.5rem;
        border-bottom: 2px solid var(--gray-200);
    }

    .horas-extra-desglose h5 {
        color: var(--primary-color);
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .horas-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }

    .hora-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: var(--gray-50);
        padding: 1rem;
        border-radius: var(--border-radius);
        border: 2px solid var(--gray-200);
    }

    .hora-label {
        font-weight: 600;
        color: var(--gray-700);
    }

    .hora-valor {
        font-weight: 700;
        font-size: 1.1rem;
    }

    .text-success {
        color: var(--success-color);
    }

    .text-danger {
        color: var(--danger-color);
    }

    .text-info {
        color: var(--info-color);
    }

    .grafico-semanal {
        padding: 1.5rem;
        border-bottom: 2px solid var(--gray-200);
    }

    .grafico-semanal h5 {
        color: var(--primary-color);
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .semana-grid {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 1rem;
    }

    .dia-asistencia {
        text-align: center;
    }

    .dia-barra {
        height: 80px;
        background: var(--gray-200);
        border-radius: var(--border-radius);
        position: relative;
        margin-bottom: 0.5rem;
    }

    .barra-fill {
        background: linear-gradient(to top, var(--primary-color), var(--secondary-color));
        border-radius: var(--border-radius);
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        transition: height 0.3s ease;
    }

    .dia-label {
        font-weight: 600;
        color: var(--gray-700);
        font-size: 0.9rem;
        margin-bottom: 0.25rem;
    }

    .dia-porcentaje {
        font-size: 0.8rem;
        color: var(--primary-color);
        font-weight: 600;
    }

    .reporte-acciones {
        display: flex;
        justify-content: center;
        gap: 1rem;
        padding: 1.5rem;
    }

    .analisis-comparativo {
        background: var(--white);
        padding: 2rem;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        border: 2px solid var(--accent-color);
    }

    .analisis-comparativo h3 {
        color: var(--primary-color);
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .comparativo-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
    }

    .comparativo-item {
        text-align: center;
        background: var(--gray-50);
        padding: 1.5rem;
        border-radius: var(--border-radius);
        border: 2px solid var(--gray-200);
    }

    .comparativo-item h4 {
        margin: 0 0 1rem 0;
        color: var(--gray-700);
        font-size: 1rem;
    }

    .comparativo-valor {
        font-weight: 600;
        color: var(--primary-color);
        font-size: 1.1rem;
    }

    .comparativo-valor small {
        color: var(--gray-600);
        font-weight: normal;
    }

    .modal-lg {
        max-width: 800px;
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
        .reportes-header {
            flex-direction: column;
            gap: 1.5rem;
        }

        .periodo-selector {
            width: 100%;
            justify-content: center;
        }

        .filtros-grid {
            grid-template-columns: 1fr;
            gap: 1rem;
        }

        .filtro-acciones {
            justify-content: center;
            flex-wrap: wrap;
        }

        .metricas-mes {
            grid-template-columns: repeat(2, 1fr);
        }

        .horas-grid {
            grid-template-columns: 1fr;
        }

        .reporte-acciones {
            flex-direction: column;
        }

        .comparativo-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .semana-grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }
</style>

<!-- ===================== SCRIPTS ESPECÍFICOS ===================== -->
<script>
    // Cambiar período
    function cambiarPeriodo() {
        const mes = document.getElementById('mes-select').value;
        const ano = document.getElementById('ano-select').value;
        
        const params = new URLSearchParams(window.location.search);
        params.set('mes', mes);
        params.set('ano', ano);
        window.location.search = params.toString();
    }

    // Aplicar filtros
    function aplicarFiltros() {
        const plantel = document.getElementById('filtro-plantel').value;
        const grado = document.getElementById('filtro-grado').value;
        
        const params = new URLSearchParams(window.location.search);
        
        if (plantel !== 'todos') params.set('plantel', plantel);
        else params.delete('plantel');
        
        if (grado !== 'todos') params.set('grado', grado);
        else params.delete('grado');
        
        window.location.search = params.toString();
    }

    // Limpiar filtros
    function limpiarFiltros() {
        const params = new URLSearchParams(window.location.search);
        params.delete('plantel');
        params.delete('grado');
        window.location.search = params.toString();
    }

    // Ver detalle completo
    function verDetalleCompleto(estudianteId) {
        const modal = document.getElementById('modal-detalle-diario');
        const titulo = document.getElementById('modal-detalle-titulo');
        const body = document.getElementById('modal-detalle-body');
        
        titulo.textContent = 'Detalle Diario - Enero 2024';
        
        // Generar calendario con datos de ejemplo
        body.innerHTML = `
            <div class="calendario-detalle">
                <div class="calendario-header">
                    <h4>Registro Diario de Asistencia</h4>
                    <p>Visualización completa del mes con entradas, salidas y observaciones</p>
                </div>
                <div class="calendario-grid">
                    ${generarCalendarioDetalle()}
                </div>
                <div class="leyenda-calendario">
                    <div class="leyenda-item">
                        <span class="leyenda-color presente"></span> Presente
                    </div>
                    <div class="leyenda-item">
                        <span class="leyenda-color tardanza"></span> Tardanza
                    </div>
                    <div class="leyenda-item">
                        <span class="leyenda-color ausente"></span> Ausente
                    </div>
                    <div class="leyenda-item">
                        <span class="leyenda-color horas-extra"></span> Horas Extra
                    </div>
                </div>
            </div>
        `;
        
        modal.style.display = 'flex';
    }

    // Generar calendario detalle
    function generarCalendarioDetalle() {
        const dias = [];
        const estados = ['presente', 'tardanza', 'ausente', 'horas-extra'];
        
        for (let i = 1; i <= 31; i++) {
            const estado = estados[Math.floor(Math.random() * estados.length)];
            const entrada = estado !== 'ausente' ? '08:' + String(Math.floor(Math.random() * 30)).padStart(2, '0') : '--:--';
            const salida = estado !== 'ausente' ? '14:' + String(Math.floor(Math.random() * 30)).padStart(2, '0') : '--:--';
            
            dias.push(`
                <div class="dia-calendario ${estado}">
                    <div class="dia-numero">${i}</div>
                    <div class="dia-horarios">
                        <div class="entrada">E: ${entrada}</div>
                        <div class="salida">S: ${salida}</div>
                    </div>
                </div>
            `);
        }
        
        return dias.join('');
    }

    // Cerrar modal
    function cerrarModal() {
        document.getElementById('modal-detalle-diario').style.display = 'none';
    }

    // Exportar individual
    function exportarIndividual(estudianteId) {
        showNotification('Generando reporte individual...', 'info');
        setTimeout(() => {
            showNotification('Reporte individual generado', 'success');
        }, 2000);
    }

    // Enviar reporte
    function enviarReporte(estudianteId) {
        if (confirm('¿Enviar reporte mensual a los tutores?')) {
            showNotification('Enviando reporte a tutores...', 'info');
            setTimeout(() => {
                showNotification('Reporte enviado exitosamente', 'success');
            }, 2000);
        }
    }

    // Exportar Excel
    function exportarExcel() {
        showNotification('Generando archivo Excel...', 'info');
        setTimeout(() => {
            showNotification('Archivo Excel descargado', 'success');
        }, 2000);
    }

    // Exportar PDF
    function exportarPDF() {
        showNotification('Generando PDF...', 'info');
        setTimeout(() => {
            showNotification('PDF generado y descargado', 'success');
        }, 2000);
    }

    // Exportar detalle diario
    function exportarDetalleDiario() {
        showNotification('Exportando detalle diario...', 'info');
        setTimeout(() => {
            showNotification('Detalle diario exportado', 'success');
            cerrarModal();
        }, 1500);
    }
</script>

<style>
    .calendario-detalle {
        padding: 1rem;
    }

    .calendario-header {
        text-align: center;
        margin-bottom: 2rem;
    }

    .calendario-header h4 {
        color: var(--primary-color);
        margin-bottom: 0.5rem;
    }

    .calendario-grid {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 0.5rem;
        margin-bottom: 2rem;
    }

    .dia-calendario {
        background: var(--gray-50);
        border: 2px solid var(--gray-200);
        border-radius: var(--border-radius);
        padding: 0.75rem;
        text-align: center;
        min-height: 80px;
        font-size: 0.8rem;
    }

    .dia-calendario.presente {
        background: var(--success-light);
        border-color: var(--success-color);
    }

    .dia-calendario.tardanza {
        background: var(--warning-light);
        border-color: var(--warning-color);
    }

    .dia-calendario.ausente {
        background: var(--danger-light);
        border-color: var(--danger-color);
    }

    .dia-calendario.horas-extra {
        background: var(--info-light);
        border-color: var(--info-color);
    }

    .dia-numero {
        font-weight: 700;
        color: var(--gray-800);
        margin-bottom: 0.5rem;
    }

    .dia-horarios {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }

    .entrada,
    .salida {
        font-size: 0.7rem;
        color: var(--gray-600);
    }

    .leyenda-calendario {
        display: flex;
        justify-content: center;
        gap: 2rem;
        flex-wrap: wrap;
    }

    .leyenda-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.9rem;
    }

    .leyenda-color {
        width: 20px;
        height: 20px;
        border-radius: 50%;
        border: 2px solid var(--gray-300);
    }

    .leyenda-color.presente {
        background: var(--success-color);
    }

    .leyenda-color.tardanza {
        background: var(--warning-color);
    }

    .leyenda-color.ausente {
        background: var(--danger-color);
    }

    .leyenda-color.horas-extra {
        background: var(--info-color);
    }
</style>
