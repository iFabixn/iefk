<?php
include_once 'db.php';

// Obtener la sección actual
$section = $_GET['section'] ?? 'scanner';

// Datos de ejemplo para estudiantes
$estudiantes_ejemplo = [
    [
        'id' => 'STU001',
        'nombre' => 'Ana Sofia Martinez',
        'grado' => '3er Grado',
        'grupo' => 'A',
        'plantel' => 'El Zapote',
        'padre_nombre' => 'Carlos Martinez',
        'padre_id' => 'PAD001',
        'entrada_programada' => '08:00',
        'salida_programada' => '14:00',
        'foto' => 'ana_sofia.jpg'
    ],
    [
        'id' => 'STU002',
        'nombre' => 'Diego Alejandro Ruiz',
        'grado' => '1er Grado',
        'grupo' => 'B',
        'plantel' => 'Insurgentes',
        'padre_nombre' => 'Maria Elena Ruiz',
        'padre_id' => 'PAD002',
        'entrada_programada' => '07:30',
        'salida_programada' => '13:30',
        'foto' => 'diego_alejandro.jpg'
    ]
];

// Datos de ejemplo para maestras
$maestras_ejemplo = [
    [
        'id' => 'MAE001',
        'nombre' => 'Profesora Laura Gonzalez',
        'grado' => '2do Grado',
        'plantel' => 'El Zapote',
        'entrada_programada' => '07:00',
        'salida_programada' => '15:00',
        'foto' => 'laura_gonzalez.jpg'
    ]
];

// Registros de asistencia del día
$asistencias_hoy = [
    [
        'persona_id' => 'STU001',
        'tipo' => 'estudiante',
        'entrada' => '08:05',
        'salida' => null,
        'escaneado_por' => 'PAD001',
        'horas_extra_entrada' => 0,
        'horas_extra_salida' => 0
    ],
    [
        'persona_id' => 'MAE001',
        'tipo' => 'maestra',
        'entrada' => '06:55',
        'salida' => null,
        'escaneado_por' => 'MAE001',
        'horas_extra_entrada' => 0,
        'horas_extra_salida' => 0
    ]
];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Control QR - Asistencias | Instituto Educativo Frida Kahlo</title>
    <link rel="stylesheet" href="../assets/css/index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.3.8/html5-qrcode.min.js"></script>
    <style>
        :root {
            --primary-color: #ff7f00;
            --primary-light: rgba(255, 127, 0, 0.1);
            --primary-dark: #e66a00;
            --secondary-color: #ffb366;
            --accent-color: #ff9933;
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
            --dark: #1a1a1a;
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
            max-width: 1400px;
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

        .btn-secondary:hover {
            background: var(--gray-600);
        }

        .btn-outline-primary {
            background: transparent;
            color: var(--primary-color);
            border: 2px solid var(--primary-color);
        }

        .btn-outline-primary:hover {
            background: var(--primary-color);
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

        .section-content {
            background: var(--white);
            padding: 2rem;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            min-height: 600px;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .fade-in {
            animation: fadeIn 0.5s ease;
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

        @media (max-width: 768px) {
            .container {
                padding: 1rem;
            }

            .nav-tabs {
                flex-direction: column;
                gap: 0.5rem;
            }

            .nav-tab {
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>
                <i class="fas fa-qrcode"></i>
                Control QR - Sistema de Asistencias
            </h1>
            <p>Gestión integral de entradas, salidas y control de horarios</p>
        </div>

        <!-- Navigation Tabs -->
        <div class="nav-tabs">
            <a href="?section=scanner" class="nav-tab <?= $section === 'scanner' ? 'active' : '' ?>">
                <i class="fas fa-camera"></i>
                Escáner QR
            </a>
            <a href="?section=asistencias_hoy" class="nav-tab <?= $section === 'asistencias_hoy' ? 'active' : '' ?>">
                <i class="fas fa-calendar-day"></i>
                Asistencias de Hoy
            </a>
            <a href="?section=reportes_mensuales" class="nav-tab <?= $section === 'reportes_mensuales' ? 'active' : '' ?>">
                <i class="fas fa-chart-bar"></i>
                Reportes Mensuales
            </a>
            <a href="?section=horas_extras" class="nav-tab <?= $section === 'horas_extras' ? 'active' : '' ?>">
                <i class="fas fa-clock"></i>
                Horas Extras
            </a>
            <a href="?section=credenciales" class="nav-tab <?= $section === 'credenciales' ? 'active' : '' ?>">
                <i class="fas fa-id-card"></i>
                Gestión de Credenciales
            </a>
            <a href="?section=configuracion" class="nav-tab <?= $section === 'configuracion' ? 'active' : '' ?>">
                <i class="fas fa-cog"></i>
                Configuración
            </a>
        </div>

        <!-- Content Section -->
        <div class="section-content fade-in">
            <?php
            switch($section) {
                case 'scanner':
                    include 'attendance_sections/scanner_qr.php';
                    break;
                case 'asistencias_hoy':
                    include 'attendance_sections/asistencias_hoy.php';
                    break;
                case 'reportes_mensuales':
                    include 'attendance_sections/reportes_mensuales.php';
                    break;
                case 'horas_extras':
                    include 'attendance_sections/gestion_horas_extra.php';
                    break;
                case 'credenciales':
                    include 'attendance_sections/credenciales.php';
                    break;
                case 'configuracion':
                    include 'attendance_sections/configuracion.php';
                    break;
                default:
                    include 'attendance_sections/scanner_qr.php';
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

        // Función global para formatear fechas
        function formatearFecha(fecha) {
            return new Date(fecha).toLocaleDateString('es-MX', {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });
        }

        // Función global para formatear horas
        function formatearHora(hora) {
            return new Date(`2000-01-01 ${hora}`).toLocaleTimeString('es-MX', {
                hour: '2-digit',
                minute: '2-digit'
            });
        }
    </script>
</body>
</html>