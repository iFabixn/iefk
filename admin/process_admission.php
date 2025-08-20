<?php
// Validar sesion de administrador
include('validar_sesion.php');

// Configuracion de errores y respuesta JSON
error_reporting(E_ALL);
ini_set('display_errors', 0);
header('Content-Type: application/json');

// Incluir conexion a base de datos
include('../db.php');

// Renombrar conexion para consistencia
$conexion = $conn;

// Incluir PHPMailer
require_once 'PHPMailer/src/Exception.php';
require_once 'PHPMailer/src/PHPMailer.php';
require_once 'PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Verificar que la peticion sea POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Metodo no permitido']);
    exit;
}

// Funcion para generar token seguro
function generarTokenSeguro($longitud = 64) {
    return bin2hex(random_bytes($longitud / 2));
}

// Funcion para verificar si el email ya tiene token activo
function verificarTokenExistente($conexion, $email) {
    $stmt = $conexion->prepare("
        SELECT id, token, usado, expirado, fecha_limite 
        FROM tokens_acceso 
        WHERE tutor_email = ? AND usado = FALSE AND expirado = FALSE
    ");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    return $stmt->get_result();
}

// Funcion para guardar token en base de datos
function guardarToken($conexion, $token_data, $menores_data) {
    // Verificar si ya existe un token activo
    $existing = verificarTokenExistente($conexion, $token_data['email']);
    
    if ($existing->num_rows > 0) {
        $existing_token = $existing->fetch_assoc();
        // Si existe un token no usado y no expirado, marcarlo como expirado
        $stmt = $conexion->prepare("UPDATE tokens_acceso SET expirado = TRUE WHERE id = ?");
        $stmt->bind_param("i", $existing_token['id']);
        $stmt->execute();
    }
    
    // Insertar nuevo token
    $stmt = $conexion->prepare("
        INSERT INTO tokens_acceso 
        (token, tutor_email, tutor_nombre, tutor_telefono, tutor_parentesco, fecha_limite, ip_creacion)
        VALUES (?, ?, ?, ?, ?, ?, ?)
    ");
    
    $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
    $stmt->bind_param("sssssss", 
        $token_data['token'],
        $token_data['email'],
        $token_data['nombre'],
        $token_data['telefono'],
        $token_data['parentesco'],
        $token_data['fecha_limite'],
        $ip
    );
    
    if (!$stmt->execute()) {
        throw new Exception('Error al guardar el token de acceso');
    }
    
    $token_id = $conexion->insert_id;
    
    // Guardar informacion de menores
    $stmt_menores = $conexion->prepare("
        INSERT INTO menores_admision 
        (padre_id, token_id, nombre, fecha_nacimiento, servicio, plantel)
        VALUES (NULL, ?, ?, ?, ?, ?)
    ");
    
    foreach ($menores_data as $menor) {
        $stmt_menores->bind_param("issss",
            $token_id,
            $menor['nombre'],
            $menor['fecha_nacimiento'],
            $menor['servicio'],
            $menor['plantel']
        );
        
        if (!$stmt_menores->execute()) {
            throw new Exception('Error al guardar informacion del menor: ' . $menor['nombre']);
        }
    }
    
    return $token_id;
}

try {
    // Validar y sanitizar datos del formulario
    $tutor_nombre = trim($_POST['tutor_nombre'] ?? '');
    $tutor_email = trim($_POST['tutor_email'] ?? '');
    $tutor_telefono = trim($_POST['tutor_telefono'] ?? '');
    $tutor_parentesco = trim($_POST['tutor_parentesco'] ?? '');
    $fecha_limite = trim($_POST['fecha_limite'] ?? '');
    
    // Datos de menores (arrays)
    $menores_nombres = $_POST['menor_nombre'] ?? [];
    $menores_edades = $_POST['menor_edad'] ?? [];
    $menores_servicios = $_POST['menor_servicio'] ?? [];
    $menores_planteles = $_POST['menor_plantel'] ?? [];

    // Validaciones basicas
    if (empty($tutor_nombre) || empty($tutor_email) || empty($tutor_telefono) || empty($tutor_parentesco)) {
        throw new Exception('Todos los campos del tutor son obligatorios');
    }

    if (empty($menores_nombres) || empty($menores_edades) || empty($menores_servicios) || empty($menores_planteles)) {
        throw new Exception('Debe registrar al menos un menor');
    }

    // Validar formato de email
    if (!filter_var($tutor_email, FILTER_VALIDATE_EMAIL)) {
        throw new Exception('El correo electronico no tiene un formato valido');
    }

    // Validar telefono (10 digitos)
    if (!preg_match('/^[0-9]{10}$/', $tutor_telefono)) {
        throw new Exception('El telefono debe tener exactamente 10 digitos');
    }

    // Validar fecha limite
    if (empty($fecha_limite) || strtotime($fecha_limite) <= time()) {
        throw new Exception('La fecha limite debe ser posterior a hoy');
    }

    // Validar que todos los arrays de menores tengan la misma cantidad
    $num_menores = count($menores_nombres);
    if (count($menores_edades) !== $num_menores || 
        count($menores_servicios) !== $num_menores || 
        count($menores_planteles) !== $num_menores) {
        throw new Exception('Datos inconsistentes en la informacion de menores');
    }

    // Construir informacion de menores para el correo y base de datos
    $menores_info = '';
    $menores_data = [];
    
    for ($i = 0; $i < $num_menores; $i++) {
        $nombre = htmlspecialchars(trim($menores_nombres[$i]));
        $edad = htmlspecialchars(trim($menores_edades[$i]));
        $servicio = htmlspecialchars(trim($menores_servicios[$i]));
        $plantel = htmlspecialchars(trim($menores_planteles[$i]));
        
        // Convertir fecha de nacimiento para base de datos
        $fecha_nacimiento = $edad; // Ya viene en formato YYYY-MM-DD del formulario
        
        // Guardar para base de datos
        $menores_data[] = [
            'nombre' => $nombre,
            'fecha_nacimiento' => $fecha_nacimiento,
            'servicio' => $servicio,
            'plantel' => $plantel
        ];
        
        // Convertir codigos a nombres legibles para el email
        $servicio_nombre = [
            'guarderia' => 'Guarderia',
            'preescolar' => 'Preescolar', 
            'primaria' => 'Primaria'
        ][$servicio] ?? $servicio;
        
        $plantel_nombre = [
            'zapote' => 'Plantel El Zapote (Matriz)',
            'rio_nilo' => 'Plantel Rio Nilo',
            'colinas' => 'Plantel Colinas de Tonala'
        ][$plantel] ?? $plantel;
        
        // Calcular edad aproximada para mostrar en email
        $fecha_nacimiento_dt = new DateTime($edad);
        $hoy = new DateTime();
        $edad_anos = $hoy->diff($fecha_nacimiento_dt)->y;
        
        $menores_info .= "
        <tr style='border-bottom: 1px solid #e9ecef;'>
            <td style='padding: 12px; border-right: 1px solid #e9ecef;'><strong>{$nombre}</strong></td>
            <td style='padding: 12px; border-right: 1px solid #e9ecef;'>{$edad_anos} anos</td>
            <td style='padding: 12px; border-right: 1px solid #e9ecef;'>{$servicio_nombre}</td>
            <td style='padding: 12px;'>{$plantel_nombre}</td>
        </tr>";
    }

    // Generar token de acceso seguro
    $token_acceso = generarTokenSeguro(128);
    
    // Guardar token y datos en base de datos
    $token_data = [
        'token' => $token_acceso,
        'email' => $tutor_email,
        'nombre' => $tutor_nombre,
        'telefono' => $tutor_telefono,
        'parentesco' => $tutor_parentesco,
        'fecha_limite' => $fecha_limite
    ];
    
    $token_id = guardarToken($conexion, $token_data, $menores_data);
    
    // Crear enlace de acceso seguro
    $enlace_acceso = "http://localhost/iefk/auth/activar_cuenta.php?token=" . $token_acceso;

    // Configurar PHPMailer
    $mail = new PHPMailer(true);
    
    // Configuracion directa del servidor SMTP
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'direccioniefk@gmail.com';
    $mail->Password = 'gwsr kjig hush ukwg';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;
    $mail->SMTPOptions = [
        'ssl' => [
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        ]
    ];
    
    // Configuracion del mensaje
    $mail->CharSet = 'UTF-8';
    $mail->isHTML(true);
    
    // Configurar remitente
    $mail->setFrom('direccioniefk@gmail.com', 'Instituto Educativo Frida Kahlo');
    
    // Configurar destinatario y contenido
    $mail->addAddress($tutor_email, $tutor_nombre);
    $mail->addReplyTo('admisiones@iefk.edu.mx', 'Instituto Educativo Frida Kahlo');
    
    // Configurar el mensaje
    $mail->Subject = 'Invitacion para Proceso de Admision - Instituto Educativo Frida Kahlo';
    
    // Plantilla HTML del correo
    $fecha_limite_formato = date('d/m/Y', strtotime($fecha_limite));
    $parentesco_texto = [
        'madre' => 'Madre',
        'padre' => 'Padre', 
        'abuelo' => 'Abuelo(a)',
        'tio' => 'Tio(a)',
        'tutor_legal' => 'Tutor Legal',
        'otro' => 'Otro'
    ][$tutor_parentesco] ?? $tutor_parentesco;

    $mail->Body = "
    <!DOCTYPE html>
    <html lang='es'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Invitacion de Admision</title>
    </head>
    <body style='margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f8f9fa;'>
        <div style='max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(251, 92, 118, 0.1);'>
            
            <!-- Header -->
            <div style='background: linear-gradient(135deg, #fb5c76, #e54965); color: white; padding: 30px; text-align: center;'>
                <h1 style='margin: 0; font-size: 24px; font-weight: bold;'>
                    Instituto Educativo Frida Kahlo
                </h1>
                <p style='margin: 10px 0 0 0; font-size: 16px; opacity: 0.9;'>
                    Proceso de Admision
                </p>
            </div>
            
            <!-- Contenido Principal -->
            <div style='padding: 30px;'>
                <h2 style='color: #fb5c76; margin-top: 0; font-size: 20px;'>
                    Hola, {$tutor_nombre}!
                </h2>
                
                <p style='color: #343a40; line-height: 1.6; margin-bottom: 20px;'>
                    Nos da mucho gusto que hayas elegido el <strong>Instituto Educativo Frida Kahlo</strong> 
                    para la educacion de tu(s) hijo(s). Hemos recibido tu solicitud de admision y estamos 
                    emocionados de iniciar este proceso contigo.
                </p>
                
                <!-- Informacion del Tutor -->
                <div style='background-color: #fdd5dd; border-radius: 8px; padding: 20px; margin-bottom: 25px;'>
                    <h3 style='color: #e54965; margin-top: 0; font-size: 16px; display: flex; align-items: center;'>
                        Informacion del Tutor
                    </h3>
                    <table style='width: 100%; border-collapse: collapse;'>
                        <tr>
                            <td style='padding: 8px 0; color: #6c757d; width: 120px;'><strong>Nombre:</strong></td>
                            <td style='padding: 8px 0; color: #343a40;'>{$tutor_nombre}</td>
                        </tr>
                        <tr>
                            <td style='padding: 8px 0; color: #6c757d;'><strong>Parentesco:</strong></td>
                            <td style='padding: 8px 0; color: #343a40;'>{$parentesco_texto}</td>
                        </tr>
                        <tr>
                            <td style='padding: 8px 0; color: #6c757d;'><strong>Telefono:</strong></td>
                            <td style='padding: 8px 0; color: #343a40;'>{$tutor_telefono}</td>
                        </tr>
                    </table>
                </div>
                
                <!-- Informacion de Menores -->
                <div style='background-color: #f8f9fa; border-radius: 8px; padding: 20px; margin-bottom: 25px;'>
                    <h3 style='color: #e54965; margin-top: 0; font-size: 16px;'>
                        Menor(es) a inscribir
                    </h3>
                    <table style='width: 100%; border-collapse: collapse; border: 1px solid #e9ecef; border-radius: 6px; overflow: hidden;'>
                        <thead>
                            <tr style='background-color: #fb5c76; color: white;'>
                                <th style='padding: 12px; text-align: left; border-right: 1px solid rgba(255,255,255,0.2);'>Nombre</th>
                                <th style='padding: 12px; text-align: left; border-right: 1px solid rgba(255,255,255,0.2);'>Edad</th>
                                <th style='padding: 12px; text-align: left; border-right: 1px solid rgba(255,255,255,0.2);'>Servicio</th>
                                <th style='padding: 12px; text-align: left;'>Plantel</th>
                            </tr>
                        </thead>
                        <tbody>
                            {$menores_info}
                        </tbody>
                    </table>
                </div>
                
                <!-- Proximos Pasos -->
                <div style='background: linear-gradient(135deg, #17a2b8, #138496); color: white; border-radius: 8px; padding: 20px; margin-bottom: 25px;'>
                    <h3 style='margin-top: 0; font-size: 16px;'>
                        Activar tu Cuenta de Padre de Familia
                    </h3>
                    <p style='margin-bottom: 15px; line-height: 1.6; opacity: 0.9;'>
                        Para completar el proceso de admision y acceder a tu portal personalizado, 
                        haz clic en el boton de abajo para activar tu cuenta:
                    </p>
                    
                    <div style='text-align: center; margin: 20px 0;'>
                        <a href='{$enlace_acceso}' 
                           style='background: #ffffff; color: #17a2b8; padding: 15px 30px; border-radius: 25px; 
                                  text-decoration: none; font-weight: bold; font-size: 16px; 
                                  box-shadow: 0 4px 15px rgba(0,0,0,0.2); display: inline-block;
                                  transition: all 0.3s ease;'>
                            Activar Mi Cuenta
                        </a>
                    </div>
                    
                    <p style='margin: 15px 0 0 0; line-height: 1.6; opacity: 0.9; font-size: 14px;'>
                        <strong>Importante:</strong> Este enlace es unico y personal. 
                        Caduca el <strong>{$fecha_limite_formato}</strong>.
                    </p>
                    
                    <p style='margin: 10px 0 0 0; line-height: 1.6; opacity: 0.8; font-size: 12px;'>
                        Si el boton no funciona, copia y pega este enlace en tu navegador:<br>
                        <span style='word-break: break-all; background: rgba(255,255,255,0.2); padding: 5px; border-radius: 3px;'>{$enlace_acceso}</span>
                    </p>
                </div>
                
                <!-- Informacion Adicional -->
                <div style='background-color: #e7f3ff; border-radius: 8px; padding: 20px; margin-bottom: 25px;'>
                    <h3 style='color: #0c5460; margin-top: 0; font-size: 16px;'>
                        Que pasa despues de activar tu cuenta?
                    </h3>
                    <ul style='color: #0c5460; line-height: 1.8; margin: 0; padding-left: 20px;'>
                        <li>Crearas tu contrasena personal</li>
                        <li>Accederas al portal de padres</li>
                        <li>Podras subir documentos de tus hijos</li>
                        <li>Veras el progreso de la admision</li>
                        <li>Recibiras notificaciones importantes</li>
                    </ul>
                </div>
                
                <!-- Contacto -->
                <div style='border-top: 2px solid #e9ecef; padding-top: 20px; text-align: center;'>
                    <p style='color: #6c757d; margin-bottom: 15px;'>
                        Si tienes alguna pregunta, no dudes en contactarnos:
                    </p>
                    <p style='color: #fb5c76; font-weight: bold; margin: 0;'>
                        33 1690 6553 | direccioniefk@gmail.com
                    </p>
                </div>
            </div>
            
            <!-- Footer -->
            <div style='background-color: #343a40; color: white; padding: 20px; text-align: center;'>
                <p style='margin: 0; font-size: 14px; opacity: 0.8;'>
                    " . date('Y') . " Instituto Educativo Frida Kahlo - Todos los derechos reservados
                </p>
            </div>
        </div>
    </body>
    </html>";

    // Version texto plano como alternativa
    $mail->AltBody = "
    Instituto Educativo Frida Kahlo - Proceso de Admision
    
    Hola, {$tutor_nombre}!
    
    Hemos recibido tu solicitud de admision para el Instituto Educativo Frida Kahlo.
    
    Informacion del Tutor:
    - Nombre: {$tutor_nombre}
    - Parentesco: {$parentesco_texto}
    - Telefono: {$tutor_telefono}
    
    Fecha limite para documentacion: {$fecha_limite_formato}
    
    Para activar tu cuenta, visita: {$enlace_acceso}
    
    Contacto: 33 1690 6553 | direccioniefk@gmail.com
    ";

    // Enviar el correo
    if ($mail->send()) {
        echo json_encode([
            'success' => true, 
            'message' => 'Invitacion enviada exitosamente a ' . $tutor_email,
            'details' => [
                'tutor' => $tutor_nombre,
                'email' => $tutor_email,
                'menores' => $num_menores,
                'fecha_limite' => $fecha_limite_formato,
                'timestamp' => date('Y-m-d H:i:s'),
                'token_id' => $token_id
            ]
        ]);
    } else {
        throw new Exception('Error al enviar el correo: ' . $mail->ErrorInfo);
    }

} catch (Exception $e) {
    // Manejo de errores
    error_log("Error en process_admission.php: " . $e->getMessage());
    
    echo json_encode([
        'success' => false, 
        'message' => 'Error: ' . $e->getMessage()
    ]);
}
?>
