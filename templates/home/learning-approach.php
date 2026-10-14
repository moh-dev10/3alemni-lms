
<?php
defined( 'ABSPATH' ) || exit;
?>

<section
    class="learning-approach relative isolate overflow-hidden border-t border-line/80 bg-paper py-20 sm:py-24 lg:py-28"
    id="approach"
    dir="rtl"
    lang="ar"
>
<div class="approach-blueprint" aria-hidden="true">
    <svg
        class="approach-blueprint__art"
        viewBox="0 0 1440 700"
        fill="none"
        xmlns="http://www.w3.org/2000/svg"
        preserveAspectRatio="xMidYMid slice"
    >
        <defs>
            <linearGradient id="blueprint-glass" x1="0" y1="0" x2="1" y2="1">
                <stop offset="0%" stop-color="#AAB9FF" stop-opacity=".42" />
                <stop offset="100%" stop-color="#244EE8" stop-opacity=".06" />
            </linearGradient>

            <linearGradient id="blueprint-page" x1="0" y1="0" x2="1" y2="1">
                <stop offset="0%" stop-color="#FFFFFF" stop-opacity=".82" />
                <stop offset="100%" stop-color="#DDE4FF" stop-opacity=".32" />
            </linearGradient>
        </defs>

        <!-- Abstract open-book / learning-path geometry -->
        <g class="blueprint-book" stroke="#244EE8" stroke-width="1.2">
            <path
                d="M950 185 L1088 135 L1225 184 L1225 370 L1088 322 L950 370 Z"
                fill="url(#blueprint-page)"
                stroke-opacity=".30"
            />
            <path d="M1088 135 V322" stroke-opacity=".42" />
            <path d="M975 211 L1063 179 M975 235 L1063 203 M975 259 L1045 234"
                stroke-opacity=".28" />
            <path d="M1112 180 L1198 211 M1112 205 L1198 236 M1112 230 L1180 254"
                stroke-opacity=".28" />
            <path d="M950 370 L1088 322 L1225 370"
                stroke-opacity=".18" />
        </g>

        <!-- Architectural construction lines -->
        <g stroke="#244EE8" stroke-width="1" stroke-opacity=".16">
            <path d="M890 110 H1280" />
            <path d="M890 110 V405" />
            <path d="M1280 110 V405" />
            <path d="M910 425 H1260" />
            <path d="M930 95 V125 M970 95 V125 M1010 95 V125 M1050 95 V125 M1090 95 V125 M1130 95 V125 M1170 95 V125 M1210 95 V125 M1250 95 V125" />
            <path d="M875 150 H905 M875 190 H905 M875 230 H905 M875 270 H905 M875 310 H905 M875 350 H905" />
        </g>

        <!-- Translucent geometric planes -->
        <path
            d="M1150 420 L1295 335 L1400 395 L1255 480 Z"
            fill="url(#blueprint-glass)"
        />
        <path
            d="M1255 480 L1400 395 V440 L1255 525 Z"
            fill="#244EE8"
            fill-opacity=".06"
        />
        <path
            d="M1150 420 L1255 480 V525 L1150 465 Z"
            fill="#FFFFFF"
            fill-opacity=".52"
        />

        <!-- Fine learning route -->
        <g stroke="#244EE8" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round">
            <path
                d="M835 465 H920 Q945 465 945 440 V420 Q945 395 970 395 H1000"
                stroke-opacity=".36"
                stroke-dasharray="4 7"
            />
            <circle cx="835" cy="465" r="4" fill="#244EE8" fill-opacity=".18" stroke-opacity=".45" />
            <circle cx="1000" cy="395" r="5" fill="#244EE8" fill-opacity=".16" stroke-opacity=".45" />
        </g>

        <!-- Edge framing -->
        <g stroke="#244EE8" stroke-width="1.2" stroke-opacity=".22">
            <path d="M1340 170 H1370 V200" />
            <path d="M890 500 V530 H920" />
            <path d="M1320 500 H1350 V470" />
        </g>
    </svg>
</div>
    <div class="learning-approach__glow" aria-hidden="true"></div>

    <div class="relative mx-auto w-full max-w-[1240px] px-[clamp(20px,5vw,72px)]">

        <div class="approach-heading mb-12 max-w-2xl sm:mb-16">
            <p class="mb-4 flex items-center gap-3 text-sm font-semibold text-blue">
                <span class="h-px w-8 bg-blue" aria-hidden="true"></span>
                طريقة بسيطة، هدف واضح
            </p>

            <h2 class="text-4xl font-semibold leading-[1.4] tracking-normal text-ink sm:text-5xl lg:text-6xl">
                ماشي غير تتفرّج.
                <br>
                <span class="text-muted">تعلّم وتقدّم.</span>
            </h2>

            <p class="mt-5 max-w-xl text-base leading-8 text-muted sm:text-lg">
                تعلّم بطريقة تخليك تفهم، تطبّق، وتبني مهارات تقدر تستعملها.
            </p>
        </div>

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3 lg:gap-5">

            <?php
            $approach_steps = [
                [
                    'number' => '01',
                    'label'  => 'افهم',
                    'title'  => 'ابدأ بالأساسيات',
                    'text'   => 'كوّن فهم واضح قبل ما تنتقل للمفاهيم الأكثر تقدّمًا.',
                    'icon'   => 'M12 6.5V19M12 6.5C10.5 5.5 8.5 5 5 5v12c3.5 0 5.5.5 7 2m0-12.5C13.5 5.5 15.5 5 19 5v12c-3.5 0-5.5.5-7 2',
                ],
                [
                    'number' => '02',
                    'label'  => 'طبّق',
                    'title'  => 'حوّل المعرفة إلى عمل',
                    'text'   => 'خصّص وقتًا للتطبيق، وراجع واش قدرت تنجز وحدك.',
                    'icon'   => 'M8 12.5l2.5 2.5L16.5 9M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z',
                ],
                [
                    'number' => '03',
                    'label'  => 'واصل',
                    'title'  => 'ابنِ على تقدّمك',
                    'text'   => 'واصل التعلّم خطوة بخطوة، حسب هدفك والوقت المتاح ليك.',
                    'icon'   => 'M12 3v3m0 12v3M3 12h3m12 0h3M5.64 5.64l2.12 2.12m8.48 8.48 2.12 2.12m0-12.72-2.12 2.12m-8.48 8.48-2.12 2.12M16 12a4 4 0 1 1-8 0 4 4 0 0 1 8 0Z',
                ],
            ];
            ?>

            <?php foreach ( $approach_steps as $step ) : ?>
                <article class="approach-card group relative flex min-h-[270px] flex-col overflow-hidden rounded-2xl border border-line bg-white p-6 sm:p-8">

<span
    class="approach-card__number pointer-events-none absolute left-0 top-3 select-none text-7xl font-semibold leading-none text-gray-300! sm:top-5 sm:text-8xl"
    aria-hidden="true"
>
    <?php echo esc_html( $step['number'] ); ?>
</span>

                    <div class="relative mb-10 flex items-center justify-between gap-4">
                        <span class="text-xs font-semibold tracking-wide text-muted">
                            <?php echo esc_html( $step['number'] . ' — ' . $step['label'] ); ?>
                        </span>


                    </div>

                    <div class="relative mt-auto">
                        <h3 class="text-xl font-semibold leading-8 text-ink sm:text-2xl">
                            <?php echo esc_html( $step['title'] ); ?>
                        </h3>

                        <p class="mt-3 max-w-sm text-sm leading-7 text-muted">
                            <?php echo esc_html( $step['text'] ); ?>
                        </p>
                    </div>

                    <span class="approach-card__accent absolute inset-x-8 bottom-0 h-[2px] origin-right scale-x-0 bg-blue"></span>
                </article>
            <?php endforeach; ?>

        </div>
    </div>
</section>
