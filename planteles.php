<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8">
    <title>Instituto Educativo Frida Kahlo</title>
    <link rel="stylesheet" href="assets/css/planteles.css">
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

    <!-- ===================== SECCIÓN PLANTELES ===================== -->
    <main class="main-content">
        <!-- Título principal -->
        <section class="planteles-header">
            <h1 class="planteles-title">Nuestros Planteles</h1>
            <div class="planteles-cenefa">
                <img src="assets/img/cenefarombos.png" alt="Cenefa divisoria" class="cenefa-img-divider3">
            </div>
            <p class="planteles-description">Contamos con 3 planteles estratégicamente ubicados para brindar el mejor servicio educativo a las familias de Tonalá</p>
        </section>

        <!-- Plantel El Zapote -->
        <section class="plantel-section">
            <div class="plantel-card">
                <div class="plantel-header">
                    <h2 class="plantel-name">Plantel El Zapote</h2>
                    <span class="plantel-badge principal">Plantel Matriz</span>
                </div>
                
                <div class="plantel-content">
                    <div class="plantel-info-col">
                        <div class="plantel-services">
                            <h3 class="plantel-subtitle">Servicios que ofrecemos</h3>
                            <div class="services-grid">
                                <div class="service-item">
                                    <a href="guarderia.php"><img src="assets/img/guarderiarosa.png" alt="Guardería" class="service-icon"></a>
                                    <span class="service-name">Guardería</span>
                                </div>
                                <div class="service-item">
                                    <a href="preescolar.php"><img src="assets/img/preescolarrosa.png" alt="Preescolar" class="service-icon"></a>
                                    <span class="service-name">Preescolar</span>
                                </div>
                                <div class="service-item">
                                    <a href="primaria.php"><img src="assets/img/primariarosa.png" alt="Primaria" class="service-icon"></a>
                                    <span class="service-name">Primaria</span>
                                </div>
                            </div>
                        </div>

                        <div class="plantel-details">
                            <div class="detail-item">
                                <i class="fas fa-clock"></i>
                                <div class="detail-content">
                                    <strong>Horarios:</strong>
                                    <span>7:30 AM - 8:00 PM</span>
                                </div>
                            </div>
                            <div class="detail-item">
                                <i class="fas fa-users"></i>
                                <div class="detail-content">
                                    <strong>Capacidad:</strong>
                                    <span>Hasta 200 niños</span>
                                </div>
                            </div>
                            <div class="detail-item">
                                <i class="fas fa-birthday-cake"></i>
                                <div class="detail-content">
                                    <strong>Edades:</strong>
                                    <span>4 meses - 12 años</span>
                                </div>
                            </div>
                            <div class="detail-item">
                                <i class="fas fa-utensils"></i>
                                <div class="detail-content">
                                    <strong>Servicios adicionales:</strong>
                                    <span>Alimentación, horario extendido y actividades extracurriculares</span>
                                </div>
                            </div>
                        </div>

                        <div class="plantel-actions">
                            <a href="https://www.google.com.mx/maps/place/Instituto+Educativo+Frida+Kahlo/@20.6315937,-103.2489686,17z/data=!3m1!4b1!4m6!3m5!1s0x8428b4613b4acd73:0x69ec43ec026476f!8m2!3d20.6315937!4d-103.2463937!16s%2Fg%2F11cn0sxzh9?hl=es&entry=ttu&g_ep=EgoyMDI1MDcyMy4wIKXMDSoASAFQAw%3D%3D" target="_blank" class="btn-location">
                                <i class="fas fa-map-marker-alt"></i>
                                Ver ubicación
                            </a>
                            <a href="https://wa.me/523316906553?text=Hola%20vengo%20de%20la%20pagina%20web" target="_blank" class="btn-contact">
                                <i class="fab fa-whatsapp"></i>
                                Contactar
                            </a>
                        </div>
                    </div>

                    <div class="plantel-gallery-col">
                        <div class="gallery-container">
                            <div class="gallery-main">
                                <img src="assets/img/.png" alt="Plantel El Zapote" class="gallery-main-img" id="zapoteMainImg">
                            </div>
                            <div class="gallery-thumbs">
                                <img src="assets/img/.png" alt="Exterior" class="gallery-thumb active" onclick="changeImage('zapoteMainImg', this.src)">
                                <img src="assets/img/.png" alt="Salón" class="gallery-thumb" onclick="changeImage('zapoteMainImg', this.src)">
                                <img src="assets/img/.png" alt="Área de juegos" class="gallery-thumb" onclick="changeImage('zapoteMainImg', this.src)">
                                <img src="assets/img/.png" alt="Comedor" class="gallery-thumb" onclick="changeImage('zapoteMainImg', this.src)">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Plantel Río Nilo -->
        <section class="plantel-section">
            <div class="plantel-card">
                <div class="plantel-header">
                    <h2 class="plantel-name">Plantel Río Nilo</h2>
                    <span class="plantel-badge reciente">Plantel más Reciente</span>
                </div>
                
                <div class="plantel-content reverse">
                    <div class="plantel-gallery-col">
                        <div class="gallery-container">
                            <div class="gallery-main">
                                <img src="assets/img/frenterionilo.webp" alt="Plantel Río Nilo" class="gallery-main-img" id="niloMainImg">
                            </div>
                            <div class="gallery-thumbs">
                                <img src="assets/img/frenterionilo.webp" alt="Exterior" class="gallery-thumb active" onclick="changeImage('niloMainImg', this.src)">
                                <img src="assets/img/recepcionrionilo.webp" alt="Salón principal" class="gallery-thumb" onclick="changeImage('niloMainImg', this.src)">
                                <img src="assets/img/aulasrionilo.webp" alt="Área de juegos" class="gallery-thumb" onclick="changeImage('niloMainImg', this.src)">
                                <img src="assets/img/salonrionilo.webp" alt="Zona de descanso" class="gallery-thumb" onclick="changeImage('niloMainImg', this.src)">
                            </div>
                        </div>
                    </div>

                    <div class="plantel-info-col">
                        <div class="plantel-services">
                            <h3 class="plantel-subtitle">Servicios que ofrecemos</h3>
                            <div class="services-grid">
                                <div class="service-item">
                                    <img src="assets/img/guarderiarosa.png" alt="Guardería" class="service-icon">
                                    <span class="service-name">Guardería Especializada</span>
                                </div>
                            </div>
                        </div>

                        <div class="plantel-details">
                            <div class="detail-item">
                                <i class="fas fa-clock"></i>
                                <div class="detail-content">
                                    <strong>Horarios:</strong>
                                    <span>7:30 AM - 7:30 PM</span>
                                </div>
                            </div>
                            <div class="detail-item">
                                <i class="fas fa-users"></i>
                                <div class="detail-content">
                                    <strong>Capacidad:</strong>
                                    <span>Hasta 40 niños</span>
                                </div>
                            </div>
                            <div class="detail-item">
                                <i class="fas fa-birthday-cake"></i>
                                <div class="detail-content">
                                    <strong>Edades:</strong>
                                    <span>3 meses - 4 años</span>
                                </div>
                            </div>
                            <div class="detail-item">
                                <i class="fas fa-heart"></i>
                                <div class="detail-content">
                                    <strong>Especialidad:</strong>
                                    <span>Cuidado personalizado para bebés y niños pequeños</span>
                                </div>
                            </div>
                        </div>

                        <div class="plantel-actions">
                            <a href="https://maps.app.goo.gl/QfP9oxNzyb6w3cBn6" target="_blank" class="btn-location">
                                <i class="fas fa-map-marker-alt"></i>
                                Ver ubicación
                            </a>
                            <a href="https://wa.me/523316906553?text=Hola%20vengo%20de%20la%20pagina%20web" target="_blank" class="btn-contact">
                                <i class="fab fa-whatsapp"></i>
                                Contactar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Plantel Colinas de Tonalá -->
        <section class="plantel-section">
            <div class="plantel-card">
                <div class="plantel-header">
                    <h2 class="plantel-name">Plantel Colinas de Tonalá</h2>
                    <span class="plantel-badge familiar">Segundo plantel</span>
                </div>
                
                <div class="plantel-content">
                    <div class="plantel-info-col">
                        <div class="plantel-services">
                            <h3 class="plantel-subtitle">Servicios que ofrecemos</h3>
                            <div class="services-grid">
                                <div class="service-item">
                                    <img src="assets/img/guarderiarosa.png" alt="Guardería" class="service-icon">
                                    <span class="service-name">Guardería Especializada</span>
                                </div>
                            </div>
                        </div>

                        <div class="plantel-details">
                            <div class="detail-item">
                                <i class="fas fa-clock"></i>
                                <div class="detail-content">
                                    <strong>Horarios:</strong>
                                    <span>7:30 AM - 6:30 PM</span>
                                </div>
                            </div>
                            <div class="detail-item">
                                <i class="fas fa-users"></i>
                                <div class="detail-content">
                                    <strong>Capacidad:</strong>
                                    <span>Hasta 30 niños</span>
                                </div>
                            </div>
                            <div class="detail-item">
                                <i class="fas fa-birthday-cake"></i>
                                <div class="detail-content">
                                    <strong>Edades:</strong>
                                    <span>2 meses - 4 años</span>
                                </div>
                            </div>
                            <div class="detail-item">
                                <i class="fas fa-home"></i>
                                <div class="detail-content">
                                    <strong>Ambiente:</strong>
                                    <span>Cálido y familiar, grupos reducidos</span>
                                </div>
                            </div>
                        </div>

                        <div class="plantel-actions">
                            <a href="https://maps.app.goo.gl/Tq4V8UkT2S1MRrAB8" target="_blank" class="btn-location">
                                <i class="fas fa-map-marker-alt"></i>
                                Ver ubicación
                            </a>
                            <a href="https://wa.me/523316906553?text=Hola%20vengo%20de%20la%20pagina%20web" target="_blank" class="btn-contact">
                                <i class="fab fa-whatsapp"></i>
                                Contactar
                            </a>
                        </div>
                    </div>

                    <div class="plantel-gallery-col">
                        <div class="gallery-container">
                            <div class="gallery-main">
                                <img src="assets/img/.png" alt="Plantel Colinas de Tonalá" class="gallery-main-img" id="colinasMainImg">
                            </div>
                            <div class="gallery-thumbs">
                                <img src="assets/img/.png" alt="Exterior" class="gallery-thumb active" onclick="changeImage('colinasMainImg', this.src)">
                                <img src="assets/img/.png" alt="Interior" class="gallery-thumb" onclick="changeImage('colinasMainImg', this.src)">
                                <img src="assets/img/.png" alt="Área de juegos" class="gallery-thumb" onclick="changeImage('colinasMainImg', this.src)">
                                <img src="assets/img/.png" alt="Jardín" class="gallery-thumb" onclick="changeImage('colinasMainImg', this.src)">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Sección de contacto general -->
        <section class="planteles-contact">
            <div class="contact-card">
                <h3 class="contact-title">¿Necesitas más información?</h3>
                <p class="contact-description">Nuestro equipo está listo para ayudarte a elegir el plantel que mejor se adapte a tus necesidades</p>
                <div class="contact-buttons">
                    <a href="https://wa.me/523316906553?text=Hola%20vengo%20de%20la%20pagina%20web" target="_blank" class="btn-contact-main">
                        <i class="fab fa-whatsapp"></i>
                        Escribir por WhatsApp
                    </a>
                    <a href="mailto: direccioniefk@gmail.com" class="btn-email">
                        <i class="fas fa-envelope"></i>
                        Enviar correo
                    </a>
                </div>
            </div>
        </section>
    </main>

    <div class="cenefa-divider">
      <img src="assets/img/cenefarombos.png" alt="Cenefa divisoria" class="cenefa-img-divider">
    </div>
    <div class="cenefa-divider">
      <img src="assets/img/cenefarombosmobile.png" alt="Cenefa divisoria" class="cenefa-img-divider2">
    </div>
    <?php include 'components/footer.php'; ?>
    <?php include 'components/menu.php'; ?>
    
    <script>
        // Función para cambiar la imagen principal de la galería
        function changeImage(mainImgId, newSrc) {
            document.getElementById(mainImgId).src = newSrc;
            
            // Remover clase active de todas las thumbnails del mismo grupo
            const mainImg = document.getElementById(mainImgId);
            const gallery = mainImg.closest('.gallery-container');
            const thumbs = gallery.querySelectorAll('.gallery-thumb');
            
            thumbs.forEach(thumb => {
                thumb.classList.remove('active');
                if (thumb.src === newSrc) {
                    thumb.classList.add('active');
                }
            });
        }

        // Animaciones de scroll para los planteles
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        // Observar todas las secciones de planteles
        document.addEventListener('DOMContentLoaded', function() {
            const plantelSections = document.querySelectorAll('.plantel-section');
            plantelSections.forEach(section => {
                section.style.opacity = '0';
                section.style.transform = 'translateY(30px)';
                section.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
                observer.observe(section);
            });
        });
    </script>
    
    <script src="assets/js/main.js"></script>
  </body>
</html>