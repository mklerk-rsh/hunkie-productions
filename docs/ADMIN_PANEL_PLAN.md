# Hunkie Productions — Filament Admin Panel Plan

## 1. Panel Configuration

```
Panel ID:     admin
Path:         /admin
Middleware:   ['web', 'auth', 'verified']
Brand Name:   Hunkie Productions
Logo:         public/images/logo.svg
Favicon:      public/images/favicon.ico
Theme:        Custom Tailwind (brand colors)
```

## 2. Resource Inventory

| Resource | Model | Icon | Group | Features |
|----------|-------|------|-------|----------|
| UserResource | User | `heroicon-o-users` | Users | CRUD, role assignment, email verification toggle |
| RoleResource | Role (Spatie) | `heroicon-o-shield-check` | Users | CRUD, permission assignment |
| PermissionResource | Permission (Spatie) | `heroicon-o-key` | Users | Read-only (managed via RoleResource) |
| ProjectResource | Project | `heroicon-o-folder-open` | Content | CRUD, media attachments, categories, SEO, status |
| ServiceResource | Service | `heroicon-o-cog` | Content | CRUD, icon picker, media, display order |
| TeamMemberResource | TeamMember | `heroicon-o-user-group` | Content | CRUD, photo, social links, display order |
| TestimonialResource | Testimonial | `heroicon-o-star` | Content | CRUD, avatar, approval workflow, rating |
| FAQResource | FAQ | `heroicon-o-question-mark-circle` | Content | CRUD, categorized, display order |
| CategoryResource | Category | `heroicon-o-tag` | Taxonomy | CRUD, display order, active status |
| BlogCategoryResource | BlogCategory | `heroicon-o-rectangle-stack` | Content | CRUD, active status |
| TagResource | Tag | `heroicon-o-hashtag` | Content | CRUD |
| BlogPostResource | BlogPost | `heroicon-o-newspaper` | Content | CRUD, rich editor, categories, tags, featured image, SEO |
| PageResource | Page | `heroicon-o-document` | Content | CRUD, rich editor, layout selection, SEO |
| LeadResource | Lead | `heroicon-inbox-arrow-down` | Leads | CRUD, status workflow, assignment, timeline |
| ContactResource | Contact | `heroicon-o-at-symbol` | Leads | Read-only, export, subscription management |
| MenuResource | Menu | `heroicon-o-bars-3` | Structure | CRUD, menu item builder with drag-drop |
| SettingResource | Setting | `heroicon-o-cog-6-tooth` | System | Key-value editor, grouped settings |
| ActivityLogResource | ActivityLog (Spatie) | `heroicon-o-clock` | System | Read-only, filters, search |

## 3. Dashboard Widgets

### Row 1: Stats Overview
```
┌─────────────────────┐ ┌─────────────────────┐ ┌─────────────────────┐ ┌─────────────────────┐
│  Total Projects     │ │  Total Leads        │ │  Total Blog Posts   │ │  Active Contacts    │
│  [Number]           │ │  [Number]           │ │  [Number]           │ │  [Number]           │
│  +% change          │ │  +% change          │ │  +% change          │ │  +% change          │
└─────────────────────┘ └─────────────────────┘ └─────────────────────┘ └─────────────────────┘
```

### Row 2: Charts
```
┌──────────────────────────────────────┐ ┌──────────────────────────────────────┐
│  Leads Overview (Line Chart)         │ │  Projects by Category (Bar Chart)    │
│  Last 30 days                        │ │                                       │
└──────────────────────────────────────┘ └──────────────────────────────────────┘
```

### Row 3: Tables
```
┌──────────────────────────────────────┐ ┌──────────────────────────────────────┐
│  Recent Leads                        │ │  Latest Blog Posts                  │
│  [Table: name, email, status, date]  │ │  [Table: title, author, date]       │
│  [View All]                          │ │  [View All]                          │
└──────────────────────────────────────┘ └──────────────────────────────────────┘
```

## 4. Resource Schema Details

### 4.1 UserResource
```
Fields:
  - name (TextInput, required)
  - email (TextInput, email, required, unique)
  - password (TextInput, password, hidden on edit unless filled)
  - email_verified_at (DateTimePicker, nullable)
  - is_active (Toggle)
  - roles (Select, multiple, Spatie)

Table Columns: name, email, roles (badge), is_active (icon), created_at
Actions: Create, Edit, Delete, Impersonate (using Filament shield)
```

### 4.2 ProjectResource
```
Fields:
  - title (TextInput, required)
  - slug (TextInput, unique, regex:/^[a-z0-9-]+$/)
  - description (RichEditor, required)
  - content (RichEditor)
  - client_name (TextInput)
  - project_date (DatePicker)
  - completion_year (TextInput, number, 4 digits)
  - url (TextInput, URL, nullable)
  - categories (Select, multiple, relationship)
  - is_featured (Toggle)
  - status (Select: draft, published, archived)
  - published_at (DateTimePicker)
  - media (SpatieMediaLibraryFileUpload, multiple)

Table Columns: title, categories (badges), status (badge), is_featured (icon), published_at
Actions: Create, Edit, Delete
Widget: Project media gallery on detail page
```

### 4.3 LeadResource
```
Fields:
  - name (TextInput, required)
  - email (TextInput, email, required)
  - phone (TextInput, tel)
  - company (TextInput)
  - message (Textarea)
  - service_interest (Select: from services list)
  - source (Select: website, referral, social_media, google, direct, other)
  - utm_source (TextInput, hidden)
  - utm_medium (TextInput, hidden)
  - utm_campaign (TextInput, hidden)
  - status (Select: new, contacted, qualified, proposal, negotiation, won, lost)
  - lead_score (TextInput, number, read-only)
  - assigned_to (Select, User relationship)
  - notes (Textarea)

Table Columns: name, email, status (badge, colored), service_interest, assigned_to, created_at
Actions: View, Edit, Assign, Change Status
Filters: status, source, date range, assigned_to
Widget: Lead timeline (activity log for this lead)
```

### 4.4 BlogPostResource
```
Fields:
  - title (TextInput, required)
  - slug (TextInput, unique)
  - content (RichEditor, required)
  - excerpt (Textarea)
  - blog_category_id (Select, required)
  - tags (Select, multiple)
  - author_id (Select, User, default: current user)
  - is_published (Toggle)
  - published_at (DateTimePicker)
  - is_featured (Toggle)
  - featured_image (SpatieMediaLibraryFileUpload, single)
  - SEO (Repeater/Group via SEO trait)

Table Columns: title, category, author, is_published (icon), published_at
Actions: Create, Edit, Delete, Preview (open in new tab)
```

### 4.5 MenuResource
```
Fields:
  - name (TextInput, required)
  - handle (TextInput, unique, slug, required)

Menu Item Builder (Repeater within MenuResource):
  - title (TextInput, required)
  - url (TextInput, URL, nullable)
  - route (TextInput, nullable - internal route name)
  - parent_id (Select, menu items in same menu)
  - target (Select: _self, _blank)
  - icon (TextInput, nullable)
  - is_active (Toggle)
  - display_order (TextInput, number)

Table Columns: name, handle, menu_items_count
Actions: Create, Edit, Delete, Builder
```

### 4.6 SettingResource
```
Fields:
  - group (Select: general, contact, social, seo, analytics)
  - key (TextInput, required, unique)
  - value (Textarea/TextInput, depending on type)

Table Columns: group, key, value (truncated)
Actions: Create, Edit, Delete
Groups as tabs/sections
```

### 4.7 PageResource
```
Fields:
  - title (TextInput, required)
  - slug (TextInput, unique, required)
  - content (RichEditor, required)
  - layout (Select: default, full_width, sidebar)
  - is_published (Toggle)
  - SEO (Group with meta_title, meta_description, og_title, etc.)

Table Columns: title, slug, layout, is_published
Actions: Create, Edit, Delete, Preview
```

## 5. Custom Pages

| Page | Route | Purpose |
|------|-------|---------|
| Dashboard | `/admin` | Main analytics dashboard |
| Activity Log | `/admin/activity-log` | Global activity stream |
| Settings | `/admin/settings` | Site-wide configuration |
| Media Library | `/admin/media` | Global media browser |
| Reports | `/admin/reports` | Lead/sales reports |

## 6. Form Customizations

### Rich Text Editor
Use Filament's RichEditor with:
- Bold, Italic, Underline, Strike
- Headings (H2, H3, H4)
- Bullet List, Ordered List
- Link insertion
- Image insertion (via media library)
- Blockquote
- Code block

### Media Upload Configuration
```
Accepted File Types:
  - Images: jpg, jpeg, png, webp, gif, svg
  - Documents: pdf, doc, docx
  - Videos: mp4, webm (optional)

Max File Size: 10MB (images), 20MB (videos)
Conversions: Automatically generate thumb, preview, hero variants
```

## 7. Authorization Rules

| Resource | View | Create | Edit | Delete |
|----------|------|--------|------|--------|
| UserResource | admin, super_admin | super_admin | super_admin | super_admin |
| RoleResource | super_admin | super_admin | super_admin | super_admin |
| PermissionResource | super_admin | — | — | — |
| ProjectResource | admin, editor | admin, editor | admin, editor | admin |
| ServiceResource | admin, editor | admin, editor | admin, editor | admin |
| TeamMemberResource | admin, editor | admin, editor | admin, editor | admin |
| TestimonialResource | admin, editor | admin, editor | admin, editor | admin |
| FAQResource | admin, editor | admin, editor | admin, editor | admin |
| BlogPostResource | admin, editor | admin, editor | admin, editor | admin |
| PageResource | admin, editor | admin, editor | admin, editor | admin |
| CategoryResource | admin, editor | admin, editor | admin, editor | admin |
| TagResource | admin, editor | admin, editor | admin, editor | admin |
| LeadResource | admin, lead_manager, support | — | admin, lead_manager | admin |
| ContactResource | admin, lead_manager | — | admin | admin |
| MenuResource | admin, editor | admin, editor | admin, editor | admin |
| SettingResource | admin | admin | admin | admin |
| ActivityLogResource | admin, super_admin | — | — | — |

## 8. Widget Providers

- `StatsOverviewWidget` — published counts for projects, leads, blog, contacts
- `LeadsChartWidget` — line chart of leads over last 30 days
- `ProjectsByCategoryWidget` — bar chart of project distribution
- `RecentLeadsWidget` — table listing latest 5 unassigned leads
- `LatestBlogPostsWidget` — table listing latest 5 unpublished/published posts
- `QuickCreateWidget` — button links to create project, blog, lead

## 9. Notifications Integration

In-app notifications via Filament's Notification system:
- New lead captured → Notification for lead managers
- Lead status changed → Notification for assignee
- New contact subscribed → Notification for admin
- Blog post published → Notification for admins
