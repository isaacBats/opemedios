# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

---

## Memory & Context Management

### Prioridad de Lectura (Ahorro de Tokens)

**Al inicio de CADA sesión, leer en este orden:**

1. `.claude/active-session.md` - **PRIMERO** (trabajo en progreso)
2. `.claude/index.md` - Inventario si necesitas contexto adicional
3. `.claude/rules/ui-style.md` - Solo si la tarea es frontend

**NO leer por defecto:**
- `project-map.md` - Solo para estructura de carpetas
- `history/OPE-*.md` - Solo si necesitas contexto histórico específico

### Flujo de Trabajo

```
┌─────────────────────────────────────────────────────────┐
│  INICIO SESIÓN                                          │
│  1. Leer active-session.md                              │
│  2. Identificar tarea actual                            │
│  3. Trabajar                                            │
└─────────────────────────────────────────────────────────┘
                         │
                         ▼
┌─────────────────────────────────────────────────────────┐
│  FIN DE TAREA                                           │
│  1. Crear history/OPE-XXX-titulo.md con resumen         │
│  2. Actualizar index.md                                 │
│  3. Limpiar active-session.md                           │
│  4. Definir siguiente tarea                             │
└─────────────────────────────────────────────────────────┘
```

### Regla de Eficiencia

> **NUNCA** dejar logs extensos en active-session.md.
> Máximo 50 líneas. Si excede, archivar en history/.

---

## Directorio .claude

```
.claude/
├── index.md                  # Inventario maestro
├── active-session.md         # Trabajo en progreso (LEER PRIMERO)
├── project-map.md            # Arquitectura del proyecto
├── agents/
│   ├── frontend-expert.md    # Estándares frontend
│   └── backend-expert.md     # Estándares backend
├── rules/
│   └── ui-style.md           # FUENTE DE VERDAD para UI
├── history/                  # Tareas completadas
│   └── OPE-XXX-titulo.md
├── doc/                      # Documentación adicional
└── hooks/                    # Hooks personalizados
```

### Archivos por Contexto

| Tarea | Leer |
|-------|------|
| Cualquiera | `active-session.md` |
| Frontend/UI | `rules/ui-style.md` |
| PHP/Laravel | `agents/backend-expert.md` |
| CSS/Blade | `agents/frontend-expert.md` |
| Contexto histórico | `history/OPE-*.md` específico |

---

## Project Overview

Opemedios is a Laravel 10 + PHP 8.2 media monitoring and news management system with multi-company support. It manages news content, newsletters, reports, and media monitoring across multiple channels (TV, Radio, Print, Internet, Social Media).

## Essential Commands

### Development
```bash
composer install                    # Install dependencies
cp .env.example .env                # Setup environment
php artisan key:generate            # Generate app key
php artisan migrate                 # Run migrations
php artisan serve                   # Start dev server (localhost:8000)
```

### Testing
```bash
vendor/bin/phpunit                  # Run all tests
vendor/bin/phpunit tests/Unit       # Unit tests only
vendor/bin/phpunit tests/Feature    # Feature tests only
vendor/bin/phpunit --filter=TestName  # Run specific test
```

### Code Quality
```bash
vendor/bin/phpstan analyse          # Static analysis (level 7)
vendor/bin/psalm                    # Type checking
vendor/bin/phpinsights              # Architecture analysis
vendor/bin/pint                     # Code formatting (Laravel Pint)
vendor/bin/phpcs                    # Code standards check
```

### Custom Artisan Commands
```bash
php artisan generate:report         # Generate news reports
php artisan newsletter:send         # Send newsletters
```

### Production
```bash
composer install --no-dev --optimize-autoloader
php artisan config:cache && php artisan route:cache
```

## Architecture

### Key Directories
- `app/Models/` - 30+ Eloquent models (News, User, Company, Theme, Newsletter, Cover, Means)
- `app/Http/Controllers/` - Domain controllers (NewsController, NewsletterController, ReportController)
- `app/Traits/` - Shared logic (StadisticsNotes for analytics across controllers)
- `app/Exports/` - Maatwebsite Excel export classes
- `app/Mail/` - Mailable classes for email templates
- `resources/views/` - Blade templates organized by feature (admin/, layouts/, auth/, mail/)
- `routes/web.php` - Primary web routes
- `routes/api.php` - API v1 routes

### Frontend
- **Blade templates** for all views
- Static libraries stored directly in `public/`:
  - `public/assets/` - CSS, JS, images
  - `public/lib/` - Third-party libraries (Bootstrap 4, jQuery, etc.)
  - `public/js/` - JavaScript files
  - `public/css/` - Stylesheets
  - `public/images/` - Image assets
- npm was only used historically for SASS compilation, not actively used now

### Core Patterns
- **Authorization**: Spatie Laravel Permission v6.10 for roles/permissions
- **File Storage**: AWS S3 via Flysystem (FILESYSTEM_DRIVER=s3)
- **Exports**: Maatwebsite Excel v3 for Excel, dompdf for PDF generation
- **Multi-tenancy**: Company-based data isolation with company switching
- **Form Validation**: FormRequest classes for centralized validation

### Key Relationships
- News belongsTo Source, Sector, Genre, Section, Means, User, AuthorType
- Newsletter hasMany ThemeNews, Sends
- Company hasMany Users, Themes (via company_themes pivot)
- User hasMany News, uses Spatie HasRoles trait

## Configuration Notes

### Environment
- **Timezone**: America/Mexico_City
- **Locale**: es (Spanish), es_MX.utf8
- **Queue**: Database driver
- **Cache**: File driver
- **Mail**: SMTP (Mailtrap for dev)

### Resource Limits (AppServiceProvider)
- Memory: 500MB
- Upload max: 350MB
- Post max: 450MB
- Execution time: 1000s

## API

### Authentication Routes
- POST `/login`, `/logout`, `/register`, `/forgot-password`

### API v1 (requires FastAPI key)
- POST `/api/v1/upload-pdf` - PDF upload with VerifyFastApiKey middleware

## Deployment

GitHub Actions workflow (`.github/workflows/deploy-prod.yml`) deploys to AWS CodeDeploy on push to `master` branch.

## Current Development

Branch `feature/theme-opemedios-v3` - Version 3 theme implementation in progress.
