/**
 * 3alemni Dev Server for AI Studio
 * - Listens on port 3000
 * - Serves compiled assets (CSS, Fonts, JS, Images)
 * - Renders the Phase 1 Design System & Component Foundation preview
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

// Helper to serve preview HTML
function getPreviewHtml() {
  return `<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>3alemni LMS — Phase 1 Design Foundation</title>
  <link rel="stylesheet" href="/assets/css/main.css">
  <style>
    /* Preview meta badges & quick navigation */
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
    .specimen-row {
      display: flex;
      flex-direction: column;
      gap: 6px;
      padding: 14px 0;
      border-bottom: 1px solid var(--color-line-subtle);
    }
    .specimen-meta {
      font-size: 11px;
      font-family: var(--font-latin);
      color: var(--color-muted);
      direction: ltr;
      text-align: right;
    }
  </style>
</head>
<body class="bg-paper text-ink min-h-screen">

  <!-- Global Header (Consistent Layout) -->
  <header class="sticky top-0 z-50 w-full border-b border-line/70 bg-paper/90 backdrop-blur-2xl">
    <div class="site-container flex min-h-[70px] items-center justify-between gap-4 py-3">
      <div class="flex items-center gap-3">
        <span class="grid size-10 place-items-center rounded-xl bg-blue text-lg font-bold text-white shadow-subtle">ع</span>
        <div>
          <span class="text-lg font-bold leading-tight block">3alemni</span>
          <span class="text-xs text-muted block">نظام التصميم — المرحلة 1</span>
        </div>
      </div>
      <div class="flex items-center gap-2">
        <span class="badge badge-success">
          <span class="size-1.5 rounded-full bg-success"></span>
          جاهز للإنتاج
        </span>
        <a href="#primitives" class="btn btn-sm btn-secondary">المكونات البرمجية</a>
        <a href="#tokens" class="btn btn-sm btn-primary">لوحة الرموز</a>
      </div>
    </div>
  </header>

  <!-- Main Container -->
  <main class="site-container py-10 sm:py-14 space-y-16">

    <!-- Hero / Status Banner -->
    <section class="card-base bg-white border-line">
      <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6">
        <div class="space-y-2">
          <span class="badge badge-primary">المرحلة 1: الأساس البصري ونظام الرموز</span>
          <h1 class="text-2xl sm:text-3xl font-bold tracking-tight">هوية علّمني الرقمية (3alemni Design Foundation)</h1>
          <p class="text-sm text-ink-secondary max-w-2xl">
            تم تأسيس لغة بصرية عربية متكاملة لمنصة تعليمية حديثة (Modern Educational SaaS) مبنية على مبادئ التصميم الدقيق: توازن بصري 60-30-10، خطوط عربية ولاتينية أصيلة، وأزرار وعناصر إدخال بنسب هندسية منضبطة.
          </p>
        </div>
        <div class="flex flex-wrap sm:flex-col gap-2 shrink-0">
          <div class="p-3 bg-paper-subtle rounded-lg border border-line-subtle text-xs">
            <span class="text-muted block">الخط العربي الأساسي:</span>
            <span class="font-bold text-ink">IBM Plex Sans Arabic (400-700)</span>
          </div>
          <div class="p-3 bg-paper-subtle rounded-lg border border-line-subtle text-xs">
            <span class="text-muted block">الخط اللاتيني الإضافي:</span>
            <span class="font-bold text-ink">Inter (400-700)</span>
          </div>
        </div>
      </div>
    </section>

    <!-- SECTION 1: Color Tokens -->
    <section id="tokens" class="space-y-6">
      <div class="border-b border-line pb-3">
        <h2 class="text-xl font-bold">1. لوحة الألوان ورموز الهوية (Color Tokens)</h2>
        <p class="text-xs text-muted">تدرجات موحدة تدعم التباين العالي وإمكانية الوصول (WCAG AA).</p>
      </div>

      <div>
        <h3 class="text-sm font-semibold uppercase tracking-wider text-muted mb-3">ألوان الخلفية والمساحات (Surfaces & Canvas)</h3>
        <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-5 gap-3">
          <div class="token-swatch">
            <div class="token-swatch__color" style="background: var(--color-paper)"></div>
            <div class="token-swatch__body">
              <strong class="block text-ink">Paper (الأساس)</strong>
              <code class="text-muted text-[11px]">#f7f5ef</code>
            </div>
          </div>
          <div class="token-swatch">
            <div class="token-swatch__color" style="background: var(--color-paper-subtle)"></div>
            <div class="token-swatch__body">
              <strong class="block text-ink">Paper Subtle</strong>
              <code class="text-muted text-[11px]">#fbfaf7</code>
            </div>
          </div>
          <div class="token-swatch">
            <div class="token-swatch__color" style="background: var(--color-surface)"></div>
            <div class="token-swatch__body">
              <strong class="block text-ink">Surface White</strong>
              <code class="text-muted text-[11px]">#ffffff</code>
            </div>
          </div>
          <div class="token-swatch">
            <div class="token-swatch__color" style="background: var(--color-surface-hover)"></div>
            <div class="token-swatch__body">
              <strong class="block text-ink">Surface Hover</strong>
              <code class="text-muted text-[11px]">#faf9f5</code>
            </div>
          </div>
          <div class="token-swatch">
            <div class="token-swatch__color" style="background: var(--color-line)"></div>
            <div class="token-swatch__body">
              <strong class="block text-ink">Line (الحدود)</strong>
              <code class="text-muted text-[11px]">#dfded5</code>
            </div>
          </div>
        </div>
      </div>

      <div>
        <h3 class="text-sm font-semibold uppercase tracking-wider text-muted mb-3">ألوان العلامة والإجراءات (Brand Blue)</h3>
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
          <div class="token-swatch">
            <div class="token-swatch__color" style="background: var(--color-blue)"></div>
            <div class="token-swatch__body">
              <strong class="block text-ink">Brand Blue</strong>
              <code class="text-muted text-[11px]">#244ee8</code>
            </div>
          </div>
          <div class="token-swatch">
            <div class="token-swatch__color" style="background: var(--color-blue-dark)"></div>
            <div class="token-swatch__body">
              <strong class="block text-ink">Blue Dark (Hover)</strong>
              <code class="text-muted text-[11px]">#1939b5</code>
            </div>
          </div>
          <div class="token-swatch">
            <div class="token-swatch__color" style="background: var(--color-blue-light)"></div>
            <div class="token-swatch__body">
              <strong class="block text-ink">Blue Light</strong>
              <code class="text-muted text-[11px]">#eff3ff</code>
            </div>
          </div>
          <div class="token-swatch">
            <div class="token-swatch__color" style="background: var(--color-blue-subtle)"></div>
            <div class="token-swatch__body">
              <strong class="block text-ink">Blue Subtle</strong>
              <code class="text-muted text-[11px]">#f5f8ff</code>
            </div>
          </div>
        </div>
      </div>

      <div>
        <h3 class="text-sm font-semibold uppercase tracking-wider text-muted mb-3">تدرجات النصوص والظلال الدلالية (Typography & Semantics)</h3>
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
          <div class="token-swatch">
            <div class="token-swatch__color" style="background: var(--color-ink)"></div>
            <div class="token-swatch__body">
              <strong class="block text-ink">Ink Primary</strong>
              <code class="text-muted text-[11px]">#1b1e1b</code>
            </div>
          </div>
          <div class="token-swatch">
            <div class="token-swatch__color" style="background: var(--color-muted)"></div>
            <div class="token-swatch__body">
              <strong class="block text-ink">Ink Muted</strong>
              <code class="text-muted text-[11px]">#73766d</code>
            </div>
          </div>
          <div class="token-swatch">
            <div class="token-swatch__color" style="background: var(--color-success)"></div>
            <div class="token-swatch__body">
              <strong class="block text-ink">Success</strong>
              <code class="text-muted text-[11px]">#15803d</code>
            </div>
          </div>
          <div class="token-swatch">
            <div class="token-swatch__color" style="background: var(--color-error)"></div>
            <div class="token-swatch__body">
              <strong class="block text-ink">Error</strong>
              <code class="text-muted text-[11px]">#b91c1c</code>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- SECTION 2: Typography Scale -->
    <section class="space-y-6">
      <div class="border-b border-line pb-3">
        <h2 class="text-xl font-bold">2. سلم الطباعة العربي (Typography Scale & Hierarchy)</h2>
        <p class="text-xs text-muted">خط IBM Plex Sans Arabic مع ارتفاعات أسطر محسوبة لراحة القراءة باللغة العربية (Line-height 1.75).</p>
      </div>

      <div class="card-base space-y-4">
        <div class="specimen-row">
          <div class="specimen-meta">Display / H1 — clamp(2rem, 3.8vw, 2.75rem) — Weight 700</div>
          <h1>تعلّم مهارات المستقبل باللغة العربية</h1>
        </div>
        <div class="specimen-row">
          <div class="specimen-meta">Heading / H2 — clamp(1.5rem, 2.8vw, 2rem) — Weight 700</div>
          <h2>مسارات تعليمية وتطبيقية موجهة لسوق العمل الجزائري</h2>
        </div>
        <div class="specimen-row">
          <div class="specimen-meta">Section / H3 — clamp(1.25rem, 2.2vw, 1.5rem) — Weight 600</div>
          <h3>دروس تفاعلية، شهادات معتمدة، ومشاريع واقعية قابلة للتنفيذ</h3>
        </div>
        <div class="specimen-row">
          <div class="specimen-meta">Subheading / H4 — 1.125rem — Weight 600</div>
          <h4>انضم إلى مجتمع يتجاوز 10,000 طالب ومدرّب شغوف بالمعرفة</h4>
        </div>
        <div class="specimen-row">
          <div class="specimen-meta">Body / Paragraph — 1rem (16px) — Line-height 1.75 — Regular 400</div>
          <p class="text-sm leading-relaxed text-ink-secondary">
            منصة علّمني صُممت لتمنح المتعلم الجزائري تجربة سلسة وعالية الكفاءة. نركز على التطبيق العملي ونقل المعرفة عبر أحدث مناهج التعليم الإلكتروني، مع الحفاظ على هوية بصرية مريحة للعين وتدعم القراءة المركزة.
          </p>
        </div>
        <div class="specimen-row border-b-0">
          <div class="specimen-meta">Numbers / Tabular Figures — font-variant-numeric: tabular-nums</div>
          <div class="flex items-center gap-6 font-bold text-lg tabular-nums">
            <span>DA 14,500</span>
            <span>+1,250 طالب</span>
            <span>98.4% تقييم إيجابي</span>
            <span>24 ساعة دعم فني</span>
          </div>
        </div>
      </div>
    </section>

    <!-- SECTION 3: Shared UI Primitives -->
    <section id="primitives" class="space-y-8">
      <div class="border-b border-line pb-3">
        <h2 class="text-xl font-bold">3. العناصر والمكونات المشتركة (Shared UI Primitives)</h2>
        <p class="text-xs text-muted">مكونات قياسية موحدة بدون أشكال كبسولية عشوائية أو تدرجات مفرطة.</p>
      </div>

      <!-- Buttons -->
      <div class="card-base space-y-5">
        <h3 class="text-sm font-semibold uppercase tracking-wider text-muted">أزرار النظام (Button Variants & States)</h3>
        
        <div class="flex flex-wrap items-center gap-3">
          <button class="btn btn-primary btn-md">زر رئيسي (Primary)</button>
          <button class="btn btn-secondary btn-md">زر ثانوي (Secondary)</button>
          <button class="btn btn-outline btn-md">زر بإطار (Outline)</button>
          <button class="btn btn-ghost btn-md">زر شفاف (Ghost)</button>
          <button class="btn btn-danger btn-md">إجراء تحذيري (Danger)</button>
          <button class="btn btn-primary btn-md" disabled>معطّل (Disabled)</button>
        </div>

        <div class="pt-3 border-t border-line-subtle flex flex-wrap items-center gap-3">
          <span class="text-xs text-muted ml-2">الأحجام:</span>
          <button class="btn btn-primary btn-sm">حجم صغير (36px)</button>
          <button class="btn btn-primary btn-md">حجم قياسي (44px)</button>
          <button class="btn btn-primary btn-lg">حجم كبير (50px)</button>
        </div>
      </div>

      <!-- Form Controls -->
      <div class="card-base space-y-6">
        <h3 class="text-sm font-semibold uppercase tracking-wider text-muted">حقول الإدخال والنماذج (Form Inputs & Validation)</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
          <div class="form-group">
            <label class="form-label" for="ex-name">الاسم الكامل</label>
            <input class="input-field" type="text" id="ex-name" placeholder="محمد بن عبد الله">
            <span class="form-hint">يظهر اسمك كما هو مدخل في الشهادات الرسمية.</span>
          </div>

          <div class="form-group">
            <label class="form-label" for="ex-email">البريد الإلكتروني</label>
            <input class="input-field" type="email" id="ex-email" value="learner@3alemni.dz">
            <span class="form-hint">سنرسل رابط تفعيل الحساب فور التسجيل.</span>
          </div>

          <div class="form-group">
            <label class="form-label" for="ex-track">المسار التعليمي</label>
            <select class="select-field" id="ex-track">
              <option>تطوير تطبيقات الويب الحديثة</option>
              <option>تصميم واجهات وتجربة المستخدم</option>
              <option>الذكاء الاصطناعي وهندسة البيانات</option>
            </select>
            <span class="form-hint">يمكنك تغيير المسار لاحقاً من لوحة التحكم.</span>
          </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 pt-3 border-t border-line-subtle">
          <div class="form-group">
            <label class="form-label text-error">حالة وجود خطأ تحقق (Error State)</label>
            <input class="input-field border-error focus:ring-error/10 focus:border-error" type="password" value="1234">
            <span class="form-error">كلمة المرور يجب أن لا تقل عن 8 خانات وتحتوي على رقم.</span>
          </div>

          <div class="form-group">
            <label class="form-label text-muted">حقل معطّل (Disabled State)</label>
            <input class="input-field" type="text" value="معرّف الطالب #DZ-9921" disabled>
            <span class="form-hint">الرقم التعريفي مُنشأ تلقائياً وغير قابل للتعديل.</span>
          </div>
        </div>
      </div>

      <!-- Badges & Chips -->
      <div class="card-base space-y-4">
        <h3 class="text-sm font-semibold uppercase tracking-wider text-muted">شارات وشارات الحالة (Status Badges)</h3>
        <div class="flex flex-wrap items-center gap-3">
          <span class="badge badge-primary">مسار نشط</span>
          <span class="badge badge-success">مكتمل 100%</span>
          <span class="badge badge-warning">قيد المراجعة</span>
          <span class="badge badge-error">غير مفعّل</span>
          <span class="badge badge-neutral">مستوى مبتدئ</span>
        </div>
      </div>

      <!-- Alerts -->
      <div class="space-y-3">
        <div class="alert alert-info">
          <span class="font-bold">ملاحظة:</span>
          <span>تم تفعيل المرحلة الأولى من التصميم بنجاح؛ كافة الرموز (Tokens) والمكونات الأساسية متوافقة بالكامل مع قوالب Tutor LMS.</span>
        </div>
        <div class="alert alert-success">
          <span class="font-bold">نجاح:</span>
          <span>تم تجميع ملف الإنتاج assets/css/main.css بنجاح دون أي أخطاء ترجمة أو استدعاءات مكررة.</span>
        </div>
        <div class="alert alert-warning">
          <span class="font-bold">تنبيه:</span>
          <span>المراحل القادمة ستشمل إعادة تصميم لوحات تحكم الطلاب والمدرّبين وصفحات المساقات بالتتابع.</span>
        </div>
      </div>

      <!-- Tables -->
      <div class="table-wrapper">
        <table class="table-base">
          <thead>
            <tr>
              <th>المساق التدريبي</th>
              <th>المدرّب</th>
              <th>المستوى</th>
              <th>عدد الطلاب</th>
              <th>التقييم</th>
              <th>الحالة</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="font-semibold">تطوير واجهات المستخدم المتقدمة</td>
              <td class="text-muted">م. كريم بلقاسم</td>
              <td>متقدم</td>
              <td class="tabular-nums">412</td>
              <td class="tabular-nums font-semibold text-blue">4.9 / 5</td>
              <td><span class="badge badge-success">مفتوح للتسجيل</span></td>
            </tr>
            <tr>
              <td class="font-semibold">أساسيات إدارة المنتجات الرقمية</td>
              <td class="text-muted">أ. سارة بن ناصر</td>
              <td>متوسط</td>
              <td class="tabular-nums">280</td>
              <td class="tabular-nums font-semibold text-blue">4.8 / 5</td>
              <td><span class="badge badge-primary">جديد</span></td>
            </tr>
            <tr>
              <td class="font-semibold">بناء وإطلاق البرمجيات السحابية</td>
              <td class="text-muted">م. مهدي عمور</td>
              <td>متقدم</td>
              <td class="tabular-nums">195</td>
              <td class="tabular-nums font-semibold text-blue">4.9 / 5</td>
              <td><span class="badge badge-warning">المقاعد محدودة</span></td>
            </tr>
          </tbody>
        </table>
      </div>

    </section>

  </main>

  <!-- Global Footer Preview -->
  <footer class="border-t border-line/80 bg-white/60 mt-20">
    <div class="site-container py-8 sm:py-10 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-muted">
      <div class="flex items-center gap-3">
        <span class="font-bold text-ink text-sm">3alemni LMS</span>
        <span>&copy; 2026 علّمني. جميع الحقوق محفوظة للمتعلمين في الجزائر.</span>
      </div>
      <div class="flex items-center gap-4">
        <span>مرحلة الأساس البصري مكتملة</span>
        <span class="text-line">•</span>
        <span>Tailwind CSS v4 + IBM Plex Sans Arabic</span>
      </div>
    </div>
  </footer>

</body>
</html>`;
}

// Create HTTP server
const server = http.createServer((req, res) => {
  const urlPath = req.url ? req.url.split('?')[0] : '/';

  // Serve static assets
  if (urlPath.startsWith('/assets/')) {
    const filePath = path.join(ROOT_DIR, urlPath);
    // Basic path traversal prevention
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
    res.end(JSON.stringify({ status: 'ok', phase: 'Phase 1: Design Foundation' }));
    return;
  }

  // Serve preview page on all HTML/page routes
  res.writeHead(200, { 'Content-Type': 'text/html; charset=utf-8' });
  res.end(getPreviewHtml());
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
