<?php

namespace App\Weather;

use App\GoogleApi\WeatherService;
use App\Model\Weather;

class LoaderService
{

    /** @var WeatherService */
    private $googleWeatherService;

    /**
     * LoaderService constructor.
     * @param WeatherService $googleWeatherService
     */
    public function __construct(WeatherService $googleWeatherService)
    {
        $this->googleWeatherService = $googleWeatherService;
    }

    /**
     * @param \DateTime $day
     * @return Weather
     * @throws \Exception
     */
    public function loadWeatherByDay(\DateTime $day): Weather
    {
        return $this->googleWeatherService->getDay($day);
    }
}
