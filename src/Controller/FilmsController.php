<?php

namespace App\Controller;

use App\Service\ApiFilms;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
    public function recupererFilmId(int $id): Response
    {
        $contenu = $this->service->recupererFilmId($id);
        if ($contenu["code"] === 201) {
            foreach ($contenu[0][0]['seances'] as &$seance) {
                $date = new \DateTime($seance['dateProjection']);
                $date = $date->format('d/m/y H:i');
                $seance['dateProjection'] = $date;
            }
            return $this->render('films/filmDetail.html.twig', [
                'film' => $contenu]);
        } else {
            return $this->render('films/filmDetail.html.twig', [
                'erreur' => $contenu]);
        }
    }

}
