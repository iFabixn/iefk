<?php
// Obtener tipo preseleccionado si viene de acceso rápido
$tipo_preseleccionado = $_GET['tipo'] ?? '';

// Categorías disponibles
$categorias = [
    'tecnologia' => [
        'nombre' => 'Tecnología',
        'icono' => 'fas fa-laptop',
        'descripcion' => 'Problemas con equipos, software, sistemas, internet'
    ],
    'estudiantes' => [
        'nombre' => 'Situaciones de Estudiantes',
        'icono' => 'fas fa-child',
        'descripcion' => 'Incidencias, comportamiento, académicas, salud'
    ],
    'pedagogico' => [
        'nombre' => 'Pedagógico',
        'icono' => 'fas fa-chalkboard-teacher',
        'descripcion' => 'Métodos de enseñanza, currículum, evaluaciones'
    ],
    'relaciones_laborales' => [
        'nombre' => 'Relaciones Laborales',
        'icono' => 'fas fa-handshake',
        'descripcion' => 'Conflictos, ambiente laboral, comunicación'
    ],
    'infraestructura' => [
        'nombre' => 'Infraestructura',
        'icono' => 'fas fa-building',
        'descripcion' => 'Instalaciones, mantenimiento, seguridad'
    ],
    'mejoras' => [
        'nombre' => 'Mejoras y Sugerencias',
        'icono' => 'fas fa-lightbulb',
        'descripcion' => 'Ideas de mejora, sugerencias, innovaciones'
    ],
    'administrativo' => [
        'nombre' => 'Administrativo',
        'icono' => 'fas fa-clipboard-list',
        'descripcion' => 'Procesos, documentación, trámites'
    ],
    'otros' => [
        'nombre' => 'Otros',
        'icono' => 'fas fa-question-circle',
        'descripcion' => 'Cualquier otro tema no contemplado'
    ]
];

// Niveles de prioridad
$prioridades = [
    'baja' => [
        'nombre' => 'Baja',
        'descripcion' => 'No es urgente, puede esperar varios días',
        'color' => 'success'
    ],
    'media' => [
        'nombre' => 'Media',
        'descripcion' => 'Importante pero no crítico, resolver en 2-3 días',
        'color' => 'warning'
    ],
    'alta' => [
        'nombre' => 'Alta',
        'descripcion' => 'Importante, resolver en 24 horas',
        'color' => 'danger'
    ],
    'urgente' => [
        'nombre' => 'Urgente',
        'descripcion' => 'Crítico, requiere atención inmediata',
        'color' => 'danger'
    ]
];

// Planteles disponibles
$planteles = [
    'el_zapote' => 'El Zapote',
    'insurgentes' => 'Insurgentes',
    'lindavista' => 'Lindavista'
];
?>

<!-- ===================== CREAR TICKET ===================== -->
<div class="crear-ticket">
    <!-- Header -->
    <div class="crear-header">
        <div class="header-content">
            <h1 style="color: var(--primary-color); margin-bottom: 0.5rem;">
                <i class="fas fa-plus-circle"></i> Crear Nuevo Ticket
            </h1>
            <p style="color: var(--gray-600);">
                Completa la información para generar tu solicitud o reporte
            </p>
        </div>
        <div class="header-actions">
            <button class="btn btn-secondary" onclick="cancelarCreacion()">
                <i class="fas fa-times"></i> Cancelar
            </button>
            <button class="btn btn-outline-primary" onclick="guardarBorrador()">
                <i class="fas fa-save"></i> Guardar Borrador
            </button>
        </div>
    </div>

    <!-- Formulario de Creación -->
    <form id="form-ticket" class="ticket-form">
        <!-- Información Básica -->
        <div class="form-section">
            <h3><i class="fas fa-info-circle"></i> Información Básica</h3>
            
            <div class="form-row">
                <div class="form-group full-width">
                    <label for="titulo">Título del Ticket *</label>
                    <input type="text" id="titulo" name="titulo" required
                           placeholder="Describe brevemente el problema o solicitud..."
                           maxlength="100">
                    <small class="form-help">Máximo 100 caracteres. Sé específico y claro.</small>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="categoria">Categoría *</label>
                    <div class="category-selection">
                        <?php foreach ($categorias as $key => $categoria): ?>
                        <div class="category-option <?= $tipo_preseleccionado === $key ? 'selected' : '' ?>"
                             onclick="selectCategory('<?= $key ?>')">
                            <div class="category-icon">
                                <i class="<?= $categoria['icono'] ?>"></i>
                            </div>
                            <div class="category-info">
                                <h4><?= $categoria['nombre'] ?></h4>
                                <p><?= $categoria['descripcion'] ?></p>
                            </div>
                            <input type="radio" name="categoria" value="<?= $key ?>" 
                                   <?= $tipo_preseleccionado === $key ? 'checked' : '' ?> style="display: none;">
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="prioridad">Nivel de Prioridad *</label>
                    <div class="priority-selection">
                        <?php foreach ($prioridades as $key => $prioridad): ?>
                        <div class="priority-option" onclick="selectPriority('<?= $key ?>')">
                            <input type="radio" name="prioridad" value="<?= $key ?>" 
                                   <?= $key === 'media' ? 'checked' : '' ?>>
                            <div class="priority-content">
                                <div class="priority-badge badge-<?= $prioridad['color'] ?>">
                                    <?= $prioridad['nombre'] ?>
                                </div>
                                <p><?= $prioridad['descripcion'] ?></p>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="plantel">Plantel *</label>
                    <select id="plantel" name="plantel" required>
                        <option value="">Selecciona un plantel...</option>
                        <?php foreach ($planteles as $key => $plantel): ?>
                        <option value="<?= $key ?>"><?= $plantel ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>

        <!-- Descripción Detallada -->
        <div class="form-section">
            <h3><i class="fas fa-edit"></i> Descripción Detallada</h3>
            
            <div class="form-row">
                <div class="form-group full-width">
                    <label for="descripcion">Descripción *</label>
                    <textarea id="descripcion" name="descripcion" required rows="6"
                              placeholder="Describe detalladamente la situación, problema o solicitud..."></textarea>
                    <small class="form-help">
                        Incluye toda la información relevante: ¿qué pasó?, ¿cuándo?, ¿dónde?, ¿quién estuvo involucrado?
                    </small>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="pasos_reproducir">Pasos para Reproducir (Opcional)</label>
                    <textarea id="pasos_reproducir" name="pasos_reproducir" rows="4"
                              placeholder="Si es un problema técnico, describe los pasos para reproducirlo..."></textarea>
                </div>

                <div class="form-group">
                    <label for="impacto">Impacto (Opcional)</label>
                    <textarea id="impacto" name="impacto" rows="4"
                              placeholder="¿Cómo afecta esto a las actividades diarias?"></textarea>
                </div>
            </div>
        </div>

        <!-- Personas Involucradas -->
        <div class="form-section">
            <h3><i class="fas fa-users"></i> Personas Involucradas</h3>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="personas_involucradas">Estudiantes/Personal Involucrado</label>
                    <textarea id="personas_involucradas" name="personas_involucradas" rows="3"
                              placeholder="Menciona nombres de estudiantes, maestros o personal involucrado..."></textarea>
                    <small class="form-help">Solo incluye si es relevante para la situación.</small>
                </div>

                <div class="form-group">
                    <label for="testigos">Testigos (Opcional)</label>
                    <textarea id="testigos" name="testigos" rows="3"
                              placeholder="Personas que presenciaron la situación..."></textarea>
                </div>
            </div>
        </div>

        <!-- Adjuntos y Evidencias -->
        <div class="form-section">
            <h3><i class="fas fa-paperclip"></i> Adjuntos y Evidencias</h3>
            
            <div class="form-row">
                <div class="form-group full-width">
                    <label for="archivos">Archivos Adjuntos</label>
                    <div class="file-upload-area" onclick="document.getElementById('archivos').click()">
                        <div class="upload-icon">
                            <i class="fas fa-cloud-upload-alt"></i>
                        </div>
                        <div class="upload-text">
                            <p><strong>Haz clic para subir archivos</strong> o arrastra y suelta aquí</p>
                            <small>Formatos permitidos: PDF, DOC, DOCX, JPG, PNG, MP4 (máx. 10MB cada uno)</small>
                        </div>
                    </div>
                    <input type="file" id="archivos" name="archivos[]" multiple 
                           accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.mp4" style="display: none;">
                    <div id="files-list" class="files-list"></div>
                </div>
            </div>
        </div>

        <!-- Configuración Adicional -->
        <div class="form-section">
            <h3><i class="fas fa-cog"></i> Configuración Adicional</h3>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="asignar_a">Asignar a (Opcional)</label>
                    <select id="asignar_a" name="asignar_a">
                        <option value="">Sistema asignará automáticamente</option>
                        <option value="director_general">Director General</option>
                        <option value="coordinador_academico">Coordinador Académico</option>
                        <option value="admin_sistemas">Administrador de Sistemas</option>
                        <option value="rrhh">Recursos Humanos</option>
                        <option value="mantenimiento">Mantenimiento</option>
                    </select>
                </div>

                <div class="form-group">
                    <div class="checkbox-group">
                        <label class="checkbox-label">
                            <input type="checkbox" name="seguimiento_urgente" value="1">
                            <span class="checkmark"></span>
                            Requiere seguimiento urgente
                        </label>
                        
                        <label class="checkbox-label">
                            <input type="checkbox" name="notificar_padres" value="1">
                            <span class="checkmark"></span>
                            Notificar a padres de familia (si aplica)
                        </label>
                        
                        <label class="checkbox-label">
                            <input type="checkbox" name="confidencial" value="1">
                            <span class="checkmark"></span>
                            Información confidencial
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group full-width">
                    <label for="fecha_limite">Fecha Límite Esperada (Opcional)</label>
                    <input type="date" id="fecha_limite" name="fecha_limite" 
                           min="<?= date('Y-m-d') ?>">
                    <small class="form-help">Si tienes una fecha específica en la que necesitas la resolución.</small>
                </div>
            </div>
        </div>

        <!-- Botones de Acción -->
        <div class="form-actions">
            <button type="button" class="btn btn-secondary" onclick="cancelarCreacion()">
                <i class="fas fa-times"></i> Cancelar
            </button>
            <button type="button" class="btn btn-outline-primary" onclick="guardarBorrador()">
                <i class="fas fa-save"></i> Guardar Borrador
            </button>
            <button type="button" class="btn btn-warning" onclick="previsualizarTicket()">
                <i class="fas fa-eye"></i> Previsualizar
            </button>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-paper-plane"></i> Crear Ticket
            </button>
        </div>
    </form>
</div>

<!-- ===================== ESTILOS ESPECÍFICOS ===================== -->
<style>
    .crear-ticket {
        animation: fadeIn 0.5s ease;
    }

    .crear-header {
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

    .header-actions {
        display: flex;
        gap: 1rem;
    }

    .ticket-form {
        max-width: 1000px;
        margin: 0 auto;
    }

    .form-section {
        background: var(--white);
        padding: 2rem;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        margin-bottom: 2rem;
    }

    .form-section h3 {
        color: var(--primary-color);
        margin-bottom: 2rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid var(--primary-light);
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 2rem;
        margin-bottom: 1.5rem;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .form-group.full-width {
        grid-column: 1 / -1;
    }

    .form-group label {
        font-weight: 600;
        color: var(--gray-700);
        font-size: 0.9rem;
    }

    .form-group input,
    .form-group textarea,
    .form-group select {
        padding: 0.75rem;
        border: 2px solid var(--gray-300);
        border-radius: var(--border-radius);
        font-size: 1rem;
        transition: border-color 0.3s ease;
    }

    .form-group input:focus,
    .form-group textarea:focus,
    .form-group select:focus {
        outline: none;
        border-color: var(--primary-color);
    }

    .form-help {
        color: var(--gray-500);
        font-size: 0.8rem;
        font-style: italic;
    }

    .category-selection {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1rem;
        grid-column: 1 / -1;
    }

    .category-option {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1.5rem;
        border: 2px solid var(--gray-300);
        border-radius: var(--border-radius);
        cursor: pointer;
        transition: var(--transition);
    }

    .category-option:hover {
        border-color: var(--primary-color);
        background: var(--primary-light);
    }

    .category-option.selected {
        border-color: var(--primary-color);
        background: var(--primary-light);
        box-shadow: 0 0 0 3px rgba(142, 68, 173, 0.1);
    }

    .category-icon {
        font-size: 2rem;
        color: var(--primary-color);
        width: 50px;
        text-align: center;
    }

    .category-info h4 {
        margin: 0 0 0.25rem 0;
        color: var(--dark);
        font-size: 1rem;
    }

    .category-info p {
        margin: 0;
        color: var(--gray-600);
        font-size: 0.8rem;
    }

    .priority-selection {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .priority-option {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem;
        border: 2px solid var(--gray-300);
        border-radius: var(--border-radius);
        cursor: pointer;
        transition: var(--transition);
    }

    .priority-option:hover {
        border-color: var(--primary-color);
        background: var(--gray-50);
    }

    .priority-option input[type="radio"]:checked + .priority-content {
        color: var(--primary-color);
    }

    .priority-option input[type="radio"]:checked {
        accent-color: var(--primary-color);
    }

    .priority-content {
        flex: 1;
    }

    .priority-badge {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        border-radius: 12px;
        font-size: 0.8rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .badge-success {
        background: var(--success-light);
        color: var(--success-color);
    }

    .badge-warning {
        background: var(--warning-light);
        color: var(--warning-color);
    }

    .badge-danger {
        background: var(--danger-light);
        color: var(--danger-color);
    }

    .priority-content p {
        margin: 0;
        color: var(--gray-600);
        font-size: 0.8rem;
    }

    .file-upload-area {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 3rem;
        border: 2px dashed var(--gray-300);
        border-radius: var(--border-radius);
        cursor: pointer;
        transition: var(--transition);
        text-align: center;
    }

    .file-upload-area:hover {
        border-color: var(--primary-color);
        background: var(--primary-light);
    }

    .upload-icon {
        font-size: 3rem;
        color: var(--primary-color);
        margin-bottom: 1rem;
    }

    .upload-text p {
        margin: 0 0 0.5rem 0;
        color: var(--dark);
    }

    .upload-text small {
        color: var(--gray-600);
    }

    .files-list {
        margin-top: 1rem;
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .file-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem;
        background: var(--gray-50);
        border-radius: var(--border-radius);
        border: 1px solid var(--gray-300);
    }

    .file-info {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .file-remove {
        background: var(--danger-color);
        color: var(--white);
        border: none;
        padding: 0.25rem 0.5rem;
        border-radius: var(--border-radius);
        cursor: pointer;
        font-size: 0.8rem;
    }

    .checkbox-group {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .checkbox-label {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        cursor: pointer;
        font-size: 0.9rem;
        color: var(--gray-700);
    }

    .checkbox-label input[type="checkbox"] {
        width: 20px;
        height: 20px;
        accent-color: var(--primary-color);
    }

    .form-actions {
        display: flex;
        justify-content: center;
        gap: 1rem;
        padding: 2rem;
        background: var(--white);
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
    }

    @media (max-width: 768px) {
        .crear-header {
            flex-direction: column;
            gap: 1rem;
        }

        .header-actions {
            width: 100%;
            justify-content: center;
        }

        .form-row {
            grid-template-columns: 1fr;
            gap: 1rem;
        }

        .category-selection {
            grid-template-columns: 1fr;
        }

        .form-actions {
            flex-direction: column;
        }
    }
</style>

<!-- ===================== SCRIPTS ESPECÍFICOS ===================== -->
<script>
    // Variables globales
    let selectedFiles = [];

    // Función para seleccionar categoría
    function selectCategory(category) {
        // Remover selección anterior
        document.querySelectorAll('.category-option').forEach(option => {
            option.classList.remove('selected');
        });
        
        // Seleccionar nueva categoría
        const selectedOption = document.querySelector(`[onclick="selectCategory('${category}')"]`);
        selectedOption.classList.add('selected');
        
        // Marcar radio button
        selectedOption.querySelector('input[type="radio"]').checked = true;
    }

    // Función para seleccionar prioridad
    function selectPriority(priority) {
        const option = document.querySelector(`input[name="prioridad"][value="${priority}"]`);
        option.checked = true;
    }

    // Manejo de archivos
    document.getElementById('archivos').addEventListener('change', function(e) {
        const files = Array.from(e.target.files);
        files.forEach(file => {
            if (validateFile(file)) {
                selectedFiles.push(file);
                addFileToList(file);
            }
        });
    });

    function validateFile(file) {
        const allowedTypes = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'image/jpeg', 'image/png', 'video/mp4'];
        const maxSize = 10 * 1024 * 1024; // 10MB

        if (!allowedTypes.includes(file.type)) {
            showNotification('Tipo de archivo no permitido: ' + file.name, 'error');
            return false;
        }

        if (file.size > maxSize) {
            showNotification('Archivo muy grande (máx. 10MB): ' + file.name, 'error');
            return false;
        }

        return true;
    }

    function addFileToList(file) {
        const filesList = document.getElementById('files-list');
        const fileItem = document.createElement('div');
        fileItem.className = 'file-item';
        fileItem.innerHTML = `
            <div class="file-info">
                <i class="fas fa-file"></i>
                <span>${file.name}</span>
                <small>(${formatFileSize(file.size)})</small>
            </div>
            <button type="button" class="file-remove" onclick="removeFile('${file.name}')">
                <i class="fas fa-times"></i>
            </button>
        `;
        filesList.appendChild(fileItem);
    }

    function removeFile(fileName) {
        selectedFiles = selectedFiles.filter(file => file.name !== fileName);
        
        // Remover del DOM
        const fileItems = document.querySelectorAll('.file-item');
        fileItems.forEach(item => {
            if (item.textContent.includes(fileName)) {
                item.remove();
            }
        });
    }

    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    // Funciones de acción
    function cancelarCreacion() {
        if (confirm('¿Estás seguro de que quieres cancelar? Se perderán todos los datos ingresados.')) {
            window.location.href = '?section=dashboard_tickets';
        }
    }

    function guardarBorrador() {
        showNotification('Borrador guardado correctamente', 'success');
        // Aquí iría la lógica para guardar el borrador
    }

    function previsualizarTicket() {
        const formData = new FormData(document.getElementById('form-ticket'));
        const preview = {
            titulo: formData.get('titulo'),
            categoria: formData.get('categoria'),
            prioridad: formData.get('prioridad'),
            plantel: formData.get('plantel'),
            descripcion: formData.get('descripcion')
        };

        let previewText = `PREVISUALIZACIÓN DEL TICKET\n\n`;
        previewText += `Título: ${preview.titulo || 'Sin título'}\n`;
        previewText += `Categoría: ${preview.categoria || 'Sin categoría'}\n`;
        previewText += `Prioridad: ${preview.prioridad || 'Sin prioridad'}\n`;
        previewText += `Plantel: ${preview.plantel || 'Sin plantel'}\n`;
        previewText += `Descripción: ${preview.descripcion || 'Sin descripción'}\n`;
        previewText += `Archivos adjuntos: ${selectedFiles.length} archivo(s)`;

        alert(previewText);
    }

    // Validación del formulario
    document.getElementById('form-ticket').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        
        // Validaciones básicas
        if (!formData.get('titulo')) {
            showNotification('El título es obligatorio', 'error');
            return;
        }
        
        if (!formData.get('categoria')) {
            showNotification('Debes seleccionar una categoría', 'error');
            return;
        }
        
        if (!formData.get('descripcion')) {
            showNotification('La descripción es obligatoria', 'error');
            return;
        }

        // Simular envío
        showNotification('Creando ticket...', 'info');
        
        setTimeout(() => {
            const ticketId = 'TK-' + new Date().getFullYear() + '-' + String(Math.floor(Math.random() * 10000)).padStart(4, '0');
            showNotification(`Ticket ${ticketId} creado exitosamente`, 'success');
            
            setTimeout(() => {
                window.location.href = `?section=ver_ticket&id=${ticketId}`;
            }, 2000);
        }, 2000);
    });

    // Inicialización
    document.addEventListener('DOMContentLoaded', function() {
        // Si hay tipo preseleccionado, activarlo
        const tipoPreseleccionado = '<?= $tipo_preseleccionado ?>';
        if (tipoPreseleccionado) {
            selectCategory(tipoPreseleccionado);
        }

        // Configurar fecha mínima
        const fechaLimite = document.getElementById('fecha_limite');
        fechaLimite.min = new Date().toISOString().split('T')[0];

        // Auto-save cada 30 segundos
        setInterval(function() {
            const titulo = document.getElementById('titulo').value;
            if (titulo.length > 10) {
                console.log('Auto-guardando borrador...');
                // Aquí iría la lógica de auto-guardado
            }
        }, 30000);
    });
</script>
