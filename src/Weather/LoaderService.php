<?php

namespace App\Weather;

use App\GoogleApi\WeatherService;
use App\Model\Weather;
use Symfony\Component\Cache\Simple\FilesystemCache;
use Psr\SimpleCache\InvalidArgumentException;

class LoaderService
{
    /** @var WeatherService */
    private $googleWeatherService;

    /** @var FilesystemCache */
    private $cacheService;

    /**
     * LoaderService constructor.
     * @param WeatherService  $googleWeatherService
     * @param FilesystemCache $cacheService
     */
    public function __construct(WeatherService $googleWeatherService, FilesystemCache $cacheService)
    {
        $this->googleWeatherService = $googleWeatherService;
        $this->cacheService = $cacheService;
    }


    /**
     * @param \DateTime $day
     * @return Weather
     * @throws InvalidArgumentException
     * @throws \Exception
     */
    public function loadWeatherByDay(\DateTime $day): Weather
    {
        $cacheKey = $this->getCacheKey($day);
        if ($this->cacheService->has($cacheKey)) {
            echo "from cache";
            $weather = $this->cacheService->get($cacheKey);
        } else {
            echo "save cache";
            $weather = $this->googleWeatherService->getDay($day);
            $this->cacheService->set($cacheKey, $weather);
        }

        return $weather;
    }

    /**
     * @param \DateTime $day
     * @return string
     */
    private function getCacheKey($day): string
    {
        return $day->format('Y-m-d');
    }
}
