<?php
declare(strict_types = 1);

namespace App\Controller;

use App\DTO\UserRegistrationDTO;
use App\Entity\User;
use App\Form\UserRegistrationType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends Controller
{
    /**
     * @var AuthenticationUtils
     */
    private $authUtils;

    /**
     * @var PasswordEncoderInterface
     */
    private $encoder;

    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    public function __construct(
        AuthenticationUtils $authUtils,
        PasswordEncoderInterface $encoder,
        TokenStorageInterface $tokenStorage
    ) {
        $this->authUtils = $authUtils;
        $this->encoder = $encoder;
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * @Route("/login", name="login")
     *
     * @return Response
     */
    public function login(): Response
    {
        $error = $this->authUtils->getLastAuthenticationError();
        $lastEmail = $this->authUtils->getLastUsername();

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
     * @param PasswordEncoderInterface $encoder
     * @param TokenStorageInterface $tokenStorage
     *
     * @return Response
     */
    public function registration(Request $request): Response
    {
        $userRegistrationDTO = new UserRegistrationDTO();
        $form = $this->createForm(UserRegistrationType::class, $userRegistrationDTO);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = new User(
                $userRegistrationDTO->name,
                $userRegistrationDTO->email,
                $this->encoder->encodePassword($userRegistrationDTO->plainPassword, '')
            );

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($user);
            $manager->flush();

            $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
            $this->tokenStorage->setToken($token);

            $this->addFlash('success', 'Вы успешно зарегистрировались');

            return $this->redirectToRoute('homepage');
        }

        return $this->render('security/registration.html.twig', ['form' => $form->createView()]);
    }
}
