<?php
// 🔒 VALIDAR SESIÓN DE ADMINISTRADOR
include('validar_sesion.php');
include('../db.php');

// 🔍 FILTROS PARA EXPORTACIÓN
$filtro_busqueda = isset($_GET['busqueda']) ? trim($_GET['busqueda']) : '';
$filtro_estado = isset($_GET['estado']) ? $_GET['estado'] : '';
$filtro_fecha = isset($_GET['fecha']) ? $_GET['fecha'] : '';

// 🏗️ CONSTRUIR CONDICIONES WHERE (misma lógica que la vista)
$where_conditions = [];
$params = [];
$types = '';

if (!empty($filtro_busqueda)) {
    $where_conditions[] = "(ta.tutor_nombre LIKE ? OR ta.tutor_email LIKE ?)";
    $busqueda_param = '%' . $filtro_busqueda . '%';
    $params[] = $busqueda_param;
    $params[] = $busqueda_param;
    $types .= 'ss';
}

if (!empty($filtro_estado)) {
    switch($filtro_estado) {
        case 'enviado':
            $where_conditions[] = "(ta.usado = 0 AND ta.expirado = 0)";
            break;
        case 'ingresado':
            $where_conditions[] = "(ta.usado = 1 AND pf.id IS NOT NULL)";
            break;
        case 'expirado':
            $where_conditions[] = "ta.expirado = 1";
            break;
    }
}

if (!empty($filtro_fecha)) {
    switch($filtro_fecha) {
        case 'hoy':
            $where_conditions[] = "DATE(ta.fecha_creacion) = CURDATE()";
            break;
        case 'semana':
            $where_conditions[] = "ta.fecha_creacion >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)";
            break;
        case 'mes':
            $where_conditions[] = "ta.fecha_creacion >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)";
            break;
    }
}

$where_clause = !empty($where_conditions) ? 'WHERE ' . implode(' AND ', $where_conditions) : '';

// 📊 Consulta para exportar TODOS los registros que coincidan con los filtros
$query = "
    SELECT 
        ta.tutor_nombre as 'Nombre del Tutor',
        ta.tutor_email as 'Email',
        ta.tutor_telefono as 'Teléfono',
        ta.tutor_parentesco as 'Parentesco',
        ta.fecha_creacion as 'Fecha de Envío',
        CASE 
            WHEN ta.expirado = 1 THEN 'Expirado'
            WHEN ta.usado = 1 AND pf.id IS NOT NULL THEN 'Ingresado'
            ELSE 'Enviado'
        END as 'Estado',
        ta.fecha_usado as 'Fecha de Uso',
        COUNT(ma.id) as 'Menores Registrados'
    FROM tokens_acceso ta
    LEFT JOIN padres_familia pf ON ta.tutor_email = pf.email
    LEFT JOIN menores_admision ma ON pf.id = ma.padre_id
    $where_clause
    GROUP BY ta.id
    ORDER BY ta.fecha_creacion DESC
";

// Preparar y ejecutar consulta
if (!empty($params)) {
    $stmt = $conn->prepare($query);
    if (!empty($types)) {
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $conn->query($query);
}

// 📁 Configurar headers para descarga CSV
$filename = 'invitaciones_enviadas_' . date('Y-m-d_H-i-s') . '.csv';
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Pragma: no-cache');
header('Expires: 0');

// 📝 Crear archivo CSV
$output = fopen('php://output', 'w');

// BOM para UTF-8 (para que Excel abra correctamente los acentos)
fputs($output, $bom = (chr(0xEF) . chr(0xBB) . chr(0xBF)));

// 📊 Escribir encabezados
if ($result && $result->num_rows > 0) {
    $primera_fila = $result->fetch_assoc();
    fputcsv($output, array_keys($primera_fila));
    
    // Escribir la primera fila de datos
    fputcsv($output, array_values($primera_fila));
    
    // Escribir el resto de los datos
    while ($row = $result->fetch_assoc()) {
        fputcsv($output, array_values($row));
    }
} else {
    // Si no hay datos, al menos escribir los encabezados
    $headers = ['Nombre del Tutor', 'Email', 'Teléfono', 'Parentesco', 'Fecha de Envío', 'Estado', 'Fecha de Uso', 'Menores Registrados'];
    fputcsv($output, $headers);
    fputcsv($output, ['Sin datos para exportar', '', '', '', '', '', '', '']);
}

fclose($output);
exit;
?>
