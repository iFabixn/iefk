<?php
// 🔐 RESTABLECER CONTRASEÑA - PORTAL DE PADRES
session_start();

// Si ya está logueado, redirigir al panel
if (isset($_SESSION['padre_id'])) {
    header("Location: panel_padres.php");
    exit;
}

include('../db.php');
$conexion = $conn;

$token = $_GET['token'] ?? '';
$error = "";
$mensaje = "";
$token_valido = false;
$padre_info = null;

// Verificar token
if (empty($token)) {
    $error = "Token de recuperación no válido.";
} else {
    try {
        $stmt = $conexion->prepare("
            SELECT tr.*, pf.nombre, pf.email 
            FROM tokens_recuperacion_padres tr
            JOIN padres_familia pf ON tr.padre_id = pf.id
            WHERE tr.token = ? AND tr.usado = FALSE AND tr.fecha_expiracion > NOW()
        ");
        $stmt->bind_param("s", $token);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 0) {
            $error = "El enlace de recuperación ha expirado o ya fue utilizado. Solicita un nuevo enlace.";
        } else {
            $token_valido = true;
            $padre_info = $result->fetch_assoc();
        }
    } catch (Exception $e) {
        $error = "Error interno del sistema.";
        error_log("Error verificando token de recuperación: " . $e->getMessage());
    }
}

// Procesar cambio de contraseña
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $token_valido) {
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    
    if (empty($password) || empty($confirm_password)) {
        $error = "Por favor, completa todos los campos.";
    } elseif ($password !== $confirm_password) {
        $error = "Las contraseñas no coinciden.";
    } elseif (strlen($password) < 8) {
        $error = "La contraseña debe tener al menos 8 caracteres.";
    } elseif (!preg_match('/[A-Z]/', $password)) {
        $error = "La contraseña debe contener al menos una letra mayúscula.";
    } elseif (!preg_match('/[a-z]/', $password)) {
        $error = "La contraseña debe contener al menos una letra minúscula.";
    } elseif (!preg_match('/[0-9]/', $password)) {
        $error = "La contraseña debe contener al menos un número.";
    } else {
        try {
            $conexion->begin_transaction();
            
            // Hash de la nueva contraseña
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            
            // Actualizar contraseña del padre
            $stmt_update = $conexion->prepare("
                UPDATE padres_familia 
                SET password_hash = ?, intentos_fallidos = 0, bloqueado_hasta = NULL 
                WHERE id = ?
            ");
            $stmt_update->bind_param("si", $password_hash, $padre_info['padre_id']);
            
            if (!$stmt_update->execute()) {
                throw new Exception("Error al actualizar la contraseña");
            }
            
            // Marcar token como usado
            $stmt_token = $conexion->prepare("
                UPDATE tokens_recuperacion_padres 
                SET usado = TRUE 
                WHERE id = ?
            ");
            $stmt_token->bind_param("i", $padre_info['id']);
            
            if (!$stmt_token->execute()) {
                throw new Exception("Error al marcar token como usado");
            }
            
            // Invalidar todas las sesiones activas del usuario
            $stmt_sessions = $conexion->prepare("
                DELETE FROM sesiones_padres 
                WHERE padre_id = ?
            ");
            $stmt_sessions->bind_param("i", $padre_info['padre_id']);
            $stmt_sessions->execute();
            
            // Invalidar todos los tokens de recuperación del usuario
            $stmt_invalidate = $conexion->prepare("
                UPDATE tokens_recuperacion_padres 
                SET usado = TRUE 
                WHERE padre_id = ? AND usado = FALSE
            ");
            $stmt_invalidate->bind_param("i", $padre_info['padre_id']);
            $stmt_invalidate->execute();
            
            $conexion->commit();
            
            $mensaje = "Tu contraseña ha sido actualizada exitosamente. Ya puedes iniciar sesión con tu nueva contraseña.";
            
        } catch (Exception $e) {
            $conexion->rollback();
            $error = "Error interno del sistema. Por favor, intenta más tarde.";
            error_log("Error al restablecer contraseña: " . $e->getMessage());
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restablecer Contraseña - Instituto Educativo Frida Kahlo</title>
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
            background: linear-gradient(135deg, var(--primary-light), var(--white));
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .reset-container {
            background: var(--white);
            border-radius: 20px;
            box-shadow: var(--shadow);
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

        .reset-badge {
            background: linear-gradient(135deg, var(--success-color), #1e7e34);
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

        .alert-info {
            background: #e7f3ff;
            color: #0c5460;
            border: 1px solid #bee5eb;
        }

        .user-info {
            background: var(--primary-light);
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 30px;
            text-align: left;
        }

        .user-info h4 {
            color: var(--primary-dark);
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
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

        .password-requirements {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 15px;
            margin-top: 10px;
        }

        .requirement {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 5px 0;
            font-size: 14px;
        }

        .requirement.valid {
            color: var(--success-color);
        }

        .requirement.invalid {
            color: var(--danger-color);
        }

        .btn {
            background: linear-gradient(135deg, var(--success-color), #1e7e34);
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
            box-shadow: 0 8px 25px rgba(40, 167, 69, 0.3);
        }

        .btn:disabled {
            background: #ccc;
            cursor: not-allowed;
            transform: none;
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

        .login-link {
            background: var(--primary-color);
            color: var(--white);
            padding: 12px 25px;
            border-radius: 8px;
            text-decoration: none;
            display: inline-block;
            margin-top: 15px;
            font-weight: bold;
            transition: all 0.3s ease;
        }

        .login-link:hover {
            background: var(--primary-dark);
            color: var(--white);
            text-decoration: none;
            transform: translateY(-2px);
        }

        @media (max-width: 768px) {
            .reset-container {
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
    <div class="reset-container">
        <img src="../assets/img/logo sin letras.png" alt="Logo IEFK" class="logo">
        
        <h1 class="title">Restablecer Contraseña</h1>
        <p class="subtitle">Instituto Educativo Frida Kahlo</p>
        
        <div class="reset-badge">
            <i class="fas fa-shield-alt"></i> Creación de Nueva Contraseña
        </div>

        <?php if (!empty($mensaje)): ?>
            <div class="success-message">
                <div class="success-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <h3 style="color: var(--success-color); margin-bottom: 15px;">
                    ¡Contraseña Actualizada!
                </h3>
                <div class="alert alert-success">
                    <strong><i class="fas fa-lock"></i> <?php echo htmlspecialchars($mensaje); ?></strong>
                </div>
                
                <a href="login_padres.php" class="login-link">
                    <i class="fas fa-sign-in-alt"></i> Iniciar Sesión
                </a>
            </div>

        <?php elseif (!$token_valido): ?>
            <div class="alert alert-danger">
                <h4><i class="fas fa-exclamation-triangle"></i> Token No Válido</h4>
                <p><?php echo htmlspecialchars($error); ?></p>
            </div>
            
            <a href="recuperar_password_padres.php" class="login-link">
                <i class="fas fa-key"></i> Solicitar Nuevo Enlace
            </a>

        <?php else: ?>
            <?php if (!empty($error)): ?>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle"></i> <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <div class="user-info">
                <h4><i class="fas fa-user"></i> Restableciendo contraseña para:</h4>
                <p><strong><?php echo htmlspecialchars($padre_info['nombre']); ?></strong></p>
                <p><?php echo htmlspecialchars($padre_info['email']); ?></p>
            </div>

            <div class="alert alert-info">
                <h4><i class="fas fa-info-circle"></i> Crear Nueva Contraseña</h4>
                <p>Establece una contraseña segura que cumpla con todos los requisitos de seguridad.</p>
            </div>

            <form method="POST" id="resetForm">
                <div class="form-group">
                    <label for="password" class="form-label">
                        <i class="fas fa-lock"></i> Nueva Contraseña
                    </label>
                    <input type="password" id="password" name="password" class="form-input" 
                           placeholder="Ingresa tu nueva contraseña" required>
                    
                    <div class="password-requirements">
                        <div class="requirement" id="req-length">
                            <i class="fas fa-times-circle"></i>
                            <span>Al menos 8 caracteres</span>
                        </div>
                        <div class="requirement" id="req-upper">
                            <i class="fas fa-times-circle"></i>
                            <span>Al menos una letra mayúscula</span>
                        </div>
                        <div class="requirement" id="req-lower">
                            <i class="fas fa-times-circle"></i>
                            <span>Al menos una letra minúscula</span>
                        </div>
                        <div class="requirement" id="req-number">
                            <i class="fas fa-times-circle"></i>
                            <span>Al menos un número</span>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="confirm_password" class="form-label">
                        <i class="fas fa-lock"></i> Confirmar Nueva Contraseña
                    </label>
                    <input type="password" id="confirm_password" name="confirm_password" class="form-input" 
                           placeholder="Confirma tu nueva contraseña" required>
                </div>

                <button type="submit" class="btn" id="submitBtn" disabled>
                    <i class="fas fa-shield-alt"></i> Actualizar Contraseña
                </button>
            </form>
        <?php endif; ?>

        <a href="login_padres.php" class="back-link">
            <i class="fas fa-arrow-left"></i> Volver al login
        </a>
    </div>

    <script>
        // Validación en tiempo real de contraseña
        const passwordInput = document.getElementById('password');
        const confirmPasswordInput = document.getElementById('confirm_password');
        const submitBtn = document.getElementById('submitBtn');

        function updateRequirement(id, isValid) {
            const element = document.getElementById(id);
            if (!element) return;
            
            const icon = element.querySelector('i');
            
            if (isValid) {
                element.classList.add('valid');
                element.classList.remove('invalid');
                icon.className = 'fas fa-check-circle';
            } else {
                element.classList.add('invalid');
                element.classList.remove('valid');
                icon.className = 'fas fa-times-circle';
            }
        }

        function validatePassword() {
            if (!passwordInput || !confirmPasswordInput || !submitBtn) return;
            
            const password = passwordInput.value;
            const confirmPassword = confirmPasswordInput.value;

            // Validar requisitos
            updateRequirement('req-length', password.length >= 8);
            updateRequirement('req-upper', /[A-Z]/.test(password));
            updateRequirement('req-lower', /[a-z]/.test(password));
            updateRequirement('req-number', /[0-9]/.test(password));

            // Verificar si todos los requisitos se cumplen
            const allValid = password.length >= 8 && 
                            /[A-Z]/.test(password) && 
                            /[a-z]/.test(password) && 
                            /[0-9]/.test(password) &&
                            password === confirmPassword &&
                            password.length > 0;

            submitBtn.disabled = !allValid;
        }

        if (passwordInput && confirmPasswordInput) {
            passwordInput.addEventListener('input', validatePassword);
            confirmPasswordInput.addEventListener('input', validatePassword);
        }

        // Prevenir envío si no es válido
        document.getElementById('resetForm')?.addEventListener('submit', function(e) {
            if (submitBtn && submitBtn.disabled) {
                e.preventDefault();
                alert('Por favor, completa todos los requisitos de la contraseña.');
            }
        });

        // Auto-focus en contraseña
        document.addEventListener('DOMContentLoaded', function() {
            if (passwordInput) {
                passwordInput.focus();
            }
        });
    </script>
</body>
</html>
