<?php
defined( 'ABSPATH' ) || exit;
?>

<!-- Contact Information -->
<div class="flex flex-col gap-5 lg:col-span-5">

    <!-- Email Card -->
    <article
        data-reveal="right"
        style="--reveal-delay: 100ms"
        class="group relative isolate overflow-hidden rounded-3xl border border-line/80 bg-white p-6 shadow-sm transition-[transform,box-shadow,border-color] duration-500 ease-out hover:-translate-y-1 hover:border-blue/30 hover:shadow-xl hover:shadow-blue/5 sm:p-7"
    >
        <!-- Decorative accent -->
        <div
            aria-hidden="true"
            class="pointer-events-none absolute -left-12 -top-12 -z-10 size-36 rounded-full bg-blue/5 blur-2xl transition-colors duration-500 group-hover:bg-blue/10"
        ></div>

        <div class="flex items-start gap-4">
            <div class="grid size-12 shrink-0 place-items-center rounded-2xl border border-blue/10 bg-gradient-to-br from-blue/15 to-blue/5 text-blue transition-transform duration-300 group-hover:scale-105">
                <svg class="size-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
            </div>

            <div class="min-w-0 flex-1">
                <h3 class="text-lg font-bold tracking-tight text-ink">
                    <?php esc_html_e( 'البريد الإلكتروني', '3alemni' ); ?>
                </h3>

                <p class="mt-2 text-sm leading-7 text-muted">
                    <?php esc_html_e( 'تقدر تراسلنا في أي وقت بشكل مباشر.', '3alemni' ); ?>
                </p>

                <a
                    href="mailto:support@3alemni.com"
                    dir="ltr"
                    class="mt-4 inline-flex max-w-full items-center gap-2 break-all rounded-lg text-sm font-bold text-blue transition-colors duration-200 hover:text-blue/70 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue/50 focus-visible:ring-offset-4"
                >
                    <span>support@3alemni.com</span>

                    <svg class="size-4 shrink-0 transition-transform duration-300 group-hover:-translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M7 17 17 7M7 7h10v10"/>
                    </svg>
                </a>
            </div>
        </div>
    </article>

    <!-- Community Card -->
    <article
        data-reveal="right"
        style="--reveal-delay: 200ms"
        class="group relative overflow-hidden rounded-3xl border border-line/80 bg-white p-6 shadow-sm transition-[transform,box-shadow,border-color] duration-500 ease-out hover:-translate-y-1 hover:border-blue/30 hover:shadow-xl hover:shadow-blue/5 sm:p-7"
    >
        <div class="flex items-start gap-4">
            <div class="grid size-12 shrink-0 place-items-center rounded-2xl border border-indigo-500/10 bg-gradient-to-br from-indigo-500/15 to-blue/5 text-indigo-600 transition-transform duration-300 group-hover:scale-105">
                <svg class="size-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"/>
                </svg>
            </div>

            <div class="min-w-0 flex-1">
                <h3 class="text-lg font-bold tracking-tight text-ink">
                    <?php esc_html_e( 'مجتمع علّمني', '3alemni' ); ?>
                </h3>

                <p class="mt-2 text-sm leading-7 text-muted">
                    <?php esc_html_e( 'انضم للشباب اللي يتعلموا معانا وباش تلقى الإجابة على أسئلتك بسرعة.', '3alemni' ); ?>
                </p>

                <a
                    href="#"
                    class="mt-4 inline-flex items-center gap-2 text-sm font-bold text-blue transition-colors duration-200 hover:text-blue/70 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue/50 focus-visible:ring-offset-4"
                >
                    <span>
                        <?php esc_html_e( 'انضم لمجتمع الديسكورد', '3alemni' ); ?>
                    </span>

                    <svg class="size-4 transition-transform duration-300 group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 12H5m7 7-7-7 7-7"/>
                    </svg>
                </a>
            </div>
        </div>
    </article>

    <!-- Quick FAQ -->
    <aside
        data-reveal="right"
        style="--reveal-delay: 300ms"
        class="group rounded-3xl border border-blue/15 bg-blue/[0.035] p-6 transition-[border-color,background-color] duration-300 hover:border-blue/30 hover:bg-blue/[0.06] sm:p-7"
    >
        <div class="flex items-start gap-3">
            <div class="grid size-10 shrink-0 place-items-center rounded-xl border border-blue/10 bg-white text-blue shadow-sm">
                <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9.5 9a2.5 2.5 0 115 0c0 1.5-2.5 2-2.5 4m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0Z"/>
                </svg>
            </div>

            <div class="min-w-0 flex-1">
                <h4 class="font-bold tracking-tight text-ink">
                    <?php esc_html_e( 'حوس على إجابة سريعة؟', '3alemni' ); ?>
                </h4>

                <p class="mt-2 text-sm leading-7 text-muted">
                    <?php esc_html_e( 'طلّ على الأسئلة الشائعة باش تعرف أكثر على طريقة التسجيل، الشهادات، والدورات.', '3alemni' ); ?>
                </p>

                <a
                    href="<?php echo esc_url( home_url( '/#faq' ) ); ?>"
                    class="mt-4 inline-flex items-center gap-2 text-sm font-bold text-ink transition-colors duration-200 hover:text-blue focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue/50 focus-visible:ring-offset-4"
                >
                    <span>
                        <?php esc_html_e( 'شوف الأسئلة الشائعة', '3alemni' ); ?>
                    </span>

                    <svg class="size-4 transition-transform duration-300 group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 12H5m7 7-7-7 7-7"/>
                    </svg>
                </a>
            </div>
        </div>
    </aside>

</div>