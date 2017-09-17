<?php

namespace AppBundle\DTO;

use AppBundle\Validator\UniqueField;
use Symfony\Component\Validator\Constraints as Assert;

class ArticleDTO
{
    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @Assert\Length(max="255")
     */
    public $title;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @Assert\Length(max="255")
     * @UniqueField(class="AppBundle\Entity\Article", field="slug", message="Такой символьный код уже существует")
     */
    public $slug;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     */
    public $text;
}
