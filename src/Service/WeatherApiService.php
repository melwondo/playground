<?php


namespace App\Service;

use http\Exception\InvalidArgumentException;
use HttpRequestException;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class WeatherApiService
{
    private $apiKey;

    private $base_uri;
    /**
     * @var HttpClientInterface
     */
    private $httpClient;

    /**
     * WeatherApiService constructor.
     * @param $apiKey string
     * @param $base_uri string
     * @param HttpClientInterface $httpClient
     */
    public function __construct($apiKey, $base_uri ,HttpClientInterface $httpClient)
    {
        $this->apiKey = $apiKey;
        $this->base_uri = $base_uri;
        $this->httpClient = $httpClient;
    }

    /**
     * @return array
     * @throws ServerExceptionInterface
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function openWeather()
    {
        $name = 'schiltigheim';
        $response = $this->httpClient->request(
            'GET',
            '/data/2.5/weather?q='.$name.'&units=metric&appid='.$this->apiKey,
            [
                'base_uri' => $this->base_uri
            ]
        );

        if (200 !== $response->getStatusCode()) {
            $content = 'Cette ville n\'existe pas';
        } else {
            $content = $response->toArray();
        }
        return $content;
    }

    /**
     * @param $city
     * @return array
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function searchWeatherByCity($city)
    {
        $response = $this->httpClient->request(
            'GET',
            '/data/2.5/weather?q='.$city.'&units=metric&appid='.$this->apiKey,
            [
                'base_uri' => $this->base_uri
            ]
        );

        if (200 !== $response->getStatusCode()) {
            $content = 'Cette ville n\'existe pas';
        } else {
            $content = $response->toArray();
        }
        return $content;
    }
}