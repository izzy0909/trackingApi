<?php declare(strict_types = 1);

namespace App\Service;

use Exception;
use Goutte\Client;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class GetSerbianPostPackageInfo
 */
class GetSerbianPostPackageInfo extends AbstractController
{
    private Client $client;

    const URL = 'https://www.posta.rs/lat/alati/pracenje-posiljke.aspx?broj=';

    /**
     * @param Client $client
     */
    public function __construct()
    {
        $this->client = new Client();
    }

    /**
     * @param string $trackingNumber
     *
     * @return array $data
     *
     * @throws Exception
     */
    public function execute(string $trackingNumber): array
    {
        $crawler = $this->client->request('GET', self::URL.$trackingNumber);

        /** @var Response $response */
        $response = $this->client->getResponse();

        if ($response->getStatusCode() !== JsonResponse::HTTP_OK) {
            throw new Exception('Not Found');
        }

        $data = $crawler->filter('table tr')
            ->each(function ($tr) {
                return $tr->filter('td')->each(function ($td, $i) {
                    return trim($td->text());
                });
            });

        return array_values(array_filter($data));
    }
}
