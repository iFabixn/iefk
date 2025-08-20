<!-- ===================== GESTIÓN DE ROLES ===================== -->
<div class="gestion-roles">
    <!-- Header -->
    <div class="roles-header">
        <div class="header-info">
            <h2 style="color: var(--primary-color); margin-bottom: 0.5rem;">
                <i class="fas fa-user-tag"></i> Gestión de Roles y Privilegios
            </h2>
            <p style="color: var(--gray-600);">
                Configuración de roles predefinidos, permisos y accesos a secciones del sistema
            </p>
        </div>
        
        <div class="header-acciones">
            <button class="btn btn-primary" onclick="abrirModalNuevoRol()">
                <i class="fas fa-plus"></i> Crear Rol Personalizado
            </button>
            <button class="btn btn-warning" onclick="exportarRoles()">
                <i class="fas fa-download"></i> Exportar Configuración
            </button>
        </div>
    </div>

    <!-- Estadísticas de Roles -->
    <div class="estadisticas-roles">
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-user-tag"></i>
            </div>
            <div class="stat-content">
                <div class="stat-number"><?= count($roles_predefinidos) ?></div>
                <div class="stat-label">Roles Configurados</div>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-content">
                <div class="stat-number"><?= count($usuarios_registrados) ?></div>
                <div class="stat-label">Usuarios Asignados</div>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-key"></i>
            </div>
            <div class="stat-content">
                <div class="stat-number"><?= count($secciones_disponibles) ?></div>
                <div class="stat-label">Secciones Disponibles</div>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-shield-alt"></i>
            </div>
            <div class="stat-content">
                <div class="stat-number">
                    <?php 
                    $permisos_unicos = [];
                    foreach ($roles_predefinidos as $rol) {
                        $permisos_unicos = array_merge($permisos_unicos, $rol['permisos']);
                    }
                    echo count(array_unique($permisos_unicos));
                    ?>
                </div>
                <div class="stat-label">Permisos Únicos</div>
            </div>
        </div>
    </div>

    <!-- Grid de Roles -->
    <div class="roles-grid">
        <?php foreach ($roles_predefinidos as $rol_nombre => $rol_data): ?>
        <div class="rol-card">
            <!-- Header del rol -->
            <div class="rol-header" style="border-left: 4px solid <?= $rol_data['color'] ?>;">
                <div class="rol-info">
                    <h3><?= $rol_nombre ?></h3>
                    <p><?= $rol_data['descripcion'] ?></p>
                    <div class="rol-badges">
                        <span class="badge" style="background: <?= $rol_data['color'] ?>;">
                            <?php 
                            $usuarios_con_rol = array_filter($usuarios_registrados, fn($u) => $u['rol'] === $rol_nombre);
                            echo count($usuarios_con_rol) . ' usuarios';
                            ?>
                        </span>
                        <span class="badge badge-secondary">
                            <?= count($rol_data['secciones']) ?> secciones
                        </span>
                        <span class="badge badge-info">
                            <?= count($rol_data['permisos']) ?> permisos
                        </span>
                    </div>
                </div>
                
                <div class="rol-acciones">
                    <button class="btn btn-sm btn-primary" onclick="editarRol('<?= $rol_nombre ?>')">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="btn btn-sm btn-info" onclick="verDetalleRol('<?= $rol_nombre ?>')">
                        <i class="fas fa-eye"></i>
                    </button>
                    <button class="btn btn-sm btn-warning" onclick="duplicarRol('<?= $rol_nombre ?>')">
                        <i class="fas fa-copy"></i>
                    </button>
                    <?php if (!in_array($rol_nombre, ['Dueño/Administrador'])): ?>
                    <button class="btn btn-sm btn-danger" onclick="eliminarRol('<?= $rol_nombre ?>')">
                        <i class="fas fa-trash"></i>
                    </button>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Secciones asignadas -->
            <div class="rol-secciones">
                <h4><i class="fas fa-key"></i> Accesos Asignados</h4>
                <div class="secciones-grid">
                    <?php foreach ($rol_data['secciones'] as $seccion_id): ?>
                        <?php if (isset($secciones_disponibles[$seccion_id])): ?>
                        <div class="seccion-item">
                            <i class="<?= $secciones_disponibles[$seccion_id]['icono'] ?>"></i>
                            <span><?= $secciones_disponibles[$seccion_id]['nombre'] ?></span>
                        </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Permisos asignados -->
            <div class="rol-permisos">
                <h4><i class="fas fa-shield-alt"></i> Permisos Otorgados</h4>
                <div class="permisos-grid">
                    <?php foreach ($rol_data['permisos'] as $permiso): ?>
                    <span class="permiso-tag permiso-<?= $permiso ?>"><?= ucfirst($permiso) ?></span>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Usuarios con este rol -->
            <div class="rol-usuarios">
                <h4><i class="fas fa-users"></i> Usuarios Asignados</h4>
                <?php 
                $usuarios_rol = array_filter($usuarios_registrados, fn($u) => $u['rol'] === $rol_nombre);
                if (!empty($usuarios_rol)): 
                ?>
                <div class="usuarios-avatars">
                    <?php foreach (array_slice($usuarios_rol, 0, 5) as $usuario): ?>
                    <div class="usuario-avatar-mini" title="<?= $usuario['nombre'] ?>">
                        <?php if ($usuario['foto_perfil']): ?>
                        <img src="../uploads/perfiles/<?= $usuario['foto_perfil'] ?>" alt="<?= $usuario['nombre'] ?>">
                        <?php else: ?>
                        <i class="fas fa-user"></i>
                        <?php endif; ?>
                    </div>
                    <?php endforeach; ?>
                    
                    <?php if (count($usuarios_rol) > 5): ?>
                    <div class="usuarios-extras">
                        +<?= count($usuarios_rol) - 5 ?>
                    </div>
                    <?php endif; ?>
                </div>
                <?php else: ?>
                <p class="sin-usuarios">No hay usuarios asignados a este rol</p>
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Matriz de Permisos -->
    <div class="matriz-permisos">
        <h3><i class="fas fa-table"></i> Matriz de Permisos por Rol</h3>
        <div class="tabla-container">
            <table class="tabla-permisos">
                <thead>
                    <tr>
                        <th>Rol</th>
                        <?php 
                        $todos_permisos = [];
                        foreach ($roles_predefinidos as $rol) {
                            $todos_permisos = array_merge($todos_permisos, $rol['permisos']);
                        }
                        $permisos_unicos = array_unique($todos_permisos);
                        foreach ($permisos_unicos as $permiso): 
                        ?>
                        <th><?= ucfirst($permiso) ?></th>
                        <?php endforeach; ?>
                        <th>Usuarios</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($roles_predefinidos as $rol_nombre => $rol_data): ?>
                    <tr>
                        <td class="rol-celda">
                            <div class="rol-info-tabla">
                                <div class="color-indicator" style="background: <?= $rol_data['color'] ?>;"></div>
                                <span><?= $rol_nombre ?></span>
                            </div>
                        </td>
                        <?php foreach ($permisos_unicos as $permiso): ?>
                        <td class="permiso-celda">
                            <?php if (in_array($permiso, $rol_data['permisos'])): ?>
                            <i class="fas fa-check text-success"></i>
                            <?php else: ?>
                            <i class="fas fa-times text-muted"></i>
                            <?php endif; ?>
                        </td>
                        <?php endforeach; ?>
                        <td class="usuarios-count">
                            <?php 
                            $count = count(array_filter($usuarios_registrados, fn($u) => $u['rol'] === $rol_nombre));
                            echo $count;
                            ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Análisis de Secciones -->
    <div class="analisis-secciones">
        <h3><i class="fas fa-chart-bar"></i> Análisis de Accesos por Sección</h3>
        <div class="secciones-analisis-grid">
            <?php foreach ($secciones_disponibles as $seccion_id => $seccion): ?>
            <div class="seccion-analisis">
                <div class="seccion-header">
                    <i class="<?= $seccion['icono'] ?>"></i>
                    <h4><?= $seccion['nombre'] ?></h4>
                </div>
                
                <div class="seccion-stats">
                    <?php 
                    $roles_con_acceso = array_filter($roles_predefinidos, fn($rol) => in_array($seccion_id, $rol['secciones']));
                    $usuarios_con_acceso = array_filter($usuarios_registrados, function($usuario) use ($seccion_id) {
                        return in_array($seccion_id, $usuario['secciones_asignadas']);
                    });
                    ?>
                    
                    <div class="stat-item">
                        <span class="stat-number"><?= count($roles_con_acceso) ?></span>
                        <span class="stat-label">Roles con acceso</span>
                    </div>
                    
                    <div class="stat-item">
                        <span class="stat-number"><?= count($usuarios_con_acceso) ?></span>
                        <span class="stat-label">Usuarios con acceso</span>
                    </div>
                </div>
                
                <div class="roles-con-acceso">
                    <?php foreach ($roles_con_acceso as $rol_nombre => $rol_data): ?>
                    <span class="rol-tag" style="background: <?= $rol_data['color'] ?>;">
                        <?= $rol_nombre ?>
                    </span>
                    <?php endforeach; ?>
                </div>
                
                <div class="seccion-descripcion">
                    <small><?= $seccion['descripcion'] ?></small>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<!-- Modal para Crear/Editar Rol -->
<div id="modal-rol" class="modal" style="display: none;">
    <div class="modal-content modal-xl">
        <div class="modal-header">
            <h3 id="modal-rol-titulo"><i class="fas fa-user-tag"></i> Crear Nuevo Rol</h3>
            <span class="modal-close" onclick="cerrarModalRol()">&times;</span>
        </div>
        <div class="modal-body">
            <form id="form-rol">
                <div class="form-grid">
                    <div class="form-group">
                        <label for="nombre-rol">Nombre del Rol *</label>
                        <input type="text" id="nombre-rol" required placeholder="Ej: Coordinador de Área">
                    </div>
                    
                    <div class="form-group">
                        <label for="color-rol">Color Identificador *</label>
                        <input type="color" id="color-rol" required value="#6366f1">
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="descripcion-rol">Descripción del Rol *</label>
                    <textarea id="descripcion-rol" required rows="3" 
                              placeholder="Descripción detallada de las responsabilidades y alcance del rol"></textarea>
                </div>
                
                <div class="secciones-configuracion">
                    <h4><i class="fas fa-key"></i> Secciones de Acceso</h4>
                    <p class="text-muted">Selecciona las secciones del sistema a las que tendrá acceso este rol</p>
                    <div class="secciones-grid-modal">
                        <?php foreach ($secciones_disponibles as $seccion_id => $seccion): ?>
                        <label class="seccion-checkbox-modal">
                            <input type="checkbox" name="secciones_rol[]" value="<?= $seccion_id ?>">
                            <div class="checkbox-content-modal">
                                <i class="<?= $seccion['icono'] ?>"></i>
                                <span class="seccion-nombre"><?= $seccion['nombre'] ?></span>
                                <small class="seccion-descripcion"><?= $seccion['descripcion'] ?></small>
                            </div>
                        </label>
                        <?php endforeach; ?>
                    </div>
                </div>
                
                <div class="permisos-configuracion">
                    <h4><i class="fas fa-shield-alt"></i> Permisos del Rol</h4>
                    <p class="text-muted">Define qué acciones puede realizar este rol en el sistema</p>
                    <div class="permisos-grid-modal">
                        <label class="permiso-checkbox-modal">
                            <input type="checkbox" name="permisos_rol[]" value="ver">
                            <div class="permiso-content">
                                <i class="fas fa-eye"></i>
                                <span>Ver Información</span>
                                <small>Consultar datos y reportes</small>
                            </div>
                        </label>
                        
                        <label class="permiso-checkbox-modal">
                            <input type="checkbox" name="permisos_rol[]" value="crear">
                            <div class="permiso-content">
                                <i class="fas fa-plus"></i>
                                <span>Crear Registros</span>
                                <small>Agregar nuevos elementos</small>
                            </div>
                        </label>
                        
                        <label class="permiso-checkbox-modal">
                            <input type="checkbox" name="permisos_rol[]" value="editar">
                            <div class="permiso-content">
                                <i class="fas fa-edit"></i>
                                <span>Editar Información</span>
                                <small>Modificar datos existentes</small>
                            </div>
                        </label>
                        
                        <label class="permiso-checkbox-modal">
                            <input type="checkbox" name="permisos_rol[]" value="eliminar">
                            <div class="permiso-content">
                                <i class="fas fa-trash"></i>
                                <span>Eliminar Registros</span>
                                <small>Borrar información del sistema</small>
                            </div>
                        </label>
                        
                        <label class="permiso-checkbox-modal">
                            <input type="checkbox" name="permisos_rol[]" value="exportar">
                            <div class="permiso-content">
                                <i class="fas fa-download"></i>
                                <span>Exportar Datos</span>
                                <small>Descargar reportes y archivos</small>
                            </div>
                        </label>
                        
                        <label class="permiso-checkbox-modal">
                            <input type="checkbox" name="permisos_rol[]" value="administrar">
                            <div class="permiso-content">
                                <i class="fas fa-cogs"></i>
                                <span>Administrar Sistema</span>
                                <small>Configuraciones avanzadas</small>
                            </div>
                        </label>
                    </div>
                </div>
                
                <div class="previa-rol">
                    <h4><i class="fas fa-preview"></i> Vista Previa del Rol</h4>
                    <div id="preview-rol" class="rol-preview">
                        <p class="text-muted">Configure el rol para ver la vista previa</p>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button class="btn btn-secondary" onclick="cerrarModalRol()">Cancelar</button>
            <button class="btn btn-primary" onclick="guardarRol()">
                <i class="fas fa-save"></i> Guardar Rol
            </button>
        </div>
    </div>
</div>

<!-- ===================== ESTILOS ESPECÍFICOS ===================== -->
<style>
    .gestion-roles {
        display: flex;
        flex-direction: column;
        gap: 2rem;
    }

    .roles-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: var(--primary-light);
        padding: 2rem;
        border-radius: var(--border-radius);
        border: 2px solid var(--primary-color);
    }

    .header-acciones {
        display: flex;
        gap: 1rem;
    }

    .estadisticas-roles {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
    }

    .roles-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
        gap: 2rem;
    }

    .rol-card {
        background: var(--white);
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        border: 2px solid var(--gray-200);
        overflow: hidden;
        transition: var(--transition);
    }

    .rol-card:hover {
        box-shadow: var(--shadow-hover);
        transform: translateY(-2px);
    }

    .rol-header {
        padding: 1.5rem;
        background: var(--gray-50);
        border-bottom: 2px solid var(--gray-200);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .rol-info h3 {
        margin: 0 0 0.5rem 0;
        color: var(--gray-800);
        font-size: 1.2rem;
    }

    .rol-info p {
        margin: 0 0 1rem 0;
        color: var(--gray-600);
        font-size: 0.9rem;
    }

    .rol-badges {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .rol-acciones {
        display: flex;
        gap: 0.5rem;
    }

    .rol-secciones,
    .rol-permisos,
    .rol-usuarios {
        padding: 1.5rem;
        border-bottom: 2px solid var(--gray-200);
    }

    .rol-secciones:last-child,
    .rol-permisos:last-child,
    .rol-usuarios:last-child {
        border-bottom: none;
    }

    .rol-secciones h4,
    .rol-permisos h4,
    .rol-usuarios h4 {
        color: var(--gray-700);
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 1rem;
    }

    .secciones-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 0.75rem;
    }

    .seccion-item {
        background: var(--primary-light);
        color: var(--primary-color);
        padding: 0.75rem;
        border-radius: var(--border-radius);
        display: flex;
        align-items: center;
        gap: 0.75rem;
        border: 1px solid var(--primary-color);
        font-size: 0.9rem;
    }

    .permisos-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
    }

    .permiso-tag {
        padding: 0.4rem 0.8rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        color: var(--white);
    }

    .usuarios-avatars {
        display: flex;
        gap: 0.5rem;
        align-items: center;
    }

    .usuario-avatar-mini {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        overflow: hidden;
        background: var(--gray-300);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--gray-600);
        font-size: 1rem;
        border: 2px solid var(--white);
        box-shadow: var(--shadow);
    }

    .usuario-avatar-mini img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .usuarios-extras {
        background: var(--gray-500);
        color: var(--white);
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.8rem;
        font-weight: 600;
        border: 2px solid var(--white);
        box-shadow: var(--shadow);
    }

    .sin-usuarios {
        color: var(--gray-500);
        font-style: italic;
        margin: 0;
    }

    .matriz-permisos {
        background: var(--white);
        padding: 2rem;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        border: 2px solid var(--gray-200);
    }

    .matriz-permisos h3 {
        color: var(--primary-color);
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .tabla-container {
        overflow-x: auto;
    }

    .tabla-permisos {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.9rem;
    }

    .tabla-permisos th,
    .tabla-permisos td {
        padding: 1rem;
        text-align: center;
        border: 1px solid var(--gray-200);
    }

    .tabla-permisos th {
        background: var(--gray-50);
        font-weight: 600;
        color: var(--gray-700);
    }

    .rol-celda {
        text-align: left !important;
    }

    .rol-info-tabla {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .color-indicator {
        width: 16px;
        height: 16px;
        border-radius: 50%;
    }

    .permiso-celda i {
        font-size: 1.1rem;
    }

    .text-success {
        color: var(--success-color);
    }

    .text-muted {
        color: var(--gray-400);
    }

    .usuarios-count {
        font-weight: 600;
        color: var(--primary-color);
    }

    .analisis-secciones {
        background: var(--white);
        padding: 2rem;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        border: 2px solid var(--accent-color);
    }

    .analisis-secciones h3 {
        color: var(--primary-color);
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .secciones-analisis-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
    }

    .seccion-analisis {
        background: var(--gray-50);
        padding: 1.5rem;
        border-radius: var(--border-radius);
        border: 2px solid var(--gray-200);
        transition: var(--transition);
    }

    .seccion-analisis:hover {
        border-color: var(--primary-color);
        transform: translateY(-2px);
    }

    .seccion-header {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .seccion-header i {
        color: var(--primary-color);
        font-size: 1.5rem;
    }

    .seccion-header h4 {
        margin: 0;
        color: var(--gray-800);
    }

    .seccion-stats {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .stat-item {
        text-align: center;
        background: var(--white);
        padding: 1rem;
        border-radius: var(--border-radius);
        border: 1px solid var(--gray-200);
    }

    .stat-item .stat-number {
        display: block;
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--primary-color);
        margin-bottom: 0.25rem;
    }

    .stat-item .stat-label {
        color: var(--gray-600);
        font-size: 0.8rem;
    }

    .roles-con-acceso {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin-bottom: 1rem;
    }

    .rol-tag {
        padding: 0.3rem 0.6rem;
        border-radius: 15px;
        color: var(--white);
        font-size: 0.75rem;
        font-weight: 600;
    }

    .seccion-descripcion {
        color: var(--gray-500);
        font-style: italic;
    }

    .form-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .secciones-configuracion,
    .permisos-configuracion {
        margin-bottom: 2rem;
    }

    .secciones-configuracion h4,
    .permisos-configuracion h4 {
        color: var(--primary-color);
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .secciones-grid-modal {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1rem;
    }

    .seccion-checkbox-modal {
        display: block;
        cursor: pointer;
    }

    .seccion-checkbox-modal input[type="checkbox"] {
        display: none;
    }

    .checkbox-content-modal {
        padding: 1rem;
        border: 2px solid var(--gray-300);
        border-radius: var(--border-radius);
        background: var(--white);
        transition: var(--transition);
    }

    .seccion-checkbox-modal input[type="checkbox"]:checked + .checkbox-content-modal {
        border-color: var(--primary-color);
        background: var(--primary-light);
    }

    .checkbox-content-modal i {
        color: var(--primary-color);
        font-size: 1.2rem;
        margin-bottom: 0.5rem;
    }

    .permisos-grid-modal {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1rem;
    }

    .permiso-checkbox-modal {
        display: block;
        cursor: pointer;
    }

    .permiso-checkbox-modal input[type="checkbox"] {
        display: none;
    }

    .permiso-content {
        padding: 1rem;
        border: 2px solid var(--gray-300);
        border-radius: var(--border-radius);
        background: var(--white);
        transition: var(--transition);
        text-align: center;
    }

    .permiso-checkbox-modal input[type="checkbox"]:checked + .permiso-content {
        border-color: var(--primary-color);
        background: var(--primary-light);
    }

    .permiso-content i {
        color: var(--primary-color);
        font-size: 1.5rem;
        margin-bottom: 0.5rem;
    }

    .permiso-content span {
        display: block;
        font-weight: 600;
        color: var(--gray-800);
        margin-bottom: 0.25rem;
    }

    .permiso-content small {
        color: var(--gray-600);
        font-size: 0.85rem;
    }

    .rol-preview {
        padding: 1.5rem;
        background: var(--gray-50);
        border-radius: var(--border-radius);
        border: 2px solid var(--gray-200);
    }

    @media (max-width: 1200px) {
        .roles-header {
            flex-direction: column;
            gap: 1.5rem;
        }

        .header-acciones {
            width: 100%;
            justify-content: center;
        }

        .roles-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 768px) {
        .estadisticas-roles {
            grid-template-columns: repeat(2, 1fr);
        }

        .secciones-grid {
            grid-template-columns: 1fr;
        }

        .form-grid {
            grid-template-columns: 1fr;
        }

        .secciones-grid-modal {
            grid-template-columns: 1fr;
        }

        .permisos-grid-modal {
            grid-template-columns: 1fr;
        }

        .secciones-analisis-grid {
            grid-template-columns: 1fr;
        }

        .rol-header {
            flex-direction: column;
            gap: 1rem;
        }

        .rol-acciones {
            justify-content: center;
        }
    }
</style>

<!-- ===================== SCRIPTS ESPECÍFICOS ===================== -->
<script>
    // Abrir modal para nuevo rol
    function abrirModalNuevoRol() {
        document.getElementById('modal-rol-titulo').innerHTML = '<i class="fas fa-user-tag"></i> Crear Nuevo Rol';
        document.getElementById('modal-rol').style.display = 'flex';
        actualizarPreviewRol();
    }

    // Cerrar modal de rol
    function cerrarModalRol() {
        document.getElementById('modal-rol').style.display = 'none';
        document.getElementById('form-rol').reset();
    }

    // Editar rol existente
    function editarRol(rolNombre) {
        document.getElementById('modal-rol-titulo').innerHTML = '<i class="fas fa-edit"></i> Editar Rol: ' + rolNombre;
        
        // Aquí cargarías los datos del rol seleccionado
        showNotification('Cargando datos del rol: ' + rolNombre, 'info');
        
        // Simular carga de datos
        setTimeout(() => {
            document.getElementById('modal-rol').style.display = 'flex';
            showNotification('Datos del rol cargados', 'success');
        }, 1000);
    }

    // Ver detalle del rol
    function verDetalleRol(rolNombre) {
        showNotification('Mostrando detalles del rol: ' + rolNombre, 'info');
        // Aquí mostrarías un modal con información detallada del rol
    }

    // Duplicar rol
    function duplicarRol(rolNombre) {
        if (confirm(`¿Crear una copia del rol "${rolNombre}"?`)) {
            showNotification('Duplicando rol...', 'info');
            
            setTimeout(() => {
                showNotification('Rol duplicado exitosamente', 'success');
                // Aquí recargarías la vista o actualizarías la lista
            }, 1500);
        }
    }

    // Eliminar rol
    function eliminarRol(rolNombre) {
        if (confirm(`¿ELIMINAR el rol "${rolNombre}"?\n\nEsta acción NO se puede deshacer.`)) {
            showNotification('Eliminando rol...', 'warning');
            
            setTimeout(() => {
                showNotification('Rol eliminado exitosamente', 'success');
                location.reload();
            }, 2000);
        }
    }

    // Actualizar vista previa del rol
    function actualizarPreviewRol() {
        const nombreRol = document.getElementById('nombre-rol').value;
        const colorRol = document.getElementById('color-rol').value;
        const descripcionRol = document.getElementById('descripcion-rol').value;
        
        const seccionesSeleccionadas = Array.from(document.querySelectorAll('input[name="secciones_rol[]"]:checked'))
            .map(checkbox => checkbox.value);
        
        const permisosSeleccionados = Array.from(document.querySelectorAll('input[name="permisos_rol[]"]:checked'))
            .map(checkbox => checkbox.value);
        
        const preview = document.getElementById('preview-rol');
        
        if (nombreRol && descripcionRol) {
            preview.innerHTML = `
                <div class="rol-preview-card">
                    <div class="rol-preview-header" style="border-left: 4px solid ${colorRol};">
                        <h4>${nombreRol}</h4>
                        <p>${descripcionRol}</p>
                        <div class="preview-badges">
                            <span class="badge" style="background: ${colorRol};">${seccionesSeleccionadas.length} secciones</span>
                            <span class="badge badge-secondary">${permisosSeleccionados.length} permisos</span>
                        </div>
                    </div>
                    
                    <div class="preview-secciones">
                        <h5>Secciones:</h5>
                        <div class="secciones-preview">
                            ${seccionesSeleccionadas.map(seccion => `
                                <span class="seccion-preview-badge">${seccion}</span>
                            `).join('')}
                        </div>
                    </div>
                    
                    <div class="preview-permisos">
                        <h5>Permisos:</h5>
                        <div class="permisos-preview">
                            ${permisosSeleccionados.map(permiso => `
                                <span class="permiso-preview-badge">${permiso}</span>
                            `).join('')}
                        </div>
                    </div>
                </div>
            `;
        } else {
            preview.innerHTML = '<p class="text-muted">Configure el rol para ver la vista previa</p>';
        }
    }

    // Guardar rol
    function guardarRol() {
        const form = document.getElementById('form-rol');
        
        if (form.checkValidity()) {
            const nombreRol = document.getElementById('nombre-rol').value;
            
            showNotification('Guardando rol...', 'info');
            
            setTimeout(() => {
                showNotification(`Rol "${nombreRol}" guardado exitosamente`, 'success');
                cerrarModalRol();
                location.reload();
            }, 2000);
        } else {
            showNotification('Por favor complete todos los campos requeridos', 'error');
        }
    }

    // Exportar roles
    function exportarRoles() {
        showNotification('Generando archivo de configuración...', 'info');
        
        setTimeout(() => {
            showNotification('Configuración de roles exportada', 'success');
        }, 2000);
    }

    // Event listeners para actualizar vista previa
    document.addEventListener('DOMContentLoaded', function() {
        // Agregar listeners a los campos del formulario
        ['nombre-rol', 'color-rol', 'descripcion-rol'].forEach(id => {
            const element = document.getElementById(id);
            if (element) {
                element.addEventListener('input', actualizarPreviewRol);
            }
        });
        
        // Listeners para checkboxes
        document.addEventListener('change', function(e) {
            if (e.target.name === 'secciones_rol[]' || e.target.name === 'permisos_rol[]') {
                actualizarPreviewRol();
            }
        });
    });
</script>

<style>
    .rol-preview-card {
        border: 2px solid var(--gray-200);
        border-radius: var(--border-radius);
        background: var(--white);
        overflow: hidden;
    }

    .rol-preview-header {
        padding: 1rem;
        background: var(--gray-50);
        border-bottom: 1px solid var(--gray-200);
    }

    .rol-preview-header h4 {
        margin: 0 0 0.5rem 0;
        color: var(--gray-800);
    }

    .rol-preview-header p {
        margin: 0 0 1rem 0;
        color: var(--gray-600);
        font-size: 0.9rem;
    }

    .preview-badges {
        display: flex;
        gap: 0.5rem;
    }

    .preview-secciones,
    .preview-permisos {
        padding: 1rem;
        border-bottom: 1px solid var(--gray-200);
    }

    .preview-permisos {
        border-bottom: none;
    }

    .preview-secciones h5,
    .preview-permisos h5 {
        margin: 0 0 0.75rem 0;
        color: var(--gray-700);
        font-size: 0.9rem;
    }

    .secciones-preview,
    .permisos-preview {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
    }

    .seccion-preview-badge,
    .permiso-preview-badge {
        padding: 0.3rem 0.6rem;
        background: var(--primary-light);
        color: var(--primary-color);
        border-radius: 15px;
        font-size: 0.75rem;
        border: 1px solid var(--primary-color);
    }

    .permiso-preview-badge {
        background: var(--info-light);
        color: var(--info-color);
        border-color: var(--info-color);
    }
</style>
