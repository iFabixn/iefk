<!-- ===================== GESTIÓN DE TUTORES ===================== -->
<div class="content-header">
    <h1 class="content-title">
        <i class="fas fa-users"></i>
        Gestión de Tutores
    </h1>
    <p class="content-description">
        Administra todos los tutores registrados y sus menores enlazados. Puedes editar información, gestionar vínculos familiares y eliminar perfiles completos.
    </p>
</div>

<!-- Estadísticas rápidas -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-number">127</div>
        <div class="stat-label">Tutores activos</div>
    </div>
    <div class="stat-card">
        <div class="stat-number">89</div>
        <div class="stat-label">Con un menor</div>
    </div>
    <div class="stat-card">
        <div class="stat-number">38</div>
        <div class="stat-label">Con múltiples menores</div>
    </div>
    <div class="stat-card">
        <div class="stat-number">203</div>
        <div class="stat-label">Total de menores</div>
    </div>
</div>

<div class="content-body">
    <!-- Filtros y búsqueda -->
    <div style="background: var(--gray-100); padding: 1.5rem; border-radius: 8px; margin-bottom: 2rem;">
        <div class="form-grid">
            <div class="form-group">
                <label class="form-label" for="buscar_tutor">
                    <i class="fas fa-search"></i> Buscar tutor
                </label>
                <input type="text" id="buscar_tutor" class="form-input" 
                       placeholder="Nombre, email o teléfono..." onkeyup="filtrarTutores()">
            </div>
            
            <div class="form-group">
                <label class="form-label" for="filtro_plantel">
                    <i class="fas fa-building"></i> Plantel
                </label>
                <select id="filtro_plantel" class="form-input" onchange="filtrarTutores()">
                    <option value="">Todos los planteles</option>
                    <option value="zapote">Plantel El Zapote</option>
                    <option value="rio_nilo">Plantel Río Nilo</option>
                    <option value="colinas">Plantel Colinas</option>
                </select>
            </div>
            
            <div class="form-group">
                <label class="form-label" for="filtro_servicio">
                    <i class="fas fa-graduation-cap"></i> Servicio
                </label>
                <select id="filtro_servicio" class="form-input" onchange="filtrarTutores()">
                    <option value="">Todos los servicios</option>
                    <option value="guarderia">Guardería</option>
                    <option value="preescolar">Preescolar</option>
                    <option value="primaria">Primaria</option>
                </select>
            </div>
            
            <div class="form-group" style="display: flex; align-items: end; gap: 0.5rem;">
                <button class="btn btn-primary" onclick="exportarTutores()">
                    <i class="fas fa-download"></i>
                    Exportar
                </button>
                <button class="btn btn-secondary" onclick="mostrarEstadisticas()">
                    <i class="fas fa-chart-bar"></i>
                    Estadísticas
                </button>
            </div>
        </div>
    </div>

    <!-- Tabla de tutores -->
    <div class="table-container">
        <table class="table" id="tabla_tutores">
            <thead>
                <tr>
                    <th><i class="fas fa-user"></i> Tutor</th>
                    <th><i class="fas fa-envelope"></i> Contacto</th>
                    <th><i class="fas fa-child"></i> Menores Enlazados</th>
                    <th><i class="fas fa-calendar"></i> Fecha Registro</th>
                    <th><i class="fas fa-check-circle"></i> Estado</th>
                    <th><i class="fas fa-tools"></i> Acciones</th>
                </tr>
            </thead>
            <tbody>
                <!-- Ejemplos de datos -->
                <tr data-plantel="zapote" data-servicio="preescolar">
                    <td>
                        <div style="display: flex; align-items: center; gap: 0.75rem;">
                            <div style="width: 40px; height: 40px; background: var(--primary-color); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold;">
                                MG
                            </div>
                            <div>
                                <strong>María Elena González</strong><br>
                                <small style="color: var(--gray-600);">Madre</small>
                            </div>
                        </div>
                    </td>
                    <td>
                        <strong>Email:</strong> maria.gonzalez@email.com<br>
                        <strong>Teléfono:</strong> 33 1234 5678<br>
                        <small style="color: var(--success-color);"><i class="fas fa-check-circle"></i> Verificado</small>
                    </td>
                    <td>
                        <div style="display: flex; flex-direction: column; gap: 0.25rem;">
                            <span style="background: var(--primary-light); padding: 0.25rem 0.5rem; border-radius: 4px; font-size: 0.8rem;">
                                <i class="fas fa-child"></i> Sofía González (3 años) - Preescolar
                            </span>
                            <small style="color: var(--gray-600); margin-left: 0.5rem;">Plantel El Zapote</small>
                        </div>
                    </td>
                    <td>15/07/2025<br><small>Activo 29 días</small></td>
                    <td><span class="badge badge-approved">Activo</span></td>
                    <td>
                        <div style="display: flex; gap: 0.25rem; flex-wrap: wrap;">
                            <button class="btn btn-secondary" onclick="verPerfilTutor(1)" style="padding: 0.25rem 0.5rem; font-size: 0.8rem;">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-primary" onclick="editarTutor(1)" style="padding: 0.25rem 0.5rem; font-size: 0.8rem;">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-success" onclick="agregarMenor(1)" style="padding: 0.25rem 0.5rem; font-size: 0.8rem;">
                                <i class="fas fa-plus"></i>
                            </button>
                            <button class="btn btn-danger" onclick="eliminarTutor(1)" style="padding: 0.25rem 0.5rem; font-size: 0.8rem;">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                
                <tr data-plantel="rio_nilo" data-servicio="guarderia">
                    <td>
                        <div style="display: flex; align-items: center; gap: 0.75rem;">
                            <div style="width: 40px; height: 40px; background: var(--success-color); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold;">
                                CR
                            </div>
                            <div>
                                <strong>Carlos Ramírez López</strong><br>
                                <small style="color: var(--gray-600);">Padre</small>
                            </div>
                        </div>
                    </td>
                    <td>
                        <strong>Email:</strong> carlos.ramirez@email.com<br>
                        <strong>Teléfono:</strong> 33 8765 4321<br>
                        <small style="color: var(--success-color);"><i class="fas fa-check-circle"></i> Verificado</small>
                    </td>
                    <td>
                        <div style="display: flex; flex-direction: column; gap: 0.25rem;">
                            <span style="background: var(--primary-light); padding: 0.25rem 0.5rem; border-radius: 4px; font-size: 0.8rem;">
                                <i class="fas fa-child"></i> Diego Ramírez (5 años) - Preescolar
                            </span>
                            <small style="color: var(--gray-600); margin-left: 0.5rem;">Plantel El Zapote</small>
                            <span style="background: var(--primary-light); padding: 0.25rem 0.5rem; border-radius: 4px; font-size: 0.8rem;">
                                <i class="fas fa-child"></i> Ana Ramírez (8 años) - Primaria
                            </span>
                            <small style="color: var(--gray-600); margin-left: 0.5rem;">Plantel El Zapote</small>
                        </div>
                    </td>
                    <td>20/06/2025<br><small>Activo 54 días</small></td>
                    <td><span class="badge badge-approved">Activo</span></td>
                    <td>
                        <div style="display: flex; gap: 0.25rem; flex-wrap: wrap;">
                            <button class="btn btn-secondary" onclick="verPerfilTutor(2)" style="padding: 0.25rem 0.5rem; font-size: 0.8rem;">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-primary" onclick="editarTutor(2)" style="padding: 0.25rem 0.5rem; font-size: 0.8rem;">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-success" onclick="agregarMenor(2)" style="padding: 0.25rem 0.5rem; font-size: 0.8rem;">
                                <i class="fas fa-plus"></i>
                            </button>
                            <button class="btn btn-danger" onclick="eliminarTutor(2)" style="padding: 0.25rem 0.5rem; font-size: 0.8rem;">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                
                <tr data-plantel="colinas" data-servicio="guarderia">
                    <td>
                        <div style="display: flex; align-items: center; gap: 0.75rem;">
                            <div style="width: 40px; height: 40px; background: var(--info-color); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold;">
                                AL
                            </div>
                            <div>
                                <strong>Ana Patricia López</strong><br>
                                <small style="color: var(--gray-600);">Madre</small>
                            </div>
                        </div>
                    </td>
                    <td>
                        <strong>Email:</strong> ana.lopez@email.com<br>
                        <strong>Teléfono:</strong> 33 5555 7777<br>
                        <small style="color: var(--warning-color);"><i class="fas fa-exclamation-triangle"></i> Pendiente verificación</small>
                    </td>
                    <td>
                        <div style="display: flex; flex-direction: column; gap: 0.25rem;">
                            <span style="background: var(--primary-light); padding: 0.25rem 0.5rem; border-radius: 4px; font-size: 0.8rem;">
                                <i class="fas fa-baby"></i> Mateo López (1 año) - Guardería
                            </span>
                            <small style="color: var(--gray-600); margin-left: 0.5rem;">Plantel Colinas</small>
                        </div>
                    </td>
                    <td>10/08/2025<br><small>Activo 3 días</small></td>
                    <td><span class="badge badge-pending">Pendiente</span></td>
                    <td>
                        <div style="display: flex; gap: 0.25rem; flex-wrap: wrap;">
                            <button class="btn btn-secondary" onclick="verPerfilTutor(3)" style="padding: 0.25rem 0.5rem; font-size: 0.8rem;">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-primary" onclick="editarTutor(3)" style="padding: 0.25rem 0.5rem; font-size: 0.8rem;">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-success" onclick="agregarMenor(3)" style="padding: 0.25rem 0.5rem; font-size: 0.8rem;">
                                <i class="fas fa-plus"></i>
                            </button>
                            <button class="btn btn-danger" onclick="eliminarTutor(3)" style="padding: 0.25rem 0.5rem; font-size: 0.8rem;">
                                <i class="fas fa-trash"></i>
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
            Mostrando 1-3 de 127 tutores
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

<!-- Modal para ver perfil del tutor -->
<div id="modalPerfilTutor" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;">
    <div style="background: white; border-radius: 12px; padding: 2rem; max-width: 800px; width: 90%; max-height: 80vh; overflow-y: auto;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
            <h3 style="color: var(--primary-color); margin: 0;">Perfil del Tutor</h3>
            <button onclick="cerrarModalPerfil()" style="background: none; border: none; font-size: 1.5rem; cursor: pointer;">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div id="contenidoModalPerfil">
            <!-- Contenido dinámico -->
        </div>
    </div>
</div>

<!-- Modal para editar tutor -->
<div id="modalEditarTutor" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;">
    <div style="background: white; border-radius: 12px; padding: 2rem; max-width: 600px; width: 90%; max-height: 80vh; overflow-y: auto;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
            <h3 style="color: var(--primary-color); margin: 0;">Editar Tutor</h3>
            <button onclick="cerrarModalEditar()" style="background: none; border: none; font-size: 1.5rem; cursor: pointer;">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div id="contenidoModalEditar">
            <!-- Contenido dinámico -->
        </div>
    </div>
</div>

<script>
function filtrarTutores() {
    const busqueda = document.getElementById('buscar_tutor').value.toLowerCase();
    const filtroPlantel = document.getElementById('filtro_plantel').value;
    const filtroServicio = document.getElementById('filtro_servicio').value;
    const filas = document.querySelectorAll('#tabla_tutores tbody tr');

    filas.forEach(fila => {
        const nombre = fila.querySelector('td:first-child strong').textContent.toLowerCase();
        const email = fila.querySelector('td:nth-child(2)').textContent.toLowerCase();
        const plantel = fila.getAttribute('data-plantel');
        const servicio = fila.getAttribute('data-servicio');
        
        let mostrar = true;

        // Filtro de búsqueda
        if (busqueda && !nombre.includes(busqueda) && !email.includes(busqueda)) {
            mostrar = false;
        }

        // Filtro de plantel
        if (filtroPlantel && plantel !== filtroPlantel) {
            mostrar = false;
        }

        // Filtro de servicio
        if (filtroServicio && servicio !== filtroServicio) {
            mostrar = false;
        }

        fila.style.display = mostrar ? '' : 'none';
    });
}

function verPerfilTutor(id) {
    const contenido = `
        <div style="display: grid; gap: 1.5rem;">
            <div style="text-align: center; padding: 1rem; background: var(--primary-light); border-radius: 8px;">
                <div style="width: 80px; height: 80px; background: var(--primary-color); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 2rem; margin: 0 auto 1rem;">
                    MG
                </div>
                <h4 style="color: var(--primary-color); margin: 0;">María Elena González</h4>
                <p style="margin: 0.25rem 0 0 0; color: var(--gray-600);">Madre de familia</p>
            </div>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div style="background: var(--gray-100); padding: 1rem; border-radius: 8px;">
                    <strong style="color: var(--primary-color);">Información de Contacto:</strong><br>
                    <strong>Email:</strong> maria.gonzalez@email.com<br>
                    <strong>Teléfono:</strong> 33 1234 5678<br>
                    <strong>Dirección:</strong> Av. Principal #123, Tonalá<br>
                    <strong>Estado:</strong> <span class="badge badge-approved">Verificado</span>
                </div>
                
                <div style="background: var(--gray-100); padding: 1rem; border-radius: 8px;">
                    <strong style="color: var(--primary-color);">Información del Registro:</strong><br>
                    <strong>Fecha de registro:</strong> 15/07/2025<br>
                    <strong>Días activo:</strong> 29 días<br>
                    <strong>Último acceso:</strong> 12/08/2025<br>
                    <strong>Contraseña:</strong> <button class="btn btn-secondary" style="font-size: 0.7rem; padding: 0.25rem 0.5rem;">Resetear</button>
                </div>
            </div>
            
            <div style="background: var(--gray-100); padding: 1rem; border-radius: 8px;">
                <strong style="color: var(--primary-color);">Menores Enlazados:</strong><br>
                <div style="margin-top: 1rem; display: grid; gap: 0.75rem;">
                    <div style="background: white; padding: 1rem; border-radius: 6px; border-left: 4px solid var(--primary-color);">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <div>
                                <strong>Sofía González Martínez</strong><br>
                                <small>3 años • Preescolar • Plantel El Zapote</small><br>
                                <small style="color: var(--success-color);">✓ Documentación completa</small>
                            </div>
                            <div style="display: flex; gap: 0.25rem;">
                                <button class="btn btn-primary" style="font-size: 0.7rem; padding: 0.25rem 0.5rem;">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-danger" style="font-size: 0.7rem; padding: 0.25rem 0.5rem;">
                                    <i class="fas fa-unlink"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <button class="btn btn-success" style="margin-top: 1rem; font-size: 0.8rem;">
                    <i class="fas fa-plus"></i> Agregar otro menor
                </button>
            </div>
            
            <div style="display: flex; gap: 1rem; justify-content: flex-end;">
                <button class="btn btn-primary" onclick="editarTutor(${id})">
                    <i class="fas fa-edit"></i> Editar Información
                </button>
                <button class="btn btn-danger" onclick="eliminarTutor(${id})">
                    <i class="fas fa-trash"></i> Eliminar Tutor
                </button>
            </div>
        </div>
    `;
    
    document.getElementById('contenidoModalPerfil').innerHTML = contenido;
    document.getElementById('modalPerfilTutor').style.display = 'flex';
}

function editarTutor(id) {
    cerrarModalPerfil();
    
    const contenido = `
        <form id="formEditarTutor">
            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Nombre Completo</label>
                    <input type="text" class="form-input" value="María Elena González" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Correo Electrónico</label>
                    <input type="email" class="form-input" value="maria.gonzalez@email.com" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Teléfono</label>
                    <input type="tel" class="form-input" value="33 1234 5678" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Parentesco</label>
                    <select class="form-input" required>
                        <option value="madre" selected>Madre</option>
                        <option value="padre">Padre</option>
                        <option value="abuelo">Abuelo(a)</option>
                        <option value="tio">Tío(a)</option>
                        <option value="tutor_legal">Tutor Legal</option>
                        <option value="otro">Otro</option>
                    </select>
                </div>
            </div>
            
            <div class="form-group">
                <label class="form-label">Dirección</label>
                <textarea class="form-input" rows="2">Av. Principal #123, Tonalá, Jalisco</textarea>
            </div>
            
            <div style="display: flex; gap: 1rem; justify-content: flex-end; margin-top: 2rem;">
                <button type="button" class="btn btn-secondary" onclick="cerrarModalEditar()">
                    Cancelar
                </button>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Guardar Cambios
                </button>
            </div>
        </form>
    `;
    
    document.getElementById('contenidoModalEditar').innerHTML = contenido;
    document.getElementById('modalEditarTutor').style.display = 'flex';
    
    // Manejar envío del formulario
    document.getElementById('formEditarTutor').addEventListener('submit', function(e) {
        e.preventDefault();
        alert('Información del tutor actualizada correctamente');
        cerrarModalEditar();
        location.reload();
    });
}

function agregarMenor(id) {
    alert('Redirigiendo al formulario para agregar un nuevo menor...');
}

function eliminarTutor(id) {
    if (confirmDelete('eliminar este tutor y TODOS sus menores enlazados')) {
        alert('Tutor eliminado correctamente');
        location.reload();
    }
}

function cerrarModalPerfil() {
    document.getElementById('modalPerfilTutor').style.display = 'none';
}

function cerrarModalEditar() {
    document.getElementById('modalEditarTutor').style.display = 'none';
}

function exportarTutores() {
    alert('Exportando lista de tutores...');
}

function mostrarEstadisticas() {
    alert('Mostrando estadísticas detalladas...');
}

// Cerrar modales al hacer clic fuera
document.getElementById('modalPerfilTutor').addEventListener('click', function(e) {
    if (e.target === this) cerrarModalPerfil();
});

document.getElementById('modalEditarTutor').addEventListener('click', function(e) {
    if (e.target === this) cerrarModalEditar();
});
</script>
