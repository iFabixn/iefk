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