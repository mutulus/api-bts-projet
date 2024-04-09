<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ApiUser
{
    private HttpClientInterface $client;

    /**
     * @param HttpClientInterface $client
     */
    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function CreerCompte(string $email, string $password):array
    {
        // Appel au modèle afin de récupérer les données
        try {
            $reponseApi = $this->client->request(
                'POST',
                'http://172.16.209.1:8000/api/register',
//                'http://127.0.0.1:8000/api/register',
                ['headers'=>[
                    'Accept'=>'application/json',
                    'Content-Type'=>'application/json'
                ],'body'=>json_encode([
                    "email"=>$email,
                    "password"=>$password
                ])
                ]

            );
            return $reponseApi->toArray();
        } catch (\Exception $e){
            $error= json_decode($reponseApi->getContent(false));
            return ["code" => $error->Code, "message"=>$error->Erreur];
        }
    }

}