# Hunkie Productions — System Architecture

## 1. High-Level Architecture

```
┌─────────────────────────────────────────────────────────────────────┐
│                        PUBLIC WEBSITE                               │
│  ┌──────────┐  ┌──────────┐  ┌──────────┐  ┌───────────────────┐   │
│  │ Landing  │  │ Portfolio│  │  Blog    │  │   Contact Form    │   │
│  │ Page     │  │ Gallery  │  │          │  │                   │   │
│  └──────────┘  └──────────┘  └──────────┘  └───────────────────┘   │
└──────────────────────────────┬──────────────────────────────────────┘
                               │ HTTP
┌──────────────────────────────▼──────────────────────────────────────┐
│                      LARAVEL APPLICATION                            │
│                                                                      │
│  ┌──────────────┐  ┌──────────────┐  ┌────────────────────────┐    │
│  │   Web Routes │  │  Controllers │  │       Middleware        │    │
│  │  (web.php)   │──▶   (Public)  │──▶   web, auth, role      │    │
│  └──────────────┘  └──────┬───────┘  └────────────────────────┘    │
│                           │                                          │
│  ┌──────────────┐  ┌──────▼───────┐  ┌────────────────────────┐    │
│  │ Filament     │  │   Service    │  │     Validation         │    │
│  │ Panel Routes │──▶   Layer      │──▶        Rules           │    │
│  └──────────────┘  └──────┬───────┘  └────────────────────────┘    │
│                           │                                          │
│                    ┌──────▼───────┐                                  │
│                    │  Repository  │                                  │
│                    │    Layer     │                                  │
│                    └──────┬───────┘                                  │
│                           │                                          │
│                    ┌──────▼───────┐                                  │
│                    │   Eloquent   │                                  │
│                    │   Models     │                                  │
│                    └──────┬───────┘                                  │
└───────────────────────────┼──────────────────────────────────────────┘
                            │
┌───────────────────────────▼──────────────────────────────────────────┐
│                       DATA LAYER                                     │
│                                                                      │
│  ┌──────────┐  ┌──────────┐  ┌──────────┐  ┌──────────────────┐    │
│  │  MySQL   │  │  Storage │  │  Queue   │  │     Cache        │    │
│  │  (hps_db)│  │  Files   │  │  (jobs)  │  │    (database)    │    │
│  └──────────┘  └──────────┘  └──────────┘  └──────────────────┘    │
└──────────────────────────────────────────────────────────────────────┘
```

## 2. Application Layers

### 2.1 Presentation Layer

| Component | Technology | Responsibility |
|-----------|-----------|----------------|
| Public Website | Blade + Tailwind CSS 4 | All user-facing pages |
| Admin Panel | Filament 5.6 (Livewire) | All administrative interfaces |
| API | Laravel (if needed future) | JSON endpoints for external integrations |

### 2.2 Application Layer

| Component | Responsibility |
|-----------|---------------|
| Controllers | HTTP request handling, validation delegation, response generation |
| Form Requests | Request validation and authorization logic |
| Service Classes | Business logic orchestration, no direct HTTP dependencies |
| Repository Classes | Complex query abstraction, data retrieval optimization |
| Actions | Single-responsibility operations (e.g., `ProcessLeadAction`) |
| Events/Listeners | Decoupled side-effect handling (notifications, logging) |
| Jobs | Deferred processing (media conversions, email sending) |

### 2.3 Domain Layer

| Component | Responsibility |
|-----------|---------------|
| Eloquent Models | Data representation, relationships, local scopes, accessors/mutators |
| Enums | Type-safe constants for statuses, types, roles |
| Traits | Reusable model behaviors (e.g., `HasSEO`, `HasActivityLog`) |
| Casts | Value object transformation |

### 2.4 Infrastructure Layer

| Component | Technology |
|-----------|-----------|
| Database | MySQL 8 |
| File Storage | Local (with S3 migration path) |
| Queue | Database driver |
| Cache | Database driver |
| Session | Database driver |

## 3. Package Integration Architecture

```
┌──────────────────────────────────────────────────────────────────────┐
│                      SPATIE PERMISSION 8                            │
│  ┌────────────┐  ┌────────────┐  ┌────────────────────────────┐    │
│  │  Roles     │  │Permissions │  │  User <-> Role <-> Perm   │    │
│  │  Table     │  │   Table    │  │   Pivot Tables            │    │
│  └────────────┘  └────────────┘  └────────────────────────────┘    │
│  Trait: HasRoles (User model)                                       │
│  Gates & Policies for authorization                                 │
└──────────────────────────────────────────────────────────────────────┘

┌──────────────────────────────────────────────────────────────────────┐
│                   SPATIE MEDIA LIBRARY 11                           │
│  ┌────────────┐  ┌────────────┐  ┌────────────────────────────┐    │
│  │  Media     │  │ Conversions│  │  Collections (images,      │    │
│  │  Table     │  │   (sizes)  │  │   documents, videos)       │    │
│  └────────────┘  └────────────┘  └────────────────────────────┘    │
│  Trait: HasMedia (Project, TeamMember, BlogPost, Service)          │
│  Conversions: thumb (150x150), preview (800x), hero (1920x)        │
└──────────────────────────────────────────────────────────────────────┘

┌──────────────────────────────────────────────────────────────────────┐
│                   SPATIE ACTIVITYLOG 5                              │
│  ┌────────────┐  ┌────────────┐  ┌────────────────────────────┐    │
│  │activity_log│  │  Loggers   │  │  Activity Log Provider     │    │
│  │   Table    │  │ (per model)│  │  (Filament Panel)          │    │
│  └────────────┘  └────────────┘  └────────────────────────────┘    │
│  Trait: LogsActivity (all main models)                              │
└──────────────────────────────────────────────────────────────────────┘

┌──────────────────────────────────────────────────────────────────────┐
│                    INTERVENTION IMAGE 4.1                          │
│  ┌────────────┐  ┌────────────┐  ┌────────────────────────────┐    │
│  │ Image      │  │  Resize    │  │  Optimization              │    │
│  │ Manager    │  │  Crop/Fit  │  │  WebP conversion           │    │
│  └────────────┘  └────────────┘  └────────────────────────────┘    │
│  Used by Spatie Media Library conversions                           │
└──────────────────────────────────────────────────────────────────────┘

┌──────────────────────────────────────────────────────────────────────┐
│                     FILAMENT 5.6                                    │
│  ┌────────────┐  ┌────────────┐  ┌────────────┐  ┌──────────────┐ │
│  │ Resources  │  │ Pages      │  │ Widgets    │  │ Forms/Tables │ │
│  └────────────┘  └────────────┘  └────────────┘  └──────────────┘ │
│  Panel: Admin (https://example.com/admin)                           │
│  Middleware: web, auth, verified, role:admin                       │
└──────────────────────────────────────────────────────────────────────┘
```

## 4. Request Lifecycle

### 4.1 Public Website Request

```
Browser → HTTP Request → Laravel → Middleware (web, session, CSRF)
  → Route → Public Controller → Service Layer → Repository (if needed)
  → Eloquent → Database → Response (Blade view) → Browser
```

### 4.2 Admin Panel Request

```
Browser → HTTP Request → Laravel → Middleware (web, auth, verified)
  → Filament Panel → Filament Resource → Form/Tables → Eloquent
  → Authorization (Gates/Policies) → Database → Response (Livewire) → Browser
```

### 4.3 Form Submission with Side Effects

```
Browser → POST Request → Controller/Form → Validation → Service
  → Database Write → Dispatch Event → Listeners
    ├── LogActivityListener → Activity Log
    ├── SendNotificationListener → Database Notification
    ├── SendEmailListener → Queue → Mail
    └── (Future) WhatsAppNotificationListener → Queue → WhatsApp
  → Response → Browser
```

## 5. Service Layer Architecture

Each service is a stateless class injected via Laravel's service container.

```
App\Services\
├── ProjectService.php         — Project CRUD, status transitions
├── LeadService.php            — Lead intake, scoring, assignment
├── BlogService.php            — Blog post management, archive queries
├── MediaService.php           — Media uploads, conversions, cleanup
├── SEOService.php             — Meta tag generation, structured data
├── NotificationService.php    — Multi-channel notification dispatch
├── ContactService.php         — Contact form processing, subscription
├── AnalyticsService.php       — Page view tracking, lead source attribution
├── MenuService.php            — Menu builder and renderer
├── SettingsService.php        — Site-wide configuration retrieval
└── TeamMemberService.php      — Team management, ordering
```

## 6. Action Classes (Single Responsibility)

```
App\Actions\
├── ProcessLeadAction.php        — Parse lead data, assign score, set source
├── AssignLeadAction.php         — Assign lead to team member
├── ConvertMediaAction.php       — Run media conversions after upload
├── GenerateSitemapAction.php    — Regenerate sitemap on content change
├── SyncSEOMetadataAction.php    — Update SEO metadata for a model
├── SendWelcomeEmailAction.php   — Send welcome to new contacts
└── LogUserActivityAction.php    — Log authenticated user actions
```

## 7. Security Architecture

```
┌──────────────────────────────────────────────────────────────────────┐
│                      SECURITY LAYERS                                │
│                                                                      │
│  ┌─────────────────────────────────────────────────────────────┐    │
│  │  Layer 1: Authentication (Laravel built-in)                   │    │
│  │  - Session-based auth via 'web' guard                        │    │
│  │  - Email/password login                                      │    │
│  │  - Email verification                                        │    │
│  └─────────────────────────────────────────────────────────────┘    │
│                                                                      │
│  ┌─────────────────────────────────────────────────────────────┐    │
│  │  Layer 2: Authorization (Spatie Permission)                  │    │
│  │  - Role-based access for admin panel                         │    │
│  │  - Permission-based gates for specific actions               │    │
│  │  - Filament resource authorization via policies             │    │
│  └─────────────────────────────────────────────────────────────┘    │
│                                                                      │
│  ┌─────────────────────────────────────────────────────────────┐    │
│  │  Layer 3: Validation                                         │    │
│  │  - Form Request validation for all public submissions        │    │
│  │  - Filament form validation for admin inputs                 │    │
│  │  - Honeypot + time-based for Contact Form (bot protection)  │    │
│  └─────────────────────────────────────────────────────────────┘    │
│                                                                      │
│  ┌─────────────────────────────────────────────────────────────┐    │
│  │  Layer 4: Data Protection                                    │    │
│  │  - CSRF tokens on all forms                                  │    │
│  │  - XSS protection via Blade escaping                         │    │
│  │  - SQL injection via Eloquent parameter binding              │    │
│  │  - Mass assignment protection via Eloquent models            │    │
│  └─────────────────────────────────────────────────────────────┘    │
└──────────────────────────────────────────────────────────────────────┘
```

## 8. Media Storage Strategy

```
storage/
├── app/
│   ├── public/
│   │   ├── media/              # Spatie Media Library uploads
│   │   │   ├── images/
│   │   │   ├── videos/
│   │   │   ├── documents/
│   │   │   └── conversions/    # Generated thumbnails/resizes
│   │   └── seo/                # Generated sitemaps, robots.txt
│   └── private/
│       └── exports/            # Generated reports, exports
└── logs/
```

**Conversion Presets (Spatie Media Library):**

| Conversion | Dimensions | Quality | Format |
|-----------|-----------|---------|--------|
| `thumb` | 150x150 (crop) | 80% | WebP |
| `preview` | 800x600 (fit) | 85% | WebP |
| `hero` | 1920x1080 (fit) | 90% | WebP |
| `og-image` | 1200x630 (crop) | 85% | WebP |

## 9. Queue Architecture

```
DISPATCHER                          QUEUE (database)              WORKER
┌──────────┐   ┌──────────────┐   ┌────────────────────┐   ┌───────────┐
│ Job      │──▶│ ShouldQueue  │──▶│ jobs table         │──▶│ Queue     │
│ Dispatch │   └──────────────┘   │                    │   │ Worker    │
└──────────┘                      │ - Notifications    │   └───────────┘
                                  │ - Media Conversions│
Queued Jobs:                      │ - Email Sending    │
- SendLeadNotification            │ - Sitemap Generate │
- ProcessMediaConversion          │ - Activity Logging │
- SendContactEmail                └────────────────────┘
- GenerateSitemap
- LogActivity
- SyncSEOData
```

## 10. Caching Strategy

| Cache Key Pattern | TTL | Store | Purpose |
|------------------|-----|-------|---------|
| `navigation.{locale}` | 1 day | database | Menu structure |
| `settings.all` | 1 day | database | Site settings |
| `services.published` | 1 hour | database | Active services |
| `projects.featured` | 1 hour | database | Featured projects |
| `team.published` | 1 day | database | Published team members |
| `testimonials.published` | 1 day | database | Approved testimonials |
| `seo.{model}_{id}` | 1 day | database | SEO metadata |
