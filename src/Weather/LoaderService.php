<?php

namespace App\Weather;

use App\Model\Weather;
use Symfony\Component\Cache\Simple\FilesystemCache;
use Psr\SimpleCache\InvalidArgumentException;

class LoaderService
{
    /** @var FilesystemCache */
    private $cacheService;

    /** @var ProviderService */
    private $weatherProvider;

    /**
     * LoaderService constructor.
     * @param FilesystemCache $cacheService
     * @param ProviderService $weatherProvider
     */
    public function __construct(FilesystemCache $cacheService, ProviderService $weatherProvider)
    {
        $this->cacheService = $cacheService;
        $this->weatherProvider = $weatherProvider;
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
            $weather = $this->cacheService->get($cacheKey);
        } else {
            $weather = $this->weatherProvider->getWeatherProvider($day)->getDay($day);
            $this->cacheService->set($cacheKey, $weather);
        }

        return $weather;
    }

    /**
     * @param \DateTime $day
     * @return string
     */
    private function getCacheKey(\DateTime  $day): string
    {
        return $day->format('Y-m-d');
    }
}
