<?php
// Datos estadísticos simulados
$stats_generales = [
    'total_estudiantes' => 1247,
    'total_activos' => 1198,
    'total_nuevos_mes' => 23,
    'total_egresos_mes' => 8,
    'estudiantes_guarderia' => 342,
    'estudiantes_preescolar' => 456,
    'estudiantes_primaria' => 449,
    'promedio_edad' => 4.8,
    'tasa_asistencia' => 94.2,
    'documentos_pendientes' => 45,
    'alertas_medicas' => 89
];

$stats_planteles = [
    'El Zapote' => [
        'total' => 458,
        'guarderia' => 156,
        'preescolar' => 167,
        'primaria' => 135,
        'ocupacion' => 91.6,
        'capacidad' => 500
    ],
    'Insurgentes' => [
        'total' => 412,
        'guarderia' => 98,
        'preescolar' => 145,
        'primaria' => 169,
        'ocupacion' => 88.2,
        'capacidad' => 467
    ],
    'Lindavista' => [
        'total' => 377,
        'guarderia' => 88,
        'preescolar' => 144,
        'primaria' => 145,
        'ocupacion' => 85.4,
        'capacidad' => 441
    ]
];

$datos_mensuales = [
    'Enero' => ['inscripciones' => 45, 'egresos' => 12, 'asistencia' => 92.1],
    'Febrero' => ['inscripciones' => 38, 'egresos' => 8, 'asistencia' => 93.4],
    'Marzo' => ['inscripciones' => 52, 'egresos' => 15, 'asistencia' => 91.8],
    'Abril' => ['inscripciones' => 41, 'egresos' => 9, 'asistencia' => 94.2],
    'Mayo' => ['inscripciones' => 35, 'egresos' => 11, 'asistencia' => 93.7],
    'Junio' => ['inscripciones' => 28, 'egresos' => 18, 'asistencia' => 90.5],
    'Julio' => ['inscripciones' => 15, 'egresos' => 22, 'asistencia' => 89.2],
    'Agosto' => ['inscripciones' => 62, 'egresos' => 6, 'asistencia' => 95.1],
    'Septiembre' => ['inscripciones' => 48, 'egresos' => 7, 'asistencia' => 94.8],
    'Octubre' => ['inscripciones' => 31, 'egresos' => 9, 'asistencia' => 93.9],
    'Noviembre' => ['inscripciones' => 25, 'egresos' => 11, 'asistencia' => 92.6],
    'Diciembre' => ['inscripciones' => 18, 'egresos' => 14, 'asistencia' => 88.9]
];

$edad_distribucion = [
    '1-2 años' => 89,
    '3 años' => 167,
    '4 años' => 198,
    '5 años' => 234,
    '6 años' => 289,
    '7-8 años' => 270
];

$alertas_medicas = [
    'Alergias Alimentarias' => 34,
    'Alergias Ambientales' => 28,
    'Asma' => 15,
    'Diabetes' => 3,
    'Problemas de Visión' => 22,
    'Problemas de Audición' => 8,
    'Medicamentos Regulares' => 45,
    'Dietas Especiales' => 19
];
?>

<!-- ===================== ESTADÍSTICAS Y REPORTES ===================== -->
<div class="estadisticas-reportes">
    <div class="content-body">
        <h2 style="color: var(--primary-color); margin-bottom: 2rem;">
            <i class="fas fa-chart-line"></i> Estadísticas y Reportes del Alumnado
        </h2>
        
        <!-- Resumen General -->
        <div class="stats-overview">
            <h3><i class="fas fa-chart-pie"></i> Resumen General</h3>
            <div class="stats-cards">
                <div class="stat-card primary">
                    <div class="stat-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-number"><?= number_format($stats_generales['total_estudiantes']) ?></div>
                        <div class="stat-label">Total de Estudiantes</div>
                    </div>
                </div>
                
                <div class="stat-card success">
                    <div class="stat-icon">
                        <i class="fas fa-user-check"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-number"><?= number_format($stats_generales['total_activos']) ?></div>
                        <div class="stat-label">Estudiantes Activos</div>
                    </div>
                </div>
                
                <div class="stat-card info">
                    <div class="stat-icon">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-number"><?= $stats_generales['total_nuevos_mes'] ?></div>
                        <div class="stat-label">Nuevos este Mes</div>
                    </div>
                </div>
                
                <div class="stat-card warning">
                    <div class="stat-icon">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-number"><?= $stats_generales['tasa_asistencia'] ?>%</div>
                        <div class="stat-label">Tasa de Asistencia</div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Distribución por Niveles -->
        <div class="stats-section">
            <h3><i class="fas fa-graduation-cap"></i> Distribución por Niveles Educativos</h3>
            <div class="chart-container">
                <div class="level-stats">
                    <div class="level-stat">
                        <div class="level-circle guarderia">
                            <span><?= $stats_generales['estudiantes_guarderia'] ?></span>
                        </div>
                        <div class="level-info">
                            <h4>Guardería</h4>
                            <p><?= number_format(($stats_generales['estudiantes_guarderia'] / $stats_generales['total_estudiantes']) * 100, 1) ?>% del total</p>
                        </div>
                    </div>
                    
                    <div class="level-stat">
                        <div class="level-circle preescolar">
                            <span><?= $stats_generales['estudiantes_preescolar'] ?></span>
                        </div>
                        <div class="level-info">
                            <h4>Preescolar</h4>
                            <p><?= number_format(($stats_generales['estudiantes_preescolar'] / $stats_generales['total_estudiantes']) * 100, 1) ?>% del total</p>
                        </div>
                    </div>
                    
                    <div class="level-stat">
                        <div class="level-circle primaria">
                            <span><?= $stats_generales['estudiantes_primaria'] ?></span>
                        </div>
                        <div class="level-info">
                            <h4>Primaria</h4>
                            <p><?= number_format(($stats_generales['estudiantes_primaria'] / $stats_generales['total_estudiantes']) * 100, 1) ?>% del total</p>
                        </div>
                    </div>
                </div>
                
                <!-- Gráfico de barras simulado -->
                <div class="bar-chart">
                    <div class="bar-item">
                        <div class="bar" style="height: <?= ($stats_generales['estudiantes_guarderia'] / $stats_generales['estudiantes_primaria']) * 100 ?>%"></div>
                        <span>Guardería</span>
                    </div>
                    <div class="bar-item">
                        <div class="bar" style="height: <?= ($stats_generales['estudiantes_preescolar'] / $stats_generales['estudiantes_primaria']) * 100 ?>%"></div>
                        <span>Preescolar</span>
                    </div>
                    <div class="bar-item">
                        <div class="bar" style="height: 100%"></div>
                        <span>Primaria</span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Estadísticas por Plantel -->
        <div class="stats-section">
            <h3><i class="fas fa-school"></i> Estadísticas por Plantel</h3>
            <div class="plantel-stats">
                <?php foreach ($stats_planteles as $plantel => $datos): ?>
                <div class="plantel-stat-card">
                    <h4><?= $plantel ?></h4>
                    <div class="plantel-numbers">
                        <div class="plantel-total">
                            <span class="number"><?= $datos['total'] ?></span>
                            <span class="label">Estudiantes</span>
                        </div>
                        <div class="plantel-occupation">
                            <div class="occupation-bar">
                                <div class="occupation-fill" style="width: <?= $datos['ocupacion'] ?>%"></div>
                            </div>
                            <span><?= $datos['ocupacion'] ?>% Ocupación</span>
                        </div>
                    </div>
                    <div class="plantel-breakdown">
                        <div class="breakdown-item">
                            <span>Guardería:</span>
                            <span><?= $datos['guarderia'] ?></span>
                        </div>
                        <div class="breakdown-item">
                            <span>Preescolar:</span>
                            <span><?= $datos['preescolar'] ?></span>
                        </div>
                        <div class="breakdown-item">
                            <span>Primaria:</span>
                            <span><?= $datos['primaria'] ?></span>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        
        <!-- Tendencias Mensuales -->
        <div class="stats-section">
            <h3><i class="fas fa-chart-line"></i> Tendencias de Inscripciones y Asistencia</h3>
            <div class="monthly-trends">
                <div class="trend-chart">
                    <?php foreach ($datos_mensuales as $mes => $datos): ?>
                    <div class="month-data">
                        <div class="month-label"><?= substr($mes, 0, 3) ?></div>
                        <div class="month-bars">
                            <div class="bar inscripciones" style="height: <?= ($datos['inscripciones'] / 62) * 100 ?>%"
                                 title="Inscripciones: <?= $datos['inscripciones'] ?>">
                            </div>
                            <div class="bar egresos" style="height: <?= ($datos['egresos'] / 22) * 100 ?>%"
                                 title="Egresos: <?= $datos['egresos'] ?>">
                            </div>
                        </div>
                        <div class="asistencia-indicator" style="background-color: hsl(<?= ($datos['asistencia'] - 85) * 8 ?>, 70%, 50%)">
                            <?= $datos['asistencia'] ?>%
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <div class="trend-legend">
                    <div class="legend-item">
                        <div class="legend-color inscripciones"></div>
                        <span>Inscripciones</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-color egresos"></div>
                        <span>Egresos</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-color asistencia"></div>
                        <span>% Asistencia</span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Distribución por Edades -->
        <div class="stats-section">
            <h3><i class="fas fa-birthday-cake"></i> Distribución por Edades</h3>
            <div class="age-distribution">
                <?php foreach ($edad_distribucion as $rango => $cantidad): ?>
                <div class="age-group">
                    <div class="age-label"><?= $rango ?></div>
                    <div class="age-bar">
                        <div class="age-fill" style="width: <?= ($cantidad / max($edad_distribucion)) * 100 ?>%"></div>
                        <span class="age-count"><?= $cantidad ?></span>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        
        <!-- Alertas Médicas -->
        <div class="stats-section">
            <h3><i class="fas fa-heartbeat"></i> Alertas Médicas por Tipo</h3>
            <div class="medical-stats">
                <?php foreach ($alertas_medicas as $tipo => $cantidad): ?>
                <div class="medical-alert-stat">
                    <div class="alert-icon">
                        <i class="fas fa-<?= $tipo === 'Alergias Alimentarias' ? 'utensils' : 
                                          ($tipo === 'Alergias Ambientales' ? 'leaf' : 
                                          ($tipo === 'Asma' ? 'lungs' : 
                                          ($tipo === 'Diabetes' ? 'tint' : 
                                          ($tipo === 'Problemas de Visión' ? 'eye' : 
                                          ($tipo === 'Problemas de Audición' ? 'deaf' : 
                                          ($tipo === 'Medicamentos Regulares' ? 'pills' : 'apple-alt')))))) ?>"></i>
                    </div>
                    <div class="alert-info">
                        <div class="alert-count"><?= $cantidad ?></div>
                        <div class="alert-type"><?= $tipo ?></div>
                        <div class="alert-percentage"><?= number_format(($cantidad / $stats_generales['total_estudiantes']) * 100, 1) ?>% del total</div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        
        <!-- Acciones de Reportes -->
        <div class="reports-section">
            <h3><i class="fas fa-file-alt"></i> Generar Reportes</h3>
            <div class="report-buttons">
                <button class="btn btn-primary" onclick="generateReport('general')">
                    <i class="fas fa-chart-pie"></i>
                    Reporte General
                </button>
                <button class="btn btn-success" onclick="generateReport('planteles')">
                    <i class="fas fa-school"></i>
                    Reporte por Planteles
                </button>
                <button class="btn btn-info" onclick="generateReport('medico')">
                    <i class="fas fa-heartbeat"></i>
                    Reporte Médico
                </button>
                <button class="btn btn-warning" onclick="generateReport('asistencia')">
                    <i class="fas fa-calendar-check"></i>
                    Reporte de Asistencia
                </button>
                <button class="btn btn-secondary" onclick="generateReport('demografico')">
                    <i class="fas fa-users"></i>
                    Reporte Demográfico
                </button>
                <button class="btn btn-outline-primary" onclick="generateReport('personalizado')">
                    <i class="fas fa-cog"></i>
                    Reporte Personalizado
                </button>
            </div>
        </div>
        
        <!-- Análisis Adicional -->
        <div class="additional-analysis">
            <h3><i class="fas fa-analytics"></i> Análisis Adicional</h3>
            <div class="analysis-grid">
                <div class="analysis-card">
                    <h4>Promedio de Edad</h4>
                    <div class="analysis-number"><?= $stats_generales['promedio_edad'] ?> años</div>
                    <p>La edad promedio de todos los estudiantes</p>
                </div>
                
                <div class="analysis-card">
                    <h4>Documentos Pendientes</h4>
                    <div class="analysis-number"><?= $stats_generales['documentos_pendientes'] ?></div>
                    <p>Estudiantes con documentación incompleta</p>
                </div>
                
                <div class="analysis-card">
                    <h4>Alertas Médicas</h4>
                    <div class="analysis-number"><?= $stats_generales['alertas_medicas'] ?></div>
                    <p>Estudiantes con condiciones médicas especiales</p>
                </div>
                
                <div class="analysis-card">
                    <h4>Tasa de Retención</h4>
                    <div class="analysis-number">96.8%</div>
                    <p>Estudiantes que continúan en la institución</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ===================== SCRIPTS ESPECÍFICOS ===================== -->
<script>
    // Función para generar reportes
    function generateReport(type) {
        let reportName = '';
        let reportDesc = '';
        
        switch(type) {
            case 'general':
                reportName = 'Reporte General de Alumnado';
                reportDesc = 'Estadísticas generales, distribución por niveles y planteles';
                break;
            case 'planteles':
                reportName = 'Reporte por Planteles';
                reportDesc = 'Análisis detallado de cada plantel y sus indicadores';
                break;
            case 'medico':
                reportName = 'Reporte Médico';
                reportDesc = 'Condiciones médicas, alergias y medicamentos por estudiante';
                break;
            case 'asistencia':
                reportName = 'Reporte de Asistencia';
                reportDesc = 'Tendencias de asistencia por período y estudiante';
                break;
            case 'demografico':
                reportName = 'Reporte Demográfico';
                reportDesc = 'Distribución por edades, género y nivel socioeconómico';
                break;
            case 'personalizado':
                reportName = 'Reporte Personalizado';
                reportDesc = 'Configurar filtros y métricas específicas';
                break;
        }
        
        if(type === 'personalizado') {
            alert(`${reportName}\n\nSe abrirá el configurador de reportes donde podrás:\n• Seleccionar métricas específicas\n• Aplicar filtros personalizados\n• Elegir formato de salida\n• Programar reportes automáticos`);
        } else {
            if(confirm(`Generar ${reportName}?\n\n${reportDesc}\n\nEl reporte se generará en formato PDF y Excel.`)) {
                alert(`Generando ${reportName}...\n\nPor favor espera mientras se procesa la información.\nEl archivo se descargará automáticamente.`);
            }
        }
    }

    // Animaciones al cargar
    document.addEventListener('DOMContentLoaded', function() {
        // Animación de contadores
        const statNumbers = document.querySelectorAll('.stat-number, .analysis-number');
        statNumbers.forEach(stat => {
            const finalNumber = stat.textContent;
            stat.textContent = '0';
            
            const increment = finalNumber / 50;
            let current = 0;
            
            const timer = setInterval(() => {
                current += increment;
                if (current >= finalNumber) {
                    stat.textContent = finalNumber;
                    clearInterval(timer);
                } else {
                    stat.textContent = Math.floor(current).toLocaleString();
                }
            }, 30);
        });
        
        // Animación de barras
        const bars = document.querySelectorAll('.bar, .age-fill, .occupation-fill');
        bars.forEach((bar, index) => {
            const originalWidth = bar.style.width || bar.style.height;
            bar.style.width = '0%';
            bar.style.height = '0%';
            
            setTimeout(() => {
                bar.style.transition = 'all 1s ease';
                bar.style.width = originalWidth;
                bar.style.height = originalWidth;
            }, index * 100);
        });
    });
</script>
