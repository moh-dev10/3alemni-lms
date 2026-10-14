
<?php
defined( 'ABSPATH' ) || exit;
?>

<section
    id="contact-faq"
    class="contact-faq mx-auto mt-20 w-full max-w-4xl px-0 md:mt-28"
    aria-labelledby="contact-faq-title"
>
    <!-- Section Header -->
    <header class="contact-faq__header mb-10 text-center md:mb-12">
        <span
            data-reveal="up"
            class="inline-flex items-center gap-2 rounded-full border border-blue/15 bg-blue/5 px-4 py-2 text-xs font-bold text-blue sm:text-sm"
        >
            <svg
                aria-hidden="true"
                class="size-4"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="1.8"
            >
                <circle cx="12" cy="12" r="9" />
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M9.6 9a2.5 2.5 0 1 1 4.3 1.8c-1.1.8-1.9 1.2-1.9 2.7M12 17h.01"
                />
            </svg>

            <?php esc_html_e( 'الأسئلة الشائعة', '3alemni' ); ?>
        </span>

        <h2
            id="contact-faq-title"
            data-reveal="up"
            style="--reveal-delay: 100ms"
            class="mt-5 text-2xl font-extrabold leading-tight tracking-tight text-ink sm:text-3xl md:text-4xl"
        >
            <?php esc_html_e( 'عندك سؤال؟', '3alemni' ); ?>

            <span class="text-blue">
                <?php esc_html_e( 'الجواب تلقاه هنا.', '3alemni' ); ?>
            </span>
        </h2>

        <p
            data-reveal="up"
            style="--reveal-delay: 200ms"
            class="mx-auto mt-4 max-w-2xl text-sm leading-8 text-muted sm:text-base"
        >
            <?php esc_html_e( 'جمعنالك الأجوبة على أكثر الأسئلة الشائعة باش تلقى المعلومة اللي تحتاجها بسهولة.', '3alemni' ); ?>
        </p>
    </header>

    <?php
    $faq_items = array(
        array(
            'question' => 'كيفاش نقدر نسجّل في دورة؟',
            'answer'   => 'تصفّح الدورات المتوفرة في المنصة، اختار الدورة اللي تناسبك، وادخل لصفحتها باش تشوف التفاصيل وخطوات التسجيل.',
        ),
        array(
            'question' => 'هل نقدر نتعلّم بالوتيرة تاعي؟',
            'answer'   => 'طريقة متابعة الدروس تختلف حسب كل دورة. شوف تفاصيل الدورة باش تعرف كيفاش منظّمين المحتوى والتعلّم فيها.',
        ),
        array(
            'question' => 'نسيت كلمة المرور، واش ندير؟',
            'answer'   => 'ادخل لصفحة تسجيل الدخول واستعمل خيار استرجاع كلمة المرور، ثم اتبع التعليمات الظاهرة لإعادة تعيينها.',
        ),
        array(
            'question' => 'كيفاش نعرف تفاصيل دورة معيّنة؟',
            'answer'   => 'افتح صفحة الدورة باش تطّلع على الوصف والمحتوى والتفاصيل المتوفرة قبل ما تقرّر التسجيل.',
        ),
        array(
            'question' => 'عندي مشكل تقني، كيفاش نتواصل معاكم؟',
            'answer'   => 'عمّر نموذج التواصل الموجود في هذه الصفحة، واشرح المشكل اللي واجهك بوضوح حتى نقدروا نفهموا طلبك.',
        ),
    );
    ?>

    <!-- FAQ Accordion -->
    <div
        class="contact-faq__list divide-y divide-line/70 overflow-hidden rounded-2xl border border-line/80 bg-white shadow-sm sm:rounded-3xl"
        data-faq-accordion
    >
        <?php foreach ( $faq_items as $index => $item ) : ?>
            <?php
            $question_id = 'contact-faq-question-' . ( $index + 1 );
            $answer_id   = 'contact-faq-answer-' . ( $index + 1 );
            ?>

            <article
                data-reveal="up"
                style="--reveal-delay: <?php echo esc_attr( (string) ( $index * 70 ) ); ?>ms"
                class="contact-faq__item px-4 transition-colors duration-300 hover:bg-blue/[0.025] sm:px-6 md:px-8"
            >
                <h3 class="m-0">
                    <button
                        id="<?php echo esc_attr( $question_id ); ?>"
                        type="button"
                        class="contact-faq__trigger flex w-full items-center justify-between gap-4 py-5 text-right text-sm font-bold leading-7 text-ink outline-none transition-colors duration-300 hover:text-blue focus-visible:rounded-lg focus-visible:ring-2 focus-visible:ring-blue/40 focus-visible:ring-offset-4 sm:py-6 sm:text-base"
                        aria-expanded="false"
                        aria-controls="<?php echo esc_attr( $answer_id ); ?>"
                    >
                        <span>
                            <?php echo esc_html( $item['question'] ); ?>
                        </span>

                        <span
                            aria-hidden="true"
                            class="contact-faq__icon flex size-8 shrink-0 items-center justify-center rounded-full border border-line bg-paper text-muted transition-[transform,background-color,border-color,color] duration-300"
                        >
                            <svg
                                class="size-4"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            >
                                <path d="M12 5v14M5 12h14" />
                            </svg>
                        </span>
                    </button>
                </h3>

                <div
                    id="<?php echo esc_attr( $answer_id ); ?>"
                    class="contact-faq__answer"
                    role="region"
                    aria-labelledby="<?php echo esc_attr( $question_id ); ?>"
                    aria-hidden="true"
                    inert
                >
                    <div class="min-h-0 overflow-hidden">
                        <p class="m-0 pb-6 pl-2 text-sm leading-8 text-muted sm:pb-7 sm:text-[15px]">
                            <?php echo esc_html( $item['answer'] ); ?>
                        </p>
                    </div>
                </div>
            </article>
        <?php endforeach; ?>
    </div>

    <!-- Contact CTA -->
    <div
        data-reveal="up"
        class="contact-faq__cta mt-8 flex flex-col items-center justify-between gap-5 rounded-2xl border border-blue/10 bg-blue/[0.035] p-5 text-center sm:flex-row sm:p-7 sm:text-right"
    >
        <div>
            <h3 class="text-base font-extrabold text-ink sm:text-lg">
                <?php esc_html_e( 'ما لقيتش الجواب اللي تحتاجه؟', '3alemni' ); ?>
            </h3>

            <p class="mt-2 text-sm leading-7 text-muted">
                <?php esc_html_e( 'تواصل معانا ونحاولوا نعاونك.', '3alemni' ); ?>
            </p>
        </div>

        <a
            href="#contact-form"
            class="inline-flex min-h-12 shrink-0 items-center justify-center gap-2 rounded-xl bg-blue px-5 py-3 text-sm font-bold text-white shadow-sm shadow-blue/15 transition-[transform,background-color,box-shadow] duration-300 hover:-translate-y-0.5 hover:bg-blue/90 hover:shadow-md focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue focus-visible:ring-offset-2 motion-reduce:transition-none"
        >
            <?php esc_html_e( 'راسلنا الآن', '3alemni' ); ?>

            <svg
                aria-hidden="true"
                class="size-4"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="1.8"
                stroke-linecap="round"
                stroke-linejoin="round"
            >
                <path d="M7 17 17 7M7 7h10v10" />
            </svg>
        </a>
    </div>
</section>
