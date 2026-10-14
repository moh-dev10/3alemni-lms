<?php
defined( 'ABSPATH' ) || exit;
?>

<!-- Contact Form -->
<section
    data-reveal="left"
    style="--reveal-delay: 150ms"
    aria-labelledby="contact-form-title"
    class="contact-form-card rounded-3xl border border-line/80 bg-white p-5 shadow-sm transition-[border-color,box-shadow] duration-300 hover:border-blue/20 hover:shadow-xl hover:shadow-blue/5 sm:p-8 lg:col-span-7"
>
    <!-- Form Header -->
    <div class="mb-8 border-b border-line/70 pb-6">
        <div class="mb-4 inline-flex size-11 items-center justify-center rounded-2xl border border-blue/10 bg-blue/5 text-blue">
            <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5Z"/>
            </svg>
        </div>

        <h2 id="contact-form-title" class="text-xl font-extrabold tracking-tight text-ink sm:text-2xl">
            <?php esc_html_e( 'خلّينا نسمعوا منك', '3alemni' ); ?>
        </h2>

        <p class="mt-2 text-sm leading-7 text-muted">
            <?php esc_html_e( 'عمّر المعلومات التالية وابعثلنا رسالتك، وفريقنا يراجع استفسارك.', '3alemni' ); ?>
        </p>

        <p class="mt-4 text-xs text-muted">
            <span class="font-bold text-red-500">*</span>
            <?php esc_html_e( 'الخانات المطلوبة', '3alemni' ); ?>
        </p>
    </div>

    <form action="#" method="POST" class="flex flex-col gap-6">

        <!-- Name & Email -->
        <div class="grid gap-5 sm:grid-cols-2">

            <div class="min-w-0">
                <label for="contact-name" class="block text-sm font-bold text-ink">
                    <?php esc_html_e( 'الاسم الكامل', '3alemni' ); ?>
                    <span class="text-red-500" aria-hidden="true">*</span>
                </label>

                <input
                    type="text"
                    id="contact-name"
                    name="contact_name"
                    autocomplete="name"
                    required
                    maxlength="100"
                    placeholder="<?php esc_attr_e( 'مثال: محمد حدو', '3alemni' ); ?>"
                    class="mt-2.5 min-h-12 w-full rounded-xl border border-line bg-paper/50 px-4 py-3 text-sm text-ink outline-none transition-[border-color,background-color,box-shadow] duration-200 placeholder:text-muted/70 hover:border-blue/30 focus:border-blue focus:bg-white focus:ring-4 focus:ring-blue/10"
                >
            </div>

            <div class="min-w-0">
                <label for="contact-email" class="block text-sm font-bold text-ink">
                    <?php esc_html_e( 'البريد الإلكتروني', '3alemni' ); ?>
                    <span class="text-red-500" aria-hidden="true">*</span>
                </label>

                <input
                    type="email"
                    id="contact-email"
                    name="contact_email"
                    autocomplete="email"
                    inputmode="email"
                    dir="ltr"
                    required
                    maxlength="254"
                    placeholder="name@example.com"
                    class="mt-2.5 min-h-12 w-full rounded-xl border border-line bg-paper/50 px-4 py-3 text-left text-sm text-ink outline-none transition-[border-color,background-color,box-shadow] duration-200 placeholder:text-muted/70 hover:border-blue/30 focus:border-blue focus:bg-white focus:ring-4 focus:ring-blue/10"
                >
            </div>

        </div>

        <!-- Subject -->
        <div>
            <label for="contact-subject" class="block text-sm font-bold text-ink">
                <?php esc_html_e( 'موضوع الرسالة', '3alemni' ); ?>
            </label>

            <div class="relative mt-2.5">
                <select
                    id="contact-subject"
                    name="contact_subject"
                    class="min-h-12 w-full appearance-none rounded-xl border border-line bg-paper/50 px-4 py-3 pe-11 text-sm text-ink outline-none transition-[border-color,background-color,box-shadow] duration-200 hover:border-blue/30 focus:border-blue focus:bg-white focus:ring-4 focus:ring-blue/10"
                >
                    <option value="general">
                        <?php esc_html_e( 'استفسار عام', '3alemni' ); ?>
                    </option>

                    <option value="course">
                        <?php esc_html_e( 'سؤال حول دورة معينة', '3alemni' ); ?>
                    </option>

                    <option value="instructor">
                        <?php esc_html_e( 'حاب نولي أستاذ في المنصة', '3alemni' ); ?>
                    </option>

                    <option value="technical">
                        <?php esc_html_e( 'مشكلة تقنية', '3alemni' ); ?>
                    </option>
                </select>

                <svg class="pointer-events-none absolute left-4 top-1/2 size-4 -translate-y-1/2 text-muted" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m7 10 5 5 5-5"/>
                </svg>
            </div>
        </div>

        <!-- Message -->
        <div>
            <label for="contact-message" class="block text-sm font-bold text-ink">
                <?php esc_html_e( 'الرسالة تاعك', '3alemni' ); ?>
                <span class="text-red-500" aria-hidden="true">*</span>
            </label>

            <textarea
                id="contact-message"
                name="contact_message"
                rows="5"
                required
                minlength="10"
                maxlength="5000"
                placeholder="<?php esc_attr_e( 'اكتب الرسالة تاعك هنا...', '3alemni' ); ?>"
                class="mt-2.5 min-h-36 w-full resize-y rounded-xl border border-line bg-paper/50 px-4 py-3.5 text-sm leading-7 text-ink outline-none transition-[border-color,background-color,box-shadow] duration-200 placeholder:text-muted/70 hover:border-blue/30 focus:border-blue focus:bg-white focus:ring-4 focus:ring-blue/10"
            ></textarea>

            <p class="mt-2 text-xs leading-5 text-muted">
                <?php esc_html_e( 'اشرحلنا استفسارك بالتفصيل باش نقدروا نعاونك.', '3alemni' ); ?>
            </p>
        </div>

        <!-- Submit -->
        <div class="border-t border-line/70 pt-5">
            <button
                type="submit"
                class="group inline-flex min-h-12 w-full items-center justify-center gap-2.5 rounded-xl bg-blue px-6 py-3.5 text-sm font-bold text-white shadow-sm shadow-blue/15 transition-[transform,background-color,box-shadow] duration-300 hover:-translate-y-0.5 hover:bg-blue-dark hover:shadow-lg hover:shadow-blue/20 focus-visible:outline-none focus-visible:ring-4 focus-visible:ring-blue/25 focus-visible:ring-offset-2 active:translate-y-0 motion-reduce:transform-none motion-reduce:transition-none"
            >
                <span>
                    <?php esc_html_e( 'أبعث الرسالة', '3alemni' ); ?>
                </span>

                <svg class="size-4 transition-transform duration-300 group-hover:-translate-x-1 motion-reduce:transform-none" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 12H5m7 7-7-7 7-7"/>
                </svg>
            </button>

            <p class="mt-3 text-center text-xs leading-6 text-muted">
                <?php esc_html_e( 'معلوماتك تُستعمل للرد على رسالتك فقط.', '3alemni' ); ?>
            </p>
        </div>

    </form>
</section>