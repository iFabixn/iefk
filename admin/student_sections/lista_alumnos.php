<?php
$plantelNames = [
    'zapote' => 'El Zapote',
    'rio_nilo' => 'Río Nilo',
    'colinas' => 'Colinas'
];

$currentPlantel = $plantel ?? 'zapote';
$currentAula = $aula ?? 'Guardería A';
$plantelName = $plantelNames[$currentPlantel] ?? 'El Zapote';

// Datos simulados de estudiantes
$estudiantes = [
    [
        'id' => 1001,
        'nombre' => 'Sofia García Méndez',
        'edad' => 4,
        'fecha_nacimiento' => '2021-03-15',
        'fecha_inscripcion' => '2024-08-01',
        'status' => 'Activo',
        'tutor1' => 'Ana Méndez García',
        'tutor2' => 'Carlos García López',
        'telefono' => '555-0123',
        'emergencia' => '555-0124',
        'alergias' => 'Ninguna',
        'medicamentos' => 'Ninguno',
        'discapacidades' => 'Ninguna',
        'personas_autorizadas' => 2,
        'documentos_pendientes' => 0,
        'foto' => null
    ],
    [
        'id' => 1002,
        'nombre' => 'Carlos Martín Ruiz',
        'edad' => 3,
        'fecha_nacimiento' => '2022-01-20',
        'fecha_inscripcion' => '2024-08-01',
        'status' => 'Activo',
        'tutor1' => 'Laura Ruiz Sánchez',
        'tutor2' => 'Pedro Martín Torres',
        'telefono' => '555-0125',
        'emergencia' => '555-0126',
        'alergias' => 'Nueces, Mariscos',
        'medicamentos' => 'Inhalador (Asma)',
        'discapacidades' => 'Asma leve',
        'personas_autorizadas' => 3,
        'documentos_pendientes' => 1,
        'foto' => null
    ],
    [
        'id' => 1003,
        'nombre' => 'María Fernández López',
        'edad' => 5,
        'fecha_nacimiento' => '2020-05-08',
        'fecha_inscripcion' => '2023-09-01',
        'status' => 'Activo',
        'tutor1' => 'Carmen López Herrera',
        'tutor2' => 'José Fernández Ruiz',
        'telefono' => '555-0127',
        'emergencia' => '555-0128',
        'alergias' => 'Polen',
        'medicamentos' => 'Antihistamínico',
        'discapacidades' => 'Ninguna',
        'personas_autorizadas' => 4,
        'documentos_pendientes' => 0,
        'foto' => null
    ],
    [
        'id' => 1004,
        'nombre' => 'Diego Ramírez Castro',
        'edad' => 4,
        'fecha_nacimiento' => '2021-11-12',
        'fecha_inscripcion' => '2024-08-15',
        'status' => 'Activo',
        'tutor1' => 'Sofía Castro Morales',
        'tutor2' => 'Miguel Ramírez Vega',
        'telefono' => '555-0129',
        'emergencia' => '555-0130',
        'alergias' => 'Lácteos',
        'medicamentos' => 'Ninguno',
        'discapacidades' => 'Intolerancia a lactosa',
        'personas_autorizadas' => 2,
        'documentos_pendientes' => 2,
        'foto' => null
    ],
    [
        'id' => 1005,
        'nombre' => 'Emma Jiménez Flores',
        'edad' => 3,
        'fecha_nacimiento' => '2022-07-25',
        'fecha_inscripcion' => '2024-08-01',
        'status' => 'Activo',
        'tutor1' => 'Rosa Flores Delgado',
        'tutor2' => 'Antonio Jiménez Silva',
        'telefono' => '555-0131',
        'emergencia' => '555-0132',
        'alergias' => 'Ninguna',
        'medicamentos' => 'Vitaminas',
        'discapacidades' => 'Ninguna',
        'personas_autorizadas' => 3,
        'documentos_pendientes' => 0,
        'foto' => null
    ],
    [
        'id' => 1006,
        'nombre' => 'Sebastián Torres Vargas',
        'edad' => 4,
        'fecha_nacimiento' => '2021-09-14',
        'fecha_inscripcion' => '2024-07-20',
        'status' => 'Activo',
        'tutor1' => 'Patricia Vargas León',
        'tutor2' => 'Alejandro Torres Mendoza',
        'telefono' => '555-0133',
        'emergencia' => '555-0134',
        'alergias' => 'Huevo',
        'medicamentos' => 'Ninguno',
        'discapacidades' => 'Ninguna',
        'personas_autorizadas' => 2,
        'documentos_pendientes' => 1,
        'foto' => null
    ]
];
?>

<!-- ===================== HEADER DEL AULA ===================== -->
<div class="content-header">
    <h1 class="content-title">
        <i class="fas fa-users"></i>
        Estudiantes del Aula <?= $currentAula ?>
    </h1>
    <p class="content-description">
        Plantel <?= $plantelName ?> - Gestión detallada de estudiantes. Acceda a fichas completas, edite información y gestione documentación.
    </p>
</div>

<!-- ===================== NAVEGACIÓN Y FILTROS ===================== -->
<div class="search-filters">
    <div class="search-grid">
        <button class="btn btn-primary" onclick="navigateTo('aulas', {plantel: '<?= $currentPlantel ?>'})">
            <i class="fas fa-arrow-left"></i>
            Volver a Aulas
        </button>
        
        <div class="form-group" style="margin-bottom: 0;">
            <input type="text" class="form-input" placeholder="Buscar estudiante..." 
                   onkeyup="searchInCurrentList(this.value)" id="search-student">
        </div>
        
        <div class="form-group" style="margin-bottom: 0;">
            <select class="form-input" onchange="filterByStatus(this.value)" id="filter-status">
                <option value="">Todos los Estados</option>
                <option value="Activo">Activos</option>
                <option value="Inactivo">Inactivos</option>
                <option value="Pendiente">Pendientes</option>
            </select>
        </div>
        
        <button class="btn btn-success" onclick="exportStudentList('<?= $currentPlantel ?>', '<?= $currentAula ?>')">
            <i class="fas fa-file-excel"></i>
            Exportar Lista
        </button>
    </div>
</div>

<!-- ===================== ESTADÍSTICAS DEL AULA ===================== -->
<div class="content-body" style="margin-bottom: 2rem;">
    <h3 style="color: var(--primary-color); margin-bottom: 1.5rem;">
        <i class="fas fa-chart-bar"></i>
        Estadísticas del Aula <?= $currentAula ?>
    </h3>
    
    <div class="info-grid">
        <?php
        $totalEstudiantes = count($estudiantes);
        $estudiantesActivos = count(array_filter($estudiantes, fn($e) => $e['status'] === 'Activo'));
        $conAlergias = count(array_filter($estudiantes, fn($e) => $e['alergias'] !== 'Ninguna'));
        $conMedicamentos = count(array_filter($estudiantes, fn($e) => $e['medicamentos'] !== 'Ninguno' && $e['medicamentos'] !== 'Vitaminas'));
        $documentosPendientes = array_sum(array_column($estudiantes, 'documentos_pendientes'));
        ?>
        
        <div class="info-section">
            <h4><i class="fas fa-users"></i> Estudiantes</h4>
            <div class="stat-value" style="font-size: 2rem; text-align: center; margin: 1rem 0;">
                <?= $totalEstudiantes ?>
            </div>
            <div class="info-item">
                <span class="info-label">Activos</span>
                <span class="info-value badge badge-active"><?= $estudiantesActivos ?></span>
            </div>
        </div>
        
        <div class="info-section">
            <h4><i class="fas fa-exclamation-triangle"></i> Alergias</h4>
            <div class="info-item">
                <span class="info-label">Con Alergias</span>
                <span class="info-value badge badge-pending"><?= $conAlergias ?></span>
            </div>
            <div class="info-item">
                <span class="info-label">Sin Alergias</span>
                <span class="info-value"><?= $totalEstudiantes - $conAlergias ?></span>
            </div>
        </div>
        
        <div class="info-section">
            <h4><i class="fas fa-pills"></i> Medicamentos</h4>
            <div class="info-item">
                <span class="info-label">Requieren Med.</span>
                <span class="info-value badge badge-pending"><?= $conMedicamentos ?></span>
            </div>
            <div class="info-item">
                <span class="info-label">Sin Medicamentos</span>
                <span class="info-value"><?= $totalEstudiantes - $conMedicamentos ?></span>
            </div>
        </div>
        
        <div class="info-section">
            <h4><i class="fas fa-file-alt"></i> Documentos</h4>
            <div class="info-item">
                <span class="info-label">Pendientes</span>
                <span class="info-value badge <?= $documentosPendientes > 0 ? 'badge-pending' : 'badge-active' ?>">
                    <?= $documentosPendientes ?>
                </span>
            </div>
            <div class="info-item">
                <span class="info-label">Completos</span>
                <span class="info-value"><?= count(array_filter($estudiantes, fn($e) => $e['documentos_pendientes'] == 0)) ?></span>
            </div>
        </div>
    </div>
</div>

<!-- ===================== LISTA DE ESTUDIANTES ===================== -->
<div class="content-body">
    <h3 style="color: var(--primary-color); margin-bottom: 1.5rem;">
        <i class="fas fa-list"></i>
        Lista de Estudiantes (<?= $totalEstudiantes ?> total)
    </h3>
    
    <div class="alumnos-list" id="students-list">
        <?php foreach ($estudiantes as $estudiante): 
            $tiempoInscrito = floor((time() - strtotime($estudiante['fecha_inscripcion'])) / (365.25 * 24 * 3600));
            $iniciales = strtoupper(substr($estudiante['nombre'], 0, 1) . substr(strstr($estudiante['nombre'], ' '), 1, 1));
        ?>
        <div class="alumno-card" onclick="showStudentCard(<?= $estudiante['id'] ?>)">
            <div class="alumno-photo">
                <?= $iniciales ?>
            </div>
            
            <div class="alumno-name">
                <?= $estudiante['nombre'] ?>
            </div>
            
            <div class="alumno-details">
                <i class="fas fa-birthday-cake"></i> <?= $estudiante['edad'] ?> años
                <br>
                <i class="fas fa-calendar"></i> Inscrito: <?= date('M Y', strtotime($estudiante['fecha_inscripcion'])) ?>
                <br>
                <i class="fas fa-users"></i> Tutores: <?= $estudiante['personas_autorizadas'] ?> autorizados
            </div>
            
            <div style="margin: 0.75rem 0;">
                <?php if ($estudiante['alergias'] !== 'Ninguna'): ?>
                <div style="font-size: 0.8rem; color: var(--danger-color); margin-bottom: 0.25rem;">
                    <i class="fas fa-exclamation-triangle"></i> Alergias: <?= $estudiante['alergias'] ?>
                </div>
                <?php endif; ?>
                
                <?php if ($estudiante['medicamentos'] !== 'Ninguno' && $estudiante['medicamentos'] !== 'Vitaminas'): ?>
                <div style="font-size: 0.8rem; color: var(--warning-color); margin-bottom: 0.25rem;">
                    <i class="fas fa-pills"></i> Medicamentos: <?= $estudiante['medicamentos'] ?>
                </div>
                <?php endif; ?>
                
                <?php if ($estudiante['discapacidades'] !== 'Ninguna'): ?>
                <div style="font-size: 0.8rem; color: var(--info-color); margin-bottom: 0.25rem;">
                    <i class="fas fa-wheelchair"></i> <?= $estudiante['discapacidades'] ?>
                </div>
                <?php endif; ?>
            </div>
            
            <div class="alumno-status">
                <span class="badge badge-<?= strtolower($estudiante['status']) === 'activo' ? 'active' : 'inactive' ?>">
                    <?= $estudiante['status'] ?>
                </span>
                
                <?php if ($estudiante['documentos_pendientes'] > 0): ?>
                <span class="badge badge-pending">
                    <?= $estudiante['documentos_pendientes'] ?> doc. pendiente<?= $estudiante['documentos_pendientes'] > 1 ? 's' : '' ?>
                </span>
                <?php else: ?>
                <span class="badge badge-active">
                    Documentos completos
                </span>
                <?php endif; ?>
            </div>
            
            <div style="margin-top: 1rem; display: flex; gap: 0.5rem; justify-content: center;">
                <button class="btn btn-primary btn-sm" onclick="event.stopPropagation(); showStudentCard(<?= $estudiante['id'] ?>)" title="Ver Ficha Completa">
                    <i class="fas fa-eye"></i>
                </button>
                
                <button class="btn btn-success btn-sm" onclick="event.stopPropagation(); editStudent(<?= $estudiante['id'] ?>)" title="Editar Información">
                    <i class="fas fa-edit"></i>
                </button>
                
                <button class="btn btn-warning btn-sm" onclick="event.stopPropagation(); manageDocuments(<?= $estudiante['id'] ?>)" title="Gestionar Documentos">
                    <i class="fas fa-file-alt"></i>
                </button>
                
                <button class="btn btn-danger btn-sm" onclick="event.stopPropagation(); deleteStudent(<?= $estudiante['id'] ?>, '<?= $estudiante['nombre'] ?>')" title="Eliminar Estudiante">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- ===================== ACCIONES ADICIONALES ===================== -->
<div class="content-body">
    <h3 style="color: var(--primary-color); margin-bottom: 1.5rem;">
        <i class="fas fa-tools"></i>
        Acciones del Aula
    </h3>
    
    <div class="info-grid">
        <button class="btn btn-primary" onclick="generateClassReport('<?= $currentAula ?>')">
            <i class="fas fa-file-pdf"></i>
            Reporte del Aula
        </button>
        
        <button class="btn btn-success" onclick="checkAllDocuments('<?= $currentAula ?>')">
            <i class="fas fa-check-circle"></i>
            Verificar Documentos
        </button>
        
        <button class="btn btn-warning" onclick="sendNotifications('<?= $currentAula ?>')">
            <i class="fas fa-envelope"></i>
            Enviar Notificaciones
        </button>
        
        <button class="btn btn-secondary" onclick="transferStudent()">
            <i class="fas fa-exchange-alt"></i>
            Transferir Estudiante
        </button>
    </div>
</div>

<!-- ===================== SCRIPTS ESPECÍFICOS ===================== -->
<script>
    // Función para buscar en la lista actual
    function searchInCurrentList(query) {
        const cards = document.querySelectorAll('.alumno-card');
        const searchTerm = query.toLowerCase();
        
        cards.forEach(card => {
            const name = card.querySelector('.alumno-name').textContent.toLowerCase();
            if (name.includes(searchTerm)) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    }

    // Función para filtrar por estado
    function filterByStatus(status) {
        const cards = document.querySelectorAll('.alumno-card');
        
        cards.forEach(card => {
            if (status === '') {
                card.style.display = 'block';
            } else {
                const badges = card.querySelectorAll('.badge');
                let hasStatus = false;
                badges.forEach(badge => {
                    if (badge.textContent.trim() === status) {
                        hasStatus = true;
                    }
                });
                card.style.display = hasStatus ? 'block' : 'none';
            }
        });
    }

    // Función para exportar lista de estudiantes
    function exportStudentList(plantel, aula) {
        if(confirm(`¿Exportar lista completa del aula ${aula}?`)) {
            alert(`Generando archivo Excel con:\n\n` +
                  `• Información básica de estudiantes\n` +
                  `• Datos de tutores y contactos\n` +
                  `• Información médica (alergias, medicamentos)\n` +
                  `• Estado de documentación\n\n` +
                  `El archivo se descargará automáticamente.`);
        }
    }

    // Función para gestionar documentos
    function manageDocuments(studentId) {
        alert(`Gestión de Documentos - Estudiante ID: ${studentId}\n\n` +
              `Opciones disponibles:\n` +
              `• Ver documentos subidos\n` +
              `• Solicitar documentos faltantes\n` +
              `• Marcar como completo/incompleto\n` +
              `• Enviar recordatorios a tutores`);
    }

    // Función para generar reporte del aula
    function generateClassReport(aula) {
        if(confirm(`¿Generar reporte completo del aula ${aula}?`)) {
            alert(`Generando reporte que incluye:\n\n` +
                  `• Lista completa de estudiantes\n` +
                  `• Estadísticas de salud y seguridad\n` +
                  `• Estado de documentación\n` +
                  `• Información de contacto de emergencia\n\n` +
                  `El reporte se generará en PDF.`);
        }
    }

    // Función para verificar todos los documentos
    function checkAllDocuments(aula) {
        alert(`Verificación de Documentos - Aula ${aula}\n\n` +
              `Estado actual:\n` +
              `• Documentos completos: 4 estudiantes\n` +
              `• Documentos pendientes: 2 estudiantes\n` +
              `• Documentos vencidos: 0 estudiantes\n\n` +
              `Se enviarán recordatorios automáticos a tutores.`);
    }

    // Función para enviar notificaciones
    function sendNotifications(aula) {
        const notificationType = prompt(`Tipo de notificación para ${aula}:\n\n` +
                                      `1. Documentos pendientes\n` +
                                      `2. Evento próximo\n` +
                                      `3. Recordatorio de pago\n` +
                                      `4. Comunicado general\n\n` +
                                      `Ingrese el número (1-4):`);
        
        if(notificationType && notificationType >= 1 && notificationType <= 4) {
            const types = ['', 'Documentos pendientes', 'Evento próximo', 'Recordatorio de pago', 'Comunicado general'];
            alert(`Enviando notificación: "${types[notificationType]}"\n\n` +
                  `La notificación se enviará a todos los tutores del aula.`);
        }
    }

    // Función para transferir estudiante
    function transferStudent() {
        const studentId = prompt('ID del estudiante a transferir:');
        if(studentId) {
            const newClass = prompt('Nueva aula de destino:');
            if(newClass) {
                if(confirm(`¿Transferir estudiante ${studentId} al aula ${newClass}?`)) {
                    alert(`Estudiante transferido exitosamente.\n\n` +
                          `Se actualizarán todos los registros y se notificará\n` +
                          `a los tutores sobre el cambio de aula.`);
                }
            }
        }
    }

    // Efectos visuales al cargar
    document.addEventListener('DOMContentLoaded', function() {
        const studentCards = document.querySelectorAll('.alumno-card');
        studentCards.forEach((card, index) => {
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
