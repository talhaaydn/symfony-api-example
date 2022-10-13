<?php

namespace App\Dto;

use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

class ProductDto
{
    /**
     * @Groups({"create", "update"})
     * @Assert\NotBlank()
     * @var string
     */
    public string $name;

    /**
     * @Groups({"create", "update"})
     * @Assert\NotBlank()
     * @Assert\GreaterThan(value="0")
     * @var float
     */
    public float $price;
}