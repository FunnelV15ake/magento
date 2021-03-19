<?php

declare(strict_types=1);

namespace GetResponse\GetResponseIntegration\Api;

class Order
{
    private $id;
    private $cartId;
    private $contactEmail;
    private $customer;
    private $lines;
    private $url;
    private $totalPrice;
    private $totalPriceTax;
    private $shippingPrice;
    private $currency;
    private $status;
    private $billingStatus;
    private $shippingAddress;
    private $billingAddress;
    private $createdAt;
    private $updatedAt;

    public function __construct(
        int $id,
        int $cartId,
        string $contactEmail,
        Customer $customer,
        array $lines,
        ?string $url,
        float $totalPrice,
        float $totalPriceTax,
        float $shippingPrice,
        string $currency,
        string $status,
        ?string $billingStatus,
        Address $shippingAddress,
        Address $billingAddress,
        string $createdAt,
        ?string $updatedAt
    ) {
        $this->id = $id;
        $this->cartId = $cartId;
        $this->contactEmail = $contactEmail;
        $this->customer = $customer;
        $this->lines = $lines;
        $this->url = $url;
        $this->totalPrice = $totalPrice;
        $this->totalPriceTax = $totalPriceTax;
        $this->shippingPrice = $shippingPrice;
        $this->currency = $currency;
        $this->status = $status;
        $this->billingStatus = $billingStatus;
        $this->shippingAddress = $shippingAddress;
        $this->billingAddress = $billingAddress;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    public function toApiRequest(string $callbackType): array
    {
        $lines = [];
        foreach ($this->lines as $line) {
            $lines[] = $line->toApiRequest();
        }

        return [
            'callback_type' => $callbackType,
             'id' => $this->id,
             'cart_id' => $this->cartId,
             'contact_email' => $this->contactEmail,
             'customer' => $this->customer->toApiRequest(),
             'lines' => $lines,
             'url' => $this->url,
             'total_price' => $this->totalPrice,
             'total_tax_price' => $this->totalPriceTax,
             'shipping_price' => $this->shippingPrice,
             'currency' => $this->currency,
             'status' => $this->status,
             'billing_status' => $this->billingStatus,
             'shipping_address' => $this->shippingAddress->toApiRequest(),
             'billing_address' => $this->billingAddress->toApiRequest(),
             'created_at' => $this->createdAt,
             'updated_at' => $this->updatedAt,


        ];
    }
}
