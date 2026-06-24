# Hunkie Productions — Database ERD & Schema Design

## 1. Entity Relationship Diagram (Text)

```
┌─────────────────────────────────────────────────────────────────────────────────────────┐
│                                      DATABASE: hps_db                                    │
│                                                                                           │
│  ┌─────────────┐     ┌──────────────────────┐     ┌──────────────────────┐              │
│  │    roles    │     │    model_has_roles    │     │       users          │              │
│  ├─────────────┤     ├──────────────────────┤     ├──────────────────────┤              │
│  │ id          │◄────┤ role_id              │     │ id                   │              │
│  │ name        │     │ model_type            │─────►│ name                 │              │
│  │ guard_name  │     │ model_id              │     │ email (unique)       │              │
│  │ created_at  │     └──────────────────────┘     │ email_verified_at    │              │
│  │ updated_at  │     ┌──────────────────────┐     │ password             │              │
│  └──────┬──────┘     │ role_has_permissions │     │ remember_token       │              │
│         │            ├──────────────────────┤     │ is_admin (bool)      │              │
│  ┌──────▼──────┐     │ role_id              │     │ is_active (bool)     │              │
│  │ permissions │     │ permission_id         │     │ created_at           │              │
│  ├─────────────┤     └──────┬───────────────┘     │ updated_at           │              │
│  │ id          │            │                      └──────────┬───────────┘              │
│  │ name        │            │                                 │                          │
│  │ guard_name  │     ┌──────▼───────────────┐                 │                          │
│  │ created_at  │     │  model_has_permissions│                │                          │
│  │ updated_at  │     ├──────────────────────┤                 │                          │
│  └─────────────┘     │ permission_id        │                 │                          │
│                      │ model_type            │                 │                          │
│                      │ model_id              │                 │                          │
│                      └──────────────────────┘                 │                          │
│                                                               │                          │
│                   ┌───────────────────────────────────────────┘                          │
│                   │                                                                      │
│                   │      ┌──────────────────┐  ┌──────────────────┐                      │
│                   │      │      leads        │  │    contacts      │                      │
│                   │      ├──────────────────┤  ├──────────────────┤                      │
│                   │      │ id               │  │ id               │                      │
│                   │      │ name             │  │ email (unique)   │                      │
│                   │      │ email            │  │ name             │                      │
│                   │      │ phone            │  │ phone            │                      │
│                   │      │ company          │  │ source            │                      │
│                   │      │ message (text)   │  │ subscribed (bool) │                      │
│                   │      │ service_interest │  │ opted_in (bool)   │                      │
│                   │      │ source            │  │ created_at        │                      │
│                   │      │ utm_source        │  │ updated_at        │                      │
│                   │      │ utm_medium        │  └──────────────────┘                      │
│                   │      │ utm_campaign      │                                            │
│                   │      │ status (enum)     │                                            │
│                   │      │ lead_score (int)  │                                            │
│                   │      │ assigned_to ──────┼──────┐                                     │
│                   │      │ notes (text)      │      │                                     │
│                   │      │ created_at        │      │                                     │
│                   │      │ updated_at        │      │                                     │
│                   │      └──────────────────┘      │                                     │
│                   │                                 │                                     │
│  ┌────────────────┼─────────────────────────────────┼────────────────────────────────┐    │
│  │                │                                 │                                │    │
│  │  ┌─────────────▼──────────┐   ┌──────────────────▼───────────┐                   │    │
│  │  │       projects         │   │      team_members             │                   │    │
│  │  ├────────────────────────┤   ├──────────────────────────────┤                   │    │
│  │  │ id                     │   │ id                           │                   │    │
│  │  │ title                  │   │ name                         │                   │    │
│  │  │ slug (unique)          │   │ slug (unique)                │                   │    │
│  │  │ description (text)     │   │ position (job title)         │                   │    │
│  │  │ content (longtext)     │   │ bio (text)                   │                   │    │
│  │  │ client_name            │   │ email                        │                   │    │
│  │  │ project_date (date)    │   │ phone                        │                   │    │
│  │  │ completion_year (year) │   │ display_order (int)          │                   │    │
│  │  │ url (nullable)         │   │ is_active (bool)             │                   │    │
│  │  │ is_featured (bool)     │   │ created_at                   │                   │    │
│  │  │ status (enum)          │   │ updated_at                   │                   │    │
│  │  │ published_at           │   └──────────────────────────────┘                   │    │
│  │  │ created_at             │                                                      │    │
│  │  │ updated_at             │                                                      │    │
│  │  └────────────┬───────────┘                                                      │    │
│  │               │                                                                  │    │
│  │  ┌────────────▼───────────┐   ┌──────────────────────────────┐                  │    │
│  │  │   project_categories   │   │        testimonials           │                  │    │
│  │  ├────────────────────────┤   ├──────────────────────────────┤                  │    │
│  │  │ project_id             │   │ id                           │                  │    │
│  │  │ category_id            │   │ client_name                  │                  │    │
│  │  └────────────┬───────────┘   │ client_company               │                  │    │
│  │               │               │ content (text)               │                  │    │
│  │  ┌────────────▼───────────┐   │ rating (int, 1-5)            │                  │    │
│  │  │       categories       │   │ is_featured (bool)           │                  │    │
│  │  ├────────────────────────┤   │ is_approved (bool)           │                  │    │
│  │  │ id                     │   │ display_order (int)          │                  │    │
│  │  │ name                   │   │ created_at                   │                  │    │
│  │  │ slug (unique)          │   │ updated_at                   │                  │    │
│  │  │ description (nullable) │   └──────────────────────────────┘                  │    │
│  │  │ is_active (bool)       │                                                      │    │
│  │  │ display_order (int)    │                                                      │    │
│  │  │ created_at             │                                                      │    │
│  │  │ updated_at             │                                                      │    │
│  │  └────────────────────────┘                                                      │    │
│  │                                                                                  │    │
│  │  ┌────────────────────────┐   ┌──────────────────────────────┐                  │    │
│  │  │       services         │   │        faqs                   │                  │    │
│  │  ├────────────────────────┤   ├──────────────────────────────┤                  │    │
│  │  │ id                     │   │ id                           │                  │    │
│  │  │ name                   │   │ question                     │                  │    │
│  │  │ slug (unique)          │   │ answer (text)                │                  │    │
│  │  │ description (text)     │   │ category (nullable)          │                  │    │
│  │  │ content (longtext)     │   │ display_order (int)          │                  │    │
│  │  │ icon (string)          │   │ is_published (bool)          │                  │    │
│  │  │ is_featured (bool)     │   │ created_at                   │                  │    │
│  │  │ display_order (int)    │   │ updated_at                   │                  │    │
│  │  │ created_at             │   └──────────────────────────────┘                  │    │
│  │  │ updated_at             │                                                      │    │
│  │  └────────────────────────┘                                                      │    │
│  │                                                                                  │    │
│  │  ┌────────────────────────┐   ┌──────────────────────────────┐                  │    │
│  │  │      blog_posts        │   │      blog_categories         │                  │    │
│  │  ├────────────────────────┤   ├──────────────────────────────┤                  │    │
│  │  │ id                     │   │ id                           │                  │    │
│  │  │ title                  │   │ name                         │                  │    │
│  │  │ slug (unique)          │   │ slug (unique)                │                  │    │
│  │  │ content (longtext)     │   │ description (nullable)      │                  │    │
│  │  │ excerpt (text)         │   │ is_active (bool)             │                  │    │
│  │  │ author_id ─────────────┼───►│ created_at                   │                  │    │
│  │  │ blog_category_id ──────┼───►│ updated_at                   │                  │    │
│  │  │ is_published (bool)    │   └──────────────────────────────┘                  │    │
│  │  │ published_at           │   ┌──────────────────────────────┐                  │    │
│  │  │ is_featured (bool)     │   │        tags                   │                  │    │
│  │  │ created_at             │   ├──────────────────────────────┤                  │    │
│  │  │ updated_at             │   │ id                           │                  │    │
│  │  └───────────┬────────────┘   │ name                         │                  │    │
│  │              │                │ slug (unique)                │                  │    │
│  │  ┌───────────▼────────────┐   │ created_at                   │                  │    │
│  │  │  blog_post_tag         │   │ updated_at                   │                  │    │
│  │  ├────────────────────────┤   └──────────────────────────────┘                  │    │
│  │  │ blog_post_id           │   ┌──────────────────────────────┐                  │    │
│  │  │ tag_id                 │   │          pages                │                  │    │
│  │  └────────────────────────┘   ├──────────────────────────────┤                  │    │
│  │                               │ id                           │                  │    │
│  │                               │ title                        │                  │    │
│  │                               │ slug (unique)                │                  │    │
│  │                               │ content (longtext)           │                  │    │
│  │                               │ is_published (bool)          │                  │    │
│  │                               │ layout (string)              │                  │    │
│  │                               │ created_at                   │                  │    │
│  │                               │ updated_at                   │                  │    │
│  │                               └──────────────────────────────┘                  │    │
│  │                                                                                  │    │
│  │  ┌────────────────────────┐   ┌──────────────────────────────┐                  │    │
│  │  │     seo_metadata       │   │     notifications             │                  │    │
│  │  ├────────────────────────┤   ├──────────────────────────────┤                  │    │
│  │  │ id                     │   │ id                           │                  │    │
│  │  │ meta_title             │   │ type (string)                │                  │    │
│  │  │ meta_description       │   │ notifiable_type              │                  │    │
│  │  │ meta_keywords          │   │ notifiable_id                │                  │    │
│  │  │ og_title               │   │ data (json)                  │                  │    │
│  │  │ og_description         │   │ read_at (nullable)           │                  │    │
│  │  │ og_image (nullable)    │   │ created_at                   │                  │    │
│  │  │ canonical_url (nullable)│  │ updated_at                   │                  │    │
│  │  │ noindex (bool)         │   └──────────────────────────────┘                  │    │
│  │  │ nofollow (bool)        │   ┌──────────────────────────────┐                  │    │
│  │  │ seoable_type            │   │       settings                │                  │    │
│  │  │ seoable_id              │   ├──────────────────────────────┤                  │    │
│  │  │ created_at              │   │ id                           │                  │    │
│  │  │ updated_at              │   │ key (unique)                 │                  │    │
│  │  └────────────────────────┘   │ value (text)                 │                  │    │
│  │                               │ group (string)               │                  │    │
│  │                               │ created_at                   │                  │    │
│  │                               │ updated_at                   │                  │    │
│  │                               └──────────────────────────────┘                  │    │
│  │                                                                                  │    │
│  │  ┌────────────────────────┐   ┌──────────────────────────────┐                  │    │
│  │  │  activity_log          │   │  page_views (for analytics)  │                  │    │
│  │  │  (spatie package)      │   ├──────────────────────────────┤                  │    │
│  │  ├────────────────────────┤   │ id                           │                  │    │
│  │  │ id                     │   │ page_url                     │                  │    │
│  │  │ log_name (nullable)    │   │ page_title                   │                  │    │
│  │  │ description            │   │ referer_url (nullable)       │                  │    │
│  │  │ subject_type            │   │ user_agent                   │                  │    │
│  │  │ event (nullable)       │   │ ip_address                   │                  │    │
│  │  │ subject_id             │   │ session_id                   │                  │    │
│  │  │ causer_type            │   │ utm_source (nullable)        │                  │    │
│  │  │ causer_id              │   │ utm_medium (nullable)        │                  │    │
│  │  │ properties (json)      │   │ utm_campaign (nullable)      │                  │    │
│  │  │ batch_uuid (nullable)   │   │ visited_at (datetime)        │                  │    │
│  │  │ created_at             │   └──────────────────────────────┘                  │    │
│  │  └────────────────────────┘   ┌──────────────────────────────┐                  │    │
│  │                               │          menus                │                  │    │
│  │  ┌────────────────────────┐   ├──────────────────────────────┤                  │    │
│  │  │      media              │   │ id                           │                  │    │
│  │  │  (spatie package)       │   │ name                         │                  │    │
│  │  ├────────────────────────┤   │ handle (unique, slug)        │                  │    │
│  │  │ id                     │   │ description (nullable)       │                  │    │
│  │  │ model_type              │   │ created_at                   │                  │    │
│  │  │ model_id               │   │ updated_at                   │                  │    │
│  │  │ uuid (unique)          │   └────────────┬─────────────────┘                  │    │
│  │  │ collection_name       │                │                                      │    │
│  │  │ name                   │   ┌────────────▼─────────────────┐                  │    │
│  │  │ file_name              │   │        menu_items             │                  │    │
│  │  │ mime_type              │   ├──────────────────────────────┤                  │    │
│  │  │ disk                   │   │ id                           │                  │    │
│  │  │ conversions_disk       │   │ menu_id                     │                  │    │
│  │  │ size                   │   │ parent_id (nullable)         │                  │    │
│  │  │ manipulations (json)  │   │ title                         │                  │    │
│  │  │ custom_properties (json)│  │ url (nullable)               │                  │    │
│  │  │ generated_conversions   │  │ route (nullable)             │                  │    │
│  │  │ responsive_images (json)│  │ target (_self/_blank)        │                  │    │
│  │  │ order_column           │   │ icon (nullable)              │                  │    │
│  │  │ created_at             │   │ is_active (bool)             │                  │    │
│  │  │ updated_at             │   │ display_order (int)          │                  │    │
│  │  └────────────────────────┘   │ created_at                   │                  │    │
│  │                               │ updated_at                   │                  │    │
│  │  (plus Laravel system tables) └──────────────────────────────┘                  │    │
│  │  users, password_reset_tokens, sessions, cache, cache_locks,                    │    │
│  │  jobs, job_batches, failed_jobs                                                 │    │
│  └──────────────────────────────────────────────────────────────────────────────────┘    │
└─────────────────────────────────────────────────────────────────────────────────────────┘
```

## 2. Complete Table Inventory

### 2.1 System Tables (Existing)

| # | Table | Purpose | Migrated |
|---|-------|---------|----------|
| 1 | `users` | System users | ✅ Existing |
| 2 | `password_reset_tokens` | Password resets | ✅ Existing |
| 3 | `sessions` | User sessions | ✅ Existing |
| 4 | `cache` | Cache store | ✅ Existing |
| 5 | `cache_locks` | Cache lock management | ✅ Existing |
| 6 | `jobs` | Queue jobs | ✅ Existing |
| 7 | `job_batches` | Job batch tracking | ✅ Existing |
| 8 | `failed_jobs` | Failed job records | ✅ Existing |

### 2.2 Package Tables (Publish + Migrate)

| # | Table | Package | Purpose |
|---|-------|---------|---------|
| 9 | `permissions` | Spatie Permission | Permission definitions |
| 10 | `roles` | Spatie Permission | Role definitions |
| 11 | `model_has_permissions` | Spatie Permission | Model-permission assignments |
| 12 | `model_has_roles` | Spatie Permission | Model-role assignments |
| 13 | `role_has_permissions` | Spatie Permission | Role-permission assignments |
| 14 | `media` | Spatie Media Library | Media file registry |
| 15 | `activity_log` | Spatie Activitylog | Activity audit trail |

### 2.3 Application Tables (New Migrations)

| # | Table | Type | Purpose |
|---|-------|------|---------|
| 16 | `categories` | Master | Portfolio categories |
| 17 | `projects` | Content | Portfolio projects |
| 18 | `project_categories` | Pivot | Project-category relationship |
| 19 | `services` | Content | Service offerings |
| 20 | `team_members` | Content | Team profiles |
| 21 | `testimonials` | Content | Client testimonials |
| 22 | `faqs` | Content | Frequently asked questions |
| 23 | `blog_categories` | Master | Blog categorization |
| 24 | `blog_posts` | Content | Blog articles |
| 25 | `tags` | Master | Content tagging |
| 26 | `blog_post_tag` | Pivot | Blog post-tag relationship |
| 27 | `leads` | Operational | Sales inquiries |
| 28 | `contacts` | Operational | Newsletter subscribers |
| 29 | `pages` | Content | CMS pages |
| 30 | `seo_metadata` | Polymorphic | SEO data for any model |
| 31 | `settings` | Configuration | Site settings |
| 32 | `menus` | Structure | Navigation menus |
| 33 | `menu_items` | Structure | Menu items |
| 34 | `notifications` | System | Database notifications |
| 35 | `page_views` | Analytics | Page view tracking |

## 3. Migration Order Plan

```
PHASE 1: SYSTEM & PACKAGES
──────────────────────────
Step 1: Create `users` table (already exists)
Step 2: Create `password_reset_tokens` table (already exists)
Step 3: Create `sessions` table (already exists)
Step 4: Create `cache` and `cache_locks` tables (already exists)
Step 5: Create `jobs`, `job_batches`, `failed_jobs` tables (already exists)
Step 6: Publish & run Spatie Permission migration (roles, permissions, pivots)
Step 7: Publish & run Spatie Media Library migration (media table)
Step 8: Publish & run Spatie Activitylog migration (activity_log table)

PHASE 2: MASTER DATA
────────────────────
Step 9: Create `settings` table
Step 10: Create `categories` table
Step 11: Create `blog_categories` table
Step 12: Create `tags` table
Step 13: Create `menus` table
Step 14: Create `menu_items` table

PHASE 3: CONTENT MODELS
──────────────────────
Step 15: Create `projects` table
Step 16: Create `project_categories` pivot table
Step 17: Create `services` table
Step 18: Create `team_members` table
Step 19: Create `testimonials` table
Step 20: Create `faqs` table
Step 21: Create `blog_posts` table
Step 22: Create `blog_post_tag` pivot table
Step 23: Create `pages` table

PHASE 4: BUSINESS OPERATIONS
───────────────────────────
Step 24: Create `leads` table
Step 25: Create `contacts` table
Step 26: Create `notifications` table (already exists for DB notifs)

PHASE 5: SEO & ANALYTICS
────────────────────────
Step 27: Create `seo_metadata` table (polymorphic)
Step 28: Create `page_views` table

PHASE 6: DATA & OPTIMIZATION
───────────────────────────
Step 29: Add `is_admin`, `is_active` columns to `users` (if not using Spatie alone)
Step 30: Add indexes for performance (foreign keys, polymorphic lookups)
Step 31: Add fulltext indexes for searchable content (projects, blog_posts)
```

## 4. Index Strategy

| Table | Index | Type | Reason |
|-------|-------|------|--------|
| `projects` | `slug` | UNIQUE | URL lookup |
| `projects` | `status` | INDEX | Filtering |
| `projects` | `is_featured` | INDEX | Featured query |
| `projects` | `published_at` | INDEX | Publishing schedule |
| `projects` | `title` | FULLTEXT | Search |
| `projects` | `description` | FULLTEXT | Search |
| `blog_posts` | `slug` | UNIQUE | URL lookup |
| `blog_posts` | `is_published` | INDEX | Frontend filtering |
| `blog_posts` | `published_at` | INDEX | Archive browsing |
| `blog_posts` | `title`, `content` | FULLTEXT | Search |
| `leads` | `status` | INDEX | Lead pipeline |
| `leads` | `assigned_to` | INDEX | Assignment lookup |
| `leads` | `source` | INDEX | Source analytics |
| `seo_metadata` | `seoable_type`, `seoable_id` | INDEX (composite) | Polymorphic lookup |
| `media` | `model_type`, `model_id` | INDEX (composite) | Polymorphic lookup |
| `activity_log` | `subject_type`, `subject_id` | INDEX | Subject lookup |
| `page_views` | `visited_at` | INDEX | Date-range analytics |
| `page_views` | `page_url` | INDEX | Page-specific analytics |
| `menu_items` | `menu_id`, `parent_id`, `display_order` | INDEX (composite) | Menu rendering |

## 5. Key Relationships Summary

| Model A | Relationship | Model B | Pivot |
|---------|-------------|---------|-------|
| Project | belongsToMany | Category | `project_categories` |
| BlogPost | belongsTo | BlogCategory | — |
| BlogPost | belongsToMany | Tag | `blog_post_tag` |
| BlogPost | belongsTo | User (author) | — |
| Lead | belongsTo | User (assignee) | — |
| Menu | hasMany | MenuItem | — |
| MenuItem | belongsTo | MenuItem (parent) | — |
| SEO Metadata | morphTo | Page, Project, BlogPost, Service | — |
| Media | morphTo | Project, TeamMember, BlogPost, Service, Testimonial | — |
| Activity Log | morphTo | All models | — |
