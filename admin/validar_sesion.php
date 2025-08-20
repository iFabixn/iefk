<?php
// Archivo de validación de sesión para archivos administrativos
session_start();

function validarSesionAdmin() {
    // Verificar si existe la sesión de admin
    if (!isset($_SESSION['admin_id']) || !isset($_SESSION['admin_nombre'])) {
        // Redirigir al login si no hay sesión activa
        header('Location: login.php?error=access_denied'); // 🔄 Volver a .php
        exit();
    }
    
    // Opcional: Verificar tiempo de inactividad (30 minutos)
    if (isset($_SESSION['ultima_actividad'])) {
        $inactividad = time() - $_SESSION['ultima_actividad'];
        if ($inactividad > 1800) { // 30 minutos = 1800 segundos
            // Destruir sesión por inactividad
            session_destroy();
            header('Location: login.php?error=session_expired'); // 🔄 Volver a .php
            exit();
        }
    }
    
    // Actualizar tiempo de última actividad
    $_SESSION['ultima_actividad'] = time();
    
    return true;
}

// Función para obtener información del admin actual
function getAdminActual() {
    return [
        'id' => $_SESSION['admin_id'] ?? null,
        'nombre' => $_SESSION['admin_nombre'] ?? null,
        'correo' => $_SESSION['admin_correo'] ?? null
    ];
}

// Función para cerrar sesión
function cerrarSesion() {
    session_destroy();
    header('Location: login.php?mensaje=logout_success'); // 🔄 Volver a .php
    exit();
}

// Validar automáticamente al incluir este archivo
validarSesionAdmin();
?>
