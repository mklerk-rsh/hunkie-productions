# Hunkie Productions — Public Website Architecture

## 1. Site Structure

```
URL STRUCTURE
═════════════
/                               → Home Page
/about                          → About Us
/portfolio                      → Portfolio Grid
/portfolio/{slug}               → Portfolio Detail
/services                       → Services Overview
/services/{slug}                → Service Detail
/blog                           → Blog Index
/blog/{slug}                    → Blog Post
/team                           → Team Overview
/team/{slug}                    → Team Member Detail
/faq                            → Frequently Asked Questions
/contact                        → Contact Page
/{slug}                         → CMS Pages (dynamic)
```

## 2. Page Inventory & Layout

### 2.1 Home Page
```
┌─────────────────────────────────────────────────┐
│  NAVBAR (Logo, Navigation, CTA Button)          │
├─────────────────────────────────────────────────┤
│  HERO SECTION                                   │
│  - Full-width background image/carousel         │
│  - Headline + subheadline                       │
│  - CTA button → /portfolio or /contact          │
├─────────────────────────────────────────────────┤
│  FEATURED PROJECTS (3-6)                        │
│  - Grid of project cards with thumbnail         │
│  - Hover overlay with title + category          │
│  - "View All Projects" link                     │
├─────────────────────────────────────────────────┤
│  SERVICES OVERVIEW (3-4 services)               │
│  - Icon + title + brief description             │
│  - Link to service detail                       │
├─────────────────────────────────────────────────┤
│  TESTIMONIALS CAROUSEL                          │
│  - Client photo, quote, name, company           │
│  - Auto-rotating or manual navigation           │
├─────────────────────────────────────────────────┤
│  CTA SECTION                                    │
│  - "Ready to start your project?"               │
│  - Contact button                               │
├─────────────────────────────────────────────────┤
│  FOOTER (Logo, Nav, Social, Contact, ©)         │
└─────────────────────────────────────────────────┘
```

### 2.2 Portfolio Page
```
┌─────────────────────────────────────────────────┐
│  PAGE HEADER (Title + Breadcrumb)               │
├─────────────────────────────────────────────────┤
│  FILTER BAR                                     │
│  - Category filter buttons (All | Film | Photo) │
├─────────────────────────────────────────────────┤
│  PROJECT GRID (Masonry/Grid)                    │
│  - Project thumbnail (16:9 or 4:3)              │
│  - Title overlay on hover                       │
│  - Category badge                               │
│  - Pagination or Infinite scroll                │
└─────────────────────────────────────────────────┘
```

### 2.3 Portfolio Detail
```
┌─────────────────────────────────────────────────┐
│  PAGE HEADER (Title, Client, Date, Breadcrumb)  │
├─────────────────────────────────────────────────┤
│  GALLERY / MEDIA SLIDER                         │
│  - Full-width image slider or grid              │
│  - Lightbox on click                            │
├─────────────────────────────────────────────────┤
│  PROJECT CONTENT                                │
│  - Rich text description                        │
│  - Client name, completion date                 │
│  - External URL (if applicable)                 │
├─────────────────────────────────────────────────┤
│  SHARE / SOCIAL                                 │
├─────────────────────────────────────────────────┤
│  RELATED PROJECTS (optional)                    │
└─────────────────────────────────────────────────┘
```

### 2.4 Blog Page
```
┌─────────────────────────────────────────────────┐
│  PAGE HEADER (Title + Breadcrumb)               │
├─────────────────────────────────────────────────┤
│  BLOG GRID                                      │
│  ┌──────┐ ┌──────┐ ┌──────┐                   │
│  │ Post  │ │ Post  │ │ Post  │                   │
│  │ Card  │ │ Card  │ │ Card  │                   │
│  └──────┘ └──────┘ └──────┘                   │
│  - Featured image                               │
│  - Category badge                               │
│  - Title + excerpt                              │
│  - Date + author                                │
├─────────────────────────────────────────────────┤
│  SIDEBAR                                        │
│  - Categories list                              │
│  - Tags cloud                                   │
│  - Recent posts                                 │
├─────────────────────────────────────────────────┤
│  PAGINATION                                     │
└─────────────────────────────────────────────────┘
```

### 2.5 Contact Page
```
┌─────────────────────────────────────────────────┐
│  PAGE HEADER (Title + Breadcrumb)               │
├─────────────────────────────────────────────────┤
│  TWO-COLUMN LAYOUT                              │
│  ┌──────────────────┐ ┌──────────────────┐     │
│  │  CONTACT FORM    │ │  COMPANY INFO     │     │
│  │  - Name          │ │  - Address        │     │
│  │  - Email         │ │  - Phone          │     │
│  │  - Phone         │ │  - Email          │     │
│  │  - Service       │ │  - Social links   │     │
│  │  - Message       │ │                   │     │
│  │  - Submit        │ │  MAP              │     │
│  └──────────────────┘ └──────────────────┘     │
└─────────────────────────────────────────────────┘
```

## 3. Component Architecture

```
resources/views/
├── components/
│   ├── layout/
│   │   ├── app.blade.php              — Main layout wrapper
│   │   ├── navigation.blade.php       — Navbar (dynamic from menus table)
│   │   ├── footer.blade.php           — Footer with dynamic menu
│   │   ├── head.blade.php             — <head> with SEO meta
│   │   └── breadcrumb.blade.php       — Breadcrumb component
│   │
│   ├── sections/
│   │   ├── hero.blade.php              — Hero section
│   │   ├── featured-projects.blade.php — Home page featured projects
│   │   ├── services-overview.blade.php — Home page services grid
│   │   ├── testimonials-carousel.blade.php
│   │   ├── cta-section.blade.php       — Call to action
│   │   └── stats-counter.blade.php     — Stats display
│   │
│   ├── cards/
│   │   ├── project-card.blade.php      — Portfolio grid card
│   │   ├── blog-card.blade.php         — Blog listing card
│   │   ├── service-card.blade.php      — Service card
│   │   ├── team-card.blade.php         — Team member card
│   │   └── testimonial-card.blade.php  — Testimonial card
│   │
│   ├── media/
│   │   ├── image.blade.php             — Optimized image with WebP
│   │   ├── gallery.blade.php           — Image gallery/slider
│   │   └── lightbox.blade.php          — Lightbox overlay
│   │
│   └── common/
│       ├── pagination.blade.php        — Pagination component
│       ├── social-share.blade.php      — Social sharing buttons
│       ├── seo-schema.blade.php        — Structured data injection
│       └── cookie-consent.blade.php    — GDPR cookie consent
│
├── pages/
│   ├── home.blade.php                   — /
│   ├── about.blade.php                  — /about
│   ├── portfolio/
│   │   ├── index.blade.php              — /portfolio
│   │   └── show.blade.php               — /portfolio/{slug}
│   ├── services/
│   │   ├── index.blade.php              — /services
│   │   └── show.blade.php               — /services/{slug}
│   ├── blog/
│   │   ├── index.blade.php              — /blog
│   │   └── show.blade.php               — /blog/{slug}
│   ├── team/
│   │   ├── index.blade.php              — /team
│   │   └── show.blade.php               — /team/{slug}
│   ├── faq.blade.php                    — /faq
│   ├── contact.blade.php                — /contact
│   └── page.blade.php                   — /{slug} (dynamic pages)
│
└── layouts/
    └── filament.php                     — Filament panel override (optional)
```

## 4. Controller Architecture

```
app/Http/Controllers/
├── Public/
│   ├── HomeController.php                  — /
│   ├── AboutController.php                 — /about
│   ├── PortfolioController.php             — /portfolio, /portfolio/{slug}
│   ├── ServiceController.php               — /services, /services/{slug}
│   ├── BlogController.php                  — /blog, /blog/{slug}
│   ├── TeamController.php                  — /team, /team/{slug}
│   ├── FAQController.php                   — /faq
│   ├── ContactController.php               — /contact (GET + POST)
│   ├── PageController.php                  — /{slug} dynamic pages
│   └── SitemapController.php               — /sitemap.xml
```

## 5. Route Definitions

```php
// web.php — Public Routes

// Home
Route::get('/', [HomeController::class, 'index'])->name('home');

// Pages
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/faq', [FAQController::class, 'index'])->name('faq');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Portfolio
Route::get('/portfolio', [PortfolioController::class, 'index'])->name('portfolio.index');
Route::get('/portfolio/{project:slug}', [PortfolioController::class, 'show'])->name('portfolio.show');

// Services
Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
Route::get('/services/{service:slug}', [ServiceController::class, 'show'])->name('services.show');

// Team
Route::get('/team', [TeamController::class, 'index'])->name('team.index');
Route::get('/team/{teamMember:slug}', [TeamController::class, 'show'])->name('team.show');

// Blog
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{blogPost:slug}', [BlogController::class, 'show'])->name('blog.show');

// Dynamic Pages (must be last to avoid route conflicts)
Route::get('/{page:slug}', [PageController::class, 'show'])->name('page.show');

// Sitemap
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');
```

## 6. SEO Metadata Implementation

### 6.1 Per-Page SEO

Every public page loads SEO metadata from the `seo_metadata` polymorphic table:

```
Page Schema:
  meta_title        → <title> tag
  meta_description  → <meta name="description">
  meta_keywords     → <meta name="keywords">
  og_title          → <meta property="og:title">
  og_description    → <meta property="og:description">
  og_image          → <meta property="og:image">
  canonical_url     → <link rel="canonical">
  noindex           → <meta name="robots" content="noindex">
  nofollow          → <meta name="robots" content="nofollow">
```

### 6.2 Automated Schema.org

```json
{
  "@context": "https://schema.org",
  "@type": "Organization",
  "name": "Hunkie Productions",
  "url": "https://hunkieproductions.com",
  "logo": "https://hunkieproductions.com/images/logo.png",
  "sameAs": [
    "https://facebook.com/hunkieproductions",
    "https://instagram.com/hunkieproductions",
    "https://linkedin.com/company/hunkieproductions"
  ]
}
```

Additional schemas per page type:
- **Portfolio Detail** → `CreativeWork` schema
- **Blog Post** → `Article` or `BlogPosting` schema
- **Service** → `Service` schema
- **FAQ** → `FAQPage` schema
- **Team** → `Person` schema

## 7. Lead Tracking & Analytics

### 7.1 UTM Parameter Tracking

The Contact form and any lead-capture forms include hidden fields for:

| Field | Source |
|-------|--------|
| `utm_source` | URL query parameter |
| `utm_medium` | URL query parameter |
| `utm_campaign` | URL query parameter |
| `referer_url` | `document.referrer` (via JS) |
| `landing_page` | Current page URL (via JS) |

### 7.2 Page View Tracking

Middleware-based page view tracking:

```php
// TrackPageView middleware
// Records: page_url, page_title, referer_url, user_agent,
//          ip_address (hashed), session_id, utm params
// Stored in: page_views table (async via queue)
```

## 8. Performance Optimizations

| Technique | Implementation |
|-----------|---------------|
| Image Optimization | WebP conversion via Spatie Media Library |
| Lazy Loading | `loading="lazy"` on all images below the fold |
| Caching | Cache navigation, settings, services for 24h |
| CSS | Tailwind CSS v4 purged in production |
| JS | Minimal JS — no framework, Alpine.js on demand |
| Font | Instrument Sans via self-hosted woff2 files |
| Preconnect | DNS prefetch for external resources |
| Critical CSS | Inline critical CSS for above-fold content |
