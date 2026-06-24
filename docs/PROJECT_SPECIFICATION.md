# Hunkie Productions — Project Specification

## 1. Executive Summary

Hunkie Productions is a full-featured content production and portfolio management platform. It serves as both a public-facing corporate website and an internal administration system. The platform enables the production company to showcase its work, manage client relationships, handle inquiries, and administrate all digital assets through a single unified interface.

## 2. Project Goals

- Establish a professional public-facing website showcasing the company's portfolio, services, and team
- Provide a comprehensive admin panel for managing all site content, media, and business operations
- Implement role-based access control for multi-user administration
- Track and manage incoming leads from multiple channels
- Deliver a scalable media library for images, videos, and documents
- Support SEO best practices across all public pages
- Enable automated notifications and communications

## 3. Technology Stack

| Layer | Technology |
|-------|-----------|
| Backend Framework | Laravel 13.x |
| Admin Panel | Filament 5.6 |
| PHP | 8.3+ |
| Database | MySQL (hps_db) |
| Queue | Database-driven |
| Cache | Database-driven |
| Session | Database-driven |
| Frontend | Tailwind CSS 4 + Vite 8 |
| JS Framework | Livewire (included via Filament) |
| Image Manipulation | Intervention Image 4.1 |
| RBAC | Spatie Laravel Permission 8 |
| Media | Spatie Laravel Media Library 11 |
| Auditing | Spatie Laravel Activitylog 5 |

## 4. Feature Inventory

### 4.1 Public Website Features

| Feature | Description |
|---------|-------------|
| Home Page | Hero section, featured projects, services overview, testimonials, CTA |
| About Us | Company story, mission, values, team members |
| Portfolio | Filterable project gallery with categories, media, and details |
| Services | Detailed service listings with descriptions and imagery |
| Blog | Full blog with categories, tags, and archive |
| Contact | Contact form with lead capture, map, company details |
| Team | Team member profiles with bios and photos |
| FAQ | Accordion-style frequently asked questions |
| SEO | Per-page meta tags, OG tags, sitemap, structured data |
| Analytics | Page view tracking, lead source attribution |

### 4.2 Admin Panel Features

| Feature | Description |
|---------|-------------|
| Dashboard | KPI widgets, charts, recent activity, quick actions |
| Users | CRUD, role assignment, account status management |
| Roles & Permissions | RBAC management via Spatie |
| Projects | Full project lifecycle with media attachments |
| Services | Service CRUD with icons and descriptions |
| Team Members | Team profile management with photos |
| Testimonials | Client testimonial management |
| Blog Posts | Rich text editor, categories, tags, featured images |
| Pages | CMS-style page management with SEO |
| Leads | Lead tracking, status workflow, assignment |
| Contacts | Newsletter subscribers and contact records |
| Media Library | Centralized media browser and manager |
| Settings | Site-wide configuration |
| Menus | Navigation menu builder |
| Activity Log | Read-only system activity audit trail |
| Notifications | In-app notification center |

## 5. User Roles & Personas

| Role | Description |
|------|-------------|
| Super Admin | Full system access, all permissions |
| Admin | All content management, user management (except role creation) |
| Editor | Blog, project, service, team member management |
| Lead Manager | Lead viewing, status updates, assignment |
| Support Staff | Lead viewing, reply to inquiries |

## 6. Non-Functional Requirements

| Requirement | Specification |
|-------------|---------------|
| Performance | Page load < 2s, image optimization via Spatie Media Library conversions |
| Security | RBAC, CSRF protection, SQL injection prevention, XSS filtering |
| Scalability | Queue-driven jobs for notifications, media processing, logging |
| Maintainability | Service layer pattern, repository pattern for complex queries |
| SEO | 95+ Lighthouse score target, semantic HTML, structured data |
| Accessibility | WCAG 2.1 AA compliance target |
| Backup | Automated database and media backups strategy |

## 7. Constraints & Assumptions

- Single MySQL database instance
- Queue system uses database driver (can be swapped to Redis later)
- Filament panel for all admin interfaces — no custom admin views
- Public website uses Blade + Tailwind CSS (no separate SPA)
- Media files stored locally with option to migrate to S3
- All image transformations handled by Spatie Media Library conversions
