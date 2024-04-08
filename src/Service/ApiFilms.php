<?php

namespace App\Service;
use Symfony\Contracts\HttpClient\HttpClientInterface;
class ApiFilms
{
    private HttpClientInterface $client;

    /**
     * @param HttpClientInterface $client
     */
    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function recupererFilms():array{
        $reponseApi = $this->client->request(
            'GET',
//            'http://172.16.209.1:8000/api/films'
            'http://127.0.0.1:8000/api/films'
        );
        return $reponseApi->toArray();
    }
    public function recupererFilmId(int $id):array
    {
        $reponseApi = $this->client->request(
            'GET',
//            'http://172.16.209.1:8000/api/films/'.$id
            'http://127.0.0.1:8000/api/films/'.$id
        );
        return $reponseApi->toArray();
    }

}