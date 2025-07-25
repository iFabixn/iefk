<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Instituto Educativo Frida Kahlo</title>
    <link rel="stylesheet" href="assets/css/servicios.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="icon" type="image/png" href="assets/img/logo sin letras.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
      @keyframes fadeInUp {
        0% { opacity: 0; transform: translateY(40px);}
        100% { opacity: 1; transform: translateY(0);}
      }
      .fade-in-up {
        opacity: 0;
        animation: fadeInUp 0.8s ease forwards;
      }
    </style>
</head>
    <script src="assets/js/main.js"></script>

<body>
  <div class="headerycards">
       <!-- ================= HEADER ================= -->
    <?php
$customLogo = "assets/img/logo frida kahlo blanco horizontal.png";
?>
<?php include 'components/header.php'; ?>

    <!-- ============== SECCIÓN PRINCIPAL ============== -->
    <div class="selection fade-in-up" style="animation-delay:0.3s">
        <h1>Educamos lo mejor de ti...</h1>
        <div class="cards-container">
            <!-- Card: Guardería -->
            <div class="card-left fade-in-up" style="animation-delay:0.4s">
                <div class="card-inner">
                    <img src="assets/img/guarderia.png" alt="Guardería">
                </div>
            </div>
            <!-- Card: Preescolar -->
            <div class="card-left fade-in-up" style="animation-delay:0.5s">
                <div class="card-inner">
                    <img src="assets/img/preescolar.png" alt="Preescolar">
                </div>
            </div>
            <!-- Card: Primaria -->
            <div class="card-right fade-in-up" style="animation-delay:0.6s">
                <div class="card-inner">
                    <img src="assets/img/primaria.png" alt="Primaria">
                </div>
            </div>
            <!-- Card: Licenciatura -->
            <div class="card-right fade-in-up" style="animation-delay:0.7s">
                <div class="card-inner">
                    <img src="assets/img/licenciatura.png" alt="Licenciatura">
                </div>
            </div>
        </div>
    </div>
  </div>
   

    <!-- ============== SECCIÓN DE NOTICIAS ============== -->
    <div class="container fade-in-up" style="animation-delay:0.8s">
        <div class="container noticias-container fade-in-up" style="animation-delay:0.9s">
            <h2 class="noticias-title fade-in-up" style="animation-delay:1s">Noticias</h2>
            <div class="noticias-row fade-in-up" style="animation-delay:1.1s">
                <!-- Carrusel de fotos -->
                <div class="noticias-carrusel fade-in-up" style="animation-delay:1.2s">
                    <span class="carrusel-arrow carrusel-arrow-left">&#10094;</span>
                    <div class="carrusel-rect">
                        <img src="" alt="Foto carrusel" class="carrusel-img">
                    </div>
                    <span class="carrusel-arrow carrusel-arrow-right">&#10095;</span>
                </div>
                <!-- Información de la noticia -->
                <div class="noticias-info fade-in-up" style="animation-delay:1.3s">
                    <h3 class="noticia-titulo">Noticia Lorem Ipsum</h3>
                    <img src="assets/img/cenefarombosmobile.png" alt="Cenefa noticia" class="cenefa-noticia-img">
                    <div class="noticia-texto">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque euismod, nisi eu consectetur consectetur, nisl nisi consectetur nisi, euismod euismod nisi nisi euismod.
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="cenefa-divider">
      <img src="assets/img/cenefarombos.png" alt="Cenefa divisoria" class="cenefa-img-divider">
    </div>
    <div class="cenefa-divider">
      <img src="assets/img/cenefarombosmobile.png" alt="Cenefa divisoria" class="cenefa-img-divider2">
    </div>
<!-- ============== FOOTER ============== -->
    <?php include 'components/footer.php'; ?>
    <!-- ============== MENÚ DESPLEGABLE ============== -->
    <?php include 'components/menu.php'; ?>

    

    <!-- ============== SCRIPTS ============== -->
</body>
</html>