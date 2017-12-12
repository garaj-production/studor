<?php

namespace App\Controller;

use App\DTO\UserRegistrationDTO;
use App\Entity\User;
use App\Form\UserRegistrationType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends Controller
{
    /**
     * @Route("/login", name="login")
     *
     * @param AuthenticationUtils $authUtils
     *
     * @return Response
     */
    public function login(AuthenticationUtils $authUtils): Response
    {
        $error = $authUtils->getLastAuthenticationError();
        $lastEmail = $authUtils->getLastUsername();

        return $this->render(
            'security/login.html.twig',
            [
                'last_username' => $lastEmail,
                'error' => $error,
            ]
        );
    }

    /**
     * @Route("/registration", name="registration")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function registration(Request $request, UserPasswordEncoderInterface $encoder): Response
    {
        $userRegistrationDTO = new UserRegistrationDTO();
        $form = $this->createForm(UserRegistrationType::class, $userRegistrationDTO);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = new User(
                $userRegistrationDTO->name,
                $userRegistrationDTO->email,
                // @todo: fix this ugly hack
                $encoder->encodePassword(new User('', '', ''), $userRegistrationDTO->plainPassword)
            );

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($user);
            $manager->flush();

            $this->addFlash(
                'success',
                'Вы успешно зарегистрировались'
            );

            return $this->redirectToRoute('login');
        }

        return $this->render('security/registration.html.twig', ['form' => $form->createView()]);
    }
}
