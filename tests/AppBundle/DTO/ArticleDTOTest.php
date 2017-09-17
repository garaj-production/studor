<?php

namespace Tests\AppBundle\DTO;

use AppBundle\DTO\ArticleDTO;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Tests\ContainerAwareTestCase;

class ArticleDTOTest extends ContainerAwareTestCase
{
    public function testGettingData()
    {
        $article = new ArticleDTO();

        $article->title = 'title';
        $article->slug = 'slug';
        $article->text = 'text';

        $this->assertEquals('title', $article->title);
        $this->assertEquals('slug', $article->slug);
        $this->assertEquals('text', $article->text);
    }

    /**
     * @dataProvider validationProvider
     *
     * @param string $title
     * @param string $slug
     * @param string $text
     * @param int $errorsCount
     */
    public function testValidation(string $title, string $slug, string $text, int $errorsCount)
    {
        $article = new ArticleDTO();
        $article->title = $title;
        $article->slug = $slug;
        $article->text = $text;

        $validator = $this->getValidator();

        $errors = $validator->validate($article);

        $this->assertCount($errorsCount, $errors);
    }

    public function validationProvider(): array
    {
        return [
            ['title', 'slug', 'text', 0],
            ['title', '123123123123123123123123121231231212113123123123123123123123123123123132132132132132311231231231231231231231231231231212312312121131231231231231231231231231231231321321321321323112312312312312312312312312312312123123121211312312312312312312312312312312313213213213213231123123', 'text', 1],
            ['123123123123123123123123121231231212113123123123123123123123123123123132132132132132311231231231231231231231231231231212312312121131231231231231231231231231231231321321321321323112312312312312312312312312312312123123121211312312312312312312312312312312313213213213213231123123', '123123123123123123123123121231231212113123123123123123123123123123123132132132132132311231231231231231231231231231231212312312121131231231231231231231231231231231321321321321323112312312312312312312312312312312123123121211312312312312312312312312312312313213213213213231123123', 'text', 2],
        ];
    }

    private function getValidator(): ValidatorInterface
    {
        return $this->get('validator');
    }
}
