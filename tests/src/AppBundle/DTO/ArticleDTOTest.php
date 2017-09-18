<?php

namespace Tests\AppBundle\DTO;

use AppBundle\DTO\ArticleDTO;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Tests\TestCase;

class ArticleDTOTest extends TestCase
{
    protected $fixturePath = '/AppBundle/DTO/ArticleDTOTest.yml';

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
     * @param int $errorsCount
     * @param string $title
     * @param string $slug
     * @param string $text
     */
    public function testValidation(int $errorsCount, string $title, string $slug, string $text)
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
            'no_errors' => [0, 'title', 'slug', 'text'],
            'too long slug' => [1, 'title', '123123123123123123123123121231231212113123123123123123123123123123123132132132132132311231231231231231231231231231231212312312121131231231231231231231231231231231321321321321323112312312312312312312312312312312123123121211312312312312312312312312312312313213213213213231123123', 'text'],
            'too long title and slug' => [2, '123123123123123123123123121231231212113123123123123123123123123123123132132132132132311231231231231231231231231231231212312312121131231231231231231231231231231231321321321321323112312312312312312312312312312312123123121211312312312312312312312312312312313213213213213231123123', '123123123123123123123123121231231212113123123123123123123123123123123132132132132132311231231231231231231231231231231212312312121131231231231231231231231231231231321321321321323112312312312312312312312312312312123123121211312312312312312312312312312312313213213213213231123123', 'text'],
            'not unique slug' => [1, 'title', 'slug_fixture', 'text'],
        ];
    }

    private function getValidator(): ValidatorInterface
    {
        return $this->get('validator');
    }
}
