<?php

class PriceCalculator
{
    public function calculateTotal(Order $order): float
    {
        $subtotal = $order->getSubtotal();
        $total = $subtotal;

        $baseDiscount = $order->getDiscountPercent();
        $memberDiscount = $order->getMemberDiscountPercent();

        if ($baseDiscount > 0) {
            $total = $total - ($total * ($baseDiscount / 100));
        }

        if ($memberDiscount > 0) {
            $total = $total - ($total * ($memberDiscount / 100));
        }

        return round($total, 2);
    }
}