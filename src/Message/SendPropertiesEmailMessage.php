<?php

namespace App\Message;

final class SendPropertiesEmailMessage
{
    private string $email;
    private array $properties;

    public function __construct($email, $properties)
    {
        $this->email = $email;
        $this->properties = $properties;
    }

    public function getProperties(): array
    {
        return $this->properties;
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}
