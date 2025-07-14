document.addEventListener('DOMContentLoaded', function() {
  // Carrusel de imágenes
  const carruselImages = [
    "assets/img/libro.png",
    "assets/img/arbol.png",
    "assets/img/pajaro.png"
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
});

