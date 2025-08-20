<?php
$alumno_id = $alumno_id ?? 1001;

// Datos simulados del estudiante (en una aplicación real vendría de la base de datos)
$estudiante = [
    'id' => 1001,
    'nombre' => 'Sofia García Méndez',
    'edad' => 4,
    'fecha_nacimiento' => '2021-03-15',
    'lugar_nacimiento' => 'Ciudad de México, México',
    'curp' => 'GAMS210315MDFRNF09',
    'genero' => 'Femenino',
    'fecha_inscripcion' => '2024-08-01',
    'plantel' => 'El Zapote',
    'aula' => 'Preescolar 1A',
    'status' => 'Activo',
    'nivel_educativo' => 'Preescolar',
    'grado' => '1er Grado',
    'numero_expediente' => 'EZ-2024-1001',
    
    // Información de salud
    'alergias' => ['Polen', 'Ácaros del polvo'],
    'medicamentos' => ['Antihistamínico (Loratadina) - 1 vez al día'],
    'discapacidades' => 'Ninguna',
    'tipo_sangre' => 'O+',
    'peso' => '18 kg',
    'estatura' => '105 cm',
    'vacunas_completas' => true,
    'problemas_vision' => false,
    'problemas_audicion' => false,
    'condiciones_especiales' => 'Rinitis alérgica estacional',
    
    // Tutores
    'tutor1' => [
        'nombre' => 'Ana Méndez García',
        'parentesco' => 'Madre',
        'telefono' => '555-0123',
        'email' => 'ana.mendez@email.com',
        'ocupacion' => 'Diseñadora Gráfica',
        'lugar_trabajo' => 'Estudio Creativo MX',
        'telefono_trabajo' => '555-0124',
        'es_tutor_principal' => true
    ],
    'tutor2' => [
        'nombre' => 'Carlos García López',
        'parentesco' => 'Padre',
        'telefono' => '555-0125',
        'email' => 'carlos.garcia@email.com',
        'ocupacion' => 'Ingeniero en Sistemas',
        'lugar_trabajo' => 'TechCorp Solutions',
        'telefono_trabajo' => '555-0126',
        'es_tutor_principal' => false
    ],
    
    // Personas autorizadas
    'personas_autorizadas' => [
        ['nombre' => 'María García Ruiz', 'parentesco' => 'Abuela Paterna', 'telefono' => '555-0127'],
        ['nombre' => 'Roberto Méndez Silva', 'parentesco' => 'Abuelo Materno', 'telefono' => '555-0128'],
        ['nombre' => 'Lucia Méndez García', 'parentesco' => 'Tía Materna', 'telefono' => '555-0129']
    ],
    
    // Contactos de emergencia
    'contactos_emergencia' => [
        ['nombre' => 'Dr. José Ramírez', 'tipo' => 'Pediatra', 'telefono' => '555-0130'],
        ['nombre' => 'Clínica San José', 'tipo' => 'Centro Médico', 'telefono' => '555-0131']
    ],
    
    // Información académica
    'calificaciones' => [
        'matematicas' => 'Excelente',
        'lenguaje' => 'Muy Bueno',
        'ciencias' => 'Excelente',
        'arte' => 'Bueno',
        'educacion_fisica' => 'Muy Bueno',
        'conducta' => 'Excelente'
    ],
    'asistencia' => 95.5,
    'reportes_conducta' => 0,
    'actividades_extracurriculares' => ['Danza', 'Natación'],
    
    // Información socioeconómica
    'direccion' => 'Av. Reforma 123, Col. Centro, CP 06000, Ciudad de México',
    'nivel_socioeconomico' => 'Medio-Alto',
    'transporte' => 'Automóvil particular',
    'quien_recoge' => 'Madre / Padre alternadamente',
    'horario_entrada' => '08:00',
    'horario_salida' => '14:00',
    
    // Documentos
    'documentos' => [
        ['nombre' => 'Acta de Nacimiento', 'status' => 'Completo', 'fecha_subida' => '2024-08-01'],
        ['nombre' => 'CURP', 'status' => 'Completo', 'fecha_subida' => '2024-08-01'],
        ['nombre' => 'Comprobante de Domicilio', 'status' => 'Completo', 'fecha_subida' => '2024-08-01'],
        ['nombre' => 'Certificado Médico', 'status' => 'Completo', 'fecha_subida' => '2024-08-01'],
        ['nombre' => 'Cartilla de Vacunación', 'status' => 'Completo', 'fecha_subida' => '2024-08-01'],
        ['nombre' => 'Fotografías', 'status' => 'Completo', 'fecha_subida' => '2024-08-01'],
        ['nombre' => 'Identificación de Tutores', 'status' => 'Completo', 'fecha_subida' => '2024-08-01']
    ],
    
    // Historial
    'historial_medico' => [
        ['fecha' => '2024-07-15', 'evento' => 'Consulta de rutina', 'notas' => 'Desarrollo normal, peso y talla adecuados'],
        ['fecha' => '2024-06-20', 'evento' => 'Episodio alérgico leve', 'notas' => 'Rinitis por exposición a polen, tratado con antihistamínico'],
        ['fecha' => '2024-05-10', 'evento' => 'Vacuna de refuerzo', 'notas' => 'DPT aplicada sin complicaciones']
    ],
    'historial_academico' => [
        ['periodo' => '2024 Agosto', 'nivel' => 'Preescolar 1A', 'plantel' => 'El Zapote', 'status' => 'Activo'],
        ['periodo' => '2023-2024', 'nivel' => 'Guardería C', 'plantel' => 'El Zapote', 'status' => 'Completado']
    ],
    'historial_incidentes' => []
];

$tiempoInscrito = floor((time() - strtotime($estudiante['fecha_inscripcion'])) / (30.44 * 24 * 3600)); // meses
$iniciales = strtoupper(substr($estudiante['nombre'], 0, 1) . substr(strstr($estudiante['nombre'], ' '), 1, 1));
?>

<!-- ===================== FICHA COMPLETA DEL ALUMNO ===================== -->
<div class="ficha-alumno">
    <!-- Header de la Ficha -->
    <div class="content-body" style="padding: 0; overflow: hidden;">
        <div class="ficha-header">
            <div class="alumno-avatar">
                <?= $iniciales ?>
            </div>
            <div class="alumno-main-info">
                <h2><?= $estudiante['nombre'] ?></h2>
                <p><i class="fas fa-id-card"></i> Expediente: <?= $estudiante['numero_expediente'] ?></p>
                <p><i class="fas fa-birthday-cake"></i> <?= $estudiante['edad'] ?> años - Nacido el <?= date('d/m/Y', strtotime($estudiante['fecha_nacimiento'])) ?></p>
                <p><i class="fas fa-school"></i> <?= $estudiante['plantel'] ?> - <?= $estudiante['aula'] ?></p>
                <p><i class="fas fa-calendar"></i> Inscrito hace <?= $tiempoInscrito ?> meses</p>
            </div>
            <div style="margin-left: auto; display: flex; flex-direction: column; gap: 0.5rem;">
                <span class="badge badge-<?= strtolower($estudiante['status']) === 'activo' ? 'active' : 'inactive' ?>" 
                      style="padding: 0.5rem 1rem; font-size: 1rem;">
                    <?= $estudiante['status'] ?>
                </span>
                <button class="btn btn-warning" onclick="editStudent(<?= $estudiante['id'] ?>)">
                    <i class="fas fa-edit"></i> Editar
                </button>
                <button class="btn btn-danger" onclick="deleteStudent(<?= $estudiante['id'] ?>, '<?= $estudiante['nombre'] ?>')">
                    <i class="fas fa-trash"></i> Eliminar
                </button>
            </div>
        </div>
        
        <!-- Navegación por Tabs -->
        <div class="ficha-tabs">
            <button class="tab-button active" onclick="showTab('general')">
                <i class="fas fa-user"></i> Información General
            </button>
            <button class="tab-button" onclick="showTab('salud')">
                <i class="fas fa-heartbeat"></i> Información de Salud
            </button>
            <button class="tab-button" onclick="showTab('tutores')">
                <i class="fas fa-users"></i> Tutores y Contactos
            </button>
            <button class="tab-button" onclick="showTab('academico')">
                <i class="fas fa-graduation-cap"></i> Historial Académico
            </button>
            <button class="tab-button" onclick="showTab('documentos')">
                <i class="fas fa-file-alt"></i> Documentos
            </button>
            <button class="tab-button" onclick="showTab('historial')">
                <i class="fas fa-clock"></i> Historial Completo
            </button>
        </div>
        
        <!-- Contenido de las Tabs -->
        <div class="tab-content">
            <!-- TAB: INFORMACIÓN GENERAL -->
            <div id="tab-general" class="tab-pane active">
                <h3 style="color: var(--primary-color); margin-bottom: 1.5rem;">
                    <i class="fas fa-user"></i> Información Personal
                </h3>
                
                <div class="info-grid">
                    <div class="info-section">
                        <h4><i class="fas fa-id-badge"></i> Datos Básicos</h4>
                        <div class="info-item">
                            <span class="info-label">Nombre Completo</span>
                            <span class="info-value"><?= $estudiante['nombre'] ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Fecha de Nacimiento</span>
                            <span class="info-value"><?= date('d/m/Y', strtotime($estudiante['fecha_nacimiento'])) ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Lugar de Nacimiento</span>
                            <span class="info-value"><?= $estudiante['lugar_nacimiento'] ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">CURP</span>
                            <span class="info-value"><?= $estudiante['curp'] ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Género</span>
                            <span class="info-value"><?= $estudiante['genero'] ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Edad Actual</span>
                            <span class="info-value"><?= $estudiante['edad'] ?> años</span>
                        </div>
                    </div>
                    
                    <div class="info-section">
                        <h4><i class="fas fa-school"></i> Información Escolar</h4>
                        <div class="info-item">
                            <span class="info-label">Número de Expediente</span>
                            <span class="info-value"><?= $estudiante['numero_expediente'] ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Plantel</span>
                            <span class="info-value"><?= $estudiante['plantel'] ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Aula Actual</span>
                            <span class="info-value"><?= $estudiante['aula'] ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Nivel Educativo</span>
                            <span class="info-value"><?= $estudiante['nivel_educativo'] ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Grado</span>
                            <span class="info-value"><?= $estudiante['grado'] ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Fecha de Inscripción</span>
                            <span class="info-value"><?= date('d/m/Y', strtotime($estudiante['fecha_inscripcion'])) ?></span>
                        </div>
                    </div>
                    
                    <div class="info-section">
                        <h4><i class="fas fa-home"></i> Información de Domicilio</h4>
                        <div class="info-item">
                            <span class="info-label">Dirección Completa</span>
                            <span class="info-value"><?= $estudiante['direccion'] ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Nivel Socioeconómico</span>
                            <span class="info-value"><?= $estudiante['nivel_socioeconomico'] ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Medio de Transporte</span>
                            <span class="info-value"><?= $estudiante['transporte'] ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Quien lo Recoge</span>
                            <span class="info-value"><?= $estudiante['quien_recoge'] ?></span>
                        </div>
                    </div>
                    
                    <div class="info-section">
                        <h4><i class="fas fa-clock"></i> Horarios</h4>
                        <div class="info-item">
                            <span class="info-label">Horario de Entrada</span>
                            <span class="info-value"><?= $estudiante['horario_entrada'] ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Horario de Salida</span>
                            <span class="info-value"><?= $estudiante['horario_salida'] ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Tiempo en la Institución</span>
                            <span class="info-value"><?= $tiempoInscrito ?> meses</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- TAB: INFORMACIÓN DE SALUD -->
            <div id="tab-salud" class="tab-pane" style="display: none;">
                <h3 style="color: var(--primary-color); margin-bottom: 1.5rem;">
                    <i class="fas fa-heartbeat"></i> Información Médica y de Salud
                </h3>
                
                <div class="info-grid">
                    <div class="info-section">
                        <h4><i class="fas fa-notes-medical"></i> Datos Médicos Básicos</h4>
                        <div class="info-item">
                            <span class="info-label">Tipo de Sangre</span>
                            <span class="info-value badge badge-info"><?= $estudiante['tipo_sangre'] ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Peso</span>
                            <span class="info-value"><?= $estudiante['peso'] ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Estatura</span>
                            <span class="info-value"><?= $estudiante['estatura'] ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Vacunas Completas</span>
                            <span class="info-value badge badge-<?= $estudiante['vacunas_completas'] ? 'active' : 'pending' ?>">
                                <?= $estudiante['vacunas_completas'] ? 'Sí' : 'No' ?>
                            </span>
                        </div>
                    </div>
                    
                    <div class="info-section">
                        <h4><i class="fas fa-exclamation-triangle"></i> Alergias</h4>
                        <?php if (!empty($estudiante['alergias'])): ?>
                            <?php foreach ($estudiante['alergias'] as $alergia): ?>
                            <div class="info-item">
                                <span class="info-label"><i class="fas fa-circle" style="color: var(--danger-color); font-size: 0.6rem;"></i></span>
                                <span class="info-value" style="color: var(--danger-color); font-weight: 600;"><?= $alergia ?></span>
                            </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="info-item">
                                <span class="info-value badge badge-active">Sin alergias conocidas</span>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="info-section">
                        <h4><i class="fas fa-pills"></i> Medicamentos</h4>
                        <?php if (!empty($estudiante['medicamentos'])): ?>
                            <?php foreach ($estudiante['medicamentos'] as $medicamento): ?>
                            <div class="info-item">
                                <span class="info-label"><i class="fas fa-pill" style="color: var(--warning-color);"></i></span>
                                <span class="info-value"><?= $medicamento ?></span>
                            </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="info-item">
                                <span class="info-value badge badge-active">Sin medicamentos regulares</span>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="info-section">
                        <h4><i class="fas fa-wheelchair"></i> Condiciones Especiales</h4>
                        <div class="info-item">
                            <span class="info-label">Discapacidades</span>
                            <span class="info-value"><?= $estudiante['discapacidades'] ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Problemas de Visión</span>
                            <span class="info-value badge badge-<?= $estudiante['problemas_vision'] ? 'pending' : 'active' ?>">
                                <?= $estudiante['problemas_vision'] ? 'Sí' : 'No' ?>
                            </span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Problemas de Audición</span>
                            <span class="info-value badge badge-<?= $estudiante['problemas_audicion'] ? 'pending' : 'active' ?>">
                                <?= $estudiante['problemas_audicion'] ? 'Sí' : 'No' ?>
                            </span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Otras Condiciones</span>
                            <span class="info-value"><?= $estudiante['condiciones_especiales'] ?></span>
                        </div>
                    </div>
                </div>
                
                <h4 style="color: var(--primary-color); margin: 2rem 0 1rem 0;">
                    <i class="fas fa-history"></i> Historial Médico Reciente
                </h4>
                <div style="background: var(--primary-light); padding: 1.5rem; border-radius: 10px;">
                    <?php foreach ($estudiante['historial_medico'] as $evento): ?>
                    <div style="margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 1px solid var(--gray-300);">
                        <div style="font-weight: 600; color: var(--primary-dark);">
                            <?= date('d/m/Y', strtotime($evento['fecha'])) ?> - <?= $evento['evento'] ?>
                        </div>
                        <div style="color: var(--gray-600); margin-top: 0.25rem;">
                            <?= $evento['notas'] ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            
            <!-- TAB: TUTORES Y CONTACTOS -->
            <div id="tab-tutores" class="tab-pane" style="display: none;">
                <h3 style="color: var(--primary-color); margin-bottom: 1.5rem;">
                    <i class="fas fa-users"></i> Tutores y Contactos de Emergencia
                </h3>
                
                <div class="info-grid">
                    <!-- Tutor Principal -->
                    <div class="info-section">
                        <h4><i class="fas fa-user-tie"></i> Tutor Principal</h4>
                        <div class="info-item">
                            <span class="info-label">Nombre</span>
                            <span class="info-value"><?= $estudiante['tutor1']['nombre'] ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Parentesco</span>
                            <span class="info-value"><?= $estudiante['tutor1']['parentesco'] ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Teléfono</span>
                            <span class="info-value"><?= $estudiante['tutor1']['telefono'] ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Email</span>
                            <span class="info-value"><?= $estudiante['tutor1']['email'] ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Ocupación</span>
                            <span class="info-value"><?= $estudiante['tutor1']['ocupacion'] ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Lugar de Trabajo</span>
                            <span class="info-value"><?= $estudiante['tutor1']['lugar_trabajo'] ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Tel. Trabajo</span>
                            <span class="info-value"><?= $estudiante['tutor1']['telefono_trabajo'] ?></span>
                        </div>
                    </div>
                    
                    <!-- Tutor Secundario -->
                    <div class="info-section">
                        <h4><i class="fas fa-user"></i> Tutor Secundario</h4>
                        <div class="info-item">
                            <span class="info-label">Nombre</span>
                            <span class="info-value"><?= $estudiante['tutor2']['nombre'] ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Parentesco</span>
                            <span class="info-value"><?= $estudiante['tutor2']['parentesco'] ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Teléfono</span>
                            <span class="info-value"><?= $estudiante['tutor2']['telefono'] ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Email</span>
                            <span class="info-value"><?= $estudiante['tutor2']['email'] ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Ocupación</span>
                            <span class="info-value"><?= $estudiante['tutor2']['ocupacion'] ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Lugar de Trabajo</span>
                            <span class="info-value"><?= $estudiante['tutor2']['lugar_trabajo'] ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Tel. Trabajo</span>
                            <span class="info-value"><?= $estudiante['tutor2']['telefono_trabajo'] ?></span>
                        </div>
                    </div>
                </div>
                
                <!-- Personas Autorizadas -->
                <h4 style="color: var(--primary-color); margin: 2rem 0 1rem 0;">
                    <i class="fas fa-user-check"></i> Personas Autorizadas para Recoger (<?= count($estudiante['personas_autorizadas']) ?>)
                </h4>
                <div style="background: var(--primary-light); padding: 1.5rem; border-radius: 10px; margin-bottom: 2rem;">
                    <?php foreach ($estudiante['personas_autorizadas'] as $persona): ?>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; padding: 1rem; background: var(--white); border-radius: 8px;">
                        <div>
                            <div style="font-weight: 600; color: var(--primary-dark);"><?= $persona['nombre'] ?></div>
                            <div style="color: var(--gray-600); font-size: 0.9rem;"><?= $persona['parentesco'] ?></div>
                        </div>
                        <div>
                            <span class="badge badge-info"><?= $persona['telefono'] ?></span>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                
                <!-- Contactos de Emergencia -->
                <h4 style="color: var(--primary-color); margin: 2rem 0 1rem 0;">
                    <i class="fas fa-ambulance"></i> Contactos de Emergencia Médica
                </h4>
                <div style="background: var(--primary-light); padding: 1.5rem; border-radius: 10px;">
                    <?php foreach ($estudiante['contactos_emergencia'] as $contacto): ?>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; padding: 1rem; background: var(--white); border-radius: 8px;">
                        <div>
                            <div style="font-weight: 600; color: var(--primary-dark);"><?= $contacto['nombre'] ?></div>
                            <div style="color: var(--gray-600); font-size: 0.9rem;"><?= $contacto['tipo'] ?></div>
                        </div>
                        <div>
                            <span class="badge badge-pending"><?= $contacto['telefono'] ?></span>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            
            <!-- TAB: HISTORIAL ACADÉMICO -->
            <div id="tab-academico" class="tab-pane" style="display: none;">
                <h3 style="color: var(--primary-color); margin-bottom: 1.5rem;">
                    <i class="fas fa-graduation-cap"></i> Rendimiento Académico y Actividades
                </h3>
                
                <div class="info-grid">
                    <div class="info-section">
                        <h4><i class="fas fa-chart-line"></i> Calificaciones Actuales</h4>
                        <?php foreach ($estudiante['calificaciones'] as $materia => $calificacion): ?>
                        <div class="info-item">
                            <span class="info-label"><?= ucfirst(str_replace('_', ' ', $materia)) ?></span>
                            <span class="info-value badge badge-<?= $calificacion === 'Excelente' ? 'active' : ($calificacion === 'Muy Bueno' ? 'info' : 'pending') ?>">
                                <?= $calificacion ?>
                            </span>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <div class="info-section">
                        <h4><i class="fas fa-calendar-check"></i> Asistencia y Conducta</h4>
                        <div class="info-item">
                            <span class="info-label">Porcentaje de Asistencia</span>
                            <span class="info-value badge badge-<?= $estudiante['asistencia'] >= 90 ? 'active' : 'pending' ?>">
                                <?= $estudiante['asistencia'] ?>%
                            </span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Reportes de Conducta</span>
                            <span class="info-value badge badge-<?= $estudiante['reportes_conducta'] === 0 ? 'active' : 'pending' ?>">
                                <?= $estudiante['reportes_conducta'] ?>
                            </span>
                        </div>
                    </div>
                    
                    <div class="info-section">
                        <h4><i class="fas fa-running"></i> Actividades Extracurriculares</h4>
                        <?php foreach ($estudiante['actividades_extracurriculares'] as $actividad): ?>
                        <div class="info-item">
                            <span class="info-label"><i class="fas fa-star" style="color: var(--warning-color);"></i></span>
                            <span class="info-value"><?= $actividad ?></span>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                
                <h4 style="color: var(--primary-color); margin: 2rem 0 1rem 0;">
                    <i class="fas fa-history"></i> Historial Académico
                </h4>
                <div style="background: var(--primary-light); padding: 1.5rem; border-radius: 10px;">
                    <?php foreach ($estudiante['historial_academico'] as $periodo): ?>
                    <div style="margin-bottom: 1rem; padding: 1rem; background: var(--white); border-radius: 8px;">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <div>
                                <div style="font-weight: 600; color: var(--primary-dark);"><?= $periodo['periodo'] ?></div>
                                <div style="color: var(--gray-600);"><?= $periodo['nivel'] ?> - <?= $periodo['plantel'] ?></div>
                            </div>
                            <span class="badge badge-<?= $periodo['status'] === 'Activo' ? 'active' : 'info' ?>"><?= $periodo['status'] ?></span>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            
            <!-- TAB: DOCUMENTOS -->
            <div id="tab-documentos" class="tab-pane" style="display: none;">
                <h3 style="color: var(--primary-color); margin-bottom: 1.5rem;">
                    <i class="fas fa-file-alt"></i> Documentación del Estudiante
                </h3>
                
                <div style="background: var(--primary-light); padding: 1.5rem; border-radius: 10px;">
                    <?php foreach ($estudiante['documentos'] as $doc): ?>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; padding: 1rem; background: var(--white); border-radius: 8px;">
                        <div>
                            <div style="font-weight: 600; color: var(--primary-dark);">
                                <i class="fas fa-file-pdf" style="color: var(--danger-color); margin-right: 0.5rem;"></i>
                                <?= $doc['nombre'] ?>
                            </div>
                            <div style="color: var(--gray-600); font-size: 0.9rem;">
                                Subido el <?= date('d/m/Y', strtotime($doc['fecha_subida'])) ?>
                            </div>
                        </div>
                        <div style="display: flex; gap: 0.5rem; align-items: center;">
                            <span class="badge badge-<?= $doc['status'] === 'Completo' ? 'active' : 'pending' ?>">
                                <?= $doc['status'] ?>
                            </span>
                            <button class="btn btn-primary btn-sm" onclick="viewDocument('<?= $doc['nombre'] ?>')">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-secondary btn-sm" onclick="downloadDocument('<?= $doc['nombre'] ?>')">
                                <i class="fas fa-download"></i>
                            </button>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                
                <div style="margin-top: 2rem;">
                    <button class="btn btn-success" onclick="uploadDocument(<?= $estudiante['id'] ?>)">
                        <i class="fas fa-upload"></i>
                        Subir Nuevo Documento
                    </button>
                    <button class="btn btn-warning" onclick="requestDocuments(<?= $estudiante['id'] ?>)">
                        <i class="fas fa-envelope"></i>
                        Solicitar Documentos Faltantes
                    </button>
                </div>
            </div>
            
            <!-- TAB: HISTORIAL COMPLETO -->
            <div id="tab-historial" class="tab-pane" style="display: none;">
                <h3 style="color: var(--primary-color); margin-bottom: 1.5rem;">
                    <i class="fas fa-clock"></i> Historial Completo del Estudiante
                </h3>
                
                <div style="background: var(--primary-light); padding: 1.5rem; border-radius: 10px;">
                    <h4 style="color: var(--primary-dark); margin-bottom: 1rem;">Eventos Recientes</h4>
                    
                    <div style="border-left: 3px solid var(--primary-color); padding-left: 1rem;">
                        <div style="margin-bottom: 1.5rem;">
                            <div style="font-weight: 600; color: var(--primary-dark);">13 Agosto 2025 - Ficha Consultada</div>
                            <div style="color: var(--gray-600); font-size: 0.9rem;">Ficha del estudiante consultada por administrador</div>
                        </div>
                        
                        <div style="margin-bottom: 1.5rem;">
                            <div style="font-weight: 600; color: var(--primary-dark);">01 Agosto 2025 - Inicio del Período Escolar</div>
                            <div style="color: var(--gray-600); font-size: 0.9rem;">Estudiante asignado al aula Preescolar 1A</div>
                        </div>
                        
                        <div style="margin-bottom: 1.5rem;">
                            <div style="font-weight: 600; color: var(--primary-dark);">15 Julio 2025 - Consulta Médica</div>
                            <div style="color: var(--gray-600); font-size: 0.9rem;">Revisión médica de rutina - Desarrollo normal</div>
                        </div>
                        
                        <div style="margin-bottom: 1.5rem;">
                            <div style="font-weight: 600; color: var(--primary-dark);">20 Junio 2025 - Episodio Alérgico</div>
                            <div style="color: var(--gray-600); font-size: 0.9rem;">Rinitis alérgica tratada con antihistamínico</div>
                        </div>
                    </div>
                </div>
                
                <div style="margin-top: 2rem;">
                    <button class="btn btn-primary" onclick="exportCompleteFile(<?= $estudiante['id'] ?>)">
                        <i class="fas fa-file-pdf"></i>
                        Exportar Expediente Completo
                    </button>
                    <button class="btn btn-secondary" onclick="printStudentCard(<?= $estudiante['id'] ?>)">
                        <i class="fas fa-print"></i>
                        Imprimir Ficha
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ===================== SCRIPTS ESPECÍFICOS ===================== -->
<script>
    // Función para mostrar tabs
    function showTab(tabName) {
        // Ocultar todas las tabs
        document.querySelectorAll('.tab-pane').forEach(tab => {
            tab.style.display = 'none';
        });
        
        // Remover clase active de todos los botones
        document.querySelectorAll('.tab-button').forEach(btn => {
            btn.classList.remove('active');
        });
        
        // Mostrar tab seleccionada
        document.getElementById('tab-' + tabName).style.display = 'block';
        event.target.classList.add('active');
    }

    // Función para ver documento
    function viewDocument(docName) {
        alert(`Abriendo documento: ${docName}\n\nEste documento se abrirá en una nueva ventana o modal.`);
    }

    // Función para descargar documento
    function downloadDocument(docName) {
        alert(`Descargando documento: ${docName}\n\nEl archivo se descargará automáticamente.`);
    }

    // Función para subir documento
    function uploadDocument(studentId) {
        alert(`Subir Nuevo Documento\n\nEstudiante ID: ${studentId}\n\nSe abrirá el selector de archivos para subir documentos.`);
    }

    // Función para solicitar documentos
    function requestDocuments(studentId) {
        alert(`Solicitar Documentos Faltantes\n\nSe enviará un email automático a los tutores\nsolicitando los documentos pendientes.`);
    }

    // Función para exportar expediente completo
    function exportCompleteFile(studentId) {
        if(confirm('¿Generar expediente completo en PDF?')) {
            alert(`Generando expediente completo del estudiante...\n\nEl archivo incluirá:\n• Información personal\n• Datos médicos\n• Historial académico\n• Documentos adjuntos\n\nEl PDF se descargará automáticamente.`);
        }
    }

    // Función para imprimir ficha
    function printStudentCard(studentId) {
        if(confirm('¿Imprimir ficha del estudiante?')) {
            window.print();
        }
    }

    // Efectos visuales al cargar
    document.addEventListener('DOMContentLoaded', function() {
        // Animación de entrada para secciones
        const sections = document.querySelectorAll('.info-section');
        sections.forEach((section, index) => {
            section.style.opacity = '0';
            section.style.transform = 'translateY(20px)';
            setTimeout(() => {
                section.style.transition = 'all 0.5s ease';
                section.style.opacity = '1';
                section.style.transform = 'translateY(0)';
            }, index * 100);
        });
    });
</script>
