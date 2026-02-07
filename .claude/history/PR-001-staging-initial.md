# Pull Request: Módulo de Clientes - Refactorización v3

## 📋 Resumen Ejecutivo

Este PR implementa una refactorización completa del módulo de clientes bajo el estándar **SaaS Modern Theme v3**, incluyendo mejoras de seguridad multi-tenant, migración de reCAPTCHA v2 a v3, y optimizaciones de rendimiento en consultas Eloquent.

**Branch:** `feature/theme-opemedios-v3` → `staging`

**Estadísticas:**
- 📁 **307 archivos modificados**
- ➕ **33,116 inserciones**
- ➖ **3,275 eliminaciones**

---

## 🔐 Seguridad y Autenticación

### 1. Migración de reCAPTCHA v2 → v3

| Componente | Antes | Después |
|------------|-------|---------|
| Tipo | Widget visible (checkbox) | Invisible (score-based) |
| Paquete | `anhskohbo/no-captcha` | Custom `RecaptchaV3Service` |
| Validación | Binaria (pass/fail) | Score ≥ 0.5 |
| UX | Interrupción al usuario | Transparente |

**Nuevos archivos:**
- `app/Services/RecaptchaV3Service.php` - Servicio de validación
- `app/Rules/RecaptchaV3.php` - Regla Laravel para FormRequests

**Vistas actualizadas:**
- `signin.blade.php` - Login de clientes
- `homev3.blade.php` - Formulario de contacto
- `contact.blade.php` - Contacto legacy
- `auth/custom-login.blade.php` - Login admin panel

**Bypass automático:**
```php
// Omite validación cuando:
// - APP_ENV=local o APP_ENV=testing
// - RECAPTCHA_ENABLED=false
```

### 2. Seguridad Multi-Tenant

Todas las consultas en controladores de clientes ahora validan el `company_id` del usuario autenticado:

```php
// ClientController - Validación obligatoria
$userCompanyId = $user->metas()->where('meta_key', 'company_id')->first()?->meta_value;

if ($user->isClient() && $userCompanyId != $company->id) {
    abort(403, 'No tiene permiso para acceder a esta empresa.');
}
```

**Controladores protegidos:**
- `ClientController@index` (Dashboard)
- `ClientController@myNews` (Lista de noticias)
- `ClientController@showNew` (Detalle de noticia)
- `ClientController@report` (Generador de reportes)
- `ClientController@getCovers` (Portafolio de covers)
- `ReportController@solicitados` (Lista de reportes)

### 3. Corrección de Filtrado en Vista → Controlador

**Vulnerabilidad corregida:**
```blade
{{-- ANTES (inseguro): Filtrado en vista --}}
@if($item->user_id == Auth::user()->id)

{{-- DESPUÉS: Filtrado en controlador --}}
$datos = ListReport::where('user_id', $user->id)->get();
```

---

## 🎨 Rediseño Visual (SaaS Modern Theme v3)

### Vistas Migradas

| Vista | Layout Anterior | Layout Nuevo | Estado |
|-------|----------------|--------------|--------|
| `signin.blade.php` | `layouts.home` | `home-clientv3` | ✅ |
| `mynews.blade.php` | `layouts.home` | `home-clientv3` | ✅ |
| `shownew.blade.php` | `layouts.home` | `home-clientv3` | ✅ |
| `covers.blade.php` | `layouts.home` | `home-clientv3` | ✅ |
| `dashboard.blade.php` | N/A (nuevo) | `home-clientv3` | ✅ |
| `list_solicitados.blade.php` | `layouts.home` | `home-clientv3` | ✅ |
| `report.blade.php` | `layouts.home` | `home-clientv3` | ✅ |

### Nuevos Componentes UI

1. **Dashboard de Cliente** (`dashboard.blade.php`)
   - Hero header con branding de compañía
   - KPI cards (hoy, mes, año, total)
   - Gráficos Chart.js (semanal y anual)
   - Distribución por medio y tendencias
   - Quick actions y reportes recientes

2. **Generador de Reportes** (`report.blade.php`)
   - Stats cards con métricas de tendencias
   - Filtros con Select2 estilizado
   - ApexCharts (donut, pie, line)
   - Tabla responsive con trend badges
   - Paginación estilizada

3. **Portafolio de Covers** (`covers.blade.php`)
   - Grid responsive de portadas
   - Filtrado por tabs (primeras, políticas, financieras, cartones)
   - Modales para contenido de columnas

### Sistema de Área Segura (Header Safe Area)

Variables CSS para evitar solapamiento con header fijo:

```css
:root {
    --header-safe-area: 160px;
}

@media (min-width: 1600px) { --header-safe-area: 180px; }
@media (min-width: 1920px) { --header-safe-area: 200px; }
```

---

## 🔧 Correcciones Técnicas

### 1. Error `Collection::total()` en Reportes

**Problema:** `simplePaginate()` retorna `SimplePaginator` sin método `total()`.

**Solución:**
```php
// Antes
->simplePaginate($paginate);
$notes->setPath(URL::full());

// Después
->paginate($paginate);
$notes->appends($request->except('page'));
```

### 2. Colores Consistentes con Style Guide

Actualización de colores warning según `ui-style.md`:

| Color | Antes | Después |
|-------|-------|---------|
| Warning | `#f59e0b` | `#fbbf24` |

### 3. Queries Optimizadas

- Uso de Query Builder en lugar de SQL raw con `str_replace()`
- Eager loading con `with()` para evitar N+1
- Parámetros seguros con bindings (prevención SQL injection)

---

## 📦 Archivos Nuevos

```
app/
├── Services/
│   └── RecaptchaV3Service.php
├── Rules/
│   └── RecaptchaV3.php
└── Http/Requests/
    └── ContactFormV3Request.php

resources/views/
├── homev3.blade.php
├── clients/
│   ├── dashboard.blade.php (NUEVO)
│   └── covers.blade.php (NUEVO)
└── layouts/
    └── home-clientv3.blade.php (NUEVO)

public/assets/clientv3/css/
└── theme-saas.css (NUEVO)

database/migrations/
└── 2026_01_02_XXXXXX_add_company_and_service_interest_to_contact_messages_table.php
```

---

## ⚙️ Instrucciones de Despliegue

### 1. Variables de Entorno

Agregar en `.env` de staging:

```env
# reCAPTCHA v3 (REQUERIDO)
RECAPTCHA_SITE_KEY=<obtener_de_google_recaptcha_admin>
RECAPTCHA_SECRET_KEY=<obtener_de_google_recaptcha_admin>
RECAPTCHA_MIN_SCORE=0.5
RECAPTCHA_ENABLED=true
```

> ⚠️ **Importante:** Las claves deben ser v3, no v2. Registrar dominios en [Google reCAPTCHA Admin](https://www.google.com/recaptcha/admin).

### 2. Migraciones

```bash
php artisan migrate
```

Migraciones pendientes:
- `add_company_and_service_interest_to_contact_messages_table` - Agrega campos `company` y `service_interest` a la tabla `contact_messages`

### 3. Cache

```bash
php artisan config:clear
php artisan config:cache
php artisan route:cache
php artisan view:clear
```

### 4. Assets (si aplica)

Los assets están en `public/assets/clientv3/` y no requieren compilación.

---

## 🧪 Testing

### Rutas a Validar

| Ruta | Método | Descripción |
|------|--------|-------------|
| `/cuenta` | GET/POST | Login de clientes con reCAPTCHA v3 |
| `/{company}/dashboard` | GET | Dashboard principal |
| `/{company}/mis-noticias` | GET | Lista de noticias |
| `/{company}/noticia/{id}` | GET | Detalle de noticia |
| `/{company}/reporte` | GET/POST | Generador de reportes |
| `/{company}/reportes/solicitados` | GET | Lista de reportes |
| `/{company}/secciones/{type}` | GET | Portafolio de covers |
| `/contacto-v3` | POST | Formulario de contacto |

### Casos de Prueba Multi-Tenant

1. ✅ Usuario cliente solo ve datos de su compañía
2. ✅ Intento de acceso a otra compañía retorna 403
3. ✅ Admin/Manager puede ver todas las compañías
4. ✅ Reportes solo muestran los del usuario actual

### Casos de Prueba reCAPTCHA

1. ✅ Login funciona en localhost sin claves v3 (`APP_ENV=local`)
2. ✅ Formulario de contacto valida score en producción
3. ✅ Error de validación muestra mensaje amigable

---

## 📸 Screenshots

> _Adjuntar capturas de: Dashboard, Reportes, Login, Portafolio de Covers_

---

## 🔗 Referencias

- **Style Guide:** `.claude/rules/ui-style.md`
- **Project Map:** `.claude/project-map.md`
- **Backend Standards:** `.claude/agents/backend-expert.md`

---

## ✅ Checklist Pre-Merge

- [ ] Variables de entorno configuradas en staging
- [ ] Migraciones ejecutadas
- [ ] Cache limpiado
- [ ] Claves reCAPTCHA v3 generadas para dominio staging
- [ ] Pruebas de login y contacto realizadas
- [ ] Validación multi-tenant verificada
- [ ] Screenshots adjuntos

---

**Autor:** Claude Code (Anthropic)
**Fecha:** 2026-01-26
**Reviewers:** @equipo-backend, @equipo-frontend
