<?php
include_once '../db.php';

// Verificar que el usuario actual sea el dueño/administrador
// Esta verificación debería implementarse según tu sistema de autenticación

// Obtener la vista actual
$vista = $_GET['vista'] ?? 'usuarios';

// Datos de ejemplo para usuarios registrados
$usuarios_registrados = [
    [
        'id' => 'USR001',
        'nombre' => 'María García López',
        'email' => 'maria.garcia@iefk.edu.mx',
        'telefono' => '+52 55 1234 5678',
        'rol' => 'Coordinador Académico',
        'estado' => 'activo',
        'fecha_registro' => '2024-01-15',
        'ultimo_acceso' => '2024-01-20 09:30:00',
        'foto_perfil' => 'maria_garcia.jpg',
        'secciones_asignadas' => ['students', 'staff', 'admissions', 'attendance'],
        'permisos_especiales' => ['crear', 'editar', 'eliminar'],
        'plantel_asignado' => 'El Zapote',
        'invitado_por' => 'Admin Principal',
        'notas' => 'Coordinadora con experiencia en gestión académica'
    ],
    [
        'id' => 'USR002',
        'nombre' => 'Carlos Rodríguez Méndez',
        'email' => 'carlos.rodriguez@iefk.edu.mx',
        'telefono' => '+52 55 2345 6789',
        'rol' => 'Maestro',
        'estado' => 'activo',
        'fecha_registro' => '2024-01-10',
        'ultimo_acceso' => '2024-01-20 08:15:00',
        'foto_perfil' => 'carlos_rodriguez.jpg',
        'secciones_asignadas' => ['students', 'attendance'],
        'permisos_especiales' => ['ver', 'editar_limitado'],
        'plantel_asignado' => 'Insurgentes',
        'invitado_por' => 'María García López',
        'notas' => 'Maestro de 3er grado, especialista en matemáticas'
    ],
    [
        'id' => 'USR003',
        'nombre' => 'Ana Patricia Fernández',
        'email' => 'ana.fernandez@iefk.edu.mx',
        'telefono' => '+52 55 3456 7890',
        'rol' => 'Secretaria Administrativa',
        'estado' => 'pendiente',
        'fecha_registro' => '2024-01-18',
        'ultimo_acceso' => null,
        'foto_perfil' => null,
        'secciones_asignadas' => ['admissions', 'finances'],
        'permisos_especiales' => ['ver', 'crear', 'editar'],
        'plantel_asignado' => 'Lindavista',
        'invitado_por' => 'Admin Principal',
        'notas' => 'Pendiente de confirmar invitación'
    ]
];

// Definir todas las secciones disponibles
$secciones_disponibles = [
    'students' => [
        'nombre' => 'Gestión de Estudiantes',
        'icono' => 'fas fa-user-graduate',
        'descripcion' => 'Administración completa de alumnos, fichas y expedientes',
        'url' => 'students.php'
    ],
    'staff' => [
        'nombre' => 'Gestión de Personal',
        'icono' => 'fas fa-users',
        'descripcion' => 'Control de empleados, nóminas y expedientes laborales',
        'url' => 'staff.php'
    ],
    'admissions' => [
        'nombre' => 'Sistema de Admisiones',
        'icono' => 'fas fa-clipboard-list',
        'descripcion' => 'Proceso de inscripciones y admisiones nuevas',
        'url' => 'admissions.php'
    ],
    'attendance' => [
        'nombre' => 'Control QR Asistencias',
        'icono' => 'fas fa-qrcode',
        'descripcion' => 'Sistema de control de entradas y salidas con QR',
        'url' => 'attendance.php'
    ],
    'finances' => [
        'nombre' => 'Control Financiero',
        'icono' => 'fas fa-chart-line',
        'descripcion' => 'Gestión de pagos, colegiaturas y reportes financieros',
        'url' => 'finances.php'
    ],
    'tickets' => [
        'nombre' => 'Sistema de Tickets',
        'icono' => 'fas fa-ticket-alt',
        'descripcion' => 'Mesa de ayuda y soporte institucional',
        'url' => 'tickets.php'
    ],
    'dashboard' => [
        'nombre' => 'Dashboard Principal',
        'icono' => 'fas fa-tachometer-alt',
        'descripcion' => 'Vista general y estadísticas del sistema',
        'url' => 'dashboard.php'
    ],
    'usuarios' => [
        'nombre' => 'Gestión de Usuarios',
        'icono' => 'fas fa-user-cog',
        'descripcion' => 'Administración de usuarios y permisos (Solo Dueños)',
        'url' => 'usuarios_registrados.php'
    ],
    'configuracion' => [
        'nombre' => 'Configuración del Sistema',
        'icono' => 'fas fa-cogs',
        'descripcion' => 'Ajustes generales y configuración avanzada',
        'url' => 'configuracion.php'
    ]
];

// Definir roles predefinidos
$roles_predefinidos = [
    'Dueño/Administrador' => [
        'descripcion' => 'Acceso completo a todas las funciones',
        'secciones' => array_keys($secciones_disponibles),
        'permisos' => ['crear', 'editar', 'eliminar', 'ver', 'administrar'],
        'color' => '#dc2626'
    ],
    'Coordinador Académico' => [
        'descripcion' => 'Gestión académica y de personal',
        'secciones' => ['students', 'staff', 'admissions', 'attendance', 'dashboard'],
        'permisos' => ['crear', 'editar', 'eliminar', 'ver'],
        'color' => '#7c3aed'
    ],
    'Coordinador Administrativo' => [
        'descripcion' => 'Gestión administrativa y financiera',
        'secciones' => ['finances', 'admissions', 'tickets', 'dashboard'],
        'permisos' => ['crear', 'editar', 'ver'],
        'color' => '#059669'
    ],
    'Maestro' => [
        'descripcion' => 'Acceso a estudiantes y asistencias',
        'secciones' => ['students', 'attendance', 'dashboard'],
        'permisos' => ['ver', 'editar_limitado'],
        'color' => '#2563eb'
    ],
    'Secretaria' => [
        'descripcion' => 'Gestión de admisiones y soporte',
        'secciones' => ['admissions', 'tickets', 'dashboard'],
        'permisos' => ['crear', 'editar', 'ver'],
        'color' => '#db2777'
    ],
    'Personal de Limpieza' => [
        'descripcion' => 'Solo tickets y dashboard básico',
        'secciones' => ['tickets', 'dashboard'],
        'permisos' => ['ver', 'crear_tickets'],
        'color' => '#6b7280'
    ]
];

// Filtros
$filtro_rol = $_GET['rol'] ?? 'todos';
$filtro_estado = $_GET['estado'] ?? 'todos';
$filtro_plantel = $_GET['plantel'] ?? 'todos';
$busqueda = $_GET['busqueda'] ?? '';

// Aplicar filtros
$usuarios_filtrados = array_filter($usuarios_registrados, function($usuario) use ($filtro_rol, $filtro_estado, $filtro_plantel, $busqueda) {
    $cumple_rol = ($filtro_rol === 'todos' || $usuario['rol'] === $filtro_rol);
    $cumple_estado = ($filtro_estado === 'todos' || $usuario['estado'] === $filtro_estado);
    $cumple_plantel = ($filtro_plantel === 'todos' || $usuario['plantel_asignado'] === $filtro_plantel);
    $cumple_busqueda = empty($busqueda) || 
                      stripos($usuario['nombre'], $busqueda) !== false || 
                      stripos($usuario['email'], $busqueda) !== false;
    
    return $cumple_rol && $cumple_estado && $cumple_plantel && $cumple_busqueda;
});

function obtenerColorEstado($estado) {
    switch ($estado) {
        case 'activo': return 'success';
        case 'inactivo': return 'secondary';
        case 'pendiente': return 'warning';
        case 'suspendido': return 'danger';
        default: return 'secondary';
    }
}

function obtenerIconoEstado($estado) {
    switch ($estado) {
        case 'activo': return 'fas fa-check-circle';
        case 'inactivo': return 'fas fa-pause-circle';
        case 'pendiente': return 'fas fa-clock';
        case 'suspendido': return 'fas fa-ban';
        default: return 'fas fa-question-circle';
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios | Instituto Educativo Frida Kahlo</title>
    <link rel="stylesheet" href="../assets/css/index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #4f46e5;
            --primary-light: rgba(79, 70, 229, 0.1);
            --primary-dark: #3730a3;
            --secondary-color: #818cf8;
            --accent-color: #6366f1;
            --white: #ffffff;
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --gray-400: #9ca3af;
            --gray-500: #6b7280;
            --gray-600: #4b5563;
            --gray-700: #374151;
            --gray-800: #1f2937;
            --gray-900: #111827;
            --success-color: #10b981;
            --success-light: rgba(16, 185, 129, 0.1);
            --warning-color: #f59e0b;
            --warning-light: rgba(245, 158, 11, 0.1);
            --danger-color: #ef4444;
            --danger-light: rgba(239, 68, 68, 0.1);
            --info-color: #3b82f6;
            --info-light: rgba(59, 130, 246, 0.1);
            --border-radius: 8px;
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-hover: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, var(--gray-50) 0%, var(--gray-100) 100%);
            color: var(--gray-800);
            line-height: 1.6;
            min-height: 100vh;
        }

        .container {
            max-width: 1600px;
            margin: 0 auto;
            padding: 2rem;
        }

        .header {
            background: var(--white);
            padding: 2rem;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            margin-bottom: 2rem;
            border-left: 4px solid var(--primary-color);
        }

        .header h1 {
            color: var(--primary-color);
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .header p {
            color: var(--gray-600);
        }

        .nav-tabs {
            display: flex;
            gap: 1rem;
            margin-bottom: 2rem;
            overflow-x: auto;
            padding-bottom: 0.5rem;
        }

        .nav-tab {
            padding: 1rem 2rem;
            background: var(--white);
            border: 2px solid var(--gray-300);
            border-radius: var(--border-radius);
            text-decoration: none;
            color: var(--gray-700);
            transition: var(--transition);
            white-space: nowrap;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-weight: 500;
        }

        .nav-tab:hover {
            border-color: var(--primary-color);
            background: var(--primary-light);
        }

        .nav-tab.active {
            background: var(--primary-color);
            color: var(--white);
            border-color: var(--primary-color);
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: var(--border-radius);
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
            text-align: center;
            justify-content: center;
        }

        .btn-primary {
            background: var(--primary-color);
            color: var(--white);
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-1px);
        }

        .btn-secondary {
            background: var(--gray-500);
            color: var(--white);
        }

        .btn-success {
            background: var(--success-color);
            color: var(--white);
        }

        .btn-warning {
            background: var(--warning-color);
            color: var(--white);
        }

        .btn-danger {
            background: var(--danger-color);
            color: var(--white);
        }

        .btn-outline-primary {
            background: transparent;
            color: var(--primary-color);
            border: 2px solid var(--primary-color);
        }

        .btn-sm {
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
        }

        .section-content {
            background: var(--white);
            padding: 2rem;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            min-height: 600px;
        }

        .badge {
            padding: 0.25rem 0.75rem;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--white);
        }

        .badge-success {
            background: var(--success-color);
        }

        .badge-warning {
            background: var(--warning-color);
        }

        .badge-danger {
            background: var(--danger-color);
        }

        .badge-secondary {
            background: var(--gray-500);
        }

        /* Notification Styles */
        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 1rem 1.5rem;
            border-radius: var(--border-radius);
            color: var(--white);
            z-index: 1000;
            max-width: 400px;
            box-shadow: var(--shadow);
            transform: translateX(100%);
            transition: transform 0.3s ease;
        }

        .notification.show {
            transform: translateX(0);
        }

        .notification.success {
            background: var(--success-color);
        }

        .notification.error {
            background: var(--danger-color);
        }

        .notification.warning {
            background: var(--warning-color);
        }

        .notification.info {
            background: var(--info-color);
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background: var(--white);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-hover);
            max-width: 90vw;
            max-height: 90vh;
            overflow-y: auto;
        }

        .modal-header {
            padding: 1.5rem;
            border-bottom: 2px solid var(--gray-200);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-body {
            padding: 1.5rem;
        }

        .modal-footer {
            padding: 1.5rem;
            border-top: 2px solid var(--gray-200);
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
        }

        .modal-close {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: var(--gray-500);
        }

        .modal-lg {
            max-width: 800px;
        }

        .modal-xl {
            max-width: 1200px;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .fade-in {
            animation: fadeIn 0.5s ease;
        }

        @media (max-width: 768px) {
            .container {
                padding: 1rem;
            }

            .nav-tabs {
                flex-direction: column;
                gap: 0.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>
                <i class="fas fa-user-cog"></i>
                Gestión de Usuarios y Permisos
            </h1>
            <p>Administración completa de usuarios, roles y accesos al sistema</p>
        </div>

        <!-- Navigation Tabs -->
        <div class="nav-tabs">
            <a href="?vista=usuarios" class="nav-tab <?= $vista === 'usuarios' ? 'active' : '' ?>">
                <i class="fas fa-users"></i>
                Usuarios Registrados
            </a>
            <a href="?vista=roles" class="nav-tab <?= $vista === 'roles' ? 'active' : '' ?>">
                <i class="fas fa-user-tag"></i>
                Gestión de Roles
            </a>
            <a href="?vista=permisos" class="nav-tab <?= $vista === 'permisos' ? 'active' : '' ?>">
                <i class="fas fa-shield-alt"></i>
                Control de Permisos
            </a>
            <a href="?vista=invitaciones" class="nav-tab <?= $vista === 'invitaciones' ? 'active' : '' ?>">
                <i class="fas fa-envelope"></i>
                Enviar Invitaciones
            </a>
            <a href="?vista=auditoria" class="nav-tab <?= $vista === 'auditoria' ? 'active' : '' ?>">
                <i class="fas fa-history"></i>
                Auditoría de Accesos
            </a>
        </div>

        <!-- Content Section -->
        <div class="section-content fade-in">
            <?php
            switch($vista) {
                case 'usuarios':
                    include 'user_sections/lista_usuarios.php';
                    break;
                case 'roles':
                    include 'user_sections/gestion_roles.php';
                    break;
                case 'permisos':
                    include 'user_sections/control_permisos.php';
                    break;
                case 'invitaciones':
                    include 'user_sections/enviar_invitaciones.php';
                    break;
                case 'auditoria':
                    include 'user_sections/auditoria_accesos.php';
                    break;
                default:
                    include 'user_sections/lista_usuarios.php';
                    break;
            }
            ?>
        </div>
    </div>

    <!-- Notification Container -->
    <div id="notification-container"></div>

    <script>
        // Sistema de notificaciones
        function showNotification(message, type = 'info', duration = 3000) {
            const container = document.getElementById('notification-container');
            const notification = document.createElement('div');
            notification.className = `notification ${type}`;
            notification.innerHTML = `
                <div style="display: flex; align-items: center; gap: 0.75rem;">
                    <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'times-circle' : type === 'warning' ? 'exclamation-triangle' : 'info-circle'}"></i>
                    <span>${message}</span>
                </div>
            `;
            
            container.appendChild(notification);
            
            setTimeout(() => notification.classList.add('show'), 100);
            
            setTimeout(() => {
                notification.classList.remove('show');
                setTimeout(() => container.removeChild(notification), 300);
            }, duration);
        }

        // Cerrar modales al hacer clic fuera
        window.onclick = function(event) {
            if (event.target.classList.contains('modal')) {
                event.target.style.display = 'none';
            }
        }

        // Función global para formatear fechas
        function formatearFecha(fecha) {
            return new Date(fecha).toLocaleDateString('es-MX', {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });
        }

        // Función global para formatear fechas y horas
        function formatearFechaHora(fechaHora) {
            return new Date(fechaHora).toLocaleString('es-MX', {
                year: 'numeric',
                month: 'short',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
        }
    </script>
</body>
</html>
