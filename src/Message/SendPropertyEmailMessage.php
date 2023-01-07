<?php

namespace App\Message;

use App\Entity\Property;

final class SendPropertyEmailMessage
{
    private Property $property;

    public function __construct($property)
    {
        $this->property = $property;
    }

    public function getProperty(): Property
    {
        return $this->property;
    }
}
