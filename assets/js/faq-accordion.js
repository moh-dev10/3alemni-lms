
(() => {
    const initFaqAccordion = () => {
        document.querySelectorAll('[data-faq-accordion]').forEach((accordion) => {
            if (accordion.dataset.faqInitialized === 'true') return;

            accordion.dataset.faqInitialized = 'true';

            const triggers = accordion.querySelectorAll('.contact-faq__trigger');

            const getAnswer = (trigger) => {
                const id = trigger.getAttribute('aria-controls');
                return id ? document.getElementById(id) : null;
            };

            const closeItem = (trigger) => {
                const answer = getAnswer(trigger);
                const icon = trigger.querySelector('.contact-faq__icon');

                if (!answer) return;

                trigger.setAttribute('aria-expanded', 'false');
                answer.setAttribute('aria-hidden', 'true');
                answer.inert = true;

                // Animate from the current height to zero.
                answer.style.height = `${answer.scrollHeight}px`;

                requestAnimationFrame(() => {
                    answer.style.height = '0px';
                    answer.style.opacity = '0';
                });

                icon?.classList.remove(
                    'rotate-45',
                    'border-blue/20',
                    'bg-blue/5',
                    'text-blue'
                );
            };

            const openItem = (trigger) => {
                const answer = getAnswer(trigger);
                const icon = trigger.querySelector('.contact-faq__icon');

                if (!answer) return;

                trigger.setAttribute('aria-expanded', 'true');
                answer.setAttribute('aria-hidden', 'false');
                answer.inert = false;

                // Start from the current height.
                answer.style.height = `${answer.scrollHeight}px`;
                answer.style.opacity = '1';

                icon?.classList.add(
                    'rotate-45',
                    'border-blue/20',
                    'bg-blue/5',
                    'text-blue'
                );

                const handleTransitionEnd = (event) => {
                    if (event.propertyName !== 'height') return;

                    answer.removeEventListener(
                        'transitionend',
                        handleTransitionEnd
                    );

                    if (trigger.getAttribute('aria-expanded') === 'true') {
                        answer.style.height = 'auto';
                    }
                };

                answer.addEventListener('transitionend', handleTransitionEnd);
            };

            triggers.forEach((trigger) => {
                const answer = getAnswer(trigger);

                if (!answer) {
                    console.warn(
                        'FAQ answer not found:',
                        trigger.getAttribute('aria-controls')
                    );
                    return;
                }

                // Initial closed state.
                answer.style.overflow = 'hidden';
                answer.style.height = '0px';
                answer.style.opacity = '0';
                answer.style.transition =
                    'height 300ms ease, opacity 250ms ease';

                answer.inert = true;

                trigger.addEventListener('click', () => {
                    const isOpen =
                        trigger.getAttribute('aria-expanded') === 'true';

                    // Close all other items.
                    triggers.forEach((otherTrigger) => {
                        if (otherTrigger !== trigger) {
                            const otherAnswer = getAnswer(otherTrigger);

                            if (
                                otherAnswer &&
                                otherTrigger.getAttribute('aria-expanded') === 'true'
                            ) {
                                closeItem(otherTrigger);
                            }
                        }
                    });

                    if (isOpen) {
                        closeItem(trigger);
                    } else {
                        openItem(trigger);
                    }
                });
            });
        });
    };

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initFaqAccordion);
    } else {
        initFaqAccordion();
    }
})();
