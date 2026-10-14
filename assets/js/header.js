
document.addEventListener('DOMContentLoaded', () => {
    const menuButton = document.getElementById('mobile-menu-button');
    const navigation = document.getElementById('primary-navigation');
    const topLine = document.getElementById('menu-line-top');
    const bottomLine = document.getElementById('menu-line-bottom');

    if (!menuButton || !navigation) return;

    const desktopMedia = window.matchMedia('(min-width: 768px)');

    const openLabel = menuButton.dataset.openLabel || 'Open navigation menu';
    const closeLabel = menuButton.dataset.closeLabel || 'Close navigation menu';

    function setMenuState(isOpen) {
        const isDesktop = desktopMedia.matches;
        const shouldShow = isDesktop || isOpen;

        menuButton.setAttribute('aria-expanded', String(!isDesktop && isOpen));
        menuButton.setAttribute(
            'aria-label',
            !isDesktop && isOpen ? closeLabel : openLabel
        );

        navigation.inert = !shouldShow;

        navigation.classList.toggle('invisible', !shouldShow);
        navigation.classList.toggle('pointer-events-none', !shouldShow);
        navigation.classList.toggle('opacity-0', !shouldShow);
        navigation.classList.toggle('-translate-y-2', !shouldShow);

        navigation.classList.toggle('visible', shouldShow);
        navigation.classList.toggle('pointer-events-auto', shouldShow);
        navigation.classList.toggle('opacity-100', shouldShow);
        navigation.classList.toggle('translate-y-0', shouldShow);

        topLine?.classList.toggle('translate-y-[3.5px]', !isDesktop && isOpen);
        topLine?.classList.toggle('rotate-45', !isDesktop && isOpen);

        bottomLine?.classList.toggle('-translate-y-[3.5px]', !isDesktop && isOpen);
        bottomLine?.classList.toggle('-rotate-45', !isDesktop && isOpen);
    }

    menuButton.addEventListener('click', () => {
        const isOpen = menuButton.getAttribute('aria-expanded') !== 'true';
        setMenuState(isOpen);
    });

    navigation.querySelectorAll('a').forEach((link) => {
        link.addEventListener('click', () => {
            if (!desktopMedia.matches) setMenuState(false);
        });
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && !desktopMedia.matches) {
            setMenuState(false);
            menuButton.focus();
        }
    });

    desktopMedia.addEventListener('change', () => setMenuState(false));

    setMenuState(false);
});
