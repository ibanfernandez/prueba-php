
## 📋 Resumen de la prueba

Esta prueba implementa un sistema de cálculo de totales con aplicación de descuentos. Se desarrollaron dos ramas principales que posteriormente se fusionaron:

- **`fix/calculate-total`** — Corrección de bug en el cálculo del subtotal
- **`feat/member-discount`** — Nueva funcionalidad de descuento para miembros + refactorización
- **`master`** — Rama principal con ambas mejoras integradas

---

## 🐛 Bug Identificado (Tarea 1)

El cálculo del subtotal **no consideraba la cantidad** (`quantity`) de cada item, generando totales incorrectos.

**Problema específico:**
```php
// ❌ Antes
$subtotal += $item['price'] * 1;

// ✅ Después
$subtotal += $item['price'] * $item['quantity'];
```

---

## 🔧 Solución Implementada (Tarea 1)

En la rama `fix/calculate-total` se realizó una corrección puntual:

- Modificación de la línea que multiplicaba por `1` para usar `price * quantity`
- Sin extracción de métodos adicionales (fix mínimo)

---

## ⚠️ Nota sobre Branching y Refactorización

La rama `feat/member-discount` se creó desde `master` **antes** del merge del fix. Por tanto:

- Fue necesario mover la lógica del subtotal de `PriceCalculator` a `Order::getSubtotal()`
- Esto permitió reutilizar el cálculo en `getMemberDiscountPercent()`
- La corrección del `quantity` también aparece en esta rama para mantener coherencia

---

## ✨ Nuevas Funcionalidades (Tarea 2)

### Método `Order::getMemberDiscountPercent()`

Calcula el descuento aplicable a miembros según estas reglas:

| Condición | Descuento |
|-----------|-----------|
| `subtotal > 100€` **Y** `isGuest = false` | **5%** |
| Otros casos | **0%** |

### Refactorización Realizada

1. **Extracción de `getSubtotal()`** a la clase `Order`
   - Centraliza el cálculo `price × quantity`
   - Reutilizable desde `PriceCalculator` y `getMemberDiscountPercent()`

2. **Actualización de `PriceCalculator::calculateTotal()`**
   - Obtiene subtotal mediante `Order::getSubtotal()`
   - Aplica descuentos en cascada (miembro → descuento base)
   - Retorna total redondeado a 2 decimales

---

## 🎯 Decisiones Técnicas

**Nomenclatura de descuentos:**
- `discountPercent` → Descuento base del pedido
- `getMemberDiscountPercent()` → Descuento específico

**Aplicación en cascada:**
```
Subtotal: 110.00€
- Descuento miembro (5%): -5.50€
= Subtotal con descuento: 104.50€
- Descuento base (10%): -10.45€
= Total final: 94.05€
```

---

## 📜 Historial de Commits

### Rama `fix/calculate-total`
- Corrección mínima del bug (inclusión de `quantity`)

### Rama `feat/member-discount`
- Refactorización del subtotal a `Order`
- Implementación del descuento de miembros
- Corrección del bug integrada por coherencia

### Rama `master`
- Merge de ambas ramas con historial completo preservado

---

## 🧪 Pruebas

### Ejecutar el script:
```bash
php index.php
```

### Resultado esperado:
```
Total del pedido: 94.05€
```

---