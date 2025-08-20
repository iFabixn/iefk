<!-- ===================== ADMISIONES ELIMINADAS ===================== -->
<div class="content-header">
    <h1 class="content-title">
        <i class="fas fa-trash-alt"></i>
        Admisiones Eliminadas
    </h1>
    <p class="content-description">
        Historial de admisiones que no completaron el proceso, fueron canceladas o dadas de baja. Puedes restaurar o eliminar permanentemente estos registros.
    </p>
</div>

<!-- Estadísticas rápidas -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-number">18</div>
        <div class="stat-label">Total eliminadas</div>
    </div>
    <div class="stat-card">
        <div class="stat-number">7</div>
        <div class="stat-label">Documentación incompleta</div>
    </div>
    <div class="stat-card">
        <div class="stat-number">6</div>
        <div class="stat-label">Canceladas por padre</div>
    </div>
    <div class="stat-card">
        <div class="stat-number">5</div>
        <div class="stat-label">No confirmadas</div>
    </div>
</div>

<div class="content-body">
    <!-- Filtros y búsqueda -->
    <div style="background: var(--gray-100); padding: 1.5rem; border-radius: 8px; margin-bottom: 2rem;">
        <div class="form-grid">
            <div class="form-group">
                <label class="form-label" for="buscar_eliminada">
                    <i class="fas fa-search"></i> Buscar por nombre o email
                </label>
                <input type="text" id="buscar_eliminada" class="form-input" 
                       placeholder="Buscar..." onkeyup="filtrarEliminadas()">
            </div>
            
            <div class="form-group">
                <label class="form-label" for="filtro_motivo">
                    <i class="fas fa-filter"></i> Motivo de eliminación
                </label>
                <select id="filtro_motivo" class="form-input" onchange="filtrarEliminadas()">
                    <option value="">Todos los motivos</option>
                    <option value="documentacion_incompleta">Documentación incompleta</option>
                    <option value="cancelado_padre">Cancelado por padre</option>
                    <option value="no_confirmado">No confirmado</option>
                    <option value="falta_pago">Falta de pago</option>
                    <option value="cupo_lleno">Cupo lleno</option>
                    <option value="otro">Otro motivo</option>
                </select>
            </div>
            
            <div class="form-group">
                <label class="form-label" for="filtro_fecha_eliminacion">
                    <i class="fas fa-calendar"></i> Fecha de eliminación
                </label>
                <select id="filtro_fecha_eliminacion" class="form-input" onchange="filtrarEliminadas()">
                    <option value="">Todas las fechas</option>
                    <option value="hoy">Hoy</option>
                    <option value="semana">Esta semana</option>
                    <option value="mes">Este mes</option>
                    <option value="trimestre">Último trimestre</option>
                </select>
            </div>
            
            <div class="form-group" style="display: flex; align-items: end; gap: 0.5rem;">
                <button class="btn btn-primary" onclick="exportarEliminadas()">
                    <i class="fas fa-download"></i>
                    Exportar
                </button>
                <button class="btn btn-danger" onclick="limpiarHistorial()">
                    <i class="fas fa-broom"></i>
                    Limpiar Historial
                </button>
            </div>
        </div>
    </div>

    <!-- Tabla de admisiones eliminadas -->
    <div class="table-container">
        <table class="table" id="tabla_eliminadas">
            <thead>
                <tr>
                    <th><i class="fas fa-user"></i> Tutor</th>
                    <th><i class="fas fa-child"></i> Menores</th>
                    <th><i class="fas fa-calendar"></i> Fecha Original</th>
                    <th><i class="fas fa-calendar-times"></i> Fecha Eliminación</th>
                    <th><i class="fas fa-exclamation-circle"></i> Motivo</th>
                    <th><i class="fas fa-user-cog"></i> Eliminado por</th>
                    <th><i class="fas fa-tools"></i> Acciones</th>
                </tr>
            </thead>
            <tbody>
                <!-- Ejemplos de datos -->
                <tr data-motivo="documentacion_incompleta" data-fecha="2025-08-10">
                    <td>
                        <strong>Luis Alberto Mendoza</strong><br>
                        <small style="color: var(--gray-600);">luis.mendoza@email.com</small><br>
                        <small style="color: var(--gray-600);">Padre</small>
                    </td>
                    <td>
                        <span style="background: var(--danger-color); color: white; padding: 0.25rem 0.5rem; border-radius: 4px; font-size: 0.8rem;">
                            Gabriel (2 años) - Guardería
                        </span>
                    </td>
                    <td>05/08/2025<br><small>Registro inicial</small></td>
                    <td>10/08/2025<br><small>15:30 PM</small></td>
                    <td>
                        <span class="badge" style="background: var(--warning-color); color: var(--dark-color);">
                            Documentación incompleta
                        </span><br>
                        <small style="color: var(--gray-600);">No subió acta de nacimiento</small>
                    </td>
                    <td>
                        <strong>Admin Sistema</strong><br>
                        <small style="color: var(--gray-600);">Automático (15 días)</small>
                    </td>
                    <td>
                        <button class="btn btn-success" onclick="restaurarAdmision(1)" style="padding: 0.25rem 0.5rem; font-size: 0.8rem;">
                            <i class="fas fa-undo"></i>
                        </button>
                        <button class="btn btn-secondary" onclick="verHistorial(1)" style="padding: 0.25rem 0.5rem; font-size: 0.8rem;">
                            <i class="fas fa-history"></i>
                        </button>
                        <button class="btn btn-danger" onclick="eliminarPermanente(1)" style="padding: 0.25rem 0.5rem; font-size: 0.8rem;">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
                
                <tr data-motivo="cancelado_padre" data-fecha="2025-08-08">
                    <td>
                        <strong>Carmen Rosa Jiménez</strong><br>
                        <small style="color: var(--gray-600);">carmen.jimenez@email.com</small><br>
                        <small style="color: var(--gray-600);">Madre</small>
                    </td>
                    <td>
                        <span style="background: var(--danger-color); color: white; padding: 0.25rem 0.5rem; border-radius: 4px; font-size: 0.8rem;">
                            Valentina (4 años) - Preescolar
                        </span><br>
                        <span style="background: var(--danger-color); color: white; padding: 0.25rem 0.5rem; border-radius: 4px; font-size: 0.8rem; margin-top: 2px; display: inline-block;">
                            Santiago (7 años) - Primaria
                        </span>
                    </td>
                    <td>01/08/2025<br><small>Registro inicial</small></td>
                    <td>08/08/2025<br><small>10:45 AM</small></td>
                    <td>
                        <span class="badge badge-rejected">
                            Cancelado por padre
                        </span><br>
                        <small style="color: var(--gray-600);">Cambio de ciudad</small>
                    </td>
                    <td>
                        <strong>María González</strong><br>
                        <small style="color: var(--gray-600);">Ejecutiva admisiones</small>
                    </td>
                    <td>
                        <button class="btn btn-success" onclick="restaurarAdmision(2)" style="padding: 0.25rem 0.5rem; font-size: 0.8rem;">
                            <i class="fas fa-undo"></i>
                        </button>
                        <button class="btn btn-secondary" onclick="verHistorial(2)" style="padding: 0.25rem 0.5rem; font-size: 0.8rem;">
                            <i class="fas fa-history"></i>
                        </button>
                        <button class="btn btn-danger" onclick="eliminarPermanente(2)" style="padding: 0.25rem 0.5rem; font-size: 0.8rem;">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
                
                <tr data-motivo="no_confirmado" data-fecha="2025-08-05">
                    <td>
                        <strong>Pedro Antonio Vásquez</strong><br>
                        <small style="color: var(--gray-600);">pedro.vasquez@email.com</small><br>
                        <small style="color: var(--gray-600);">Padre</small>
                    </td>
                    <td>
                        <span style="background: var(--danger-color); color: white; padding: 0.25rem 0.5rem; border-radius: 4px; font-size: 0.8rem;">
                            Emilia (6 meses) - Guardería
                        </span>
                    </td>
                    <td>20/07/2025<br><small>Registro inicial</small></td>
                    <td>05/08/2025<br><small>09:15 AM</small></td>
                    <td>
                        <span class="badge" style="background: var(--gray-500); color: white;">
                            No confirmado
                        </span><br>
                        <small style="color: var(--gray-600);">Sin respuesta a invitación</small>
                    </td>
                    <td>
                        <strong>Admin Sistema</strong><br>
                        <small style="color: var(--gray-600);">Automático (15 días)</small>
                    </td>
                    <td>
                        <button class="btn btn-success" onclick="restaurarAdmision(3)" style="padding: 0.25rem 0.5rem; font-size: 0.8rem;">
                            <i class="fas fa-undo"></i>
                        </button>
                        <button class="btn btn-secondary" onclick="verHistorial(3)" style="padding: 0.25rem 0.5rem; font-size: 0.8rem;">
                            <i class="fas fa-history"></i>
                        </button>
                        <button class="btn btn-danger" onclick="eliminarPermanente(3)" style="padding: 0.25rem 0.5rem; font-size: 0.8rem;">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
                
                <tr data-motivo="cupo_lleno" data-fecha="2025-08-03">
                    <td>
                        <strong>Sofía Martínez Torres</strong><br>
                        <small style="color: var(--gray-600);">sofia.martinez@email.com</small><br>
                        <small style="color: var(--gray-600);">Madre</small>
                    </td>
                    <td>
                        <span style="background: var(--danger-color); color: white; padding: 0.25rem 0.5rem; border-radius: 4px; font-size: 0.8rem;">
                            Alejandro (9 años) - Primaria
                        </span>
                    </td>
                    <td>25/07/2025<br><small>Registro inicial</small></td>
                    <td>03/08/2025<br><small>16:20 PM</small></td>
                    <td>
                        <span class="badge" style="background: var(--info-color); color: white;">
                            Cupo lleno
                        </span><br>
                        <small style="color: var(--gray-600);">Sin cupo en plantel solicitado</small>
                    </td>
                    <td>
                        <strong>Carlos Pérez</strong><br>
                        <small style="color: var(--gray-600);">Director académico</small>
                    </td>
                    <td>
                        <button class="btn btn-success" onclick="restaurarAdmision(4)" style="padding: 0.25rem 0.5rem; font-size: 0.8rem;">
                            <i class="fas fa-undo"></i>
                        </button>
                        <button class="btn btn-secondary" onclick="verHistorial(4)" style="padding: 0.25rem 0.5rem; font-size: 0.8rem;">
                            <i class="fas fa-history"></i>
                        </button>
                        <button class="btn btn-danger" onclick="eliminarPermanente(4)" style="padding: 0.25rem 0.5rem; font-size: 0.8rem;">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Paginación -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 2rem; padding: 1rem; background: var(--gray-100); border-radius: 8px;">
        <div style="color: var(--gray-600);">
            Mostrando 1-4 de 18 registros eliminados
        </div>
        <div style="display: flex; gap: 0.5rem;">
            <button class="btn btn-secondary" style="padding: 0.5rem 0.75rem;">
                <i class="fas fa-chevron-left"></i>
            </button>
            <button class="btn btn-primary" style="padding: 0.5rem 0.75rem;">1</button>
            <button class="btn btn-secondary" style="padding: 0.5rem 0.75rem;">2</button>
            <button class="btn btn-secondary" style="padding: 0.5rem 0.75rem;">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>
    </div>
</div>

<!-- Modal para ver historial -->
<div id="modalHistorial" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;">
    <div style="background: white; border-radius: 12px; padding: 2rem; max-width: 700px; width: 90%; max-height: 80vh; overflow-y: auto;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
            <h3 style="color: var(--primary-color); margin: 0;">Historial de Admisión</h3>
            <button onclick="cerrarModalHistorial()" style="background: none; border: none; font-size: 1.5rem; cursor: pointer;">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div id="contenidoModalHistorial">
            <!-- Contenido dinámico -->
        </div>
    </div>
</div>

<script>
function filtrarEliminadas() {
    const busqueda = document.getElementById('buscar_eliminada').value.toLowerCase();
    const filtroMotivo = document.getElementById('filtro_motivo').value;
    const filtroFecha = document.getElementById('filtro_fecha_eliminacion').value;
    const filas = document.querySelectorAll('#tabla_eliminadas tbody tr');

    filas.forEach(fila => {
        const nombre = fila.querySelector('td:first-child strong').textContent.toLowerCase();
        const email = fila.querySelector('td:first-child small').textContent.toLowerCase();
        const motivo = fila.getAttribute('data-motivo');
        const fecha = fila.getAttribute('data-fecha');
        
        let mostrar = true;

        // Filtro de búsqueda
        if (busqueda && !nombre.includes(busqueda) && !email.includes(busqueda)) {
            mostrar = false;
        }

        // Filtro de motivo
        if (filtroMotivo && motivo !== filtroMotivo) {
            mostrar = false;
        }

        // Filtro de fecha (simplificado para demo)
        if (filtroFecha === 'hoy' && fecha !== '2025-08-13') {
            mostrar = false;
        }

        fila.style.display = mostrar ? '' : 'none';
    });
}

function verHistorial(id) {
    const contenido = `
        <div style="display: grid; gap: 1.5rem;">
            <div style="background: var(--gray-100); padding: 1rem; border-radius: 8px;">
                <strong style="color: var(--primary-color);">Información del Tutor:</strong><br>
                <strong>Nombre:</strong> Luis Alberto Mendoza<br>
                <strong>Email:</strong> luis.mendoza@email.com<br>
                <strong>Teléfono:</strong> 33 9876 5432<br>
                <strong>Parentesco:</strong> Padre
            </div>
            
            <div style="background: var(--gray-100); padding: 1rem; border-radius: 8px;">
                <strong style="color: var(--primary-color);">Menor Inscrito:</strong><br>
                <strong>Nombre:</strong> Gabriel Mendoza<br>
                <strong>Edad:</strong> 2 años<br>
                <strong>Servicio:</strong> Guardería<br>
                <strong>Plantel:</strong> Plantel Río Nilo
            </div>
            
            <div style="background: var(--gray-100); padding: 1rem; border-radius: 8px;">
                <strong style="color: var(--primary-color);">Cronología del Proceso:</strong><br>
                <div style="margin-top: 1rem;">
                    <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 0.5rem;">
                        <span class="badge badge-sent">05/08</span>
                        <span>Invitación enviada</span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 0.5rem;">
                        <span class="badge badge-approved">06/08</span>
                        <span>Tutor registró su cuenta</span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 0.5rem;">
                        <span class="badge badge-pending">07/08</span>
                        <span>Documentación parcial subida</span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 0.5rem;">
                        <span class="badge badge-rejected">10/08</span>
                        <span>Eliminado por documentación incompleta</span>
                    </div>
                </div>
            </div>
            
            <div style="background: var(--danger-color); color: white; padding: 1rem; border-radius: 8px;">
                <strong>Motivo de Eliminación:</strong><br>
                Documentación incompleta - No subió acta de nacimiento<br>
                <small>Eliminado automáticamente después de 15 días sin completar documentos</small>
            </div>
        </div>
    `;
    
    document.getElementById('contenidoModalHistorial').innerHTML = contenido;
    document.getElementById('modalHistorial').style.display = 'flex';
}

function cerrarModalHistorial() {
    document.getElementById('modalHistorial').style.display = 'none';
}

function restaurarAdmision(id) {
    if (confirm('¿Deseas restaurar esta admisión? Se generará una nueva invitación.')) {
        alert('Admisión restaurada correctamente. Se ha enviado una nueva invitación.');
        location.reload();
    }
}

function eliminarPermanente(id) {
    if (confirmDelete('eliminar PERMANENTEMENTE este registro')) {
        alert('Registro eliminado permanentemente');
        location.reload();
    }
}

function limpiarHistorial() {
    if (confirm('¿Estás seguro de que deseas limpiar todo el historial? Esta acción eliminará PERMANENTEMENTE todos los registros eliminados.')) {
        if (confirm('ÚLTIMA CONFIRMACIÓN: Esta acción NO se puede deshacer. ¿Continuar?')) {
            alert('Historial limpiado correctamente');
            location.reload();
        }
    }
}

function exportarEliminadas() {
    alert('Exportando historial de admisiones eliminadas...');
}

// Cerrar modal al hacer clic fuera
document.getElementById('modalHistorial').addEventListener('click', function(e) {
    if (e.target === this) {
        cerrarModalHistorial();
    }
});
</script>
