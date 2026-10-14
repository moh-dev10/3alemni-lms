<?php
defined( 'ABSPATH' ) || exit;

$courses_url = get_post_type_archive_link( 'courses' );

if ( ! $courses_url ) {
    $courses_url = home_url( '/' );
}
?>

<section
    class="hero-section relative isolate overflow-hidden bg-paper py-16 sm:py-20 lg:py-24"
    dir="rtl"
    lang="ar"
>
    <!-- Ambient background -->
    <div class="hero-ambient hero-ambient--one" aria-hidden="true"></div>
    <div class="hero-ambient hero-ambient--two" aria-hidden="true"></div>
    <div class="hero-grid" aria-hidden="true"></div>

    <div class="relative mx-auto grid w-full max-w-[1240px] grid-cols-1 items-center gap-14 px-[clamp(20px,5vw,72px)] lg:grid-cols-[minmax(0,1.05fr)_minmax(0,0.95fr)] lg:gap-12 xl:gap-16">

        <!-- Copy -->
        <div class="hero-copy relative z-10 min-w-0">

            <p class="hero-enter hero-enter--1 mb-6 inline-flex items-center gap-3 rounded-full border border-blue/10 bg-white/80 px-4 py-2 text-xs font-semibold text-muted shadow-sm shadow-ink/[0.03] sm:text-sm">
                <span class="relative flex size-2.5 items-center justify-center" aria-hidden="true">
                    <span class="absolute size-full animate-ping rounded-full bg-blue/30"></span>
                    <span class="relative size-2 rounded-full bg-blue"></span>
                </span>
                <span>3alemni <span class="mx-1 text-blue/40">/</span> منصة التعلّم</span>
            </p>

            <h1 class="hero-enter hero-enter--2 max-w-3xl text-5xl font-semibold leading-[1.3] tracking-tight text-ink sm:text-6xl lg:text-[clamp(3.5rem,5.2vw,5rem)] lg:leading-[1.25]">
                تعلّم مهارة.
                <br>
                ابنِ ثقتك.
                <br>
                <span class="hero-title-highlight relative inline-block text-blue">
                    وابدأ.
                </span>
            </h1>

            <p class="hero-enter hero-enter--3 mt-7 max-w-xl text-base leading-8 text-muted sm:text-lg sm:leading-9">
                طريقك للتعلّم ما لازم يكون معقّد.
                اكتشف دورات واضحة، تعلّم في وقتك،
                وطبّق واش تتعلّم خطوة بخطوة.
            </p>

            <div class="hero-enter hero-enter--4 mt-8 flex flex-wrap items-center gap-3 sm:gap-4">

                <a
                    class="hero-cta-primary group inline-flex min-h-14 items-center justify-center gap-4 rounded-full bg-blue px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-blue/20 transition-colors hover:bg-blue-dark focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-blue sm:px-7"
                    href="<?php echo esc_url( $courses_url ); ?>"
                >
                    اكتشف الدورات

                    <svg
                        aria-hidden="true"
                        viewBox="0 0 24 24"
                        fill="none"
                        class="h-4 w-4 transition-transform duration-200 group-hover:-translate-x-1"
                    >
                        <path
                            d="M19 12H5m0 0 6 6m-6-6 6-6"
                            stroke="currentColor"
                            stroke-width="1.8"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        />
                    </svg>
                </a>

                <a
                    class="inline-flex min-h-14 items-center justify-center gap-2 rounded-full border border-line bg-white/70 px-6 py-3 text-sm font-semibold text-ink transition-all duration-200 hover:border-blue/30 hover:bg-white hover:text-blue focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-blue"
                    href="#approach"
                >
                    كيفاش نتعلّم؟

                    <svg
                        aria-hidden="true"
                        viewBox="0 0 20 20"
                        fill="none"
                        class="h-4 w-4 text-muted"
                    >
                        <path
                            d="m5 8 5 5 5-5"
                            stroke="currentColor"
                            stroke-width="1.7"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        />
                    </svg>
                </a>
            </div>

            <div class="hero-enter hero-enter--5 mt-8 flex items-center gap-3 text-sm text-muted">
                <span class="h-px w-8 bg-blue" aria-hidden="true"></span>
                <span>تعلّم على وتيرتك. تقدّم بخطواتك.</span>
            </div>
        </div>

        <!-- Learning dashboard visual -->
        <div
            class="hero-visual relative mx-auto w-full max-w-[540px] lg:max-w-none"
            dir="rtl"
            aria-hidden="true"
        >
            <div class="hero-visual-glow"></div>

            <!-- Main canvas -->
            <div class="hero-dashboard relative overflow-hidden rounded-[28px] border border-white/80 bg-[#F3F6FF] p-4 shadow-[0_30px_90px_-35px_rgba(30,64,175,0.25)] sm:rounded-[34px] sm:p-6">

                <!-- Top bar -->
                <div class="relative z-10 flex items-center justify-between gap-3 pb-5">
                    <div class="flex items-center gap-3">
                        <span class="grid size-10 place-items-center rounded-2xl bg-blue text-sm font-bold text-white shadow-lg shadow-blue/20">
                            ع
                        </span>
                        <div>
                            <p class="text-sm font-bold text-ink">مساحة تعلّمك</p>
                            <p class="mt-1 text-[11px] text-muted">كل خطوة تقرّبك لهدفك</p>
                        </div>
                    </div>

                    <span class="inline-flex items-center gap-2 rounded-full border border-white bg-white/80 px-3 py-2 text-[10px] font-semibold text-muted sm:text-xs">
                        <span class="size-1.5 rounded-full bg-emerald-500"></span>
                        تعلّم مستمر
                    </span>
                </div>

                <!-- Featured course -->
                <div class="hero-course-card relative overflow-hidden rounded-[24px] bg-ink p-5 text-white sm:p-6">
                    <div class="absolute -left-10 -top-14 size-44 rounded-full border border-white/10"></div>
                    <div class="absolute -left-2 -top-6 size-28 rounded-full border border-white/[0.08]"></div>
                    <div class="absolute -bottom-16 right-1/3 size-40 rounded-full bg-blue/30 blur-3xl"></div>

                    <div class="relative z-10 flex items-start justify-between gap-4">
                        <div>
                            <span class="inline-flex rounded-full border border-white/15 bg-white/10 px-3 py-1.5 text-[10px] font-semibold text-blue-100">
                                تعلّم · طبّق · تطوّر
                            </span>

                            <h2 class="mt-5 max-w-[230px] text-xl font-semibold leading-8 sm:text-2xl">
                                مهارات جديدة.
                                <br>
                                فرص أكثر.
                            </h2>

                            <p class="mt-2 max-w-[220px] text-xs leading-6 text-white/65 sm:text-sm">
                                ابني معرفتك، وطبّقها في مشاريعك.
                            </p>
                        </div>

                        <div class="hero-course-symbol grid size-[76px] shrink-0 place-items-center rounded-[24px] border border-white/15 bg-white/[0.08] sm:size-[94px]">
                            <svg viewBox="0 0 80 80" fill="none" class="w-14 sm:w-[70px]">
                                <path d="M40 8 67 23v34L40 72 13 57V23L40 8Z" stroke="#91B3FF" stroke-width="1.5"/>
                                <path d="m25 32 15-9 15 9-15 9-15-9Z" fill="#2457E6"/>
                                <path d="M25 40v9l15 9 15-9v-9" stroke="#91B3FF" stroke-width="1.5" stroke-linejoin="round"/>
                                <path d="M40 41v17" stroke="#91B3FF" stroke-width="1.5"/>
                            </svg>
                        </div>
                    </div>

                    <div class="relative z-10 mt-6 flex items-center justify-between border-t border-white/15 pt-4">
                        <span class="text-[10px] font-medium tracking-wider text-white/55 sm:text-xs">YOUR NEXT CHAPTER</span>
                        <span class="flex items-center gap-2 text-xs font-semibold text-white sm:text-sm">
                            ابدأ رحلتك
                            <svg viewBox="0 0 20 20" fill="none" class="size-4">
                                <path d="M15 10H5m0 0 4-4m-4 4 4 4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </span>
                    </div>
                </div>

                <!-- Learning progress -->
                <div class="mt-4 rounded-[22px] border border-white bg-white p-4 shadow-sm shadow-ink/[0.025] sm:p-5">
                    <div class="flex items-center justify-between gap-3">
                        <div>
                            <p class="text-sm font-bold text-ink">رحلتك تبدأ بخطوة</p>
                            <p class="mt-1.5 text-xs leading-5 text-muted">اختار دورة وابدأ تتعلّم على وتيرتك.</p>
                        </div>

                        <div class="grid size-11 shrink-0 place-items-center rounded-2xl bg-blue/5 text-blue">
                            <svg viewBox="0 0 24 24" fill="none" class="size-5">
                                <path d="M4 19V5m0 14h16M7 15l4-4 3 2 5-6" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                    </div>

                    <div class="mt-5 flex items-center justify-between text-[11px] font-medium">
                        <span class="text-muted">خطوة بخطوة</span>
                        <span class="text-blue">تقدّم مستمر</span>
                    </div>

                    <div class="mt-3 h-2 overflow-hidden rounded-full bg-[#E9EDF7]">
                        <div class="hero-progress-bar h-full w-[68%] rounded-full bg-gradient-to-l from-blue to-[#80A5FF]"></div>
                    </div>
                </div>

                <!-- Bottom learning principles -->
                <div class="mt-4 grid grid-cols-3 gap-2 sm:gap-3">
                    <div class="hero-mini-card rounded-2xl border border-white bg-white/80 px-2 py-3 text-center sm:px-3">
                        <span class="mx-auto grid size-9 place-items-center rounded-xl bg-blue/10 text-blue">
                            <svg viewBox="0 0 24 24" fill="none" class="size-[18px]">
                                <path d="M12 3v18m-7-7 7 7 7-7" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </span>
                        <p class="mt-2 text-[11px] font-bold text-ink sm:text-xs">تعلّم</p>
                        <p class="mt-1 text-[9px] text-muted sm:text-[10px]">اكتشف الجديد</p>
                    </div>

                    <div class="hero-mini-card rounded-2xl border border-white bg-white/80 px-2 py-3 text-center sm:px-3">
                        <span class="mx-auto grid size-9 place-items-center rounded-xl bg-indigo-50 text-indigo-600">
                            <svg viewBox="0 0 24 24" fill="none" class="size-[18px]">
                                <path d="m8 5-5 7 5 7m8-14 5 7-5 7m-3-16-2 18" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </span>
                        <p class="mt-2 text-[11px] font-bold text-ink sm:text-xs">طبّق</p>
                        <p class="mt-1 text-[9px] text-muted sm:text-[10px]">حوّل المعرفة</p>
                    </div>

                    <div class="hero-mini-card rounded-2xl border border-white bg-white/80 px-2 py-3 text-center sm:px-3">
                        <span class="mx-auto grid size-9 place-items-center rounded-xl bg-emerald-50 text-emerald-600">
                            <svg viewBox="0 0 24 24" fill="none" class="size-[18px]">
                                <path d="m12 3 2.8 5.7 6.2.9-4.5 4.4 1.1 6.2-5.6-3-5.6 3 1.1-6.2L3 9.6l6.2-.9L12 3Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/>
                            </svg>
                        </span>
                        <p class="mt-2 text-[11px] font-bold text-ink sm:text-xs">تطوّر</p>
                        <p class="mt-1 text-[9px] text-muted sm:text-[10px]">تقدّم كل يوم</p>
                    </div>
                </div>
            </div>

            <!-- Floating accent -->
            <div class="hero-float-badge absolute -left-2 top-[28%] z-20 hidden items-center gap-3 rounded-2xl border border-white/80 bg-white/95 px-4 py-3 shadow-xl shadow-ink/10 sm:flex lg:-left-5">
                <span class="grid size-10 place-items-center rounded-xl bg-blue/10 text-blue">
                    <svg viewBox="0 0 24 24" fill="none" class="size-5">
                        <path d="m5 12 4 4L19 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </span>
                <span>
                    <span class="block text-xs font-bold text-ink">كل خطوة تفرق</span>
                    <span class="mt-1 block text-[10px] text-muted">تقدّم بطريقتك</span>
                </span>
            </div>

            <div class="hero-float-dot absolute -bottom-3 right-[14%] z-20 size-6 rounded-lg border-4 border-paper bg-blue shadow-lg shadow-blue/20 sm:right-[10%]"></div>
        </div>
    </div>
</section>
