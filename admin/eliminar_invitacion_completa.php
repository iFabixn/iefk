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
    // 🚨 Iniciar transacción para eliminación completa
    $conn->begin_transaction();
    
    // 📊 Obtener información de la invitación y padre asociado
    $query = "
        SELECT 
            ta.id as token_id,
            ta.tutor_email,
            ta.tutor_nombre,
            pf.id as padre_id
        FROM tokens_acceso ta
        LEFT JOIN padres_familia pf ON ta.tutor_email = pf.email
        WHERE ta.id = ?
    ";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $invitacion_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        $conn->rollback();
        echo json_encode(['success' => false, 'message' => 'Invitación no encontrada']);
        exit;
    }
    
    $datos = $result->fetch_assoc();
    $padre_id = $datos['padre_id'];
    
    // 🗑️ ELIMINACIÓN EN CASCADA - ORDEN IMPORTANTE
    
    // 1️⃣ Eliminar log de actividad de padres
    if ($padre_id) {
        $delete_log = "DELETE FROM log_actividad_padres WHERE padre_id = ?";
        $stmt_log = $conn->prepare($delete_log);
        $stmt_log->bind_param("i", $padre_id);
        $stmt_log->execute();
    }
    
    // 2️⃣ Eliminar sesiones activas
    if ($padre_id) {
        $delete_sesiones = "DELETE FROM sesiones_padres WHERE padre_id = ?";
        $stmt_sesiones = $conn->prepare($delete_sesiones);
        $stmt_sesiones->bind_param("i", $padre_id);
        $stmt_sesiones->execute();
    }
    
    // 3️⃣ Eliminar menores de admisión
    if ($padre_id) {
        $delete_menores = "DELETE FROM menores_admision WHERE padre_id = ?";
        $stmt_menores = $conn->prepare($delete_menores);
        $stmt_menores->bind_param("i", $padre_id);
        $stmt_menores->execute();
    }
    
    // 4️⃣ Eliminar tokens de recuperación de contraseña
    $delete_tokens_recuperacion = "DELETE FROM tokens_recuperacion_padres WHERE email = ?";
    $stmt_tokens_recup = $conn->prepare($delete_tokens_recuperacion);
    $stmt_tokens_recup->bind_param("s", $datos['tutor_email']);
    $stmt_tokens_recup->execute();
    
    // 5️⃣ Eliminar padre de familia
    if ($padre_id) {
        $delete_padre = "DELETE FROM padres_familia WHERE id = ?";
        $stmt_padre = $conn->prepare($delete_padre);
        $stmt_padre->bind_param("i", $padre_id);
        $stmt_padre->execute();
    }
    
    // 6️⃣ Finalmente, eliminar el token de acceso
    $delete_token = "DELETE FROM tokens_acceso WHERE id = ?";
    $stmt_token = $conn->prepare($delete_token);
    $stmt_token->bind_param("i", $invitacion_id);
    $stmt_token->execute();
    
    // 📝 Registrar la eliminación en el log
    $descripcion = "Eliminación completa de invitación: " . $datos['tutor_nombre'] . " (" . $datos['tutor_email'] . ")";
    $ip = $_SERVER['REMOTE_ADDR'] ?? '';
    $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? '';
    
    $insert_log = "INSERT INTO log_actividad_padres (padre_id, accion, descripcion, ip_address, user_agent) VALUES (NULL, 'eliminacion_completa', ?, ?, ?)";
    $stmt_insert_log = $conn->prepare($insert_log);
    $stmt_insert_log->bind_param("sss", $descripcion, $ip, $user_agent);
    $stmt_insert_log->execute();
    
    // ✅ Confirmar transacción
    $conn->commit();
    
    echo json_encode([
        'success' => true, 
        'message' => 'Invitación eliminada completamente del sistema. El email puede ser reutilizado.'
    ]);
    
} catch (Exception $e) {
    // 🚨 Revertir cambios en caso de error
    $conn->rollback();
    
    echo json_encode([
        'success' => false, 
        'message' => 'Error al eliminar: ' . $e->getMessage()
    ]);
}
?>
