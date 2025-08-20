<?php
// 🔑 RECUPERACIÓN DE CONTRASEÑA - PORTAL DE PADRES
session_start();

// Si ya está logueado, redirigir al panel
if (isset($_SESSION['padre_id'])) {
    header("Location: panel_padres.php");
    exit;
}

include('../db.php');
$conexion = $conn;

$mensaje = "";
$error = "";
$email_enviado = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    
    if (empty($email)) {
        $error = "Por favor, ingresa tu correo electrónico.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Por favor, ingresa un correo electrónico válido.";
    } else {
        try {
            // Verificar si el email existe y está activo
            $stmt = $conexion->prepare("SELECT id, nombre FROM padres_familia WHERE email = ? AND activo = 1");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows === 0) {
                $error = "No se encontró una cuenta activa con ese correo electrónico.";
            } else {
                $padre = $result->fetch_assoc();
                
                // Verificar si ya existe un token activo reciente (últimos 5 minutos)
                $stmt_check = $conexion->prepare("
                    SELECT id FROM tokens_recuperacion_padres 
                    WHERE email = ? AND usado = FALSE 
                    AND fecha_creacion > DATE_SUB(NOW(), INTERVAL 5 MINUTE)
                ");
                $stmt_check->bind_param("s", $email);
                $stmt_check->execute();
                $result_check = $stmt_check->get_result();
                
                if ($result_check->num_rows > 0) {
                    $error = "Ya se envió un correo de recuperación recientemente. Por favor, espera 5 minutos antes de solicitar otro.";
                } else {
                    // Generar token único
                    $token = bin2hex(random_bytes(32));
                    $fecha_expiracion = date('Y-m-d H:i:s', strtotime('+24 hours'));
                    $ip_address = $_SERVER['REMOTE_ADDR'] ?? '';
                    $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? '';
                    
                    // Invalidar tokens anteriores del mismo usuario
                    $stmt_invalidate = $conexion->prepare("
                        UPDATE tokens_recuperacion_padres 
                        SET usado = TRUE 
                        WHERE padre_id = ? AND usado = FALSE
                    ");
                    $stmt_invalidate->bind_param("i", $padre['id']);
                    $stmt_invalidate->execute();
                    
                    // Insertar nuevo token
                    $stmt_insert = $conexion->prepare("
                        INSERT INTO tokens_recuperacion_padres 
                        (padre_id, token, email, fecha_expiracion, ip_solicitud, user_agent) 
                        VALUES (?, ?, ?, ?, ?, ?)
                    ");
                    $stmt_insert->bind_param("isssss", $padre['id'], $token, $email, $fecha_expiracion, $ip_address, $user_agent);
                    
                    if ($stmt_insert->execute()) {
                        // Enviar email de recuperación
                        include('../config/email_recuperacion.php');
                        $enlace_recuperacion = "http://localhost/iefk/auth/restablecer_password.php?token=" . $token;
                        
                        $email_enviado_exitoso = enviar_email_recuperacion($email, $padre['nombre'], $enlace_recuperacion);
                        
                        if ($email_enviado_exitoso) {
                            $mensaje = "Se ha enviado un correo con las instrucciones para restablecer tu contraseña.";
                            $email_enviado = true;
                        } else {
                            // Si falla el email, mostrar enlace directo para debug
                            $mensaje = "Hubo un problema enviando el correo. Usa el enlace de debug abajo.";
                            $email_enviado = true; // Mostrar la pantalla de éxito con debug
                        }
                    } else {
                        $error = "Error interno. Por favor, intenta más tarde.";
                    }
                }
            }
        } catch (Exception $e) {
            $error = "Error interno del sistema. Por favor, intenta más tarde.";
            error_log("Error en recuperación de contraseña: " . $e->getMessage());
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña - Instituto Educativo Frida Kahlo</title>
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

        .recovery-container {
            background: var(--white);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            padding: 50px;
            max-width: 500px;
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

        .recovery-badge {
            background: linear-gradient(135deg, var(--warning-color), #e0a800);
            color: var(--dark-color);
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

        .alert-info {
            background: #e7f3ff;
            color: #0c5460;
            border: 1px solid #bee5eb;
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

        .back-link {
            color: var(--primary-color);
            text-decoration: none;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .back-link:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }

        .info-box {
            background: var(--light-color);
            border-radius: 12px;
            padding: 20px;
            margin-top: 30px;
            text-align: left;
        }

        .info-box h4 {
            color: var(--primary-color);
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .info-box ul {
            color: var(--dark-color);
            font-size: 14px;
            line-height: 1.6;
        }

        .success-message {
            background: var(--light-color);
            border: 2px solid var(--success-color);
            border-radius: 15px;
            padding: 30px;
            margin: 20px 0;
        }

        .success-icon {
            font-size: 3rem;
            color: var(--success-color);
            margin-bottom: 20px;
        }

        .debug-link {
            background: var(--info-color);
            color: var(--white);
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            display: inline-block;
            margin-top: 15px;
            font-size: 14px;
        }

        @media (max-width: 768px) {
            .recovery-container {
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
    <div class="recovery-container">
        <img src="../assets/img/logo sin letras.png" alt="Logo IEFK" class="logo">
        
        <h1 class="title">Recuperar Contraseña</h1>
        <p class="subtitle">Instituto Educativo Frida Kahlo</p>
        
        <div class="recovery-badge">
            <i class="fas fa-key"></i> Restablecimiento de Contraseña
        </div>

        <?php if ($email_enviado): ?>
            <div class="success-message">
                <div class="success-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <h3 style="color: var(--success-color); margin-bottom: 15px;">
                    ¡Correo Enviado!
                </h3>
                <div class="alert alert-success">
                    <strong><i class="fas fa-envelope"></i> <?php echo htmlspecialchars($mensaje); ?></strong>
                    <p style="margin-top: 10px;">
                        Revisa tu bandeja de entrada y sigue las instrucciones del correo. 
                        El enlace de recuperación es válido por 24 horas.
                    </p>
                </div>
                
                <!-- ENLACE DE DEBUG - Remover en producción -->
                <div class="alert alert-info">
                    <strong><i class="fas fa-code"></i> Modo Debug (Solo para desarrollo):</strong>
                    <br>
                    <a href="<?php echo $enlace_recuperacion; ?>" class="debug-link">
                        <i class="fas fa-external-link-alt"></i> Ir directamente a restablecer contraseña
                    </a>
                </div>
            </div>
        <?php else: ?>
            <?php if (!empty($error)): ?>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle"></i> <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <div class="alert alert-info">
                <h4><i class="fas fa-info-circle"></i> ¿Olvidaste tu contraseña?</h4>
                <p>Ingresa tu correo electrónico y te enviaremos un enlace para restablecer tu contraseña de forma segura.</p>
            </div>

            <form method="POST">
                <div class="form-group">
                    <label for="email" class="form-label">
                        <i class="fas fa-envelope"></i> Correo Electrónico
                    </label>
                    <input type="email" id="email" name="email" class="form-input" 
                           placeholder="tu@email.com" 
                           value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>"
                           required autofocus>
                </div>

                <button type="submit" class="btn">
                    <i class="fas fa-paper-plane"></i> Enviar Enlace de Recuperación
                </button>
            </form>
        <?php endif; ?>

        <a href="login_padres.php" class="back-link">
            <i class="fas fa-arrow-left"></i> Volver al login
        </a>

        <?php if (!$email_enviado): ?>
            <div class="info-box">
                <h4><i class="fas fa-shield-alt"></i> Información de Seguridad</h4>
                <ul>
                    <li>El enlace de recuperación expira en 24 horas</li>
                    <li>Solo puedes solicitar un enlace cada 5 minutos</li>
                    <li>Al crear una nueva contraseña, se invalidarán todos los tokens anteriores</li>
                    <li>Si no recibes el correo, revisa tu carpeta de spam</li>
                </ul>
            </div>
        <?php endif; ?>
    </div>

    <script>
        // Auto-focus en email
        document.addEventListener('DOMContentLoaded', function() {
            const emailInput = document.getElementById('email');
            if (emailInput) {
                emailInput.focus();
            }
        });

        // Validación del formulario
        document.querySelector('form')?.addEventListener('submit', function(e) {
            const email = document.getElementById('email')?.value.trim();
            
            if (!email) {
                e.preventDefault();
                alert('Por favor, ingresa tu correo electrónico.');
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
