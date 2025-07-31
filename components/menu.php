<style>

.menu-section.disabled .menu-link {
    color: #888 !important;
    cursor: not-allowed;
    pointer-events: none;
}

.menu-section.disabled .menu-section-img {
    filter: grayscale(100%) brightness(0.6);
    opacity: 0.5;
}

.menu-section.disabled .menu-section-word {
    color: #888 !important;
    position: relative;
}

</style>

<div class="menu-background" id="menuBackground"></div>
<div class="menu-overlay" id="menuOverlay">
  <div class="menu-overlay-header-row">
    <div class="menu-overlay-header">
      <a href="index.php">
        <img src="assets/img/logo frida kahlo blanco horizontal.png" alt="Logo" class="logo-img-overlay">
      </a>
    </div>
    <div class="menu-close-row">
      <span class="menu-close-label">Menú</span>
      <button class="close-btn" id="closeMenu" aria-label="Cerrar menú">
        <i class="fas fa-times fa-2x"></i>
      </button>
    </div>
  </div>
  <div class="menu-section yellow">
    <a href="quienessomos.php" class="menu-link">
      <img src="assets/img/pajaro.png" alt="Icono quienes somos" class="menu-section-img">
      <span class="menu-section-word">Quienes somos</span>
    </a>
  </div>
  <div class="menu-section red">
    <a href="servicios.php" class="menu-link">
      <img src="assets/img/arbol.png" alt="Icono servicios" class="menu-section-img">
      <span class="menu-section-word">Servicios</span>
    </a>
  </div>
  <div class="menu-section yellow">
    <a href="planteles.php" class="menu-link">
      <img src="assets/img/escuela.png" alt="Icono escuelas" class="menu-section-img">
      <span class="menu-section-word">Planteles</span>
    </a>
  </div>
  <div class="menu-section red disabled">
    <a href="" class="menu-link">
      <img src="assets/img/libro.png" alt="Icono contacto" class="menu-section-img">
      <span class="menu-section-word">Próximamente...</span>
    </a>
  </div>