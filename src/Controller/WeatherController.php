<?php

namespace App\Controller;

use App\Model\NullWeather;
use App\Weather\LoaderService;
use App\Weather\ValidationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Psr\SimpleCache\InvalidArgumentException;
use Symfony\Component\HttpFoundation\Response;

class WeatherController extends AbstractController
{
    /**
     * @param               $day
     * @param LoaderService $weatherLoader
     * @param ValidationService $validationService
     * @return Response
     * @throws InvalidArgumentException
     */
    public function index($day, LoaderService $weatherLoader, ValidationService $validationService): Response
    {
        try {
            $validationService->validateWeatherByDay($day);
            $weather = $weatherLoader->loadWeatherByDay(new \DateTime($day));
        } catch (\Exception $exp) {
            $error = $exp->getMessage();
        }

        if(isset($error)){
            return $this->render('weather/error.html.twig', [
                'validationError' => $error
            ]);
        }



        return $this->render('weather/index.html.twig', [
            'weatherData' => [
                'date'      => $weather->getDate()->format('Y-m-d'),
                'dayTemp'   => $weather->getDayTemp(),
                'nightTemp' => $weather->getNightTemp(),
                'sky'       => $weather->getSky(),
                'provider'  => $weather->getProvider()
            ],
        ]);
    }
}
