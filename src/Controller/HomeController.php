<?php

namespace App\Controller;

use App\Service\WeatherApiService;
use HttpRequestException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @param WeatherApiService $apiService
     * @return Response
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function index(WeatherApiService $apiService)
    {
        $weather = $apiService->openWeather();

        return $this->render('home/index.html.twig', [
            'weather' => $weather,
        ]);
    }

    /**
     * @Route("/weather_city", name="weather_city")
     * @param Request $request
     * @param WeatherApiService $apiService
     * @return JsonResponse|Response
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function searchWeatherByCity(Request $request, WeatherApiService $apiService)
    {
        $response = 'Cette ville n\'existe pas';
        if($request->get('input_city') && preg_match('/[a-zA-Z]+/',$request->get('input_city'))){
            $city = $request->get('input_city');
            $value = $apiService->searchWeatherByCity($city);
            $response =  $value;
            return new JsonResponse($response);
        }
        return new JsonResponse($response);
    }
}
