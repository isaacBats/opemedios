# Opemedios UI Style Guide - SaaS Modern Theme v3

Este documento define las reglas de estilo para la interfaz de usuario de Opemedios. Todas las nuevas páginas y componentes deben seguir estas directrices para mantener consistencia visual.

---

## 1. Paleta de Colores

### Colores Primarios
```css
--ope-primary: #2563eb;        /* Azul corporativo principal */
--ope-primary-dark: #1d4ed8;   /* Hover states */
--ope-primary-light: #3b82f6;  /* Accents */
--ope-primary-lighter: #dbeafe; /* Backgrounds suaves */
```

### Colores Secundarios
```css
--ope-secondary: #0ea5e9;      /* Cyan complementario */
--ope-accent: #06b6d4;         /* Acentos */
```

### Colores Neutros
```css
--ope-dark: #1a1a1a;           /* Títulos, texto principal */
--ope-dark-soft: #374151;      /* Subtítulos */
--ope-gray-700: #4b5563;       /* Texto secundario fuerte */
--ope-gray-600: #6b7280;       /* Texto body principal */
--ope-gray-500: #9ca3af;       /* Texto terciario, labels */
--ope-gray-400: #d1d5db;       /* Bordes */
--ope-gray-300: #e5e7eb;       /* Bordes suaves */
--ope-gray-200: #f3f4f6;       /* Fondos alternos */
--ope-gray-100: #f9fafb;       /* Fondos de sección */
--ope-white: #ffffff;          /* Fondo principal */
```

### Gradientes
```css
--ope-gradient: linear-gradient(135deg, #2563eb 0%, #0ea5e9 100%);
--ope-gradient-soft: linear-gradient(135deg, #dbeafe 0%, #e0f2fe 100%);
```

### Colores Semánticos
- **Success**: `#10b981` (verde esmeralda)
- **Warning**: `#fbbf24` (amarillo ámbar)
- **Error**: `#ef4444` (rojo)
- **Info**: `#3b82f6` (azul)

---

## 2. Tipografía

### Fuente Principal
```css
font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
```

### Escala Tipográfica

| Elemento | Tamaño | Peso | Line Height |
|----------|--------|------|-------------|
| H1 (Hero) | `clamp(2.5rem, 6vw, 4rem)` | 800 | 1.1 |
| H2 (Sección) | `clamp(1.75rem, 4vw, 2.75rem)` | 800 | 1.3 |
| H3 (Card Title) | `1.25rem` | 700 | 1.4 |
| H4 (Subtitle) | `1.125rem` | 700 | 1.4 |
| Body | `1rem (16px)` | 400 | 1.7 |
| Body Large | `1.125rem` | 400 | 1.8 |
| Small | `0.875rem` | 500 | 1.5 |
| Caption | `0.75rem` | 500 | 1.4 |

### Reglas de Tipografía
- **Títulos**: Siempre en `--ope-dark` (#1a1a1a)
- **Body text**: En `--ope-gray-600` (#6b7280)
- **Letter spacing** en títulos grandes: `-0.02em` a `-0.03em`
- **Anti-aliasing**: Usar `-webkit-font-smoothing: antialiased`

---

## 3. Sistema de Títulos a Dos Pisos

El patrón distintivo de Opemedios v3. La primera línea es oscura, la segunda es azul con gradiente.

### Implementación
```html
<h1 class="hero-title">
    <span class="line-1">Texto en negro</span>
    <span class="line-2">Texto con gradiente azul</span>
</h1>
```

### Variante en Secciones
```html
<h2>
    Palabra normal <span class="text-gradient">Palabra destacada</span>
</h2>
```

### Clase `.text-gradient`
```css
.text-gradient {
    background: linear-gradient(135deg, #2563eb 0%, #0ea5e9 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}
```

---

## 4. Sombras (Box Shadow)

Usar sombras muy sutiles, estilo SaaS moderno. Evitar sombras agresivas.

```css
--shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
--shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.07), 0 2px 4px -1px rgba(0, 0, 0, 0.04);
--shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.08), 0 4px 6px -2px rgba(0, 0, 0, 0.04);
--shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.08), 0 10px 10px -5px rgba(0, 0, 0, 0.03);
--shadow-2xl: 0 25px 50px -12px rgba(0, 0, 0, 0.15);

/* Para tarjetas */
--shadow-card: 0 1px 3px rgba(0, 0, 0, 0.04), 0 4px 12px rgba(0, 0, 0, 0.06);
--shadow-card-hover: 0 4px 8px rgba(0, 0, 0, 0.06), 0 12px 24px rgba(0, 0, 0, 0.1);
```

### Regla de Uso
- **Cards en reposo**: `--shadow-card`
- **Cards en hover**: `--shadow-card-hover`
- **Modals/Dropdowns**: `--shadow-xl`
- **Hero images**: `--shadow-2xl`

---

## 5. Border Radius

```css
--radius-sm: 6px;      /* Inputs pequeños, badges */
--radius-md: 10px;     /* Botones, inputs */
--radius-lg: 16px;     /* Cards, contenedores */
--radius-xl: 24px;     /* Imágenes hero, modals */
--radius-full: 9999px; /* Pills, avatares, badges circulares */
```

---

## 6. Espaciado de Secciones

```css
--section-padding: 100px;        /* Desktop */
--section-padding-tablet: 80px;  /* Tablet */
--section-padding-mobile: 60px;  /* Mobile */
```

### Margin entre elementos
- Entre título de sección y contenido: `3rem`
- Entre cards: `1.5rem` (usando `gap` en grid/flex)
- Padding interno de cards: `2rem`

---

## 7. Componentes

### 7.1 Botones

#### Botón Primario
```html
<a href="#" class="btn-saas btn-saas-primary">
    Texto del botón
    <i class='bx bx-right-arrow-alt'></i>
</a>
```
- Background: Gradiente azul
- Color texto: Blanco
- Hover: `transform: translateY(-2px)` + sombra más intensa
- Padding: `14px 28px`

#### Botón Secundario
```html
<a href="#" class="btn-saas btn-saas-secondary">
    Texto del botón
</a>
```
- Background: Blanco
- Border: `1px solid --ope-gray-300`
- Color texto: `--ope-dark`
- Hover: Background `--ope-gray-100`

#### Tamaños
- Normal: `padding: 14px 28px`
- Large (`.btn-saas-lg`): `padding: 16px 32px`

### 7.2 Cards

#### Feature Card
```html
<div class="feature-card-modern">
    <div class="feature-icon">
        <i class='bx bx-icon'></i>
    </div>
    <span class="feature-number">01</span>
    <h3>Título</h3>
    <p>Descripción</p>
</div>
```
- Fondo: Blanco
- Border: `1px solid --ope-gray-200`
- Border radius: `--radius-lg`
- Hover: `translateY(-4px)` + sombra + border azul claro

#### Testimonial Card
```html
<div class="testimonial-card-modern">
    <div class="testimonial-header">
        <div class="testimonial-quote-icon">...</div>
        <div class="testimonial-rating">...</div>
    </div>
    <div class="testimonial-content">
        <p class="testimonial-text">"Texto del testimonio"</p>
    </div>
    <div class="testimonial-author">
        <img src="..." class="author-avatar">
        <div class="author-info">
            <h4>Nombre</h4>
            <p>Cargo</p>
        </div>
    </div>
</div>
```
- Fondo: Blanco
- Sombra: `--shadow-card`
- El texto del testimonio va en cursiva

### 7.3 Section Badge
```html
<span class="section-badge">
    <i class='bx bx-icon'></i>
    Texto del badge
</span>
```
- Background: `--ope-gradient-soft`
- Border radius: `--radius-full`
- Color texto: `--ope-primary`
- Padding: `8px 16px`

### 7.4 Service Pills (Selector)
```html
<div class="service-pills">
    <div class="service-pill">
        <input type="radio" name="servicio" id="servicio-1" value="valor">
        <label for="servicio-1">
            <i class='bx bx-icon'></i>
            Texto
        </label>
    </div>
</div>
```
- Estado normal: Fondo gris claro, sin borde
- Estado seleccionado: Fondo azul claro, borde azul
- Border radius: `--radius-full`

### 7.5 Inputs de Formulario
```html
<div class="form-group-modern">
    <label for="campo">Label</label>
    <input type="text" class="form-control-modern" placeholder="Placeholder">
</div>
```
- Background: `--ope-gray-100`
- Border: `2px solid transparent`
- Focus: Border `--ope-primary`, fondo blanco, outline con sombra azul

---

## 8. Iconografía

### Librería
Usar **Boxicons** (`bx bx-*`, `bx bxs-*`, `bx bxl-*`)

### Tamaños
- En botones: `1.25em` (relativo al texto)
- En feature icons: `1.5rem`
- En badges: `1rem`

### Contenedores de Iconos
```css
.feature-icon {
    width: 56px;
    height: 56px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--ope-gradient-soft);
    border-radius: var(--radius-md);
}
```

---

## 9. Animaciones y Transiciones

### Transiciones Base
```css
--transition-fast: 0.15s ease;
--transition-base: 0.25s ease;
--transition-slow: 0.4s ease;
```

### Animaciones de Entrada (AOS)
Usar `data-aos` para animaciones en scroll:
- `fade-up`: Elementos que entran de abajo
- `fade-left` / `fade-right`: Elementos laterales
- `fade-up` con `data-aos-delay`: Stagger effect en listas

### Hover Effects
- **Cards**: `transform: translateY(-4px)`
- **Botones primarios**: `transform: translateY(-2px)` + sombra
- **Links**: Color transition
- **Imágenes en cards**: `transform: scale(1.05)`

### Keyframes Disponibles
```css
@keyframes pulse-dot {
    0%, 100% { opacity: 1; transform: scale(1); }
    50% { opacity: 0.7; transform: scale(1.2); }
}

@keyframes float-y {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-15px); }
}
```

---

## 10. Estructura de Secciones

### Patrón Estándar
```html
<section class="nombre-section section-padding">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <div class="section-title-modern text-center">
                    <span class="section-badge">
                        <i class='bx bx-icon'></i>
                        Badge Text
                    </span>
                    <h2>
                        Primera parte <span class="text-gradient">Parte destacada</span>
                    </h2>
                    <p>Descripción de la sección</p>
                </div>
            </div>
        </div>
        <div class="row g-4 mt-2">
            <!-- Contenido -->
        </div>
    </div>
</section>
```

### Alternancia de Fondos
- Secciones impares: Fondo blanco (`--ope-white`)
- Secciones pares: Fondo gris claro (`--ope-gray-100` / `.bg-gray-light`)

---

## 11. Responsive Breakpoints

```css
/* Mobile first approach */
/* Base: Mobile */
/* sm: 576px+ */
/* md: 768px+ */
/* lg: 992px+ */
/* xl: 1200px+ */
/* xxl: 1400px+ */
```

### Ajustes Responsivos Clave
- **< 992px**: Hero visual debajo del contenido
- **< 768px**: Pills de servicio en columna
- **< 576px**: Reducir padding de secciones

---

## 12. Do's and Don'ts

### DO (Hacer)
- Usar el sistema de dos pisos para títulos importantes
- Mantener sombras sutiles y elegantes
- Usar transiciones suaves en todos los estados interactivos
- Mantener suficiente espacio en blanco
- Usar el gradiente azul para CTAs principales
- Incluir iconos en botones cuando mejoren la claridad

### DON'T (No Hacer)
- Usar colores fuera de la paleta definida
- Sombras duras o muy oscuras
- Bordes gruesos (máximo 2px en focus states)
- Demasiadas animaciones que distraigan
- Texto menor a 14px para body
- Mezclar diferentes estilos de botones en la misma sección

---

## 13. Archivo CSS de Referencia

El archivo principal del tema está en:
```
public/assets/clientv3/css/theme-saas.css
```

Incluir siempre después de `style.css` en el layout:
```html
<link rel="stylesheet" href="{{ asset('assets/clientv3/css/theme-saas.css') }}">
```

---

## 14. Ejemplos de Páginas

### Página de Referencia
`resources/views/homev3.blade.php` contiene la implementación completa del nuevo estilo con:
- Hero section con título a dos pisos
- Feature cards
- Testimonials modernos
- Formulario con service pills
- CTA sections

Usar esta página como referencia para nuevas implementaciones.
