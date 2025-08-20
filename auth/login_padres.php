<?php
// 🔐 LOGIN EXCLUSIVO PARA PADRES DE FAMILIA
session_start();

// 📊 Incluir conexión a base de datos
include('../db.php');
$conexion = $conn; // Renombrar para consistencia

// 🔍 Verificar si ya está logueado como padre
if (isset($_SESSION['padre_id'])) {
    header("Location: panel_padres.php");
    exit;
}

// 📧 Obtener email si viene de activación
$email_activado = $_GET['email'] ?? '';
$mensaje_activacion = isset($_GET['activado']) ? true : false;
$ya_activado = isset($_GET['ya_activado']) ? true : false;

$error = '';
$success = '';

if ($mensaje_activacion) {
    $success = "¡Cuenta activada exitosamente! Ahora puedes iniciar sesión.";
} elseif ($ya_activado) {
    $success = "Tu cuenta ya fue activada anteriormente. Puedes iniciar sesión directamente.";
}

// 🔐 Procesar login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    
    if (empty($email) || empty($password)) {
        $error = "Por favor, ingresa tu email y contraseña.";
    } else {
        // 🔍 Buscar padre en base de datos
        $stmt = $conexion->prepare("
            SELECT id, email, nombre, password_hash, activo, intentos_fallidos, bloqueado_hasta
            FROM padres_familia 
            WHERE email = ?
        ");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $resultado = $stmt->get_result();
        
        if ($resultado->num_rows === 0) {
            $error = "Email no registrado en nuestro sistema.";
        } else {
            $padre = $resultado->fetch_assoc();
            
            // Verificar si está bloqueado
            if ($padre['bloqueado_hasta'] && new DateTime() < new DateTime($padre['bloqueado_hasta'])) {
                $error = "Cuenta temporalmente bloqueada. Intenta más tarde.";
            } elseif (!$padre['activo']) {
                $error = "Cuenta desactivada. Contacta a la administración.";
            } elseif (password_verify($password, $padre['password_hash'])) {
                // ✅ Login exitoso
                
                // Resetear intentos fallidos
                $stmt_reset = $conexion->prepare("
                    UPDATE padres_familia 
                    SET intentos_fallidos = 0, bloqueado_hasta = NULL, ultimo_acceso = NOW()
                    WHERE id = ?
                ");
                $stmt_reset->bind_param("i", $padre['id']);
                $stmt_reset->execute();
                
                // 🔐 Crear sesión segura
                $session_token = bin2hex(random_bytes(32));
                $ip_address = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
                $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? 'unknown';
                $fecha_expiracion = date('Y-m-d H:i:s', strtotime('+8 hours'));
                
                $stmt_session = $conexion->prepare("
                    INSERT INTO sesiones_padres 
                    (padre_id, session_token, ip_address, user_agent, fecha_expiracion)
                    VALUES (?, ?, ?, ?, ?)
                ");
                $stmt_session->bind_param("issss", $padre['id'], $session_token, $ip_address, $user_agent, $fecha_expiracion);
                $stmt_session->execute();
                
                // 📝 Log de actividad
                $stmt_log = $conexion->prepare("
                    INSERT INTO log_actividad_padres 
                    (padre_id, accion, descripcion, ip_address, user_agent)
                    VALUES (?, 'login', 'Inicio de sesión exitoso', ?, ?)
                ");
                $stmt_log->bind_param("iss", $padre['id'], $ip_address, $user_agent);
                $stmt_log->execute();
                
                // Establecer variables de sesión
                $_SESSION['padre_id'] = $padre['id'];
                $_SESSION['padre_email'] = $padre['email'];
                $_SESSION['padre_nombre'] = $padre['nombre'];
                $_SESSION['session_token'] = $session_token;
                $_SESSION['login_time'] = time();
                
                // Forzar escritura de sesión antes de redirección
                session_write_close();
                session_start();
                
                header("Location: panel_padres.php");
                exit;
                
            } else {
                // ❌ Contraseña incorrecta
                $intentos = $padre['intentos_fallidos'] + 1;
                
                if ($intentos >= 5) {
                    // Bloquear por 30 minutos
                    $bloqueado_hasta = date('Y-m-d H:i:s', strtotime('+30 minutes'));
                    $stmt_block = $conexion->prepare("
                        UPDATE padres_familia 
                        SET intentos_fallidos = ?, bloqueado_hasta = ?
                        WHERE id = ?
                    ");
                    $stmt_block->bind_param("isi", $intentos, $bloqueado_hasta, $padre['id']);
                    $stmt_block->execute();
                    
                    $error = "Demasiados intentos fallidos. Cuenta bloqueada por 30 minutos.";
                } else {
                    $stmt_intentos = $conexion->prepare("
                        UPDATE padres_familia 
                        SET intentos_fallidos = ?
                        WHERE id = ?
                    ");
                    $stmt_intentos->bind_param("ii", $intentos, $padre['id']);
                    $stmt_intentos->execute();
                    
                    $restantes = 5 - $intentos;
                    $error = "Contraseña incorrecta. Te quedan {$restantes} intentos.";
                }
                
                // Log del intento fallido
                $stmt_log = $conexion->prepare("
                    INSERT INTO log_actividad_padres 
                    (padre_id, accion, descripcion, ip_address, user_agent)
                    VALUES (?, 'login_fallido', 'Intento de login con contraseña incorrecta', ?, ?)
                ");
                $stmt_log->bind_param("iss", $padre['id'], $ip_address, $user_agent);
                $stmt_log->execute();
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal de Padres - Instituto Educativo Frida Kahlo</title>
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
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-container {
            background: var(--white);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            padding: 50px;
            max-width: 450px;
            width: 100%;
            text-align: center;
        }

        .logo {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            margin-bottom: 30px;
            border: 4px solid var(--primary-light);
        }

        .title {
            color: var(--primary-color);
            font-size: 2.2rem;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .subtitle {
            color: var(--dark-color);
            font-size: 1.1rem;
            margin-bottom: 30px;
        }

        .parents-badge {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            color: var(--white);
            padding: 8px 20px;
            border-radius: 25px;
            font-size: 0.9rem;
            font-weight: bold;
            margin-bottom: 30px;
            display: inline-block;
        }

        .alert {
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            text-align: left;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-danger {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .form-group {
            margin-bottom: 25px;
            text-align: left;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: var(--dark-color);
        }

        .form-input {
            width: 100%;
            padding: 15px;
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(251, 92, 118, 0.1);
        }

        .btn {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            color: var(--white);
            border: none;
            padding: 15px 30px;
            border-radius: 12px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
            margin-bottom: 20px;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(251, 92, 118, 0.3);
        }

        .forgot-password {
            color: var(--primary-color);
            text-decoration: none;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .forgot-password:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }

        .security-info {
            background: var(--light-color);
            border-radius: 12px;
            padding: 20px;
            margin-top: 30px;
            text-align: left;
        }

        .security-info h4 {
            color: var(--primary-color);
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .security-info ul {
            color: var(--dark-color);
            font-size: 14px;
            line-height: 1.6;
        }

        .footer-links {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e0e0e0;
        }

        .footer-links a {
            color: var(--primary-color);
            text-decoration: none;
            margin: 0 10px;
            font-size: 14px;
        }

        @media (max-width: 768px) {
            .login-container {
                padding: 30px 20px;
                margin: 0 10px;
            }
            
            .title {
                font-size: 1.8rem;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <img src="../assets/img/logo sin letras.png" alt="Logo IEFK" class="logo">
        
        <h1 class="title">Portal de Padres</h1>
        <p class="subtitle">Instituto Educativo Frida Kahlo</p>
        
        <div class="parents-badge">
            <i class="fas fa-users"></i> Acceso Exclusivo para Padres de Familia
        </div>

        <?php if ($success): ?>
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> <?= htmlspecialchars($success) ?>
            </div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-triangle"></i> <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label for="email" class="form-label">
                    <i class="fas fa-envelope"></i> Correo Electrónico
                </label>
                <input type="email" id="email" name="email" class="form-input" 
                       placeholder="tu@email.com" 
                       value="<?= htmlspecialchars($email_activado) ?>"
                       required autofocus>
            </div>

            <div class="form-group">
                <label for="password" class="form-label">
                    <i class="fas fa-lock"></i> Contraseña
                </label>
                <input type="password" id="password" name="password" class="form-input" 
                       placeholder="Tu contraseña segura" required>
            </div>

            <button type="submit" class="btn">
                <i class="fas fa-sign-in-alt"></i> Ingresar al Portal
            </button>
        </form>

        <a href="recuperar_password_padres.php" class="forgot-password">
            <i class="fas fa-key"></i> ¿Olvidaste tu contraseña?
        </a>

        <div class="security-info">
            <h4><i class="fas fa-shield-alt"></i> Información de Seguridad</h4>
            <ul>
                <li>Tu sesión expira automáticamente por seguridad</li>
                <li>Después de 5 intentos fallidos, la cuenta se bloquea temporalmente</li>
                <li>Solo puedes acceder desde este portal exclusivo para padres</li>
                <li>Nunca compartas tus credenciales de acceso</li>
            </ul>
        </div>

        <div class="footer-links">
            <a href="../index.php"><i class="fas fa-home"></i> Inicio</a>
            <a href="../quienessomos.php"><i class="fas fa-info-circle"></i> Acerca del Instituto</a>
            <a href="mailto:admisiones@iefk.edu.mx"><i class="fas fa-envelope"></i> Contacto</a>
        </div>
    </div>

    <script>
        // Auto-focus en email si no está pre-llenado
        document.addEventListener('DOMContentLoaded', function() {
            const emailInput = document.getElementById('email');
            const passwordInput = document.getElementById('password');
            
            if (emailInput.value.trim() !== '') {
                passwordInput.focus();
            } else {
                emailInput.focus();
            }
        });

        // Validación básica del formulario
        document.querySelector('form').addEventListener('submit', function(e) {
            const email = document.getElementById('email').value.trim();
            const password = document.getElementById('password').value;
            
            if (!email || !password) {
                e.preventDefault();
                alert('Por favor, completa todos los campos.');
                return false;
            }
            
            if (!email.includes('@')) {
                e.preventDefault();
                alert('Por favor, ingresa un correo electrónico válido.');
                return false;
            }
        });
    </script>
</body>
</html>
