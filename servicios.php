<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Instituto Educativo Frida Kahlo</title>
    <link rel="stylesheet" href="assets/css/servicios.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="icon" type="image/png" href="assets/img/logo sin letras.png">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
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
                    <a href="guarderia.php">
                        <img src="assets/img/guarderia.png" alt="Guardería">
                    </a>
                </div>
            </div>
            <!-- Card: Preescolar -->
            <div class="card-left fade-in-up" style="animation-delay:0.5s">
                <div class="card-inner">
                    <a href="preescolar.php">
                        <img src="assets/img/preescolar.png" alt="Preescolar">
                    </a>
                </div>
            </div>
            <!-- Card: Primaria -->
            <div class="card-right fade-in-up" style="animation-delay:0.6s">
                <div class="card-inner">
                    <a href="primaria.php">
                        <img src="assets/img/primaria.png" alt="Primaria">
                    </a>
                </div>
            </div>
            <!-- Card: Licenciatura -->
            <div class="card-right fade-in-up" style="animation-delay:0.7s">
                <div class="card-inner">
                    <a href="#">
                        <img src="assets/img/licenciatura.png" alt="Licenciatura">
                    </a>
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
                        <div class="carousel-container">
                            <div class="carousel-wrapper">
                                <div class="carousel-track" id="carouselTrack">
                                    <div class="carousel-slide active">
                                        <img src="assets/img/remodelacion1.png" alt="Actividad 1" class="carousel-img">
                                    </div>
                                    <div class="carousel-slide">
                                        <img src="assets/img/remodelacion2.png" alt="Actividad 2" class="carousel-img">
                                    </div>
                                    <div class="carousel-slide">
                                        <img src="assets/img/remodelacion3.png" alt="Actividad 3" class="carousel-img">
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Controles del carrusel -->
                            <button class="carousel-btn carousel-btn-prev" id="prevBtn">
                                <i class="fas fa-chevron-left"></i>
                            </button>
                            <button class="carousel-btn carousel-btn-next" id="nextBtn">
                                <i class="fas fa-chevron-right"></i>
                            </button>
                            
                            <!-- Indicadores del carrusel -->
                            <div class="carousel-indicators" id="carouselIndicators">
                                <!-- Los indicadores se generarán dinámicamente con JavaScript -->
                            </div>
                        </div>
                <!-- Información de la noticia -->
                <div class="noticias-info fade-in-up" style="animation-delay:1.3s">
                    <h3 class="noticia-titulo">¡Comenzamos las remodelaciones para recibir el nuevo ciclo escolar!</h3>
                    <img src="assets/img/cenefarombosmobile.png" alt="Cenefa noticia" class="cenefa-noticia-img">
                    <div class="noticia-texto">
                        Estamos renovando nuestros espacios para ofrecer un ambiente más cómodo, seguro y estimulante para todos nuestros alumnos.
¡Nos emociona recibirlos este 01 de septiembre!
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Decorative Shapes -->
            <div class="shape shapes-1" draggable="true">
                <img src="assets/img/cloud1.png" alt="Cloud Shape 1">
            </div>
            <div class="shape shapes-2" draggable="true">
                <img src="assets/img/cloud1.png" alt="Cloud Shape 2">
            </div>
            <div class="shape shapes-3" draggable="true">
                <img src="assets/img/cloud1.png" alt="Cloud Shape 3">
            </div>
            <div class="shape shapes-4" draggable="true">
                <img src="assets/img/cloud1.png" alt="Cloud Shape 4">
            </div>
            <div class="shape shapes-5" draggable="true">
                <img src="assets/img/cloud1.png" alt="Cloud Shape 5">
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