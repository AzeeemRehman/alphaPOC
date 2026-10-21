# ALPHA Global Shipping & Logistics — Website Development Plan

**Domain:** www.alphagsl.com
**Tagline:** Reliable • Efficient • Worldwide
**Source material:** `alpha_global_shipping_logistics_www_alphagsl_com.html` (single-page prototype) and `WhatsApp Image 2026-10-20 at 7.58.14 AM.jpeg` (logo + official contact details)

---

## Implementation status (updated 2026-10-21)

**The site described in this plan is built and running.** Differences from the original plan:

| Plan | As built | Why |
|---|---|---|
| PHPMailer via Composer | Own small mailer (`app/Core/Mailer.php`): `log`, `mail` or `smtp` | No Composer on the dev machine, and no dependencies to maintain |
| HTML Purifier | Own allowlist sanitizer (`app/Core/Html.php`), run when a post is saved | Same reason. Tested against script/onerror/javascript:/iframe |
| TinyMCE | Quill editor (CDN) | Free, light, no API key |
| reCAPTCHA | Honeypot + time trap + per-IP limit, plus optional Cloudflare Turnstile (set keys in `.env`) | Privacy-friendly and free |
| Folder `src/`, `controllers/` | `app/Controllers`, `app/Models`, `app/Core`, `app/views` | Same idea, PSR-4-style autoload |
| `/services/{x}` pages in DB | Defined in `app/Data/Services.php` | Six fixed services. Edit the file to change the text |

**Not yet done / needs the client:** the items in section 15, real photos, real ISO/"since" claims (removed from the pages until verified), the legal pages (template text only, needs review), SMTP credentials, and production hosting.

**Quick start (Windows + XAMPP):**
```bash
npm install && npm run build:css
php database/install.php --sample      # creates DB, tables, admin user, sample content
php -S localhost:8000 -t public public/index.php
```
Admin: http://localhost:8000/admin/login (the password is printed once by the installer).

---

## 1. Goal

Turn the single-file prototype into a production multi-page company website, built the way the industry builds them:

- Each section gets its own page and URL (`/about`, `/services`, ...). The prototype hides and shows `<div>`s with JavaScript instead.
- A **blog**: the admin can write, edit, publish and delete posts, and visitors can read them.
- A **query / quote form** that saves every submission to a database and emails the office.
- A password-protected **admin panel** for managing blog posts and reading queries.
- SEO, mobile-friendly design, security and fast loading.

---

## 2. Official Business Details (from logo image)

The prototype contains **placeholder** contact data (`+1 (800) 555-ALPHA`, "Suite 1400, Global Maritime Trade Center"). Replace it everywhere with the real details:

| Field | Value |
|---|---|
| Company | ALPHA Global Shipping & Logistics |
| Address | Suite # 21, 2nd Floor, State Life Insurance Building No. 7, G. Allana Road, Near Merewether Tower, Karachi – Pakistan |
| Telephone | 021-32316744-5 |
| Mobile / WhatsApp | +92 333 2209385 |
| Email | info@alphagsl.com *(to confirm with client)* |
| Website | www.alphagsl.com |

**Claims to verify with the client before launch:** "ISO 9001:2015 Certified", "Since 2010", "180+ Countries", "14,290 shipments". Remove any of these that aren't true.

### Brand colours (from logo)

| Token | Hex | Use |
|---|---|---|
| `navy-900` | `#0B192C` | Header/footer backgrounds, headings |
| `brand-blue` | `#1F5FA8` | Logo globe blue: links, primary buttons |
| `brand-orange` | `#F58220` | Logo arrow orange: CTAs, highlights |
| `gray-50` | `#F8FAFC` | Section backgrounds |

Font: **Inter** (already used in the prototype). Headings bold or extra-bold.

---

## 3. Technology Stack

| Layer | Choice | Reason |
|---|---|---|
| Backend | **PHP 8.2+** | Runs on any standard cPanel shared hosting in Pakistan, and no Node server is needed |
| Database | **MySQL 8 / MariaDB** | Included with every hosting plan |
| Styling | **Tailwind CSS (CLI build)** | Same classes as the prototype. Compiled to one small CSS file instead of the CDN script, which isn't meant for production |
| Icons | Font Awesome 6 (self-hosted subset) | Already used in the prototype |
| Rich text editor (blog) | **TinyMCE** or **Quill** | For writing blog posts in the admin panel |
| Email | **PHPMailer** over SMTP | Sends query notifications to the office inbox |
| Spam protection | Honeypot field + Google reCAPTCHA v3 (or Cloudflare Turnstile) | Protects the query form |
| Dependency manager | Composer | Installs PHPMailer and HTML Purifier |

> Alternative if the client prefers: WordPress with a custom theme. Same pages, with built-in blog and Contact Form 7. This plan assumes the custom PHP build, which is lighter, faster and has no plugin maintenance.

---

## 4. Site Map (Public Pages)

```
/                       Home
/about                  About Us (history, mission, vision, why choose us)
/services               Services overview
/services/ocean-freight     Ocean Freight (FCL / LCL)
/services/air-freight       Air Cargo Express & Charter
/services/customs-clearance Customs Brokerage & Clearance
/services/warehousing       Bonded Warehousing & Distribution
/services/land-transport    Land Transport / Haulage
/services/project-cargo     Heavy Lift & Project Logistics
/tracking               Shipment Tracking
/quote                  Request a Quote (detailed freight form)
/blog                   Blog listing (paginated, category filter, search)
/blog/{slug}            Single blog post
/blog/category/{slug}   Posts in a category
/contact                Contact Us (details, Google Map, query form)
/privacy-policy         Privacy Policy
/terms                  Terms & Conditions
/404                    Custom not-found page
```

### Page content

| Page | Sections |
|---|---|
| **Home** | Hero with CTA ("Get a Quote" / "Track Shipment") · quick-track box · key stats · services grid · why choose us · process steps · latest 3 blog posts · testimonials · CTA banner |
| **About** | Company story · mission & vision · core values · certifications · team (optional) · global network |
| **Services** | Card grid linking to each service detail page |
| **Service detail** | Description · features list · how it works · FAQ · "Request Quote for this service" CTA (pre-fills the quote form) |
| **Tracking** | Tracking number input · status timeline. Phase 1: statuses entered manually by admin. Phase 2: carrier API |
| **Quote** | Full freight quote form (see §6) |
| **Blog** | Post cards (image, title, excerpt, date, category) · sidebar: search, categories, recent posts |
| **Contact** | Address, phones, WhatsApp button, email, office hours · embedded Google Map (Merewether Tower, Karachi) · general query form |

### Global elements on every page

- **Top bar:** phone, email, office hours, social links
- **Header:** logo (from image), navigation, "Get a Quote" button. Becomes a hamburger menu on mobile
- **Footer:** logo + tagline, quick links, services, contact details, newsletter (optional), copyright
- **Floating WhatsApp button** linking to `https://wa.me/923332209385`

---

## 5. Blog Module

### Admin (logged in)
- Create, edit, delete and publish/unpublish posts
- Fields: title, slug (auto-generated, editable), featured image upload, excerpt, content (rich text), category, tags, meta title, meta description, status (draft/published), publish date
- Manage categories
- Image uploads checked for type (jpg/png/webp) and size (≤ 2 MB), and stored in `/public/uploads/blog/`

### Public
- Listing with pagination (9 per page)
- Category filter and keyword search
- Single post page with share buttons (WhatsApp, LinkedIn, Facebook) and related posts
- SEO: unique `<title>`, meta description, Open Graph tags, and an `Article` JSON-LD schema per post

---

## 6. Query / Quote Forms

### 6.1 Contact form (`/contact`)
Fields: Full Name\*, Email\*, Phone\*, Company, Subject\*, Message\*

### 6.2 Quote request form (`/quote`)
Fields: Full Name\*, Company, Email\*, Phone/WhatsApp\*, Service Type\* (Ocean FCL / Ocean LCL / Air / Customs / Warehousing / Land), Origin\*, Destination\*, Commodity\*, Weight (kg), Volume (CBM), Container Type (20'/40'/40'HC), Incoterms, Expected Ship Date, Notes

### Submission flow
1. Client-side validation (HTML5 + JavaScript)
2. Server-side validation and sanitisation in PHP
3. CSRF token check, honeypot check, reCAPTCHA check, rate limit (5 per IP per hour)
4. Save to the `queries` table with status `new`
5. Email notification to the office inbox, plus an auto-reply to the customer
6. Redirect to a "Thank you" message (Post/Redirect/Get pattern)

### Admin
- Inbox listing with filters (new / in-progress / closed, contact / quote, date)
- View detail, change status, add internal notes
- Export to CSV

---

## 7. Admin Panel (`/admin`)

| Screen | Purpose |
|---|---|
| Login | Email + password (bcrypt hash), session-based, lockout after 5 failed attempts |
| Dashboard | Counts: new queries, total posts, recent activity |
| Blog Posts | List / create / edit / delete |
| Categories | Manage blog categories |
| Queries | Contact + quote submissions inbox |
| Shipments | Add tracking numbers and status updates (powers `/tracking`) |
| Settings | Company phone, email, address, social links (stored in DB, used across the site) |
| Users | Change password, add editors (optional) |

The prototype's "Admin Portal" button in the public top bar is **removed**. The admin is reached directly at `/admin`.

---

## 8. Database Schema

```sql
users        (id, name, email UNIQUE, password_hash, role ENUM('admin','editor'), last_login, created_at)
categories   (id, name, slug UNIQUE)
posts        (id, title, slug UNIQUE, excerpt, content LONGTEXT, featured_image,
              category_id FK, author_id FK, status ENUM('draft','published'),
              meta_title, meta_description, published_at, created_at, updated_at)
tags         (id, name, slug UNIQUE)
post_tags    (post_id FK, tag_id FK)
queries      (id, type ENUM('contact','quote'), name, email, phone, company, subject,
              message, service_type, origin, destination, commodity, weight_kg, volume_cbm,
              container_type, incoterms, ship_date, status ENUM('new','in_progress','closed'),
              admin_notes, ip_address, created_at)
shipments    (id, tracking_no UNIQUE, origin, destination, mode, current_status, eta, created_at)
shipment_events (id, shipment_id FK, status, location, note, event_time)
settings     (key PRIMARY KEY, value)
login_attempts (id, ip_address, email, attempted_at)
```

---

## 9. Folder Structure

```
alpha-website/
├── public/                     # Web root (document root on hosting)
│   ├── index.php               # Front controller / router
│   ├── .htaccess               # Clean URLs, HTTPS redirect, caching
│   ├── assets/
│   │   ├── css/app.css         # Compiled Tailwind
│   │   ├── js/app.js           # Menu, form validation, tracking
│   │   └── img/                # logo.png, hero images, service images
│   └── uploads/blog/           # Blog images (writable)
├── app/
│   ├── config/config.php       # DB, SMTP, reCAPTCHA keys (read from .env)
│   ├── core/                   # Router, Database (PDO), Auth, Csrf, Validator, Mailer
│   ├── controllers/            # PageController, BlogController, QueryController, Admin/*
│   ├── models/                 # Post, Category, Query, Shipment, User, Setting
│   └── views/
│       ├── layouts/            # main.php, admin.php
│       ├── partials/           # header.php, footer.php, topbar.php, whatsapp.php
│       ├── pages/              # home, about, services, service-detail, tracking, quote, contact
│       ├── blog/               # index.php, show.php
│       └── admin/              # login, dashboard, posts, queries, shipments, settings
├── database/
│   ├── schema.sql
│   └── seed.sql                # Admin user, sample categories & posts
├── src/css/input.css           # Tailwind source
├── tailwind.config.js          # Brand colours from §2
├── composer.json
├── package.json                # Tailwind CLI only
├── .env.example
└── DEVELOPMENT.md
```

---

## 10. Security Checklist

- [ ] PDO prepared statements for **every** query (no SQL injection)
- [ ] `htmlspecialchars()` on all output. Blog HTML cleaned with **HTML Purifier** (no XSS)
- [ ] CSRF tokens on every form (public and admin)
- [ ] `password_hash()` / `password_verify()` for admin passwords
- [ ] Session hardening: `httponly`, `secure`, `samesite=Lax`, regenerate ID on login
- [ ] Login rate limiting and lockout
- [ ] File uploads: MIME check, random filenames, no PHP execution in `/uploads`
- [ ] HTTPS forced via `.htaccess`, plus security headers (CSP, X-Frame-Options, etc.)
- [ ] Secrets in `.env`, outside the web root and never committed
- [ ] Daily DB backup (cPanel cron)

---

## 11. SEO & Performance

- Unique `<title>` and meta description per page, using the industry keywords: *freight forwarder Karachi*, *shipping company Pakistan*, *customs clearance Karachi*, *sea freight*, *air cargo*
- `LocalBusiness` JSON-LD schema with the Karachi address and phones
- `sitemap.xml` (auto-generated, includes blog posts) and `robots.txt`
- Open Graph and Twitter cards
- Images in WebP, lazy-loaded, with sizes set
- Minified CSS/JS, browser caching via `.htaccess`
- Target Lighthouse score ≥ 90 for Performance, Accessibility, Best Practices and SEO
- Register with Google Search Console and Google Business Profile

---

## 12. Development Phases

| Phase | Deliverables | Est. |
|---|---|---|
| **1. Setup** | Folder structure, Tailwind build, router, DB connection, `.env`, logo assets cut from the image | 1 day |
| **2. Layout & static pages** | Header, footer, top bar, WhatsApp button. Home, About, Services, 6 service pages, Contact, Privacy, Terms, 404. All content moved from the prototype, real contact details used | 3 days |
| **3. Query forms** | Contact + Quote forms, validation, DB storage, email notifications, thank-you flow, spam protection | 2 days |
| **4. Admin panel** | Auth, dashboard, queries inbox, settings | 2 days |
| **5. Blog** | Admin CRUD with editor and image upload, public listing, single post, categories, search | 3 days |
| **6. Tracking** | Admin shipment management + public tracking page | 1 day |
| **7. SEO & polish** | Meta tags, schema, sitemap, performance, accessibility, cross-browser and mobile testing | 1–2 days |
| **8. Deployment** | Upload to hosting, DB import, SSL, SMTP config, DNS for alphagsl.com, final QA | 1 day |

---

## 13. Local Development

**Requirements:** PHP 8.2+, MySQL 8, Composer, Node.js 18+ (only for building Tailwind). XAMPP or Laragon on Windows works.

```bash
composer install
npm install
cp .env.example .env          # then fill in DB + SMTP credentials
mysql -u root -p alpha_gsl < database/schema.sql
mysql -u root -p alpha_gsl < database/seed.sql
npm run build:css             # or: npm run watch:css
php -S localhost:8000 -t public
```

Open http://localhost:8000 for the site and http://localhost:8000/admin for the admin panel. The seed admin credentials are in `database/seed.sql` and must be changed after first login.

---

## 14. Deployment (cPanel hosting)

1. Point the domain's document root to `/public`
2. Upload files (Git or File Manager), then run `composer install --no-dev`
3. Create the MySQL database and user, then import `schema.sql`
4. Fill in the production `.env`
5. Enable AutoSSL / Let's Encrypt and force HTTPS
6. Configure SMTP (hosting mail or Gmail/Workspace app password)
7. Set up the cron job for DB backups
8. Submit `sitemap.xml` to Google Search Console

---

## 15. Open Questions for the Client

1. Confirm the official email address(es) for receiving queries.
2. Are ISO certification, "Since 2010" and the statistics accurate?
3. Is real tracking needed (carrier API integration), or is manual admin-entered status enough for now?
4. Social media links (Facebook, LinkedIn, Instagram)?
5. Photos: real office, team and cargo photos, or licensed stock images?
6. Languages: English only, or English + Urdu?
7. Hosting: is there an existing hosting account for alphagsl.com?
