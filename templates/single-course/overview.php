<?php
/**
 * 3alemni — Single Course Overview Component
 *
 * Displays course benefits ("What you will learn"), long description,
 * requirements/prerequisites, and target audience.
 *
 * @package 3alemni
 * @since 1.0.0
 */

defined( 'ABSPATH' ) || exit;

$course_id = get_the_ID();
if ( ! $course_id ) {
	return;
}

// 1. Benefits / What you will learn
$benefits_raw = get_post_meta( $course_id, '_tutor_course_benefits', true );
$benefits = array();
if ( is_string( $benefits_raw ) && ! empty( trim( $benefits_raw ) ) ) {
	$lines = preg_split( '/\r\n|\r|\n/', trim( $benefits_raw ) );
	foreach ( $lines as $line ) {
		$clean = trim( $line );
		if ( ! empty( $clean ) ) {
			$benefits[] = $clean;
		}
	}
} elseif ( is_array( $benefits_raw ) ) {
	$benefits = array_filter( array_map( 'trim', $benefits_raw ) );
}

// 2. Course Requirements
$requirements_raw = get_post_meta( $course_id, '_tutor_course_requirements', true );
$requirements = array();
if ( is_string( $requirements_raw ) && ! empty( trim( $requirements_raw ) ) ) {
	$lines = preg_split( '/\r\n|\r|\n/', trim( $requirements_raw ) );
	foreach ( $lines as $line ) {
		$clean = trim( $line );
		if ( ! empty( $clean ) ) {
			$requirements[] = $clean;
		}
	}
} elseif ( is_array( $requirements_raw ) ) {
	$requirements = array_filter( array_map( 'trim', $requirements_raw ) );
}

// 3. Target Audience
$audience_raw = get_post_meta( $course_id, '_tutor_course_target_audience', true );
$audience = array();
if ( is_string( $audience_raw ) && ! empty( trim( $audience_raw ) ) ) {
	$lines = preg_split( '/\r\n|\r|\n/', trim( $audience_raw ) );
	foreach ( $lines as $line ) {
		$clean = trim( $line );
		if ( ! empty( $clean ) ) {
			$audience[] = $clean;
		}
	}
} elseif ( is_array( $audience_raw ) ) {
	$audience = array_filter( array_map( 'trim', $audience_raw ) );
}

// 4. Materials Included
$materials_raw = get_post_meta( $course_id, '_tutor_course_material_includes', true );
$materials = array();
if ( is_string( $materials_raw ) && ! empty( trim( $materials_raw ) ) ) {
	$lines = preg_split( '/\r\n|\r|\n/', trim( $materials_raw ) );
	foreach ( $lines as $line ) {
		$clean = trim( $line );
		if ( ! empty( $clean ) ) {
			$materials[] = $clean;
		}
	}
} elseif ( is_array( $materials_raw ) ) {
	$materials = array_filter( array_map( 'trim', $materials_raw ) );
}

// Course content (body)
$content = get_the_content();
?>

<div class="space-y-8 sm:space-y-10">

	<!-- A. What You Will Learn (Benefits) -->
	<?php if ( ! empty( $benefits ) ) : ?>
		<section class="rounded-2xl border border-blue/20 bg-gradient-to-br from-blue/[0.03] to-surface p-5 sm:p-7 shadow-xs" aria-labelledby="learning-outcomes-heading">
			<div class="mb-4 sm:mb-5 flex items-center gap-2.5">
				<div class="grid size-9 place-items-center rounded-xl bg-blue/10 text-blue">
					<svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
						<path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
						<polyline points="22 4 12 14.01 9 11.01"/>
					</svg>
				</div>
				<h2 id="learning-outcomes-heading" class="text-lg sm:text-xl font-bold text-ink">
					<?php esc_html_e( 'ماذا ستتعلّم في هذه الدورة؟', '3alemni' ); ?>
				</h2>
			</div>

			<div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5 sm:gap-4">
				<?php foreach ( $benefits as $benefit ) : ?>
					<div class="flex items-start gap-3 rounded-xl border border-line/60 bg-white p-3.5 transition-colors hover:border-blue/30">
						<svg class="size-5 shrink-0 text-success mt-0.5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
							<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
						</svg>
						<span class="text-sm font-medium leading-relaxed text-ink-secondary">
							<?php echo esc_html( $benefit ); ?>
						</span>
					</div>
				<?php endforeach; ?>
			</div>
		</section>
	<?php endif; ?>

	<!-- B. Course Description -->
	<?php if ( ! empty( trim( $content ) ) ) : ?>
		<section class="rounded-2xl border border-line bg-white p-6 sm:p-8 shadow-xs" aria-labelledby="course-description-heading">
			<div class="mb-5 flex items-center gap-2.5 border-b border-line/60 pb-4">
				<div class="grid size-9 place-items-center rounded-xl bg-paper text-ink-secondary">
					<svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
						<path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1-2.5-2.5Z"/>
						<path d="M6 6h10"/>
						<path d="M6 10h10"/>
					</svg>
				</div>
				<h2 id="course-description-heading" class="text-lg sm:text-xl font-bold text-ink">
					<?php esc_html_e( 'عن الدورة', '3alemni' ); ?>
				</h2>
			</div>

			<div class="prose max-w-none text-sm sm:text-base leading-relaxed text-ink-secondary">
				<?php the_content(); ?>
			</div>
		</section>
	<?php endif; ?>

	<!-- C. Requirements & Target Audience (2 Columns) -->
	<?php if ( ! empty( $requirements ) || ! empty( $audience ) ) : ?>
		<div class="grid grid-cols-1 md:grid-cols-2 gap-6">

			<!-- Requirements -->
			<?php if ( ! empty( $requirements ) ) : ?>
				<section class="rounded-2xl border border-line bg-white p-6 shadow-xs flex flex-col justify-between" aria-labelledby="course-requirements-heading">
					<div>
						<div class="mb-4 flex items-center gap-2.5">
							<div class="grid size-8 place-items-center rounded-lg bg-paper text-ink">
								<svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
									<polyline points="9 11 12 14 22 4"/>
									<path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/>
								</svg>
							</div>
							<h3 id="course-requirements-heading" class="text-base font-bold text-ink">
								<?php esc_html_e( 'المتطلبات الأساسية', '3alemni' ); ?>
							</h3>
						</div>

						<ul class="space-y-2.5 text-sm text-ink-secondary">
							<?php foreach ( $requirements as $req ) : ?>
								<li class="flex items-start gap-2.5">
									<span class="size-1.5 rounded-full bg-blue mt-2 shrink-0" aria-hidden="true"></span>
									<span class="leading-relaxed"><?php echo esc_html( $req ); ?></span>
								</li>
							<?php endforeach; ?>
						</ul>
					</div>
				</section>
			<?php endif; ?>

			<!-- Target Audience -->
			<?php if ( ! empty( $audience ) ) : ?>
				<section class="rounded-2xl border border-line bg-white p-6 shadow-xs flex flex-col justify-between" aria-labelledby="target-audience-heading">
					<div>
						<div class="mb-4 flex items-center gap-2.5">
							<div class="grid size-8 place-items-center rounded-lg bg-paper text-ink">
								<svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
									<path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
									<circle cx="9" cy="7" r="4"/>
									<path d="M22 21v-2a4 4 0 0 0-3-3.87"/>
									<path d="M16 3.13a4 4 0 0 1 0 7.75"/>
								</svg>
							</div>
							<h3 id="target-audience-heading" class="text-base font-bold text-ink">
								<?php esc_html_e( 'الفئة المستهدفة', '3alemni' ); ?>
							</h3>
						</div>

						<ul class="space-y-2.5 text-sm text-ink-secondary">
							<?php foreach ( $audience as $aud ) : ?>
								<li class="flex items-start gap-2.5">
									<span class="size-1.5 rounded-full bg-blue mt-2 shrink-0" aria-hidden="true"></span>
									<span class="leading-relaxed"><?php echo esc_html( $aud ); ?></span>
								</li>
							<?php endforeach; ?>
						</ul>
					</div>
				</section>
			<?php endif; ?>

		</div>
	<?php endif; ?>

	<!-- D. Materials Included -->
	<?php if ( ! empty( $materials ) ) : ?>
		<section class="rounded-2xl border border-line bg-white p-6 shadow-xs" aria-labelledby="course-materials-heading">
			<div class="mb-4 flex items-center gap-2.5">
				<div class="grid size-8 place-items-center rounded-lg bg-paper text-ink">
					<svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
						<path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/>
						<polyline points="3.27 6.96 12 12.01 20.73 6.96"/>
						<line x1="12" y1="22.08" x2="12" y2="12"/>
					</svg>
				</div>
				<h3 id="course-materials-heading" class="text-base font-bold text-ink">
					<?php esc_html_e( 'المواد والملفات المرفقة', '3alemni' ); ?>
				</h3>
			</div>

			<div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm text-ink-secondary">
				<?php foreach ( $materials as $material ) : ?>
					<div class="flex items-center gap-2 rounded-lg bg-paper/60 px-3 py-2 border border-line/40">
						<svg class="size-4 text-blue shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
							<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
							<polyline points="14 2 14 8 20 8"/>
							<line x1="16" y1="13" x2="8" y2="13"/>
							<line x1="16" y1="17" x2="8" y2="17"/>
							<polyline points="10 9 9 9 8 9"/>
						</svg>
						<span class="truncate"><?php echo esc_html( $material ); ?></span>
					</div>
				<?php endforeach; ?>
			</div>
		</section>
	<?php endif; ?>

</div>
