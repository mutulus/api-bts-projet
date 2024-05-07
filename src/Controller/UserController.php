<?php

namespace App\Controller;

use App\Form\LoginType;
use App\Form\RegisterType;
use App\Model\UserModel;
use App\Service\ApiUser;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UserController extends AbstractController
{
    private ApiUser $apiUser;

    /**
     * @param ApiUser $apiUser
     */
    public function __construct(ApiUser $apiUser)
    {
        $this->apiUser = $apiUser;
    }

    #[Route('/register', name: 'app_register')]
    public function register(RequestStack $request): Response
    {
        $user = new UserModel();
        $form = $this->createForm(RegisterType::class, $user);

        $form->handleRequest($request->getCurrentRequest());
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $reponse = $this->apiUser->CreerCompte($user->getEmail(), $user->getPassword());

            if ($reponse["code"] === 201) {
                $this->addFlash("success", "Le compte a bien été créé");
                return $this->redirectToRoute('app_login');
            } else {
                $message = $reponse["message"];
                $form->get('email')->addError(new FormError($message));
            }


        }
        return $this->render('User/Register.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/login', name: 'app_login')]
    public function login(RequestStack $request): Response
    {
        $user = new UserModel();
        $form = $this->createForm(LoginType::class, $user);
        $form->handleRequest($request->getCurrentRequest());

        if ($form->isSubmitted() && $form->isValid()) {

            $user = $form->getData();
            $reponse = $this->apiUser->seLogin($user->getEmail(), $user->getPassword());

            if (!empty($reponse["token"] )) {
                $request->getSession()->set('Token', $reponse["token"]);
                $this->addFlash("success", "Connexion réussie");
                return $this->redirectToRoute("app_films");
            } else {
                $message = $reponse["message"];
                $form->get('email')->addError(new FormError($message));
            }
        }
        return $this->render('User/Login.html.twig', [
            'form' => $form
        ]);

    }

    #[Route('/logout', name: 'app_logout')]
    public function unlog(RequestStack $requestStack): Response
    {
        $requestStack->getSession()->remove('Token');
        $this->addFlash("success", "Vous avez bien été deconnecté");
        return $this->redirectToRoute("app_films");
    }
}
