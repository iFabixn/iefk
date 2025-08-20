<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}
include('../db.php');

$mensaje = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = trim($_POST['correo']);
    $token = bin2hex(random_bytes(16)); // genera un token seguro

    $stmt = $conn->prepare("INSERT INTO invitaciones (correo, token) VALUES (?, ?)");
    $stmt->bind_param("ss", $correo, $token);

    if ($stmt->execute()) {
        $link = "http://localhost/iefk/auth/acceso.php?token=$token";
        $mensaje = "✅ Invitación creada exitosamente. Enlace generado:";
    } else {
        $mensaje = "❌ Error: " . $stmt->error;
    }
}
?>

<h2>Crear invitación para tutor</h2>

<form method="POST">
    <input type="email" name="correo" placeholder="Correo del tutor" required>
    <button type="submit">Generar invitación</button>
</form>

<?php if ($mensaje): ?>
    <p><?= $mensaje ?></p>
    <?php if (isset($link)): ?>
        <p><strong>Enlace:</strong> <a href="<?= $link ?>" target="_blank"><?= $link ?></a></p>
    <?php endif; ?>
<?php endif; ?>

<p><a href="dashboard.php">← Volver al panel</a></p>
