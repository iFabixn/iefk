<!-- ===================== LISTA DE USUARIOS REGISTRADOS ===================== -->
<div class="usuarios-lista">
    <!-- Header con estadísticas y acciones -->
    <div class="usuarios-header">
        <div class="estadisticas-usuarios">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-number"><?= count($usuarios_registrados) ?></div>
                    <div class="stat-label">Total Usuarios</div>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon activo">
                    <i class="fas fa-user-check"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-number">
                        <?= count(array_filter($usuarios_registrados, fn($u) => $u['estado'] === 'activo')) ?>
                    </div>
                    <div class="stat-label">Usuarios Activos</div>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon pendiente">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-number">
                        <?= count(array_filter($usuarios_registrados, fn($u) => $u['estado'] === 'pendiente')) ?>
                    </div>
                    <div class="stat-label">Pendientes</div>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon roles">
                    <i class="fas fa-user-tag"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-number"><?= count($roles_predefinidos) ?></div>
                    <div class="stat-label">Roles Disponibles</div>
                </div>
            </div>
        </div>
        
        <div class="acciones-principales">
            <button class="btn btn-primary" onclick="abrirModalInvitar()">
                <i class="fas fa-user-plus"></i> Invitar Usuario
            </button>
            <button class="btn btn-success" onclick="exportarUsuarios()">
                <i class="fas fa-file-excel"></i> Exportar
            </button>
            <button class="btn btn-warning" onclick="abrirModalRoles()">
                <i class="fas fa-user-tag"></i> Gestionar Roles
            </button>
        </div>
    </div>

    <!-- Filtros y búsqueda -->
    <div class="filtros-usuarios">
        <h3><i class="fas fa-filter"></i> Filtros y Búsqueda</h3>
        <div class="filtros-grid">
            <div class="filtro-item">
                <label for="busqueda-usuario">Buscar usuario:</label>
                <input type="text" id="busqueda-usuario" placeholder="Nombre o email..." 
                       value="<?= htmlspecialchars($busqueda) ?>" onkeyup="aplicarFiltros()">
            </div>
            
            <div class="filtro-item">
                <label for="filtro-rol-usuario">Rol:</label>
                <select id="filtro-rol-usuario" onchange="aplicarFiltros()">
                    <option value="todos">Todos los roles</option>
                    <?php foreach (array_keys($roles_predefinidos) as $rol): ?>
                    <option value="<?= $rol ?>" <?= $filtro_rol === $rol ? 'selected' : '' ?>>
                        <?= $rol ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="filtro-item">
                <label for="filtro-estado-usuario">Estado:</label>
                <select id="filtro-estado-usuario" onchange="aplicarFiltros()">
                    <option value="todos">Todos los estados</option>
                    <option value="activo" <?= $filtro_estado === 'activo' ? 'selected' : '' ?>>Activo</option>
                    <option value="inactivo" <?= $filtro_estado === 'inactivo' ? 'selected' : '' ?>>Inactivo</option>
                    <option value="pendiente" <?= $filtro_estado === 'pendiente' ? 'selected' : '' ?>>Pendiente</option>
                    <option value="suspendido" <?= $filtro_estado === 'suspendido' ? 'selected' : '' ?>>Suspendido</option>
                </select>
            </div>
            
            <div class="filtro-item">
                <label for="filtro-plantel-usuario">Plantel:</label>
                <select id="filtro-plantel-usuario" onchange="aplicarFiltros()">
                    <option value="todos">Todos los planteles</option>
                    <option value="El Zapote" <?= $filtro_plantel === 'El Zapote' ? 'selected' : '' ?>>El Zapote</option>
                    <option value="Insurgentes" <?= $filtro_plantel === 'Insurgentes' ? 'selected' : '' ?>>Insurgentes</option>
                    <option value="Lindavista" <?= $filtro_plantel === 'Lindavista' ? 'selected' : '' ?>>Lindavista</option>
                </select>
            </div>
            
            <div class="filtro-acciones">
                <button class="btn btn-secondary" onclick="limpiarFiltros()">
                    <i class="fas fa-eraser"></i> Limpiar
                </button>
                <button class="btn btn-info" onclick="buscarAvanzado()">
                    <i class="fas fa-search"></i> Buscar
                </button>
            </div>
        </div>
    </div>

    <!-- Lista de usuarios -->
    <div class="usuarios-grid">
        <?php if (empty($usuarios_filtrados)): ?>
        <div class="empty-state">
            <i class="fas fa-users fa-3x"></i>
            <h3>No se encontraron usuarios</h3>
            <p>No hay usuarios que coincidan con los filtros seleccionados.</p>
            <button class="btn btn-primary" onclick="abrirModalInvitar()">
                <i class="fas fa-user-plus"></i> Invitar Primer Usuario
            </button>
        </div>
        <?php else: ?>
            <?php foreach ($usuarios_filtrados as $usuario): ?>
            <div class="usuario-card">
                <!-- Header del usuario -->
                <div class="usuario-header">
                    <div class="usuario-avatar">
                        <?php if ($usuario['foto_perfil']): ?>
                        <img src="../uploads/perfiles/<?= $usuario['foto_perfil'] ?>" alt="<?= $usuario['nombre'] ?>">
                        <?php else: ?>
                        <i class="fas fa-user"></i>
                        <?php endif; ?>
                    </div>
                    
                    <div class="usuario-info">
                        <h4><?= $usuario['nombre'] ?></h4>
                        <p><?= $usuario['email'] ?></p>
                        <div class="usuario-badges">
                            <span class="badge badge-<?= obtenerColorEstado($usuario['estado']) ?>">
                                <i class="<?= obtenerIconoEstado($usuario['estado']) ?>"></i>
                                <?= ucfirst($usuario['estado']) ?>
                            </span>
                            <span class="badge" style="background: <?= $roles_predefinidos[$usuario['rol']]['color'] ?? '#6b7280' ?>;">
                                <?= $usuario['rol'] ?>
                            </span>
                        </div>
                    </div>
                    
                    <div class="usuario-acciones">
                        <button class="btn btn-sm btn-primary" onclick="editarUsuario('<?= $usuario['id'] ?>')">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-info" onclick="verDetalleUsuario('<?= $usuario['id'] ?>')">
                            <i class="fas fa-eye"></i>
                        </button>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-secondary dropdown-toggle" onclick="toggleDropdown('<?= $usuario['id'] ?>')">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                            <div class="dropdown-menu" id="dropdown-<?= $usuario['id'] ?>">
                                <a href="#" onclick="cambiarEstado('<?= $usuario['id'] ?>', 'activo')">
                                    <i class="fas fa-check"></i> Activar
                                </a>
                                <a href="#" onclick="cambiarEstado('<?= $usuario['id'] ?>', 'suspendido')">
                                    <i class="fas fa-ban"></i> Suspender
                                </a>
                                <a href="#" onclick="resetearPassword('<?= $usuario['id'] ?>')">
                                    <i class="fas fa-key"></i> Resetear Contraseña
                                </a>
                                <a href="#" onclick="enviarInvitacion('<?= $usuario['id'] ?>')">
                                    <i class="fas fa-envelope"></i> Reenviar Invitación
                                </a>
                                <a href="#" onclick="eliminarUsuario('<?= $usuario['id'] ?>')" class="text-danger">
                                    <i class="fas fa-trash"></i> Eliminar
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Información detallada -->
                <div class="usuario-detalles">
                    <div class="detalle-item">
                        <i class="fas fa-phone"></i>
                        <span><?= $usuario['telefono'] ?: 'No registrado' ?></span>
                    </div>
                    <div class="detalle-item">
                        <i class="fas fa-building"></i>
                        <span><?= $usuario['plantel_asignado'] ?></span>
                    </div>
                    <div class="detalle-item">
                        <i class="fas fa-calendar"></i>
                        <span>Registrado: <?= date('d/m/Y', strtotime($usuario['fecha_registro'])) ?></span>
                    </div>
                    <div class="detalle-item">
                        <i class="fas fa-clock"></i>
                        <span>
                            Último acceso: 
                            <?= $usuario['ultimo_acceso'] ? date('d/m/Y H:i', strtotime($usuario['ultimo_acceso'])) : 'Nunca' ?>
                        </span>
                    </div>
                </div>

                <!-- Secciones asignadas -->
                <div class="secciones-asignadas">
                    <h5><i class="fas fa-key"></i> Accesos Asignados</h5>
                    <div class="secciones-grid">
                        <?php foreach ($usuario['secciones_asignadas'] as $seccion_id): ?>
                            <?php if (isset($secciones_disponibles[$seccion_id])): ?>
                            <div class="seccion-badge">
                                <i class="<?= $secciones_disponibles[$seccion_id]['icono'] ?>"></i>
                                <span><?= $secciones_disponibles[$seccion_id]['nombre'] ?></span>
                            </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Permisos especiales -->
                <div class="permisos-especiales">
                    <h5><i class="fas fa-shield-alt"></i> Permisos</h5>
                    <div class="permisos-list">
                        <?php foreach ($usuario['permisos_especiales'] as $permiso): ?>
                        <span class="permiso-badge permiso-<?= $permiso ?>"><?= ucfirst($permiso) ?></span>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Notas -->
                <?php if ($usuario['notas']): ?>
                <div class="usuario-notas">
                    <h5><i class="fas fa-sticky-note"></i> Notas</h5>
                    <p><?= htmlspecialchars($usuario['notas']) ?></p>
                </div>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<!-- Modal para Invitar Usuario -->
<div id="modal-invitar-usuario" class="modal" style="display: none;">
    <div class="modal-content modal-lg">
        <div class="modal-header">
            <h3><i class="fas fa-user-plus"></i> Invitar Nuevo Usuario</h3>
            <span class="modal-close" onclick="cerrarModalInvitar()">&times;</span>
        </div>
        <div class="modal-body">
            <form id="form-invitar-usuario">
                <div class="form-grid">
                    <div class="form-group">
                        <label for="nombre-usuario">Nombre Completo *</label>
                        <input type="text" id="nombre-usuario" required placeholder="Ej: María García López">
                    </div>
                    
                    <div class="form-group">
                        <label for="email-usuario">Correo Electrónico *</label>
                        <input type="email" id="email-usuario" required placeholder="usuario@iefk.edu.mx">
                    </div>
                    
                    <div class="form-group">
                        <label for="telefono-usuario">Teléfono</label>
                        <input type="tel" id="telefono-usuario" placeholder="+52 55 1234 5678">
                    </div>
                    
                    <div class="form-group">
                        <label for="rol-usuario">Rol *</label>
                        <select id="rol-usuario" required onchange="actualizarSeccionesRol()">
                            <option value="">Seleccionar rol</option>
                            <?php foreach ($roles_predefinidos as $rol_nombre => $rol_data): ?>
                            <option value="<?= $rol_nombre ?>"><?= $rol_nombre ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="plantel-usuario">Plantel Asignado *</label>
                        <select id="plantel-usuario" required>
                            <option value="">Seleccionar plantel</option>
                            <option value="El Zapote">El Zapote</option>
                            <option value="Insurgentes">Insurgentes</option>
                            <option value="Lindavista">Lindavista</option>
                            <option value="Todos">Todos los planteles</option>
                        </select>
                    </div>
                </div>
                
                <div class="secciones-seleccion">
                    <h4><i class="fas fa-key"></i> Secciones de Acceso</h4>
                    <p class="text-muted">Selecciona las secciones a las que tendrá acceso este usuario</p>
                    <div class="secciones-checkbox-grid" id="secciones-disponibles">
                        <?php foreach ($secciones_disponibles as $seccion_id => $seccion): ?>
                        <label class="seccion-checkbox">
                            <input type="checkbox" name="secciones[]" value="<?= $seccion_id ?>">
                            <div class="checkbox-content">
                                <i class="<?= $seccion['icono'] ?>"></i>
                                <span class="seccion-nombre"><?= $seccion['nombre'] ?></span>
                                <small class="seccion-descripcion"><?= $seccion['descripcion'] ?></small>
                            </div>
                        </label>
                        <?php endforeach; ?>
                    </div>
                </div>
                
                <div class="permisos-seleccion">
                    <h4><i class="fas fa-shield-alt"></i> Permisos Especiales</h4>
                    <div class="permisos-checkbox-grid">
                        <label class="permiso-checkbox">
                            <input type="checkbox" name="permisos[]" value="crear">
                            <span>Crear registros</span>
                        </label>
                        <label class="permiso-checkbox">
                            <input type="checkbox" name="permisos[]" value="editar">
                            <span>Editar registros</span>
                        </label>
                        <label class="permiso-checkbox">
                            <input type="checkbox" name="permisos[]" value="eliminar">
                            <span>Eliminar registros</span>
                        </label>
                        <label class="permiso-checkbox">
                            <input type="checkbox" name="permisos[]" value="ver">
                            <span>Ver información</span>
                        </label>
                        <label class="permiso-checkbox">
                            <input type="checkbox" name="permisos[]" value="exportar">
                            <span>Exportar datos</span>
                        </label>
                        <label class="permiso-checkbox">
                            <input type="checkbox" name="permisos[]" value="administrar">
                            <span>Administrar sistema</span>
                        </label>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="notas-usuario">Notas Adicionales</label>
                    <textarea id="notas-usuario" rows="3" 
                              placeholder="Información adicional sobre el usuario, responsabilidades específicas, etc."></textarea>
                </div>
                
                <div class="mensaje-invitacion">
                    <h4><i class="fas fa-envelope"></i> Mensaje de Invitación</h4>
                    <textarea id="mensaje-personalizado" rows="4" 
                              placeholder="Mensaje personalizado para incluir en la invitación...">Te damos la bienvenida al sistema del Instituto Educativo Frida Kahlo. Has sido invitado a formar parte de nuestro equipo con acceso a las herramientas necesarias para tu trabajo. 

Por favor, haz clic en el enlace que recibirás para completar tu registro.</textarea>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button class="btn btn-secondary" onclick="cerrarModalInvitar()">Cancelar</button>
            <button class="btn btn-primary" onclick="enviarInvitacionUsuario()">
                <i class="fas fa-paper-plane"></i> Enviar Invitación
            </button>
        </div>
    </div>
</div>

<!-- ===================== ESTILOS ESPECÍFICOS ===================== -->
<style>
    .usuarios-lista {
        display: flex;
        flex-direction: column;
        gap: 2rem;
    }

    .usuarios-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 2rem;
        margin-bottom: 2rem;
    }

    .estadisticas-usuarios {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1.5rem;
        flex: 1;
    }

    .stat-card {
        background: var(--white);
        padding: 1.5rem;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        border: 2px solid var(--gray-200);
        display: flex;
        align-items: center;
        gap: 1rem;
        transition: var(--transition);
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-hover);
    }

    .stat-icon {
        width: 50px;
        height: 50px;
        background: var(--primary-color);
        color: var(--white);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
    }

    .stat-icon.activo {
        background: var(--success-color);
    }

    .stat-icon.pendiente {
        background: var(--warning-color);
    }

    .stat-icon.roles {
        background: var(--info-color);
    }

    .stat-number {
        font-size: 1.8rem;
        font-weight: 700;
        color: var(--gray-800);
        line-height: 1;
    }

    .stat-label {
        color: var(--gray-600);
        font-size: 0.9rem;
    }

    .acciones-principales {
        display: flex;
        gap: 1rem;
        flex-shrink: 0;
    }

    .filtros-usuarios {
        background: var(--white);
        padding: 1.5rem;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        border: 2px solid var(--secondary-color);
    }

    .filtros-usuarios h3 {
        color: var(--primary-color);
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .filtros-grid {
        display: grid;
        grid-template-columns: 2fr 1fr 1fr 1fr auto;
        gap: 1.5rem;
        align-items: end;
    }

    .filtro-item {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .filtro-item label {
        font-weight: 600;
        color: var(--gray-700);
        font-size: 0.9rem;
    }

    .filtro-item input,
    .filtro-item select {
        padding: 0.75rem;
        border: 2px solid var(--gray-300);
        border-radius: var(--border-radius);
        font-size: 1rem;
        background: var(--white);
    }

    .filtro-acciones {
        display: flex;
        gap: 1rem;
    }

    .usuarios-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(400px, 1fr));
        gap: 2rem;
    }

    .usuario-card {
        background: var(--white);
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        border: 2px solid var(--gray-200);
        overflow: hidden;
        transition: var(--transition);
    }

    .usuario-card:hover {
        border-color: var(--primary-color);
        box-shadow: var(--shadow-hover);
        transform: translateY(-2px);
    }

    .usuario-header {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1.5rem;
        background: var(--gray-50);
        border-bottom: 2px solid var(--gray-200);
    }

    .usuario-avatar {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        overflow: hidden;
        background: var(--gray-300);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--gray-600);
        font-size: 1.5rem;
        flex-shrink: 0;
    }

    .usuario-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .usuario-info {
        flex: 1;
    }

    .usuario-info h4 {
        margin: 0 0 0.25rem 0;
        color: var(--gray-800);
        font-size: 1.1rem;
    }

    .usuario-info p {
        margin: 0 0 0.5rem 0;
        color: var(--gray-600);
        font-size: 0.9rem;
    }

    .usuario-badges {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .usuario-acciones {
        display: flex;
        gap: 0.5rem;
        position: relative;
    }

    .dropdown {
        position: relative;
    }

    .dropdown-menu {
        position: absolute;
        top: 100%;
        right: 0;
        background: var(--white);
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-hover);
        border: 2px solid var(--gray-200);
        min-width: 200px;
        z-index: 100;
        display: none;
    }

    .dropdown-menu.show {
        display: block;
    }

    .dropdown-menu a {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem 1rem;
        text-decoration: none;
        color: var(--gray-700);
        border-bottom: 1px solid var(--gray-200);
        transition: var(--transition);
    }

    .dropdown-menu a:hover {
        background: var(--gray-50);
    }

    .dropdown-menu a:last-child {
        border-bottom: none;
    }

    .dropdown-menu a.text-danger {
        color: var(--danger-color);
    }

    .usuario-detalles {
        padding: 1rem 1.5rem;
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    .detalle-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        color: var(--gray-600);
        font-size: 0.9rem;
    }

    .detalle-item i {
        color: var(--primary-color);
        width: 16px;
    }

    .secciones-asignadas {
        padding: 1rem 1.5rem;
        border-top: 2px solid var(--gray-200);
    }

    .secciones-asignadas h5 {
        color: var(--gray-700);
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.95rem;
    }

    .secciones-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
    }

    .seccion-badge {
        background: var(--primary-light);
        color: var(--primary-color);
        padding: 0.4rem 0.8rem;
        border-radius: 20px;
        font-size: 0.8rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        border: 1px solid var(--primary-color);
    }

    .permisos-especiales {
        padding: 1rem 1.5rem;
        border-top: 2px solid var(--gray-200);
    }

    .permisos-especiales h5 {
        color: var(--gray-700);
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.95rem;
    }

    .permisos-list {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
    }

    .permiso-badge {
        padding: 0.3rem 0.6rem;
        border-radius: 15px;
        font-size: 0.75rem;
        font-weight: 600;
        color: var(--white);
    }

    .permiso-crear {
        background: var(--success-color);
    }

    .permiso-editar {
        background: var(--info-color);
    }

    .permiso-eliminar {
        background: var(--danger-color);
    }

    .permiso-ver {
        background: var(--warning-color);
    }

    .permiso-exportar {
        background: var(--primary-color);
    }

    .permiso-administrar {
        background: var(--gray-800);
    }

    .permiso-editar_limitado {
        background: var(--secondary-color);
    }

    .permiso-crear_tickets {
        background: var(--accent-color);
    }

    .usuario-notas {
        padding: 1rem 1.5rem;
        border-top: 2px solid var(--gray-200);
        background: var(--gray-50);
    }

    .usuario-notas h5 {
        color: var(--gray-700);
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.95rem;
    }

    .usuario-notas p {
        margin: 0;
        color: var(--gray-600);
        font-size: 0.9rem;
        font-style: italic;
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .form-group label {
        font-weight: 600;
        color: var(--gray-700);
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
        padding: 0.75rem;
        border: 2px solid var(--gray-300);
        border-radius: var(--border-radius);
        font-size: 1rem;
        background: var(--white);
    }

    .secciones-seleccion,
    .permisos-seleccion {
        margin-bottom: 2rem;
    }

    .secciones-seleccion h4,
    .permisos-seleccion h4 {
        color: var(--primary-color);
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .text-muted {
        color: var(--gray-500);
        font-size: 0.9rem;
        margin-bottom: 1rem;
    }

    .secciones-checkbox-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1rem;
    }

    .seccion-checkbox {
        display: block;
        cursor: pointer;
    }

    .seccion-checkbox input[type="checkbox"] {
        display: none;
    }

    .checkbox-content {
        padding: 1rem;
        border: 2px solid var(--gray-300);
        border-radius: var(--border-radius);
        background: var(--white);
        transition: var(--transition);
    }

    .seccion-checkbox input[type="checkbox"]:checked + .checkbox-content {
        border-color: var(--primary-color);
        background: var(--primary-light);
    }

    .checkbox-content i {
        color: var(--primary-color);
        font-size: 1.2rem;
        margin-bottom: 0.5rem;
    }

    .seccion-nombre {
        display: block;
        font-weight: 600;
        color: var(--gray-800);
        margin-bottom: 0.25rem;
    }

    .seccion-descripcion {
        color: var(--gray-600);
        font-size: 0.85rem;
    }

    .permisos-checkbox-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1rem;
    }

    .permiso-checkbox {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem;
        border: 2px solid var(--gray-300);
        border-radius: var(--border-radius);
        background: var(--white);
        cursor: pointer;
        transition: var(--transition);
    }

    .permiso-checkbox:hover {
        border-color: var(--primary-color);
        background: var(--primary-light);
    }

    .permiso-checkbox input[type="checkbox"] {
        width: 18px;
        height: 18px;
        accent-color: var(--primary-color);
    }

    .mensaje-invitacion {
        background: var(--gray-50);
        padding: 1.5rem;
        border-radius: var(--border-radius);
        border: 2px solid var(--gray-200);
    }

    .mensaje-invitacion h4 {
        color: var(--primary-color);
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .empty-state {
        grid-column: 1 / -1;
        text-align: center;
        padding: 4rem 2rem;
        color: var(--gray-600);
    }

    .empty-state i {
        color: var(--gray-400);
        margin-bottom: 1.5rem;
    }

    @media (max-width: 1200px) {
        .usuarios-header {
            flex-direction: column;
            align-items: stretch;
        }

        .estadisticas-usuarios {
            grid-template-columns: repeat(2, 1fr);
        }

        .acciones-principales {
            justify-content: center;
        }
    }

    @media (max-width: 768px) {
        .filtros-grid {
            grid-template-columns: 1fr;
            gap: 1rem;
        }

        .filtro-acciones {
            justify-content: stretch;
            flex-direction: column;
        }

        .usuarios-grid {
            grid-template-columns: 1fr;
        }

        .estadisticas-usuarios {
            grid-template-columns: 1fr;
        }

        .form-grid {
            grid-template-columns: 1fr;
        }

        .secciones-checkbox-grid {
            grid-template-columns: 1fr;
        }

        .permisos-checkbox-grid {
            grid-template-columns: 1fr;
        }

        .acciones-principales {
            flex-direction: column;
        }

        .usuario-header {
            flex-direction: column;
            text-align: center;
            gap: 1rem;
        }

        .usuario-acciones {
            justify-content: center;
        }
    }
</style>

<!-- ===================== SCRIPTS ESPECÍFICOS ===================== -->
<script>
    // Variables globales
    let dropdownActual = null;

    // Aplicar filtros
    function aplicarFiltros() {
        const busqueda = document.getElementById('busqueda-usuario').value;
        const rol = document.getElementById('filtro-rol-usuario').value;
        const estado = document.getElementById('filtro-estado-usuario').value;
        const plantel = document.getElementById('filtro-plantel-usuario').value;
        
        const params = new URLSearchParams(window.location.search);
        
        if (busqueda) params.set('busqueda', busqueda);
        else params.delete('busqueda');
        
        if (rol !== 'todos') params.set('rol', rol);
        else params.delete('rol');
        
        if (estado !== 'todos') params.set('estado', estado);
        else params.delete('estado');
        
        if (plantel !== 'todos') params.set('plantel', plantel);
        else params.delete('plantel');
        
        // Aplicar filtros con debounce para la búsqueda
        if (busqueda) {
            clearTimeout(window.filtroTimeout);
            window.filtroTimeout = setTimeout(() => {
                window.location.search = params.toString();
            }, 500);
        } else {
            window.location.search = params.toString();
        }
    }

    // Limpiar filtros
    function limpiarFiltros() {
        const params = new URLSearchParams(window.location.search);
        params.delete('busqueda');
        params.delete('rol');
        params.delete('estado');
        params.delete('plantel');
        window.location.search = params.toString();
    }

    // Búsqueda avanzada
    function buscarAvanzado() {
        showNotification('Aplicando filtros de búsqueda...', 'info');
        aplicarFiltros();
    }

    // Toggle dropdown
    function toggleDropdown(usuarioId) {
        const dropdown = document.getElementById(`dropdown-${usuarioId}`);
        
        // Cerrar dropdown anterior
        if (dropdownActual && dropdownActual !== dropdown) {
            dropdownActual.classList.remove('show');
        }
        
        dropdown.classList.toggle('show');
        dropdownActual = dropdown.classList.contains('show') ? dropdown : null;
    }

    // Cerrar dropdowns al hacer clic fuera
    document.addEventListener('click', function(event) {
        if (!event.target.closest('.dropdown')) {
            document.querySelectorAll('.dropdown-menu').forEach(menu => {
                menu.classList.remove('show');
            });
            dropdownActual = null;
        }
    });

    // Abrir modal para invitar usuario
    function abrirModalInvitar() {
        document.getElementById('modal-invitar-usuario').style.display = 'flex';
    }

    // Cerrar modal de invitación
    function cerrarModalInvitar() {
        document.getElementById('modal-invitar-usuario').style.display = 'none';
        document.getElementById('form-invitar-usuario').reset();
    }

    // Actualizar secciones según rol seleccionado
    function actualizarSeccionesRol() {
        const rolSelect = document.getElementById('rol-usuario');
        const rolSeleccionado = rolSelect.value;
        
        // Datos de roles (estos vendrían del PHP)
        const rolesData = <?= json_encode($roles_predefinidos) ?>;
        
        if (rolSeleccionado && rolesData[rolSeleccionado]) {
            const seccionesRol = rolesData[rolSeleccionado].secciones;
            const permisosRol = rolesData[rolSeleccionado].permisos;
            
            // Actualizar checkboxes de secciones
            document.querySelectorAll('input[name="secciones[]"]').forEach(checkbox => {
                checkbox.checked = seccionesRol.includes(checkbox.value);
            });
            
            // Actualizar checkboxes de permisos
            document.querySelectorAll('input[name="permisos[]"]').forEach(checkbox => {
                checkbox.checked = permisosRol.includes(checkbox.value);
            });
            
            showNotification(`Secciones y permisos actualizados para el rol: ${rolSeleccionado}`, 'info');
        }
    }

    // Enviar invitación de usuario
    function enviarInvitacionUsuario() {
        const form = document.getElementById('form-invitar-usuario');
        
        if (form.checkValidity()) {
            const nombre = document.getElementById('nombre-usuario').value;
            const email = document.getElementById('email-usuario').value;
            
            showNotification('Enviando invitación...', 'info');
            
            // Aquí enviarías los datos al servidor
            setTimeout(() => {
                showNotification(`Invitación enviada exitosamente a ${nombre} (${email})`, 'success');
                cerrarModalInvitar();
                // Recargar la página o actualizar la lista
                setTimeout(() => location.reload(), 1500);
            }, 2000);
        } else {
            showNotification('Por favor complete todos los campos requeridos', 'error');
        }
    }

    // Editar usuario
    function editarUsuario(usuarioId) {
        showNotification('Abriendo editor de usuario...', 'info');
        // Aquí abrirías el modal de edición con los datos precargados
        setTimeout(() => {
            abrirModalInvitar(); // Por ahora reutilizamos el modal
            showNotification('Cargando datos del usuario...', 'info');
        }, 500);
    }

    // Ver detalle de usuario
    function verDetalleUsuario(usuarioId) {
        showNotification('Cargando detalles del usuario...', 'info');
        // Aquí mostrarías un modal con todos los detalles del usuario
    }

    // Cambiar estado de usuario
    function cambiarEstado(usuarioId, nuevoEstado) {
        if (confirm(`¿Confirmar cambio de estado a "${nuevoEstado}"?`)) {
            showNotification(`Cambiando estado a ${nuevoEstado}...`, 'info');
            
            setTimeout(() => {
                showNotification(`Estado actualizado exitosamente`, 'success');
                location.reload();
            }, 1500);
        }
    }

    // Resetear contraseña
    function resetearPassword(usuarioId) {
        if (confirm('¿Enviar email para resetear contraseña?')) {
            showNotification('Enviando email de recuperación...', 'info');
            
            setTimeout(() => {
                showNotification('Email de recuperación enviado', 'success');
            }, 1500);
        }
    }

    // Reenviar invitación
    function enviarInvitacion(usuarioId) {
        if (confirm('¿Reenviar invitación al usuario?')) {
            showNotification('Reenviando invitación...', 'info');
            
            setTimeout(() => {
                showNotification('Invitación reenviada exitosamente', 'success');
            }, 1500);
        }
    }

    // Eliminar usuario
    function eliminarUsuario(usuarioId) {
        if (confirm('¿ELIMINAR PERMANENTEMENTE este usuario?\n\nEsta acción NO se puede deshacer.')) {
            showNotification('Eliminando usuario...', 'warning');
            
            setTimeout(() => {
                showNotification('Usuario eliminado exitosamente', 'success');
                location.reload();
            }, 2000);
        }
    }

    // Exportar usuarios
    function exportarUsuarios() {
        showNotification('Generando archivo de exportación...', 'info');
        
        setTimeout(() => {
            showNotification('Archivo exportado exitosamente', 'success');
        }, 2000);
    }

    // Abrir modal de roles
    function abrirModalRoles() {
        showNotification('Abriendo gestión de roles...', 'info');
        // Redireccionar a la vista de roles
        window.location.href = '?vista=roles';
    }
</script>
