(() => {
    const button = document.querySelector('.hamburger');
    const menu = document.querySelector('nav ul.menu');
    if (!button || !menu) return;

    button.type = 'button';
    button.setAttribute('aria-controls', menu.id || 'menu');
    button.setAttribute('aria-expanded', 'false');
    button.setAttribute('aria-label', 'Ouvrir le menu de navigation');

    const backdrop = document.createElement('div');
    backdrop.className = 'menu-backdrop';
    document.body.append(backdrop);

    const setMenu = (open) => {
        menu.classList.toggle('active', open);
        button.classList.toggle('active', open);
        document.documentElement.classList.toggle('menu-open', open);
        document.body.classList.toggle('menu-open', open);
        backdrop.classList.toggle('is-visible', open);
        button.setAttribute('aria-expanded', String(open));
        button.setAttribute('aria-label', open ? 'Fermer le menu de navigation' : 'Ouvrir le menu de navigation');
    };

    button.addEventListener('click', () => setMenu(!menu.classList.contains('active')));
    backdrop.addEventListener('click', () => setMenu(false));
    menu.addEventListener('click', (event) => {
        if (event.target.closest('a')) setMenu(false);
    });
    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') setMenu(false);
    });

    const currentFile = window.location.pathname.split('/').pop() || 'head.php';
    menu.querySelectorAll('a').forEach((link) => {
        if (link.getAttribute('href') === currentFile) link.setAttribute('aria-current', 'page');
    });
})();
