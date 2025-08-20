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
    // 📊 Consulta para obtener detalles completos de la invitación
    $query = "
        SELECT 
            ta.id,
            ta.token,
            ta.tutor_email,
            ta.tutor_nombre,
            ta.tutor_telefono,
            ta.tutor_parentesco,
            ta.fecha_creacion,
            ta.fecha_limite,
            ta.usado,
            ta.expirado,
            ta.fecha_usado,
            pf.id as padre_registrado,
            pf.ultimo_acceso,
            pf.fecha_registro
        FROM tokens_acceso ta
        LEFT JOIN padres_familia pf ON ta.tutor_email = pf.email
        WHERE ta.id = ?
    ";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $invitacion_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        echo json_encode(['success' => false, 'message' => 'Invitación no encontrada']);
        exit;
    }
    
    $invitacion = $result->fetch_assoc();
    
    // 👶 Obtener información de menores si existe padre registrado
    $menores_info = 'Sin menores registrados aún';
    if ($invitacion['padre_registrado']) {
        $menores_query = "
            SELECT 
                ma.nombre,
                ma.fecha_nacimiento,
                ma.servicio,
                ma.plantel,
                ma.estatus
            FROM menores_admision ma
            WHERE ma.padre_id = ?
        ";
        
        $menores_stmt = $conn->prepare($menores_query);
        $menores_stmt->bind_param("i", $invitacion['padre_registrado']);
        $menores_stmt->execute();
        $menores_result = $menores_stmt->get_result();
        
        if ($menores_result->num_rows > 0) {
            $menores_html = '';
            while ($menor = $menores_result->fetch_assoc()) {
                $edad = date_diff(date_create($menor['fecha_nacimiento']), date_create('today'))->y;
                $plantel_nombre = ucfirst(str_replace('_', ' ', $menor['plantel']));
                $servicio_nombre = ucfirst($menor['servicio']);
                
                $menores_html .= "• {$menor['nombre']} ({$edad} años) - {$servicio_nombre} - Plantel {$plantel_nombre}<br>";
            }
            $menores_info = $menores_html;
        }
    }
    
    // 📅 Formatear fechas
    $invitacion['fecha_creacion_formato'] = date('d/m/Y H:i', strtotime($invitacion['fecha_creacion']));
    $invitacion['fecha_usado_formato'] = $invitacion['fecha_usado'] ? date('d/m/Y H:i', strtotime($invitacion['fecha_usado'])) : null;
    $invitacion['menores_info'] = $menores_info;
    
    echo json_encode([
        'success' => true, 
        'invitacion' => $invitacion
    ]);
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false, 
        'message' => 'Error del servidor: ' . $e->getMessage()
    ]);
}
?>
