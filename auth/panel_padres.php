<?php
// 🔐 PANEL DE PADRES - PÁGINA DE PRUEBA
session_start();

// 📊 Incluir conexión a base de datos
include('../db.php');
$conexion = $conn; // Renombrar para consistencia

// 🔍 Verificar autenticación de padre
if (!isset($_SESSION['padre_id'])) {
    header("Location: login_padres.php");
    exit;
}

// 🔐 Validar sesión activa
$stmt_session = $conexion->prepare("
    SELECT fecha_expiracion, activa 
    FROM sesiones_padres 
    WHERE padre_id = ? AND session_token = ? AND activa = TRUE
");
$stmt_session->bind_param("is", $_SESSION['padre_id'], $_SESSION['session_token']);
$stmt_session->execute();
$session_result = $stmt_session->get_result();

if ($session_result->num_rows === 0) {
    // Sesión no válida
    session_destroy();
    header("Location: login_padres.php");
    exit;
}

$session_data = $session_result->fetch_assoc();
if (new DateTime() > new DateTime($session_data['fecha_expiracion'])) {
    // Sesión expirada
    $stmt_expire = $conexion->prepare("UPDATE sesiones_padres SET activa = FALSE WHERE padre_id = ? AND session_token = ?");
    $stmt_expire->bind_param("is", $_SESSION['padre_id'], $_SESSION['session_token']);
    $stmt_expire->execute();
    
    session_destroy();
    header("Location: login_padres.php");
    exit;
}

// 📊 Obtener información del padre
$stmt_padre = $conexion->prepare("
    SELECT pf.*, ta.fecha_limite, ta.tutor_parentesco
    FROM padres_familia pf
    JOIN tokens_acceso ta ON pf.token_id = ta.id
    WHERE pf.id = ?
");
$stmt_padre->bind_param("i", $_SESSION['padre_id']);
$stmt_padre->execute();
$padre = $stmt_padre->get_result()->fetch_assoc();

// 👶 Obtener información de menores
$stmt_menores = $conexion->prepare("
    SELECT id, nombre, fecha_nacimiento, servicio, plantel, estatus, documentos_completos
    FROM menores_admision 
    WHERE padre_id = ?
    ORDER BY nombre
");
$stmt_menores->bind_param("i", $_SESSION['padre_id']);
$stmt_menores->execute();
$menores = $stmt_menores->get_result()->fetch_all(MYSQLI_ASSOC);

// 📊 Calcular estadísticas
$total_menores = count($menores);
$documentos_pendientes = array_filter($menores, function($m) { return !$m['documentos_completos']; });
$admisiones_aprobadas = array_filter($menores, function($m) { return $m['estatus'] === 'aprobado'; });

// 🚪 Procesar logout
if (isset($_GET['logout'])) {
    // Invalidar sesión en BD
    $stmt_logout = $conexion->prepare("UPDATE sesiones_padres SET activa = FALSE WHERE padre_id = ? AND session_token = ?");
    $stmt_logout->bind_param("is", $_SESSION['padre_id'], $_SESSION['session_token']);
    $stmt_logout->execute();
    
    // Log de actividad
    $stmt_log = $conexion->prepare("
        INSERT INTO log_actividad_padres 
        (padre_id, accion, descripcion, ip_address)
        VALUES (?, 'logout', 'Cierre de sesión', ?)
    ");
    $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
    $stmt_log->bind_param("is", $_SESSION['padre_id'], $ip);
    $stmt_log->execute();
    
    session_destroy();
    header("Location: login_padres.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Portal - Instituto Educativo Frida Kahlo</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="icon" type="image/png" href="../assets/img/logo sin letras.png">
    <style>
        :root {
            --primary-color: #fb5c76;
            --primary-light: #fdd5dd;
            --primary-dark: #e54965;
            --success-color: #28a745;
            --danger-color: #dc3545;
            --warning-color: #ffc107;
            --info-color: #17a2b8;
            --light-color: #f8f9fa;
            --dark-color: #343a40;
            --white: #ffffff;
            --shadow: 0 4px 15px rgba(251, 92, 118, 0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: var(--light-color);
            color: var(--dark-color);
        }

        .header {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            color: var(--white);
            padding: 20px 0;
            box-shadow: var(--shadow);
        }

        .header-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo-section {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .logo {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            border: 2px solid var(--white);
        }

        .header-title {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .welcome-text {
            text-align: right;
        }

        .logout-btn {
            background: rgba(255, 255, 255, 0.2);
            color: var(--white);
            border: 1px solid rgba(255, 255, 255, 0.3);
            padding: 8px 16px;
            border-radius: 20px;
            text-decoration: none;
            transition: all 0.3s ease;
            font-size: 14px;
        }

        .logout-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            color: var(--white);
            text-decoration: none;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 30px 20px;
        }

        .welcome-banner {
            background: var(--white);
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: var(--shadow);
            text-align: center;
        }

        .welcome-banner h1 {
            color: var(--primary-color);
            font-size: 2.2rem;
            margin-bottom: 10px;
        }

        .welcome-banner p {
            font-size: 1.1rem;
            color: var(--dark-color);
            margin-bottom: 20px;
        }

        .test-badge {
            background: linear-gradient(135deg, var(--warning-color), #ff8f00);
            color: var(--white);
            padding: 10px 20px;
            border-radius: 25px;
            font-weight: bold;
            display: inline-block;
            margin-bottom: 20px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: var(--white);
            border-radius: 15px;
            padding: 25px;
            box-shadow: var(--shadow);
            text-align: center;
            border-left: 5px solid var(--primary-color);
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: bold;
            color: var(--primary-color);
            margin-bottom: 10px;
        }

        .stat-label {
            color: var(--dark-color);
            font-size: 1rem;
        }

        .children-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 25px;
            margin-bottom: 30px;
        }

        .child-card {
            background: var(--white);
            border-radius: 15px;
            padding: 25px;
            box-shadow: var(--shadow);
            transition: transform 0.3s ease;
        }

        .child-card:hover {
            transform: translateY(-5px);
        }

        .child-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
        }

        .child-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-light), var(--primary-color));
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: var(--primary-dark);
            font-weight: bold;
        }

        .child-name {
            font-size: 1.3rem;
            font-weight: bold;
            color: var(--primary-color);
        }

        .child-info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .info-item {
            display: flex;
            flex-direction: column;
        }

        .info-label {
            font-size: 12px;
            color: var(--dark-color);
            font-weight: bold;
            margin-bottom: 5px;
            text-transform: uppercase;
        }

        .info-value {
            color: var(--dark-color);
            font-size: 14px;
        }

        .status-badge {
            padding: 5px 12px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .status-pendiente {
            background: #fff3cd;
            color: #856404;
        }

        .status-aprobado {
            background: #d4edda;
            color: #155724;
        }

        .status-revision {
            background: #cce7ff;
            color: #004085;
        }

        .quick-actions {
            background: var(--white);
            border-radius: 15px;
            padding: 25px;
            box-shadow: var(--shadow);
            margin-bottom: 30px;
        }

        .quick-actions h3 {
            color: var(--primary-color);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .action-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
        }

        .action-btn {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            color: var(--white);
            padding: 15px 20px;
            border-radius: 12px;
            text-decoration: none;
            text-align: center;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(251, 92, 118, 0.3);
            color: var(--white);
            text-decoration: none;
        }

        .action-btn.secondary {
            background: linear-gradient(135deg, var(--info-color), #117a8b);
        }

        .action-btn.disabled {
            background: #ccc;
            cursor: not-allowed;
            transform: none;
        }

        .action-btn.disabled:hover {
            transform: none;
            box-shadow: none;
        }

        .security-info {
            background: var(--light-color);
            border-radius: 15px;
            padding: 20px;
            border-left: 5px solid var(--info-color);
        }

        .security-info h4 {
            color: var(--info-color);
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        @media (max-width: 768px) {
            .header-content {
                flex-direction: column;
                gap: 15px;
            }
            
            .children-grid {
                grid-template-columns: 1fr;
            }
            
            .child-info {
                grid-template-columns: 1fr;
            }
            
            .action-grid {
                grid-template-columns: 1fr;
            }
            
            .welcome-banner h1 {
                font-size: 1.8rem;
            }
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="header-content">
            <div class="logo-section">
                <img src="../assets/img/logo sin letras.png" alt="Logo IEFK" class="logo">
                <div>
                    <div class="header-title">Portal de Padres</div>
                    <div style="font-size: 0.9rem; opacity: 0.9;">Instituto Educativo Frida Kahlo</div>
                </div>
            </div>
            
            <div class="user-info">
                <div class="welcome-text">
                    <div style="font-weight: bold;"><?= htmlspecialchars($padre['nombre']) ?></div>
                    <div style="font-size: 0.85rem; opacity: 0.9;"><?= htmlspecialchars($padre['email']) ?></div>
                </div>
                <a href="?logout=1" class="logout-btn" onclick="return confirm('¿Estás seguro de que deseas cerrar sesión?')">
                    <i class="fas fa-sign-out-alt"></i> Salir
                </a>
            </div>
        </div>
    </header>

    <div class="container">
        <div class="welcome-banner">
            <div class="test-badge">
                <i class="fas fa-flask"></i> PÁGINA DE PRUEBA - DESARROLLO
            </div>
            <h1>¡Bienvenido(a) a tu Portal!</h1>
            <p>Aquí podrás gestionar toda la información relacionada con el proceso de admisión de tus hijos.</p>
            <p><strong>Fecha límite para documentación:</strong> <?= date('d/m/Y', strtotime($padre['fecha_limite'])) ?></p>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-number"><?= $total_menores ?></div>
                <div class="stat-label">Menores Registrados</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?= count($documentos_pendientes) ?></div>
                <div class="stat-label">Documentos Pendientes</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?= count($admisiones_aprobadas) ?></div>
                <div class="stat-label">Admisiones Aprobadas</div>
            </div>
        </div>

        <h2 style="color: var(--primary-color); margin-bottom: 20px;">
            <i class="fas fa-children"></i> Mis Hijos
        </h2>

        <div class="children-grid">
            <?php foreach ($menores as $menor): ?>
                <?php
                // Calcular edad
                $fecha_nac = new DateTime($menor['fecha_nacimiento']);
                $hoy = new DateTime();
                $edad = $hoy->diff($fecha_nac)->y;
                
                // Obtener inicial del nombre
                $inicial = strtoupper(substr($menor['nombre'], 0, 1));
                
                // Convertir datos para mostrar
                $servicios_nombres = [
                    'guarderia' => 'Guardería',
                    'preescolar' => 'Preescolar',
                    'primaria' => 'Primaria'
                ];
                
                $planteles_nombres = [
                    'zapote' => 'El Zapote (Matriz)',
                    'rio_nilo' => 'Río Nilo',
                    'colinas' => 'Colinas de Tonalá'
                ];
                ?>
                <div class="child-card">
                    <div class="child-header">
                        <div class="child-avatar"><?= $inicial ?></div>
                        <div>
                            <div class="child-name"><?= htmlspecialchars($menor['nombre']) ?></div>
                            <div style="color: var(--dark-color); font-size: 0.9rem;"><?= $edad ?> años</div>
                        </div>
                    </div>
                    
                    <div class="child-info">
                        <div class="info-item">
                            <span class="info-label">Servicio</span>
                            <span class="info-value"><?= $servicios_nombres[$menor['servicio']] ?? $menor['servicio'] ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Plantel</span>
                            <span class="info-value"><?= $planteles_nombres[$menor['plantel']] ?? $menor['plantel'] ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Estatus</span>
                            <span class="status-badge status-<?= $menor['estatus'] ?>"><?= ucfirst($menor['estatus']) ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Documentos</span>
                            <span class="info-value">
                                <?= $menor['documentos_completos'] ? '✅ Completos' : '⏳ Pendientes' ?>
                            </span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="quick-actions">
            <h3><i class="fas fa-bolt"></i> Acciones Rápidas</h3>
            <div class="action-grid">
                <a href="#" class="action-btn disabled">
                    <i class="fas fa-upload"></i> Subir Documentos
                </a>
                <a href="#" class="action-btn secondary disabled">
                    <i class="fas fa-file-alt"></i> Ver Expedientes
                </a>
                <a href="#" class="action-btn secondary disabled">
                    <i class="fas fa-comments"></i> Mensajes
                </a>
                <a href="#" class="action-btn secondary disabled">
                    <i class="fas fa-calendar"></i> Citas
                </a>
            </div>
            <p style="margin-top: 15px; color: var(--dark-color); font-size: 0.9rem;">
                <i class="fas fa-info-circle"></i> 
                <em>Las funcionalidades completas estarán disponibles en la versión final del portal.</em>
            </p>
        </div>

        <div class="security-info">
            <h4><i class="fas fa-shield-alt"></i> Información de Seguridad</h4>
            <ul style="margin: 0; padding-left: 20px; line-height: 1.6;">
                <li>Tu sesión está protegida y expira automáticamente por seguridad</li>
                <li>Solo tú puedes acceder a la información de tus hijos</li>
                <li>Todos los documentos se almacenan de forma segura y encriptada</li>
                <li>Recibirás notificaciones por email sobre cambios importantes</li>
            </ul>
        </div>
    </div>

    <script>
        // Auto-logout por inactividad (opcional)
        let inactivityTimer;
        const INACTIVITY_TIMEOUT = 30 * 60 * 1000; // 30 minutos

        function resetInactivityTimer() {
            clearTimeout(inactivityTimer);
            inactivityTimer = setTimeout(() => {
                if (confirm('Tu sesión está a punto de expirar por inactividad. ¿Deseas continuar?')) {
                    resetInactivityTimer();
                } else {
                    window.location.href = '?logout=1';
                }
            }, INACTIVITY_TIMEOUT);
        }

        // Detectar actividad del usuario
        ['mousedown', 'mousemove', 'keypress', 'scroll', 'touchstart'].forEach(event => {
            document.addEventListener(event, resetInactivityTimer, true);
        });

        // Iniciar timer
        resetInactivityTimer();

        // Mostrar información del sistema en consola
        console.log('🔐 Portal de Padres - IEFK');
        console.log('📊 Sistema de tokens seguros implementado');
        console.log('🛡️ Múltiples capas de seguridad activas');
    </script>
</body>
</html>
