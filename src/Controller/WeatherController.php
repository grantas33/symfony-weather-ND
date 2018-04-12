<?php

namespace App\Controller;

use App\Model\NullWeather;
use App\Weather\LoaderService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class WeatherController extends AbstractController
{
    public function index($day, LoaderService $weatherService)
    {
        try {
            $weather = $weatherService->loadWeatherByDay(new \DateTime($day));
        } catch (\Exception $exp) {
            $weather = new NullWeather();
        }

        return $this->render('weather/index.html.twig', [
            'weatherData' => [
                'date'      => $weather->getDate()->format('Y-m-d'),
                'dayTemp'   => $weather->getDayTemp(),
                'nightTemp' => $weather->getNightTemp(),
                'sky'       => $weather->getSky(),
            ],
        ]);
    }
}
