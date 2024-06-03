<?php

namespace App\Controller;

use App\Form\ReservationType;
use App\Model\ReservationModel;
use App\Service\ApiFilms;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class FilmsController extends AbstractController
{


    private ApiFilms $service;

    /**
     * @param ApiFilms $service
     */
    public function __construct(ApiFilms $service)
    {
        $this->service = $service;
    }

    #[Route('/', name: 'app_films')]
    public function index(): Response
    {
        $contenu = $this->service->recupererFilms();
        return $this->render('films/index.html.twig', ['films' => $contenu]);
    }

    #[Route('/film/{id}', name: 'app_film_detail')]
    public function recupererFilmId(int $id, RequestStack $request): Response
    {
        $message = "";
        if ($request->getCurrentRequest()->getRealMethod() === 'POST') {
            $nbPlaces = $request->getCurrentRequest()->get("places");
            $idSeance = $request->getCurrentRequest()->get("idSeance");
            $token = $request->getSession()->get('Token');
            if (empty($token)) {
                return $this->render('films/filmDetail.html.twig', [
                    'formError' => 'Veuillez vous connecter afin de réserver une séance']);
            }
            $reponse = $this->service->reserverSeance($idSeance, $nbPlaces, $token);

//            $montant = $reservationNew->getPrixTotal() * $reservationNew->getNbPlaces();
//            $reponse = $this->service->reserverSeance($idSeance, $reservationNew->getNbPlaces(), $montant);
            if ($reponse["Code"] == 200) {
                $this->addFlash("success", "La réservation a bien été effectuée");
                return $this->redirectToRoute('app_films');
            } else {
                $message = $reponse["Message"];
                return $this->render('films/filmDetail.html.twig', [
                    'formError' => $message]);
            }
        } else {

//        } else {
            $contenu = $this->service->recupererFilmId($id);
            if ($contenu["code"] >= 200 and $contenu["code"] <= 299) {
                foreach ($contenu[0][0]['seances'] as &$seance) {
                    $date = new \DateTime($seance['dateProjection']);
                    $date = $date->format('d/m/y H:i');
                    $seance['dateProjection'] = $date;
                }
                return $this->render('films/filmDetail.html.twig', [
                    'film' => $contenu,
                    'formError' => $message
                ]);
            } else {
                return $this->render('films/filmDetail.html.twig', [
                    'erreur' => $contenu,
                    'formError' => $message
                ]);
            }

        }
    }
}
//    #[Route('/film/{id}', name: 'app_film_seances')]
//    public function reservationFilm(RequestStack $request): Response
//    {
//        $reservation = new ReservationModel();
//
//        $form = $this->createForm(ReservationType::class, $reservation);
//        $form->handleRequest($request->getCurrentRequest());
//        if ($form->isSubmitted() && $form->isValid()) {
//            $reservationNew = $form->getData();
//            $idSeance = $form->get('idSeance')->getData();
//        }
//        return $this->render('films/filmDetail.html.twig', [
//            'film' => 'heyyy'
//            ]);
//    }

