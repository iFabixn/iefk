<?php
session_start();
include('../db.php');

$error = "";
$mensaje = "";

// Manejar mensajes de la URL
if (isset($_GET['error'])) {
    switch($_GET['error']) {
        case 'access_denied':
            $error = "Debes iniciar sesión para acceder a esta página.";
            break;
        case 'session_expired':
            $error = "Tu sesión ha expirado por inactividad. Inicia sesión nuevamente.";
            break;
    }
}

if (isset($_GET['mensaje'])) {
    switch($_GET['mensaje']) {
        case 'logout_success':
            $mensaje = "Has cerrado sesión correctamente.";
            break;
        case 'password_changed':
            $mensaje = "Contraseña cambiada correctamente. Inicia sesión con tu nueva contraseña.";
            break;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = $_POST['correo'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM admins WHERE correo = ?");
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows === 1) {
        $admin = $res->fetch_assoc();

        if (password_verify($password, $admin['password_hash'])) {
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_nombre'] = $admin['nombre'];
            $_SESSION['admin_correo'] = $admin['correo']; // Agregar correo a la sesión
            $_SESSION['ultima_actividad'] = time(); // Tiempo de inicio de sesión
            header("Location: dashboard.php"); // 🔄 Volver a .php
            exit;
        } else {
            $error = "Contraseña incorrecta.";
        }
    } else {
        $error = "Usuario no encontrado.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IEFK - Panel Administrativo</title>
    
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
            /* Colores institucionales */
            --primary-color: #1e3a8a;
            --primary-dark: #1e40af;
            --secondary-color: #3b82f6;
            --accent-color: #60a5fa;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --error-color: #ef4444;
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
            --white: #ffffff;
            
            /* Fuentes */
            --font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            
            /* Sombras */
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            
            /* Transiciones */
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

        /* Elementos decorativos de fondo */
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: 
                radial-gradient(circle at 20% 80%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(255, 255, 255, 0.08) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(255, 255, 255, 0.05) 0%, transparent 50%);
            pointer-events: none;
        }

        .login-container {
            background: var(--white);
            border-radius: 1rem;
            box-shadow: var(--shadow-xl);
            overflow: hidden;
            width: 100%;
            max-width: 400px;
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

        .login-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            color: var(--white);
            padding: 2rem;
            text-align: center;
            position: relative;
        }

        .login-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse"><path d="M 10 0 L 0 0 0 10" fill="none" stroke="rgba(255,255,255,0.1)" stroke-width="0.5"/></pattern></defs><rect width="100" height="100" fill="url(%23grid)"/></svg>');
            opacity: 0.3;
        }

        .logo {
            position: relative;
            z-index: 1;
        }

        .logo-img {
            width: 4rem;
            height: 4rem;
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
            letter-spacing: -0.025em;
        }

        .logo p {
            font-size: 0.875rem;
            opacity: 0.8;
            font-weight: 400;
        }

        .login-form {
            padding: 2rem;
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
            color: #fff;
        }

        .password-toggle {
            position: absolute;
            right: 3rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--gray-400);
            cursor: pointer;
            font-size: 0.875rem;
            padding: 0.25rem;
            z-index: 2;
        }

        .password-toggle:hover {
            color: var(--gray-600);
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
            font-family: var(--font-family);
            cursor: pointer;
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }

        .submit-btn:hover {
            transform: translateY(-1px);
            box-shadow: var(--shadow-lg);
        }

        .submit-btn:active {
            transform: translateY(0);
        }

        .submit-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .submit-btn .btn-text {
            transition: var(--transition);
        }

        .submit-btn .btn-spinner {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            opacity: 0;
            transition: var(--transition);
        }

        .submit-btn.loading .btn-text {
            opacity: 0;
        }

        .submit-btn.loading .btn-spinner {
            opacity: 1;
        }

        .spinner {
            width: 1rem;
            height: 1rem;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-top: 2px solid var(--white);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .error-message {
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.1) 0%, rgba(239, 68, 68, 0.05) 100%);
            border: 1px solid rgba(239, 68, 68, 0.2);
            color: var(--error-color);
            padding: 0.875rem 1rem;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            margin-top: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            animation: shake 0.5s ease-in-out;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-4px); }
            20%, 40%, 60%, 80% { transform: translateX(4px); }
        }

        .forgot-password {
            text-align: center;
            margin-top: 1.5rem;
        }

        .forgot-password a {
            color: white;
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 500;
            transition: var(--transition);
        }

        .forgot-password a:hover {
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

        /* Responsive Design */
        @media (max-width: 480px) {
            body {
                padding: 0.5rem;
            }

            .login-container {
                max-width: 100%;
                margin: 0;
            }

            .login-header {
                padding: 1.5rem;
            }

            .logo i {
                font-size: 2.5rem;
            }

            .logo h1 {
                font-size: 1.5rem;
            }

            .login-form {
                padding: 1.5rem;
            }

            .form-group {
                margin-bottom: 1.25rem;
            }
        }

        /* iPad y tablets */
        @media (min-width: 768px) and (max-width: 1024px) {
            .login-container {
                max-width: 450px;
            }
        }

        /* Pantallas grandes */
        @media (min-width: 1200px) {
            .login-container {
                max-width: 500px;
            }
            
            .login-header {
                padding: 2.5rem;
            }
            
            .login-form {
                padding: 2.5rem;
            }
        }

        /* Modo oscuro para dispositivos que lo soporten */
        @media (prefers-color-scheme: dark) {
            .login-container {
                background: var(--gray-800);
            }
            
            .form-input {
                background: var(--gray-700);
                border-color: var(--gray-600);
                color: var(--white);
            }
            
            .form-group label {
                color: var(--gray-300);
            }
            
            .footer {
                background: var(--gray-700);
                border-color: var(--gray-600);
            }
        }

        /* Animaciones adicionales */
        .form-group {
            animation: fadeInUp 0.6s ease-out forwards;
            opacity: 0;
            transform: translateY(20px);
        }

        .form-group:nth-child(1) { animation-delay: 0.1s; }
        .form-group:nth-child(2) { animation-delay: 0.2s; }
        .form-group:nth-child(3) { animation-delay: 0.3s; }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <!-- Header -->
        <div class="login-header">
            <div class="logo">
                <img src="../assets/img/logo sin letras.png" alt="IEFK Logo" class="logo-img">
                <h1>IEFK</h1>
                <p>Panel Administrativo</p>
            </div>
        </div>

        <!-- Formulario -->
        <div class="login-form">
            <form method="POST" id="loginForm">
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

                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <div class="input-wrapper">
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            class="form-input" 
                            placeholder="••••••••" 
                            required
                            autocomplete="current-password"
                        >
                        <i class="fas fa-lock"></i>
                        <button type="button" class="password-toggle" onclick="togglePassword()">
                            <i class="fas fa-eye" id="passwordToggleIcon"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="submit-btn" id="submitBtn">
                    <span class="btn-text">
                        <i class="fas fa-sign-in-alt" style="margin-right: 0.5rem;"></i>
                        Iniciar Sesión
                    </span>
                    <div class="btn-spinner">
                        <div class="spinner"></div>
                    </div>
                </button>
            </form>

            <?php if ($error): ?>
                <div class="error-message">
                    <i class="fas fa-exclamation-triangle"></i>
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <?php if ($mensaje): ?>
                <div class="success-message" style="background: #ecfdf5; border: 1px solid #10b981; color: #059669; padding: 12px 16px; border-radius: 8px; margin: 15px 0; display: flex; align-items: center; gap: 8px;">
                    <i class="fas fa-check-circle"></i>
                    <?= htmlspecialchars($mensaje) ?>
                </div>
            <?php endif; ?>

            <div class="forgot-password">
                <a href="forgot-password.php">¿Olvidaste tu contraseña?</a> <!-- 🔄 Volver a .php -->
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>&copy; <?= date('Y') ?> IEFK - Instituto Educativo Frida Kahlo. Todos los derechos reservados.</p>
        </div>
    </div>

    <script>
        // Toggle password visibility
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('passwordToggleIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }

        // Form submission with loading state
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const submitBtn = document.getElementById('submitBtn');
            submitBtn.classList.add('loading');
            submitBtn.disabled = true;
        });

        // Forgot password - redirect to forgot password page
        function showForgotPassword() {
            window.location.href = 'forgot-password.php'; // 🔄 Volver a .php
        }

        // Auto-focus en el primer campo
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('correo').focus();
        });

        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' && (e.ctrlKey || e.metaKey)) {
                document.getElementById('loginForm').submit();
            }
        });
    </script>
</body>
</html>
