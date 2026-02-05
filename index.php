<?php

require_once __DIR__ . '/src/Order.php';
require_once __DIR__ . '/src/PriceCalculator.php';

$order = new Order(10, false); // 10% de descuento, no es invitado

$order->addItem('Camiseta', 20, 2);  
$order->addItem('Pantalón', 50, 1);  
$order->addItem('Calcetines', 5, 4);

// Total esperado antes de descuentos: 110
// Con 10%: 99
// Con regla nueva (si aplica): 94.05

$calculator = new PriceCalculator();
$total = $calculator->calculateTotal($order);

echo "Total del pedido: " . $total . "€\n";