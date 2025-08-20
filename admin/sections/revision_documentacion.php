<!-- ===================== REVISIÓN DE DOCUMENTACIÓN ===================== -->
<div class="content-header">
    <h1 class="content-title">
        <i class="fas fa-search"></i>
        Revisión de Documentación
    </h1>
    <p class="content-description">
        Revisa y aprueba la documentación enviada por los tutores. Aquí puedes validar documentos, solicitar correcciones o aprobar admisiones completamente.
    </p>
</div>

<!-- Estadísticas rápidas -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-number">24</div>
        <div class="stat-label">Pendientes de revisión</div>
    </div>
    <div class="stat-card">
        <div class="stat-number">8</div>
        <div class="stat-label">Requieren correcciones</div>
    </div>
    <div class="stat-card">
        <div class="stat-number">15</div>
        <div class="stat-label">Aprobados hoy</div>
    </div>
    <div class="stat-card">
        <div class="stat-number">92%</div>
        <div class="stat-label">Tasa de aprobación</div>
    </div>
</div>

<div class="content-body">
    <!-- Filtros y búsqueda -->
    <div style="background: var(--gray-100); padding: 1.5rem; border-radius: 8px; margin-bottom: 2rem;">
        <div class="form-grid">
            <div class="form-group">
                <label class="form-label" for="buscar_documentacion">
                    <i class="fas fa-search"></i> Buscar por tutor o menor
                </label>
                <input type="text" id="buscar_documentacion" class="form-input" 
                       placeholder="Nombre del tutor o menor..." onkeyup="filtrarDocumentacion()">
            </div>
            
            <div class="form-group">
                <label class="form-label" for="filtro_estado_doc">
                    <i class="fas fa-filter"></i> Estado de revisión
                </label>
                <select id="filtro_estado_doc" class="form-input" onchange="filtrarDocumentacion()">
                    <option value="">Todos los estados</option>
                    <option value="pendiente">Pendiente de revisión</option>
                    <option value="en_revision">En revisión</option>
                    <option value="correccion">Requiere corrección</option>
                    <option value="aprobado">Aprobado</option>
                    <option value="rechazado">Rechazado</option>
                </select>
            </div>
            
            <div class="form-group">
                <label class="form-label" for="filtro_prioridad">
                    <i class="fas fa-exclamation-triangle"></i> Prioridad
                </label>
                <select id="filtro_prioridad" class="form-input" onchange="filtrarDocumentacion()">
                    <option value="">Todas las prioridades</option>
                    <option value="alta">Alta prioridad</option>
                    <option value="media">Prioridad media</option>
                    <option value="baja">Prioridad baja</option>
                </select>
            </div>
            
            <div class="form-group" style="display: flex; align-items: end; gap: 0.5rem;">
                <button class="btn btn-primary" onclick="asignarRevisor()">
                    <i class="fas fa-user-plus"></i>
                    Asignar Revisor
                </button>
                <button class="btn btn-secondary" onclick="exportarReporte()">
                    <i class="fas fa-file-export"></i>
                    Reporte
                </button>
            </div>
        </div>
    </div>

    <!-- Tabla de documentación -->
    <div class="table-container">
        <table class="table" id="tabla_documentacion">
            <thead>
                <tr>
                    <th><i class="fas fa-user"></i> Tutor / Menor</th>
                    <th><i class="fas fa-file-alt"></i> Documentos</th>
                    <th><i class="fas fa-calendar"></i> Fecha Subida</th>
                    <th><i class="fas fa-user-tie"></i> Revisor</th>
                    <th><i class="fas fa-traffic-light"></i> Estado</th>
                    <th><i class="fas fa-cogs"></i> Acciones</th>
                </tr>
            </thead>
            <tbody>
                <!-- Ejemplos de datos -->
                <tr data-estado="pendiente" data-prioridad="alta">
                    <td>
                        <div style="display: flex; align-items: center; gap: 0.75rem;">
                            <div style="width: 40px; height: 40px; background: var(--warning-color); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold;">
                                <i class="fas fa-exclamation"></i>
                            </div>
                            <div>
                                <strong>Laura Martínez</strong><br>
                                <small style="color: var(--gray-600);">laura.martinez@email.com</small><br>
                                <small style="color: var(--primary-color);"><strong>Pablo Martínez (4 años)</strong></small>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div style="display: flex; flex-direction: column; gap: 0.25rem;">
                            <span style="background: var(--success-color); color: white; padding: 0.2rem 0.5rem; border-radius: 4px; font-size: 0.7rem;">
                                ✓ Acta de nacimiento
                            </span>
                            <span style="background: var(--success-color); color: white; padding: 0.2rem 0.5rem; border-radius: 4px; font-size: 0.7rem;">
                                ✓ CURP
                            </span>
                            <span style="background: var(--danger-color); color: white; padding: 0.2rem 0.5rem; border-radius: 4px; font-size: 0.7rem;">
                                ✗ Cartilla vacunación
                            </span>
                            <span style="background: var(--warning-color); color: white; padding: 0.2rem 0.5rem; border-radius: 4px; font-size: 0.7rem;">
                                ⚠ Certificado médico
                            </span>
                        </div>
                    </td>
                    <td>12/08/2025<br><small>Hace 1 día</small></td>
                    <td>
                        <span style="color: var(--gray-500);">Sin asignar</span><br>
                        <button class="btn btn-primary" onclick="asignarme(1)" style="padding: 0.25rem 0.5rem; font-size: 0.7rem; margin-top: 0.25rem;">
                            Tomar caso
                        </button>
                    </td>
                    <td>
                        <span class="badge badge-pending">Pendiente</span><br>
                        <small style="color: var(--danger-color); font-weight: bold;">ALTA PRIORIDAD</small>
                    </td>
                    <td>
                        <div style="display: flex; gap: 0.25rem; flex-wrap: wrap;">
                            <button class="btn btn-secondary" onclick="revisarDocumentos(1)" style="padding: 0.25rem 0.5rem; font-size: 0.8rem;">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-primary" onclick="iniciarRevision(1)" style="padding: 0.25rem 0.5rem; font-size: 0.8rem;">
                                <i class="fas fa-play"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                
                <tr data-estado="en_revision" data-prioridad="media">
                    <td>
                        <div style="display: flex; align-items: center; gap: 0.75rem;">
                            <div style="width: 40px; height: 40px; background: var(--primary-color); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold;">
                                <i class="fas fa-search"></i>
                            </div>
                            <div>
                                <strong>Roberto Hernández</strong><br>
                                <small style="color: var(--gray-600);">roberto.hernandez@email.com</small><br>
                                <small style="color: var(--primary-color);"><strong>Isabella Hernández (4 años)</strong></small>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div style="display: flex; flex-direction: column; gap: 0.25rem;">
                            <span style="background: var(--success-color); color: white; padding: 0.2rem 0.5rem; border-radius: 4px; font-size: 0.7rem;">
                                ✓ Acta de nacimiento
                            </span>
                            <span style="background: var(--success-color); color: white; padding: 0.2rem 0.5rem; border-radius: 4px; font-size: 0.7rem;">
                                ✓ CURP
                            </span>
                            <span style="background: var(--success-color); color: white; padding: 0.2rem 0.5rem; border-radius: 4px; font-size: 0.7rem;">
                                ✓ Cartilla vacunación
                            </span>
                            <span style="background: var(--success-color); color: white; padding: 0.2rem 0.5rem; border-radius: 4px; font-size: 0.7rem;">
                                ✓ Certificado médico
                            </span>
                        </div>
                    </td>
                    <td>10/08/2025<br><small>Hace 3 días</small></td>
                    <td>
                        <strong>Dra. Carmen López</strong><br>
                        <small style="color: var(--success-color);">Revisando desde hace 2 horas</small>
                    </td>
                    <td>
                        <span class="badge" style="background: var(--primary-color); color: white;">En revisión</span><br>
                        <small style="color: var(--warning-color);">PRIORIDAD MEDIA</small>
                    </td>
                    <td>
                        <div style="display: flex; gap: 0.25rem; flex-wrap: wrap;">
                            <button class="btn btn-secondary" onclick="revisarDocumentos(2)" style="padding: 0.25rem 0.5rem; font-size: 0.8rem;">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-success" onclick="aprobarExpediente(2)" style="padding: 0.25rem 0.5rem; font-size: 0.8rem;">
                                <i class="fas fa-check"></i>
                            </button>
                            <button class="btn btn-warning" onclick="solicitarCorreccion(2)" style="padding: 0.25rem 0.5rem; font-size: 0.8rem;">
                                <i class="fas fa-edit"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                
                <tr data-estado="correccion" data-prioridad="alta">
                    <td>
                        <div style="display: flex; align-items: center; gap: 0.75rem;">
                            <div style="width: 40px; height: 40px; background: var(--warning-color); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold;">
                                <i class="fas fa-edit"></i>
                            </div>
                            <div>
                                <strong>Ana García Ruiz</strong><br>
                                <small style="color: var(--gray-600);">ana.garcia@email.com</small><br>
                                <small style="color: var(--primary-color);"><strong>Sebastián García (2 años)</strong></small>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div style="display: flex; flex-direction: column; gap: 0.25rem;">
                            <span style="background: var(--success-color); color: white; padding: 0.2rem 0.5rem; border-radius: 4px; font-size: 0.7rem;">
                                ✓ Acta de nacimiento
                            </span>
                            <span style="background: var(--danger-color); color: white; padding: 0.2rem 0.5rem; border-radius: 4px; font-size: 0.7rem;">
                                ✗ CURP (ilegible)
                            </span>
                            <span style="background: var(--success-color); color: white; padding: 0.2rem 0.5rem; border-radius: 4px; font-size: 0.7rem;">
                                ✓ Cartilla vacunación
                            </span>
                            <span style="background: var(--danger-color); color: white; padding: 0.2rem 0.5rem; border-radius: 4px; font-size: 0.7rem;">
                                ✗ Cert. médico (vencido)
                            </span>
                        </div>
                    </td>
                    <td>08/08/2025<br><small>Hace 5 días</small></td>
                    <td>
                        <strong>Lic. María González</strong><br>
                        <small style="color: var(--warning-color);">Correcciones solicitadas hace 2 días</small>
                    </td>
                    <td>
                        <span class="badge badge-pending">Requiere corrección</span><br>
                        <small style="color: var(--danger-color); font-weight: bold;">ALTA PRIORIDAD</small>
                    </td>
                    <td>
                        <div style="display: flex; gap: 0.25rem; flex-wrap: wrap;">
                            <button class="btn btn-secondary" onclick="revisarDocumentos(3)" style="padding: 0.25rem 0.5rem; font-size: 0.8rem;">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-primary" onclick="enviarRecordatorio(3)" style="padding: 0.25rem 0.5rem; font-size: 0.8rem;">
                                <i class="fas fa-bell"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                
                <tr data-estado="aprobado" data-prioridad="baja">
                    <td>
                        <div style="display: flex; align-items: center; gap: 0.75rem;">
                            <div style="width: 40px; height: 40px; background: var(--success-color); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold;">
                                <i class="fas fa-check"></i>
                            </div>
                            <div>
                                <strong>Patricia Jiménez</strong><br>
                                <small style="color: var(--gray-600);">patricia.jimenez@email.com</small><br>
                                <small style="color: var(--primary-color);"><strong>Valeria Jiménez (5 años)</strong></small>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div style="display: flex; flex-direction: column; gap: 0.25rem;">
                            <span style="background: var(--success-color); color: white; padding: 0.2rem 0.5rem; border-radius: 4px; font-size: 0.7rem;">
                                ✓ Acta de nacimiento
                            </span>
                            <span style="background: var(--success-color); color: white; padding: 0.2rem 0.5rem; border-radius: 4px; font-size: 0.7rem;">
                                ✓ CURP
                            </span>
                            <span style="background: var(--success-color); color: white; padding: 0.2rem 0.5rem; border-radius: 4px; font-size: 0.7rem;">
                                ✓ Cartilla vacunación
                            </span>
                            <span style="background: var(--success-color); color: white; padding: 0.2rem 0.5rem; border-radius: 4px; font-size: 0.7rem;">
                                ✓ Certificado médico
                            </span>
                        </div>
                    </td>
                    <td>05/08/2025<br><small>Hace 8 días</small></td>
                    <td>
                        <strong>Dr. Luis Morales</strong><br>
                        <small style="color: var(--success-color);">Aprobado hace 1 día</small>
                    </td>
                    <td>
                        <span class="badge badge-approved">Aprobado</span><br>
                        <small style="color: var(--success-color);">EXPEDIENTE COMPLETO</small>
                    </td>
                    <td>
                        <div style="display: flex; gap: 0.25rem; flex-wrap: wrap;">
                            <button class="btn btn-secondary" onclick="revisarDocumentos(4)" style="padding: 0.25rem 0.5rem; font-size: 0.8rem;">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-success" onclick="generarConstancia(4)" style="padding: 0.25rem 0.5rem; font-size: 0.8rem;">
                                <i class="fas fa-certificate"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Paginación -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 2rem; padding: 1rem; background: var(--gray-100); border-radius: 8px;">
        <div style="color: var(--gray-600);">
            Mostrando 1-4 de 24 expedientes
        </div>
        <div style="display: flex; gap: 0.5rem;">
            <button class="btn btn-secondary" style="padding: 0.5rem 0.75rem;">
                <i class="fas fa-chevron-left"></i>
            </button>
            <button class="btn btn-primary" style="padding: 0.5rem 0.75rem;">1</button>
            <button class="btn btn-secondary" style="padding: 0.5rem 0.75rem;">2</button>
            <button class="btn btn-secondary" style="padding: 0.5rem 0.75rem;">3</button>
            <button class="btn btn-secondary" style="padding: 0.5rem 0.75rem;">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>
    </div>
</div>

<!-- Modal para revisar documentos -->
<div id="modalRevisarDocs" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;">
    <div style="background: white; border-radius: 12px; padding: 2rem; max-width: 900px; width: 90%; max-height: 80vh; overflow-y: auto;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
            <h3 style="color: var(--primary-color); margin: 0;">Revisión de Documentos</h3>
            <button onclick="cerrarModalRevision()" style="background: none; border: none; font-size: 1.5rem; cursor: pointer;">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div id="contenidoModalRevision">
            <!-- Contenido dinámico -->
        </div>
    </div>
</div>

<script>
function filtrarDocumentacion() {
    const busqueda = document.getElementById('buscar_documentacion').value.toLowerCase();
    const filtroEstado = document.getElementById('filtro_estado_doc').value;
    const filtroPrioridad = document.getElementById('filtro_prioridad').value;
    const filas = document.querySelectorAll('#tabla_documentacion tbody tr');

    filas.forEach(fila => {
        const nombre = fila.querySelector('td:first-child strong').textContent.toLowerCase();
        const email = fila.querySelector('td:first-child small').textContent.toLowerCase();
        const estado = fila.getAttribute('data-estado');
        const prioridad = fila.getAttribute('data-prioridad');
        
        let mostrar = true;

        if (busqueda && !nombre.includes(busqueda) && !email.includes(busqueda)) {
            mostrar = false;
        }
        if (filtroEstado && estado !== filtroEstado) {
            mostrar = false;
        }
        if (filtroPrioridad && prioridad !== filtroPrioridad) {
            mostrar = false;
        }

        fila.style.display = mostrar ? '' : 'none';
    });
}

function revisarDocumentos(id) {
    const contenido = `
        <div style="display: grid; gap: 1.5rem;">
            <div style="background: var(--primary-light); padding: 1rem; border-radius: 8px;">
                <strong style="color: var(--primary-color);">Expediente de: Laura Martínez - Pablo Martínez (4 años)</strong><br>
                <small>Preescolar • Plantel El Zapote • Registro: 12/08/2025</small>
            </div>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div style="background: var(--gray-100); padding: 1rem; border-radius: 8px;">
                    <strong style="color: var(--success-color);">✓ Acta de Nacimiento</strong><br>
                    <small>Subida: 12/08/2025 10:30 AM</small><br>
                    <button class="btn btn-secondary" style="margin-top: 0.5rem; font-size: 0.8rem;">
                        <i class="fas fa-download"></i> Descargar
                    </button>
                    <button class="btn btn-primary" style="margin-top: 0.5rem; font-size: 0.8rem;">
                        <i class="fas fa-eye"></i> Ver
                    </button>
                </div>
                
                <div style="background: var(--gray-100); padding: 1rem; border-radius: 8px;">
                    <strong style="color: var(--success-color);">✓ CURP</strong><br>
                    <small>Subida: 12/08/2025 10:32 AM</small><br>
                    <button class="btn btn-secondary" style="margin-top: 0.5rem; font-size: 0.8rem;">
                        <i class="fas fa-download"></i> Descargar
                    </button>
                    <button class="btn btn-primary" style="margin-top: 0.5rem; font-size: 0.8rem;">
                        <i class="fas fa-eye"></i> Ver
                    </button>
                </div>
                
                <div style="background: var(--danger-color); color: white; padding: 1rem; border-radius: 8px;">
                    <strong>✗ Cartilla de Vacunación</strong><br>
                    <small>FALTANTE - No subido</small><br>
                    <button class="btn" style="background: white; color: var(--danger-color); margin-top: 0.5rem; font-size: 0.8rem;">
                        <i class="fas fa-exclamation"></i> Solicitar
                    </button>
                </div>
                
                <div style="background: var(--warning-color); color: white; padding: 1rem; border-radius: 8px;">
                    <strong>⚠ Certificado Médico</strong><br>
                    <small>Subida: 12/08/2025 11:00 AM</small><br>
                    <small><strong>REQUIERE REVISIÓN</strong></small><br>
                    <button class="btn" style="background: white; color: var(--warning-color); margin-top: 0.5rem; font-size: 0.8rem;">
                        <i class="fas fa-eye"></i> Revisar
                    </button>
                </div>
            </div>
            
            <div style="background: var(--gray-100); padding: 1rem; border-radius: 8px;">
                <strong style="color: var(--primary-color);">Notas de Revisión:</strong><br>
                <textarea class="form-input" rows="3" placeholder="Agregar notas sobre la documentación..."></textarea>
            </div>
            
            <div style="display: flex; gap: 1rem; justify-content: flex-end;">
                <button class="btn btn-danger" onclick="rechazarExpediente(${id})">
                    <i class="fas fa-times"></i> Rechazar
                </button>
                <button class="btn btn-warning" onclick="solicitarCorreccion(${id})">
                    <i class="fas fa-edit"></i> Solicitar Corrección
                </button>
                <button class="btn btn-success" onclick="aprobarExpediente(${id})">
                    <i class="fas fa-check"></i> Aprobar
                </button>
            </div>
        </div>
    `;
    
    document.getElementById('contenidoModalRevision').innerHTML = contenido;
    document.getElementById('modalRevisarDocs').style.display = 'flex';
}

function asignarme(id) {
    if (confirm('¿Deseas asignarte este caso para revisión?')) {
        alert('Caso asignado correctamente');
        location.reload();
    }
}

function iniciarRevision(id) {
    if (confirm('¿Deseas iniciar la revisión de este expediente?')) {
        alert('Revisión iniciada');
        revisarDocumentos(id);
    }
}

function aprobarExpediente(id) {
    if (confirm('¿Estás seguro de que deseas APROBAR este expediente? Esta acción concretará la admisión.')) {
        alert('Expediente aprobado. Admisión concretada exitosamente.');
        cerrarModalRevision();
        location.reload();
    }
}

function solicitarCorreccion(id) {
    const motivo = prompt('Indica el motivo de la corrección necesaria:');
    if (motivo) {
        alert('Solicitud de corrección enviada al tutor.');
        cerrarModalRevision();
        location.reload();
    }
}

function rechazarExpediente(id) {
    const motivo = prompt('Indica el motivo del rechazo:');
    if (motivo && confirm('¿Estás seguro de que deseas RECHAZAR este expediente?')) {
        alert('Expediente rechazado. Se ha notificado al tutor.');
        cerrarModalRevision();
        location.reload();
    }
}

function enviarRecordatorio(id) {
    if (confirm('¿Deseas enviar un recordatorio al tutor sobre las correcciones pendientes?')) {
        alert('Recordatorio enviado correctamente');
    }
}

function generarConstancia(id) {
    alert('Generando constancia de admisión aprobada...');
}

function asignarRevisor() {
    alert('Función para asignar revisores en lote...');
}

function exportarReporte() {
    alert('Exportando reporte de revisión de documentación...');
}

function cerrarModalRevision() {
    document.getElementById('modalRevisarDocs').style.display = 'none';
}

// Cerrar modal al hacer clic fuera
document.getElementById('modalRevisarDocs').addEventListener('click', function(e) {
    if (e.target === this) {
        cerrarModalRevision();
    }
});
</script>
