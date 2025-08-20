<?php
session_start();
include('../db.php');
include('smtp_config.php'); // 👈 AGREGAR ESTA LÍNEA

$message = "";
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = $_POST['correo'];
    
    // Verificar si el correo existe en la base de datos
    $stmt = $conn->prepare("SELECT id, nombre FROM admins WHERE correo = ?");
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $res = $stmt->get_result();
    
    if ($res->num_rows === 1) {
        $admin = $res->fetch_assoc();
        
        // Generar token único
        $token = bin2hex(random_bytes(32));
        $expires = date('Y-m-d H:i:s', strtotime('+1 hour')); // Expira en 1 hora
        
        // Guardar el token en la base de datos
        $stmt = $conn->prepare("INSERT INTO password_resets (admin_id, token, expires_at) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE token = ?, expires_at = ?");
        $stmt->bind_param("issss", $admin['id'], $token, $expires, $token, $expires);
        $stmt->execute();
        
        // Enviar correo electrónico
        $reset_link = "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']) . "/reset-password.php?token=" . $token; // 🔄 Volver a .php
        
        $to = $correo;
        $subject = "IEFK - Recuperación de Contraseña";
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
                .header { background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 100%); color: white; padding: 30px; text-align: center; border-radius: 10px 10px 0 0; }
                .content { background: #f9fafb; padding: 30px; }
                .button { display: inline-block; background: #1e3a8a; color: white; padding: 15px 30px; text-decoration: none; border-radius: 8px; font-weight: bold; margin: 20px 0; }
                .footer { background: #374151; color: #9ca3af; padding: 20px; text-align: center; border-radius: 0 0 10px 10px; font-size: 14px; }
                .warning { background: #fef3c7; border: 1px solid #f59e0b; padding: 15px; border-radius: 8px; margin: 20px 0; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h1>🎓 IEFK</h1>
                    <h2>Instituto Educativo Frida Kahlo</h2>
                    <p>Recuperación de Contraseña</p>
                </div>
                <div class='content'>
                    <h3>Hola, " . htmlspecialchars($admin['nombre']) . "</h3>
                    <p>Hemos recibido una solicitud para restablecer la contraseña de tu cuenta de administrador en el sistema IEFK.</p>
                    
                    <p>Para restablecer tu contraseña, haz clic en el siguiente enlace:</p>
                    
                    <p style='text-align: center;'>
                        <a href='" . $reset_link . "' class='button'>Restablecer Contraseña</a>
                    </p>
                    
                    <div class='warning'>
                        <strong>⚠️ Importante:</strong>
                        <ul>
                            <li>Este enlace expirará en 1 hora por seguridad</li>
                            <li>Solo puede ser usado una vez</li>
                            <li>Si no solicitaste este cambio, puedes ignorar este correo</li>
                        </ul>
                    </div>
                    
                    <p>Si el botón no funciona, copia y pega el siguiente enlace en tu navegador:</p>
                    <p style='word-break: break-all; background: #e5e7eb; padding: 10px; border-radius: 5px; font-family: monospace;'>
                        " . $reset_link . "
                    </p>
                    
                    <p>Si tienes problemas o no solicitaste este cambio, contacta al administrador del sistema.</p>
                </div>
                <div class='footer'>
                    <p>&copy; " . date('Y') . " Instituto Educativo Frida Kahlo. Todos los derechos reservados.</p>
                    <p>Este es un correo automático, por favor no responder.</p>
                </div>
            </div>
        </body>
        </html>";
        
        // Enviar correo usando PHPMailer
        if (enviarCorreoSMTP($correo, $admin['nombre'], "IEFK - Recuperación de Contraseña", $email_body)) {
            $message = "Se ha enviado un enlace de recuperación a tu correo electrónico. Revisa tu bandeja de entrada y spam.";
        } else {
            $error = "Error al enviar el correo. Contacta al administrador del sistema.";
        }
    } else {
        // Por seguridad, mostramos el mismo mensaje aunque el correo no exista
        $message = "Si el correo existe en nuestro sistema, recibirás un enlace de recuperación.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IEFK - Recuperar Contraseña</title>
    
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
            position: relative;
            overflow-x: hidden;
        }

        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: 
                radial-gradient(circle at 20% 80%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(255, 255, 255, 0.08) 0%, transparent 50%);
            pointer-events: none;
        }

        .recovery-container {
            background: var(--white);
            border-radius: 1rem;
            box-shadow: var(--shadow-xl);
            overflow: hidden;
            width: 100%;
            max-width: 450px;
            position: relative;
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

        .recovery-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            color: var(--white);
            padding: 2rem;
            text-align: center;
            position: relative;
        }

        .logo {
            position: relative;
            z-index: 1;
        }

        .logo-img {
            width: 3.5rem;
            height: 3.5rem;
            margin-bottom: 0.75rem;
            opacity: 0.95;
            transition: var(--transition);
        }

        .logo-img:hover {
            opacity: 1;
            transform: scale(1.05);
        }

        .logo i {
            font-size: 3rem;
            margin-bottom: 0.5rem;
            display: block;
            opacity: 0.9;
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

        .recovery-form {
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
            position: relative;
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
            background: var(--white);
        }

        .form-input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(30, 58, 138, 0.1);
        }

        .form-input:focus + i {
            color: var(--primary-color);
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
            position: relative;
            overflow: hidden;
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
            margin-top: 1rem;
            display: flex;
            align-items: flex-start;
            gap: 0.5rem;
            animation: fadeIn 0.5s ease-in-out;
        }

        .error-message {
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.1) 0%, rgba(239, 68, 68, 0.05) 100%);
            border: 1px solid rgba(239, 68, 68, 0.2);
            color: var(--error-color);
            padding: 1rem;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            margin-top: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            animation: shake 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-4px); }
            20%, 40%, 60%, 80% { transform: translateX(4px); }
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
            text-decoration: underline;
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

            .recovery-container {
                max-width: 100%;
            }

            .recovery-header {
                padding: 1.5rem;
            }

            .recovery-form {
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="recovery-container">
        <!-- Header -->
        <div class="recovery-header">
            <div class="logo">
                <img src="../assets/img/logo sin letras.png" alt="IEFK Logo" class="logo-img">
                <h1>Recuperar Contraseña</h1>
                <p>Instituto Educativo Frida Kahlo</p>
            </div>
        </div>

        <!-- Formulario -->
        <div class="recovery-form">
            <?php if (!$message && !$error): ?>
                <div class="form-description">
                    <p>Ingresa tu correo electrónico y te enviaremos un enlace para restablecer tu contraseña.</p>
                </div>

                <form method="POST" id="recoveryForm">
                    <div class="form-group">
                        <label for="correo">Correo Electrónico</label>
                        <div class="input-wrapper">
                            <input 
                                type="email" 
                                id="correo" 
                                name="correo" 
                                class="form-input" 
                                placeholder="admin@iefk.edu.mx" 
                                required
                                autocomplete="email"
                            >
                            <i class="fas fa-envelope"></i>
                        </div>
                    </div>

                    <button type="submit" class="submit-btn" id="submitBtn">
                        <i class="fas fa-paper-plane" style="margin-right: 0.5rem;"></i>
                        Enviar Enlace de Recuperación
                    </button>
                </form>
            <?php endif; ?>

            <?php if ($message): ?>
                <div class="success-message">
                    <i class="fas fa-check-circle"></i>
                    <div>
                        <strong>¡Correo enviado!</strong><br>
                        <?= htmlspecialchars($message) ?>
                    </div>
                </div>
            <?php endif; ?>

            <?php if ($error): ?>
                <div class="error-message">
                    <i class="fas fa-exclamation-triangle"></i>
                    <?= htmlspecialchars($error) ?>
                </div>
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
        // Form submission with loading state
        document.getElementById('recoveryForm')?.addEventListener('submit', function(e) {
            const submitBtn = document.getElementById('submitBtn');
            const originalText = submitBtn.innerHTML;
            
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin" style="margin-right: 0.5rem;"></i>Enviando...';
            submitBtn.disabled = true;
            
            // Si hay error en el servidor, restaurar el botón
            setTimeout(() => {
                if (submitBtn.disabled) {
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                }
            }, 10000);
        });

        // Auto-focus en el campo de correo
        document.addEventListener('DOMContentLoaded', function() {
            const emailInput = document.getElementById('correo');
            if (emailInput) {
                emailInput.focus();
            }
        });
    </script>
</body>
</html>
