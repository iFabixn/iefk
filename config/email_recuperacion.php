<?php
// 📧 FUNCIONES DE EMAIL PARA RECUPERACIÓN DE CONTRASEÑA
require_once('../admin/PHPMailer/src/PHPMailer.php');
require_once('../admin/PHPMailer/src/SMTP.php');
require_once('../admin/PHPMailer/src/Exception.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function enviar_email_recuperacion($email_destino, $nombre_padre, $enlace_recuperacion) {
    $mail = new PHPMailer(true);
    
    try {
        // Configuración del servidor SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'direccioniefk@gmail.com';
        $mail->Password = 'gwsr kjig hush ukwg'; // App password del sistema admin
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        $mail->CharSet = 'UTF-8';

        // Configuración del correo
        $mail->setFrom('direccioniefk@gmail.com', 'Instituto Educativo Frida Kahlo');
        $mail->addAddress($email_destino, $nombre_padre);
        $mail->addReplyTo('direccioniefk@gmail.com', 'IEFK - Portal de Padres');

        // Contenido del correo
        $mail->isHTML(true);
        $mail->Subject = '🔐 Recuperación de Contraseña - Portal de Padres IEFK';
        
        // Plantilla HTML del email
        $mail->Body = "
        <!DOCTYPE html>
        <html lang='es'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Recuperación de Contraseña - IEFK</title>
            <style>
                body {
                    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                    line-height: 1.6;
                    color: #333;
                    max-width: 600px;
                    margin: 0 auto;
                    padding: 20px;
                    background-color: #f8f9fa;
                }
                .email-container {
                    background: white;
                    border-radius: 20px;
                    padding: 40px;
                    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
                }
                .header {
                    text-align: center;
                    margin-bottom: 30px;
                    padding-bottom: 20px;
                    border-bottom: 3px solid #fb5c76;
                }
                .logo {
                    width: 80px;
                    height: 80px;
                    border-radius: 50%;
                    margin-bottom: 15px;
                }
                .title {
                    color: #fb5c76;
                    font-size: 28px;
                    font-weight: bold;
                    margin-bottom: 10px;
                }
                .subtitle {
                    color: #666;
                    font-size: 16px;
                }
                .content {
                    margin: 30px 0;
                }
                .greeting {
                    font-size: 18px;
                    color: #333;
                    margin-bottom: 20px;
                }
                .message {
                    background: #e7f3ff;
                    border-left: 4px solid #17a2b8;
                    padding: 20px;
                    margin: 20px 0;
                    border-radius: 0 10px 10px 0;
                }
                .reset-button {
                    display: inline-block;
                    background: linear-gradient(135deg, #fb5c76, #e54965);
                    color: white !important;
                    padding: 15px 30px;
                    text-decoration: none;
                    border-radius: 25px;
                    font-weight: bold;
                    font-size: 16px;
                    margin: 20px 0;
                    box-shadow: 0 5px 15px rgba(251, 92, 118, 0.3);
                    transition: all 0.3s ease;
                }
                .reset-button:hover {
                    transform: translateY(-2px);
                    box-shadow: 0 8px 25px rgba(251, 92, 118, 0.4);
                }
                .security-info {
                    background: #fff3cd;
                    border: 1px solid #ffeaa7;
                    border-radius: 10px;
                    padding: 20px;
                    margin: 30px 0;
                }
                .security-title {
                    color: #856404;
                    font-weight: bold;
                    margin-bottom: 10px;
                    display: flex;
                    align-items: center;
                    gap: 8px;
                }
                .security-list {
                    color: #856404;
                    margin: 0;
                    padding-left: 20px;
                }
                .footer {
                    text-align: center;
                    margin-top: 40px;
                    padding-top: 20px;
                    border-top: 1px solid #dee2e6;
                    color: #666;
                    font-size: 14px;
                }
                .contact-info {
                    background: #f8f9fa;
                    border-radius: 10px;
                    padding: 15px;
                    margin-top: 20px;
                    text-align: center;
                }
                .urgent {
                    color: #dc3545;
                    font-weight: bold;
                }
                @media (max-width: 600px) {
                    body { padding: 10px; }
                    .email-container { padding: 20px; }
                    .title { font-size: 24px; }
                    .reset-button { padding: 12px 20px; font-size: 14px; }
                }
            </style>
        </head>
        <body>
            <div class='email-container'>
                <div class='header'>
                    <h1 class='title'>🔐 Recuperación de Contraseña</h1>
                    <p class='subtitle'>Instituto Educativo Frida Kahlo - Portal de Padres</p>
                </div>
                
                <div class='content'>
                    <p class='greeting'>Hola <strong>" . htmlspecialchars($nombre_padre) . "</strong>,</p>
                    
                    <div class='message'>
                        <p><strong>📧 Solicitud de Recuperación Recibida</strong></p>
                        <p>Hemos recibido una solicitud para restablecer la contraseña de tu cuenta en el Portal de Padres del Instituto Educativo Frida Kahlo.</p>
                    </div>
                    
                    <p>Si solicitaste este cambio, haz clic en el siguiente botón para crear una nueva contraseña segura:</p>
                    
                    <div style='text-align: center; margin: 30px 0;'>
                        <a href='" . htmlspecialchars($enlace_recuperacion) . "' class='reset-button'>
                            🔑 Restablecer Mi Contraseña
                        </a>
                    </div>
                    
                    <p>O copia y pega este enlace en tu navegador:</p>
                    <p style='background: #f8f9fa; padding: 10px; border-radius: 5px; word-break: break-all; font-family: monospace; font-size: 12px;'>
                        " . htmlspecialchars($enlace_recuperacion) . "
                    </p>
                    
                    <div class='security-info'>
                        <div class='security-title'>
                            🛡️ Información de Seguridad Importante
                        </div>
                        <ul class='security-list'>
                            <li>Este enlace es válido por <strong>24 horas únicamente</strong></li>
                            <li>Solo puede ser utilizado <strong>una vez</strong></li>
                            <li>Al cambiar tu contraseña, todas las sesiones activas se cerrarán</li>
                            <li>Si no solicitaste este cambio, <span class='urgent'>ignora este correo</span></li>
                        </ul>
                    </div>
                    
                    <p><strong>¿No solicitaste este cambio?</strong></p>
                    <p>Si no fuiste tú quien solicitó restablecer la contraseña, puedes ignorar este correo de forma segura. Tu cuenta permanecerá protegida y no se realizarán cambios.</p>
                </div>
                
                <div class='footer'>
                    <div class='contact-info'>
                        <p><strong>Instituto Educativo Frida Kahlo</strong></p>
                        <p>📧 <a href='mailto:direccioniefk@gmail.com'>direccioniefk@gmail.com</a></p>
                        <p>🌐 <a href='http://localhost/iefk'>Portal Institucional</a></p>
                    </div>
                    
                    <p style='margin-top: 20px; font-size: 12px; color: #999;'>
                        Este es un correo automático del sistema. Por favor, no respondas a este mensaje.<br>
                        Si tienes dudas, contacta directamente a la administración del instituto.
                    </p>
                </div>
            </div>
        </body>
        </html>";

        // Versión texto plano como alternativa
        $mail->AltBody = "
        RECUPERACIÓN DE CONTRASEÑA - INSTITUTO EDUCATIVO FRIDA KAHLO
        
        Hola " . $nombre_padre . ",
        
        Hemos recibido una solicitud para restablecer la contraseña de tu cuenta en el Portal de Padres.
        
        Para crear una nueva contraseña, visita el siguiente enlace:
        " . $enlace_recuperacion . "
        
        INFORMACIÓN IMPORTANTE:
        - Este enlace es válido por 24 horas únicamente
        - Solo puede ser utilizado una vez
        - Al cambiar tu contraseña, todas las sesiones activas se cerrarán
        - Si no solicitaste este cambio, ignora este correo
        
        Instituto Educativo Frida Kahlo
        Email: direccioniefk@gmail.com
        ";

        $mail->send();
        return true;
        
    } catch (Exception $e) {
        error_log("Error enviando email de recuperación: " . $mail->ErrorInfo);
        return false;
    }
}

/**
 * 📧 Función general para enviar emails HTML
 */
function enviarEmailRecuperacion($email_destino, $asunto, $mensaje_html) {
    $mail = new PHPMailer(true);
    
    try {
        // Configuración del servidor SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'direccioniefk@gmail.com';
        $mail->Password = 'gwsr kjig hush ukwg'; // App password del sistema admin
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        $mail->CharSet = 'UTF-8';

        // Configuración del correo
        $mail->setFrom('direccioniefk@gmail.com', 'Instituto Educativo Frida Kahlo');
        $mail->addAddress($email_destino);
        $mail->addReplyTo('direccioniefk@gmail.com', 'IEFK - Sistema de Admisiones');

        // Contenido del correo
        $mail->isHTML(true);
        $mail->Subject = $asunto;
        $mail->Body = $mensaje_html;
        
        // Versión texto plano (opcional)
        $mail->AltBody = strip_tags(str_replace(['<br>', '<br/>', '<br />'], "\n", $mensaje_html));

        $mail->send();
        return ['success' => true, 'message' => 'Email enviado correctamente'];
        
    } catch (Exception $e) {
        error_log("Error enviando email: " . $mail->ErrorInfo);
        return ['success' => false, 'message' => 'Error al enviar email: ' . $mail->ErrorInfo];
    }
}
?>
