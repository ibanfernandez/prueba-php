Resumen
- Proyecto de prueba para calcular el total de un pedido aplicando descuentos.
- Ramas relevantes: `fix/calculate-total` (bug), `feat/member-discount` (feature + refactor). Ambas fusionadas en la rama principal (`main`/`master`).

Qué bug encontré (Tarea 1)
- El subtotal no tenía en cuenta la cantidad (`quantity`) de cada item, produciendo subtotales incorrectos.

Cómo lo solucioné (Tarea 1)
- En la rama `fix/calculate-total` corregí la línea concreta que multiplicaba por `1` y la cambié por `price * quantity`. No se extrajo ningún método en esa rama; fue una corrección puntual.

Nota sobre branching y refactor
- Al crear la rama de feature desde `main` (sin el commit del fix), para implementar la nueva regla fue necesario mover la lógica del subtotal de `PriceCalculator` a `Order::getSubtotal()` para poder reutilizarla en `getMemberDiscountPercent()`. Por coherencia interna, la corrección del `quantity` también aparece en la rama `feat/member-discount`.

Cambios realizados (Tarea 1)
- Fix: sustituir la multiplicación por `1` por `price * quantity` en el cálculo.

Cambios realizados (Tarea 2)
- Nuevo método: `Order::getMemberDiscountPercent()` — devuelve 5 (5%) si `getSubtotal() > 100` y `isGuest === false`, sino 0.
- Refactor: extraído `getSubtotal()` a `Order` para centralizar `price * quantity` para reutilizar ese cálculo en `getMemberDiscountPercent()` y también en `PriceCalculator`.
- `PriceCalculator::calculateTotal()` ahora:
  - Obtiene subtotal con `Order::getSubtotal()`.
  - Aplica los descuentos en cascada (descuento de miembro y descuento base del pedido).
  - Devuelve el total redondeado a 2 decimales.

Decisiones técnicas relevantes
- Mantener `discountPercent` como nombre interno; añadir `getMemberDiscountPercent()` para distinguir tipos de descuento.
- Aplicación de descuentos en cascada. En el ejemplo dado esto produce `94.05€`.

Historial y commits
- Se conservaron las ramas `fix/calculate-total` y `feat/member-discount`.
- En `fix/calculate-total` se aplicó la corrección mínima (incluir quantity).
- En `feat/member-discount` se hizo el refactor (mover subtotal a Order) y la implementación del member discount; la corrección del subtotal también está presente en esa rama para garantizar coherencia al probar y mergear.
- Ambas ramas fueron mergeadas en la rama principal para entregar el historial completo.

Cómo probar
1. Ejecutar: `php index.php`
2. Resultado esperado con los datos de ejemplo: `Total del pedido: 94.05€`