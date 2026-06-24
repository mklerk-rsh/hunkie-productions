# Hunkie Productions — Implementation Roadmap

## Phase Overview

| Phase | Name | Duration | Output |
|-------|------|----------|--------|
| 0 | Foundation | 1 day | Project setup, auth, admin panel |
| 1 | Core Data Models | 3 days | All migrations, models, relationships |
| 2 | Admin Panel — Content | 5 days | All content Filament resources |
| 3 | Admin Panel — Operations | 3 days | Leads, contacts, settings, menus |
| 4 | Public Website | 5 days | All public pages and components |
| 5 | Features & Integration | 4 days | SEO, analytics, notifications, media |
| 6 | Testing & Polish | 3 days | Testing, performance, deployment prep |
| **Total** | | **24 days** | |

---

## Phase 0: Foundation (Day 1)

### Goals
- Configure Laravel and Filament panel
- Set up Spatie packages
- Establish auth and RBAC structure

### Tasks

| # | Task | Details |
|---|------|---------|
| 0.1 | Environment setup | Verify .env, DB connection, APP_KEY |
| 0.2 | Install Filament panel | `php artisan filament:install --panels` |
| 0.3 | Configure Admin panel | Set path `/admin`, middleware, brand, theme |
| 0.4 | Publish Spatie migrations | `php artisan vendor:publish` for permission, media library, activitylog |
| 0.5 | Run initial migrations | All package migrations |
| 0.6 | Update User model | Add `HasRoles` trait, `HasMedia` trait |
| 0.7 | Create Super Admin seeder | Seed default roles and super admin user |
| 0.8 | Configure Filament auth | Set up login page, email verification |
| 0.9 | Create base Filament resources | UserResource, RoleResource (crud generators) |
| 0.10 | Verify admin login | Test authentication and role assignment |

### Deliverables
- Working admin panel at `/admin`
- Super Admin user can log in
- Roles & Permissions structure operational
- User management functional

---

## Phase 1: Core Data Models (Days 2-4)

### Goals
- Create all database migrations
- Build all Eloquent models with relationships
- Establish service layer foundation

### Tasks

| # | Task | Details |
|---|------|---------|
| 1.1 | Create migrations | All 17 new tables (see DATABASE_ERD.md) |
| 1.2 | Run migrations in order | Execute all new migrations |
| 1.3 | Create Model classes | One model per table |
| 1.4 | Define relationships | All belongsTo, hasMany, belongsToMany, morphMany |
| 1.5 | Add Global Scopes | Published scope for projects, blog posts |
| 1.6 | Add Local Scopes | Featured scope, ordered scope, active scope |
| 1.7 | Add Accessors/Mutators | Slug generation, date formatting, excerpt truncation |
| 1.8 | Implement Traits | `HasSEO`, `HasActivityLog`, `HasMediaCollections` |
| 1.9 | Create Enums | `ProjectStatus`, `LeadStatus`, `LeadSource` |
| 1.10 | Create Form Requests | Validation rules for all models |
| 1.11 | Create Repository classes | For complex queries on projects, blog, leads |
| 1.12 | Create Service classes | Stubs for all 10 services |

### Deliverables
- All tables created with proper indexes
- All models with complete relationships
- Reusable traits for SEO, media, activity logging
- Enum classes for status fields
- Service layer skeleton

---

## Phase 2: Admin Panel — Content (Days 5-9)

### Goals
- Build all content management Filament resources
- Implement media library integration
- Build SEO metadata management

### Tasks

| # | Task | Details |
|---|------|---------|
| 2.1 | ProjectResource | Full CRUD + media upload + categories + SEO |
| 2.2 | ServiceResource | Full CRUD + icon + media + ordering |
| 2.3 | TeamMemberResource | Full CRUD + photo + social links + ordering |
| 2.4 | TestimonialResource | Full CRUD + avatar + approval + rating |
| 2.5 | FAQResource | Full CRUD + categorization + ordering |
| 2.6 | CategoryResource | CRUD + ordering |
| 2.7 | BlogCategoryResource | CRUD |
| 2.8 | TagResource | CRUD + usage count |
| 2.9 | BlogPostResource | Full CRUD + rich editor + media + tags + SEO |
| 2.10 | PageResource | Full CRUD + rich editor + layout + SEO |
| 2.11 | Implement Global Search | Search across projects, blog, pages |
| 2.12 | Add Activity Log | `LogsActivity` on all content models |
| 2.13 | Add Filament notifications | Toast notifications on CRUD operations |
| 2.14 | Create custom form components | Media picker, SEO fields group |

### Deliverables
- 10 complete Filament resources
- Rich text editing with media insertion
- Activity logging on all content changes
- SEO metadata editing within each resource

---

## Phase 3: Admin Panel — Operations (Days 10-12)

### Goals
- Build lead management system
- Implement contact management
- Build settings, menus, notifications
- Create admin dashboard

### Tasks

| # | Task | Details |
|---|------|---------|
| 3.1 | LeadResource | Full CRUD + status workflow + assignment |
| 3.2 | Lead timeline widget | Activity feed on lead detail page |
| 3.3 | ContactResource | Read-only + search + export (CSV) |
| 3.4 | MenuResource | CRUD + menu item builder with drag-drop |
| 3.5 | SettingResource | Key-value editor with grouped tabs |
| 3.6 | ActivityLogResource | Read-only with filters (date, user, model) |
| 3.7 | Dashboard widgets | Stats overview, charts, recent tables |
| 3.8 | Notification preference | User notification settings |
| 3.9 | Queue configuration | Configure database queue + worker |
| 3.10 | NotificationResource | View in-app notifications |

### Deliverables
- Complete lead management pipeline
- Menu builder with nested items
- Settings management interface
- Dashboard with real-time stats
- Activity log viewer

---

## Phase 4: Public Website (Days 13-17)

### Goals
- Build all public-facing pages
- Implement navigation and layout
- Create contact form with lead capture
- Implement SEO across all pages

### Tasks

| # | Task | Details |
|---|------|---------|
| 4.1 | Main layout | Full layout with navigation + footer + SEO head |
| 4.2 | Navigation component | Dynamic menu from menus table |
| 4.3 | Footer component | Dynamic footer with menus + social links |
| 4.4 | Home page | Hero + featured projects + services + testimonials + CTA |
| 4.5 | Portfolio index | Filterable project grid with categories |
| 4.6 | Portfolio detail | Gallery/slider + content + project info |
| 4.7 | Services index | Services grid |
| 4.8 | Service detail | Full service content |
| 4.9 | Team index | Team member cards |
| 4.10 | About page | Company story + stats |
| 4.11 | Blog index | Blog grid + sidebar with categories/tags |
| 4.12 | Blog detail | Full article + share buttons |
| 4.13 | FAQ page | Accordion component |
| 4.14 | Contact page | Form + company info + map |
| 4.15 | Dynamic pages | Generic CMS page renderer |
| 4.16 | Contact form validation | Server + client side, honeypot, rate limiting |
| 4.17 | Contact form submission | Store lead + dispatch events |
| 4.18 | Breadcrumb component | Dynamic breadcrumbs |
| 4.19 | Sitemap controller | Dynamic sitemap.xml |
| 4.20 | Robots.txt | Dynamic robots.txt |

### Deliverables
- Complete public website with all pages
- Dynamic navigation from admin panel
- Functional contact form capturing leads
- SEO metadata rendering on all pages
- Sitemap generation

---

## Phase 5: Features & Integration (Days 18-21)

### Goals
- Implement notification system
- Build analytics/lead tracking
- Add WhatsApp integration
- Implement advanced media features

### Tasks

| # | Task | Details |
|---|------|---------|
| 5.1 | NotificationService | Multi-channel notification dispatch |
| 5.2 | Email notifications | New lead, contact subscription, blog published |
| 5.3 | Database notifications | In-app notification center |
| 5.4 | Event/Listener setup | All events + listeners |
| 5.5 | Job classes | SendEmail, ProcessMedia, GenerateSitemap |
| 5.6 | Page view tracking | TrackPageView middleware + queue |
| 5.7 | UTM parameter capture | Hidden fields + JS in contact form |
| 5.8 | Lead scoring | Basic scoring algorithm |
| 5.9 | WhatsApp channel research | Twilio/WhatsApp API setup |
| 5.10 | WhatsApp lead notification | Send lead details via WhatsApp |
| 5.11 | Image optimization | WebP conversion, responsive images |
| 5.12 | Media library browser | Global media browser in admin |
| 5.13 | SEO sitemap | Dynamic XML sitemap with priorities |
| 5.14 | Schema.org data | Structured data on all page types |
| 5.15 | Open Graph images | Auto-generated OG images (future) |

### Deliverables
- Complete notification system (email + database)
- Page view analytics with UTM tracking
- WhatsApp integration for lead notifications
- Media optimization pipeline
- Full SEO implementation with structured data

---

## Phase 6: Testing & Polish (Days 22-24)

### Goals
- Comprehensive test coverage
- Performance optimization
- Security audit
- Deployment preparation

### Tasks

| # | Task | Details |
|---|------|---------|
| 6.1 | Model tests | All relationships, scopes, accessors |
| 6.2 | Service tests | All service methods |
| 6.3 | Controller tests | All public routes |
| 6.4 | Feature tests | Contact form submission, lead workflow |
| 6.5 | Filament resource tests | Form submission, validation |
| 6.6 | Notification tests | All notification channels |
| 6.7 | Permission tests | All role/permission combinations |
| 6.8 | Performance audit | Query optimization, N+1 fixes |
| 6.9 | Image optimization | Verify all conversions |
| 6.10 | Security audit | CSRF, XSS, SQL injection, auth checks |
| 6.11 | SEO audit | Meta tags, schema, sitemap validator |
| 6.12 | Accessibility check | WCAG 2.1 AA compliance |
| 6.13 | Documentation | Finalize technical documentation |
| 6.14 | Deployment prep | Environment config, migration strategy |
| 6.15 | Final QA | Full walkthrough of all features |

### Deliverables
- Test suite with >80% coverage
- Performance-optimized application
- Security-hardened deployment
- Production-ready documentation

---

## Migration Order (Detailed)

```bash
# Phase 0 — Foundation
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider" --tag="migrations"
php artisan vendor:publish --provider="Spatie\MediaLibrary\MediaLibraryServiceProvider" --tag="migrations"
php artisan vendor:publish --provider="Spatie\Activitylog\ActivitylogServiceProvider" --tag="migrations"
php artisan migrate

# Phase 1 — Master Data
php artisan make:migration create_settings_table
php artisan make:migration create_categories_table
php artisan make:migration create_blog_categories_table
php artisan make:migration create_tags_table
php artisan make:migration create_menus_table
php artisan make:migration create_menu_items_table

# Phase 2 — Content
php artisan make:migration create_projects_table
php artisan make:migration create_project_categories_table
php artisan make:migration create_services_table
php artisan make:migration create_team_members_table
php artisan make:migration create_testimonials_table
php artisan make:migration create_faqs_table
php artisan make:migration create_blog_posts_table
php artisan make:migration create_blog_post_tag_table
php artisan make:migration create_pages_table

# Phase 3 — Operations
php artisan make:migration create_leads_table
php artisan make:migration create_contacts_table

# Phase 4 — SEO & Analytics
php artisan make:migration create_seo_metadata_table
php artisan make:migration create_page_views_table
```

## Seeding Strategy

```bash
# Seeders (in order)
DatabaseSeeder.php
├── RoleAndPermissionSeeder.php      # Default roles + permissions
├── AdminUserSeeder.php              # Super admin account
├── CategorySeeder.php               # Sample categories
├── BlogCategorySeeder.php           # Sample blog categories
├── TagSeeder.php                    # Sample tags
├── SettingSeeder.php                # Default settings
└── MenuSeeder.php                   # Default navigation structure
```

## Key Dependencies

| Phase | Blocked By | Description |
|-------|-----------|-------------|
| Phase 1 | Phase 0 | Need working DB + packages |
| Phase 2 | Phase 1 | Need models + migrations |
| Phase 3 | Phase 2 | Admin must be functional |
| Phase 4 | Phase 1 | Need models for data |
| Phase 4 | Phase 3 | Settings and menus via admin |
| Phase 5 | Phase 4 | Public website must be live |
| Phase 6 | All | Everything must exist |

## Effort Distribution

```
Phase 0:   ██░░░░░░░░  4%
Phase 1:   ███████░░░  13%
Phase 2:   ██████████  21%
Phase 3:   ██████░░░░  13%
Phase 4:   ██████████  21%
Phase 5:   ████████░░  17%
Phase 6:   ██████░░░░  13%
```
