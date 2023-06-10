<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Service\WeatherService;

#[Route('/')]
class HomeController extends AbstractController
{
    #[Route('', name: 'main_page')]
    public function Home(WeatherService $WeatherService)
    {
        $weatherData = $WeatherService->getWeather();
        return $this->render('index.html.twig', ['weatherData'=>$weatherData]);
    }

}
