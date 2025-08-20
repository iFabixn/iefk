<?php
// Obtener sección actual
$section = $_GET['section'] ?? 'dashboard_tickets';
$ticket_id = $_GET['ticket_id'] ?? null;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Tickets - IEFK Admin</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        /* ===================== VARIABLES CSS ===================== */
        :root {
            --primary-color: #8e44ad;
            --primary-dark: #732d91;
            --primary-light: #e8d5f2;
            --secondary-color: #6c757d;
            --success-color: #28a745;
            --success-light: #d4edda;
            --danger-color: #dc3545;
            --danger-light: #f8d7da;
            --warning-color: #fd7e14;
            --warning-light: #fff3cd;
            --info-color: #17a2b8;
            --info-light: #d1ecf1;
            --white: #ffffff;
            --light: #f8f9fa;
            --dark: #343a40;
            --gray-100: #f8f9fa;
            --gray-200: #e9ecef;
            --gray-300: #dee2e6;
            --gray-400: #ced4da;
            --gray-500: #adb5bd;
            --gray-600: #6c757d;
            --gray-700: #495057;
            --gray-800: #343a40;
            --gray-900: #212529;
            --purple: #6f42c1;
            --shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            --shadow-lg: 0 1rem 3rem rgba(0, 0, 0, 0.175);
            --border-radius: 0.375rem;
            --transition: all 0.3s ease;
        }

        /* ===================== RESET Y BASE ===================== */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: var(--gray-100);
            color: var(--dark);
            line-height: 1.6;
        }

        /* ===================== LAYOUT PRINCIPAL ===================== */
        .container {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 280px;
            background: var(--primary-color);
            color: var(--white);
            padding: 0;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            z-index: 1000;
        }

        .sidebar-header {
            background: rgba(0,0,0,0.1);
            padding: 2rem;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .sidebar-header h2 {
            color: var(--white);
            font-size: 1.3rem;
            margin-bottom: 0.5rem;
        }

        .sidebar-header p {
            color: rgba(255,255,255,0.7);
            font-size: 0.9rem;
        }

        .sidebar-nav {
            padding: 1rem 0;
        }

        .nav-section {
            margin-bottom: 1.5rem;
        }

        .nav-section-title {
            color: rgba(255,255,255,0.6);
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 0.5rem 2rem;
            margin-bottom: 0.5rem;
        }

        .nav-item {
            margin-bottom: 0.25rem;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem 2rem;
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            transition: var(--transition);
            border-left: 3px solid transparent;
        }

        .nav-link:hover {
            background: rgba(255,255,255,0.1);
            color: var(--white);
            border-left-color: var(--white);
        }

        .nav-link.active {
            background: rgba(255,255,255,0.15);
            color: var(--white);
            border-left-color: var(--white);
            font-weight: 600;
        }

        .nav-link i {
            width: 20px;
            text-align: center;
        }

        .main-content {
            margin-left: 280px;
            padding: 2rem;
            width: calc(100% - 280px);
            min-height: 100vh;
        }

        /* ===================== BREADCRUMB ===================== */
        .breadcrumb {
            background: var(--white);
            padding: 1rem 2rem;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            margin-bottom: 2rem;
        }

        .breadcrumb-list {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            list-style: none;
        }

        .breadcrumb-item {
            color: var(--gray-600);
        }

        .breadcrumb-item.active {
            color: var(--primary-color);
            font-weight: 600;
        }

        .breadcrumb-separator {
            color: var(--gray-400);
        }

        /* ===================== BOTONES ===================== */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: var(--border-radius);
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            transition: var(--transition);
            font-size: 0.9rem;
            border: 2px solid transparent;
        }

        .btn-primary {
            background: var(--primary-color);
            color: var(--white);
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
        }

        .btn-success {
            background: var(--success-color);
            color: var(--white);
        }

        .btn-success:hover {
            background: #218838;
            transform: translateY(-2px);
        }

        .btn-warning {
            background: var(--warning-color);
            color: var(--white);
        }

        .btn-warning:hover {
            background: #e0670b;
            transform: translateY(-2px);
        }

        .btn-danger {
            background: var(--danger-color);
            color: var(--white);
        }

        .btn-danger:hover {
            background: #c82333;
            transform: translateY(-2px);
        }

        .btn-info {
            background: var(--info-color);
            color: var(--white);
        }

        .btn-info:hover {
            background: #138496;
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: var(--secondary-color);
            color: var(--white);
        }

        .btn-secondary:hover {
            background: #5a6268;
            transform: translateY(-2px);
        }

        .btn-outline-primary {
            background: transparent;
            color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-outline-primary:hover {
            background: var(--primary-color);
            color: var(--white);
        }

        .btn-sm {
            padding: 0.5rem 1rem;
            font-size: 0.8rem;
        }

        .btn-lg {
            padding: 1rem 2rem;
            font-size: 1.1rem;
        }

        /* ===================== UTILIDADES ===================== */
        .fadeIn {
            animation: fadeIn 0.5s ease-in;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .text-center { text-align: center; }
        .text-left { text-align: left; }
        .text-right { text-align: right; }

        .mb-0 { margin-bottom: 0; }
        .mb-1 { margin-bottom: 0.5rem; }
        .mb-2 { margin-bottom: 1rem; }
        .mb-3 { margin-bottom: 1.5rem; }
        .mb-4 { margin-bottom: 2rem; }

        .mt-0 { margin-top: 0; }
        .mt-1 { margin-top: 0.5rem; }
        .mt-2 { margin-top: 1rem; }
        .mt-3 { margin-top: 1.5rem; }
        .mt-4 { margin-top: 2rem; }

        /* ===================== RESPONSIVE ===================== */
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: static;
            }

            .main-content {
                margin-left: 0;
                width: 100%;
                padding: 1rem;
            }

            .container {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-header">
                <h2><i class="fas fa-ticket-alt"></i> Sistema de Tickets</h2>
                <p>Gestión Central de Incidencias</p>
            </div>

            <nav class="sidebar-nav">
                <!-- Dashboard Principal -->
                <div class="nav-section">
                    <div class="nav-section-title">Panel Principal</div>
                    <div class="nav-item">
                        <a href="?section=dashboard_tickets" class="nav-link <?= $section === 'dashboard_tickets' ? 'active' : '' ?>">
                            <i class="fas fa-tachometer-alt"></i>
                            <span>Dashboard</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a href="?section=crear_ticket" class="nav-link <?= $section === 'crear_ticket' ? 'active' : '' ?>">
                            <i class="fas fa-plus-circle"></i>
                            <span>Crear Ticket</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a href="?section=mis_tickets" class="nav-link <?= $section === 'mis_tickets' ? 'active' : '' ?>">
                            <i class="fas fa-user-circle"></i>
                            <span>Mis Tickets</span>
                        </a>
                    </div>
                </div>

                <!-- Gestión de Tickets -->
                <div class="nav-section">
                    <div class="nav-section-title">Gestión de Tickets</div>
                    <div class="nav-item">
                        <a href="?section=todos_tickets" class="nav-link <?= $section === 'todos_tickets' ? 'active' : '' ?>">
                            <i class="fas fa-list"></i>
                            <span>Todos los Tickets</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a href="?section=tickets_asignados" class="nav-link <?= $section === 'tickets_asignados' ? 'active' : '' ?>">
                            <i class="fas fa-clipboard-list"></i>
                            <span>Tickets Asignados</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a href="?section=tickets_pendientes" class="nav-link <?= $section === 'tickets_pendientes' ? 'active' : '' ?>">
                            <i class="fas fa-clock"></i>
                            <span>Pendientes</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a href="?section=tickets_urgentes" class="nav-link <?= $section === 'tickets_urgentes' ? 'active' : '' ?>">
                            <i class="fas fa-exclamation-triangle"></i>
                            <span>Urgentes</span>
                        </a>
                    </div>
                </div>

                <!-- Categorías Específicas -->
                <div class="nav-section">
                    <div class="nav-section-title">Categorías</div>
                    <div class="nav-item">
                        <a href="?section=incidencias_estudiantes" class="nav-link <?= $section === 'incidencias_estudiantes' ? 'active' : '' ?>">
                            <i class="fas fa-child"></i>
                            <span>Situaciones de Estudiantes</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a href="?section=relaciones_laborales" class="nav-link <?= $section === 'relaciones_laborales' ? 'active' : '' ?>">
                            <i class="fas fa-handshake"></i>
                            <span>Relaciones Laborales</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a href="?section=infraestructura" class="nav-link <?= $section === 'infraestructura' ? 'active' : '' ?>">
                            <i class="fas fa-building"></i>
                            <span>Infraestructura</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a href="?section=pedagogico" class="nav-link <?= $section === 'pedagogico' ? 'active' : '' ?>">
                            <i class="fas fa-chalkboard-teacher"></i>
                            <span>Pedagógico</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a href="?section=tecnologia" class="nav-link <?= $section === 'tecnologia' ? 'active' : '' ?>">
                            <i class="fas fa-laptop"></i>
                            <span>Tecnología</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a href="?section=mejoras" class="nav-link <?= $section === 'mejoras' ? 'active' : '' ?>">
                            <i class="fas fa-lightbulb"></i>
                            <span>Mejoras y Sugerencias</span>
                        </a>
                    </div>
                </div>

                <!-- Seguimientos -->
                <div class="nav-section">
                    <div class="nav-section-title">Seguimientos</div>
                    <div class="nav-item">
                        <a href="?section=seguimientos_activos" class="nav-link <?= $section === 'seguimientos_activos' ? 'active' : '' ?>">
                            <i class="fas fa-search"></i>
                            <span>Seguimientos Activos</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a href="?section=escalaciones" class="nav-link <?= $section === 'escalaciones' ? 'active' : '' ?>">
                            <i class="fas fa-arrow-up"></i>
                            <span>Escalaciones</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a href="?section=casos_cerrados" class="nav-link <?= $section === 'casos_cerrados' ? 'active' : '' ?>">
                            <i class="fas fa-check-circle"></i>
                            <span>Casos Cerrados</span>
                        </a>
                    </div>
                </div>

                <!-- Reportes y Análisis -->
                <div class="nav-section">
                    <div class="nav-section-title">Reportes</div>
                    <div class="nav-item">
                        <a href="?section=reportes_tickets" class="nav-link <?= $section === 'reportes_tickets' ? 'active' : '' ?>">
                            <i class="fas fa-chart-bar"></i>
                            <span>Reportes</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a href="?section=estadisticas_tickets" class="nav-link <?= $section === 'estadisticas_tickets' ? 'active' : '' ?>">
                            <i class="fas fa-analytics"></i>
                            <span>Estadísticas</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a href="?section=metricas" class="nav-link <?= $section === 'metricas' ? 'active' : '' ?>">
                            <i class="fas fa-chart-line"></i>
                            <span>Métricas de Rendimiento</span>
                        </a>
                    </div>
                </div>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Breadcrumb -->
            <div class="breadcrumb">
                <ul class="breadcrumb-list">
                    <li class="breadcrumb-item">
                        <i class="fas fa-home"></i> Admin
                    </li>
                    <li class="breadcrumb-separator">
                        <i class="fas fa-chevron-right"></i>
                    </li>
                    <li class="breadcrumb-item">
                        <i class="fas fa-ticket-alt"></i> Tickets
                    </li>
                    <li class="breadcrumb-separator">
                        <i class="fas fa-chevron-right"></i>
                    </li>
                    <li class="breadcrumb-item active">
                        <?php
                        $section_titles = [
                            'dashboard_tickets' => 'Dashboard',
                            'crear_ticket' => 'Crear Ticket',
                            'mis_tickets' => 'Mis Tickets',
                            'todos_tickets' => 'Todos los Tickets',
                            'tickets_asignados' => 'Tickets Asignados',
                            'tickets_pendientes' => 'Pendientes',
                            'tickets_urgentes' => 'Urgentes',
                            'incidencias_estudiantes' => 'Situaciones de Estudiantes',
                            'relaciones_laborales' => 'Relaciones Laborales',
                            'infraestructura' => 'Infraestructura',
                            'pedagogico' => 'Pedagógico',
                            'tecnologia' => 'Tecnología',
                            'mejoras' => 'Mejoras y Sugerencias',
                            'seguimientos_activos' => 'Seguimientos Activos',
                            'escalaciones' => 'Escalaciones',
                            'casos_cerrados' => 'Casos Cerrados',
                            'reportes_tickets' => 'Reportes',
                            'estadisticas_tickets' => 'Estadísticas',
                            'metricas' => 'Métricas de Rendimiento'
                        ];
                        echo $section_titles[$section] ?? 'Sección';
                        ?>
                    </li>
                </ul>
            </div>

            <!-- Content Body -->
            <div class="content-body">
                <?php
                // Incluir la sección correspondiente
                $section_file = "tickets_sections/{$section}.php";
                if (file_exists($section_file)) {
                    include $section_file;
                } else {
                    // Mostrar dashboard por defecto
                    include 'tickets_sections/dashboard_tickets.php';
                }
                ?>
            </div>
        </div>
    </div>

    <!-- Scripts generales -->
    <script>
        // Función para mostrar notificaciones
        function showNotification(message, type = 'info') {
            const notification = document.createElement('div');
            notification.className = `notification ${type}`;
            notification.innerHTML = `
                <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'}"></i>
                <span>${message}</span>
                <button onclick="this.parentElement.remove()" class="notification-close">
                    <i class="fas fa-times"></i>
                </button>
            `;
            
            // Agregar estilos si no existen
            if (!document.querySelector('#notification-styles')) {
                const styles = document.createElement('style');
                styles.id = 'notification-styles';
                styles.textContent = `
                    .notification {
                        position: fixed;
                        top: 20px;
                        right: 20px;
                        padding: 1rem 1.5rem;
                        background: var(--white);
                        border-radius: var(--border-radius);
                        box-shadow: var(--shadow-lg);
                        display: flex;
                        align-items: center;
                        gap: 1rem;
                        z-index: 9999;
                        min-width: 300px;
                        animation: slideInRight 0.3s ease;
                        border-left: 4px solid var(--info-color);
                    }
                    .notification.success { border-left-color: var(--success-color); }
                    .notification.error { border-left-color: var(--danger-color); }
                    .notification.warning { border-left-color: var(--warning-color); }
                    .notification-close {
                        background: none;
                        border: none;
                        color: var(--gray-500);
                        cursor: pointer;
                        padding: 0.25rem;
                    }
                    @keyframes slideInRight {
                        from { transform: translateX(100%); opacity: 0; }
                        to { transform: translateX(0); opacity: 1; }
                    }
                `;
                document.head.appendChild(styles);
            }
            
            document.body.appendChild(notification);
            
            // Auto-remover después de 5 segundos
            setTimeout(() => {
                if (notification.parentElement) {
                    notification.remove();
                }
            }, 5000);
        }

        // Función para confirmar acciones
        function confirmAction(message, action) {
            if (confirm(message)) {
                action();
            }
        }

        // Inicialización
        document.addEventListener('DOMContentLoaded', function() {
            // Agregar efectos de hover a elementos interactivos
            const interactiveElements = document.querySelectorAll('.nav-link, .btn');
            interactiveElements.forEach(element => {
                element.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateX(5px)';
                });
                element.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateX(0)';
                });
            });
        });
    </script>
</body>
</html>
