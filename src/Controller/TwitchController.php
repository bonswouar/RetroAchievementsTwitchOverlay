<?php

namespace App\Controller;

use App\Service\RetroAchievementsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/twitch', name: 'app_twitch_')]
class TwitchController extends AbstractController
{
    #[Route('/last/{username}/{time}', name: 'last')]
    public function last(RetroAchievementsService $raService, string $username, int $time = 600): Response
    {
        $achievements = $raService->getUserRecentAchievements($username, $time);

        return $this->render('twitch/last.html.twig', [
            'username' => $username,
            'achievements' => $achievements,
        ]);
    }
}
