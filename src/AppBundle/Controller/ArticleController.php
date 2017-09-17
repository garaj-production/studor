<?php

namespace AppBundle\Controller;

use AppBundle\DTO\ArticleDTO;
use AppBundle\Entity\Article;
use AppBundle\Form\NewArticleType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends Controller
{
    /**
     * @Route("/article/new", name="article_new")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function newArticleAction(Request $request): Response
    {
        $articleDTO = new ArticleDTO();

        $form = $this->createForm(NewArticleType::class, $articleDTO);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $article = Article::createFromDTO($articleDTO);
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($article);
            $manager->flush();

            return $this->redirectToRoute('article_new');
        }

        return $this->render(
            'article/new.htnl.twig',
            ['form' => $form->createView()]
        );
    }
}
