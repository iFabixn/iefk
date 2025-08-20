<?php
// 🔒 VALIDAR SESIÓN DE ADMINISTRADOR
include('validar_sesion.php');
include('../db.php');

// 🔍 Verificar que se recibió el ID
if (!isset($_POST['id']) || empty($_POST['id'])) {
    echo json_encode(['success' => false, 'message' => 'ID de invitación no proporcionado']);
    exit;
}

$invitacion_id = intval($_POST['id']);

try {
    // 📊 Obtener datos de la invitación
    $query = "SELECT * FROM tokens_acceso WHERE id = ? AND usado = 0 AND expirado = 0";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $invitacion_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        echo json_encode(['success' => false, 'message' => 'Invitación no encontrada o ya no es válida para reenvío']);
        exit;
    }
    
    $invitacion = $result->fetch_assoc();
    
    // 📧 Incluir configuración de email
    include('../config/email_recuperacion.php');
    
    // 🔗 Crear enlace de invitación
    $enlace_invitacion = "http://localhost/iefk/auth/activar_cuenta.php?token=" . $invitacion['token'];
    
    // 📝 Preparar contenido del email
    $asunto = "Recordatorio: Completa tu registro en Instituto Educativo Frida Kahlo";
    
    $mensaje_html = "
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset='UTF-8'>
        <style>
            body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
            .container { max-width: 600px; margin: 0 auto; padding: 20px; }
            .header { background: #fb5c76; color: white; padding: 20px; text-align: center; border-radius: 8px 8px 0 0; }
            .content { background: #f9f9f9; padding: 30px; border-radius: 0 0 8px 8px; }
            .button { display: inline-block; padding: 12px 30px; background: #fb5c76; color: white; text-decoration: none; border-radius: 5px; margin: 20px 0; }
            .footer { text-align: center; margin-top: 20px; font-size: 12px; color: #666; }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                <h1>🎓 Instituto Educativo Frida Kahlo</h1>
                <p>Recordatorio de Invitación</p>
            </div>
            <div class='content'>
                <h2>Hola " . htmlspecialchars($invitacion['tutor_nombre']) . ",</h2>
                
                <p>Te recordamos que tienes una invitación pendiente para completar el registro de admisión en el Instituto Educativo Frida Kahlo.</p>
                
                <p><strong>Detalles de tu invitación:</strong></p>
                <ul>
                    <li><strong>Nombre:</strong> " . htmlspecialchars($invitacion['tutor_nombre']) . "</li>
                    <li><strong>Email:</strong> " . htmlspecialchars($invitacion['tutor_email']) . "</li>
                    <li><strong>Parentesco:</strong> " . ucfirst($invitacion['tutor_parentesco']) . "</li>
                </ul>
                
                <p><strong>⏰ Importante:</strong> Este enlace es válido hasta el " . date('d/m/Y', strtotime($invitacion['fecha_limite'])) . ".</p>
                
                <div style='text-align: center;'>
                    <a href='" . $enlace_invitacion . "' class='button'>Completar Registro</a>
                </div>
                
                <p><small>Si no puedes hacer clic en el botón, copia y pega este enlace en tu navegador:<br>
                <a href='" . $enlace_invitacion . "'>" . $enlace_invitacion . "</a></small></p>
                
                <hr>
                <p><strong>¿Necesitas ayuda?</strong><br>
                Contáctanos en: <a href='mailto:direccioniefk@gmail.com'>direccioniefk@gmail.com</a></p>
            </div>
            <div class='footer'>
                <p>Instituto Educativo Frida Kahlo<br>
                Educación de calidad para el futuro de México</p>
            </div>
        </div>
    </body>
    </html>";
    
    // 📤 Enviar email
    $resultado_envio = enviarEmailRecuperacion($invitacion['tutor_email'], $asunto, $mensaje_html);
    
    if ($resultado_envio['success']) {
        // 📝 Registrar el reenvío en el log
        $log_query = "
            INSERT INTO log_actividad_padres (padre_id, accion, descripcion, ip_address, user_agent) 
            VALUES (NULL, 'reenvio_invitacion', ?, ?, ?)
        ";
        $descripcion = "Invitación reenviada para: " . $invitacion['tutor_email'];
        $ip = $_SERVER['REMOTE_ADDR'] ?? '';
        $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? '';
        
        $log_stmt = $conn->prepare($log_query);
        $log_stmt->bind_param("sss", $descripcion, $ip, $user_agent);
        $log_stmt->execute();
        
        echo json_encode([
            'success' => true, 
            'message' => 'Invitación reenviada correctamente'
        ]);
    } else {
        echo json_encode([
            'success' => false, 
            'message' => 'Error al enviar el email: ' . $resultado_envio['message']
        ]);
    }
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false, 
        'message' => 'Error del servidor: ' . $e->getMessage()
    ]);
}
?>
