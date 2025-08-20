<?php
// Version FINAL completa con envío de emails
session_start();

// Configuracion de errores
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);

// Headers para JSON
header('Content-Type: application/json');
header('Cache-Control: no-cache, must-revalidate');

// Incluir PHPMailer
require_once 'PHPMailer/src/Exception.php';
require_once 'PHPMailer/src/PHPMailer.php';
require_once 'PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception as PHPMailerException;

// Buffer de salida para capturar cualquier output no deseado
ob_start();

try {
    // Validar sesion (comentado para pruebas, descomentar en producción)
    // if (!isset($_SESSION['admin_logueado']) || $_SESSION['admin_logueado'] !== true) {
    //     throw new Exception('Sesión no válida');
    // }

    // Verificar método POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Método no permitido');
    }

    // Limpiar buffer antes de respuesta JSON
    ob_clean();

    // Incluir conexion a base de datos
    include('../db.php');
    if (!isset($conn) || $conn->connect_error) {
        throw new Exception('Error de conexión a la base de datos');
    }
    $conexion = $conn;

    // Obtener y validar datos
    $tutor_nombre = trim($_POST['tutor_nombre'] ?? '');
    $tutor_email = trim($_POST['tutor_email'] ?? '');
    $tutor_telefono = trim($_POST['tutor_telefono'] ?? '');
    $tutor_parentesco = trim($_POST['tutor_parentesco'] ?? '');
    $fecha_limite = $_POST['fecha_limite'] ?? '';
    
    if (empty($tutor_nombre) || empty($tutor_email) || empty($tutor_telefono)) {
        throw new Exception('Datos del tutor incompletos');
    }

    // Procesar menores
    $menor_nombres = $_POST['menor_nombre'] ?? [];
    $menor_edades = $_POST['menor_edad'] ?? [];
    $menor_servicios = $_POST['menor_servicio'] ?? [];
    $menor_planteles = $_POST['menor_plantel'] ?? [];
    
    if (empty($menor_nombres) || count($menor_nombres) === 0) {
        throw new Exception('Debe registrar al menos un menor');
    }

    // ==================== VERIFICAR EMAIL PRIMERO ====================
    
    // Incluir configuración de email
    include('mail_config.php');
    
    // Verificar configuración de email
    if (!defined('SMTP_USERNAME') || empty(SMTP_USERNAME)) {
        throw new Exception('Configuración de email no encontrada');
    }

    // ==================== INICIAR TRANSACCIÓN ====================
    $conexion->autocommit(false); // Iniciar transacción
    $conexion->begin_transaction();

    try {
        // Generar token
        $token = bin2hex(random_bytes(32));
        
        // Verificar token existente
        $stmt = $conexion->prepare("SELECT id FROM tokens_acceso WHERE tutor_email = ? AND usado = FALSE AND expirado = FALSE");
        if (!$stmt) {
            throw new Exception('Error preparando consulta de verificación');
        }
        
        $stmt->bind_param("s", $tutor_email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            throw new Exception('Ya existe una invitación activa para este correo electrónico');
        }

        // Insertar token
        $stmt = $conexion->prepare("
            INSERT INTO tokens_acceso (
                token, tutor_nombre, tutor_email, tutor_telefono, 
                tutor_parentesco, fecha_limite, fecha_creacion
            ) VALUES (?, ?, ?, ?, ?, ?, NOW())
        ");
        
        if (!$stmt) {
            throw new Exception('Error preparando consulta de inserción de token');
        }
        
        $stmt->bind_param("ssssss", $token, $tutor_nombre, $tutor_email, 
                          $tutor_telefono, $tutor_parentesco, $fecha_limite);
        
        if (!$stmt->execute()) {
            throw new Exception('Error al guardar el token: ' . $stmt->error);
        }
        
        $token_id = $conexion->insert_id;

        // CREAR REGISTRO EN PADRES_FAMILIA
        $stmt_padre = $conexion->prepare("
            INSERT INTO padres_familia (
                token_id, email, nombre, telefono, parentesco, 
                password_hash, fecha_registro, activo
            ) VALUES (?, ?, ?, ?, ?, '', NOW(), 0)
        ");
        
        if (!$stmt_padre) {
            throw new Exception('Error preparando consulta de inserción de padre: ' . $conexion->error);
        }
        
        $stmt_padre->bind_param("issss", $token_id, $tutor_email, $tutor_nombre, $tutor_telefono, $tutor_parentesco);
        
        if (!$stmt_padre->execute()) {
            throw new Exception('Error al guardar el padre: ' . $stmt_padre->error);
        }
        
        $padre_id = $conexion->insert_id;

        // Insertar menores
        $stmt_menor = $conexion->prepare("
            INSERT INTO menores_admision (token_id, padre_id, nombre, fecha_nacimiento, servicio, plantel) 
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        
        if (!$stmt_menor) {
            throw new Exception('Error preparando consulta de inserción de menores');
        }

        $menores_insertados = 0;
        for ($i = 0; $i < count($menor_nombres); $i++) {
            if (!empty(trim($menor_nombres[$i]))) {
                // Asignar variables para bind_param
                $nombre_menor = trim($menor_nombres[$i]);
                $fecha_nacimiento = $menor_edades[$i] ?? '';
                $servicio = $menor_servicios[$i] ?? '';
                $plantel = $menor_planteles[$i] ?? '';
                
                $stmt_menor->bind_param("iissss", 
                    $token_id,
                    $padre_id,
                    $nombre_menor,
                    $fecha_nacimiento,
                    $servicio,
                    $plantel
                );
                
                if (!$stmt_menor->execute()) {
                    throw new Exception('Error al insertar menor: ' . $stmt_menor->error);
                }
                $menores_insertados++;
            }
        }

        if ($menores_insertados === 0) {
            throw new Exception('No se pudo insertar ningún menor');
        }

        // ==================== ENVÍO DE EMAIL (ANTES DE COMMIT) ====================
        
        // Crear enlace de acceso
        $enlace_acceso = "http://localhost/iefk/auth/activar_cuenta.php?token=" . urlencode($token);
        
        // Formatear fecha límite
        $fecha_limite_formato = date('d/m/Y', strtotime($fecha_limite));
        
        // Texto del parentesco
        $parentesco_textos = [
            'madre' => 'Madre',
            'padre' => 'Padre', 
            'abuelo' => 'Abuelo(a)',
            'tio' => 'Tío(a)',
            'tutor_legal' => 'Tutor Legal',
            'otro' => 'Otro'
        ];
        $parentesco_texto = $parentesco_textos[$tutor_parentesco] ?? 'Tutor';

        // Configurar PHPMailer
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = SMTP_HOST;
        $mail->SMTPAuth = true;
        $mail->Username = SMTP_USERNAME;
        $mail->Password = SMTP_PASSWORD;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = SMTP_PORT;
        $mail->CharSet = 'UTF-8';

        // Configurar remitente y destinatario
        $mail->setFrom(FROM_EMAIL, FROM_NAME);
        $mail->addAddress($tutor_email, $tutor_nombre);

    // Configurar contenido del email
    $mail->isHTML(true);
    $mail->Subject = '🌟 Bienvenido al Instituto Educativo Frida Kahlo - Active su cuenta';
    
    $mail->Body = "
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset='UTF-8'>
        <style>
            body { font-family: 'Arial', sans-serif; line-height: 1.6; color: #333; }
            .container { max-width: 600px; margin: 0 auto; padding: 20px; }
            .header { background: linear-gradient(135deg, #fb5c76, #ff8a9b); color: white; text-align: center; padding: 30px; border-radius: 10px 10px 0 0; }
            .content { background: #fff; padding: 30px; border: 1px solid #e0e0e0; }
            .footer { background: #f8f9fa; padding: 20px; text-align: center; border-radius: 0 0 10px 10px; }
            .btn { background: #fb5c76; color: white; padding: 15px 30px; text-decoration: none; border-radius: 5px; display: inline-block; margin: 20px 0; }
            .info-box { background: #f8f9fa; padding: 15px; border-left: 4px solid #fb5c76; margin: 15px 0; }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                <h1>🌟 Instituto Educativo Frida Kahlo</h1>
                <p>¡Bienvenido a nuestra familia educativa!</p>
            </div>
            
            <div class='content'>
                <h2>¡Hola, {$tutor_nombre}!</h2>
                
                <p>Hemos recibido su solicitud de admisión para el <strong>Instituto Educativo Frida Kahlo</strong>. Nos complace darle la bienvenida a nuestro proceso de admisión.</p>
                
                <div class='info-box'>
                    <h3>📋 Información del Tutor:</h3>
                    <p><strong>👤 Nombre:</strong> {$tutor_nombre}</p>
                    <p><strong>💼 Parentesco:</strong> {$parentesco_texto}</p>
                    <p><strong>📞 Teléfono:</strong> {$tutor_telefono}</p>
                    <p><strong>📅 Fecha límite para documentación:</strong> {$fecha_limite_formato}</p>
                </div>
                
                <p>Para continuar con el proceso de admisión, debe <strong>activar su cuenta</strong> haciendo clic en el siguiente botón:</p>
                
                <div style='text-align: center;'>
                    <a href='{$enlace_acceso}' class='btn'>🔐 Activar Cuenta</a>
                </div>
                
                <p><small>Si el botón no funciona, copie y pegue este enlace en su navegador:<br>
                <a href='{$enlace_acceso}'>{$enlace_acceso}</a></small></p>
                
                <div class='info-box'>
                    <h3>📚 Próximos pasos:</h3>
                    <ol>
                        <li>Active su cuenta usando el enlace de arriba</li>
                        <li>Complete su perfil y establezca una contraseña</li>
                        <li>Suba los documentos requeridos antes del {$fecha_limite_formato}</li>
                        <li>Espere la revisión de nuestro equipo</li>
                    </ol>
                </div>
                
                <p>Si tiene alguna pregunta, no dude en contactarnos:</p>
                <p>📞 <strong>Teléfono:</strong> 33 1690 6553<br>
                📧 <strong>Email:</strong> direccioniefk@gmail.com</p>
            </div>
            
            <div class='footer'>
                <p><strong>Instituto Educativo Frida Kahlo</strong><br>
                Educación de calidad con valores humanos</p>
                <p><small>Este es un correo automático, por favor no responda a esta dirección.</small></p>
            </div>
        </div>
    </body>
    </html>";

    // Version texto plano
    $mail->AltBody = "
    Instituto Educativo Frida Kahlo - Proceso de Admisión
    
    ¡Hola, {$tutor_nombre}!
    
    Hemos recibido su solicitud de admisión para el Instituto Educativo Frida Kahlo.
    
    Información del Tutor:
    - Nombre: {$tutor_nombre}
    - Parentesco: {$parentesco_texto}
    - Teléfono: {$tutor_telefono}
    
    Fecha límite para documentación: {$fecha_limite_formato}
    
    Para activar su cuenta, visite: {$enlace_acceso}
    
    Contacto: 33 1690 6553 | direccioniefk@gmail.com
    ";

        // Enviar el correo
        if (!$mail->send()) {
            throw new Exception('Error al enviar el correo: ' . $mail->ErrorInfo);
        }

        // ==================== CONFIRMAR TRANSACCIÓN ====================
        $conexion->commit();
        $conexion->autocommit(true);

        // Respuesta exitosa
        $response = [
            'success' => true, 
            'message' => '¡Invitación enviada exitosamente! El correo electrónico ha sido enviado a ' . $tutor_email,
            'details' => [
                'tutor' => $tutor_nombre,
                'email' => $tutor_email,
                'menores' => $menores_insertados . ' menor(es)',
                'fecha_limite' => $fecha_limite_formato,
                'timestamp' => date('Y-m-d H:i:s'),
                'token_id' => $token_id,
                'padre_id' => $padre_id
            ]
        ];
        
        echo json_encode($response);

    } catch (Exception $e) {
        // ==================== ROLLBACK EN CASO DE ERROR ====================
        $conexion->rollback();
        $conexion->autocommit(true);
        throw $e; // Re-lanzar excepción para manejo externo
    }} catch (PHPMailerException $e) {
    // Error específico de PHPMailer
    ob_clean();
    error_log("Error PHPMailer en process_admission: " . $e->getMessage());
    
    echo json_encode([
        'success' => false, 
        'message' => 'Error al enviar el correo electrónico: ' . $e->getMessage()
    ]);
    
} catch (Exception $e) {
    // Error general
    ob_clean();
    error_log("Error en process_admission: " . $e->getMessage());
    
    echo json_encode([
        'success' => false, 
        'message' => $e->getMessage()
    ]);
} catch (Error $e) {
    // Error fatal
    ob_clean();
    error_log("Error fatal en process_admission: " . $e->getMessage());
    
    echo json_encode([
        'success' => false, 
        'message' => 'Error interno del servidor'
    ]);
}

// Finalizar buffer
ob_end_flush();
?>
