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
            'http://172.16.209.1:8000/api/films'

        );
        return $reponseApi->toArray();
    }
    public function recupererFilmId(int $id):array
    {
        try {
            $reponseApi = $this->client->request(
                'GET',
               'http://172.16.209.1:8000/api/films/'.$id

            );
            return $reponseApi->toArray();
        }catch (\Exception $e){
            $error= json_decode($reponseApi->getContent(false));
            return ["code" => $error->Code, "message"=>$error->Erreur];
        }
    }
    public function reserverSeance(int $id,int $places,string $token):array
    {
        {
            try {
                $reponseApi = $this->client->request(
                    'POST',
                'http://172.16.209.1:8000/api/reserver/'.$id,

                    ['headers' => [
                        'Accept' => 'application/json',
                        'Content-Type' => 'application/json',
                        'Authorization' => 'Bearer '.$token,
                    ], 'body' => json_encode([
                        "NbPlaces" => $places,
                    ])
                    ]

                );
                return $reponseApi->toArray();
            } catch (\Exception $e) {
                $error = json_decode($reponseApi->getContent(false));
                return ["Code" => $error->Code, "Message" => $error->Erreur];
            }
        }
    }}