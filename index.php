<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8">
    <title>Instituto Educativo Frida Kahlo</title>
    <link rel="stylesheet" href="assets/css/index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="icon" type="image/png" href="assets/img/logo sin letras.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  </head>
  <body>
    <?php include 'components/header.php'; ?>

    

    <div class="container body-container">
        <main class="center-content">
            <div class="images-row">
                <img src="assets/img/buho.png" alt="Imagen 1" class="center-img buho-animado">
                <img src="assets/img/textoinicial.png" alt="Imagen 2" class="center-img">
            </div>
         </main>
         <div class="conocenos-btn-row">
            <a href="servicios.php" class="conocenos-btn">Conócenos</a>
         </div>
         <!-- Decorative Shapes -->
            <div class="shape shape-1" draggable="true">
                <img src="assets/img/cloud1.png" alt="Cloud Shape 1">
            </div>
            <div class="shape shape-2" draggable="true">
                <img src="assets/img/cloud1.png" alt="Cloud Shape 2">
            </div>
            <div class="shape shape-3" draggable="true">
                <img src="assets/img/cloud1.png" alt="Cloud Shape 3">
            </div>
            <div class="shape shape-4" draggable="true">
                <img src="assets/img/cloud1.png" alt="Cloud Shape 4">
            </div>
            <div class="shape shape-5" draggable="true">
                <img src="assets/img/cloud1.png" alt="Cloud Shape 5">
            </div>
    </div>
    <div class="cenefa-divider">
      <img src="assets/img/cenefarombos.png" alt="Cenefa divisoria" class="cenefa-img-divider">
    </div>
    <div class="cenefa-divider">
      <img src="assets/img/cenefarombosmobile.png" alt="Cenefa divisoria" class="cenefa-img-divider2">
    </div>

    <?php include 'components/footer.php'; ?>
    <?php include 'components/menu.php'; ?>
    <script src="assets/js/main.js"></script>
  </body>
</html>