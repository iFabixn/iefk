<?php
// 🔒 VALIDAR SESIÓN DE ADMINISTRADOR
include('validar_sesion.php');
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Instituto Educativo Frida Kahlo</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="icon" type="image/png" href="../assets/img/logo sin letras.png">
    <style>
        /* ===================== VARIABLES CSS ===================== */
        :root {
            --primary-color: #fb5c76;
            --primary-dark: #e54965;
            --secondary-color: #ff9e35;
            --success-color: #28a745;
            --warning-color: #ffc107;
            --danger-color: #dc3545;
            --info-color: #17a2b8;
            --light-color: #f8f9fa;
            --dark-color: #343a40;
            --white: #ffffff;
            --shadow: 0 4px 15px rgba(251, 92, 118, 0.1);
            --shadow-hover: 0 8px 25px rgba(251, 92, 118, 0.15);
            --border-radius: 12px;
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
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            color: var(--dark-color);
        }

        /* ===================== HEADER ===================== */
        .dashboard-header {
            background: var(--white);
            box-shadow: var(--shadow);
            padding: 1rem 2rem;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .header-content {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo-section {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .logo-img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
        }

        .logo-text {
            font-size: 1.5rem;
            font-weight: bold;
            color: var(--primary-color);
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 1rem;
            color: var(--dark-color);
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            background: var(--primary-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            font-weight: bold;
        }

        /* ===================== MAIN CONTENT ===================== */
        .dashboard-main {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 2rem;
        }

        .welcome-section {
            background: var(--white);
            border-radius: var(--border-radius);
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: var(--shadow);
            text-align: center;
        }

        .welcome-title {
            font-size: 2rem;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }

        .welcome-subtitle {
            color: var(--dark-color);
            opacity: 0.8;
        }

        /* ===================== DASHBOARD GRID ===================== */
        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
            margin-top: 2rem;
        }

        .dashboard-card {
            background: var(--white);
            border-radius: var(--border-radius);
            padding: 1.5rem;
            box-shadow: var(--shadow);
            transition: var(--transition);
            text-decoration: none;
            color: inherit;
            position: relative;
            overflow: hidden;
        }

        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-hover);
            text-decoration: none;
            color: inherit;
        }

        .dashboard-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: var(--card-color, var(--primary-color));
        }

        .card-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
            font-size: 1.5rem;
            color: var(--white);
            background: var(--card-color, var(--primary-color));
        }

        .card-title {
            font-size: 1.2rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
            color: var(--dark-color);
        }

        .card-description {
            color: var(--dark-color);
            opacity: 0.7;
            font-size: 0.9rem;
            line-height: 1.4;
        }

        /* ===================== COLORES ESPECÍFICOS ===================== */
        .card-admissions { --card-color: var(--primary-color); }
        .card-finances { --card-color: var(--success-color); }
        .card-students { --card-color: var(--info-color); }
        .card-staff { --card-color: var(--warning-color); }
        .card-tickets { --card-color: #6f42c1; }
        .card-attendance { --card-color: #fd7e14; }
        .card-users { --card-color: #20c997; }
        .card-settings { --card-color: var(--dark-color); }
        .card-logout { --card-color: var(--danger-color); }

        /* ===================== RESPONSIVE ===================== */
        @media (max-width: 768px) {
            .dashboard-main {
                padding: 0 1rem;
            }

            .header-content {
                padding: 0 1rem;
            }

            .dashboard-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .welcome-section {
                padding: 1.5rem;
            }

            .welcome-title {
                font-size: 1.5rem;
            }
        }

        /* ===================== ANIMACIONES ===================== */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .dashboard-card {
            animation: fadeInUp 0.6s ease forwards;
        }

        .dashboard-card:nth-child(1) { animation-delay: 0.1s; }
        .dashboard-card:nth-child(2) { animation-delay: 0.2s; }
        .dashboard-card:nth-child(3) { animation-delay: 0.3s; }
        .dashboard-card:nth-child(4) { animation-delay: 0.4s; }
        .dashboard-card:nth-child(5) { animation-delay: 0.5s; }
        .dashboard-card:nth-child(6) { animation-delay: 0.6s; }
        .dashboard-card:nth-child(7) { animation-delay: 0.7s; }
        .dashboard-card:nth-child(8) { animation-delay: 0.8s; }
        .dashboard-card:nth-child(9) { animation-delay: 0.9s; }
        .dashboard-card:nth-child(10) { animation-delay: 1s; }
        .dashboard-card:nth-child(11) { animation-delay: 1.1s; }
    </style>
</head>
<body>
    <!-- ===================== HEADER ===================== -->
    <header class="dashboard-header">
        <div class="header-content">
            <div class="logo-section">
                <img src="../assets/img/logo sin letras.png" alt="Logo IEFK" class="logo-img">
                <div class="logo-text">IEFK Admin</div>
            </div>
            <div class="user-info">
                <div class="user-avatar"><?= strtoupper(substr($_SESSION['admin_nombre'], 0, 1)) ?></div>
                <span>Bienvenido, <?= $_SESSION['admin_nombre'] ?></span>
            </div>
        </div>
    </header>

    <!-- ===================== MAIN CONTENT ===================== -->
    <main class="dashboard-main">
        <!-- Sección de bienvenida -->
        <section class="welcome-section">
            <h1 class="welcome-title">Panel de Administración</h1>
            <p class="welcome-subtitle">Gestiona todos los aspectos del Instituto Educativo Frida Kahlo desde aquí</p>
        </section>

        <!-- Grid de opciones del dashboard -->
        <div class="dashboard-grid">
            <!-- Admisiones -->
            <a href="admissions.php" class="dashboard-card card-admissions">
                <div class="card-icon">
                    <i class="fas fa-clipboard-list"></i>
                </div>
                <h3 class="card-title">Admisiones</h3>
                <p class="card-description">Gestiona el proceso de inscripción y admisión de nuevos estudiantes</p>
            </a>

            <!-- Finanzas -->
            <a href="finances.php" class="dashboard-card card-finances">
                <div class="card-icon">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <h3 class="card-title">Finanzas</h3>
                <p class="card-description">Control de pagos, mensualidades y gestión financiera del instituto</p>
            </a>

            <!-- Alumnado -->
            <a href="students.php" class="dashboard-card card-students">
                <div class="card-icon">
                    <i class="fas fa-user-graduate"></i>
                </div>
                <h3 class="card-title">Alumnado</h3>
                <p class="card-description">Administra la información y expedientes de todos los estudiantes</p>
            </a>

            <!-- Personal -->
            <a href="staff.php" class="dashboard-card card-staff">
                <div class="card-icon">
                    <i class="fas fa-users"></i>
                </div>
                <h3 class="card-title">Personal</h3>
                <p class="card-description">Gestión del personal docente y administrativo del instituto</p>
            </a>

            <!-- Tickets -->
            <a href="tickets.php" class="dashboard-card card-tickets">
                <div class="card-icon">
                    <i class="fas fa-ticket-alt"></i>
                </div>
                <h3 class="card-title">Tickets</h3>
                <p class="card-description">Sistema de soporte y gestión de incidencias</p>
            </a>

            <!-- QR Asistencia -->
            <a href="attendance.php" class="dashboard-card card-attendance">
                <div class="card-icon">
                    <i class="fas fa-qrcode"></i>
                </div>
                <h3 class="card-title">Control QR</h3>
                <p class="card-description">Sistema de asistencia mediante códigos QR</p>
            </a>

            <!-- Usuarios Registrados -->
            <a href="usuarios_registrados.php" class="dashboard-card card-users">
                <div class="card-icon">
                    <i class="fas fa-user-friends"></i>
                </div>
                <h3 class="card-title">Usuarios Registrados</h3>
                <p class="card-description">Lista y gestión de usuarios registrados en el sistema</p>
            </a>

            <!-- Portal de Prueba (Solo desarrollo) -->
            <a href="../auth/test_access.php" class="dashboard-card" style="--card-color: #17a2b8;">
                <div class="card-icon">
                    <i class="fas fa-flask"></i>
                </div>
                <h3 class="card-title">Portal de Admisiones (Prueba)</h3>
                <p class="card-description">Acceso de prueba al portal de admisiones para padres</p>
            </a>

            <!-- Configuración -->
            <a href="settings.php" class="dashboard-card card-settings">
                <div class="card-icon">
                    <i class="fas fa-cog"></i>
                </div>
                <h3 class="card-title">Configuración</h3>
                <p class="card-description">Ajustes del sistema y configuración general</p>
            </a>

            <!-- Cerrar Sesión -->
            <a href="logout.php" class="dashboard-card card-logout">
                <div class="card-icon">
                    <i class="fas fa-sign-out-alt"></i>
                </div>
                <h3 class="card-title">Cerrar Sesión</h3>
                <p class="card-description">Salir del panel de administración de forma segura</p>
            </a>
        </div>
    </main>

    <!-- ===================== SCRIPTS ===================== -->
    <script>
        // Efectos de hover adicionales
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.dashboard-card');
            
            cards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-8px) scale(1.02)';
                });
                
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0) scale(1)';
                });
            });
        });
    </script>
</body>
</html>
