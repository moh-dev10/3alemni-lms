(() => {
    const revealSelector = [
        '[data-reveal]',
        '.principles-heading',
        '.principle-card',
        '.courses-heading',
        '.course-card',
        '.approach-heading',
        '.approach-card',
        // About page
        '.about-hero > *',
        '.about-value-card',
        '.about-story',
    ].join(',');

    const initScrollReveal = () => {
        const elements = [...document.querySelectorAll(revealSelector)];

        if (!elements.length) return;

        const reducedMotion = window.matchMedia(
            '(prefers-reduced-motion: reduce)'
        ).matches;

        if (reducedMotion || !('IntersectionObserver' in window)) {
            elements.forEach((element) => {
                element.classList.add('is-visible');
            });

            return;
        }

        elements.forEach((element) => {
            element.setAttribute(
                'data-reveal',
                element.dataset.reveal || 'up'
            );

            if (
                !element.style.getPropertyValue('--reveal-delay') &&
                element.matches(
                    '.principle-card, .course-card, .approach-card'
                )
            ) {
                const siblings = [...element.parentElement.children].filter(
                    (sibling) => sibling.matches(
                        '.principle-card, .course-card, .approach-card'
                    )
                );

                const index = siblings.indexOf(element);

                element.style.setProperty(
                    '--reveal-delay',
                    `${Math.max(index, 0) * 100}ms`
                );
            }
        });

        const observer = new IntersectionObserver(
            (entries, currentObserver) => {
                entries.forEach((entry) => {
                    if (!entry.isIntersecting) return;

                    entry.target.classList.add('is-visible');
                    currentObserver.unobserve(entry.target);
                });
            },
            {
                threshold: 0.12,
                rootMargin: '0px 0px -36px 0px',
            }
        );

        elements.forEach((element) => observer.observe(element));

        // Enable reveal styles only after observer setup.
        document.documentElement.classList.add('reveal-ready');
    };

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initScrollReveal, {
            once: true,
        });
    } else {
        initScrollReveal();
    }
})();
