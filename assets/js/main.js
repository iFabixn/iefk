// Menú desplegable
const menuToggle = document.getElementById('menuToggle');
const menuOverlay = document.getElementById('menuOverlay');
const closeMenu = document.getElementById('closeMenu');
const menuIcon = document.getElementById('menuIcon');

function openMenu() {
  menuOverlay.classList.add('active');
  menuIcon.classList.add('hide');
  document.body.classList.add('menu-open');
}

function closeMenuFunc() {
  menuOverlay.classList.remove('active');
  menuIcon.classList.remove('hide');
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