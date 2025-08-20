<?php
session_start();
session_destroy();
header("Location: login.php?mensaje=logout_success"); // 🔄 Volver a .php
exit;
