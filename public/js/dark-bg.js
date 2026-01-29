let btn = document.getElementById('darkModeToggle');
let body = document.body;
let icon = btn.querySelector('i');

// Función para aplicar el modo
function applyTheme(theme) {
    if (theme === 'dark') {
        body.classList.add('dark-mode');
        icon.classList.replace('bi-moon', 'bi-sun');
    } else {
        body.classList.remove('dark-mode');
        icon.classList.replace('bi-sun', 'bi-moon');
    }
}

// Cargar preferencia al inicio
applyTheme(localStorage.getItem('theme'));

btn.addEventListener('click', () => {
    let isDark = body.classList.toggle('dark-mode');
    let theme = isDark ? 'dark' : 'light';
    localStorage.setItem('theme', theme);

    if (isDark) {
        icon.classList.replace('bi-moon', 'bi-sun');
    } else {
        icon.classList.replace('bi-sun', 'bi-moon');
    }
});