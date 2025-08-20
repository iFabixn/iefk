<?php
// 🔒 ARCHIVO DE CONFIGURACIÓN SENSIBLE - SOLO PARA INCLUSIÓN
// Este archivo contiene credenciales sensibles y NO debe ser accesible directamente

// Prevenir acceso directo al archivo
if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    die('❌ Acceso denegado. Este archivo solo puede ser incluido desde otros scripts.');
}

// Configuración SMTP para Gmail
define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_PORT', 587);
define('SMTP_USERNAME', 'direccioniefk@gmail.com'); // ✅ Email correcto
define('SMTP_PASSWORD', 'gwsr kjig hush ukwg');   // 👈 PEGA LA CONTRASEÑA DE 16 CARACTERES
define('SMTP_ENCRYPTION', 'tls');
define('FROM_EMAIL', 'direccioniefk@gmail.com');  // ✅ Mismo email
define('FROM_NAME', 'IEFK - Sistema Administrativo');

// Función para enviar correos con PHPMailer
function enviarCorreo($to, $subject, $body, $toName = '') {
    // Para usar la función mail() nativa de PHP con configuración SMTP
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: " . FROM_NAME . " <" . FROM_EMAIL . ">" . "\r\n";
    $headers .= "Reply-To: " . FROM_EMAIL . "\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion();
    
    return mail($to, $subject, $body, $headers);
}
?>
