<?php
// 🔒 VALIDAR SESIÓN DE ADMINISTRADOR
include('validar_sesion.php');

// Obtener la sección actual (por defecto: registrar)
$section = $_GET['section'] ?? 'registrar';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admisiones - Instituto Educativo Frida Kahlo</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="icon" type="image/png" href="../assets/img/logo sin letras.png">
    <style>
        /* ===================== VARIABLES CSS ===================== */
        :root {
            --primary-color: #fb5c76;
            --primary-light: #fdd5dd;
            --primary-dark: #e54965;
            --secondary-color: #ff9e35;
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
            --shadow: 0 4px 15px rgba(251, 92, 118, 0.1);
            --shadow-lg: 0 8px 25px rgba(251, 92, 118, 0.15);
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
            position: relative;
            padding: 0.5rem;
            border-radius: 4px;
            transition: var(--transition);
        }

        /* ✨ Efecto hover con línea blanca debajo */
        .breadcrumb a::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 2px;
            background: var(--white);
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }

        .breadcrumb a:hover::after {
            width: 80%;
        }

        .breadcrumb a:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateY(-1px);
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        /* 🍔 Botón hamburguesa para móviles */
        .mobile-menu-btn {
            display: none;
            background: var(--primary-color);
            color: var(--white);
            border: none;
            padding: 0.75rem;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1.2rem;
            transition: var(--transition);
            order: -1;
        }

        .mobile-menu-btn:hover {
            background: var(--primary-dark);
            transform: scale(1.05);
        }

        .mobile-menu-btn i {
            transition: transform 0.3s ease;
        }

        .mobile-menu-btn.active i {
            transform: rotate(90deg);
        }

        /* 📱 RESPONSIVE DESIGN - Media Queries */
        
        /* 💻 Desktop Grande (1920px+) */
        @media (min-width: 1920px) {
            .main-content {
                max-width: 1600px;
                margin-left: auto;
                margin-right: auto;
                padding-left: calc(var(--sidebar-width) + 2rem);
            }
            
            .dashboard-stats {
                grid-template-columns: repeat(4, 1fr);
                gap: 2rem;
            }
        }

        /* 💻 Mac Standard (1440px - 1919px) */
        @media (max-width: 1919px) and (min-width: 1440px) {
            .dashboard-stats {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        /* 📱 iPad Pro (1024px - 1439px) */
        @media (max-width: 1439px) and (min-width: 1024px) {
            .sidebar {
                width: 240px;
            }
            
            .main-content {
                margin-left: 240px;
            }
            
            .dashboard-stats {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .header {
                padding: 1rem 1.5rem;
            }
        }

        /* 📱 iPad Standard (768px - 1023px) */
        @media (max-width: 1023px) and (min-width: 768px) {
            .main-content {
                margin-left: 0;
                width: 100%;
            }
            
            .mobile-menu-btn {
                display: block;
            }
            
            /* 🏠 Ocultar breadcrumb en tablets */
            .breadcrumb {
                display: none;
            }
            
            /* 📱 Optimizar botón volver - solo ícono */
            .back-btn .btn-text {
                display: none;
            }
            
            .dashboard-stats {
                grid-template-columns: repeat(2, 1fr);
                gap: 1rem;
            }
            
            .header {
                padding: 1rem;
            }
            
            .stat-card {
                padding: 1.5rem;
            }
        }

        /* 📱 iPhone Pro Max (414px - 767px) */
        @media (max-width: 767px) and (min-width: 414px) {
            .main-content {
                margin-left: 0;
                width: 100%;
                padding: 1rem;
                margin-top: 0;
            }
            
            .main-layout {
                margin-top: 60px;
            }
            
            .mobile-menu-btn {
                display: block;
            }
            
            /* 🏠 Ocultar breadcrumb completamente */
            .breadcrumb {
                display: none;
            }
            
            /* 📱 Optimizar botón volver - solo ícono */
            .back-btn .btn-text {
                display: none;
            }
            
            .back-btn {
                padding: 0.5rem;
                min-width: 40px;
                justify-content: center;
            }
            
            .dashboard-stats {
                grid-template-columns: 1fr;
                gap: 1rem;
            }
            
            .header {
                padding: 0.75rem;
                flex-wrap: nowrap;
                gap: 0.5rem;
                justify-content: space-between;
            }
            
            .user-info {
                flex-direction: row;
                align-items: center;
                gap: 0.5rem;
            }
            
            .stat-card {
                padding: 1.25rem;
                text-align: center;
            }
        }

        /* 📱 iPhone Standard (375px - 413px) */
        @media (max-width: 413px) {
            .main-content {
                margin-left: 0;
                width: 100%;
                padding: 0.75rem;
                margin-top: 0;
            }
            
            .main-layout {
                margin-top: 50px;
            }
            
            .mobile-menu-btn {
                display: block;
                padding: 0.5rem;
                font-size: 1rem;
            }
            
            /* 🏠 Ocultar breadcrumb completamente */
            .breadcrumb {
                display: none;
            }
            
            /* 📱 Optimizar botón volver - solo ícono */
            .back-btn .btn-text {
                display: none;
            }
            
            .back-btn {
                padding: 0.5rem;
                min-width: 40px;
                justify-content: center;
            }
            
            .dashboard-stats {
                grid-template-columns: 1fr;
                gap: 0.75rem;
            }
            
            .header {
                padding: 0.5rem;
                justify-content: space-between;
                align-items: center;
                gap: 0.5rem;
            }
            
            .user-info {
                flex-direction: row;
                align-items: center;
                width: auto;
                justify-content: flex-end;
            }
            
            .stat-card {
                padding: 1rem;
                text-align: center;
            }
            
            .stat-card h3 {
                font-size: 1.5rem;
            }
        }

        /* 📱 iPhone SE y dispositivos pequeños (320px - 374px) */
        @media (max-width: 374px) {
            .sidebar {
                width: 90%;
            }
            
            .main-content {
                padding: 0.5rem;
            }
            
            .header {
                padding: 0.5rem;
            }
            
            .mobile-menu-btn {
                padding: 0.4rem;
                font-size: 0.9rem;
            }
            
            .stat-card {
                padding: 0.75rem;
            }
            
            .stat-card h3 {
                font-size: 1.25rem;
            }
            
            .stat-card p {
                font-size: 0.875rem;
            }
        }

        /* 🎭 Overlay para móviles cuando el sidebar está abierto */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .sidebar-overlay.active {
            display: block;
            opacity: 1;
        }

        /* 🔄 Animaciones suaves para transiciones */
        @media (max-width: 1023px) {
            .sidebar, .main-content, .mobile-menu-btn {
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            }
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

        /* 🔒 En móviles/tablets el sidebar está oculto por defecto */
        @media (max-width: 1023px) {
            .sidebar {
                left: -100%;
                z-index: 1001;
                top: 0;
                height: 100vh;
                width: 260px;
                transition: left 0.3s ease;
            }
            
            .sidebar.active {
                left: 0;
            }
        }

        /* 📱 Para dispositivos muy pequeños, sidebar más angosto */
        @media (max-width: 413px) {
            .sidebar {
                width: 85%;
            }
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
            box-shadow: 0 0 0 3px rgba(251, 92, 118, 0.1);
        }

        .form-textarea {
            min-height: 100px;
            resize: vertical;
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

        /* ===================== TABLAS ===================== */
        .table-container {
            overflow-x: auto;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
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

        /* ===================== TARJETAS ===================== */
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

        .stat-label {
            color: var(--gray-600);
            font-size: 0.9rem;
        }

        /* ===================== ESTADOS/BADGES ===================== */
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

        .badge-sent {
            background: var(--info-color);
            color: var(--white);
        }

        /* ===================== RESPONSIVE ===================== */
        @media (max-width: 768px) {
            .main-content {
                margin-left: 0;
                padding: 1rem;
            }

            .header-content {
                padding: 0 1rem;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }
        }

        /* ===================== ANIMACIONES ===================== */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .content-body {
            animation: fadeIn 0.5s ease;
        }
    </style>
</head>
<body>
    <!-- ===================== HEADER ===================== -->
    <header class="header">
        <div class="header-content">
            <!-- 🍔 Botón hamburguesa para móviles -->
            <button class="mobile-menu-btn" id="mobileMenuBtn">
                <i class="fas fa-bars"></i>
            </button>
            
            <div class="logo-section">
                <img src="../assets/img/logo sin letras.png" alt="Logo IEFK" class="logo-img">
                <div class="logo-text">IEFK Admin</div>
            </div>
            
            <div class="breadcrumb">
                <a href="dashboard.php"><i class="fas fa-home"></i></a> <!-- 🔄 Volver a .php -->
                <i class="fas fa-chevron-right"></i>
                <span>Admisiones</span>
            </div>

            <div class="user-info">
                <a href="dashboard.php" class="back-btn"> <!-- 🔄 Volver a .php -->
                    <i class="fas fa-arrow-left"></i>
                    <span class="btn-text">Volver al Dashboard</span>
                </a>
            </div>
        </div>
    </header>

    <!-- ===================== LAYOUT PRINCIPAL ===================== -->
    <!-- 🎭 Overlay para móviles -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>
    
    <div class="main-layout">
        <!-- ===================== SIDEBAR ===================== -->
        <nav class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <div class="sidebar-title">
                    <i class="fas fa-clipboard-list"></i>
                    Sistema de Admisiones
                </div>
            </div>
            
            <div class="sidebar-menu">
                <a href="?section=registrar" class="menu-item <?= $section === 'registrar' ? 'active' : '' ?>">
                    <i class="fas fa-plus-circle"></i>
                    Registrar Nueva Admisión
                </a>
                
                <a href="?section=invitaciones" class="menu-item <?= $section === 'invitaciones' ? 'active' : '' ?>">
                    <i class="fas fa-envelope"></i>
                    Invitaciones Enviadas
                </a>
                
                <a href="?section=eliminadas" class="menu-item <?= $section === 'eliminadas' ? 'active' : '' ?>">
                    <i class="fas fa-trash-alt"></i>
                    Admisiones Eliminadas
                </a>
                
                <a href="?section=tutores" class="menu-item <?= $section === 'tutores' ? 'active' : '' ?>">
                    <i class="fas fa-users"></i>
                    Gestión de Tutores
                </a>
                
                <a href="?section=revision" class="menu-item <?= $section === 'revision' ? 'active' : '' ?>">
                    <i class="fas fa-search"></i>
                    Revisión de Documentación
                </a>
            </div>
        </nav>

        <!-- ===================== CONTENIDO PRINCIPAL ===================== -->
        <main class="main-content">
            <?php
            switch($section) {
                case 'registrar':
                    include 'sections/registrar_admision.php';
                    break;
                case 'invitaciones':
                    include 'sections/invitaciones_enviadas.php';
                    break;
                case 'eliminadas':
                    include 'sections/admisiones_eliminadas.php';
                    break;
                case 'tutores':
                    include 'sections/gestion_tutores.php';
                    break;
                case 'revision':
                    include 'sections/revision_documentacion.php';
                    break;
                default:
                    include 'sections/registrar_admision.php';
            }
            ?>
        </main>
    </div>

    <!-- ===================== SCRIPTS ===================== -->
    <script>
        // Confirmar acciones peligrosas
        function confirmDelete(action) {
            return confirm(`¿Estás seguro de que deseas ${action}? Esta acción no se puede deshacer.`);
        }

        // Validación de formularios
        function validateForm(formId) {
            const form = document.getElementById(formId);
            const inputs = form.querySelectorAll('input[required], select[required], textarea[required]');
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

        // Envío de formulario con validación
        function submitForm(formId, action) {
            if (validateForm(formId)) {
                const form = document.getElementById(formId);
                // Aquí se puede agregar AJAX para envío sin recarga
                console.log(`Enviando formulario: ${formId} - Acción: ${action}`);
                return true;
            } else {
                alert('Por favor, complete todos los campos requeridos.');
                return false;
            }
        }

        // 📱 FUNCIONALIDAD PRINCIPAL DEL MENÚ MÓVIL
        document.addEventListener('DOMContentLoaded', function() {
            // Animación de entrada para elementos
            const elements = document.querySelectorAll('.content-body, .stat-card');
            elements.forEach((el, index) => {
                el.style.opacity = '0';
                el.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    el.style.transition = 'all 0.5s ease';
                    el.style.opacity = '1';
                    el.style.transform = 'translateY(0)';
                }, index * 100);
            });

            // 🍔 Elementos del menú móvil
            const mobileMenuBtn = document.getElementById('mobileMenuBtn');
            const sidebar = document.getElementById('sidebar');
            const sidebarOverlay = document.getElementById('sidebarOverlay');

            // ✅ Función principal para abrir/cerrar el sidebar
            function toggleMobileMenu() {
                const isActive = sidebar.classList.contains('active');
                
                console.log('🍔 Toggle menu - Estado actual:', isActive ? 'ABIERTO' : 'CERRADO');
                
                if (isActive) {
                    // ❌ Cerrar sidebar
                    sidebar.classList.remove('active');
                    sidebarOverlay.classList.remove('active');
                    mobileMenuBtn.classList.remove('active');
                    document.body.style.overflow = '';
                    console.log('🚪 Menu CERRADO');
                } else {
                    // ✅ Abrir sidebar
                    sidebar.classList.add('active');
                    sidebarOverlay.classList.add('active');
                    mobileMenuBtn.classList.add('active');
                    document.body.style.overflow = 'hidden';
                    console.log('🚪 Menu ABIERTO');
                }
            }

            // 🎯 Event listener para botón hamburguesa
            if (mobileMenuBtn) {
                mobileMenuBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    console.log('🍔 Click en botón hamburguesa');
                    toggleMobileMenu();
                });
                console.log('✅ Botón hamburguesa conectado');
            } else {
                console.error('❌ No se encontró el botón hamburguesa');
            }

            // 🎯 Event listener para overlay
            if (sidebarOverlay) {
                sidebarOverlay.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    console.log('🎭 Click en overlay');
                    toggleMobileMenu();
                });
                console.log('✅ Overlay conectado');
            } else {
                console.error('❌ No se encontró el overlay');
            }

            // 🔗 Cerrar sidebar al hacer clic en enlaces del menú
            if (sidebar) {
                const menuItems = sidebar.querySelectorAll('.menu-item');
                console.log('🔗 Enlaces encontrados:', menuItems.length);
                
                menuItems.forEach((item, index) => {
                    item.addEventListener('click', () => {
                        console.log(`🔗 Click en enlace ${index + 1}`);
                        if (window.innerWidth <= 1023) {
                            setTimeout(() => {
                                toggleMobileMenu();
                            }, 150);
                        }
                    });
                });
            } else {
                console.error('❌ No se encontró el sidebar');
            }

            // 📏 Manejar redimensionado de ventana
            window.addEventListener('resize', () => {
                if (window.innerWidth > 1023) {
                    // 🖥️ Restablecer estado en desktop
                    sidebar.classList.remove('active');
                    sidebarOverlay.classList.remove('active');
                    mobileMenuBtn.classList.remove('active');
                    document.body.style.overflow = '';
                    console.log('🖥️ Modo desktop - menu resetado');
                }
            });

            // 🔒 Prevenir scroll del body cuando el sidebar está abierto
            document.addEventListener('touchmove', function(e) {
                if (sidebar.classList.contains('active') && !sidebar.contains(e.target)) {
                    e.preventDefault();
                }
            }, { passive: false });

            // ⌨️ Cerrar menú con tecla ESC
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && sidebar.classList.contains('active')) {
                    console.log('⌨️ ESC presionado - cerrando menu');
                    toggleMobileMenu();
                }
            });

            // 🔍 Verificación inicial
            console.log('🔍 Verificación inicial:');
            console.log('- Botón hamburguesa:', mobileMenuBtn ? '✅' : '❌');
            console.log('- Sidebar:', sidebar ? '✅' : '❌');
            console.log('- Overlay:', sidebarOverlay ? '✅' : '❌');
            console.log('- Ancho de ventana:', window.innerWidth);
        });
    </script>
</body>
</html>
