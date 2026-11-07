/**
 * 3alemni Dev Server for AI Studio
 * - Listens on port 3000
 * - Serves compiled assets (CSS, Fonts, JS, Images)
 * - Renders Phase 3: Premium Student My Courses Page (/dashboard/my-courses or /dashboard/enrolled-courses)
 * - Renders Phase 2: Premium Student Dashboard (/dashboard)
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

// Render the Phase 3 Student My Courses Page
function getMyCoursesHtml(isEmptyState = false) {
  return `<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>3alemni LMS — دوراتي التعليمية (My Courses)</title>
  <link rel="stylesheet" href="/assets/css/main.css">
</head>
<body class="bg-paper text-ink min-h-screen font-sans selection:bg-blue/10 selection:text-blue">

  <!-- Dev View Switcher Banner -->
  <div class="bg-white border-b border-line px-4 py-2 flex flex-wrap items-center justify-between text-xs gap-3">
    <div class="flex items-center gap-2">
      <span class="badge badge-primary">المرحلة 3: صفحة دوراتي</span>
      <span class="text-muted hidden sm:inline">واجهة الطالب مع البحث الفوري والتصنيفات</span>
    </div>
    <div class="flex items-center gap-2">
      <a href="/dashboard/courses" class="btn btn-sm ${!isEmptyState ? 'btn-primary' : 'btn-secondary'} py-1 px-3">
        طالب مسجّل (3 دورات)
      </a>
      <a href="/dashboard/courses?state=empty" class="btn btn-sm ${isEmptyState ? 'btn-primary' : 'btn-secondary'} py-1 px-3">
        حالة فارغة (0 دورات)
      </a>
      <span class="text-line mx-1">|</span>
      <a href="/dashboard" class="text-ink-secondary hover:text-blue font-medium">لوحة التحكم &larr;</a>
      <span class="text-line mx-1">|</span>
      <a href="/tokens" class="text-blue hover:text-blue-dark font-semibold">رموز التصميم &rarr;</a>
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
          <a href="/dashboard" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-ink-secondary hover:bg-paper-subtle hover:text-blue transition">
            <svg class="size-4.5 text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            <span>نظرة عامة</span>
          </a>
          <a href="/dashboard/courses" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-semibold transition bg-blue-subtle text-blue border border-blue/20">
            <svg class="size-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
            <span>دوراتي التعليمية</span>
            <span class="size-1.5 rounded-full bg-blue mr-auto"></span>
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
            <a href="/dashboard" class="hover:text-blue transition font-medium">لوحة المتعلّم</a>
            <span class="text-line-strong">/</span>
            <span class="text-ink font-semibold">دوراتي</span>
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

      <!-- DASHBOARD BODY CONTAINER (MY COURSES TEMPLATE) -->
      <main class="flex-1 p-5 sm:p-8 space-y-7 max-w-[1300px] w-full mx-auto">

        <!-- 1. PAGE HEADER -->
        <header class="card-base bg-white border border-line p-6 sm:p-7 rounded-xl shadow-subtle">
          <div class="flex flex-col md:flex-row md:items-center justify-between gap-5">
            <div class="space-y-1.5 max-w-xl">
              <div class="flex items-center gap-2.5">
                <h1 class="text-2xl sm:text-3xl font-bold text-ink tracking-tight">دوراتي</h1>
                <span class="badge badge-primary text-xs font-bold tabular-nums">
                  ${!isEmptyState ? '3 دورات' : '0 دورات'}
                </span>
              </div>
              <p class="text-xs sm:text-sm text-muted leading-relaxed">
                تابع تقدّمك الدراسي، استكمل دروسك، واستعرض شهاداتك في مكان واحد.
              </p>
            </div>

            <!-- Search Input -->
            <div class="w-full md:w-80 shrink-0 relative">
              <div class="relative">
                <span class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none text-muted">
                  <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </span>
                <input
                  type="search"
                  id="course-search-input"
                  class="input-field ps-10 pe-9 text-xs sm:text-sm"
                  placeholder="ابحث في دوراتك بالعنوان أو المدرّب..."
                  autocomplete="off"
                >
                <button
                  type="button"
                  id="course-search-clear"
                  class="absolute inset-y-0 end-0 flex items-center pe-3 text-muted hover:text-ink transition hidden"
                  aria-label="مسح البحث"
                >
                  <svg class="size-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
                </button>
              </div>
            </div>
          </div>
        </header>

        <!-- 2. COURSE FILTERS -->
        <nav class="flex items-center justify-between flex-wrap gap-3 border-b border-line pb-3" aria-label="تصفية الدورات">
          <div class="flex items-center gap-2" role="tablist">
            <button
              type="button"
              role="tab"
              data-filter="all"
              class="filter-tab-btn btn btn-sm rounded-lg transition btn-primary"
            >
              <span>جميع الدورات</span>
              <span class="text-[11px] opacity-80 tabular-nums">(${!isEmptyState ? '3' : '0'})</span>
            </button>

            <button
              type="button"
              role="tab"
              data-filter="in-progress"
              class="filter-tab-btn btn btn-sm rounded-lg transition btn-secondary text-ink-secondary"
            >
              <span>قيد التعلّم</span>
              <span class="text-[11px] opacity-80 tabular-nums">(${!isEmptyState ? '2' : '0'})</span>
            </button>

            <button
              type="button"
              role="tab"
              data-filter="completed"
              class="filter-tab-btn btn btn-sm rounded-lg transition btn-secondary text-ink-secondary"
            >
              <span>المكتملة</span>
              <span class="text-[11px] opacity-80 tabular-nums">(${!isEmptyState ? '1' : '0'})</span>
            </button>
          </div>

          <a href="/courses" class="text-xs font-semibold text-blue hover:text-blue-dark transition flex items-center gap-1.5">
            <span>استكشاف دورات جديدة</span>
            <span class="rtl:rotate-180 text-sm">&rarr;</span>
          </a>
        </nav>

        <!-- 3. COURSE GRID -->
        <div id="courses-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
          ${!isEmptyState ? `
          <!-- Card 1 -->
          <article
            class="course-card-item card-base bg-white border border-line rounded-xl overflow-hidden shadow-subtle hover:shadow-card hover:-translate-y-0.5 transition flex flex-col h-full"
            data-course-status="in-progress"
            data-course-title="تطوير تطبيقات الويب الكاملة باستخدام react و node.js"
            data-course-instructor="م. كريم بلقاسم"
          >
            <div class="aspect-video w-full bg-paper-subtle overflow-hidden relative border-b border-line flex items-center justify-center">
              <span class="text-3xl">💻</span>
              <span class="absolute top-3 left-3 badge badge-primary shadow-xs font-bold text-xs tabular-nums">65%</span>
            </div>
            <div class="p-5 flex-1 flex flex-col justify-between space-y-4">
              <div class="space-y-2">
                <div class="flex items-center gap-1.5 text-xs text-muted">
                  <svg class="size-3.5 text-muted shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                  <span>م. كريم بلقاسم</span>
                </div>
                <h3 class="text-base font-bold text-ink leading-snug line-clamp-2 hover:text-blue transition">
                  <a href="/courses/full-stack-web">تطوير تطبيقات الويب الكاملة باستخدام React و Node.js</a>
                </h3>
              </div>
              <div class="p-2.5 bg-paper-subtle rounded-lg border border-line-subtle text-xs flex items-center gap-2 text-ink">
                <span class="size-1.5 rounded-full bg-blue shrink-0"></span>
                <span class="text-muted shrink-0">الدرس التالي:</span>
                <strong class="truncate max-w-[170px]">بناء وتأمين واجهات REST API</strong>
              </div>
              <div class="space-y-1.5 pt-2 border-t border-line-subtle">
                <div class="flex items-center justify-between text-xs text-muted">
                  <span>نسبة التقدّم</span>
                  <strong class="text-ink tabular-nums">13 من 20 درساً (65%)</strong>
                </div>
                <div class="w-full h-2 bg-paper rounded-full overflow-hidden border border-line-subtle">
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

          <!-- Card 2 -->
          <article
            class="course-card-item card-base bg-white border border-line rounded-xl overflow-hidden shadow-subtle hover:shadow-card hover:-translate-y-0.5 transition flex flex-col h-full"
            data-course-status="in-progress"
            data-course-title="تصميم واجهات وتجربة المستخدم الحديثة (ui/ux design)"
            data-course-instructor="أ. سارة بن ناصر"
          >
            <div class="aspect-video w-full bg-paper-subtle overflow-hidden relative border-b border-line flex items-center justify-center">
              <span class="text-3xl">🎨</span>
              <span class="absolute top-3 left-3 badge badge-primary shadow-xs font-bold text-xs tabular-nums">30%</span>
            </div>
            <div class="p-5 flex-1 flex flex-col justify-between space-y-4">
              <div class="space-y-2">
                <div class="flex items-center gap-1.5 text-xs text-muted">
                  <svg class="size-3.5 text-muted shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                  <span>أ. سارة بن ناصر</span>
                </div>
                <h3 class="text-base font-bold text-ink leading-snug line-clamp-2 hover:text-blue transition">
                  <a href="/courses/ui-ux-design">تصميم واجهات وتجربة المستخدم الحديثة (UI/UX Design)</a>
                </h3>
              </div>
              <div class="p-2.5 bg-paper-subtle rounded-lg border border-line-subtle text-xs flex items-center gap-2 text-ink">
                <span class="size-1.5 rounded-full bg-blue shrink-0"></span>
                <span class="text-muted shrink-0">الدرس التالي:</span>
                <strong class="truncate max-w-[170px]">نظم التصميم والمكونات في Figma</strong>
              </div>
              <div class="space-y-1.5 pt-2 border-t border-line-subtle">
                <div class="flex items-center justify-between text-xs text-muted">
                  <span>نسبة التقدّم</span>
                  <strong class="text-ink tabular-nums">4 من 12 درساً (30%)</strong>
                </div>
                <div class="w-full h-2 bg-paper rounded-full overflow-hidden border border-line-subtle">
                  <div class="h-full bg-blue rounded-full" style="width: 30%;"></div>
                </div>
              </div>
              <div class="pt-1">
                <a href="/lessons/ui-ux-5" class="btn btn-secondary btn-sm w-full justify-between">
                  <span>متابعة التعلّم</span>
                  <span class="text-blue rtl:rotate-180">&rarr;</span>
                </a>
              </div>
            </div>
          </article>

          <!-- Card 3 -->
          <article
            class="course-card-item card-base bg-white border border-line rounded-xl overflow-hidden shadow-subtle hover:shadow-card hover:-translate-y-0.5 transition flex flex-col h-full"
            data-course-status="completed"
            data-course-title="الأساسيات البرمجية وهياكل البيانات الحديثة"
            data-course-instructor="م. مهدي عمور"
          >
            <div class="aspect-video w-full bg-paper-subtle overflow-hidden relative border-b border-line flex items-center justify-center">
              <span class="text-3xl">⚡</span>
              <span class="absolute top-3 left-3 badge badge-success shadow-xs font-bold text-xs">مكتملة 100%</span>
            </div>
            <div class="p-5 flex-1 flex flex-col justify-between space-y-4">
              <div class="space-y-2">
                <div class="flex items-center gap-1.5 text-xs text-muted">
                  <svg class="size-3.5 text-muted shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                  <span>م. مهدي عمور</span>
                </div>
                <h3 class="text-base font-bold text-ink leading-snug line-clamp-2 hover:text-blue transition">
                  <a href="/courses/cs-fundamentals">الأساسيات البرمجية وهياكل البيانات الحديثة</a>
                </h3>
              </div>
              <div class="space-y-1.5 pt-2 border-t border-line-subtle">
                <div class="flex items-center justify-between text-xs text-muted">
                  <span>حالة الإنجاز</span>
                  <strong class="text-success tabular-nums font-semibold">مكتملة بالكامل (16/16)</strong>
                </div>
                <div class="w-full h-2 bg-paper rounded-full overflow-hidden border border-line-subtle">
                  <div class="h-full bg-success rounded-full" style="width: 100%;"></div>
                </div>
              </div>
              <div class="pt-1">
                <a href="/courses/cs-fundamentals" class="btn btn-secondary btn-sm w-full justify-between">
                  <span>مراجعة محتوى الدورة</span>
                  <span class="text-blue rtl:rotate-180">&rarr;</span>
                </a>
              </div>
            </div>
          </article>
          ` : ''}
        </div>

        <!-- 4. EMPTY STATES -->

        <!-- Empty State A: No enrolled courses -->
        <div
          id="empty-state-no-enrolled"
          class="card-base bg-white border border-line rounded-xl p-8 sm:p-14 text-center space-y-4 max-w-lg mx-auto shadow-subtle ${!isEmptyState ? 'hidden' : ''}"
        >
          <div class="grid size-16 place-items-center rounded-2xl bg-paper mx-auto text-3xl border border-line">
            🎓
          </div>
          <div class="space-y-1.5">
            <h2 class="text-xl font-bold text-ink">لم تقم بالتسجيل في أي دورة بعد</h2>
            <p class="text-xs sm:text-sm text-muted leading-relaxed">
              استكشف مساراتنا المعتمدة في البرمجة، التصميم، والتكنولوجيا وابدأ مسيرتك المهنية الآن.
            </p>
          </div>
          <div class="pt-2">
            <a href="/courses" class="btn btn-primary btn-md shadow-subtle inline-flex">
              <span>تصفح دليل الدورات المتاحة</span>
              <span class="rtl:rotate-180">&rarr;</span>
            </a>
          </div>
        </div>

        <!-- Empty State B: No matches for search -->
        <div id="empty-state-search" class="card-base bg-white border border-line rounded-xl p-8 sm:p-12 text-center space-y-4 max-w-md mx-auto shadow-subtle hidden">
          <div class="grid size-14 place-items-center rounded-2xl bg-paper mx-auto text-2xl border border-line">
            🔍
          </div>
          <div class="space-y-1.5">
            <h2 class="text-lg font-bold text-ink">لم نجد أي دورة مطابقة</h2>
            <p class="text-xs text-muted leading-relaxed" id="empty-search-message">
              لا توجد نتائج مطابقة لبحثك الحالي. حاول استخدام كلمات مفتاحية أخرى.
            </p>
          </div>
          <div class="pt-1">
            <button type="button" id="btn-reset-search" class="btn btn-secondary btn-sm inline-flex">
              إعادة ضبط البحث
            </button>
          </div>
        </div>

        <!-- Empty State C: No courses in selected filter -->
        <div id="empty-state-filter" class="card-base bg-white border border-line rounded-xl p-8 sm:p-12 text-center space-y-4 max-w-md mx-auto shadow-subtle hidden">
          <div class="grid size-14 place-items-center rounded-2xl bg-paper mx-auto text-2xl border border-line">
            📂
          </div>
          <div class="space-y-1.5">
            <h2 class="text-lg font-bold text-ink">لا توجد دورات في هذا القسم</h2>
            <p class="text-xs text-muted leading-relaxed">
              لم تسجل بعد أي تقدم في هذا التصنيف. يمكنك استعراض كافة دوراتك التعليمية.
            </p>
          </div>
          <div class="pt-1 flex items-center justify-center gap-2">
            <button type="button" id="btn-view-all-filter" class="btn btn-primary btn-sm inline-flex">
              عرض جميع الدورات
            </button>
          </div>
        </div>

      </main>

      <!-- Global Dashboard Footer -->
      <footer class="border-t border-line bg-white/70 mt-auto">
        <div class="px-5 sm:px-8 py-5 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-muted">
          <div class="flex items-center gap-3">
            <strong class="text-ink">3alemni LMS</strong>
            <span>&copy; 2026 علّمني. منصة التعليم الرقمي للجمهور الجزائري.</span>
          </div>
          <div class="flex items-center gap-4">
            <span class="badge badge-success text-[11px]">المرحلة 3 مكتملة</span>
            <span class="text-line">•</span>
            <span>Student My Courses Page</span>
          </div>
        </div>
      </footer>

    </div>
  </div>

  <script>
  (function() {
    var currentFilter = 'all';
    var searchInput = document.getElementById('course-search-input');
    var clearBtn = document.getElementById('course-search-clear');
    var filterBtns = document.querySelectorAll('.filter-tab-btn');
    var cards = document.querySelectorAll('.course-card-item');
    var emptySearch = document.getElementById('empty-state-search');
    var emptyFilter = document.getElementById('empty-state-filter');
    var emptySearchMsg = document.getElementById('empty-search-message');
    var resetSearchBtn = document.getElementById('btn-reset-search');
    var viewAllBtn = document.getElementById('btn-view-all-filter');

    if (!cards.length) return;

    function applyFilterAndSearch() {
      var query = (searchInput ? searchInput.value : '').trim().toLowerCase();
      var visibleCount = 0;
      var filterMatchCount = 0;

      if (clearBtn) {
        clearBtn.classList.toggle('hidden', query.length === 0);
      }

      cards.forEach(function(card) {
        var cardStatus = card.getAttribute('data-course-status') || '';
        var cardTitle = card.getAttribute('data-course-title') || '';
        var cardInstructor = card.getAttribute('data-course-instructor') || '';

        var matchesFilter = (currentFilter === 'all' || cardStatus === currentFilter);
        if (matchesFilter) filterMatchCount++;

        var matchesSearch = (query.length === 0 || cardTitle.indexOf(query) !== -1 || cardInstructor.indexOf(query) !== -1);

        if (matchesFilter && matchesSearch) {
          card.classList.remove('hidden');
          visibleCount++;
        } else {
          card.classList.add('hidden');
        }
      });

      if (emptySearch) emptySearch.classList.add('hidden');
      if (emptyFilter) emptyFilter.classList.add('hidden');

      if (visibleCount === 0) {
        if (query.length > 0) {
          if (emptySearch) {
            emptySearch.classList.remove('hidden');
            if (emptySearchMsg) emptySearchMsg.textContent = 'لم نعثر على أي دورة تطابق "' + query + '". جرب البحث باسم آخر.';
          }
        } else if (filterMatchCount === 0) {
          if (emptyFilter) emptyFilter.classList.remove('hidden');
        }
      }
    }

    filterBtns.forEach(function(btn) {
      btn.addEventListener('click', function() {
        var target = this.getAttribute('data-filter') || 'all';
        currentFilter = target;
        filterBtns.forEach(function(b) {
          var isActive = (b.getAttribute('data-filter') === target);
          if (isActive) {
            b.classList.remove('btn-secondary', 'text-ink-secondary');
            b.classList.add('btn-primary');
          } else {
            b.classList.remove('btn-primary');
            b.classList.add('btn-secondary', 'text-ink-secondary');
          }
        });
        applyFilterAndSearch();
      });
    });

    if (searchInput) searchInput.addEventListener('input', applyFilterAndSearch);
    if (clearBtn) clearBtn.addEventListener('click', function() {
      searchInput.value = '';
      searchInput.focus();
      applyFilterAndSearch();
    });
    if (resetSearchBtn) resetSearchBtn.addEventListener('click', function() {
      if (searchInput) searchInput.value = '';
      applyFilterAndSearch();
    });
    if (viewAllBtn) viewAllBtn.addEventListener('click', function() {
      var all = document.querySelector('.filter-tab-btn[data-filter="all"]');
      if (all) all.click();
    });

    applyFilterAndSearch();
  })();
  </script>

</body>
</html>`;
}

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
      <a href="/dashboard" class="btn btn-sm ${!isEmptyState ? 'btn-primary' : 'btn-secondary'} py-1 px-3">
        نظرة عامة
      </a>
      <a href="/dashboard/my-courses" class="btn btn-sm btn-secondary py-1 px-3 text-blue font-semibold">
        صفحة دوراتي (المرحلة 3) &rarr;
      </a>
      <span class="text-line mx-1">|</span>
      <a href="/tokens" class="text-blue hover:text-blue-dark font-semibold">
        لوحة الرموز &rarr;
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
          <button
            onclick="document.getElementById('dashboard-sidebar').classList.toggle('hidden')"
            type="button"
            class="md:hidden flex items-center justify-center size-9 rounded-lg border border-line bg-paper-subtle text-ink hover:bg-paper transition"
            aria-label="تبديل القائمة"
          >
            <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
          </button>

          <div class="flex items-center gap-2 text-xs text-muted">
            <span class="font-medium">لوحة المتعلّم</span>
            <span class="text-line-strong">/</span>
            <span class="text-ink font-semibold">نظرة عامة</span>
          </div>
        </div>

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
        <!-- Welcome Section -->
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
                لديك 2 دورات قيد التعلّم. واصل التقدّم واكتسب مهارات عملية جديدة اليوم.
              </p>
            </div>
            <div class="flex items-center gap-3 shrink-0">
              <a href="/dashboard/my-courses" class="btn btn-primary btn-md shadow-subtle">
                <span>عرض دوراتي (المرحلة 3)</span>
                <svg class="size-4 rtl:rotate-180" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
              </a>
            </div>
          </div>
        </section>

        <!-- Metrics -->
        <section class="grid grid-cols-2 sm:grid-cols-4 gap-4">
          <div class="card-base bg-white border border-line p-5 rounded-xl shadow-subtle">
            <div class="flex items-center justify-between mb-3"><span class="text-xs font-semibold uppercase text-muted">الدورات المسجلة</span><span class="grid size-8 place-items-center rounded-lg bg-blue-subtle text-blue text-sm">📚</span></div>
            <div class="flex items-baseline gap-2"><span class="text-2xl sm:text-3xl font-bold text-ink tabular-nums">3</span><span class="text-xs text-muted">دورات</span></div>
          </div>
          <div class="card-base bg-white border border-line p-5 rounded-xl shadow-subtle">
            <div class="flex items-center justify-between mb-3"><span class="text-xs font-semibold uppercase text-muted">قيد التعلّم</span><span class="grid size-8 place-items-center rounded-lg bg-warning-subtle text-warning text-sm">⏳</span></div>
            <div class="flex items-baseline gap-2"><span class="text-2xl sm:text-3xl font-bold text-ink tabular-nums">2</span><span class="text-xs text-muted">دورات جارية</span></div>
          </div>
          <div class="card-base bg-white border border-line p-5 rounded-xl shadow-subtle">
            <div class="flex items-center justify-between mb-3"><span class="text-xs font-semibold uppercase text-muted">الدورات المكتملة</span><span class="grid size-8 place-items-center rounded-lg bg-success-subtle text-success text-sm">✓</span></div>
            <div class="flex items-baseline gap-2"><span class="text-2xl sm:text-3xl font-bold text-ink tabular-nums">1</span><span class="text-xs text-muted">شهادة جاهزة</span></div>
          </div>
          <div class="card-base bg-white border border-line p-5 rounded-xl shadow-subtle">
            <div class="flex items-center justify-between mb-3"><span class="text-xs font-semibold uppercase text-muted">معدل الإنجاز</span><span class="grid size-8 place-items-center rounded-lg bg-blue-light text-blue text-sm">🎯</span></div>
            <div class="flex items-baseline gap-2"><span class="text-2xl sm:text-3xl font-bold text-ink tabular-nums">33%</span><span class="text-xs text-muted">إجمالي المسارات</span></div>
          </div>
        </section>

        <!-- Continue Learning Quick Link -->
        <div class="p-4 bg-white border border-line rounded-xl flex items-center justify-between">
          <div class="flex items-center gap-3">
            <span class="text-2xl">💻</span>
            <div>
              <strong class="text-sm font-bold block text-ink">تطوير تطبيقات الويب الكاملة باستخدام React و Node.js</strong>
              <span class="text-xs text-muted">مكتمل بنسبة 65% • الدرس 14 جاهز للبدء</span>
            </div>
          </div>
          <a href="/dashboard/my-courses" class="btn btn-primary btn-sm">
            متابعة في دوراتي &larr;
          </a>
        </div>
      </main>
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
        <a href="/dashboard/my-courses" class="btn btn-sm btn-primary">
          معاينة صفحة دوراتي (المرحلة 3) &rarr;
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
    res.end(JSON.stringify({ status: 'ok', phase: 'Phase 3: Premium Student My Courses' }));
    return;
  }

  // Tokens route
  if (urlPath === '/tokens') {
    res.writeHead(200, { 'Content-Type': 'text/html; charset=utf-8' });
    res.end(getTokensHtml());
    return;
  }

  // Phase 2 Overview Dashboard route
  if (urlPath === '/dashboard' || urlPath === '/dashboard/') {
    const isEmpty = stateQuery === 'empty';
    res.writeHead(200, { 'Content-Type': 'text/html; charset=utf-8' });
    res.end(getStudentDashboardHtml(isEmpty));
    return;
  }

  // Phase 3 Student My Courses route (default for root / or /dashboard/my-courses or /dashboard/enrolled-courses)
  const isEmpty = stateQuery === 'empty';
  res.writeHead(200, { 'Content-Type': 'text/html; charset=utf-8' });
  res.end(getMyCoursesHtml(isEmpty));
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
