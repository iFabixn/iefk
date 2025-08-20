<?php
// Configuración de reportes disponibles
$tipos_reportes = [
    'estudiantes' => [
        'name' => 'Listados de Estudiantes',
        'icon' => 'users',
        'color' => 'primary',
        'options' => [
            'Lista completa de estudiantes por plantel',
            'Estudiantes por nivel educativo',
            'Estudiantes con documentos pendientes',
            'Nuevas inscripciones por período',
            'Lista de contactos de emergencia'
        ]
    ],
    'medico' => [
        'name' => 'Reportes Médicos',
        'icon' => 'heartbeat',
        'color' => 'danger',
        'options' => [
            'Estudiantes con alergias conocidas',
            'Medicamentos por estudiante',
            'Condiciones médicas especiales',
            'Historial de incidentes médicos',
            'Estudiantes sin certificado médico vigente'
        ]
    ],
    'academico' => [
        'name' => 'Reportes Académicos',
        'icon' => 'graduation-cap',
        'color' => 'success',
        'options' => [
            'Calificaciones por período',
            'Reportes de asistencia',
            'Estudiantes con bajo rendimiento',
            'Actividades extracurriculares',
            'Historial académico completo'
        ]
    ],
    'administrativo' => [
        'name' => 'Reportes Administrativos',
        'icon' => 'file-alt',
        'color' => 'info',
        'options' => [
            'Reporte de pagos y colegiaturas',
            'Documentación por estudiante',
            'Estados de cuenta familiares',
            'Reportes de comunicaciones',
            'Análisis de capacidad por aula'
        ]
    ],
    'estadistico' => [
        'name' => 'Reportes Estadísticos',
        'icon' => 'chart-line',
        'color' => 'warning',
        'options' => [
            'Tendencias de inscripción',
            'Análisis demográfico',
            'Distribución por edades',
            'Índices de retención',
            'Comparativas mensuales'
        ]
    ]
];

$reportes_rapidos = [
    [
        'title' => 'Lista de Estudiantes Activos',
        'description' => 'Todos los estudiantes con status activo',
        'type' => 'estudiantes',
        'format' => 'PDF'
    ],
    [
        'title' => 'Alertas Médicas',
        'description' => 'Estudiantes con condiciones médicas',
        'type' => 'medico',
        'format' => 'Excel'
    ],
    [
        'title' => 'Reporte de Asistencia Mensual',
        'description' => 'Asistencia del mes actual',
        'type' => 'academico',
        'format' => 'PDF'
    ],
    [
        'title' => 'Documentos Pendientes',
        'description' => 'Estudiantes con documentación incompleta',
        'type' => 'administrativo',
        'format' => 'Excel'
    ]
];

$planteles = ['El Zapote', 'Insurgentes', 'Lindavista'];
$niveles = ['Guardería', 'Preescolar', 'Primaria'];
$formatos = ['PDF', 'Excel', 'Word', 'CSV'];
?>

<!-- ===================== REPORTES ===================== -->
<div class="reportes-section">
    <div class="content-body">
        <h2 style="color: var(--primary-color); margin-bottom: 2rem;">
            <i class="fas fa-file-alt"></i> Generación de Reportes
        </h2>
        
        <!-- Reportes Rápidos -->
        <div class="quick-reports">
            <h3><i class="fas fa-bolt"></i> Reportes Rápidos</h3>
            <p>Genera reportes predefinidos con un solo clic</p>
            
            <div class="quick-reports-grid">
                <?php foreach ($reportes_rapidos as $index => $reporte): ?>
                <div class="quick-report-card">
                    <div class="report-icon">
                        <i class="fas fa-<?= $tipos_reportes[$reporte['type']]['icon'] ?>"></i>
                    </div>
                    <div class="report-content">
                        <h4><?= $reporte['title'] ?></h4>
                        <p><?= $reporte['description'] ?></p>
                        <div class="report-format">
                            <span class="badge badge-<?= $tipos_reportes[$reporte['type']]['color'] ?>">
                                <?= $reporte['format'] ?>
                            </span>
                        </div>
                    </div>
                    <div class="report-actions">
                        <button class="btn btn-<?= $tipos_reportes[$reporte['type']]['color'] ?>" 
                                onclick="generateQuickReport(<?= $index ?>)">
                            <i class="fas fa-download"></i>
                            Generar
                        </button>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        
        <!-- Generador de Reportes Personalizados -->
        <div class="custom-reports">
            <h3><i class="fas fa-cog"></i> Generador de Reportes Personalizados</h3>
            <p>Configura reportes específicos según tus necesidades</p>
            
            <div class="report-configurator">
                <div class="config-section">
                    <h4>1. Tipo de Reporte</h4>
                    <div class="report-types">
                        <?php foreach ($tipos_reportes as $key => $tipo): ?>
                        <div class="report-type-option">
                            <input type="radio" id="type-<?= $key ?>" name="report_type" value="<?= $key ?>">
                            <label for="type-<?= $key ?>" class="report-type-label">
                                <div class="type-icon">
                                    <i class="fas fa-<?= $tipo['icon'] ?>"></i>
                                </div>
                                <div class="type-content">
                                    <h5><?= $tipo['name'] ?></h5>
                                    <div class="type-options">
                                        <?php foreach (array_slice($tipo['options'], 0, 3) as $option): ?>
                                        <span>• <?= $option ?></span>
                                        <?php endforeach; ?>
                                        <?php if (count($tipo['options']) > 3): ?>
                                        <span>• Y más...</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </label>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                
                <div class="config-section">
                    <h4>2. Filtros de Datos</h4>
                    <div class="filters-grid">
                        <div class="filter-group">
                            <label for="filter-plantel">Plantel</label>
                            <select id="filter-plantel" name="plantel">
                                <option value="">Todos los Planteles</option>
                                <?php foreach ($planteles as $plantel): ?>
                                <option value="<?= $plantel ?>"><?= $plantel ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="filter-group">
                            <label for="filter-nivel">Nivel Educativo</label>
                            <select id="filter-nivel" name="nivel">
                                <option value="">Todos los Niveles</option>
                                <?php foreach ($niveles as $nivel): ?>
                                <option value="<?= $nivel ?>"><?= $nivel ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="filter-group">
                            <label for="filter-fecha-inicio">Fecha de Inicio</label>
                            <input type="date" id="filter-fecha-inicio" name="fecha_inicio">
                        </div>
                        
                        <div class="filter-group">
                            <label for="filter-fecha-fin">Fecha de Fin</label>
                            <input type="date" id="filter-fecha-fin" name="fecha_fin">
                        </div>
                        
                        <div class="filter-group">
                            <label for="filter-status">Estado</label>
                            <select id="filter-status" name="status">
                                <option value="">Todos los Estados</option>
                                <option value="Activo">Activo</option>
                                <option value="Pendiente Documentos">Pendiente Documentos</option>
                                <option value="Suspendido">Suspendido</option>
                                <option value="Dado de Baja">Dado de Baja</option>
                            </select>
                        </div>
                        
                        <div class="filter-group">
                            <label for="filter-edad-min">Edad Mínima</label>
                            <input type="number" id="filter-edad-min" name="edad_min" min="1" max="15">
                        </div>
                    </div>
                </div>
                
                <div class="config-section">
                    <h4>3. Campos a Incluir</h4>
                    <div class="fields-selection">
                        <div class="field-category">
                            <h5>Información Básica</h5>
                            <div class="field-checkboxes">
                                <label><input type="checkbox" checked> Nombre Completo</label>
                                <label><input type="checkbox" checked> Edad</label>
                                <label><input type="checkbox" checked> Fecha de Nacimiento</label>
                                <label><input type="checkbox"> CURP</label>
                                <label><input type="checkbox"> Número de Expediente</label>
                                <label><input type="checkbox"> Fecha de Inscripción</label>
                            </div>
                        </div>
                        
                        <div class="field-category">
                            <h5>Información Académica</h5>
                            <div class="field-checkboxes">
                                <label><input type="checkbox" checked> Plantel</label>
                                <label><input type="checkbox" checked> Aula</label>
                                <label><input type="checkbox"> Nivel Educativo</label>
                                <label><input type="checkbox"> Calificaciones</label>
                                <label><input type="checkbox"> Asistencia</label>
                                <label><input type="checkbox"> Actividades Extracurriculares</label>
                            </div>
                        </div>
                        
                        <div class="field-category">
                            <h5>Información de Contacto</h5>
                            <div class="field-checkboxes">
                                <label><input type="checkbox" checked> Tutor Principal</label>
                                <label><input type="checkbox"> Tutor Secundario</label>
                                <label><input type="checkbox" checked> Teléfono</label>
                                <label><input type="checkbox"> Email</label>
                                <label><input type="checkbox"> Dirección</label>
                                <label><input type="checkbox"> Personas Autorizadas</label>
                            </div>
                        </div>
                        
                        <div class="field-category">
                            <h5>Información Médica</h5>
                            <div class="field-checkboxes">
                                <label><input type="checkbox"> Alergias</label>
                                <label><input type="checkbox"> Medicamentos</label>
                                <label><input type="checkbox"> Tipo de Sangre</label>
                                <label><input type="checkbox"> Condiciones Especiales</label>
                                <label><input type="checkbox"> Contactos de Emergencia</label>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="config-section">
                    <h4>4. Formato y Opciones</h4>
                    <div class="format-options">
                        <div class="format-group">
                            <label>Formato de Salida</label>
                            <div class="format-buttons">
                                <?php foreach ($formatos as $formato): ?>
                                <label class="format-option">
                                    <input type="radio" name="format" value="<?= $formato ?>">
                                    <div class="format-card">
                                        <i class="fas fa-file-<?= strtolower($formato) === 'pdf' ? 'pdf' : 
                                                                  (strtolower($formato) === 'excel' ? 'excel' : 
                                                                  (strtolower($formato) === 'word' ? 'word' : 'code')) ?>"></i>
                                        <span><?= $formato ?></span>
                                    </div>
                                </label>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        
                        <div class="additional-options">
                            <label class="checkbox-option">
                                <input type="checkbox" id="include-photos">
                                <span>Incluir fotografías de estudiantes</span>
                            </label>
                            <label class="checkbox-option">
                                <input type="checkbox" id="include-charts">
                                <span>Incluir gráficos estadísticos</span>
                            </label>
                            <label class="checkbox-option">
                                <input type="checkbox" id="group-by-level">
                                <span>Agrupar por nivel educativo</span>
                            </label>
                            <label class="checkbox-option">
                                <input type="checkbox" id="sort-alphabetically">
                                <span>Ordenar alfabéticamente</span>
                            </label>
                        </div>
                    </div>
                </div>
                
                <div class="config-actions">
                    <button class="btn btn-primary btn-lg" onclick="generateCustomReport()">
                        <i class="fas fa-file-download"></i>
                        Generar Reporte Personalizado
                    </button>
                    <button class="btn btn-secondary" onclick="previewReport()">
                        <i class="fas fa-eye"></i>
                        Vista Previa
                    </button>
                    <button class="btn btn-success" onclick="saveTemplate()">
                        <i class="fas fa-save"></i>
                        Guardar como Plantilla
                    </button>
                    <button class="btn btn-outline-secondary" onclick="resetConfiguration()">
                        <i class="fas fa-undo"></i>
                        Reiniciar
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Plantillas Guardadas -->
        <div class="saved-templates">
            <h3><i class="fas fa-bookmark"></i> Plantillas Guardadas</h3>
            <p>Accede rápidamente a configuraciones de reportes guardadas anteriormente</p>
            
            <div class="templates-grid">
                <div class="template-card">
                    <div class="template-info">
                        <h4>Lista Completa con Contactos</h4>
                        <p>Todos los estudiantes con información de contacto completa</p>
                        <div class="template-meta">
                            <span class="badge badge-primary">PDF</span>
                            <span class="template-date">Creado: 15/12/2024</span>
                        </div>
                    </div>
                    <div class="template-actions">
                        <button class="btn btn-primary btn-sm" onclick="useTemplate('template1')">
                            <i class="fas fa-play"></i> Usar
                        </button>
                        <button class="btn btn-warning btn-sm" onclick="editTemplate('template1')">
                            <i class="fas fa-edit"></i> Editar
                        </button>
                        <button class="btn btn-danger btn-sm" onclick="deleteTemplate('template1')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
                
                <div class="template-card">
                    <div class="template-info">
                        <h4>Reporte Médico Completo</h4>
                        <p>Todas las condiciones médicas y alergias por plantel</p>
                        <div class="template-meta">
                            <span class="badge badge-danger">Excel</span>
                            <span class="template-date">Creado: 10/12/2024</span>
                        </div>
                    </div>
                    <div class="template-actions">
                        <button class="btn btn-primary btn-sm" onclick="useTemplate('template2')">
                            <i class="fas fa-play"></i> Usar
                        </button>
                        <button class="btn btn-warning btn-sm" onclick="editTemplate('template2')">
                            <i class="fas fa-edit"></i> Editar
                        </button>
                        <button class="btn btn-danger btn-sm" onclick="deleteTemplate('template2')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
                
                <div class="template-card">
                    <div class="template-info">
                        <h4>Estadísticas Mensuales</h4>
                        <p>Reporte estadístico con gráficos y tendencias</p>
                        <div class="template-meta">
                            <span class="badge badge-warning">PDF</span>
                            <span class="template-date">Creado: 05/12/2024</span>
                        </div>
                    </div>
                    <div class="template-actions">
                        <button class="btn btn-primary btn-sm" onclick="useTemplate('template3')">
                            <i class="fas fa-play"></i> Usar
                        </button>
                        <button class="btn btn-warning btn-sm" onclick="editTemplate('template3')">
                            <i class="fas fa-edit"></i> Editar
                        </button>
                        <button class="btn btn-danger btn-sm" onclick="deleteTemplate('template3')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Historial de Reportes -->
        <div class="reports-history">
            <h3><i class="fas fa-history"></i> Historial de Reportes Generados</h3>
            <div class="history-table">
                <table>
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Tipo de Reporte</th>
                            <th>Filtros Aplicados</th>
                            <th>Formato</th>
                            <th>Generado por</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>13/12/2024 10:30</td>
                            <td>Lista de Estudiantes</td>
                            <td>Plantel: El Zapote</td>
                            <td><span class="badge badge-primary">PDF</span></td>
                            <td>Administrador</td>
                            <td>
                                <button class="btn btn-secondary btn-sm" onclick="downloadReport('report1')">
                                    <i class="fas fa-download"></i>
                                </button>
                                <button class="btn btn-info btn-sm" onclick="regenerateReport('report1')">
                                    <i class="fas fa-redo"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>12/12/2024 14:15</td>
                            <td>Reporte Médico</td>
                            <td>Todos los planteles</td>
                            <td><span class="badge badge-success">Excel</span></td>
                            <td>Administrador</td>
                            <td>
                                <button class="btn btn-secondary btn-sm" onclick="downloadReport('report2')">
                                    <i class="fas fa-download"></i>
                                </button>
                                <button class="btn btn-info btn-sm" onclick="regenerateReport('report2')">
                                    <i class="fas fa-redo"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>11/12/2024 09:45</td>
                            <td>Estadísticas</td>
                            <td>Noviembre 2024</td>
                            <td><span class="badge badge-warning">PDF</span></td>
                            <td>Administrador</td>
                            <td>
                                <button class="btn btn-secondary btn-sm" onclick="downloadReport('report3')">
                                    <i class="fas fa-download"></i>
                                </button>
                                <button class="btn btn-info btn-sm" onclick="regenerateReport('report3')">
                                    <i class="fas fa-redo"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- ===================== SCRIPTS ESPECÍFICOS ===================== -->
<script>
    // Función para generar reportes rápidos
    function generateQuickReport(index) {
        const quickReports = <?= json_encode($reportes_rapidos) ?>;
        const report = quickReports[index];
        
        if(confirm(`Generar "${report.title}"?\n\n${report.description}\n\nFormato: ${report.format}`)) {
            showLoadingMessage(`Generando ${report.title}...`);
            
            // Simular generación
            setTimeout(() => {
                alert(`¡Reporte generado exitosamente!\n\n"${report.title}" ha sido creado en formato ${report.format}.\n\nEl archivo se descargará automáticamente.`);
            }, 2000);
        }
    }

    // Función para generar reporte personalizado
    function generateCustomReport() {
        const reportType = document.querySelector('input[name="report_type"]:checked');
        const format = document.querySelector('input[name="format"]:checked');
        
        if (!reportType) {
            alert('Por favor selecciona un tipo de reporte.');
            return;
        }
        
        if (!format) {
            alert('Por favor selecciona un formato de salida.');
            return;
        }
        
        // Recopilar filtros
        const filters = {
            plantel: document.getElementById('filter-plantel').value,
            nivel: document.getElementById('filter-nivel').value,
            fecha_inicio: document.getElementById('filter-fecha-inicio').value,
            fecha_fin: document.getElementById('filter-fecha-fin').value,
            status: document.getElementById('filter-status').value,
            edad_min: document.getElementById('filter-edad-min').value
        };
        
        // Recopilar campos seleccionados
        const selectedFields = [];
        document.querySelectorAll('.field-checkboxes input[type="checkbox"]:checked').forEach(checkbox => {
            selectedFields.push(checkbox.parentElement.textContent.trim());
        });
        
        if (selectedFields.length === 0) {
            alert('Por favor selecciona al menos un campo para incluir en el reporte.');
            return;
        }
        
        const reportTypeName = document.querySelector(`label[for="${reportType.id}"] h5`).textContent;
        
        if(confirm(`Generar Reporte Personalizado?\n\nTipo: ${reportTypeName}\nFormato: ${format.value}\nCampos seleccionados: ${selectedFields.length}\n\n¿Proceder con la generación?`)) {
            showLoadingMessage('Generando reporte personalizado...');
            
            setTimeout(() => {
                alert(`¡Reporte personalizado generado exitosamente!\n\nSe ha creado un reporte de "${reportTypeName}" con ${selectedFields.length} campos en formato ${format.value}.\n\nEl archivo se descargará automáticamente.`);
            }, 3000);
        }
    }

    // Función para vista previa
    function previewReport() {
        const reportType = document.querySelector('input[name="report_type"]:checked');
        
        if (!reportType) {
            alert('Por favor selecciona un tipo de reporte para la vista previa.');
            return;
        }
        
        alert('Vista Previa del Reporte\n\nSe abrirá una ventana con una muestra del reporte basado en la configuración actual.\n\nEsto te permitirá verificar el formato y contenido antes de la generación final.');
    }

    // Función para guardar plantilla
    function saveTemplate() {
        const templateName = prompt('Nombre para la plantilla:');
        
        if (templateName) {
            alert(`Plantilla guardada exitosamente!\n\nNombre: "${templateName}"\n\nLa configuración actual ha sido guardada y estará disponible en la sección de "Plantillas Guardadas".`);
        }
    }

    // Función para usar plantilla
    function useTemplate(templateId) {
        alert(`Cargando plantilla: ${templateId}\n\nSe aplicará la configuración guardada y se generará el reporte automáticamente.`);
    }

    // Función para editar plantilla
    function editTemplate(templateId) {
        alert(`Editar plantilla: ${templateId}\n\nSe cargará la configuración actual de la plantilla para su modificación.`);
    }

    // Función para eliminar plantilla
    function deleteTemplate(templateId) {
        if(confirm('¿Eliminar esta plantilla?\n\nEsta acción no se puede deshacer.')) {
            alert(`Plantilla ${templateId} eliminada exitosamente.`);
        }
    }

    // Función para reiniciar configuración
    function resetConfiguration() {
        if(confirm('¿Reiniciar toda la configuración?\n\nSe perderán todos los filtros y selecciones actuales.')) {
            document.querySelectorAll('input[type="radio"], input[type="checkbox"]').forEach(input => {
                input.checked = false;
            });
            document.querySelectorAll('select, input[type="text"], input[type="date"], input[type="number"]').forEach(input => {
                input.value = '';
            });
            
            // Marcar campos básicos por defecto
            document.querySelectorAll('.field-category:first-child input[type="checkbox"]').forEach((checkbox, index) => {
                if (index < 3) checkbox.checked = true;
            });
        }
    }

    // Función para mostrar mensaje de carga
    function showLoadingMessage(message) {
        const overlay = document.createElement('div');
        overlay.style.cssText = `
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.7);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            color: white;
            font-size: 1.2rem;
        `;
        overlay.innerHTML = `
            <div style="text-align: center;">
                <div style="margin-bottom: 1rem;">
                    <i class="fas fa-spinner fa-spin fa-3x"></i>
                </div>
                <div>${message}</div>
            </div>
        `;
        
        document.body.appendChild(overlay);
        
        setTimeout(() => {
            document.body.removeChild(overlay);
        }, 2000);
    }

    // Funciones del historial
    function downloadReport(reportId) {
        alert(`Descargando reporte: ${reportId}\n\nEl archivo se descargará automáticamente.`);
    }

    function regenerateReport(reportId) {
        if(confirm('¿Regenerar este reporte con datos actualizados?')) {
            alert(`Regenerando reporte: ${reportId}\n\nSe creará una nueva versión con los datos más recientes.`);
        }
    }

    // Inicializar al cargar la página
    document.addEventListener('DOMContentLoaded', function() {
        // Marcar campos básicos por defecto
        document.querySelectorAll('.field-category:first-child input[type="checkbox"]').forEach((checkbox, index) => {
            if (index < 3) checkbox.checked = true;
        });
        
        // Establecer fechas por defecto
        const today = new Date();
        const firstDay = new Date(today.getFullYear(), today.getMonth(), 1);
        document.getElementById('filter-fecha-inicio').value = firstDay.toISOString().split('T')[0];
        document.getElementById('filter-fecha-fin').value = today.toISOString().split('T')[0];
    });
</script>
