<?php

class CeleryServiceFactory
{
    /**
     * Given an identifying string, get a ThirdPartyCeleryService object of that type.
     *
     * @param $serviceName string the name of the service to create
     *
     * @return null|Application_Service_ThirdPartyCeleryService
     */
    public static function getService($serviceName)
    {
        switch ($serviceName) {
            case PODCAST_SERVICE_NAME:
                return new Application_Service_PodcastEpisodeService();

            default:
                return null;
        }
    }
}
