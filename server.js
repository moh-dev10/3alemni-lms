/**
 * 3alemni Dev Server for AI Studio
 * - Listens on port 3000
 * - Serves compiled assets (CSS, Fonts, JS, Images)
 * - Renders Phase 2: Premium Student Dashboard (with live preview & empty state toggle)
 * - Renders Phase 1: Design System & Component Foundation preview (/tokens)
 * - Runs the Tailwind CSS v4 compiler/watcher
 */

const http = require('node:http');
const fs = require('node:fs');
const path = require('node:path');
const { spawn } = require('node:child_process');

const PORT = process.env.PORT || 3000;
const ROOT_DIR = __dirname;

// MIME types mapping
const MIME_TYPES = {
  '.html': 'text/html; charset=utf-8',
  '.css': 'text/css; charset=utf-8',
  '.js': 'application/javascript; charset=utf-8',
  '.json': 'application/json; charset=utf-8',
  '.woff2': 'font/woff2',
  '.woff': 'font/woff',
  '.ttf': 'font/ttf',
  '.svg': 'image/svg+xml',
  '.png': 'image/png',
  '.jpg': 'image/jpeg',
  '.jpeg': 'image/jpeg',
  '.webp': 'image/webp',
  '.ico': 'image/x-icon',
};

// Spawn Tailwind v4 watcher in background
const tailwindProcess = spawn(
  'npx',
  ['@tailwindcss/cli', '-i', './assets/css/src.css', '-o', './assets/css/main.css', '--watch'],
  { cwd: ROOT_DIR, stdio: 'inherit' }
);

tailwindProcess.on('error', (err) => {
  console.error('[Tailwind Watcher Error]:', err);
});

// Render the Phase 2 Premium Student Dashboard
function getStudentDashboardHtml(isEmptyState = false) {
  return `<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>3alemni LMS — لوحة تحكّم المتعلّم (Student Dashboard)</title>
  <link rel="stylesheet" href="/assets/css/main.css">
</head>
<body class="bg-paper text-ink min-h-screen font-sans selection:bg-blue/10 selection:text-blue">

  <!-- Dev View Switcher Banner -->
  <div class="bg-white border-b border-line px-4 py-2 flex flex-wrap items-center justify-between text-xs gap-3">
    <div class="flex items-center gap-2">
      <span class="badge badge-primary">المرحلة 2: لوحة المتعلّم</span>
      <span class="text-muted hidden sm:inline">معاينة واجهة المتعلّم الحية مبنية برموز التصميم 3alemni</span>
    </div>
    <div class="flex items-center gap-2">
      <span class="text-muted font-medium">حالة البيانات:</span>
      <a href="/dashboard" class="btn btn-sm ${!isEmptyState ? 'btn-primary' : 'btn-secondary'} py-1 px-3">
        طالب مسجّل (بيانات فعلية)
      </a>
      <a href="/dashboard?state=empty" class="btn btn-sm ${isEmptyState ? 'btn-primary' : 'btn-secondary'} py-1 px-3">
        طالب جديد (حالة فارغة)
      </a>
      <span class="text-line mx-1">|</span>
      <a href="/tokens" class="text-blue hover:text-blue-dark font-semibold">
        لوحة الرموز (المرحلة 1) &rarr;
      </a>
    </div>
  </div>

  <div class="alemni-dashboard flex min-h-[calc(100vh-41px)] w-full">

    <!-- A. APPLICATION SIDEBAR -->
    <aside id="dashboard-sidebar" class="w-64 shrink-0 bg-white border-l border-line p-5 flex flex-col justify-between hidden md:flex min-h-full">
      <div class="space-y-6">
        <!-- Logo -->
        <a href="/" class="flex items-center gap-3 no-underline group">
          <span class="grid size-10 place-items-center rounded-xl bg-blue text-lg font-bold text-white shadow-subtle group-hover:scale-105 transition">ع</span>
          <div>
            <span class="text-lg font-bold leading-tight block text-ink">3alemni</span>
            <span class="text-[11px] text-muted block">منصة التعلّم الذكي</span>
          </div>
        </a>

        <!-- Navigation Menu -->
        <nav class="space-y-1">
          <p class="text-[11px] font-bold uppercase tracking-wider text-muted px-3 py-1 mb-1">
            القائمة الرئيسية
          </p>
          <a href="/dashboard" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-semibold transition bg-blue-subtle text-blue border border-blue/20">
            <svg class="size-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            <span>نظرة عامة</span>
            <span class="size-1.5 rounded-full bg-blue mr-auto"></span>
          </a>
          <a href="/dashboard/my-courses" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-ink-secondary hover:bg-paper-subtle hover:text-blue transition">
            <svg class="size-4.5 text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
            <span>دوراتي التعليمية</span>
          </a>
          <a href="/dashboard/enrolled-courses" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-ink-secondary hover:bg-paper-subtle hover:text-blue transition">
            <svg class="size-4.5 text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span>الدورات المسجلة</span>
          </a>
          <a href="/dashboard/wishlist" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-ink-secondary hover:bg-paper-subtle hover:text-blue transition">
            <svg class="size-4.5 text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
            <span>قائمة الرغبات</span>
          </a>
          <a href="/dashboard/settings" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-ink-secondary hover:bg-paper-subtle hover:text-blue transition">
            <svg class="size-4.5 text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            <span>الإعدادات</span>
          </a>
        </nav>
      </div>

      <!-- Sidebar Explore Card -->
      <div class="card-subtle bg-paper-subtle border border-line p-4 rounded-xl space-y-3">
        <span class="text-[10px] font-bold text-blue uppercase tracking-wider block">استكشف المزيد</span>
        <p class="text-xs font-semibold text-ink leading-relaxed">
          اكتشف مسارات جديدة تناسب سوق العمل في الجزائر.
        </p>
        <a href="/courses" class="btn btn-secondary btn-sm w-full justify-between">
          <span>دليل الدورات</span>
          <span class="rtl:rotate-180">&rarr;</span>
        </a>
      </div>
    </aside>

    <!-- MAIN CONTENT AREA -->
    <div class="flex-1 flex flex-col min-w-0">

      <!-- B. TOP HEADER -->
      <header class="bg-white border-b border-line px-5 sm:px-8 py-3.5 flex items-center justify-between sticky top-0 z-30 shadow-xs">
        <div class="flex items-center gap-3">
          <!-- Mobile Sidebar Toggle -->
          <button
            onclick="document.getElementById('dashboard-sidebar').classList.toggle('hidden')"
            type="button"
            class="md:hidden flex items-center justify-center size-9 rounded-lg border border-line bg-paper-subtle text-ink hover:bg-paper transition"
            aria-label="تبديل القائمة"
          >
            <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
          </button>

          <!-- Breadcrumb Context -->
          <div class="flex items-center gap-2 text-xs text-muted">
            <span class="font-medium">لوحة المتعلّم</span>
            <span class="text-line-strong">/</span>
            <span class="text-ink font-semibold">نظرة عامة</span>
          </div>
        </div>

        <!-- Student Profile / Actions -->
        <div class="flex items-center gap-3">
          <div class="flex items-center gap-2.5 p-1.5 pr-2.5 rounded-lg border border-line bg-white shadow-subtle hover:border-line-strong transition cursor-pointer">
            <span class="grid size-8 place-items-center rounded-lg bg-blue-subtle text-blue font-bold text-xs">
              م ع
            </span>
            <div class="hidden sm:block text-right">
              <strong class="text-xs font-bold text-ink block leading-tight">محمد الأمين</strong>
              <span class="text-[10px] text-muted block leading-none">متعلّم</span>
            </div>
            <svg class="size-3.5 text-muted mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
          </div>
        </div>
      </header>

      <!-- DASHBOARD BODY CONTAINER -->
      <main class="flex-1 p-5 sm:p-8 space-y-8 max-w-[1300px] w-full mx-auto">

        <!-- C. WELCOME SECTION -->
        <section class="card-base bg-white border border-line p-6 sm:p-8 rounded-xl relative overflow-hidden shadow-subtle">
          <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="space-y-2 max-w-2xl">
              <div class="flex items-center gap-2">
                <span class="badge badge-primary">مساحة المتعلّم</span>
                <span class="text-xs text-muted">السبت، 7 نوفمبر 2026</span>
              </div>
              <h1 class="text-2xl sm:text-3xl font-bold text-ink tracking-tight flex items-center gap-2">
                <span>مرحباً بك،</span>
                <span class="text-blue">محمد الأمين</span>
                <span class="text-xl" aria-hidden="true">👋</span>
              </h1>
              <p class="text-sm text-ink-secondary leading-relaxed">
                ${!isEmptyState
                  ? 'لديك 2 دورات قيد التعلّم. واصل التقدّم واكتسب مهارات عملية جديدة اليوم.'
                  : 'أهلاً بك في منصة علّمني. ابدأ رحلتك التعليمية اليوم باختيار أول مساق يناسب طموحاتك.'}
              </p>
            </div>
            <div class="flex items-center gap-3 shrink-0">
              ${!isEmptyState ? `
                <a href="#continue-section" class="btn btn-primary btn-md shadow-subtle">
                  <span>متابعة آخر درس</span>
                  <svg class="size-4 rtl:rotate-180" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                </a>
              ` : `
                <a href="/courses" class="btn btn-primary btn-md shadow-subtle">
                  <span>استكشاف الدورات</span>
                  <svg class="size-4 rtl:rotate-180" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                </a>
              `}
              <a href="/dashboard/enrolled-courses" class="btn btn-secondary btn-md">
                سجل الدورات
              </a>
            </div>
          </div>
        </section>

        <!-- D. LEARNING OVERVIEW (METRICS) -->
        <section class="grid grid-cols-2 sm:grid-cols-4 gap-4">
          <div class="card-base bg-white border border-line p-5 rounded-xl shadow-subtle">
            <div class="flex items-center justify-between mb-3">
              <span class="text-xs font-semibold uppercase tracking-wider text-muted">الدورات المسجلة</span>
              <span class="grid size-8 place-items-center rounded-lg bg-blue-subtle text-blue text-sm">📚</span>
            </div>
            <div class="flex items-baseline gap-2">
              <span class="text-2xl sm:text-3xl font-bold text-ink tabular-nums">${!isEmptyState ? '3' : '0'}</span>
              <span class="text-xs text-muted">دورات</span>
            </div>
          </div>

          <div class="card-base bg-white border border-line p-5 rounded-xl shadow-subtle">
            <div class="flex items-center justify-between mb-3">
              <span class="text-xs font-semibold uppercase tracking-wider text-muted">قيد التعلّم</span>
              <span class="grid size-8 place-items-center rounded-lg bg-warning-subtle text-warning text-sm">⏳</span>
            </div>
            <div class="flex items-baseline gap-2">
              <span class="text-2xl sm:text-3xl font-bold text-ink tabular-nums">${!isEmptyState ? '2' : '0'}</span>
              <span class="text-xs text-muted">دورات جارية</span>
            </div>
          </div>

          <div class="card-base bg-white border border-line p-5 rounded-xl shadow-subtle">
            <div class="flex items-center justify-between mb-3">
              <span class="text-xs font-semibold uppercase tracking-wider text-muted">الدورات المكتملة</span>
              <span class="grid size-8 place-items-center rounded-lg bg-success-subtle text-success text-sm">✓</span>
            </div>
            <div class="flex items-baseline gap-2">
              <span class="text-2xl sm:text-3xl font-bold text-ink tabular-nums">${!isEmptyState ? '1' : '0'}</span>
              <span class="text-xs text-muted">شهادات جاهزة</span>
            </div>
          </div>

          <div class="card-base bg-white border border-line p-5 rounded-xl shadow-subtle">
            <div class="flex items-center justify-between mb-3">
              <span class="text-xs font-semibold uppercase tracking-wider text-muted">معدل الإنجاز</span>
              <span class="grid size-8 place-items-center rounded-lg bg-blue-light text-blue text-sm">🎯</span>
            </div>
            <div class="flex items-baseline gap-2">
              <span class="text-2xl sm:text-3xl font-bold text-ink tabular-nums">${!isEmptyState ? '33%' : '0%'}</span>
              <span class="text-xs text-muted">إجمالي المسارات</span>
            </div>
          </div>
        </section>

        <!-- E. CONTINUE LEARNING HERO SECTION -->
        ${!isEmptyState ? `
        <section id="continue-section" class="space-y-4">
          <div class="flex items-center justify-between">
            <div class="flex items-center gap-2">
              <h2 class="text-lg sm:text-xl font-bold text-ink">متابعة التعلّم</h2>
              <span class="badge badge-primary">65% منجز</span>
            </div>
            <a href="/courses/full-stack-web" class="text-xs font-semibold text-blue hover:text-blue-dark transition">
              تفاصيل الدورة &larr;
            </a>
          </div>

          <div class="card-base bg-white border border-line rounded-xl p-6 shadow-card hover:border-line-strong transition">
            <div class="flex flex-col md:flex-row gap-6 items-start">
              <div class="w-full md:w-56 shrink-0 aspect-video md:aspect-[4/3] rounded-lg overflow-hidden bg-paper-subtle border border-line relative">
                <div class="w-full h-full bg-gradient-to-br from-blue/10 to-blue/5 flex flex-col items-center justify-center p-4 text-center">
                  <span class="text-3xl mb-1">💻</span>
                  <strong class="text-xs font-bold text-ink">تطوير الويب المتكامل</strong>
                </div>
              </div>

              <div class="flex-1 space-y-4 min-w-0 w-full">
                <div class="space-y-1.5">
                  <div class="flex items-center gap-2">
                    <span class="text-xs text-muted">المدرّب: <strong class="text-ink">م. كريم بلقاسم</strong></span>
                    <span class="badge badge-primary text-[11px]">قيد التقدّم</span>
                  </div>
                  <h3 class="text-xl font-bold text-ink hover:text-blue transition line-clamp-2">
                    مسار تطوير تطبيقات الويب الكاملة باستخدام React و Node.js
                  </h3>
                </div>

                <div class="p-3 bg-paper-subtle rounded-lg border border-line-subtle flex items-center justify-between gap-3 text-xs">
                  <div class="flex items-center gap-2 text-ink">
                    <span class="size-2 rounded-full bg-blue shrink-0"></span>
                    <span class="text-muted">الدرس التالي:</span>
                    <strong class="truncate max-w-xs sm:max-w-md">بناء وتأمين واجهات برمجة التطبيقات REST API مع المصادقة</strong>
                  </div>
                  <span class="text-muted shrink-0">18 دقيقة</span>
                </div>

                <div class="space-y-1.5">
                  <div class="flex items-center justify-between text-xs text-muted">
                    <span>نسبة الإنجاز</span>
                    <strong class="text-ink tabular-nums">65% (13 من 20 درساً)</strong>
                  </div>
                  <div class="w-full h-2.5 bg-paper rounded-full overflow-hidden border border-line-subtle">
                    <div class="h-full bg-blue rounded-full transition-all duration-500" style="width: 65%;"></div>
                  </div>
                </div>

                <div class="pt-2 flex items-center gap-3">
                  <a href="/lessons/lesson-14" class="btn btn-primary btn-md shadow-subtle">
                    <span>متابعة الدورة الآن</span>
                    <svg class="size-4 rtl:rotate-180" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                  </a>
                  <a href="/courses/full-stack-web" class="btn btn-ghost btn-md text-muted hover:text-ink">
                    فهرس الدروس
                  </a>
                </div>
              </div>
            </div>
          </div>
        </section>
        ` : ''}

        <!-- F. MY COURSES SECTION -->
        <section class="space-y-5">
          <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
              <h2 class="text-lg sm:text-xl font-bold text-ink">دوراتي التعليمية</h2>
              <span class="badge badge-neutral text-xs">${!isEmptyState ? '3' : '0'}</span>
            </div>
            <a href="/courses" class="btn btn-secondary btn-sm">
              <span>استعراض المزيد من الدورات</span>
            </a>
          </div>

          ${!isEmptyState ? `
          <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Course Card 1 -->
            <article class="card-base bg-white border border-line rounded-xl overflow-hidden shadow-subtle hover:shadow-card hover:-translate-y-0.5 transition flex flex-col h-full">
              <div class="aspect-video w-full bg-paper-subtle overflow-hidden relative border-b border-line flex items-center justify-center">
                <span class="text-3xl">💻</span>
                <span class="absolute top-3 left-3 badge badge-primary shadow-xs">65%</span>
              </div>
              <div class="p-5 flex-1 flex flex-col justify-between space-y-4">
                <div class="space-y-1.5">
                  <span class="text-xs text-muted block">م. كريم بلقاسم</span>
                  <h3 class="text-base font-bold text-ink leading-snug line-clamp-2">
                    تطوير تطبيقات الويب الكاملة باستخدام React و Node.js
                  </h3>
                </div>
                <div class="space-y-1.5 pt-2 border-t border-line-subtle">
                  <div class="flex items-center justify-between text-xs text-muted">
                    <span>التقدّم</span>
                    <span class="font-semibold text-ink tabular-nums">65%</span>
                  </div>
                  <div class="w-full h-1.5 bg-paper rounded-full overflow-hidden">
                    <div class="h-full bg-blue rounded-full" style="width: 65%;"></div>
                  </div>
                </div>
                <div class="pt-1">
                  <a href="/lessons/lesson-14" class="btn btn-secondary btn-sm w-full justify-between">
                    <span>متابعة التعلّم</span>
                    <span class="text-blue rtl:rotate-180">&rarr;</span>
                  </a>
                </div>
              </div>
            </article>

            <!-- Course Card 2 -->
            <article class="card-base bg-white border border-line rounded-xl overflow-hidden shadow-subtle hover:shadow-card hover:-translate-y-0.5 transition flex flex-col h-full">
              <div class="aspect-video w-full bg-paper-subtle overflow-hidden relative border-b border-line flex items-center justify-center">
                <span class="text-3xl">🎨</span>
                <span class="absolute top-3 left-3 badge badge-primary shadow-xs">30%</span>
              </div>
              <div class="p-5 flex-1 flex flex-col justify-between space-y-4">
                <div class="space-y-1.5">
                  <span class="text-xs text-muted block">أ. سارة بن ناصر</span>
                  <h3 class="text-base font-bold text-ink leading-snug line-clamp-2">
                    تصميم واجهات وتجربة المستخدم الحديثة (UI/UX Design)
                  </h3>
                </div>
                <div class="space-y-1.5 pt-2 border-t border-line-subtle">
                  <div class="flex items-center justify-between text-xs text-muted">
                    <span>التقدّم</span>
                    <span class="font-semibold text-ink tabular-nums">30%</span>
                  </div>
                  <div class="w-full h-1.5 bg-paper rounded-full overflow-hidden">
                    <div class="h-full bg-blue rounded-full" style="width: 30%;"></div>
                  </div>
                </div>
                <div class="pt-1">
                  <a href="/lessons/ui-ux-3" class="btn btn-secondary btn-sm w-full justify-between">
                    <span>متابعة التعلّم</span>
                    <span class="text-blue rtl:rotate-180">&rarr;</span>
                  </a>
                </div>
              </div>
            </article>

            <!-- Course Card 3 (Completed) -->
            <article class="card-base bg-white border border-line rounded-xl overflow-hidden shadow-subtle hover:shadow-card hover:-translate-y-0.5 transition flex flex-col h-full">
              <div class="aspect-video w-full bg-paper-subtle overflow-hidden relative border-b border-line flex items-center justify-center">
                <span class="text-3xl">⚡</span>
                <span class="absolute top-3 left-3 badge badge-success shadow-xs">مكتملة 100%</span>
              </div>
              <div class="p-5 flex-1 flex flex-col justify-between space-y-4">
                <div class="space-y-1.5">
                  <span class="text-xs text-muted block">م. مهدي عمور</span>
                  <h3 class="text-base font-bold text-ink leading-snug line-clamp-2">
                    الأساسيات البرمجية وهياكل البيانات الحديثة
                  </h3>
                </div>
                <div class="space-y-1.5 pt-2 border-t border-line-subtle">
                  <div class="flex items-center justify-between text-xs text-muted">
                    <span>الشهادة</span>
                    <span class="font-semibold text-success tabular-nums">معتمدة ✓</span>
                  </div>
                  <div class="w-full h-1.5 bg-paper rounded-full overflow-hidden">
                    <div class="h-full bg-success rounded-full" style="width: 100%;"></div>
                  </div>
                </div>
                <div class="pt-1">
                  <a href="/courses/cs-fundamentals" class="btn btn-secondary btn-sm w-full justify-between">
                    <span>مراجعة المحتوى</span>
                    <span class="text-blue rtl:rotate-180">&rarr;</span>
                  </a>
                </div>
              </div>
            </article>
          </div>
          ` : `
          <!-- 5. EMPTY STATE: NO ENROLLED COURSES -->
          <div class="card-base bg-white border border-line rounded-xl p-8 sm:p-14 text-center space-y-4 max-w-lg mx-auto shadow-subtle">
            <div class="grid size-14 place-items-center rounded-2xl bg-paper mx-auto text-2xl border border-line">
              🎓
            </div>
            <div class="space-y-1.5">
              <h3 class="text-lg font-bold text-ink">لم تقم بالتسجيل في أي دورة بعد</h3>
              <p class="text-xs text-muted leading-relaxed">
                استكشف مساراتنا المتاحة في التكنولوجيا، البرمجة، والتصميم وابدأ في بناء مهاراتك المستقبلية الآن.
              </p>
            </div>
            <div class="pt-2">
              <a href="/courses" class="btn btn-primary btn-md shadow-subtle inline-flex">
                تصفح دليل الدورات المتاحة
              </a>
            </div>
          </div>
          `}
        </section>

      </main>

      <!-- Global Dashboard Footer -->
      <footer class="border-t border-line bg-white/70 mt-auto">
        <div class="px-5 sm:px-8 py-5 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-muted">
          <div class="flex items-center gap-3">
            <strong class="text-ink">3alemni LMS</strong>
            <span>&copy; 2026 علّمني. منصة التعليم الرقمي للجمهور الجزائري.</span>
          </div>
          <div class="flex items-center gap-4">
            <span class="badge badge-success text-[11px]">المرحلة 2 مكتملة</span>
            <span class="text-line">•</span>
            <span>Tutor LMS Student Workspace</span>
          </div>
        </div>
      </footer>

    </div>
  </div>

</body>
</html>`;
}

// Render the Phase 1 Design Foundation Tokens Page
function getTokensHtml() {
  return `<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>3alemni LMS — Phase 1 Design Foundation</title>
  <link rel="stylesheet" href="/assets/css/main.css">
  <style>
    .token-swatch {
      display: flex;
      flex-direction: column;
      border-radius: var(--radius-md);
      overflow: hidden;
      border: 1px solid var(--color-line);
      background: #ffffff;
      box-shadow: var(--shadow-subtle);
    }
    .token-swatch__color {
      height: 64px;
      width: 100%;
    }
    .token-swatch__body {
      padding: 10px 12px;
      font-size: 12px;
      line-height: 1.4;
    }
  </style>
</head>
<body class="bg-paper text-ink min-h-screen">
  <header class="sticky top-0 z-50 w-full border-b border-line bg-paper/90 backdrop-blur-2xl">
    <div class="site-container flex min-h-[64px] items-center justify-between gap-4 py-2">
      <div class="flex items-center gap-3">
        <span class="grid size-9 place-items-center rounded-xl bg-blue text-base font-bold text-white shadow-subtle">ع</span>
        <div>
          <span class="text-base font-bold leading-tight block">3alemni Design Foundation</span>
          <span class="text-xs text-muted block">المرحلة 1: لوحة الرموز والمكونات</span>
        </div>
      </div>
      <div class="flex items-center gap-2">
        <a href="/dashboard" class="btn btn-sm btn-primary">
          معاينة لوحة المتعلّم (المرحلة 2) &rarr;
        </a>
      </div>
    </div>
  </header>

  <main class="site-container py-10 space-y-12">
    <section class="card-base bg-white border border-line p-6 rounded-xl space-y-2">
      <span class="badge badge-primary">رموز التصميم الأساسية</span>
      <h1 class="text-2xl font-bold">نظام الرموز المعتمد لمنصة علّمني</h1>
      <p class="text-xs text-muted">تدرجات موحدة تدعم التباين العالي وإمكانية الوصول (WCAG AA).</p>
    </section>

    <!-- Colors -->
    <section class="space-y-4">
      <h2 class="text-lg font-bold">1. لوحة الألوان الأساسية</h2>
      <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-6 gap-3">
        <div class="token-swatch"><div class="token-swatch__color" style="background: var(--color-paper)"></div><div class="token-swatch__body"><strong>Paper</strong><code class="text-muted text-[11px] block">#f7f5ef</code></div></div>
        <div class="token-swatch"><div class="token-swatch__color" style="background: var(--color-surface)"></div><div class="token-swatch__body"><strong>Surface</strong><code class="text-muted text-[11px] block">#ffffff</code></div></div>
        <div class="token-swatch"><div class="token-swatch__color" style="background: var(--color-ink)"></div><div class="token-swatch__body"><strong>Ink</strong><code class="text-muted text-[11px] block">#1b1e1b</code></div></div>
        <div class="token-swatch"><div class="token-swatch__color" style="background: var(--color-blue)"></div><div class="token-swatch__body"><strong>Brand Blue</strong><code class="text-muted text-[11px] block">#244ee8</code></div></div>
        <div class="token-swatch"><div class="token-swatch__color" style="background: var(--color-line)"></div><div class="token-swatch__body"><strong>Line</strong><code class="text-muted text-[11px] block">#dfded5</code></div></div>
        <div class="token-swatch"><div class="token-swatch__color" style="background: var(--color-success)"></div><div class="token-swatch__body"><strong>Success</strong><code class="text-muted text-[11px] block">#15803d</code></div></div>
      </div>
    </section>

    <!-- Primitives -->
    <section class="card-base bg-white border border-line p-6 rounded-xl space-y-5">
      <h2 class="text-lg font-bold">2. الأزرار والمكونات المشتركة</h2>
      <div class="flex flex-wrap items-center gap-3">
        <button class="btn btn-primary btn-md">زر رئيسي (Primary)</button>
        <button class="btn btn-secondary btn-md">زر ثانوي (Secondary)</button>
        <button class="btn btn-outline btn-md">زر بإطار (Outline)</button>
        <button class="btn btn-ghost btn-md">زر شفاف (Ghost)</button>
        <button class="btn btn-primary btn-md" disabled>معطّل (Disabled)</button>
      </div>
      <div class="pt-3 border-t border-line-subtle flex flex-wrap gap-2">
        <span class="badge badge-primary">شارة رئيسية</span>
        <span class="badge badge-success">مكتمل</span>
        <span class="badge badge-warning">قيد المراجعة</span>
        <span class="badge badge-error">خطأ</span>
        <span class="badge badge-neutral">محايد</span>
      </div>
    </section>
  </main>
</body>
</html>`;
}

// Create HTTP server
const server = http.createServer((req, res) => {
  const urlObj = new URL(req.url, `http://${req.headers.host || 'localhost'}`);
  const urlPath = urlObj.pathname;
  const stateQuery = urlObj.searchParams.get('state');

  // Serve static assets
  if (urlPath.startsWith('/assets/')) {
    const filePath = path.join(ROOT_DIR, urlPath);
    if (!filePath.startsWith(ROOT_DIR)) {
      res.writeHead(403);
      res.end('Forbidden');
      return;
    }

    fs.stat(filePath, (err, stats) => {
      if (err || !stats.isFile()) {
        res.writeHead(404, { 'Content-Type': 'text/plain' });
        res.end('File Not Found');
        return;
      }

      const ext = path.extname(filePath).toLowerCase();
      const contentType = MIME_TYPES[ext] || 'application/octet-stream';

      res.writeHead(200, {
        'Content-Type': contentType,
        'Cache-Control': 'no-cache, must-revalidate',
      });
      fs.createReadStream(filePath).pipe(res);
    });
    return;
  }

  // Health check endpoint
  if (urlPath === '/health' || urlPath === '/api/health') {
    res.writeHead(200, { 'Content-Type': 'application/json' });
    res.end(JSON.stringify({ status: 'ok', phase: 'Phase 2: Premium Student Dashboard' }));
    return;
  }

  // Tokens route for Phase 1 view
  if (urlPath === '/tokens') {
    res.writeHead(200, { 'Content-Type': 'text/html; charset=utf-8' });
    res.end(getTokensHtml());
    return;
  }

  // Default to Phase 2 Student Dashboard (supports ?state=empty for empty state testing)
  const isEmpty = stateQuery === 'empty';
  res.writeHead(200, { 'Content-Type': 'text/html; charset=utf-8' });
  res.end(getStudentDashboardHtml(isEmpty));
});

server.listen(PORT, '0.0.0.0', () => {
  console.log(`[3alemni LMS] Dev server running on http://0.0.0.0:${PORT}`);
});

process.on('SIGINT', () => {
  tailwindProcess.kill();
  process.exit();
});
process.on('SIGTERM', () => {
  tailwindProcess.kill();
  process.exit();
});
