<?php
/**
 * 🔒 PROTECCIÓN AUTOMÁTICA PARA FRAGMENTOS
 * Este archivo previene el acceso directo a fragmentos HTML/PHP
 * que deben ser incluidos desde otros archivos autenticados
 */

// Verificar si este archivo está siendo accedido directamente
$currentFile = basename($_SERVER['PHP_SELF']);
$fragmentFiles = [
    'registrar_admision.php',
    'admisiones_eliminadas.php', 
    'gestion_tutores.php',
    'revision_documentacion.php',
    'invitaciones_enviadas.php',
    'asistencias_hoy.php',
    'gestion_horas_extra.php',
    'reportes_mensuales.php',
    'scanner_qr.php',
    'configuracion.php',
    'control_plantel.php',
    'dashboard_general.php',
    'reportes_consolidados.php',
    'expediente_empleado.php',
    'lista_empleados.php',
    'nomina_salarios.php',
    'vista_general.php',
    'busqueda_global.php',
    'estadisticas.php',
    'ficha_alumno.php',
    'lista_alumnos.php',
    'reportes.php',
    'vista_aulas.php',
    'vista_planteles.php',
    'categorias_tickets.php',
    'crear_ticket.php',
    'dashboard_tickets.php',
    'ver_ticket.php',
    'gestion_roles.php',
    'lista_usuarios.php'
];

// Si es un fragmento y se accede directamente, redirigir al login
if (in_array($currentFile, $fragmentFiles)) {
    header('Location: ../login.php?error=access_denied'); // 🔄 Volver a .php
    exit('❌ Acceso denegado. Este fragmento solo puede ser incluido desde el panel administrativo.');
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Acceso Denegado - IEFK</title>
    <style>
        body { font-family: 'Inter', sans-serif; background: #f3f4f6; display: flex; align-items: center; justify-content: center; min-height: 100vh; margin: 0; }
        .error-container { background: white; padding: 40px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); text-align: center; max-width: 500px; }
        .error-icon { font-size: 4rem; color: #dc2626; margin-bottom: 20px; }
        .error-title { font-size: 1.5rem; font-weight: bold; color: #374151; margin-bottom: 10px; }
        .error-message { color: #6b7280; margin-bottom: 30px; }
        .login-btn { background: #1e3a8a; color: white; padding: 12px 24px; border: none; border-radius: 8px; text-decoration: none; display: inline-block; font-weight: 500; }
        .login-btn:hover { background: #1e40af; }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="error-icon">🔒</div>
        <h1 class="error-title">Acceso Denegado</h1>
        <p class="error-message">
            Esta sección requiere autenticación de administrador.<br>
            Por favor inicia sesión para continuar.
        </p>
        <a href="../login.php" class="login-btn">Ir al Login</a> <!-- 🔄 Volver a .php -->
    </div>
</body>
</html>
