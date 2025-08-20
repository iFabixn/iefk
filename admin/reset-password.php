<?php
session_start();
include('../db.php');

$message = "";
$error = "";
$valid_token = false;
$token = "";

// Verificar si hay un token en la URL
if (isset($_GET['token'])) {
    $token = $_GET['token'];
    
    // Verificar que el token sea válido y no haya expirado
    $stmt = $conn->prepare("
        SELECT pr.admin_id, pr.expires_at, a.correo, a.nombre 
        FROM password_resets pr 
        JOIN admins a ON pr.admin_id = a.id 
        WHERE pr.token = ? AND pr.expires_at > NOW() AND pr.used = 0
    ");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $res = $stmt->get_result();
    
    if ($res->num_rows === 1) {
        $valid_token = true;
        $reset_data = $res->fetch_assoc();
    } else {
        $error = "El enlace de recuperación es inválido o ha expirado. Solicita uno nuevo.";
    }
}

// Procesar el formulario de nueva contraseña
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $valid_token) {
    $new_password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    // Validaciones
    if (strlen($new_password) < 8) {
        $error = "La contraseña debe tener al menos 8 caracteres.";
    } elseif ($new_password !== $confirm_password) {
        $error = "Las contraseñas no coinciden.";
    } elseif (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)/', $new_password)) {
        $error = "La contraseña debe contener al menos una mayúscula, una minúscula y un número.";
    } else {
        // Actualizar la contraseña
        $password_hash = password_hash($new_password, PASSWORD_DEFAULT);
        
        $stmt = $conn->prepare("UPDATE admins SET password_hash = ? WHERE id = ?");
        $stmt->bind_param("si", $password_hash, $reset_data['admin_id']);
        
        if ($stmt->execute()) {
            // Marcar el token como usado
            $stmt = $conn->prepare("UPDATE password_resets SET used = 1 WHERE token = ?");
            $stmt->bind_param("s", $token);
            $stmt->execute();
            
            // Enviar correo de confirmación
            $to = $reset_data['correo'];
            $subject = "IEFK - Contraseña Actualizada";
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            $headers .= "From: noreply@iefk.edu.mx" . "\r\n";
            
            $email_body = "
            <!DOCTYPE html>
            <html>
            <head>
                <meta charset='UTF-8'>
                <style>
                    body { font-family: 'Inter', Arial, sans-serif; line-height: 1.6; color: #374151; }
                    .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                    .header { background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; padding: 30px; text-align: center; border-radius: 10px 10px 0 0; }
                    .content { background: #f9fafb; padding: 30px; }
                    .footer { background: #374151; color: #9ca3af; padding: 20px; text-align: center; border-radius: 0 0 10px 10px; font-size: 14px; }
                    .success-box { background: #d1fae5; border: 1px solid #10b981; padding: 20px; border-radius: 8px; margin: 20px 0; text-align: center; }
                </style>
            </head>
            <body>
                <div class='container'>
                    <div class='header'>
                        <h1>🔒 IEFK</h1>
                        <h2>Contraseña Actualizada</h2>
                    </div>
                    <div class='content'>
                        <h3>Hola, " . htmlspecialchars($reset_data['nombre']) . "</h3>
                        
                        <div class='success-box'>
                            <h3>✅ ¡Contraseña actualizada exitosamente!</h3>
                            <p>Tu contraseña ha sido cambiada correctamente.</p>
                        </div>
                        
                        <p>Tu contraseña de administrador ha sido actualizada el " . date('d/m/Y \a \l\a\s H:i') . ".</p>
                        
                        <p><strong>Detalles de seguridad:</strong></p>
                        <ul>
                            <li>Fecha: " . date('d/m/Y H:i:s') . "</li>
                            <li>IP: " . $_SERVER['REMOTE_ADDR'] . "</li>
                            <li>Navegador: " . $_SERVER['HTTP_USER_AGENT'] . "</li>
                        </ul>
                        
                        <p>Si no realizaste este cambio, contacta inmediatamente al administrador del sistema.</p>
                        
                        <p style='text-align: center; margin: 30px 0;'>
                            <a href='http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']) . "/login.php' 
                               style='display: inline-block; background: #1e3a8a; color: white; padding: 15px 30px; text-decoration: none; border-radius: 8px; font-weight: bold;'>
                               Iniciar Sesión
                            </a>
                        </p>
                    </div>
                    <div class='footer'>
                        <p>&copy; " . date('Y') . " Instituto Educativo Frida Kahlo</p>
                        <p>Este es un correo automático, por favor no responder.</p>
                    </div>
                </div>
            </body>
            </html>";
            
            mail($to, $subject, $email_body, $headers);
            
            $message = "Tu contraseña ha sido actualizada exitosamente. Ya puedes iniciar sesión con tu nueva contraseña.";
        } else {
            $error = "Error al actualizar la contraseña. Inténtalo de nuevo.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IEFK - Restablecer Contraseña</title>
    
    <!-- 🔖 Favicon -->
    <link rel="icon" type="image/png" href="../assets/img/logo sin letras.png">
    <link rel="shortcut icon" type="image/png" href="../assets/img/logo sin letras.png">
    <link rel="apple-touch-icon" href="../assets/img/logo sin letras.png">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #1e3a8a;
            --primary-dark: #1e40af;
            --secondary-color: #3b82f6;
            --success-color: #10b981;
            --error-color: #ef4444;
            --warning-color: #f59e0b;
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-400: #9ca3af;
            --gray-500: #6b7280;
            --gray-600: #4b5563;
            --gray-700: #374151;
            --white: #ffffff;
            --font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            --transition: all 0.2s ease-in-out;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: var(--font-family);
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .reset-container {
            background: var(--white);
            border-radius: 1rem;
            box-shadow: var(--shadow-xl);
            overflow: hidden;
            width: 100%;
            max-width: 450px;
            animation: slideIn 0.6s ease-out;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .reset-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            color: var(--white);
            padding: 2rem;
            text-align: center;
        }

        .logo i {
            font-size: 3rem;
            margin-bottom: 0.5rem;
            display: block;
        }

        .logo h1 {
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
        }

        .logo p {
            font-size: 0.875rem;
            opacity: 0.8;
        }

        .reset-form {
            padding: 2rem;
        }

        .form-description {
            text-align: center;
            margin-bottom: 2rem;
            color: var(--gray-600);
            line-height: 1.6;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--gray-700);
            margin-bottom: 0.5rem;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper i {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray-400);
            font-size: 0.875rem;
            z-index: 1;
        }

        .form-input {
            width: 100%;
            padding: 0.75rem 1rem 0.75rem 2.75rem;
            border: 2px solid var(--gray-200);
            border-radius: 0.5rem;
            font-size: 0.875rem;
            font-family: var(--font-family);
            transition: var(--transition);
        }

        .form-input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(30, 58, 138, 0.1);
        }

        .form-input:focus + i {
            color: var(--primary-color);
        }

        .password-requirements {
            background: var(--gray-50);
            border: 1px solid var(--gray-200);
            border-radius: 0.5rem;
            padding: 1rem;
            margin-top: 0.5rem;
            font-size: 0.75rem;
        }

        .password-requirements h4 {
            color: var(--gray-700);
            margin-bottom: 0.5rem;
        }

        .password-requirements ul {
            list-style: none;
            padding: 0;
        }

        .password-requirements li {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 0.25rem;
            color: var(--gray-600);
        }

        .password-requirements .check {
            color: var(--success-color);
        }

        .password-requirements .cross {
            color: var(--error-color);
        }

        .submit-btn {
            width: 100%;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            color: var(--white);
            border: none;
            padding: 0.875rem 1rem;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
        }

        .submit-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        .submit-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .success-message {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.1) 0%, rgba(16, 185, 129, 0.05) 100%);
            border: 1px solid rgba(16, 185, 129, 0.2);
            color: var(--success-color);
            padding: 1rem;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            margin-bottom: 1rem;
            display: flex;
            align-items: flex-start;
            gap: 0.5rem;
        }

        .error-message {
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.1) 0%, rgba(239, 68, 68, 0.05) 100%);
            border: 1px solid rgba(239, 68, 68, 0.2);
            color: var(--error-color);
            padding: 1rem;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .back-to-login {
            text-align: center;
            margin-top: 1.5rem;
        }

        .back-to-login a {
            color: var(--primary-color);
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 500;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .back-to-login a:hover {
            color: var(--primary-dark);
        }

        .footer {
            background: var(--gray-50);
            padding: 1rem 2rem;
            text-align: center;
            border-top: 1px solid var(--gray-200);
        }

        .footer p {
            font-size: 0.75rem;
            color: var(--gray-500);
            margin: 0;
        }

        /* Responsive */
        @media (max-width: 480px) {
            body {
                padding: 0.5rem;
            }

            .reset-container {
                max-width: 100%;
            }

            .reset-header {
                padding: 1.5rem;
            }

            .reset-form {
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="reset-container">
        <!-- Header -->
        <div class="reset-header">
            <div class="logo">
                <i class="fas fa-shield-alt"></i>
                <h1>Nueva Contraseña</h1>
                <p>Instituto Educativo Frida Kahlo</p>
            </div>
        </div>

        <!-- Contenido -->
        <div class="reset-form">
            <?php if (!$valid_token && !$message): ?>
                <div class="error-message">
                    <i class="fas fa-exclamation-triangle"></i>
                    <div>
                        <strong>Enlace inválido</strong><br>
                        <?= htmlspecialchars($error) ?>
                    </div>
                </div>
            <?php elseif ($message): ?>
                <div class="success-message">
                    <i class="fas fa-check-circle"></i>
                    <div>
                        <strong>¡Contraseña actualizada!</strong><br>
                        <?= htmlspecialchars($message) ?>
                    </div>
                </div>
            <?php elseif ($valid_token): ?>
                <div class="form-description">
                    <p>Hola <strong><?= htmlspecialchars($reset_data['nombre']) ?></strong>,<br>
                    Crea una nueva contraseña segura para tu cuenta.</p>
                </div>

                <?php if ($error): ?>
                    <div class="error-message">
                        <i class="fas fa-exclamation-triangle"></i>
                        <?= htmlspecialchars($error) ?>
                    </div>
                <?php endif; ?>

                <form method="POST" id="resetForm">
                    <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
                    
                    <div class="form-group">
                        <label for="password">Nueva Contraseña</label>
                        <div class="input-wrapper">
                            <input 
                                type="password" 
                                id="password" 
                                name="password" 
                                class="form-input" 
                                placeholder="Ingresa tu nueva contraseña" 
                                required
                                minlength="8"
                            >
                            <i class="fas fa-lock"></i>
                        </div>
                        
                        <div class="password-requirements" id="passwordRequirements">
                            <h4>Requisitos de la contraseña:</h4>
                            <ul>
                                <li><i class="fas fa-times cross" id="length"></i> Al menos 8 caracteres</li>
                                <li><i class="fas fa-times cross" id="uppercase"></i> Una letra mayúscula</li>
                                <li><i class="fas fa-times cross" id="lowercase"></i> Una letra minúscula</li>
                                <li><i class="fas fa-times cross" id="number"></i> Un número</li>
                            </ul>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="confirm_password">Confirmar Contraseña</label>
                        <div class="input-wrapper">
                            <input 
                                type="password" 
                                id="confirm_password" 
                                name="confirm_password" 
                                class="form-input" 
                                placeholder="Confirma tu nueva contraseña" 
                                required
                            >
                            <i class="fas fa-lock"></i>
                        </div>
                    </div>

                    <button type="submit" class="submit-btn" id="submitBtn" disabled>
                        <i class="fas fa-save" style="margin-right: 0.5rem;"></i>
                        Actualizar Contraseña
                    </button>
                </form>
            <?php endif; ?>

            <div class="back-to-login">
                <a href="login.php">
                    <i class="fas fa-arrow-left"></i>
                    Volver al inicio de sesión
                </a>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>&copy; <?= date('Y') ?> IEFK - Instituto Educativo Frida Kahlo. Todos los derechos reservados.</p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const passwordInput = document.getElementById('password');
            const confirmPasswordInput = document.getElementById('confirm_password');
            const submitBtn = document.getElementById('submitBtn');
            
            if (passwordInput) {
                passwordInput.addEventListener('input', validatePassword);
                confirmPasswordInput.addEventListener('input', validatePassword);
            }
            
            function validatePassword() {
                const password = passwordInput.value;
                const confirmPassword = confirmPasswordInput.value;
                
                // Validar requisitos individuales
                const hasLength = password.length >= 8;
                const hasUppercase = /[A-Z]/.test(password);
                const hasLowercase = /[a-z]/.test(password);
                const hasNumber = /\d/.test(password);
                const passwordsMatch = password === confirmPassword && password.length > 0;
                
                // Actualizar iconos de requisitos
                updateRequirement('length', hasLength);
                updateRequirement('uppercase', hasUppercase);
                updateRequirement('lowercase', hasLowercase);
                updateRequirement('number', hasNumber);
                
                // Habilitar/deshabilitar botón
                const allValid = hasLength && hasUppercase && hasLowercase && hasNumber && passwordsMatch;
                submitBtn.disabled = !allValid;
                
                // Cambiar estilo del campo de confirmación
                if (confirmPassword.length > 0) {
                    if (passwordsMatch) {
                        confirmPasswordInput.style.borderColor = '#10b981';
                    } else {
                        confirmPasswordInput.style.borderColor = '#ef4444';
                    }
                }
            }
            
            function updateRequirement(id, valid) {
                const element = document.getElementById(id);
                if (valid) {
                    element.className = 'fas fa-check check';
                } else {
                    element.className = 'fas fa-times cross';
                }
            }
        });

        // Form submission
        document.getElementById('resetForm')?.addEventListener('submit', function(e) {
            const submitBtn = document.getElementById('submitBtn');
            const originalText = submitBtn.innerHTML;
            
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin" style="margin-right: 0.5rem;"></i>Actualizando...';
            submitBtn.disabled = true;
        });
    </script>
</body>
</html>
