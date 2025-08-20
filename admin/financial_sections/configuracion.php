<!-- ===================== CONFIGURACIÓN FINANCIERA ===================== -->
<div class="content-header">
    <h1 class="content-title">
        <i class="fas fa-cog"></i>
        Configuración del Sistema Financiero
    </h1>
    <p class="content-description">
        Configuración general del sistema financiero, planteles, usuarios y parámetros de control
    </p>
</div>

<!-- ===================== NAVEGACIÓN DE CONFIGURACIÓN ===================== -->
<div class="content-body" style="margin-bottom: 2rem;">
    <div class="form-grid">
        <button class="btn btn-primary" onclick="showConfigSection('planteles')" id="config-btn-planteles">
            <i class="fas fa-building"></i>
            Configurar Planteles
        </button>
        <button class="btn btn-secondary" onclick="showConfigSection('usuarios')" id="config-btn-usuarios">
            <i class="fas fa-users"></i>
            Gestión de Usuarios
        </button>
        <button class="btn btn-secondary" onclick="showConfigSection('conceptos')" id="config-btn-conceptos">
            <i class="fas fa-tags"></i>
            Conceptos de Pago
        </button>
        <button class="btn btn-secondary" onclick="showConfigSection('sistema')" id="config-btn-sistema">
            <i class="fas fa-sliders-h"></i>
            Parámetros Sistema
        </button>
    </div>
</div>

<!-- ===================== CONFIGURACIÓN DE PLANTELES ===================== -->
<div id="config-planteles" class="config-section">
    <div class="content-body" style="margin-bottom: 2rem;">
        <h3 style="color: var(--primary-color); margin-bottom: 1.5rem;">
            <i class="fas fa-building"></i>
            Configuración de Planteles
        </h3>
        
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>Plantel</th>
                        <th>Encargada</th>
                        <th>Alumnos</th>
                        <th>Meta Mensual</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <strong>El Zapote</strong><br>
                            <small>Dirección: Av. Central 123</small>
                        </td>
                        <td>
                            María González<br>
                            <small>maria.gonzalez@iefk.edu</small>
                        </td>
                        <td>180</td>
                        <td>$270,000</td>
                        <td><span class="badge badge-approved">Activo</span></td>
                        <td>
                            <button class="btn btn-primary" style="padding: 0.25rem 0.5rem; font-size: 0.8rem;" 
                                    onclick="editarPlantel('zapote')">
                                Editar
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>Río Nilo</strong><br>
                            <small>Dirección: Calle Río Nilo 456</small>
                        </td>
                        <td>
                            Carmen López<br>
                            <small>carmen.lopez@iefk.edu</small>
                        </td>
                        <td>165</td>
                        <td>$247,500</td>
                        <td><span class="badge badge-approved">Activo</span></td>
                        <td>
                            <button class="btn btn-primary" style="padding: 0.25rem 0.5rem; font-size: 0.8rem;" 
                                    onclick="editarPlantel('rio_nilo')">
                                Editar
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>Colinas</strong><br>
                            <small>Dirección: Fraccionamiento Colinas 789</small>
                        </td>
                        <td>
                            Ana Rodríguez<br>
                            <small>ana.rodriguez@iefk.edu</small>
                        </td>
                        <td>142</td>
                        <td>$213,000</td>
                        <td><span class="badge badge-approved">Activo</span></td>
                        <td>
                            <button class="btn btn-primary" style="padding: 0.25rem 0.5rem; font-size: 0.8rem;" 
                                    onclick="editarPlantel('colinas')">
                                Editar
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <div style="margin-top: 1.5rem;">
            <button class="btn btn-success" onclick="agregarPlantel()">
                <i class="fas fa-plus"></i>
                Agregar Nuevo Plantel
            </button>
        </div>
    </div>
</div>

<!-- ===================== GESTIÓN DE USUARIOS ===================== -->
<div id="config-usuarios" class="config-section" style="display: none;">
    <div class="content-body" style="margin-bottom: 2rem;">
        <h3 style="color: var(--primary-color); margin-bottom: 1.5rem;">
            <i class="fas fa-users"></i>
            Gestión de Usuarios del Sistema
        </h3>
        
        <!-- Formulario para nuevo usuario -->
        <div style="background: var(--primary-light); padding: 1.5rem; border-radius: var(--border-radius); margin-bottom: 2rem;">
            <h4 style="color: var(--primary-color); margin-bottom: 1rem;">Agregar Nuevo Usuario</h4>
            
            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Nombre Completo</label>
                    <input type="text" class="form-input" id="nuevo-usuario-nombre" placeholder="Nombre completo">
                </div>
                
                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-input" id="nuevo-usuario-email" placeholder="usuario@iefk.edu">
                </div>
                
                <div class="form-group">
                    <label class="form-label">Rol</label>
                    <select class="form-input" id="nuevo-usuario-rol">
                        <option value="">Seleccionar rol</option>
                        <option value="admin">Administrador</option>
                        <option value="director">Director</option>
                        <option value="encargada">Encargada de Plantel</option>
                        <option value="contador">Contador</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Plantel Asignado</label>
                    <select class="form-input" id="nuevo-usuario-plantel">
                        <option value="">Seleccionar plantel</option>
                        <option value="todos">Todos los Planteles</option>
                        <option value="zapote">El Zapote</option>
                        <option value="rio_nilo">Río Nilo</option>
                        <option value="colinas">Colinas</option>
                    </select>
                </div>
            </div>
            
            <div style="margin-top: 1rem;">
                <button class="btn btn-primary" onclick="crearUsuario()">
                    <i class="fas fa-user-plus"></i>
                    Crear Usuario
                </button>
            </div>
        </div>
        
        <!-- Lista de usuarios existentes -->
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>Usuario</th>
                        <th>Email</th>
                        <th>Rol</th>
                        <th>Plantel</th>
                        <th>Último Acceso</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <strong>Director General</strong><br>
                            <small>Administrador Principal</small>
                        </td>
                        <td>director@iefk.edu</td>
                        <td><span class="badge badge-approved">Admin</span></td>
                        <td>Todos</td>
                        <td>13/08/2025 15:30</td>
                        <td><span class="badge badge-approved">Activo</span></td>
                        <td>
                            <button class="btn btn-primary" style="padding: 0.25rem 0.5rem; font-size: 0.8rem;">
                                Editar
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>María González</strong><br>
                            <small>Encargada El Zapote</small>
                        </td>
                        <td>maria.gonzalez@iefk.edu</td>
                        <td><span class="badge badge-pending">Encargada</span></td>
                        <td>El Zapote</td>
                        <td>13/08/2025 14:15</td>
                        <td><span class="badge badge-approved">Activo</span></td>
                        <td>
                            <button class="btn btn-primary" style="padding: 0.25rem 0.5rem; font-size: 0.8rem;">
                                Editar
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>Carmen López</strong><br>
                            <small>Encargada Río Nilo</small>
                        </td>
                        <td>carmen.lopez@iefk.edu</td>
                        <td><span class="badge badge-pending">Encargada</span></td>
                        <td>Río Nilo</td>
                        <td>13/08/2025 13:45</td>
                        <td><span class="badge badge-approved">Activo</span></td>
                        <td>
                            <button class="btn btn-primary" style="padding: 0.25rem 0.5rem; font-size: 0.8rem;">
                                Editar
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>Ana Rodríguez</strong><br>
                            <small>Encargada Colinas</small>
                        </td>
                        <td>ana.rodriguez@iefk.edu</td>
                        <td><span class="badge badge-pending">Encargada</span></td>
                        <td>Colinas</td>
                        <td>13/08/2025 12:30</td>
                        <td><span class="badge badge-approved">Activo</span></td>
                        <td>
                            <button class="btn btn-primary" style="padding: 0.25rem 0.5rem; font-size: 0.8rem;">
                                Editar
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ===================== CONFIGURACIÓN DE CONCEPTOS ===================== -->
<div id="config-conceptos" class="config-section" style="display: none;">
    <div class="content-body" style="margin-bottom: 2rem;">
        <h3 style="color: var(--primary-color); margin-bottom: 1.5rem;">
            <i class="fas fa-tags"></i>
            Conceptos de Pago y Gasto
        </h3>
        
        <div class="form-grid">
            <!-- Conceptos de Pago -->
            <div class="stat-card">
                <h4 style="color: var(--primary-color);">Conceptos de Pago</h4>
                <div style="text-align: left; margin-top: 1rem;">
                    <div style="margin-bottom: 0.5rem;">
                        <span class="badge badge-paid">Mensualidad</span>
                        <button style="margin-left: 0.5rem; border: none; background: none; color: var(--danger-color);">
                            <i class="fas fa-edit"></i>
                        </button>
                    </div>
                    <div style="margin-bottom: 0.5rem;">
                        <span class="badge badge-paid">Inscripción</span>
                        <button style="margin-left: 0.5rem; border: none; background: none; color: var(--danger-color);">
                            <i class="fas fa-edit"></i>
                        </button>
                    </div>
                    <div style="margin-bottom: 0.5rem;">
                        <span class="badge badge-paid">Material Didáctico</span>
                        <button style="margin-left: 0.5rem; border: none; background: none; color: var(--danger-color);">
                            <i class="fas fa-edit"></i>
                        </button>
                    </div>
                    <div style="margin-bottom: 0.5rem;">
                        <span class="badge badge-paid">Uniforme</span>
                        <button style="margin-left: 0.5rem; border: none; background: none; color: var(--danger-color);">
                            <i class="fas fa-edit"></i>
                        </button>
                    </div>
                    <div style="margin-bottom: 0.5rem;">
                        <span class="badge badge-paid">Excursión</span>
                        <button style="margin-left: 0.5rem; border: none; background: none; color: var(--danger-color);">
                            <i class="fas fa-edit"></i>
                        </button>
                    </div>
                </div>
                <button class="btn btn-success" style="width: 100%; margin-top: 1rem;" onclick="agregarConceptoPago()">
                    <i class="fas fa-plus"></i>
                    Agregar Concepto
                </button>
            </div>
            
            <!-- Conceptos de Gasto -->
            <div class="stat-card">
                <h4 style="color: var(--primary-color);">Conceptos de Gasto</h4>
                <div style="text-align: left; margin-top: 1rem;">
                    <div style="margin-bottom: 0.5rem;">
                        <span class="badge badge-warning">Mantenimiento</span>
                        <button style="margin-left: 0.5rem; border: none; background: none; color: var(--danger-color);">
                            <i class="fas fa-edit"></i>
                        </button>
                    </div>
                    <div style="margin-bottom: 0.5rem;">
                        <span class="badge badge-warning">Limpieza</span>
                        <button style="margin-left: 0.5rem; border: none; background: none; color: var(--danger-color);">
                            <i class="fas fa-edit"></i>
                        </button>
                    </div>
                    <div style="margin-bottom: 0.5rem;">
                        <span class="badge badge-warning">Papelería</span>
                        <button style="margin-left: 0.5rem; border: none; background: none; color: var(--danger-color);">
                            <i class="fas fa-edit"></i>
                        </button>
                    </div>
                    <div style="margin-bottom: 0.5rem;">
                        <span class="badge badge-warning">Servicios</span>
                        <button style="margin-left: 0.5rem; border: none; background: none; color: var(--danger-color);">
                            <i class="fas fa-edit"></i>
                        </button>
                    </div>
                    <div style="margin-bottom: 0.5rem;">
                        <span class="badge badge-warning">Transporte</span>
                        <button style="margin-left: 0.5rem; border: none; background: none; color: var(--danger-color);">
                            <i class="fas fa-edit"></i>
                        </button>
                    </div>
                </div>
                <button class="btn btn-success" style="width: 100%; margin-top: 1rem;" onclick="agregarConceptoGasto()">
                    <i class="fas fa-plus"></i>
                    Agregar Concepto
                </button>
            </div>
        </div>
    </div>
</div>

<!-- ===================== PARÁMETROS DEL SISTEMA ===================== -->
<div id="config-sistema" class="config-section" style="display: none;">
    <div class="content-body">
        <h3 style="color: var(--primary-color); margin-bottom: 1.5rem;">
            <i class="fas fa-sliders-h"></i>
            Parámetros del Sistema Financiero
        </h3>
        
        <div class="form-grid">
            <div class="form-group">
                <label class="form-label">Moneda del Sistema</label>
                <select class="form-input">
                    <option value="MXN" selected>Peso Mexicano (MXN)</option>
                    <option value="USD">Dólar Americano (USD)</option>
                    <option value="EUR">Euro (EUR)</option>
                </select>
            </div>
            
            <div class="form-group">
                <label class="form-label">Hora de Corte Diario</label>
                <input type="time" class="form-input" value="18:00">
            </div>
            
            <div class="form-group">
                <label class="form-label">Límite de Efectivo en Caja</label>
                <input type="number" class="form-input" value="50000" step="1000">
            </div>
            
            <div class="form-group">
                <label class="form-label">Días para Alerta de Recolección</label>
                <select class="form-input">
                    <option value="1" selected>1 día</option>
                    <option value="2">2 días</option>
                    <option value="3">3 días</option>
                </select>
            </div>
            
            <div class="form-group">
                <label class="form-label">Backup Automático</label>
                <select class="form-input">
                    <option value="diario" selected>Diario</option>
                    <option value="semanal">Semanal</option>
                    <option value="mensual">Mensual</option>
                </select>
            </div>
            
            <div class="form-group">
                <label class="form-label">Retención de Datos (meses)</label>
                <input type="number" class="form-input" value="24" min="12" max="60">
            </div>
        </div>
        
        <div style="margin-top: 2rem;">
            <button class="btn btn-primary" onclick="guardarConfiguracion()">
                <i class="fas fa-save"></i>
                Guardar Configuración
            </button>
            
            <button class="btn btn-warning" onclick="exportarConfiguracion()">
                <i class="fas fa-download"></i>
                Exportar Configuración
            </button>
            
            <button class="btn btn-danger" onclick="resetearSistema()">
                <i class="fas fa-undo"></i>
                Resetear a Valores por Defecto
            </button>
        </div>
    </div>
</div>

<!-- ===================== SCRIPTS ESPECÍFICOS ===================== -->
<script>
    // Función para mostrar secciones de configuración
    function showConfigSection(section) {
        // Ocultar todas las secciones
        document.querySelectorAll('.config-section').forEach(el => {
            el.style.display = 'none';
        });
        
        // Resetear botones
        document.querySelectorAll('[id^="config-btn-"]').forEach(btn => {
            btn.className = btn.className.replace('btn-primary', 'btn-secondary');
        });
        
        // Mostrar sección seleccionada
        document.getElementById('config-' + section).style.display = 'block';
        document.getElementById('config-btn-' + section).className = 
            document.getElementById('config-btn-' + section).className.replace('btn-secondary', 'btn-primary');
    }

    // Función para editar plantel
    function editarPlantel(plantel) {
        alert(`Editando configuración del plantel: ${plantel}\n\n` +
              `Aquí se abrirá un modal con los datos editables del plantel.`);
    }

    // Función para agregar plantel
    function agregarPlantel() {
        const nombre = prompt('Nombre del nuevo plantel:');
        if(nombre) {
            alert(`Agregando plantel: ${nombre}\n\n` +
                  `Se creará la configuración inicial y se asignará un encargado.`);
        }
    }

    // Función para crear usuario
    function crearUsuario() {
        const nombre = document.getElementById('nuevo-usuario-nombre').value;
        const email = document.getElementById('nuevo-usuario-email').value;
        const rol = document.getElementById('nuevo-usuario-rol').value;
        const plantel = document.getElementById('nuevo-usuario-plantel').value;
        
        if(nombre && email && rol && plantel) {
            alert(`Usuario creado exitosamente:\n\n` +
                  `Nombre: ${nombre}\n` +
                  `Email: ${email}\n` +
                  `Rol: ${rol}\n` +
                  `Plantel: ${plantel}\n\n` +
                  `Se enviará un email con las credenciales de acceso.`);
            
            // Limpiar formulario
            document.getElementById('nuevo-usuario-nombre').value = '';
            document.getElementById('nuevo-usuario-email').value = '';
            document.getElementById('nuevo-usuario-rol').value = '';
            document.getElementById('nuevo-usuario-plantel').value = '';
        } else {
            alert('Por favor complete todos los campos obligatorios.');
        }
    }

    // Función para agregar concepto de pago
    function agregarConceptoPago() {
        const concepto = prompt('Nuevo concepto de pago:');
        if(concepto) {
            alert(`Concepto "${concepto}" agregado exitosamente a la lista de conceptos de pago.`);
        }
    }

    // Función para agregar concepto de gasto
    function agregarConceptoGasto() {
        const concepto = prompt('Nuevo concepto de gasto:');
        if(concepto) {
            alert(`Concepto "${concepto}" agregado exitosamente a la lista de conceptos de gasto.`);
        }
    }

    // Función para guardar configuración
    function guardarConfiguracion() {
        if(confirm('¿Guardar la configuración actual del sistema?')) {
            alert('Configuración guardada exitosamente.\n\nLos cambios se aplicarán inmediatamente.');
        }
    }

    // Función para exportar configuración
    function exportarConfiguracion() {
        if(confirm('¿Exportar la configuración actual a un archivo?')) {
            alert('Exportando configuración...\n\nEl archivo se descargará automáticamente.');
        }
    }

    // Función para resetear sistema
    function resetearSistema() {
        if(confirm('¿ADVERTENCIA: Esto restaurará todos los parámetros a sus valores por defecto?\n\n¿Está seguro de continuar?')) {
            alert('Sistema restaurado a valores por defecto.\n\nSe recomienda revisar toda la configuración.');
        }
    }

    // Mostrar sección de planteles por defecto
    document.addEventListener('DOMContentLoaded', function() {
        showConfigSection('planteles');
    });
</script>
