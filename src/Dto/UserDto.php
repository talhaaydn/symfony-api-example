<?php

namespace App\Dto;

use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

class UserDto
{
    /**
     * @Groups({"create"})
     * @Assert\NotBlank()
     * @var string
     */
    public string $email;

    /**
     * @Groups({"create"})
     * @Assert\NotBlank()
     * @var string
     */
    public string $password;
}