# OPE-007: Sistema de Gestión de Costos

**Fecha:** 2026-02-02
**Branch:** `feature/news-cost-autocomplete`
**Estado:** Completado e Integrado

---

## Resumen

Sistema integral de gestión de tarifas que incluye modelo Rate, CRUD administrativo, importación masiva CSV, autocompletado dinámico en formularios de noticias y servicio de cálculo.

---

## Archivos Creados

| Archivo | Descripción |
|---------|-------------|
| `app/Models/Rate.php` | Modelo con relaciones y scopes |
| `app/Http/Controllers/RateController.php` | CRUD completo + importación CSV |
| `app/Services/CostCalculatorService.php` | Servicio de cálculo de tarifas |
| `database/migrations/2026_02_02_..._create_rates_table.php` | Migración con índices |
| `database/seeders/RateSeeder.php` | Seeder para datos iniciales |
| `resources/views/admin/rates/index.blade.php` | Listado de tarifas |
| `resources/views/admin/rates/create.blade.php` | Formulario de creación |
| `resources/views/admin/rates/show.blade.php` | Vista/edición de tarifa |
| `resources/views/admin/rates/import.blade.php` | Importación CSV |

## Archivos Modificados

| Archivo | Cambio |
|---------|--------|
| `routes/web.php` | Rutas CRUD de tarifas |
| `routes/api.php` | Endpoint `/api/admin/rates/lookup` |
| `resources/views/admin/news/create.blade.php` | JS autocompletado costo |
| `resources/views/admin/news/edit.blade.php` | JS autocompletado costo |
| `resources/views/admin/sidebar.blade.php` | Menú "Tarifarios" en Catálogos |

---

## Estructura del Modelo Rate

```php
// Campos
source_id, section_id, social_network_id, content_type
min_value, max_value, price, type, metadata

// Tipos
'social', 'internet', 'radio', 'tv', 'print'

// Content Types (Social)
'post', 'story', 'reel', 'video'
```

---

## Rutas Creadas

```php
// Admin Panel
/panel/tarifas           → RateController@index
/panel/tarifa/nueva      → RateController@showForm/create
/panel/tarifa/ver/{id}   → RateController@show
/panel/tarifa/importar   → RateController@showImportForm/import

// API
GET /api/admin/rates/lookup → RateController@lookup
```

---

## Resultado del Seeder

```bash
php artisan db:seed --class=RateSeeder
```

| Métrica | Cantidad |
|---------|----------|
| Nuevos registros | 2,007 |
| Actualizados | 607 |
| Total procesados | 2,614 |

**Distribución:**
- Social: 352 registros
- Internet: 1,655 registros

---

## Funcionalidad de Autocompletado

El campo de costo en el formulario de noticias se auto-rellena cuando:
1. Se selecciona una fuente y/o sección
2. Se cambia el alcance (followers) para redes sociales
3. Solo si el campo está vacío o es cero

---

*Archivado: 2026-02-02*
