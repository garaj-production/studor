<?php

namespace App\Controller;

use App\DTO\ArticleDTO;
use App\Entity\Article;
use App\Form\NewArticleType;
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
            $article = new Article(
                $articleDTO->title,
                $articleDTO->slug,
                $articleDTO->text
            );

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($article);
            $manager->flush();

            $this->addFlash(
                'success',
                'Статья успешно создана и отправлена на модерацию!'
            );

            return $this->redirectToRoute('article_new');
        }

        return $this->render(
            'article/new.htnl.twig',
            ['form' => $form->createView()]
        );
    }
}
