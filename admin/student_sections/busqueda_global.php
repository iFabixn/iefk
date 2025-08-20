<?php
// Parámetros de búsqueda
$search_query = $_GET['q'] ?? '';
$search_plantel = $_GET['plantel'] ?? '';
$search_nivel = $_GET['nivel'] ?? '';
$search_status = $_GET['status'] ?? '';

// Datos simulados de estudiantes
$estudiantes = [
    [
        'id' => 1001,
        'nombre' => 'Sofia García Méndez',
        'edad' => 4,
        'plantel' => 'El Zapote',
        'aula' => 'Preescolar 1A',
        'nivel' => 'Preescolar',
        'status' => 'Activo',
        'tutor' => 'Ana Méndez García',
        'telefono' => '555-0123',
        'expediente' => 'EZ-2024-1001',
        'alergias' => true,
        'medicamentos' => true
    ],
    [
        'id' => 1002,
        'nombre' => 'Diego Hernández López',
        'edad' => 3,
        'plantel' => 'El Zapote',
        'aula' => 'Guardería B',
        'nivel' => 'Guardería',
        'status' => 'Activo',
        'tutor' => 'María López Hernández',
        'telefono' => '555-0124',
        'expediente' => 'EZ-2024-1002',
        'alergias' => false,
        'medicamentos' => false
    ],
    [
        'id' => 1003,
        'nombre' => 'Isabella Rodríguez Santos',
        'edad' => 6,
        'plantel' => 'Insurgentes',
        'aula' => 'Primaria 1B',
        'nivel' => 'Primaria',
        'status' => 'Activo',
        'tutor' => 'Carlos Santos Rodríguez',
        'telefono' => '555-0125',
        'expediente' => 'IN-2024-1003',
        'alergias' => false,
        'medicamentos' => true
    ],
    [
        'id' => 1004,
        'nombre' => 'Mateo González Pérez',
        'edad' => 5,
        'plantel' => 'El Zapote',
        'aula' => 'Preescolar 2A',
        'nivel' => 'Preescolar',
        'status' => 'Pendiente Documentos',
        'tutor' => 'Laura Pérez González',
        'telefono' => '555-0126',
        'expediente' => 'EZ-2024-1004',
        'alergias' => true,
        'medicamentos' => false
    ]
];

// Aplicar filtros de búsqueda
$resultados = array_filter($estudiantes, function($estudiante) use ($search_query, $search_plantel, $search_nivel, $search_status) {
    $match_query = empty($search_query) || 
                  stripos($estudiante['nombre'], $search_query) !== false ||
                  stripos($estudiante['expediente'], $search_query) !== false ||
                  stripos($estudiante['tutor'], $search_query) !== false;
    
    $match_plantel = empty($search_plantel) || $estudiante['plantel'] === $search_plantel;
    $match_nivel = empty($search_nivel) || $estudiante['nivel'] === $search_nivel;
    $match_status = empty($search_status) || $estudiante['status'] === $search_status;
    
    return $match_query && $match_plantel && $match_nivel && $match_status;
});

$total_resultados = count($resultados);
?>

<!-- ===================== BÚSQUEDA GLOBAL ===================== -->
<div class="busqueda-global">
    <div class="content-body">
        <h2 style="color: var(--primary-color); margin-bottom: 2rem;">
            <i class="fas fa-search"></i> Búsqueda Global de Estudiantes
        </h2>
        
        <!-- Formulario de Búsqueda Avanzada -->
        <div class="search-container">
            <div class="search-form">
                <div class="search-row">
                    <div class="search-field">
                        <label for="search-query">Búsqueda General</label>
                        <input type="text" 
                               id="search-query" 
                               name="q"
                               value="<?= htmlspecialchars($search_query) ?>"
                               placeholder="Nombre, expediente, tutor...">
                    </div>
                    <div class="search-field">
                        <label for="search-plantel">Plantel</label>
                        <select id="search-plantel" name="plantel">
                            <option value="">Todos los Planteles</option>
                            <option value="El Zapote" <?= $search_plantel === 'El Zapote' ? 'selected' : '' ?>>El Zapote</option>
                            <option value="Insurgentes" <?= $search_plantel === 'Insurgentes' ? 'selected' : '' ?>>Insurgentes</option>
                            <option value="Lindavista" <?= $search_plantel === 'Lindavista' ? 'selected' : '' ?>>Lindavista</option>
                        </select>
                    </div>
                    <div class="search-field">
                        <label for="search-nivel">Nivel Educativo</label>
                        <select id="search-nivel" name="nivel">
                            <option value="">Todos los Niveles</option>
                            <option value="Guardería" <?= $search_nivel === 'Guardería' ? 'selected' : '' ?>>Guardería</option>
                            <option value="Preescolar" <?= $search_nivel === 'Preescolar' ? 'selected' : '' ?>>Preescolar</option>
                            <option value="Primaria" <?= $search_nivel === 'Primaria' ? 'selected' : '' ?>>Primaria</option>
                        </select>
                    </div>
                    <div class="search-field">
                        <label for="search-status">Estado</label>
                        <select id="search-status" name="status">
                            <option value="">Todos los Estados</option>
                            <option value="Activo" <?= $search_status === 'Activo' ? 'selected' : '' ?>>Activo</option>
                            <option value="Pendiente Documentos" <?= $search_status === 'Pendiente Documentos' ? 'selected' : '' ?>>Pendiente Documentos</option>
                            <option value="Suspendido" <?= $search_status === 'Suspendido' ? 'selected' : '' ?>>Suspendido</option>
                            <option value="Dado de Baja" <?= $search_status === 'Dado de Baja' ? 'selected' : '' ?>>Dado de Baja</option>
                        </select>
                    </div>
                    <div class="search-actions">
                        <button type="button" class="btn btn-primary" onclick="performSearch()">
                            <i class="fas fa-search"></i> Buscar
                        </button>
                        <button type="button" class="btn btn-secondary" onclick="clearSearch()">
                            <i class="fas fa-times"></i> Limpiar
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Resumen de Resultados -->
        <div class="search-results-summary">
            <div class="results-info">
                <h3>Resultados de Búsqueda</h3>
                <p>Se encontraron <strong><?= $total_resultados ?></strong> estudiantes que coinciden con los criterios de búsqueda.</p>
            </div>
            <div class="results-actions">
                <button class="btn btn-success" onclick="exportSearchResults()">
                    <i class="fas fa-file-excel"></i> Exportar Resultados
                </button>
                <button class="btn btn-info" onclick="printSearchResults()">
                    <i class="fas fa-print"></i> Imprimir Lista
                </button>
            </div>
        </div>
        
        <!-- Resultados de Búsqueda -->
        <div class="search-results">
            <?php if ($total_resultados > 0): ?>
                <div class="results-grid">
                    <?php foreach ($resultados as $estudiante): ?>
                    <div class="student-result-card" onclick="viewStudentFile(<?= $estudiante['id'] ?>)">
                        <div class="student-result-header">
                            <div class="student-avatar">
                                <?= strtoupper(substr($estudiante['nombre'], 0, 1) . substr(strstr($estudiante['nombre'], ' '), 1, 1)) ?>
                            </div>
                            <div class="student-basic-info">
                                <h4><?= $estudiante['nombre'] ?></h4>
                                <p><i class="fas fa-id-card"></i> <?= $estudiante['expediente'] ?></p>
                                <p><i class="fas fa-birthday-cake"></i> <?= $estudiante['edad'] ?> años</p>
                            </div>
                            <div class="student-status">
                                <span class="badge badge-<?= strtolower(str_replace(' ', '-', $estudiante['status'])) ?>">
                                    <?= $estudiante['status'] ?>
                                </span>
                            </div>
                        </div>
                        
                        <div class="student-result-details">
                            <div class="detail-item">
                                <i class="fas fa-school"></i>
                                <span><?= $estudiante['plantel'] ?> - <?= $estudiante['aula'] ?></span>
                            </div>
                            <div class="detail-item">
                                <i class="fas fa-graduation-cap"></i>
                                <span><?= $estudiante['nivel'] ?></span>
                            </div>
                            <div class="detail-item">
                                <i class="fas fa-user-tie"></i>
                                <span><?= $estudiante['tutor'] ?></span>
                            </div>
                            <div class="detail-item">
                                <i class="fas fa-phone"></i>
                                <span><?= $estudiante['telefono'] ?></span>
                            </div>
                        </div>
                        
                        <!-- Alertas Médicas -->
                        <div class="medical-alerts">
                            <?php if ($estudiante['alergias']): ?>
                            <div class="alert-badge allergy">
                                <i class="fas fa-exclamation-triangle"></i>
                                <span>Alergias</span>
                            </div>
                            <?php endif; ?>
                            <?php if ($estudiante['medicamentos']): ?>
                            <div class="alert-badge medication">
                                <i class="fas fa-pills"></i>
                                <span>Medicamentos</span>
                            </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="student-actions">
                            <button class="btn btn-primary btn-sm" onclick="viewStudentFile(<?= $estudiante['id'] ?>); event.stopPropagation();">
                                <i class="fas fa-eye"></i> Ver Ficha
                            </button>
                            <button class="btn btn-warning btn-sm" onclick="editStudent(<?= $estudiante['id'] ?>); event.stopPropagation();">
                                <i class="fas fa-edit"></i> Editar
                            </button>
                            <button class="btn btn-secondary btn-sm" onclick="contactParents(<?= $estudiante['id'] ?>); event.stopPropagation();">
                                <i class="fas fa-envelope"></i> Contactar
                            </button>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="no-results">
                    <div class="no-results-icon">
                        <i class="fas fa-search"></i>
                    </div>
                    <h3>No se encontraron resultados</h3>
                    <p>No hay estudiantes que coincidan con los criterios de búsqueda especificados.</p>
                    <p>Intenta modificar los filtros o realizar una búsqueda más amplia.</p>
                    <button class="btn btn-primary" onclick="clearSearch()">
                        <i class="fas fa-refresh"></i> Limpiar Búsqueda
                    </button>
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Búsquedas Rápidas -->
        <div class="quick-searches">
            <h3 style="color: var(--primary-color); margin-bottom: 1rem;">
                <i class="fas fa-bolt"></i> Búsquedas Rápidas
            </h3>
            <div class="quick-search-buttons">
                <button class="btn btn-outline-primary" onclick="quickSearch('alergias')">
                    <i class="fas fa-exclamation-triangle"></i>
                    Estudiantes con Alergias
                </button>
                <button class="btn btn-outline-primary" onclick="quickSearch('medicamentos')">
                    <i class="fas fa-pills"></i>
                    Estudiantes con Medicamentos
                </button>
                <button class="btn btn-outline-primary" onclick="quickSearch('pendientes')">
                    <i class="fas fa-file-alt"></i>
                    Documentos Pendientes
                </button>
                <button class="btn btn-outline-primary" onclick="quickSearch('nuevos')">
                    <i class="fas fa-user-plus"></i>
                    Estudiantes Nuevos
                </button>
                <button class="btn btn-outline-primary" onclick="quickSearch('cumpleanos')">
                    <i class="fas fa-birthday-cake"></i>
                    Cumpleaños del Mes
                </button>
                <button class="btn btn-outline-primary" onclick="quickSearch('inasistencias')">
                    <i class="fas fa-calendar-times"></i>
                    Inasistencias Frecuentes
                </button>
            </div>
        </div>
    </div>
</div>

<!-- ===================== SCRIPTS ESPECÍFICOS ===================== -->
<script>
    // Función para realizar búsqueda
    function performSearch() {
        const query = document.getElementById('search-query').value;
        const plantel = document.getElementById('search-plantel').value;
        const nivel = document.getElementById('search-nivel').value;
        const status = document.getElementById('search-status').value;
        
        const params = new URLSearchParams();
        if (query) params.append('q', query);
        if (plantel) params.append('plantel', plantel);
        if (nivel) params.append('nivel', nivel);
        if (status) params.append('status', status);
        
        // Simular búsqueda
        const url = `?section=busqueda_global&${params.toString()}`;
        window.location.href = url;
    }

    // Función para limpiar búsqueda
    function clearSearch() {
        document.getElementById('search-query').value = '';
        document.getElementById('search-plantel').value = '';
        document.getElementById('search-nivel').value = '';
        document.getElementById('search-status').value = '';
        window.location.href = '?section=busqueda_global';
    }

    // Función para búsquedas rápidas
    function quickSearch(type) {
        let searchParams = '';
        
        switch(type) {
            case 'alergias':
                searchParams = 'medical_condition=alergias';
                alert('Buscando estudiantes con alergias conocidas...');
                break;
            case 'medicamentos':
                searchParams = 'medical_condition=medicamentos';
                alert('Buscando estudiantes que requieren medicamentos...');
                break;
            case 'pendientes':
                searchParams = 'status=Pendiente%20Documentos';
                window.location.href = '?section=busqueda_global&status=Pendiente%20Documentos';
                return;
            case 'nuevos':
                searchParams = 'enrollment_date=recent';
                alert('Buscando estudiantes inscritos en los últimos 30 días...');
                break;
            case 'cumpleanos':
                searchParams = 'birthday_month=current';
                alert('Buscando estudiantes que cumplen años este mes...');
                break;
            case 'inasistencias':
                searchParams = 'attendance=low';
                alert('Buscando estudiantes con asistencia menor al 85%...');
                break;
        }
        
        // Simular búsqueda rápida
        console.log('Búsqueda rápida:', type, searchParams);
    }

    // Función para ver ficha de estudiante
    function viewStudentFile(studentId) {
        // Navegar a la ficha del estudiante
        changeSection('ficha_alumno', studentId);
    }

    // Función para editar estudiante
    function editStudent(studentId) {
        alert(`Editar Estudiante ID: ${studentId}\n\nSe abrirá el formulario de edición con todos los datos del estudiante.`);
    }

    // Función para contactar padres
    function contactParents(studentId) {
        alert(`Contactar Padres/Tutores\n\nEstudiante ID: ${studentId}\n\nOpciones disponibles:\n• Enviar email\n• Llamada telefónica\n• Mensaje SMS\n• Programar cita`);
    }

    // Función para exportar resultados
    function exportSearchResults() {
        if(confirm('¿Exportar resultados de búsqueda a Excel?')) {
            alert('Generando archivo Excel con los resultados de búsqueda...\n\nEl archivo incluirá:\n• Lista de estudiantes encontrados\n• Información básica de contacto\n• Estado de documentación\n• Alertas médicas');
        }
    }

    // Función para imprimir resultados
    function printSearchResults() {
        if(confirm('¿Imprimir lista de resultados?')) {
            window.print();
        }
    }

    // Buscar al presionar Enter
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('search-query').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                performSearch();
            }
        });
        
        // Animación de entrada para las cartas
        const cards = document.querySelectorAll('.student-result-card');
        cards.forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            setTimeout(() => {
                card.style.transition = 'all 0.3s ease';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, index * 50);
        });
    });
</script>
