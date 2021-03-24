<?php

declare(strict_types=1);

namespace GetResponse\GetResponseIntegration\Api;

use JsonSerializable;

class Variant implements JsonSerializable
{
    private $id;
    private $name;
    private $sku;
    private $price;
    private $priceTax;
    private $previousPrice;
    private $previousPriceTax;
    private $quantity;
    private $position;
    private $barcode;
    private $description;
    /** @var null|Image[] */
    private $images;

    public function __construct(
        int $id,
        string $name,
        string $sku,
        float $price,
        float $priceTax,
        ?float $previousPrice,
        ?float $previousPriceTax,
        int $quantity,
        ?int $position,
        ?int $barcode,
        string $description,
        ?array $images
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->sku = $sku;
        $this->price = $price;
        $this->priceTax = $priceTax;
        $this->previousPrice = $previousPrice;
        $this->previousPriceTax = $previousPriceTax;
        $this->quantity = $quantity;
        $this->position = $position;
        $this->barcode = $barcode;
        $this->description = $description;
        $this->images = $images;
    }

    public function jsonSerialize(): array
    {
        $images = [];
        foreach ($this->images as $image) {
            $images[] = $image->jsonSerialize();
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'sku' => $this->sku,
            'price' => $this->price,
            'price_tax' => $this->priceTax,
            'previous_price' => $this->previousPrice,
            'previous_price_tax' => $this->previousPriceTax,
            'quantity' => $this->quantity,
            'position' => $this->position,
            'barcode' => $this->barcode,
            'description' => $this->description,
            'images' => $images
        ];
    }
}
