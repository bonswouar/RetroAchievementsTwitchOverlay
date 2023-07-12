<?php
namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class RetroAchievementsService
{
    private const API_URL = 'https://retroachievements.org/API/';

    public function __construct(
        private string $raUser,
        private string $raApiKey,
        private HttpClientInterface $httpClient) {  
    }

    private function authQS()
    {
        return '?z='.$this->raUser.'&y='.$this->raApiKey;
    }

    private function getRAResponse($target, $params = '')
    {
        $response = $this->httpClient->request(
            'GET',
            self::API_URL.$target.$this->authQS().'&'.$params
        );
        $statusCode = $response->getStatusCode();
        $contentType = $response->getHeaders()['content-type'][0];
        $content = $response->getContent();
        if ($statusCode !== 200 || $contentType !== 'application/json') {
            throw new \Exception($content);
        }
        return $response->toArray();
    }

    public function getUserRecentAchievements($user, $minutes)
    {
        return $this->getRAResponse('API_GetUserRecentAchievements.php', 'u='.$user.'&m='.$minutes);
    }
}
