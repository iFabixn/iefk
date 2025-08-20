-- 🗃️ SISTEMA DE TOKENS Y PADRES DE FAMILIA
-- Ejecutar este SQL en phpMyAdmin

-- 1️⃣ Tabla para tokens de acceso
CREATE TABLE tokens_acceso (
    id INT AUTO_INCREMENT PRIMARY KEY,
    token VARCHAR(128) UNIQUE NOT NULL,
    tutor_email VARCHAR(255) NOT NULL,
    tutor_nombre VARCHAR(255) NOT NULL,
    tutor_telefono VARCHAR(20) NOT NULL,
    tutor_parentesco ENUM('madre', 'padre', 'abuelo', 'tio', 'tutor_legal', 'otro') NOT NULL,
    fecha_limite DATE NOT NULL,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_usado TIMESTAMP NULL,
    usado BOOLEAN DEFAULT FALSE,
    expirado BOOLEAN DEFAULT FALSE,
    ip_creacion VARCHAR(45),
    ip_usado VARCHAR(45),
    INDEX idx_token (token),
    INDEX idx_email (tutor_email),
    INDEX idx_usado (usado),
    INDEX idx_expirado (expirado)
);

-- 2️⃣ Tabla para padres registrados
CREATE TABLE padres_familia (
    id INT AUTO_INCREMENT PRIMARY KEY,
    token_id INT,
    email VARCHAR(255) UNIQUE NOT NULL,
    nombre VARCHAR(255) NOT NULL,
    telefono VARCHAR(20) NOT NULL,
    parentesco ENUM('madre', 'padre', 'abuelo', 'tio', 'tutor_legal', 'otro') NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    ultimo_acceso TIMESTAMP NULL,
    activo BOOLEAN DEFAULT TRUE,
    intentos_fallidos INT DEFAULT 0,
    bloqueado_hasta TIMESTAMP NULL,
    FOREIGN KEY (token_id) REFERENCES tokens_acceso(id),
    INDEX idx_email (email),
    INDEX idx_activo (activo)
);

-- 3️⃣ Tabla para menores (asociados a padres)
CREATE TABLE menores_admision (
    id INT AUTO_INCREMENT PRIMARY KEY,
    padre_id INT NOT NULL,
    token_id INT NOT NULL,
    nombre VARCHAR(255) NOT NULL,
    fecha_nacimiento DATE NOT NULL,
    servicio ENUM('guarderia', 'preescolar', 'primaria') NOT NULL,
    plantel ENUM('zapote', 'rio_nilo', 'colinas') NOT NULL,
    documentos_completos BOOLEAN DEFAULT FALSE,
    estatus ENUM('pendiente', 'documentos_subidos', 'revision', 'aprobado', 'rechazado') DEFAULT 'pendiente',
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (padre_id) REFERENCES padres_familia(id) ON DELETE CASCADE,
    FOREIGN KEY (token_id) REFERENCES tokens_acceso(id),
    INDEX idx_padre (padre_id),
    INDEX idx_estatus (estatus)
);

-- 4️⃣ Tabla para sesiones de padres
CREATE TABLE sesiones_padres (
    id INT AUTO_INCREMENT PRIMARY KEY,
    padre_id INT NOT NULL,
    session_token VARCHAR(128) UNIQUE NOT NULL,
    ip_address VARCHAR(45) NOT NULL,
    user_agent TEXT,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_expiracion TIMESTAMP NOT NULL,
    activa BOOLEAN DEFAULT TRUE,
    FOREIGN KEY (padre_id) REFERENCES padres_familia(id) ON DELETE CASCADE,
    INDEX idx_token (session_token),
    INDEX idx_padre (padre_id),
    INDEX idx_activa (activa)
);

-- 5️⃣ Tabla para log de actividad
CREATE TABLE log_actividad_padres (
    id INT AUTO_INCREMENT PRIMARY KEY,
    padre_id INT,
    accion VARCHAR(100) NOT NULL,
    descripcion TEXT,
    ip_address VARCHAR(45),
    user_agent TEXT,
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (padre_id) REFERENCES padres_familia(id) ON DELETE SET NULL,
    INDEX idx_padre (padre_id),
    INDEX idx_timestamp (timestamp)
);
