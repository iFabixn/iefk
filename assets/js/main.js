document.addEventListener('DOMContentLoaded', function() {
  // Carrusel de imágenes
  const carruselImages = [
    "assets/img/remodelacion1.png",
    "assets/img/remodelacion2.png",
    "assets/img/remodelacion3.png"
  ];
  let currentIndex = 0;

  const carruselImg = document.querySelector('.carrusel-img');
  const leftArrow = document.querySelector('.carrusel-arrow-left');
  const rightArrow = document.querySelector('.carrusel-arrow-right');

  function showImage(index) {
    if (carruselImg) {
      carruselImg.src = carruselImages[index];
    }
  }

  // Inicializa el carrusel
  showImage(currentIndex);

  if (leftArrow && rightArrow && carruselImg) {
    leftArrow.addEventListener('click', () => {
      currentIndex = (currentIndex - 1 + carruselImages.length) % carruselImages.length;
      showImage(currentIndex);
    });

    rightArrow.addEventListener('click', () => {
      currentIndex = (currentIndex + 1) % carruselImages.length;
      showImage(currentIndex);
    });
  }

  // Menú desplegable
  const menuToggle = document.getElementById('menuToggle');
  const menuOverlay = document.getElementById('menuOverlay');
  const closeMenu = document.getElementById('closeMenu');
  const menuBackground = document.getElementById('menuBackground');

  function openMenu() {
    menuOverlay.classList.add('active');
    menuBackground.classList.add('active');
    document.body.classList.add('menu-open');
  }

  function closeMenuFunc() {
    menuOverlay.classList.remove('active');
    menuBackground.classList.remove('active');
    document.body.classList.remove('menu-open');
  }

  if (menuToggle && closeMenu) {
    menuToggle.addEventListener('click', openMenu);
    closeMenu.addEventListener('click', closeMenuFunc);
  }


  // Copiar al portapapeles
  function copyToClipboard(id) {
    const el = document.getElementById(id);
    const text = el.textContent.split(': ')[1];
    navigator.clipboard.writeText(text).then(() => {
      el.style.background = "#ffe9b3";
      setTimeout(() => { el.style.background = ""; }, 800);
        });
  }

  // ===================== CARRUSEL DE GUARDERÍA =====================
  const carouselTrack = document.getElementById('carouselTrack');
  const prevBtn = document.getElementById('prevBtn');
  const nextBtn = document.getElementById('nextBtn');
  const indicatorsContainer = document.getElementById('carouselIndicators');
  
  if (carouselTrack) {
    const slides = carouselTrack.querySelectorAll('.carousel-slide');
    let currentSlide = 0;
    
    // Asegurar que solo la primera slide esté activa al inicio
    slides.forEach((slide, index) => {
      slide.classList.remove('active');
      if (index === 0) {
        slide.classList.add('active');
      }
    });
    
    // Crear indicadores
    if (indicatorsContainer) {
      slides.forEach((_, index) => {
        const indicator = document.createElement('div');
        indicator.classList.add('carousel-indicator');
        if (index === 0) indicator.classList.add('active');
        indicator.addEventListener('click', () => goToSlide(index));
        indicatorsContainer.appendChild(indicator);
      });
    }
    
    const indicators = indicatorsContainer ? indicatorsContainer.querySelectorAll('.carousel-indicator') : [];
    
    function updateCarousel() {
      // Ocultar todas las slides
      slides.forEach((slide, index) => {
        slide.classList.remove('active');
        if (index === currentSlide) {
          slide.classList.add('active');
        }
      });
      
      // Actualizar indicadores
      indicators.forEach((indicator, index) => {
        indicator.classList.remove('active');
        if (index === currentSlide) {
          indicator.classList.add('active');
        }
      });
    }
    
    function goToSlide(index) {
      currentSlide = index;
      updateCarousel();
    }
    
    function nextSlide() {
      currentSlide = (currentSlide + 1) % slides.length;
      updateCarousel();
    }
    
    function prevSlide() {
      currentSlide = (currentSlide - 1 + slides.length) % slides.length;
      updateCarousel();
    }
    
    // Event listeners
    if (nextBtn) nextBtn.addEventListener('click', nextSlide);
    if (prevBtn) prevBtn.addEventListener('click', prevSlide);
    
    // Auto-play del carrusel (opcional)
    let autoPlayInterval = setInterval(nextSlide, 3000); // Cambia cada 3 segundos

    // Pausar auto-play al hover
    if (carouselTrack.parentElement) {
      carouselTrack.parentElement.addEventListener('mouseenter', () => {
        clearInterval(autoPlayInterval);
      });
      
      carouselTrack.parentElement.addEventListener('mouseleave', () => {
        autoPlayInterval = setInterval(nextSlide, 3000); // Reiniciar auto-play
      });
    }
    
    // Inicializar carrusel
    updateCarousel();
  }
});

