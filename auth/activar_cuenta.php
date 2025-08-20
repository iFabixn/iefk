<?php
// 🔐 PÁGINA DE ACTIVACIÓN DE CUENTA PARA PADRES
session_start();

// 📊 Incluir conexión a base de datos
include('../db.php');
$conexion = $conn; // Renombrar para consistencia

// 🔍 Obtener y validar token
$token = $_GET['token'] ?? '';

if (empty($token) || strlen($token) !== 64) { // Cambiar de 128 a 64 caracteres
    $error = "Token de acceso inválido o faltante";
    $token_valido = false;
} else {
    // 🔍 Verificar token en base de datos
    $stmt = $conexion->prepare("
        SELECT t.*, 
               COUNT(m.id) as num_menores
        FROM tokens_acceso t
        LEFT JOIN menores_admision m ON t.id = m.token_id
        WHERE t.token = ? AND t.expirado = FALSE AND t.fecha_limite >= CURDATE()
        GROUP BY t.id
    ");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $resultado = $stmt->get_result();
    
    if ($resultado->num_rows === 0) {
        $error = "Token expirado o no válido";
        $token_valido = false;
    } else {
        $token_data = $resultado->fetch_assoc();
        
        // 🔍 Verificar si ya existe una cuenta activada para este token
        $stmt_padre_existente = $conexion->prepare("SELECT id, email, password_hash FROM padres_familia WHERE token_id = ?");
        $stmt_padre_existente->bind_param("i", $token_data['id']);
        $stmt_padre_existente->execute();
        $padre_existente = $stmt_padre_existente->get_result()->fetch_assoc();
        
        if ($padre_existente && !empty($padre_existente['password_hash'])) {
            // La cuenta ya fue activada y tiene contraseña, redirigir al login
            header("Location: login_padres.php?ya_activado=1&email=" . urlencode($padre_existente['email']));
            exit;
        }
        
        if ($token_data['usado']) {
            $error = "Token ya utilizado";
            $token_valido = false;
        } else {
            $token_valido = true;
            
            // 👶 Obtener información de menores
            $stmt_menores = $conexion->prepare("
                SELECT nombre, fecha_nacimiento, servicio, plantel
                FROM menores_admision 
                WHERE token_id = (SELECT id FROM tokens_acceso WHERE token = ?)
                ORDER BY nombre
            ");
            $stmt_menores->bind_param("s", $token);
            $stmt_menores->execute();
            $menores = $stmt_menores->get_result()->fetch_all(MYSQLI_ASSOC);
        }
    }
}

// 🔐 Procesar formulario de activación
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $token_valido) {
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    
    // Validaciones
    $errores = [];
    
    if (strlen($password) < 8) {
        $errores[] = "La contraseña debe tener al menos 8 caracteres";
    }
    
    if (!preg_match('/[A-Z]/', $password)) {
        $errores[] = "La contraseña debe contener al menos una letra mayúscula";
    }
    
    if (!preg_match('/[a-z]/', $password)) {
        $errores[] = "La contraseña debe contener al menos una letra minúscula";
    }
    
    if (!preg_match('/[0-9]/', $password)) {
        $errores[] = "La contraseña debe contener al menos un número";
    }
    
    if ($password !== $confirm_password) {
        $errores[] = "Las contraseñas no coinciden";
    }
    
    if (empty($errores)) {
        // 🔐 Activar cuenta de padre
        $conexion->begin_transaction();
        
        try {
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            
            // Verificar si ya existe un padre para este token
            $stmt_check_padre = $conexion->prepare("SELECT id FROM padres_familia WHERE token_id = ?");
            $stmt_check_padre->bind_param("i", $token_data['id']);
            $stmt_check_padre->execute();
            $padre_existente = $stmt_check_padre->get_result()->fetch_assoc();
            
            if ($padre_existente) {
                // 1. Actualizar padre existente con la contraseña
                $stmt_update_padre = $conexion->prepare("
                    UPDATE padres_familia 
                    SET password_hash = ?, activo = 1
                    WHERE token_id = ?
                ");
                $stmt_update_padre->bind_param("si", $password_hash, $token_data['id']);
                
                if (!$stmt_update_padre->execute()) {
                    throw new Exception("Error al actualizar la cuenta");
                }
                
                $padre_id = $padre_existente['id'];
                
            } else {
                // 1. Crear nuevo registro de padre
                $stmt_padre = $conexion->prepare("
                    INSERT INTO padres_familia 
                    (token_id, email, nombre, telefono, parentesco, password_hash)
                    VALUES (?, ?, ?, ?, ?, ?)
                ");
                
                $stmt_padre->bind_param("isssss",
                    $token_data['id'],
                    $token_data['tutor_email'],
                    $token_data['tutor_nombre'],
                    $token_data['tutor_telefono'],
                    $token_data['tutor_parentesco'],
                    $password_hash
                );
                
                if (!$stmt_padre->execute()) {
                    throw new Exception("Error al crear la cuenta");
                }
                
                $padre_id = $conexion->insert_id;
            }
            
            // 2. Actualizar menores con el padre_id
            $stmt_update_menores = $conexion->prepare("
                UPDATE menores_admision 
                SET padre_id = ? 
                WHERE token_id = ?
            ");
            $stmt_update_menores->bind_param("ii", $padre_id, $token_data['id']);
            $stmt_update_menores->execute();
            
            // 3. Marcar token como usado
            $stmt_token = $conexion->prepare("
                UPDATE tokens_acceso 
                SET usado = TRUE, fecha_usado = NOW(), ip_usado = ?
                WHERE id = ?
            ");
            $ip_usado = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
            $stmt_token->bind_param("si", $ip_usado, $token_data['id']);
            $stmt_token->execute();
            
            // 4. Log de actividad
            $stmt_log = $conexion->prepare("
                INSERT INTO log_actividad_padres 
                (padre_id, accion, descripcion, ip_address, user_agent)
                VALUES (?, 'cuenta_activada', 'Cuenta activada exitosamente', ?, ?)
            ");
            $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? 'unknown';
            $stmt_log->bind_param("iss", $padre_id, $ip_usado, $user_agent);
            $stmt_log->execute();
            
            $conexion->commit();
            
            // ✅ Redirigir al login de padres
            header("Location: login_padres.php?activado=1&email=" . urlencode($token_data['tutor_email']));
            exit;
            
        } catch (Exception $e) {
            $conexion->rollback();
            $errores[] = "Error al activar la cuenta: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activar Cuenta - Instituto Educativo Frida Kahlo</title>
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

        .container {
            background: var(--white);
            border-radius: 20px;
            box-shadow: var(--shadow);
            padding: 40px;
            max-width: 600px;
            width: 100%;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .logo {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            margin-bottom: 20px;
        }

        .title {
            color: var(--primary-color);
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .subtitle {
            color: var(--dark-color);
            font-size: 1.1rem;
        }

        .error-box, .success-box, .info-box {
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .error-box {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .success-box {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .info-box {
            background: #e7f3ff;
            color: #0c5460;
            border: 1px solid #bee5eb;
        }

        .tutor-info {
            background: var(--primary-light);
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 30px;
        }

        .tutor-info h3 {
            color: var(--primary-dark);
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
        }

        .info-item {
            display: flex;
            flex-direction: column;
        }

        .info-label {
            font-weight: bold;
            color: var(--primary-dark);
            margin-bottom: 5px;
        }

        .info-value {
            color: var(--dark-color);
        }

        .menores-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 15px;
            margin-top: 15px;
        }

        .menor-card {
            background: var(--white);
            border-radius: 10px;
            padding: 15px;
            border: 2px solid var(--primary-color);
        }

        .menor-name {
            font-weight: bold;
            color: var(--primary-color);
            margin-bottom: 10px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: var(--dark-color);
        }

        .form-input {
            width: 100%;
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
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
            background: var(--primary-color);
            color: var(--white);
            border: none;
            padding: 15px 30px;
            border-radius: 10px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
        }

        .btn:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
        }

        .btn:disabled {
            background: #ccc;
            cursor: not-allowed;
            transform: none;
        }

        @media (max-width: 768px) {
            .container {
                padding: 30px 20px;
            }
            
            .title {
                font-size: 1.5rem;
            }
            
            .info-grid, .menores-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="../assets/img/logo sin letras.png" alt="Logo IEFK" class="logo">
            <h1 class="title">🔐 Activar Cuenta</h1>
            <p class="subtitle">Instituto Educativo Frida Kahlo - Portal de Padres</p>
        </div>

        <?php if (!$token_valido): ?>
            <div class="error-box">
                <h3><i class="fas fa-exclamation-triangle"></i> Error de Acceso</h3>
                <p><?= htmlspecialchars($error) ?></p>
                <p><strong>Posibles causas:</strong></p>
                <ul>
                    <li>El enlace ha expirado</li>
                    <li>El token ya fue usado</li>
                    <li>El enlace no es válido</li>
                    <li>La invitación fue cancelada</li>
                </ul>
                <br>
                <p>Si crees que esto es un error, contacta a la administración del instituto.</p>
            </div>
        <?php else: ?>
            
            <?php if (!empty($errores)): ?>
                <div class="error-box">
                    <h4><i class="fas fa-times-circle"></i> Errores encontrados:</h4>
                    <ul>
                        <?php foreach ($errores as $error): ?>
                            <li><?= htmlspecialchars($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <div class="tutor-info">
                <h3><i class="fas fa-user"></i> Información del Tutor</h3>
                <div class="info-grid">
                    <div class="info-item">
                        <span class="info-label">Nombre:</span>
                        <span class="info-value"><?= htmlspecialchars($token_data['tutor_nombre']) ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Email:</span>
                        <span class="info-value"><?= htmlspecialchars($token_data['tutor_email']) ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Teléfono:</span>
                        <span class="info-value"><?= htmlspecialchars($token_data['tutor_telefono']) ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Parentesco:</span>
                        <span class="info-value"><?= ucfirst(str_replace('_', ' ', $token_data['tutor_parentesco'])) ?></span>
                    </div>
                </div>

                <h4 style="margin-top: 20px; color: var(--primary-dark);"><i class="fas fa-children"></i> Menores a Inscribir (<?= count($menores) ?>)</h4>
                <div class="menores-grid">
                    <?php foreach ($menores as $menor): ?>
                        <div class="menor-card">
                            <div class="menor-name"><?= htmlspecialchars($menor['nombre']) ?></div>
                            <div><strong>Servicio:</strong> <?= ucfirst($menor['servicio']) ?></div>
                            <div><strong>Plantel:</strong> <?= ucfirst(str_replace('_', ' ', $menor['plantel'])) ?></div>
                            <div><strong>Fecha Nac.:</strong> <?= date('d/m/Y', strtotime($menor['fecha_nacimiento'])) ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="info-box">
                <h4><i class="fas fa-info-circle"></i> Crear tu Contraseña</h4>
                <p>Para acceder a tu portal personalizado, establece una contraseña segura que cumpla con nuestros requisitos de seguridad.</p>
            </div>

            <form method="POST" id="activationForm">
                <div class="form-group">
                    <label for="password" class="form-label">
                        <i class="fas fa-lock"></i> Contraseña
                    </label>
                    <input type="password" id="password" name="password" class="form-input" 
                           placeholder="Ingresa una contraseña segura" required>
                    
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
                        <i class="fas fa-lock"></i> Confirmar Contraseña
                    </label>
                    <input type="password" id="confirm_password" name="confirm_password" class="form-input" 
                           placeholder="Confirma tu contraseña" required>
                </div>

                <button type="submit" class="btn" id="submitBtn" disabled>
                    <i class="fas fa-key"></i> Activar Mi Cuenta
                </button>
            </form>

        <?php endif; ?>
    </div>

    <script>
        // Validación en tiempo real de contraseña
        const passwordInput = document.getElementById('password');
        const confirmPasswordInput = document.getElementById('confirm_password');
        const submitBtn = document.getElementById('submitBtn');

        function updateRequirement(id, isValid) {
            const element = document.getElementById(id);
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

        passwordInput.addEventListener('input', validatePassword);
        confirmPasswordInput.addEventListener('input', validatePassword);

        // Prevenir envío si no es válido
        document.getElementById('activationForm').addEventListener('submit', function(e) {
            if (submitBtn.disabled) {
                e.preventDefault();
                alert('Por favor, completa todos los requisitos de la contraseña.');
            }
        });
    </script>
</body>
</html>
