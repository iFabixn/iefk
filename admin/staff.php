<?php

// Obtener sección actual
$section = $_GET['section'] ?? 'vista_general';
$employee_id = $_GET['employee_id'] ?? null;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Personal - IEFK Admin</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        /* ===================== VARIABLES CSS ===================== */
        :root {
            --primary-color: #ffc107;
            --primary-dark: #e0a800;
            --primary-light: #fff3cd;
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
            overflow-x: hidden;
        }

        /* ===================== HEADER ===================== */
        .header {
            background: var(--white);
            box-shadow: var(--shadow);
            padding: 1rem 2rem;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1001;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header h1 {
            color: var(--primary-color);
            font-size: 1.5rem;
            font-weight: 700;
        }

        .header-actions {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        /* ===================== ESTILOS ESPECÍFICOS PARA STAFF ===================== */
        .content-wrapper {
            display: flex;
            min-height: 100vh;
            margin-top: 70px;
        }

        .sidebar {
            width: 300px;
            background: linear-gradient(145deg, var(--primary-color), var(--primary-dark));
            color: var(--dark);
            padding: 0;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
            position: fixed;
            height: calc(100vh - 70px);
            overflow-y: auto;
            z-index: 1000;
        }

        .sidebar-header {
            background: rgba(0,0,0,0.1);
            padding: 2rem;
            text-align: center;
            border-bottom: 1px solid rgba(0,0,0,0.1);
        }

        .sidebar-header h2 {
            color: var(--dark);
            font-size: 1.3rem;
            margin-bottom: 0.5rem;
        }

        .sidebar-header p {
            color: rgba(0,0,0,0.7);
            font-size: 0.9rem;
        }

        .sidebar-nav {
            padding: 1rem 0;
        }

        .nav-section {
            margin-bottom: 1.5rem;
        }

        .nav-section-title {
            color: rgba(0,0,0,0.6);
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
            color: var(--dark);
            text-decoration: none;
            padding: 1rem 2rem;
            transition: var(--transition);
            border-left: 3px solid transparent;
        }

        .nav-link:hover,
        .nav-link.active {
            background: rgba(0,0,0,0.1);
            color: var(--dark);
            border-left-color: var(--dark);
        }

        .nav-link i {
            width: 20px;
            text-align: center;
            font-size: 1.1rem;
        }

        .nav-badge {
            background: var(--danger-color);
            color: var(--white);
            font-size: 0.7rem;
            padding: 0.2rem 0.5rem;
            border-radius: 10px;
            margin-left: auto;
        }

        .main-content {
            flex: 1;
            margin-left: 300px;
            background: var(--gray-100);
        }

        .content-body {
            padding: 2rem;
            min-height: calc(100vh - 70px);
        }

        .breadcrumb {
            background: var(--white);
            padding: 1rem 1.5rem;
            border-radius: var(--border-radius);
            margin-bottom: 2rem;
            box-shadow: var(--shadow);
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
        }

        .btn-primary {
            background: var(--primary-color);
            color: var(--dark);
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            color: var(--dark);
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
            background: #e0650e;
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
            background: var(--gray-600);
            color: var(--white);
        }

        .btn-secondary:hover {
            background: var(--gray-700);
            transform: translateY(-2px);
        }

        .btn-outline-primary {
            background: transparent;
            color: var(--primary-color);
            border: 2px solid var(--primary-color);
        }

        .btn-outline-primary:hover {
            background: var(--primary-color);
            color: var(--dark);
        }

        .btn-sm {
            padding: 0.5rem 1rem;
            font-size: 0.8rem;
        }

        .btn-lg {
            padding: 1rem 2rem;
            font-size: 1.1rem;
        }

        /* ===================== BADGES ===================== */
        .badge {
            padding: 0.25rem 0.75rem;
            border-radius: 12px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .badge-active {
            background: var(--success-light);
            color: var(--success-color);
        }

        .badge-inactive {
            background: var(--danger-light);
            color: var(--danger-color);
        }

        .badge-pending {
            background: var(--warning-light);
            color: var(--warning-color);
        }

        .badge-info {
            background: var(--info-light);
            color: var(--info-color);
        }

        .badge-primary {
            background: var(--primary-light);
            color: var(--primary-dark);
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

        /* ===================== CARDS ===================== */
        .card {
            background: var(--white);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            overflow: hidden;
            transition: var(--transition);
        }

        .card:hover {
            box-shadow: var(--shadow-lg);
            transform: translateY(-5px);
        }

        .card-header {
            background: var(--primary-light);
            padding: 1.5rem;
            border-bottom: 1px solid var(--gray-200);
        }

        .card-body {
            padding: 1.5rem;
        }

        .card-footer {
            background: var(--gray-100);
            padding: 1rem 1.5rem;
            border-top: 1px solid var(--gray-200);
        }

        /* ===================== RESPONSIVE ===================== */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .content-body {
                padding: 1rem;
            }
        }

        /* ===================== ANIMACIONES ===================== */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in {
            animation: fadeIn 0.5s ease;
        }

        @keyframes slideIn {
            from {
                transform: translateX(-20px);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        .slide-in {
            animation: slideIn 0.3s ease;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div>
            <h1><i class="fas fa-users"></i> Gestión de Personal</h1>
        </div>
        <div class="header-actions">
            <button class="btn btn-outline-primary" onclick="toggleSidebar()">
                <i class="fas fa-bars"></i>
            </button>
            <button class="btn btn-success" onclick="addNewEmployee()">
                <i class="fas fa-user-plus"></i> Nuevo Empleado
            </button>
            <button class="btn btn-warning" onclick="generatePayroll()">
                <i class="fas fa-money-bill-wave"></i> Generar Nómina
            </button>
        </div>
    </div>

    <!-- Content Wrapper -->
    <div class="content-wrapper">
        <!-- Sidebar -->
        <div class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <h2><i class="fas fa-users-cog"></i> Personal IEFK</h2>
                <p>Sistema de Gestión de Recursos Humanos</p>
            </div>
            
            <nav class="sidebar-nav">
                <!-- Sección Principal -->
                <div class="nav-section">
                    <div class="nav-section-title">Panel Principal</div>
                    <div class="nav-item">
                        <a href="?section=vista_general" class="nav-link <?= $section === 'vista_general' ? 'active' : '' ?>">
                            <i class="fas fa-tachometer-alt"></i>
                            <span>Vista General</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a href="?section=lista_empleados" class="nav-link <?= $section === 'lista_empleados' ? 'active' : '' ?>">
                            <i class="fas fa-users"></i>
                            <span>Lista de Empleados</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a href="?section=busqueda_global" class="nav-link <?= $section === 'busqueda_global' ? 'active' : '' ?>">
                            <i class="fas fa-search"></i>
                            <span>Búsqueda Global</span>
                        </a>
                    </div>
                </div>

                <!-- Nómina y Pagos -->
                <div class="nav-section">
                    <div class="nav-section-title">Nómina y Pagos</div>
                    <div class="nav-item">
                        <a href="?section=nomina_actual" class="nav-link <?= $section === 'nomina_actual' ? 'active' : '' ?>">
                            <i class="fas fa-money-bill-wave"></i>
                            <span>Nómina Actual</span>
                            <span class="nav-badge">3</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a href="?section=historial_pagos" class="nav-link <?= $section === 'historial_pagos' ? 'active' : '' ?>">
                            <i class="fas fa-history"></i>
                            <span>Historial de Pagos</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a href="?section=prestamos" class="nav-link <?= $section === 'prestamos' ? 'active' : '' ?>">
                            <i class="fas fa-hand-holding-usd"></i>
                            <span>Préstamos</span>
                            <span class="nav-badge">2</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a href="?section=descuentos" class="nav-link <?= $section === 'descuentos' ? 'active' : '' ?>">
                            <i class="fas fa-minus-circle"></i>
                            <span>Descuentos</span>
                        </a>
                    </div>
                </div>

                <!-- Asistencias y Horarios -->
                <div class="nav-section">
                    <div class="nav-section-title">Asistencias</div>
                    <div class="nav-item">
                        <a href="?section=asistencias_hoy" class="nav-link <?= $section === 'asistencias_hoy' ? 'active' : '' ?>">
                            <i class="fas fa-calendar-check"></i>
                            <span>Asistencias Hoy</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a href="?section=horarios" class="nav-link <?= $section === 'horarios' ? 'active' : '' ?>">
                            <i class="fas fa-clock"></i>
                            <span>Horarios</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a href="?section=faltas" class="nav-link <?= $section === 'faltas' ? 'active' : '' ?>">
                            <i class="fas fa-calendar-times"></i>
                            <span>Faltas y Permisos</span>
                            <span class="nav-badge">1</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a href="?section=codigos_qr" class="nav-link <?= $section === 'codigos_qr' ? 'active' : '' ?>">
                            <i class="fas fa-qrcode"></i>
                            <span>Códigos QR</span>
                        </a>
                    </div>
                </div>

                <!-- Gestión de Personal -->
                <div class="nav-section">
                    <div class="nav-section-title">Gestión</div>
                    <div class="nav-item">
                        <a href="?section=contratos" class="nav-link <?= $section === 'contratos' ? 'active' : '' ?>">
                            <i class="fas fa-file-contract"></i>
                            <span>Contratos</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a href="?section=aumentos" class="nav-link <?= $section === 'aumentos' ? 'active' : '' ?>">
                            <i class="fas fa-chart-line"></i>
                            <span>Aumentos Salariales</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a href="?section=familiares" class="nav-link <?= $section === 'familiares' ? 'active' : '' ?>">
                            <i class="fas fa-baby"></i>
                            <span>Hijos Estudiantes</span>
                        </a>
                    </div>
                </div>

                <!-- Reportes -->
                <div class="nav-section">
                    <div class="nav-section-title">Reportes</div>
                    <div class="nav-item">
                        <a href="?section=reportes" class="nav-link <?= $section === 'reportes' ? 'active' : '' ?>">
                            <i class="fas fa-chart-bar"></i>
                            <span>Reportes</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a href="?section=estadisticas" class="nav-link <?= $section === 'estadisticas' ? 'active' : '' ?>">
                            <i class="fas fa-analytics"></i>
                            <span>Estadísticas</span>
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
                        <i class="fas fa-users"></i> Personal
                    </li>
                    <li class="breadcrumb-separator">
                        <i class="fas fa-chevron-right"></i>
                    </li>
                    <li class="breadcrumb-item active">
                        <?php
                        $section_titles = [
                            'vista_general' => 'Vista General',
                            'lista_empleados' => 'Lista de Empleados',
                            'busqueda_global' => 'Búsqueda Global',
                            'nomina_actual' => 'Nómina Actual',
                            'historial_pagos' => 'Historial de Pagos',
                            'prestamos' => 'Préstamos',
                            'descuentos' => 'Descuentos',
                            'asistencias_hoy' => 'Asistencias Hoy',
                            'horarios' => 'Horarios',
                            'faltas' => 'Faltas y Permisos',
                            'codigos_qr' => 'Códigos QR',
                            'contratos' => 'Contratos',
                            'aumentos' => 'Aumentos Salariales',
                            'familiares' => 'Hijos Estudiantes',
                            'reportes' => 'Reportes',
                            'estadisticas' => 'Estadísticas',
                            'ficha_empleado' => 'Ficha de Empleado'
                        ];
                        echo $section_titles[$section] ?? 'Sección';
                        ?>
                    </li>
                </ul>
            </div>

            <!-- Content Body -->
            <div class="content-body">
                <?php
                // Incluir el archivo de la sección correspondiente
                $section_file = "staff_sections/{$section}.php";
                if (file_exists($section_file)) {
                    include $section_file;
                } else {
                    echo '<div style="text-align: center; padding: 3rem; color: #666;">
                            <i class="fas fa-exclamation-triangle" style="font-size: 3rem; margin-bottom: 1rem;"></i>
                            <h3>Sección en desarrollo</h3>
                            <p>La sección "' . htmlspecialchars($section) . '" está siendo construida.</p>
                          </div>';
                }
                ?>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        // Función para cambiar de sección
        function changeSection(section, employeeId = null) {
            let url = `?section=${section}`;
            if (employeeId) {
                url += `&employee_id=${employeeId}`;
            }
            window.location.href = url;
        }

        // Función para toggle del sidebar
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('active');
        }

        // Función para agregar nuevo empleado
        function addNewEmployee() {
            alert('Funcionalidad para agregar nuevo empleado\n\nSe abrirá el formulario de registro de personal.');
        }

        // Función para generar nómina
        function generatePayroll() {
            if(confirm('¿Generar nómina actual?\n\nEsto calculará los pagos pendientes para todos los empleados.')) {
                alert('Generando nómina...\n\nSe procesarán todos los cálculos de sueldos, descuentos y bonificaciones.');
            }
        }

        // Función para ver ficha de empleado
        function viewEmployeeFile(employeeId) {
            changeSection('ficha_empleado', employeeId);
        }

        // Función para editar empleado
        function editEmployee(employeeId) {
            alert(`Editar empleado ID: ${employeeId}\n\nSe abrirá el formulario de edición con todos los datos del empleado.`);
        }

        // Función para eliminar empleado
        function deleteEmployee(employeeId, employeeName) {
            if(confirm(`¿Eliminar empleado?\n\nNombre: ${employeeName}\nID: ${employeeId}\n\nEsta acción no se puede deshacer.`)) {
                alert(`Empleado ${employeeName} ha sido dado de baja del sistema.`);
            }
        }

        // Cerrar sidebar al hacer clic fuera
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const toggleBtn = event.target.closest('[onclick="toggleSidebar()"]');
            
            if (!sidebar.contains(event.target) && !toggleBtn && window.innerWidth <= 768) {
                sidebar.classList.remove('active');
            }
        });

        // Animaciones de entrada
        document.addEventListener('DOMContentLoaded', function() {
            const elements = document.querySelectorAll('.card, .nav-item');
            elements.forEach((el, index) => {
                el.style.opacity = '0';
                el.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    el.style.transition = 'all 0.5s ease';
                    el.style.opacity = '1';
                    el.style.transform = 'translateY(0)';
                }, index * 50);
            });
        });
    </script>
</body>
</html>
