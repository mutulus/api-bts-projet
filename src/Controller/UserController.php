<?php

namespace App\Controller;

use App\Form\RegisterType;
use App\Model\UserModel;
use App\Service\ApiUser;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
    $form=$this->createForm(RegisterType::class,$user);

    $form->handleRequest($request->getCurrentRequest());
    if ($form->isSubmitted() && $form->isValid()) {
        $user = $form->getData();
        $reponseApi = $this->apiUser->CreerCompte($user->getEmail(), $user->getPassword());

        if (isset($message)){
            return $this->render('User/Register.html.twig', [
                'form'=>$form,
                'erreur'=>$message
            ]);
        }
        $this->addFlash("success","Ce compte a bien été créé");
        $this->redirectToRoute("app_films");
    }
        return $this->render('User/Register.html.twig', [
            'form'=>$form,
        ]);
    }
}
