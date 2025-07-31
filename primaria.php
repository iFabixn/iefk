<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8">
    <title>Instituto Educativo Frida Kahlo</title>
    <link rel="stylesheet" href="assets/css/guarderia.css">
    <link rel="stylesheet" href="assets/css/quienessomos.css">
    <link rel="stylesheet" href="assets/css/preescolar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="icon" type="image/png" href="assets/img/logo sin letras.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  </head>
  
  <body>
    <?php
      $customLogo = "assets/img/logorosa.png";
    ?>
    <?php include 'components/header.php'; ?>

    <!-- ===================== ESTANCIA INFANTIL ===================== -->
    <!-- Decorative Shapes -->
            <div class="shape shape-1" draggable="true">
                <img src="assets/img/cloud1.png" alt="Cloud Shape 1">
            </div>
            <div class="shape shape-2" draggable="true">
                <img src="assets/img/cloud1.png" alt="Cloud Shape 2">
            </div>
           
            <div class="shape shape-4" draggable="true">
                <img src="assets/img/cloud1.png" alt="Cloud Shape 4">
            </div>
         
             <!-- Decorative Shapes -->
            <div class="shape shape-6" draggable="true">
                <img src="assets/img/cloud1.png" alt="Cloud Shape 6">
            </div>
            <div class="shape shape-7" draggable="true">
                <img src="assets/img/cloud1.png" alt="Cloud Shape 7">
            </div>
            <div class="shape shape-8" draggable="true">
                <img src="assets/img/cloud1.png" alt="Cloud Shape 8">
            </div>
            <div class="shape shape-9" draggable="true">
                <img src="assets/img/cloud1.png" alt="Cloud Shape 9">
            </div>
    <main class="guarderia-main">
        <!-- Título principal -->
        <section class="guarderia-header">
            <h1 class="qs-title-guarderia">Primaria</h1>
        </section>

        <!-- Contenido principal -->
        <div class="guarderia-content">
            
            <main class="main-content">
                <div class="qs-row">
                    <div class="qs-img-col-guarderia">
                    <img src="assets/img/primariarosa.png" alt="Imagen quienes somos">
                    </div>
                    <div class="qs-info-col">
                    <div class="qs-subtitle">Aprendiendo a volar</div>
                    <div class="qs-cenefa">
                        <img src="assets/img/cenefarombosmobile.png" alt="Cenefa divisoria" class="cenefa-img-divider3">
                    </div>
                    <div class="qs-lorem">
                        <p>Nuestro programa de primaria está diseñado para acompañar a los niños en su desarrollo académico y personal. A través de un enfoque pedagógico integral, fomentamos el desarrollo de habilidades cognitivas, socioemocionales y motrices que serán la base sólida para su éxito académico futuro. Con metodologías innovadoras y un ambiente cálido de aprendizaje, preparamos a cada niño para enfrentar con confianza y entusiasmo su transición hacia la educación secundaria, cultivando su curiosidad natural y amor por el conocimiento.</p>
                    </div>
                    </div>
                </div>
            </main>

            <!-- Sección de dos columnas: Actividades e Imagen -->
            <section class="actividades-section">
                <div class="actividades-container">
                    <!-- Columna izquierda: Actividades -->
                    <div class="actividades-col">
                        <h3 class="actividades-title">Actividades:</h3>
                        <div class="qs-cenefa">
                        <img src="assets/img/cenefarombos.png" alt="Cenefa divisoria" class="cenefa-img-divider3">
                    </div>
                        
                        <ul class="actividades-list">
                            <li class="actividad-item">
                                <img src="assets/img/romborojo.png" alt="rombos-actividades">
                                <span>Español y comunicación efectiva.</span>
                            </li>
                            <li class="actividad-item">
                                <img src="assets/img/romboamarillo.png" alt="rombos-actividades">
                                <span>Matemáticas y resolución de problemas.</span>
                            </li>
                            <li class="actividad-item">
                                <img src="assets/img/romborojo.png" alt="rombos-actividades">
                                <span>Ciencias naturales e investigación.</span>
                            </li>
                            <li class="actividad-item">
                                <img src="assets/img/romboamarillo.png" alt="rombos-actividades">
                                <span>Inglés diario y conversación.</span>
                            </li>
                            <li class="actividad-item">
                                <img src="assets/img/romborojo.png" alt="rombos-actividades">
                                <span>Historia y geografía de México.</span>
                            </li>
                            <li class="actividad-item">
                                <img src="assets/img/romboamarillo.png" alt="rombos-actividades">
                                <span>Formación cívica y ética.</span>
                            </li>
                            <li class="actividad-item">
                                <img src="assets/img/romborojo.png" alt="rombos-actividades">
                                <span>Educación artística y cultural.</span>
                            </li>
                            <li class="actividad-item">
                                <img src="assets/img/romboamarillo.png" alt="rombos-actividades">
                                <span>Educación física y deportes.</span>
                            </li>
                            <li class="actividad-item">
                                <img src="assets/img/romborojo.png" alt="rombos-actividades">
                                <span>Robótica y programación.</span>
                            </li>
                            <li class="actividad-item">
                                <img src="assets/img/romboamarillo.png" alt="rombos-actividades">
                                <span>Preparación para secundaria.</span>
                            </li>
                        </ul>
                    </div>

                    <!-- Columna derecha: Carrusel de imágenes -->
                    <div class="imagen-col">
                        <div class="carousel-container">
                            <div class="carousel-wrapper">
                                <div class="carousel-track" id="carouselTrack">
                                    <div class="carousel-slide active">
                                        <img src="assets/img/guarderia/1.jpeg" alt="Actividad 1" class="carousel-img">
                                    </div>
                                    <div class="carousel-slide">
                                        <img src="assets/img/guarderia/2.jpeg" alt="Actividad 2" class="carousel-img">
                                    </div>
                                    <div class="carousel-slide">
                                        <img src="assets/img/guarderia/3.jpeg" alt="Actividad 3" class="carousel-img">
                                    </div>
                                    <div class="carousel-slide">
                                        <img src="assets/img/guarderia/4.jpeg" alt="Actividad 4" class="carousel-img">
                                    </div>
                                    <div class="carousel-slide">
                                        <img src="assets/img/guarderia/5.jpeg" alt="Actividad 5" class="carousel-img">
                                    </div>
                                    <div class="carousel-slide">
                                        <img src="assets/img/guarderia/6.jpeg" alt="Actividad 6" class="carousel-img">
                                    </div>
                                    <div class="carousel-slide">
                                        <img src="assets/img/guarderia/7.jpeg" alt="Actividad 7" class="carousel-img">
                                    </div>
                                    <div class="carousel-slide">
                                        <img src="assets/img/guarderia/8.jpg" alt="Actividad 8" class="carousel-img">
                                    </div>
                                    <div class="carousel-slide">
                                        <img src="assets/img/guarderia/9.jpeg" alt="Actividad 9" class="carousel-img">
                                    </div>
                                    <div class="carousel-slide">
                                        <img src="assets/img/guarderia/10.jpeg" alt="Actividad 10" class="carousel-img">
                                    </div>
                                    <div class="carousel-slide">
                                        <img src="assets/img/guarderia/11.jpeg" alt="Actividad 11" class="carousel-img">
                                    </div>
                                    <div class="carousel-slide">
                                        <img src="assets/img/guarderia/12.jpeg" alt="Actividad 12" class="carousel-img">
                                    </div>
                                    <div class="carousel-slide">
                                        <img src="assets/img/guarderia/13.jpeg" alt="Actividad 13" class="carousel-img">
                                    </div>
                                    <div class="carousel-slide">
                                        <img src="assets/img/guarderia/14.jpeg" alt="Actividad 14" class="carousel-img">
                                    </div>
                                    <div class="carousel-slide">
                                        <img src="assets/img/guarderia/15.jpeg" alt="Actividad 15" class="carousel-img">
                                    </div>
                                    <div class="carousel-slide">
                                        <img src="assets/img/guarderia/16.jpg" alt="Actividad 16" class="carousel-img">
                                    </div>
                                    <div class="carousel-slide">
                                        <img src="assets/img/guarderia/17.jpeg" alt="Actividad 17" class="carousel-img">
                                    </div>
                                    <div class="carousel-slide">
                                        <img src="assets/img/guarderia/18.jpeg" alt="Actividad 18" class="carousel-img">
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
                            
                            <!-- Indicadores -->
                            <div class="carousel-indicators" id="carouselIndicators">
                                <!-- Los indicadores se generarán dinámicamente -->
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Sección Horarios -->
            <section class="horarios-section">
                <h1 class="qs-title-guarderia-horarios">Contamos con preescolar en los siguientes planteles:</h1>
                <div class="horarios-content">
                    <!-- Plantel El Zapote -->
                    <div class="plantel-item">
                        <div class="horarios-image">
                            <img src="assets/img/escuelarosa.png" alt="Plantel El Zapote" class="horarios-img">
                            <h4 class="horarios-location">El Zapote</h4>
                        </div>
                        <div class="horarios-info">
                            <h3 class="horarios-title">Horario</h3>
                            <div class="horarios-details">
                                <p class="horario-item">
                                    <strong>Lunes a Viernes:</strong> 07:30 a.m. - 20:00 p.m.
                                </p>
                            </div>
                            <a href="https://wa.me/523316906553?text=Vengo%20de%20la%20pagina%20web%20me%20interesa%20el%20servicio%20de%20primaria%20en%20el%20plantel%20de%20el%20zapote" target="_blank" class="whatsapp-btn">
                                <i class="fab fa-whatsapp"></i> Contactar
                            </a>
                        </div>
                    </div>

            </section>
        </div>

        <!-- Elementos decorativos -->
        <div class="decorative-elements">
            <div class="decorative-shape shape-1"></div>
            <div class="decorative-shape shape-2"></div>
            <div class="decorative-shape shape-3"></div>
            <div class="decorative-shape shape-4"></div>
        </div>
    </main>

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