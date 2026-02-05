<?php

class Order
{
    private array $items = [];
    private float $discountPercent;
    private bool $isGuest;

    public function __construct(float $discountPercent, bool $isGuest)
    {
        $this->discountPercent = $discountPercent;
        $this->isGuest = $isGuest;
    }

    public function addItem(string $name, float $price, int $quantity): void
    {
        $this->items[] = [
            'name' => $name,
            'price' => $price,
            'quantity' => $quantity,
        ];
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function getSubtotal(): float
    {
        $subtotal = 0;
        foreach ($this->items as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }
        return $subtotal;
    }

    public function getDiscountPercent(): float
    {
        return $this->discountPercent;
    }

    public function getMemberDiscountPercent(): float
    {
        return ($this->getSubtotal() > 100 && !$this->isGuest) ? 5 : 0;
    }

    public function isGuest(): bool
    {
        return $this->isGuest;
    }
}
