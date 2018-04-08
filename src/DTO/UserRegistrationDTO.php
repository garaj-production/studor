<?php
declare(strict_types = 1);

namespace App\DTO;

use App\Validator\UniqueField;
use Symfony\Component\Validator\Constraints as Assert;

class UserRegistrationDTO
{
    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @Assert\Length(max="255")
     */
    public $name;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @Assert\Length(max="255")
     * @Assert\Email()
     * @UniqueField(class="App\Entity\User", field="email", message="Такой email уже существует")
     */
    public $email;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @Assert\Length(max="255")
     */
    public $plainPassword;
}
