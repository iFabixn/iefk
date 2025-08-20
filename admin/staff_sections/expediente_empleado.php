<?php
// Datos del empleado específico (simularemos obtenerlo de la base de datos)
$empleado_id = $_GET['id'] ?? 1001;

// Función para obtener datos del empleado
function obtenerEmpleado($id) {
    $empleados = [
        1001 => [
            'id' => 1001,
            'nombre' => 'Roberto Martínez García',
            'puesto' => 'Director General',
            'area' => 'Dirección',
            'plantel' => 'El Zapote',
            'salario_base' => 25000.00,
            'email' => 'roberto.martinez@iefk.edu.mx',
            'telefono' => '555-0101',
            'celular' => '555-9101',
            'direccion' => 'Av. Principal 123, Col. Centro, CP 12345',
            'fecha_nacimiento' => '1980-05-15',
            'fecha_ingreso' => '2018-03-15',
            'tipo_contrato' => 'Indefinido',
            'modalidad_pago' => 'Transferencia',
            'banco' => 'BBVA Bancomer',
            'cuenta_bancaria' => '1234567890',
            'clabe' => '012345678901234567',
            'rfc' => 'MARG800515ABC',
            'curp' => 'MARG800515HCMLRB01',
            'nss' => '12345678901',
            'status' => 'Activo',
            'hijos_estudiantes' => 2,
            'prestamos_activos' => 0,
            'horario' => '07:00-16:00',
            'jefe_inmediato' => 'N/A',
            'antiguedad_anos' => 7.4,
            'ultima_evaluacion' => '2025-03-01',
            'proxima_evaluacion' => '2025-09-01',
            'contacto_emergencia' => 'Patricia García López',
            'telefono_emergencia' => '555-9999',
            'estado_civil' => 'Casado',
            'estudios' => 'Maestría en Administración Educativa',
            'nivel_estudios' => 'Posgrado',
            'universidad' => 'UNAM',
            'foto' => '',
            'observaciones' => 'Excelente desempeño, liderazgo ejemplar'
        ]
    ];
    
    return $empleados[$id] ?? null;
}

$empleado = obtenerEmpleado($empleado_id);

if (!$empleado) {
    echo "<div class='alert alert-danger'>Empleado no encontrado</div>";
    return;
}

// Documentos del empleado
$documentos = [
    ['nombre' => 'Identificación Oficial (INE)', 'tipo' => 'identificacion', 'status' => 'completo', 'fecha' => '2025-01-15'],
    ['nombre' => 'CURP', 'tipo' => 'curp', 'status' => 'completo', 'fecha' => '2025-01-15'],
    ['nombre' => 'RFC', 'tipo' => 'rfc', 'status' => 'completo', 'fecha' => '2025-01-15'],
    ['nombre' => 'Acta de Nacimiento', 'tipo' => 'acta_nacimiento', 'status' => 'completo', 'fecha' => '2025-01-15'],
    ['nombre' => 'Comprobante de Domicilio', 'tipo' => 'domicilio', 'status' => 'completo', 'fecha' => '2025-01-15'],
    ['nombre' => 'NSS (IMSS)', 'tipo' => 'nss', 'status' => 'completo', 'fecha' => '2025-01-15'],
    ['nombre' => 'Título Profesional', 'tipo' => 'titulo', 'status' => 'completo', 'fecha' => '2025-01-15'],
    ['nombre' => 'Cédula Profesional', 'tipo' => 'cedula', 'status' => 'pendiente', 'fecha' => null],
    ['nombre' => 'Carta de Antecedentes No Penales', 'tipo' => 'antecedentes', 'status' => 'completo', 'fecha' => '2025-01-15'],
    ['nombre' => 'Examen Médico', 'tipo' => 'medico', 'status' => 'vencido', 'fecha' => '2024-03-15'],
    ['nombre' => 'Contrato Laboral', 'tipo' => 'contrato', 'status' => 'completo', 'fecha' => '2025-01-15'],
    ['nombre' => 'Referencias Laborales', 'tipo' => 'referencias', 'status' => 'completo', 'fecha' => '2025-01-15']
];

// Historial laboral
$historial = [
    ['fecha' => '2025-08-01', 'evento' => 'Evaluación de Desempeño', 'resultado' => 'Excelente', 'observaciones' => 'Cumplimiento de objetivos al 100%'],
    ['fecha' => '2025-06-15', 'evento' => 'Aumento Salarial', 'resultado' => '+8%', 'observaciones' => 'Incremento por evaluación y antiguedad'],
    ['fecha' => '2025-03-01', 'evento' => 'Evaluación de Desempeño', 'resultado' => 'Muy Bueno', 'observaciones' => 'Liderazgo destacado'],
    ['fecha' => '2024-12-20', 'evento' => 'Reconocimiento', 'resultado' => 'Bono', 'observaciones' => 'Excelente gestión anual'],
    ['fecha' => '2024-09-01', 'evento' => 'Evaluación de Desempeño', 'resultado' => 'Excelente', 'observaciones' => 'Innovación en procesos']
];

// Capacitaciones
$capacitaciones = [
    ['fecha' => '2025-07-15', 'curso' => 'Liderazgo Educativo', 'duracion' => '20 hrs', 'institucion' => 'ITESM', 'status' => 'Completado'],
    ['fecha' => '2025-05-10', 'curso' => 'Administración Escolar', 'duracion' => '40 hrs', 'institucion' => 'SEP', 'status' => 'Completado'],
    ['fecha' => '2025-02-20', 'curso' => 'Tecnologías Educativas', 'duracion' => '15 hrs', 'institucion' => 'Microsoft', 'status' => 'Completado'],
    ['fecha' => '2024-11-05', 'curso' => 'Gestión de Recursos Humanos', 'duracion' => '30 hrs', 'institucion' => 'UNAM', 'status' => 'Completado']
];
?>

<!-- ===================== EXPEDIENTE DE EMPLEADO ===================== -->
<div class="expediente-empleado">
    <!-- Header del Expediente -->
    <div class="expediente-header">
        <div class="employee-profile">
            <div class="employee-photo">
                <?php if ($empleado['foto']): ?>
                    <img src="<?= $empleado['foto'] ?>" alt="Foto de <?= $empleado['nombre'] ?>">
                <?php else: ?>
                    <div class="photo-placeholder">
                        <?= strtoupper(substr($empleado['nombre'], 0, 1) . substr(strstr($empleado['nombre'], ' '), 1, 1)) ?>
                    </div>
                <?php endif; ?>
            </div>
            
            <div class="employee-info">
                <h1><?= $empleado['nombre'] ?></h1>
                <p class="position"><?= $empleado['puesto'] ?></p>
                <p class="department"><?= $empleado['area'] ?> - <?= $empleado['plantel'] ?></p>
                <div class="employee-status">
                    <span class="badge badge-<?= strtolower($empleado['status']) === 'activo' ? 'active' : 'inactive' ?>">
                        <?= $empleado['status'] ?>
                    </span>
                    <span class="employee-id">ID: <?= $empleado['id'] ?></span>
                </div>
            </div>
        </div>
        
        <div class="expediente-actions">
            <button class="btn btn-primary" onclick="editEmployee()">
                <i class="fas fa-edit"></i> Editar Datos
            </button>
            <button class="btn btn-warning" onclick="generateEmployeeReport()">
                <i class="fas fa-file-pdf"></i> Generar Reporte
            </button>
            <button class="btn btn-info" onclick="printExpediente()">
                <i class="fas fa-print"></i> Imprimir
            </button>
            <button class="btn btn-secondary" onclick="goBackToEmployees()">
                <i class="fas fa-arrow-left"></i> Regresar
            </button>
        </div>
    </div>

    <!-- Navegación por Pestañas -->
    <div class="expediente-tabs">
        <button class="tab-btn active" onclick="showTab('datos-personales')">
            <i class="fas fa-user"></i> Datos Personales
        </button>
        <button class="tab-btn" onclick="showTab('datos-laborales')">
            <i class="fas fa-briefcase"></i> Datos Laborales
        </button>
        <button class="tab-btn" onclick="showTab('documentos')">
            <i class="fas fa-folder"></i> Documentos
        </button>
        <button class="tab-btn" onclick="showTab('historial')">
            <i class="fas fa-history"></i> Historial
        </button>
        <button class="tab-btn" onclick="showTab('capacitaciones')">
            <i class="fas fa-graduation-cap"></i> Capacitaciones
        </button>
        <button class="tab-btn" onclick="showTab('nomina')">
            <i class="fas fa-dollar-sign"></i> Nómina
        </button>
    </div>

    <!-- Contenido de las Pestañas -->
    
    <!-- DATOS PERSONALES -->
    <div id="datos-personales" class="tab-content active">
        <div class="content-section">
            <h3><i class="fas fa-user"></i> Información Personal</h3>
            <div class="info-grid">
                <div class="info-item">
                    <label>Nombre Completo:</label>
                    <span><?= $empleado['nombre'] ?></span>
                </div>
                <div class="info-item">
                    <label>Fecha de Nacimiento:</label>
                    <span><?= date('d/m/Y', strtotime($empleado['fecha_nacimiento'])) ?> (<?= floor((time() - strtotime($empleado['fecha_nacimiento'])) / 31557600) ?> años)</span>
                </div>
                <div class="info-item">
                    <label>Estado Civil:</label>
                    <span><?= $empleado['estado_civil'] ?></span>
                </div>
                <div class="info-item">
                    <label>RFC:</label>
                    <span><?= $empleado['rfc'] ?></span>
                </div>
                <div class="info-item">
                    <label>CURP:</label>
                    <span><?= $empleado['curp'] ?></span>
                </div>
                <div class="info-item">
                    <label>NSS:</label>
                    <span><?= $empleado['nss'] ?></span>
                </div>
            </div>
        </div>

        <div class="content-section">
            <h3><i class="fas fa-map-marker-alt"></i> Información de Contacto</h3>
            <div class="info-grid">
                <div class="info-item full-width">
                    <label>Dirección:</label>
                    <span><?= $empleado['direccion'] ?></span>
                </div>
                <div class="info-item">
                    <label>Teléfono:</label>
                    <span><?= $empleado['telefono'] ?></span>
                </div>
                <div class="info-item">
                    <label>Celular:</label>
                    <span><?= $empleado['celular'] ?></span>
                </div>
                <div class="info-item full-width">
                    <label>Email:</label>
                    <span><?= $empleado['email'] ?></span>
                </div>
            </div>
        </div>

        <div class="content-section">
            <h3><i class="fas fa-phone"></i> Contacto de Emergencia</h3>
            <div class="info-grid">
                <div class="info-item">
                    <label>Contacto:</label>
                    <span><?= $empleado['contacto_emergencia'] ?></span>
                </div>
                <div class="info-item">
                    <label>Teléfono:</label>
                    <span><?= $empleado['telefono_emergencia'] ?></span>
                </div>
            </div>
        </div>

        <div class="content-section">
            <h3><i class="fas fa-graduation-cap"></i> Información Académica</h3>
            <div class="info-grid">
                <div class="info-item">
                    <label>Nivel de Estudios:</label>
                    <span><?= $empleado['nivel_estudios'] ?></span>
                </div>
                <div class="info-item">
                    <label>Universidad:</label>
                    <span><?= $empleado['universidad'] ?></span>
                </div>
                <div class="info-item full-width">
                    <label>Estudios:</label>
                    <span><?= $empleado['estudios'] ?></span>
                </div>
            </div>
        </div>
    </div>

    <!-- DATOS LABORALES -->
    <div id="datos-laborales" class="tab-content">
        <div class="content-section">
            <h3><i class="fas fa-briefcase"></i> Información Laboral</h3>
            <div class="info-grid">
                <div class="info-item">
                    <label>Puesto:</label>
                    <span><?= $empleado['puesto'] ?></span>
                </div>
                <div class="info-item">
                    <label>Área:</label>
                    <span><?= $empleado['area'] ?></span>
                </div>
                <div class="info-item">
                    <label>Plantel:</label>
                    <span><?= $empleado['plantel'] ?></span>
                </div>
                <div class="info-item">
                    <label>Tipo de Contrato:</label>
                    <span><?= $empleado['tipo_contrato'] ?></span>
                </div>
                <div class="info-item">
                    <label>Fecha de Ingreso:</label>
                    <span><?= date('d/m/Y', strtotime($empleado['fecha_ingreso'])) ?></span>
                </div>
                <div class="info-item">
                    <label>Antigüedad:</label>
                    <span><?= number_format($empleado['antiguedad_anos'], 1) ?> años</span>
                </div>
                <div class="info-item">
                    <label>Horario:</label>
                    <span><?= $empleado['horario'] ?></span>
                </div>
                <div class="info-item">
                    <label>Jefe Inmediato:</label>
                    <span><?= $empleado['jefe_inmediato'] ?></span>
                </div>
            </div>
        </div>

        <div class="content-section">
            <h3><i class="fas fa-dollar-sign"></i> Información Salarial</h3>
            <div class="info-grid">
                <div class="info-item">
                    <label>Salario Base:</label>
                    <span class="salary-amount">$<?= number_format($empleado['salario_base']) ?></span>
                </div>
                <div class="info-item">
                    <label>Modalidad de Pago:</label>
                    <span><?= $empleado['modalidad_pago'] ?></span>
                </div>
                <div class="info-item">
                    <label>Banco:</label>
                    <span><?= $empleado['banco'] ?></span>
                </div>
                <div class="info-item">
                    <label>Cuenta Bancaria:</label>
                    <span><?= $empleado['cuenta_bancaria'] ?></span>
                </div>
                <div class="info-item full-width">
                    <label>CLABE:</label>
                    <span><?= $empleado['clabe'] ?></span>
                </div>
            </div>
        </div>

        <div class="content-section">
            <h3><i class="fas fa-chart-line"></i> Evaluaciones</h3>
            <div class="info-grid">
                <div class="info-item">
                    <label>Última Evaluación:</label>
                    <span><?= date('d/m/Y', strtotime($empleado['ultima_evaluacion'])) ?></span>
                </div>
                <div class="info-item">
                    <label>Próxima Evaluación:</label>
                    <span><?= date('d/m/Y', strtotime($empleado['proxima_evaluacion'])) ?></span>
                </div>
                <div class="info-item full-width">
                    <label>Observaciones:</label>
                    <span><?= $empleado['observaciones'] ?></span>
                </div>
            </div>
        </div>

        <div class="content-section">
            <h3><i class="fas fa-users"></i> Información Familiar</h3>
            <div class="info-grid">
                <div class="info-item">
                    <label>Hijos Estudiantes:</label>
                    <span class="badge badge-info"><?= $empleado['hijos_estudiantes'] ?></span>
                </div>
                <div class="info-item">
                    <label>Préstamos Activos:</label>
                    <span class="badge badge-warning"><?= $empleado['prestamos_activos'] ?></span>
                </div>
            </div>
        </div>
    </div>

    <!-- DOCUMENTOS -->
    <div id="documentos" class="tab-content">
        <div class="content-section">
            <div class="section-header">
                <h3><i class="fas fa-folder"></i> Documentos del Empleado</h3>
                <button class="btn btn-success" onclick="uploadDocument()">
                    <i class="fas fa-upload"></i> Subir Documento
                </button>
            </div>
            
            <div class="documents-grid">
                <?php foreach ($documentos as $doc): ?>
                <div class="document-card">
                    <div class="document-icon">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <div class="document-info">
                        <h4><?= $doc['nombre'] ?></h4>
                        <p class="document-type"><?= ucfirst(str_replace('_', ' ', $doc['tipo'])) ?></p>
                        <?php if ($doc['fecha']): ?>
                            <p class="document-date">Actualizado: <?= date('d/m/Y', strtotime($doc['fecha'])) ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="document-status">
                        <span class="badge badge-<?= $doc['status'] ?>">
                            <?php
                                switch($doc['status']) {
                                    case 'completo': echo 'Completo'; break;
                                    case 'pendiente': echo 'Pendiente'; break;
                                    case 'vencido': echo 'Vencido'; break;
                                }
                            ?>
                        </span>
                    </div>
                    <div class="document-actions">
                        <?php if ($doc['status'] === 'completo'): ?>
                            <button class="btn btn-sm btn-primary" onclick="viewDocument('<?= $doc['tipo'] ?>')">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-sm btn-secondary" onclick="downloadDocument('<?= $doc['tipo'] ?>')">
                                <i class="fas fa-download"></i>
                            </button>
                        <?php endif; ?>
                        <button class="btn btn-sm btn-warning" onclick="replaceDocument('<?= $doc['tipo'] ?>')">
                            <i class="fas fa-upload"></i>
                        </button>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- HISTORIAL -->
    <div id="historial" class="tab-content">
        <div class="content-section">
            <h3><i class="fas fa-history"></i> Historial Laboral</h3>
            <div class="timeline">
                <?php foreach ($historial as $evento): ?>
                <div class="timeline-item">
                    <div class="timeline-date">
                        <?= date('d/m/Y', strtotime($evento['fecha'])) ?>
                    </div>
                    <div class="timeline-content">
                        <h4><?= $evento['evento'] ?></h4>
                        <p class="timeline-result"><?= $evento['resultado'] ?></p>
                        <p class="timeline-observations"><?= $evento['observaciones'] ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- CAPACITACIONES -->
    <div id="capacitaciones" class="tab-content">
        <div class="content-section">
            <div class="section-header">
                <h3><i class="fas fa-graduation-cap"></i> Capacitaciones y Cursos</h3>
                <button class="btn btn-success" onclick="addTraining()">
                    <i class="fas fa-plus"></i> Agregar Capacitación
                </button>
            </div>
            
            <div class="trainings-table">
                <table>
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Curso</th>
                            <th>Duración</th>
                            <th>Institución</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($capacitaciones as $cap): ?>
                        <tr>
                            <td><?= date('d/m/Y', strtotime($cap['fecha'])) ?></td>
                            <td><?= $cap['curso'] ?></td>
                            <td><?= $cap['duracion'] ?></td>
                            <td><?= $cap['institucion'] ?></td>
                            <td>
                                <span class="badge badge-<?= strtolower($cap['status']) === 'completado' ? 'active' : 'pending' ?>">
                                    <?= $cap['status'] ?>
                                </span>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-primary" onclick="viewCertificate()">
                                    <i class="fas fa-certificate"></i>
                                </button>
                                <button class="btn btn-sm btn-warning" onclick="editTraining()">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- NÓMINA -->
    <div id="nomina" class="tab-content">
        <div class="content-section">
            <h3><i class="fas fa-dollar-sign"></i> Información de Nómina</h3>
            <div class="nomina-summary">
                <div class="nomina-card">
                    <h4>Salario Actual</h4>
                    <div class="amount">$<?= number_format($empleado['salario_base']) ?></div>
                    <p>Salario Base Mensual</p>
                </div>
                <div class="nomina-card">
                    <h4>Último Pago</h4>
                    <div class="amount">$<?= number_format($empleado['salario_base']) ?></div>
                    <p>13 de Agosto, 2025</p>
                </div>
                <div class="nomina-card">
                    <h4>Deducciones</h4>
                    <div class="amount">$<?= number_format($empleado['salario_base'] * 0.15) ?></div>
                    <p>IMSS, ISR, etc.</p>
                </div>
                <div class="nomina-card">
                    <h4>Neto</h4>
                    <div class="amount">$<?= number_format($empleado['salario_base'] * 0.85) ?></div>
                    <p>Pago Neto</p>
                </div>
            </div>
            
            <div class="nomina-actions">
                <button class="btn btn-primary" onclick="viewPayrollHistory()">
                    <i class="fas fa-history"></i> Ver Historial de Pagos
                </button>
                <button class="btn btn-warning" onclick="generatePayStub()">
                    <i class="fas fa-file-invoice"></i> Generar Recibo
                </button>
                <button class="btn btn-info" onclick="viewPayrollDetails()">
                    <i class="fas fa-calculator"></i> Detalles de Nómina
                </button>
            </div>
        </div>
    </div>
</div>

<!-- ===================== ESTILOS ESPECÍFICOS ===================== -->
<style>
    .expediente-empleado {
        max-width: 1200px;
        margin: 0 auto;
        animation: fadeIn 0.5s ease;
    }

    .expediente-header {
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

    .employee-profile {
        display: flex;
        gap: 2rem;
        align-items: center;
    }

    .employee-photo {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        overflow: hidden;
        border: 4px solid var(--primary-color);
    }

    .employee-photo img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .photo-placeholder {
        width: 100%;
        height: 100%;
        background: var(--primary-color);
        color: var(--dark);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        font-weight: bold;
    }

    .employee-info h1 {
        margin: 0 0 0.5rem 0;
        color: var(--dark);
        font-size: 1.8rem;
    }

    .position {
        font-size: 1.2rem;
        font-weight: 600;
        color: var(--primary-color);
        margin: 0 0 0.25rem 0;
    }

    .department {
        color: var(--gray-600);
        margin: 0 0 1rem 0;
    }

    .employee-status {
        display: flex;
        gap: 1rem;
        align-items: center;
    }

    .employee-id {
        background: var(--gray-100);
        padding: 0.25rem 0.75rem;
        border-radius: 12px;
        font-size: 0.9rem;
        color: var(--gray-600);
    }

    .expediente-actions {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .expediente-tabs {
        display: flex;
        gap: 0.5rem;
        margin-bottom: 2rem;
        background: var(--white);
        padding: 1rem;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        overflow-x: auto;
    }

    .tab-btn {
        padding: 1rem 1.5rem;
        border: none;
        background: var(--gray-100);
        color: var(--gray-600);
        border-radius: var(--border-radius);
        cursor: pointer;
        transition: var(--transition);
        white-space: nowrap;
        font-weight: 600;
    }

    .tab-btn:hover {
        background: var(--primary-light);
        color: var(--primary-color);
    }

    .tab-btn.active {
        background: var(--primary-color);
        color: var(--dark);
    }

    .tab-content {
        display: none;
        animation: fadeIn 0.3s ease;
    }

    .tab-content.active {
        display: block;
    }

    .content-section {
        background: var(--white);
        padding: 2rem;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        margin-bottom: 2rem;
    }

    .content-section h3 {
        color: var(--primary-color);
        margin-bottom: 1.5rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid var(--primary-light);
    }

    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }

    .section-header h3 {
        margin-bottom: 0;
        border-bottom: none;
        padding-bottom: 0;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
    }

    .info-item {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .info-item.full-width {
        grid-column: 1 / -1;
    }

    .info-item label {
        font-weight: 600;
        color: var(--gray-700);
        font-size: 0.9rem;
    }

    .info-item span {
        color: var(--dark);
        font-size: 1rem;
        padding: 0.75rem;
        background: var(--gray-50);
        border-radius: var(--border-radius);
        border-left: 3px solid var(--primary-color);
    }

    .salary-amount {
        color: var(--success-color) !important;
        font-weight: bold;
        font-size: 1.2rem !important;
    }

    .documents-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 1.5rem;
    }

    .document-card {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1.5rem;
        background: var(--gray-50);
        border-radius: var(--border-radius);
        border-left: 4px solid var(--info-color);
        transition: var(--transition);
    }

    .document-card:hover {
        background: var(--white);
        box-shadow: var(--shadow);
    }

    .document-icon {
        font-size: 2rem;
        color: var(--info-color);
    }

    .document-info {
        flex: 1;
    }

    .document-info h4 {
        margin: 0 0 0.25rem 0;
        color: var(--dark);
        font-size: 1rem;
    }

    .document-type {
        color: var(--gray-600);
        font-size: 0.8rem;
        margin: 0;
    }

    .document-date {
        color: var(--gray-500);
        font-size: 0.8rem;
        margin: 0.25rem 0 0 0;
    }

    .document-actions {
        display: flex;
        gap: 0.5rem;
    }

    .timeline {
        position: relative;
        padding-left: 2rem;
    }

    .timeline::before {
        content: '';
        position: absolute;
        left: 1rem;
        top: 0;
        bottom: 0;
        width: 2px;
        background: var(--primary-color);
    }

    .timeline-item {
        position: relative;
        margin-bottom: 2rem;
        padding-left: 2rem;
    }

    .timeline-item::before {
        content: '';
        position: absolute;
        left: -0.5rem;
        top: 0.5rem;
        width: 1rem;
        height: 1rem;
        background: var(--primary-color);
        border-radius: 50%;
        border: 3px solid var(--white);
        box-shadow: 0 0 0 3px var(--primary-light);
    }

    .timeline-date {
        color: var(--primary-color);
        font-weight: 600;
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
    }

    .timeline-content h4 {
        margin: 0 0 0.25rem 0;
        color: var(--dark);
    }

    .timeline-result {
        color: var(--success-color);
        font-weight: 600;
        margin: 0 0 0.5rem 0;
    }

    .timeline-observations {
        color: var(--gray-600);
        margin: 0;
        font-style: italic;
    }

    .trainings-table {
        overflow-x: auto;
    }

    .trainings-table table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 1rem;
    }

    .trainings-table th,
    .trainings-table td {
        padding: 1rem;
        text-align: left;
        border-bottom: 1px solid var(--gray-200);
    }

    .trainings-table th {
        background: var(--primary-light);
        color: var(--dark);
        font-weight: 600;
    }

    .trainings-table tbody tr:hover {
        background: var(--gray-50);
    }

    .nomina-summary {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .nomina-card {
        background: var(--gray-50);
        padding: 1.5rem;
        border-radius: var(--border-radius);
        text-align: center;
        border-left: 4px solid var(--primary-color);
    }

    .nomina-card h4 {
        margin: 0 0 1rem 0;
        color: var(--gray-700);
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .nomina-card .amount {
        font-size: 1.8rem;
        font-weight: bold;
        color: var(--primary-color);
        margin-bottom: 0.5rem;
    }

    .nomina-card p {
        color: var(--gray-600);
        margin: 0;
        font-size: 0.8rem;
    }

    .nomina-actions {
        display: flex;
        gap: 1rem;
        justify-content: center;
        flex-wrap: wrap;
    }

    .badge {
        padding: 0.25rem 0.75rem;
        border-radius: 12px;
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .badge-active {
        background: var(--success-light);
        color: var(--success-color);
    }

    .badge-inactive {
        background: var(--danger-light);
        color: var(--danger-color);
    }

    .badge-info {
        background: var(--info-light);
        color: var(--info-color);
    }

    .badge-warning {
        background: var(--warning-light);
        color: var(--warning-color);
    }

    .badge-completo {
        background: var(--success-light);
        color: var(--success-color);
    }

    .badge-pendiente {
        background: var(--warning-light);
        color: var(--warning-color);
    }

    .badge-vencido {
        background: var(--danger-light);
        color: var(--danger-color);
    }

    .badge-pending {
        background: var(--warning-light);
        color: var(--warning-color);
    }

    @media (max-width: 768px) {
        .expediente-header {
            flex-direction: column;
            gap: 2rem;
        }

        .employee-profile {
            flex-direction: column;
            text-align: center;
        }

        .expediente-actions {
            justify-content: center;
        }

        .expediente-tabs {
            flex-direction: column;
        }

        .info-grid {
            grid-template-columns: 1fr;
        }

        .nomina-summary {
            grid-template-columns: repeat(2, 1fr);
        }

        .nomina-actions {
            flex-direction: column;
        }
    }
</style>

<!-- ===================== SCRIPTS ESPECÍFICOS ===================== -->
<script>
    // Función para mostrar pestañas
    function showTab(tabName) {
        // Ocultar todas las pestañas
        document.querySelectorAll('.tab-content').forEach(tab => {
            tab.classList.remove('active');
        });
        
        // Desactivar todos los botones
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.classList.remove('active');
        });
        
        // Mostrar la pestaña seleccionada
        document.getElementById(tabName).classList.add('active');
        
        // Activar el botón correspondiente
        event.target.classList.add('active');
    }

    // Funciones de acciones del expediente
    function editEmployee() {
        alert('Editar Empleado\n\nSe abrirá el formulario de edición con todos los datos actuales del empleado para su modificación.');
    }

    function generateEmployeeReport() {
        alert('Generar Reporte de Empleado\n\nSe generará un reporte completo en PDF con:\n• Datos personales\n• Información laboral\n• Historial\n• Documentos\n• Evaluaciones');
    }

    function printExpediente() {
        if(confirm('¿Imprimir expediente completo?\n\nSe imprimirá toda la información del empleado.')) {
            window.print();
        }
    }

    function goBackToEmployees() {
        window.location.href = '?section=lista_empleados';
    }

    function uploadDocument() {
        alert('Subir Documento\n\nSe abrirá el formulario para subir un nuevo documento:\n• Seleccionar tipo de documento\n• Cargar archivo\n• Agregar observaciones');
    }

    function viewDocument(tipo) {
        alert(`Ver Documento: ${tipo}\n\nSe abrirá el visor de documentos para mostrar el archivo correspondiente.`);
    }

    function downloadDocument(tipo) {
        alert(`Descargar Documento: ${tipo}\n\nSe descargará el archivo del documento solicitado.`);
    }

    function replaceDocument(tipo) {
        alert(`Reemplazar Documento: ${tipo}\n\nSe abrirá el formulario para reemplazar el documento actual con una nueva versión.`);
    }

    function addTraining() {
        alert('Agregar Capacitación\n\nSe abrirá el formulario para registrar una nueva capacitación:\n• Nombre del curso\n• Institución\n• Fecha de realización\n• Duración\n• Certificado');
    }

    function viewCertificate() {
        alert('Ver Certificado\n\nSe mostrará el certificado de la capacitación correspondiente.');
    }

    function editTraining() {
        alert('Editar Capacitación\n\nSe abrirá el formulario para editar los datos de la capacitación seleccionada.');
    }

    function viewPayrollHistory() {
        alert('Historial de Pagos\n\nSe mostrará el historial completo de pagos del empleado con:\n• Fechas de pago\n• Montos\n• Deducciones\n• Bonos\n• Recibos');
    }

    function generatePayStub() {
        alert('Generar Recibo de Nómina\n\nSe generará el recibo de pago más reciente en formato PDF.');
    }

    function viewPayrollDetails() {
        alert('Detalles de Nómina\n\nSe mostrarán los detalles completos del cálculo de nómina:\n• Salario base\n• Prestaciones\n• Deducciones\n• Impuestos\n• Neto a pagar');
    }

    // Inicialización
    document.addEventListener('DOMContentLoaded', function() {
        // Animación de entrada
        document.querySelector('.expediente-empleado').style.opacity = '0';
        document.querySelector('.expediente-empleado').style.transform = 'translateY(20px)';
        
        setTimeout(() => {
            document.querySelector('.expediente-empleado').style.transition = 'all 0.5s ease';
            document.querySelector('.expediente-empleado').style.opacity = '1';
            document.querySelector('.expediente-empleado').style.transform = 'translateY(0)';
        }, 100);
    });
</script>
