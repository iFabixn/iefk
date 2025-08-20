<?php
// Herramienta para eliminar invitaciones con manejo de foreign keys
include('../db.php');
$conexion = $conn;

header('Content-Type: text/html; charset=UTF-8');

echo "<!DOCTYPE html>
<html>
<head>
    <meta charset='UTF-8'>
    <title>Gestión de Invitaciones</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .invitacion { border: 1px solid #ddd; padding: 15px; margin: 10px 0; border-radius: 5px; }
        .btn { padding: 10px 15px; margin: 5px; border: none; border-radius: 3px; cursor: pointer; }
        .btn-danger { background: #dc3545; color: white; }
        .btn-info { background: #17a2b8; color: white; }
        .success { background: #d4edda; border: 1px solid #c3e6cb; padding: 10px; border-radius: 5px; color: #155724; }
        .error { background: #f8d7da; border: 1px solid #f5c6cb; padding: 10px; border-radius: 5px; color: #721c24; }
    </style>
</head>
<body>
    <h1>🗑️ Gestión de Invitaciones - IEFK</h1>";

// Procesar eliminación si se solicita
if (isset($_POST['eliminar_token_id'])) {
    $token_id = (int)$_POST['eliminar_token_id'];
    
    try {
        $conexion->autocommit(false);
        $conexion->begin_transaction();
        
        echo "<div class='success'><h3>🔄 Eliminando invitación Token ID: $token_id</h3>";
        
        // 1. Eliminar menores_admision
        $stmt1 = $conexion->prepare("DELETE FROM menores_admision WHERE token_id = ?");
        $stmt1->bind_param("i", $token_id);
        $result1 = $stmt1->execute();
        $menores_eliminados = $conexion->affected_rows;
        echo "✅ Menores eliminados: $menores_eliminados<br>";
        
        // 2. Eliminar padres_familia
        $stmt2 = $conexion->prepare("DELETE FROM padres_familia WHERE token_id = ?");
        $stmt2->bind_param("i", $token_id);
        $result2 = $stmt2->execute();
        $padres_eliminados = $conexion->affected_rows;
        echo "✅ Padres eliminados: $padres_eliminados<br>";
        
        // 3. Eliminar tokens_acceso
        $stmt3 = $conexion->prepare("DELETE FROM tokens_acceso WHERE id = ?");
        $stmt3->bind_param("i", $token_id);
        $result3 = $stmt3->execute();
        $tokens_eliminados = $conexion->affected_rows;
        echo "✅ Tokens eliminados: $tokens_eliminados<br>";
        
        $conexion->commit();
        $conexion->autocommit(true);
        
        echo "<strong>🎉 ¡Invitación eliminada completamente!</strong></div>";
        
    } catch (Exception $e) {
        $conexion->rollback();
        $conexion->autocommit(true);
        echo "<div class='error'>❌ Error al eliminar: " . $e->getMessage() . "</div>";
    }
}

// Eliminar TODAS las invitaciones
if (isset($_POST['eliminar_todas'])) {
    try {
        $conexion->autocommit(false);
        $conexion->begin_transaction();
        
        echo "<div class='success'><h3>🔄 Eliminando TODAS las invitaciones</h3>";
        
        // 1. Eliminar todos los menores
        $result1 = $conexion->query("DELETE FROM menores_admision");
        $menores_eliminados = $conexion->affected_rows;
        echo "✅ Total menores eliminados: $menores_eliminados<br>";
        
        // 2. Eliminar todos los padres
        $result2 = $conexion->query("DELETE FROM padres_familia");
        $padres_eliminados = $conexion->affected_rows;
        echo "✅ Total padres eliminados: $padres_eliminados<br>";
        
        // 3. Eliminar todos los tokens
        $result3 = $conexion->query("DELETE FROM tokens_acceso");
        $tokens_eliminados = $conexion->affected_rows;
        echo "✅ Total tokens eliminados: $tokens_eliminados<br>";
        
        $conexion->commit();
        $conexion->autocommit(true);
        
        echo "<strong>🎉 ¡TODAS las invitaciones eliminadas!</strong></div>";
        
    } catch (Exception $e) {
        $conexion->rollback();
        $conexion->autocommit(true);
        echo "<div class='error'>❌ Error al eliminar todo: " . $e->getMessage() . "</div>";
    }
}

// Mostrar invitaciones existentes
echo "<h2>📋 Invitaciones Existentes</h2>";

$query = "
SELECT 
    t.id as token_id,
    t.tutor_nombre,
    t.tutor_email,
    t.tutor_telefono,
    t.tutor_parentesco,
    t.fecha_limite,
    t.fecha_creacion,
    t.usado,
    t.expirado,
    COUNT(m.id) as num_menores,
    GROUP_CONCAT(m.nombre SEPARATOR ', ') as nombres_menores
FROM tokens_acceso t
LEFT JOIN menores_admision m ON t.id = m.token_id
GROUP BY t.id
ORDER BY t.fecha_creacion DESC
";

$result = $conexion->query($query);

if ($result->num_rows == 0) {
    echo "<p>🎉 No hay invitaciones en la base de datos.</p>";
} else {
    echo "<form method='post' style='margin-bottom: 20px;'>
            <button type='submit' name='eliminar_todas' class='btn btn-danger' 
                    onclick='return confirm(\"¿Estás COMPLETAMENTE SEGURO de eliminar TODAS las invitaciones? Esta acción NO se puede deshacer.\")'>
                🗑️ ELIMINAR TODAS LAS INVITACIONES
            </button>
          </form>";
    
    while ($row = $result->fetch_assoc()) {
        $estado = $row['usado'] ? '✅ Usado' : ($row['expirado'] ? '⏰ Expirado' : '🟡 Pendiente');
        
        echo "<div class='invitacion'>
                <h3>👤 {$row['tutor_nombre']} 
                    <span style='font-size: 0.8em; color: #666;'>($estado)</span>
                </h3>
                <p><strong>📧 Email:</strong> {$row['tutor_email']}</p>
                <p><strong>📞 Teléfono:</strong> {$row['tutor_telefono']}</p>
                <p><strong>👨‍👩‍👧‍👦 Parentesco:</strong> {$row['tutor_parentesco']}</p>
                <p><strong>📅 Fecha límite:</strong> {$row['fecha_limite']}</p>
                <p><strong>🕒 Fecha creación:</strong> {$row['fecha_creacion']}</p>
                <p><strong>👶 Menores ({$row['num_menores']}):</strong> {$row['nombres_menores']}</p>
                
                <form method='post' style='display: inline;'>
                    <input type='hidden' name='eliminar_token_id' value='{$row['token_id']}'>
                    <button type='submit' class='btn btn-danger' 
                            onclick='return confirm(\"¿Eliminar la invitación de {$row['tutor_nombre']}?\")'>
                        🗑️ Eliminar
                    </button>
                </form>
              </div>";
    }
}

echo "
    <hr>
    <p><a href='../admissions.php'>← Volver al Panel de Administración</a></p>
    <h3>💡 Orden de eliminación para evitar errores de Foreign Key:</h3>
    <ol>
        <li>🗑️ <strong>menores_admision</strong> (primero)</li>
        <li>🗑️ <strong>padres_familia</strong> (segundo)</li>
        <li>🗑️ <strong>tokens_acceso</strong> (último)</li>
    </ol>
</body>
</html>";
?>
