# Índice del Directorio .claude

> **Propósito:** Inventario maestro para navegación rápida
> **Última actualización:** 2026-02-02

---

## Estructura de Carpetas

```
.claude/
├── index.md                    ← Este archivo
├── active-session.md           ← LEER PRIMERO
├── project-map.md              ← Arquitectura (solo consulta)
│
├── agents/
│   ├── backend-expert.md       ← PHP/Laravel
│   └── frontend-expert.md      ← CSS/Blade/Vue
│
├── rules/
│   └── ui-style.md             ← FUENTE DE VERDAD UI
│
├── history/
│   ├── OPE-001-theme-saas-v3-foundation.md
│   ├── OPE-002-client-module-redesign.md
│   ├── OPE-003-covers-dashboard-reports.md
│   ├── OPE-004-cicd-navigation.md
│   ├── OPE-005-dashboard-fixes.md
│   ├── OPE-006-staging-direct-refactor.md
│   ├── OPE-007-cost-management-system.md
│   ├── PR-001-staging-initial.md
│   └── PR-002-staging-refactor.md
│
├── doc/                        ← (vacío)
└── hooks/                      ← (vacío)
```

---

## Prioridad de Lectura

| Orden | Archivo | Cuándo |
|-------|---------|--------|
| 1 | `active-session.md` | **SIEMPRE** al inicio |
| 2 | `rules/ui-style.md` | Solo si tarea es frontend |
| 3 | `history/OPE-*.md` | Solo si necesitas contexto histórico |

---

## Historial de Sesiones

| ID | Título | Fecha | Resumen |
|----|--------|-------|---------|
| OPE-001 | Theme SaaS v3 | 2024-12-30 | Tema, docs, agentes |
| OPE-002 | Client Module | 2026-01-24 | Login, noticias, reCAPTCHA |
| OPE-003 | Covers/Dashboard | 2026-01-26 | Covers, dashboard, reportes |
| OPE-004 | CI/CD | 2026-01-27 | PHPStan, menú condicional |
| OPE-005 | Dashboard Fixes | 2026-01-31 | Logo +30%, multi-tenant |
| OPE-006 | Staging Direct Refactor | 2026-01-31 | UI/UX, seguridad, backend fixes |
| OPE-007 | Cost Management System | 2026-02-02 | Rate model, CRUD, CSV import, autocompletado |

## Pull Requests

| ID | Archivo | Destino |
|----|---------|---------|
| PR-001 | `PR-001-staging-initial.md` | staging |
| PR-002 | `PR-002-staging-refactor.md` | staging (consolidado) |

---

## Notas Rápidas

1. **UI:** `rules/ui-style.md` es la fuente de verdad
2. **Seguridad:** Multi-tenant obligatorio en ClientController
3. **reCAPTCHA:** Claves v3 pendientes para producción
4. **Tarifarios:** CSV master en `tarifario/master_tarifario_opemedios.csv`, acceso vía Catálogo > Tarifarios
