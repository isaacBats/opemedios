# Opemedios - Arquitectura del Proyecto

> **Para trabajo activo:** `active-session.md`
> **Para historial:** `history/OPE-*.md`

---

## Stack Tecnológico

| Capa | Tecnología |
|------|------------|
| Backend | Laravel 10, PHP 8.2 |
| Frontend | Blade, Bootstrap 5, jQuery |
| CSS | Theme SaaS v3 (`theme-saas.css`) |
| Database | MySQL |
| Storage | AWS S3 |
| CI/CD | GitHub Actions → AWS CodeDeploy |

---

## Estructura de Carpetas

```
opemedios/
├── app/
│   ├── Http/Controllers/
│   │   ├── ClientController.php      # Módulo clientes
│   │   ├── ReportController.php      # Reportes
│   │   ├── NewsletterController.php  # Newsletters
│   │   └── HomeController.php        # Home y contacto
│   ├── Services/
│   │   └── RecaptchaV3Service.php
│   ├── Rules/
│   │   └── RecaptchaV3.php
│   ├── Models/                       # 30+ modelos Eloquent
│   ├── Exports/                      # Maatwebsite Excel
│   └── Mail/                         # Mailables
│
├── resources/views/
│   ├── homev3.blade.php              # Home v3
│   ├── signin.blade.php              # Login clientes
│   ├── clients/
│   │   ├── dashboard.blade.php
│   │   ├── mynews.blade.php
│   │   ├── shownew.blade.php
│   │   ├── covers.blade.php
│   │   └── report.blade.php
│   ├── layouts/
│   │   └── home-clientv3.blade.php   # Layout principal v3
│   └── mail/                         # Templates de email
│
├── public/assets/clientv3/css/
│   └── theme-saas.css                # Tema SaaS v3
│
├── routes/
│   ├── web.php                       # Rutas web
│   └── api.php                       # API v1
│
└── .github/workflows/
    ├── ci.yml                        # Tests + PHPStan
    └── deploy-prod.yml               # Deploy a AWS
```

---

## Módulos Principales

### 1. Clientes (`ClientController`)
- Dashboard con KPIs
- Vista de noticias filtrable
- Detalle de noticia
- Portafolio de covers
- Generador de reportes

### 2. Newsletters (`NewsletterController`)
- Gestión de newsletters
- Envío programado
- Templates de email

### 3. Reportes (`ReportController`)
- Lista de reportes solicitados
- Generación por cron (small/medium/big)
- Exportación Excel/PDF

### 4. Admin Panel
- Gestión de usuarios
- Gestión de compañías
- Configuración del sistema

---

## Rutas Clave

```php
// Clientes
/{company}/dashboard           → ClientController@index
/{company}/mis-noticias        → ClientController@myNews
/{company}/noticia/{id}        → ClientController@showNew
/{company}/otras-secciones     → ClientController@getCovers
/{company}/reporte             → ClientController@report

// API
/api/v1/upload-pdf             → VerifyFastApiKey middleware
```

---

## Seguridad

- **Multi-tenant:** Validación `company_id` en todos los métodos de ClientController
- **Autenticación:** Spatie Laravel Permission
- **reCAPTCHA:** v3 con score-based validation
- **CI:** PHPStan nivel 5, composer audit

---

*Última actualización: 2026-01-31*
