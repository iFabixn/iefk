<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

// Obtener la sección actual (por defecto: dashboard)
$section = $_GET['section'] ?? 'dashboard';
$plantel = $_GET['plantel'] ?? '';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finanzas - Instituto Educativo Frida Kahlo</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="icon" type="image/png" href="../assets/img/logo sin letras.png">
    <style>
        /* ===================== VARIABLES CSS ===================== */
        :root {
            --primary-color: #28a745;
            --primary-light: #d4edda;
            --primary-dark: #1e7e34;
            --secondary-color: #17a2b8;
            --success-color: #28a745;
            --warning-color: #ffc107;
            --danger-color: #dc3545;
            --info-color: #17a2b8;
            --light-color: #f8f9fa;
            --dark-color: #343a40;
            --white: #ffffff;
            --gray-100: #f8f9fa;
            --gray-200: #e9ecef;
            --gray-300: #dee2e6;
            --gray-400: #ced4da;
            --gray-500: #adb5bd;
            --gray-600: #6c757d;
            --shadow: 0 4px 15px rgba(40, 167, 69, 0.1);
            --shadow-lg: 0 8px 25px rgba(40, 167, 69, 0.15);
            --border-radius: 12px;
            --transition: all 0.3s ease;
            --sidebar-width: 280px;
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
            color: var(--dark-color);
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
            z-index: 1000;
            height: 70px;
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: none;
        }

        .logo-section {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .logo-img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
        }

        .logo-text {
            font-size: 1.3rem;
            font-weight: bold;
            color: var(--primary-color);
        }

        .breadcrumb {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--gray-600);
        }

        .breadcrumb a {
            color: var(--primary-color);
            text-decoration: none;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .back-btn {
            background: var(--primary-color);
            color: var(--white);
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: var(--transition);
        }

        .back-btn:hover {
            background: var(--primary-dark);
            color: var(--white);
            text-decoration: none;
        }

        /* ===================== LAYOUT PRINCIPAL ===================== */
        .main-layout {
            display: flex;
            margin-top: 70px;
            min-height: calc(100vh - 70px);
        }

        /* ===================== SIDEBAR ===================== */
        .sidebar {
            width: var(--sidebar-width);
            background: var(--white);
            box-shadow: var(--shadow);
            position: fixed;
            left: 0;
            top: 70px;
            height: calc(100vh - 70px);
            overflow-y: auto;
            z-index: 100;
        }

        .sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid var(--gray-200);
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            color: var(--white);
        }

        .sidebar-title {
            font-size: 1.2rem;
            font-weight: bold;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .sidebar-menu {
            padding: 1rem 0;
        }

        .menu-item {
            display: block;
            padding: 1rem 1.5rem;
            color: var(--dark-color);
            text-decoration: none;
            transition: var(--transition);
            border-left: 3px solid transparent;
        }

        .menu-item:hover {
            background: var(--primary-light);
            color: var(--primary-dark);
            text-decoration: none;
            border-left-color: var(--primary-color);
        }

        .menu-item.active {
            background: var(--primary-light);
            color: var(--primary-color);
            border-left-color: var(--primary-color);
            font-weight: 600;
        }

        .menu-item i {
            width: 20px;
            margin-right: 0.75rem;
        }

        /* ===================== CONTENIDO PRINCIPAL ===================== */
        .main-content {
            flex: 1;
            margin-left: var(--sidebar-width);
            padding: 2rem;
        }

        .content-header {
            background: var(--white);
            border-radius: var(--border-radius);
            padding: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: var(--shadow);
        }

        .content-title {
            font-size: 1.8rem;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .content-description {
            color: var(--gray-600);
            line-height: 1.5;
        }

        .content-body {
            background: var(--white);
            border-radius: var(--border-radius);
            padding: 2rem;
            box-shadow: var(--shadow);
        }

        /* ===================== TARJETAS DE PLANTELES ===================== */
        .planteles-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .plantel-card {
            background: var(--white);
            border-radius: var(--border-radius);
            padding: 1.5rem;
            box-shadow: var(--shadow);
            transition: var(--transition);
            border-left: 4px solid var(--primary-color);
        }

        .plantel-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
        }

        .plantel-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .plantel-icon {
            width: 60px;
            height: 60px;
            background: var(--primary-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: var(--white);
        }

        .plantel-info h3 {
            color: var(--primary-color);
            margin-bottom: 0.25rem;
        }

        .plantel-info p {
            color: var(--gray-600);
            font-size: 0.9rem;
        }

        .plantel-stats {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .stat-item {
            text-align: center;
            padding: 1rem;
            background: var(--gray-100);
            border-radius: 8px;
        }

        .stat-value {
            font-size: 1.5rem;
            font-weight: bold;
            color: var(--primary-color);
        }

        .stat-label {
            font-size: 0.8rem;
            color: var(--gray-600);
            margin-top: 0.25rem;
        }

        .plantel-actions {
            display: flex;
            gap: 0.5rem;
        }

        /* ===================== FORMULARIOS ===================== */
        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: var(--dark-color);
        }

        .form-input {
            width: 100%;
            padding: 0.75rem;
            border: 2px solid var(--gray-300);
            border-radius: 8px;
            font-size: 1rem;
            transition: var(--transition);
        }

        .form-input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(40, 167, 69, 0.1);
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-primary {
            background: var(--primary-color);
            color: var(--white);
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: var(--gray-500);
            color: var(--white);
        }

        .btn-success {
            background: var(--success-color);
            color: var(--white);
        }

        .btn-danger {
            background: var(--danger-color);
            color: var(--white);
        }

        .btn-warning {
            background: var(--warning-color);
            color: var(--dark-color);
        }

        /* ===================== TABLAS ===================== */
        .table-container {
            overflow-x: auto;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            margin-bottom: 2rem;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            background: var(--white);
        }

        .table th,
        .table td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid var(--gray-200);
        }

        .table th {
            background: var(--primary-light);
            color: var(--primary-dark);
            font-weight: 600;
        }

        .table tr:hover {
            background: var(--gray-100);
        }

        /* ===================== ESTADÍSTICAS ===================== */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: var(--white);
            border-radius: var(--border-radius);
            padding: 1.5rem;
            box-shadow: var(--shadow);
            text-align: center;
            border-left: 4px solid var(--primary-color);
        }

        .stat-number {
            font-size: 2rem;
            font-weight: bold;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }

        .stat-label-card {
            color: var(--gray-600);
            font-size: 0.9rem;
        }

        /* ===================== BADGES ===================== */
        .badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .badge-pending {
            background: var(--warning-color);
            color: var(--dark-color);
        }

        .badge-approved {
            background: var(--success-color);
            color: var(--white);
        }

        .badge-rejected {
            background: var(--danger-color);
            color: var(--white);
        }

        .badge-paid {
            background: var(--primary-color);
            color: var(--white);
        }

        /* ===================== RESPONSIVE ===================== */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                transition: var(--transition);
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .header-content {
                padding: 0 1rem;
            }

            .main-content {
                padding: 1rem;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            .planteles-grid {
                grid-template-columns: 1fr;
            }
        }

        /* ===================== ANIMACIONES ===================== */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .content-body, .plantel-card {
            animation: fadeIn 0.5s ease;
        }
    </style>
</head>
<body>
    <!-- ===================== HEADER ===================== -->
    <header class="header">
        <div class="header-content">
            <div class="logo-section">
                <img src="../assets/img/logo sin letras.png" alt="Logo IEFK" class="logo-img">
                <div class="logo-text">IEFK Admin</div>
            </div>
            
            <div class="breadcrumb">
                <a href="dashboard.php"><i class="fas fa-home"></i></a>
                <i class="fas fa-chevron-right"></i>
                <span>Finanzas</span>
                <?php if($plantel): ?>
                    <i class="fas fa-chevron-right"></i>
                    <span><?= ucfirst(str_replace('_', ' ', $plantel)) ?></span>
                <?php endif; ?>
            </div>

            <div class="user-info">
                <a href="dashboard.php" class="back-btn">
                    <i class="fas fa-arrow-left"></i>
                    Volver al Dashboard
                </a>
            </div>
        </div>
    </header>

    <!-- ===================== LAYOUT PRINCIPAL ===================== -->
    <div class="main-layout">
        <!-- ===================== SIDEBAR ===================== -->
        <nav class="sidebar">
            <div class="sidebar-header">
                <div class="sidebar-title">
                    <i class="fas fa-dollar-sign"></i>
                    Sistema Financiero
                </div>
            </div>
            
            <div class="sidebar-menu">
                <a href="?section=dashboard" class="menu-item <?= $section === 'dashboard' ? 'active' : '' ?>">
                    <i class="fas fa-chart-pie"></i>
                    Dashboard General
                </a>
                
                <a href="?section=pagos&plantel=zapote" class="menu-item <?= $section === 'pagos' && $plantel === 'zapote' ? 'active' : '' ?>">
                    <i class="fas fa-building"></i>
                    Plantel El Zapote
                </a>
                
                <a href="?section=pagos&plantel=rio_nilo" class="menu-item <?= $section === 'pagos' && $plantel === 'rio_nilo' ? 'active' : '' ?>">
                    <i class="fas fa-building"></i>
                    Plantel Río Nilo
                </a>
                
                <a href="?section=pagos&plantel=colinas" class="menu-item <?= $section === 'pagos' && $plantel === 'colinas' ? 'active' : '' ?>">
                    <i class="fas fa-building"></i>
                    Plantel Colinas
                </a>
                
                <a href="?section=reportes" class="menu-item <?= $section === 'reportes' ? 'active' : '' ?>">
                    <i class="fas fa-chart-bar"></i>
                    Reportes Consolidados
                </a>
                
                <a href="?section=configuracion" class="menu-item <?= $section === 'configuracion' ? 'active' : '' ?>">
                    <i class="fas fa-cog"></i>
                    Configuración
                </a>
            </div>
        </nav>

        <!-- ===================== CONTENIDO PRINCIPAL ===================== -->
        <main class="main-content">
            <?php
            switch($section) {
                case 'dashboard':
                    include 'financial_sections/dashboard_general.php';
                    break;
                case 'pagos':
                    include 'financial_sections/control_plantel.php';
                    break;
                case 'reportes':
                    include 'financial_sections/reportes_consolidados.php';
                    break;
                case 'configuracion':
                    include 'financial_sections/configuracion.php';
                    break;
                default:
                    include 'financial_sections/dashboard_general.php';
            }
            ?>
        </main>
    </div>

    <!-- ===================== SCRIPTS ===================== -->
    <script>
        // Función para formatear moneda
        function formatCurrency(amount) {
            return new Intl.NumberFormat('es-MX', {
                style: 'currency',
                currency: 'MXN'
            }).format(amount);
        }

        // Función para confirmar acciones
        function confirmAction(message) {
            return confirm(message);
        }

        // Validación de formularios
        function validateForm(formId) {
            const form = document.getElementById(formId);
            const inputs = form.querySelectorAll('input[required], select[required]');
            let isValid = true;

            inputs.forEach(input => {
                if (!input.value.trim()) {
                    input.style.borderColor = 'var(--danger-color)';
                    isValid = false;
                } else {
                    input.style.borderColor = 'var(--gray-300)';
                }
            });

            return isValid;
        }

        // Actualizar totales en tiempo real
        function updateTotals() {
            // Esta función se implementará en cada sección específica
            console.log('Actualizando totales...');
        }

        // Efectos visuales
        document.addEventListener('DOMContentLoaded', function() {
            // Animación de entrada para elementos
            const elements = document.querySelectorAll('.content-body, .plantel-card, .stat-card');
            elements.forEach((el, index) => {
                el.style.opacity = '0';
                el.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    el.style.transition = 'all 0.5s ease';
                    el.style.opacity = '1';
                    el.style.transform = 'translateY(0)';
                }, index * 100);
            });
        });
    </script>
</body>
</html>
