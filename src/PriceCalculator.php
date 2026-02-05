<?php

class PriceCalculator
{
    public function calculateTotal(Order $order): float
    {
        $total = 0;

        foreach ($order->getItems() as $item) {
            $total += $item['price'] * 1;
        }

        $discount = $order->getDiscountPercent();
        if ($discount > 0) {
            $total = $total - ($total * ($discount / 100));
        }

        return round($total, 2);
    }
}