<?php
defined( 'ABSPATH' ) || exit;
?>

<!-- Vision & Values -->
<section
    id="about-values"
    class="about-values mt-20 scroll-mt-24 md:mt-28"
    aria-labelledby="about-values-title"
    dir="rtl"
>
    <!-- Section Heading -->
    <header class="mx-auto mb-10 max-w-2xl text-center md:mb-12">
        <span
            data-reveal="up"
            class="about-reveal inline-flex items-center gap-2 rounded-full border border-blue/20 bg-blue/10 px-3 py-1.5 text-xs font-semibold text-blue"
            style="--reveal-delay: 0ms"
        >
            <?php esc_html_e( 'فلسفتنا', '3alemni' ); ?>
        </span>

        <h2
            id="about-values-title"
            data-reveal="up"
            class="about-reveal mt-4 text-2xl font-extrabold leading-relaxed tracking-tight text-ink sm:text-3xl md:text-4xl"
            style="--reveal-delay: 100ms"
        >
            <?php esc_html_e( 'تعلّم، طبّق، ومن بعد طوّر روحك', '3alemni' ); ?>
        </h2>

        <p
            data-reveal="up"
            class="about-reveal mx-auto mt-4 max-w-xl text-sm leading-8 text-muted sm:text-base"
            style="--reveal-delay: 200ms"
        >
            <?php esc_html_e( 'ثلاث مبادئ يوجّهوا طريقة التعلّم في علّمني، من أول مفهوم تفهمه حتى المشروع اللي تبنيه بيديك.', '3alemni' ); ?>
        </p>
    </header>

    <!-- Values Grid -->
    <div class="grid items-stretch gap-5 md:grid-cols-3 md:gap-6">

        <!-- Learn -->
        <article
            data-reveal="up"
            class="about-reveal about-value-card group flex h-full flex-col rounded-3xl border border-line/80 bg-white p-6 shadow-sm transition duration-300 hover:-translate-y-1 hover:border-blue/30 hover:shadow-lg hover:shadow-blue/5 motion-reduce:transform-none motion-reduce:transition-none sm:p-8"
            style="--reveal-delay: 0ms"
        >
            <div class="flex items-center justify-between gap-3">
                <span class="grid size-12 place-items-center rounded-2xl bg-blue/10 text-blue transition-transform duration-300 group-hover:scale-105 motion-reduce:transition-none">
                    <svg class="size-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </span>

                <span class="font-mono text-xs font-semibold tracking-widest text-blue/50" aria-hidden="true">01</span>
            </div>

            <h3 class="mt-6 text-xl font-bold leading-relaxed text-ink">
                <?php esc_html_e( 'تعلّم بوضوح', '3alemni' ); ?>
            </h3>

            <p class="mt-3 text-sm leading-8 text-muted">
                <?php esc_html_e( 'نفهموا المفاهيم خطوة بخطوة، ونركّزوا على الأساسيات والممارسات الحديثة بلا تعقيد غير ضروري.', '3alemni' ); ?>
            </p>
        </article>

        <!-- Practice -->
        <article
            data-reveal="up"
            class="about-reveal about-value-card group flex h-full flex-col rounded-3xl border border-line/80 bg-white p-6 shadow-sm transition duration-300 hover:-translate-y-1 hover:border-blue/30 hover:shadow-lg hover:shadow-blue/5 motion-reduce:transform-none motion-reduce:transition-none sm:p-8"
            style="--reveal-delay: 120ms"
        >
            <div class="flex items-center justify-between gap-3">
                <span class="grid size-12 place-items-center rounded-2xl bg-blue/10 text-blue transition-transform duration-300 group-hover:scale-105 motion-reduce:transition-none">
                    <svg class="size-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/>
                    </svg>
                </span>

                <span class="font-mono text-xs font-semibold tracking-widest text-blue/50" aria-hidden="true">02</span>
            </div>

            <h3 class="mt-6 text-xl font-bold leading-relaxed text-ink">
                <?php esc_html_e( 'طبّق وابنِ مشاريعك', '3alemni' ); ?>
            </h3>

            <p class="mt-3 text-sm leading-8 text-muted">
                <?php esc_html_e( 'المشاهدة وحدها ما تكفيش. التطبيق والتمارين يساعدوك تحوّل المعرفة إلى مهارات ومشاريع تقدر تطوّرها.', '3alemni' ); ?>
            </p>
        </article>

        <!-- Grow -->
        <article
            data-reveal="up"
            class="about-reveal about-value-card group flex h-full flex-col rounded-3xl border border-line/80 bg-white p-6 shadow-sm transition duration-300 hover:-translate-y-1 hover:border-blue/30 hover:shadow-lg hover:shadow-blue/5 motion-reduce:transform-none motion-reduce:transition-none sm:p-8"
            style="--reveal-delay: 240ms"
        >
            <div class="flex items-center justify-between gap-3">
                <span class="grid size-12 place-items-center rounded-2xl bg-blue/10 text-blue transition-transform duration-300 group-hover:scale-105 motion-reduce:transition-none">
                    <svg class="size-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                </span>

                <span class="font-mono text-xs font-semibold tracking-widest text-blue/50" aria-hidden="true">03</span>
            </div>

            <h3 class="mt-6 text-xl font-bold leading-relaxed text-ink">
                <?php esc_html_e( 'تطوّر باستمرار', '3alemni' ); ?>
            </h3>

            <p class="mt-3 text-sm leading-8 text-muted">
                <?php esc_html_e( 'طوّر مستواك وثقتك بقدراتك، وواصل بناء مشاريعك الخاصة وفتح فرص جديدة للتعلّم والعمل.', '3alemni' ); ?>
            </p>
        </article>

    </div>
</section>