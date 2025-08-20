<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8">
    <title>Instituto Educativo Frida Kahlo</title>
    <link rel="stylesheet" href="assets/css/guarderia.css">
    <link rel="stylesheet" href="assets/css/quienessomos.css">
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
    <main class="guarderia-main">
        <!-- Título principal -->
        <section class="guarderia-header">
            <h1 class="qs-title-guarderia">Guardería</h1>
        </section>

        <!-- Contenido principal -->
        <div class="guarderia-content">
            
            <main class="main-content">
                <div class="qs-row">
                    <div class="qs-img-col-guarderia">
                    <img src="assets/img/guarderiarosa.png" alt="Imagen quienes somos">
                    </div>
                    <div class="qs-info-col">
                    <div class="qs-subtitle">Nido de diversión</div>
                    <div class="qs-cenefa">
                        <img src="assets/img/cenefarombosmobile.png" alt="Cenefa divisoria" class="cenefa-img-divider3">
                    </div>
                    <div class="qs-lorem">
                        <p>En nuestro servicio de guardería ofrecemos un ambiente seguro, cálido y estimulante donde los pequeños pueden aprender, jugar y desarrollar sus habilidades sociales mientras sus padres trabajan con total tranquilidad. Nuestro "Nido de diversión" está diseñado especialmente para brindar cuidado integral a niños y niñas, fomentando su desarrollo cognitivo, emocional y social a través de actividades lúdicas y educativas. Con personal altamente capacitado y espacios seguros, garantizamos que cada día sea una experiencia enriquecedora para los más pequeños de la familia.</p>
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
                                <span>Juegos didácticos y de mesa.</span>
                            </li>
                            <li class="actividad-item">
                                <img src="assets/img/romboamarillo.png" alt="rombos-actividades">
                                <span>Actividades de psicomotricidad gruesa.</span>
                            </li>
                            <li class="actividad-item">
                                <img src="assets/img/romborojo.png" alt="rombos-actividades">
                                <span>Talleres de arte y manualidades.</span>
                            </li>
                            <li class="actividad-item">
                                <img src="assets/img/romboamarillo.png" alt="rombos-actividades">
                                <span>Cuentacuentos y lectura de libros.</span>
                            </li>
                            <li class="actividad-item">
                                <img src="assets/img/romborojo.png" alt="rombos-actividades">
                                <span>Actividades musicales y rítmicas.</span>
                            </li>
                            <li class="actividad-item">
                                <img src="assets/img/romboamarillo.png" alt="rombos-actividades">
                                <span>Juegos de construcción y bloques.</span>
                            </li>
                            <li class="actividad-item">
                                <img src="assets/img/romborojo.png" alt="rombos-actividades">
                                <span>Actividades de estimulación sensorial.</span>
                            </li>
                            <li class="actividad-item">
                                <img src="assets/img/romboamarillo.png" alt="rombos-actividades">
                                <span>Juegos al aire libre y recreo.</span>
                            </li>
                            <li class="actividad-item">
                                <img src="assets/img/romborojo.png" alt="rombos-actividades">
                                <span>Ejercicios de motricidad fina.</span>
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
                <h1 class="qs-title-guarderia-horarios">Contamos con guardería en los siguientes planteles:</h1>
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
                                    <strong>Lunes a Viernes:</strong> 07:30 a.m. - 19:30 p.m.
                                </p>
                            </div>
                            <a href="https://wa.me/523316906553?text=Vengo%20de%20la%20pagina%20web%20me%20interesa%20guarderia%20en%20el%20plantel%20de%20el%20zapote" target="_blank" class="whatsapp-btn">
                                <i class="fab fa-whatsapp"></i> Contactar
                            </a>
                        </div>
                    </div>

                    <!-- Plantel Río Nilo -->
                    <div class="plantel-item">
                        <div class="horarios-image">
                            <img src="assets/img/escuelarosa.png" alt="Plantel Río Nilo" class="horarios-img">
                            <h4 class="horarios-location">Río Nilo</h4>
                        </div>
                        <div class="horarios-info">
                            <h3 class="horarios-title">Horario</h3>
                            <div class="horarios-details">
                                <p class="horario-item">
                                    <strong>Lunes a Viernes:</strong> 07:30 a.m. - 20:00 p.m.
                                </p>
                            </div>
                            <a href="https://wa.me/523316906553?text=Vengo%20de%20la%20pagina%20web%20me%20interesa%20guarderia%20en%20el%20plantel%20de%20rio%20nilo" target="_blank" class="whatsapp-btn">
                                <i class="fab fa-whatsapp"></i> Contactar
                            </a>
                        </div>
                    </div>

                    <!-- Plantel Colinas de Tonalá -->
                    <div class="plantel-item">
                        <div class="horarios-image">
                            <img src="assets/img/escuelarosa.png" alt="Plantel Colinas de Tonalá" class="horarios-img">
                            <h4 class="horarios-location">Colinas de Tonalá</h4>
                        </div>
                        <div class="horarios-info">
                            <h3 class="horarios-title">Horario</h3>
                            <div class="horarios-details">
                                <p class="horario-item">
                                    <strong>Lunes a Viernes:</strong> 07:30 a.m. - 18:30 p.m.
                                </p>
                            </div>
                            <a href="https://wa.me/523316906553?text=Vengo%20de%20la%20pagina%20web%20me%20interesa%20guarderia%20en%20el%20plantel%20de%20colinas%20de%20tonala" target="_blank" class="whatsapp-btn">
                                <i class="fab fa-whatsapp"></i> Contactar
                            </a>
                        </div>
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