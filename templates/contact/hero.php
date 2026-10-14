<?php
defined( 'ABSPATH' ) || exit;
?>

<!-- Contact Hero -->
<header class="contact-hero relative isolate mx-auto max-w-5xl overflow-hidden px-4 py-20 text-center sm:px-8 sm:py-24 lg:py-28">

    <!-- Ambient background -->
    <div
        aria-hidden="true"
        class="pointer-events-none absolute inset-0 -z-10 overflow-hidden"
    >
        <!-- Blue glow -->
        <div
            class="absolute left-1/2 top-0 h-72 w-72 -translate-x-1/2 rounded-full blur-3xl sm:h-96 sm:w-96"
            style="background: rgba(59, 130, 246, 0.16);"
        ></div>

        <!-- Dotted pattern -->
        <div
            class="absolute inset-0 w-full "
            style="
                background-image: radial-gradient(
                    circle,
                    rgba(37, 99, 235, 0.22) 1.2px,
                    transparent 1.2px
                );
                background-size: 20px 20px;
                mask-image: linear-gradient(
                    to bottom,
                    black 0%,
                    rgba(0, 0, 0, 0.65) 45%,
                    transparent 100%
                );
                -webkit-mask-image: linear-gradient(
                    to bottom,
                    black 0%,
                    rgba(0, 0, 0, 0.65) 45%,
                    transparent 100%
                );
            "
        ></div>

        <!-- Horizontal accent -->
        <div
            class="absolute left-1/2 top-1/2 h-px w-full max-w-2xl -translate-x-1/2"
            style="background: linear-gradient(90deg, transparent, rgba(37, 99, 235, 0.25), transparent);"
        ></div>
    </div>

    <!-- Eyebrow -->
    <div
        data-reveal="up"
        class="flex justify-center"
    >
        <span class="group inline-flex items-center gap-2.5 rounded-full border border-blue/20 bg-white/80 px-4 py-2 text-xs font-bold tracking-wide text-blue shadow-sm shadow-blue/5 backdrop-blur-sm transition-colors duration-300 hover:border-blue/40 hover:bg-blue/5">
            <span class="relative flex size-2">
                <span class="absolute inline-flex size-full animate-ping rounded-full bg-blue/40 motion-reduce:animate-none"></span>
                <span class="relative inline-flex size-2 rounded-full bg-blue"></span>
            </span>

            <?php esc_html_e( 'تواصل معنا', '3alemni' ); ?>
        </span>
    </div>

    <!-- Heading -->
    <h1
        data-reveal="up"
        style="--reveal-delay: 100ms"
        class="mx-auto mt-5 max-w-3xl text-3xl font-extrabold leading-[1.35] tracking-tight text-ink sm:mt-6 sm:text-4xl md:text-5xl lg:text-6xl"
    >
        <?php esc_html_e( 'حنا هنا باش نعاونوك', '3alemni' ); ?>

        <span class="relative mt-1 inline-block text-blue">
            <?php esc_html_e( 'تنجح', '3alemni' ); ?>

            <svg
                aria-hidden="true"
                class="absolute -bottom-2 right-0 h-3 w-full text-blue/25"
                viewBox="0 0 180 12"
                fill="none"
                preserveAspectRatio="none"
            >
                <path
                    d="M3 8.5C44 2 111 2 177 7"
                    stroke="currentColor"
                    stroke-width="5"
                    stroke-linecap="round"
                />
            </svg>
        </span>
    </h1>

    <!-- Description -->
    <p
        data-reveal="up"
        style="--reveal-delay: 200ms"
        class="mx-auto mt-5 max-w-2xl text-sm leading-7 text-muted sm:mt-6 sm:text-base sm:leading-8 md:text-lg"
    >
        <?php esc_html_e( 'عندك سؤال على الدورات، المنصة، ولا حاب تتواصل مع الأساتذة؟ ابعتلنا رسالة ونرجعولك في أقرب وقت.', '3alemni' ); ?>
    </p>

    <!-- Supporting microcopy -->
    <div
        data-reveal="up"
        style="--reveal-delay: 300ms"
        class="mt-5 flex flex-wrap items-center justify-center gap-x-5 gap-y-3 text-xs font-medium text-muted sm:mt-6 sm:text-sm"
    >
        <span class="inline-flex items-center gap-2">
            <svg
                class="size-4 shrink-0 text-blue"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="1.8"
                aria-hidden="true"
            >
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l2.5 2.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
            </svg>
            <?php esc_html_e( 'نردّوا عليك في أقرب وقت', '3alemni' ); ?>
        </span>

        <span
            aria-hidden="true"
            class="hidden size-1 rounded-full bg-blue/40 sm:block"
        ></span>

        <span class="inline-flex items-center gap-2">
            <svg
                class="size-4 shrink-0 text-blue"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="1.8"
                aria-hidden="true"
            >
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 10h8M8 14h5m-8 6 3.5-3H17a4 4 0 0 0 4-4V7a4 4 0 0 0-4-4H7a4 4 0 0 0-4 4v10a3 3 0 0 0 2 3Z"/>
            </svg>
            <?php esc_html_e( 'مرحبا بجميع استفساراتك', '3alemni' ); ?>
        </span>
    </div>

</header>