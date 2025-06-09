document.addEventListener('DOMContentLoaded', () => {
  const toggleButton = document.getElementById('menu-toggle');
  const menu = document.getElementById('mobile-menu');
  const iconOpen = document.getElementById('menu-icon-open');
  const iconClose = document.getElementById('menu-icon-close');

  toggleButton.addEventListener('click', () => {
    // const isHidden = menu.classList.contains('hidden');
    menu.classList.toggle('mobile-menu');
    iconOpen.classList.toggle('hidden');
    iconClose.classList.toggle('hidden');
  });

  const userMenuButton = document.getElementById('user-menu-button');
  const userDropdown = document.getElementById('user-dropdown');

  userMenuButton.addEventListener('click', () => {
    userDropdown.classList.toggle('hidden');
  });
});
