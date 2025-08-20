<?php
$plantelNames = [
    'zapote' => 'El Zapote',
    'rio_nilo' => 'Río Nilo',
    'colinas' => 'Colinas'
];

$currentPlantel = $plantel ?? 'zapote';
$plantelName = $plantelNames[$currentPlantel] ?? 'El Zapote';

// Datos simulados de aulas por plantel
$aulasData = [
    'zapote' => [
        ['name' => 'Guardería A', 'nivel' => 'Guardería', 'capacity' => 15, 'current' => 12, 'teacher' => 'María Fernández', 'edad' => '1-2 años'],
        ['name' => 'Guardería B', 'nivel' => 'Guardería', 'capacity' => 15, 'current' => 14, 'teacher' => 'Ana Castillo', 'edad' => '2-3 años'],
        ['name' => 'Guardería C', 'nivel' => 'Guardería', 'capacity' => 15, 'current' => 13, 'teacher' => 'Laura Méndez', 'edad' => '1-3 años'],
        ['name' => 'Preescolar 1A', 'nivel' => 'Preescolar', 'capacity' => 18, 'current' => 16, 'teacher' => 'Carmen Silva', 'edad' => '3-4 años'],
        ['name' => 'Preescolar 1B', 'nivel' => 'Preescolar', 'capacity' => 18, 'current' => 17, 'teacher' => 'Rosa Jiménez', 'edad' => '3-4 años'],
        ['name' => 'Preescolar 2A', 'nivel' => 'Preescolar', 'capacity' => 20, 'current' => 18, 'teacher' => 'Patricia Vega', 'edad' => '4-5 años'],
        ['name' => 'Preescolar 2B', 'nivel' => 'Preescolar', 'capacity' => 20, 'current' => 19, 'teacher' => 'Elena Torres', 'edad' => '4-5 años'],
        ['name' => 'Preescolar 3', 'nivel' => 'Preescolar', 'capacity' => 22, 'current' => 21, 'teacher' => 'Mónica Ruiz', 'edad' => '5-6 años'],
        ['name' => 'Primaria 1A', 'nivel' => 'Primaria', 'capacity' => 25, 'current' => 23, 'teacher' => 'Roberto García', 'edad' => '6-7 años'],
        ['name' => 'Primaria 1B', 'nivel' => 'Primaria', 'capacity' => 25, 'current' => 22, 'teacher' => 'Silvia López', 'edad' => '6-7 años'],
        ['name' => 'Primaria 2', 'nivel' => 'Primaria', 'capacity' => 28, 'current' => 25, 'teacher' => 'Fernando Díaz', 'edad' => '7-8 años'],
        ['name' => 'Primaria 3', 'nivel' => 'Primaria', 'capacity' => 30, 'current' => 18, 'teacher' => 'Guadalupe Morales', 'edad' => '8-9 años']
    ],
    'rio_nilo' => [
        ['name' => 'Guardería A', 'nivel' => 'Guardería', 'capacity' => 12, 'current' => 11, 'teacher' => 'Claudia Herrera', 'edad' => '1-2 años'],
        ['name' => 'Guardería B', 'nivel' => 'Guardería', 'capacity' => 15, 'current' => 13, 'teacher' => 'Beatriz Sánchez', 'edad' => '2-3 años'],
        ['name' => 'Guardería C', 'nivel' => 'Guardería', 'capacity' => 14, 'current' => 14, 'teacher' => 'Adriana Cruz', 'edad' => '1-3 años'],
        ['name' => 'Preescolar 1A', 'nivel' => 'Preescolar', 'capacity' => 16, 'current' => 15, 'teacher' => 'Norma Peña', 'edad' => '3-4 años'],
        ['name' => 'Preescolar 1B', 'nivel' => 'Preescolar', 'capacity' => 18, 'current' => 16, 'teacher' => 'Raquel Flores', 'edad' => '3-4 años'],
        ['name' => 'Preescolar 2A', 'nivel' => 'Preescolar', 'capacity' => 20, 'current' => 17, 'teacher' => 'Irene Vargas', 'edad' => '4-5 años'],
        ['name' => 'Preescolar 2B', 'nivel' => 'Preescolar', 'capacity' => 19, 'current' => 19, 'teacher' => 'Diana Romero', 'edad' => '4-5 años'],
        ['name' => 'Primaria 1A', 'nivel' => 'Primaria', 'capacity' => 22, 'current' => 20, 'teacher' => 'Miguel Guerrero', 'edad' => '6-7 años'],
        ['name' => 'Primaria 1B', 'nivel' => 'Primaria', 'capacity' => 24, 'current' => 21, 'teacher' => 'Teresa Aguilar', 'edad' => '6-7 años'],
        ['name' => 'Primaria 2', 'nivel' => 'Primaria', 'capacity' => 26, 'current' => 19, 'teacher' => 'Arturo Mendoza', 'edad' => '7-8 años'],
        ['name' => 'Primaria 3', 'nivel' => 'Primaria', 'capacity' => 28, 'current' => 0, 'teacher' => 'Vacante', 'edad' => '8-9 años']
    ],
    'colinas' => [
        ['name' => 'Guardería A', 'nivel' => 'Guardería', 'capacity' => 14, 'current' => 13, 'teacher' => 'Sofía Ramírez', 'edad' => '1-2 años'],
        ['name' => 'Guardería B', 'nivel' => 'Guardería', 'capacity' => 16, 'current' => 15, 'teacher' => 'Verónica Castro', 'edad' => '2-3 años'],
        ['name' => 'Guardería C', 'nivel' => 'Guardería', 'capacity' => 15, 'current' => 12, 'teacher' => 'Alejandra Osorio', 'edad' => '1-3 años'],
        ['name' => 'Preescolar 1A', 'nivel' => 'Preescolar', 'capacity' => 18, 'current' => 17, 'teacher' => 'Lucía Delgado', 'edad' => '3-4 años'],
        ['name' => 'Preescolar 1B', 'nivel' => 'Preescolar', 'capacity' => 18, 'current' => 16, 'teacher' => 'Gabriela Herrera', 'edad' => '3-4 años'],
        ['name' => 'Preescolar 2A', 'nivel' => 'Preescolar', 'capacity' => 20, 'current' => 18, 'teacher' => 'Mariana Campos', 'edad' => '4-5 años'],
        ['name' => 'Preescolar 2B', 'nivel' => 'Preescolar', 'capacity' => 19, 'current' => 5, 'teacher' => 'Cristina Mejía', 'edad' => '4-5 años'],
        ['name' => 'Primaria 1A', 'nivel' => 'Primaria', 'capacity' => 24, 'current' => 22, 'teacher' => 'Andrés Salinas', 'edad' => '6-7 años'],
        ['name' => 'Primaria 1B', 'nivel' => 'Primaria', 'capacity' => 22, 'current' => 19, 'teacher' => 'Paola Núñez', 'edad' => '6-7 años'],
        ['name' => 'Primaria 2', 'nivel' => 'Primaria', 'capacity' => 25, 'current' => 0, 'teacher' => 'Vacante', 'edad' => '7-8 años']
    ]
];

$aulas = $aulasData[$currentPlantel] ?? [];
?>

<!-- ===================== HEADER DEL PLANTEL ===================== -->
<div class="content-header">
    <h1 class="content-title">
        <i class="fas fa-school"></i>
        Aulas del Plantel <?= $plantelName ?>
    </h1>
    <p class="content-description">
        Gestión detallada de aulas y grupos por nivel educativo. Visualice la ocupación, maestros asignados y acceda a la lista de estudiantes.
    </p>
</div>

<!-- ===================== NAVEGACIÓN RÁPIDA ===================== -->
<div class="content-body" style="margin-bottom: 2rem;">
    <div class="search-grid">
        <button class="btn btn-primary" onclick="navigateTo('planteles')">
            <i class="fas fa-arrow-left"></i>
            Volver a Planteles
        </button>
        
        <button class="btn btn-success" onclick="showAllStudents('<?= $currentPlantel ?>')">
            <i class="fas fa-users"></i>
            Ver Todos los Estudiantes
        </button>
        
        <button class="btn btn-warning" onclick="exportClassroomData('<?= $currentPlantel ?>')">
            <i class="fas fa-file-excel"></i>
            Exportar Datos del Plantel
        </button>
        
        <button class="btn btn-secondary" onclick="addNewClassroom('<?= $currentPlantel ?>')">
            <i class="fas fa-plus"></i>
            Agregar Nueva Aula
        </button>
    </div>
</div>

<!-- ===================== ESTADÍSTICAS DEL PLANTEL ===================== -->
<div class="content-body" style="margin-bottom: 2rem;">
    <h3 style="color: var(--primary-color); margin-bottom: 1.5rem;">
        <i class="fas fa-chart-bar"></i>
        Estadísticas del Plantel <?= $plantelName ?>
    </h3>
    
    <div class="info-grid">
        <?php
        $totalCapacity = array_sum(array_column($aulas, 'capacity'));
        $totalCurrent = array_sum(array_column($aulas, 'current'));
        $occupancyRate = $totalCapacity > 0 ? round(($totalCurrent / $totalCapacity) * 100, 1) : 0;
        
        $guarderia = array_filter($aulas, fn($aula) => $aula['nivel'] === 'Guardería');
        $preescolar = array_filter($aulas, fn($aula) => $aula['nivel'] === 'Preescolar');
        $primaria = array_filter($aulas, fn($aula) => $aula['nivel'] === 'Primaria');
        ?>
        
        <div class="info-section">
            <h4><i class="fas fa-users"></i> Ocupación General</h4>
            <div class="stat-value" style="font-size: 2rem; text-align: center; margin: 1rem 0;">
                <?= $totalCurrent ?>/<?= $totalCapacity ?>
            </div>
            <div class="info-item">
                <span class="info-label">Tasa de Ocupación</span>
                <span class="info-value badge <?= $occupancyRate >= 80 ? 'badge-active' : ($occupancyRate >= 60 ? 'badge-pending' : 'badge-inactive') ?>">
                    <?= $occupancyRate ?>%
                </span>
            </div>
        </div>
        
        <div class="info-section">
            <h4><i class="fas fa-baby"></i> Guardería</h4>
            <div class="info-item">
                <span class="info-label">Aulas</span>
                <span class="info-value"><?= count($guarderia) ?></span>
            </div>
            <div class="info-item">
                <span class="info-label">Estudiantes</span>
                <span class="info-value"><?= array_sum(array_column($guarderia, 'current')) ?></span>
            </div>
            <div class="info-item">
                <span class="info-label">Capacidad</span>
                <span class="info-value"><?= array_sum(array_column($guarderia, 'capacity')) ?></span>
            </div>
        </div>
        
        <div class="info-section">
            <h4><i class="fas fa-child"></i> Preescolar</h4>
            <div class="info-item">
                <span class="info-label">Aulas</span>
                <span class="info-value"><?= count($preescolar) ?></span>
            </div>
            <div class="info-item">
                <span class="info-label">Estudiantes</span>
                <span class="info-value"><?= array_sum(array_column($preescolar, 'current')) ?></span>
            </div>
            <div class="info-item">
                <span class="info-label">Capacidad</span>
                <span class="info-value"><?= array_sum(array_column($preescolar, 'capacity')) ?></span>
            </div>
        </div>
        
        <div class="info-section">
            <h4><i class="fas fa-graduation-cap"></i> Primaria</h4>
            <div class="info-item">
                <span class="info-label">Aulas</span>
                <span class="info-value"><?= count($primaria) ?></span>
            </div>
            <div class="info-item">
                <span class="info-label">Estudiantes</span>
                <span class="info-value"><?= array_sum(array_column($primaria, 'current')) ?></span>
            </div>
            <div class="info-item">
                <span class="info-label">Capacidad</span>
                <span class="info-value"><?= array_sum(array_column($primaria, 'capacity')) ?></span>
            </div>
        </div>
    </div>
</div>

<!-- ===================== AULAS POR NIVEL ===================== -->
<?php
$niveles = ['Guardería' => 'baby', 'Preescolar' => 'child', 'Primaria' => 'graduation-cap'];
foreach ($niveles as $nivel => $icon):
    $aulasNivel = array_filter($aulas, fn($aula) => $aula['nivel'] === $nivel);
    if (empty($aulasNivel)) continue;
?>
<div class="content-body" style="margin-bottom: 2rem;">
    <h3 style="color: var(--primary-color); margin-bottom: 1.5rem;">
        <i class="fas fa-<?= $icon ?>"></i>
        <?= $nivel ?>
    </h3>
    
    <div class="aulas-grid">
        <?php foreach ($aulasNivel as $index => $aula): 
            $occupancyPercent = $aula['capacity'] > 0 ? round(($aula['current'] / $aula['capacity']) * 100) : 0;
            $statusClass = $aula['current'] == 0 ? 'inactive' : ($occupancyPercent >= 90 ? 'active' : 'pending');
        ?>
        <div class="aula-card" onclick="navigateTo('alumnos', {plantel: '<?= $currentPlantel ?>', aula: '<?= $aula['name'] ?>'})">
            <div class="aula-header" style="display: flex; justify-content: space-between; align-items: center;">
                <div class="aula-name"><?= $aula['name'] ?></div>
                <div class="aula-capacity">
                    <?= $aula['current'] ?>/<?= $aula['capacity'] ?>
                </div>
            </div>
            
            <div class="info-item">
                <span class="info-label">Maestro(a)</span>
                <span class="info-value"><?= $aula['teacher'] ?></span>
            </div>
            
            <div class="info-item">
                <span class="info-label">Rango de Edad</span>
                <span class="info-value"><?= $aula['edad'] ?></span>
            </div>
            
            <div class="info-item">
                <span class="info-label">Nivel Educativo</span>
                <span class="info-value"><?= $aula['nivel'] ?></span>
            </div>
            
            <div style="margin: 1rem 0;">
                <div style="background: var(--gray-200); height: 8px; border-radius: 4px; overflow: hidden;">
                    <div style="background: var(--primary-color); height: 100%; width: <?= $occupancyPercent ?>%; transition: var(--transition);"></div>
                </div>
                <div style="font-size: 0.8rem; color: var(--gray-600); margin-top: 0.25rem; text-align: center;">
                    Ocupación: <?= $occupancyPercent ?>%
                </div>
            </div>
            
            <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 1rem;">
                <span class="badge badge-<?= $statusClass ?>">
                    <?= $aula['current'] == 0 ? 'Vacía' : ($occupancyPercent >= 90 ? 'Completa' : 'Disponible') ?>
                </span>
                
                <div style="display: flex; gap: 0.5rem;">
                    <button class="btn btn-primary btn-sm" onclick="event.stopPropagation(); editClassroom('<?= $aula['name'] ?>')" title="Editar Aula">
                        <i class="fas fa-edit"></i>
                    </button>
                    
                    <button class="btn btn-success btn-sm" onclick="event.stopPropagation(); viewStudentList('<?= $currentPlantel ?>', '<?= $aula['name'] ?>')" title="Ver Estudiantes">
                        <i class="fas fa-users"></i>
                    </button>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>
<?php endforeach; ?>

<!-- ===================== ACCIONES ADICIONALES ===================== -->
<div class="content-body">
    <h3 style="color: var(--primary-color); margin-bottom: 1.5rem;">
        <i class="fas fa-tools"></i>
        Acciones Adicionales
    </h3>
    
    <div class="info-grid">
        <button class="btn btn-primary" onclick="generateClassroomReport('<?= $currentPlantel ?>')">
            <i class="fas fa-file-alt"></i>
            Generar Reporte de Aulas
        </button>
        
        <button class="btn btn-success" onclick="manageTeachers('<?= $currentPlantel ?>')">
            <i class="fas fa-chalkboard-teacher"></i>
            Gestionar Maestros
        </button>
        
        <button class="btn btn-warning" onclick="checkCapacity('<?= $currentPlantel ?>')">
            <i class="fas fa-exclamation-triangle"></i>
            Verificar Capacidades
        </button>
        
        <button class="btn btn-secondary" onclick="scheduleActivities('<?= $currentPlantel ?>')">
            <i class="fas fa-calendar"></i>
            Programar Actividades
        </button>
    </div>
</div>

<!-- ===================== SCRIPTS ESPECÍFICOS ===================== -->
<script>
    // Función para mostrar todos los estudiantes del plantel
    function showAllStudents(plantel) {
        navigateTo('busqueda', {plantel: plantel});
    }

    // Función para exportar datos del aula
    function exportClassroomData(plantel) {
        if(confirm('¿Exportar datos completos del plantel a Excel?')) {
            alert('Generando archivo Excel con:\n\n' +
                  '• Lista de aulas y capacidades\n' +
                  '• Asignación de maestros\n' +
                  '• Estadísticas de ocupación\n' +
                  '• Lista completa de estudiantes\n\n' +
                  'El archivo se descargará automáticamente.');
        }
    }

    // Función para agregar nueva aula
    function addNewClassroom(plantel) {
        const aulaName = prompt('Nombre de la nueva aula:');
        if(aulaName) {
            alert(`Creando nueva aula "${aulaName}" en plantel ${plantel}\n\n` +
                  'Se abrirá el formulario de configuración para:\n' +
                  '• Asignar maestro\n' +
                  '• Definir capacidad\n' +
                  '• Establecer nivel educativo\n' +
                  '• Configurar horarios');
        }
    }

    // Función para editar aula
    function editClassroom(aulaName) {
        alert(`Editando configuración del aula: ${aulaName}\n\n` +
              'Opciones disponibles:\n' +
              '• Cambiar maestro asignado\n' +
              '• Modificar capacidad\n' +
              '• Actualizar información\n' +
              '• Gestionar horarios');
    }

    // Función para ver lista de estudiantes
    function viewStudentList(plantel, aula) {
        navigateTo('alumnos', {plantel: plantel, aula: aula});
    }

    // Función para generar reporte de aulas
    function generateClassroomReport(plantel) {
        if(confirm('¿Generar reporte detallado de aulas?')) {
            alert('Generando reporte que incluye:\n\n' +
                  '• Estado de ocupación por aula\n' +
                  '• Asignación de maestros\n' +
                  '• Distribución por edades\n' +
                  '• Capacidades y disponibilidad\n\n' +
                  'El reporte se generará en PDF.');
        }
    }

    // Función para gestionar maestros
    function manageTeachers(plantel) {
        alert('Gestión de Maestros:\n\n' +
              'Funciones disponibles:\n' +
              '• Asignar maestros a aulas\n' +
              '• Ver historial de asignaciones\n' +
              '• Gestionar sustitutos\n' +
              '• Actualizar información de contacto');
    }

    // Función para verificar capacidades
    function checkCapacity(plantel) {
        alert('Verificación de Capacidades:\n\n' +
              'Estado actual:\n' +
              '• Aulas con sobrecupo: 0\n' +
              '• Aulas cerca del límite: 3\n' +
              '• Aulas con disponibilidad: 8\n' +
              '• Aulas vacías: 1');
    }

    // Función para programar actividades
    function scheduleActivities(plantel) {
        alert('Programación de Actividades:\n\n' +
              'Próximas actividades:\n' +
              '• Festival de primavera\n' +
              '• Día de los padres\n' +
              '• Obras de teatro\n' +
              '• Deportes y competencias');
    }

    // Efectos visuales para las tarjetas de aulas
    document.addEventListener('DOMContentLoaded', function() {
        const aulaCards = document.querySelectorAll('.aula-card');
        aulaCards.forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            setTimeout(() => {
                card.style.transition = 'all 0.5s ease';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, index * 50);
        });
    });
</script>
