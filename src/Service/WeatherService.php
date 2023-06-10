<?php

namespace App\Service;

use Symfony\Component\HttpClient\HttpClient;
use \Datetime;


class WeatherService
{
    public function getWeather()
    {
        $url = 'https://api.open-meteo.com/v1/forecast?latitude=48.85&longitude=2.35&hourly=temperature_2m';
        $httpClient = HttpClient::create();

        $response = $httpClient->request('GET', $url);

        if (200 !== $response->getStatusCode()) {
        } else {
            $content = $response->getContent();
        }
        $dataRaw = json_decode($content, true);
        //dd($dataRaw['hourly']['temperature_2m']['15']);
        $now = (new DateTime())->format("Y-m-d\TH:00");
        $result = array_search($now, $dataRaw['hourly']['time']);
        //dd($dataRaw['hourly']['temperature_2m'][$result]);
        $customizedData['timezone'] = $dataRaw['timezone'];
        $customizedData['temprature_unit'] = $dataRaw['hourly_units']['temperature_2m'];
        $customizedData['temprature'] = $dataRaw['hourly']['temperature_2m'][$result];

        return $customizedData;
    }
}
