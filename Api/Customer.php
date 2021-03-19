<?php

declare(strict_types=1);

namespace GetResponse\GetResponseIntegration\Api;

class Customer
{
    private $id;
    private $email;
    private $firstName;
    private $lastName;
    private $isMarketingAccepted;
    private $tags;
    private $customFields;

    public function __construct(
        int $id,
        string $email,
        string $firstName,
        string $lastName,
        bool $isMarketingAccepted,
        array $tags,
        array $customFields
    ) {
        $this->id = $id;
        $this->email = $email;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->isMarketingAccepted = $isMarketingAccepted;
        $this->tags = $tags;
        $this->customFields = $customFields;
    }

    public function toApiRequest(): array
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'accepts_marketing' => $this->isMarketingAccepted,
            'tags' => $this->tags,
            'customFields' => $this->customFields
        ];
    }
}
