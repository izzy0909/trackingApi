<?php declare(strict_types = 1);

namespace App\Controller;

use App\Service\GetSerbianPostPackageInfo;
use App\Traits\LoggerAwareTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class SerbianPostController
 */
class SerbianPostController extends AbstractController
{
    use LoggerAwareTrait;

    private GetSerbianPostPackageInfo $getSerbianPostPackageInfo;

    /**
     * @param GetSerbianPostPackageInfo $getSerbianPostPackageInfo
     */
    public function __construct(
        GetSerbianPostPackageInfo $getSerbianPostPackageInfo
    ) {
        $this->getSerbianPostPackageInfo = $getSerbianPostPackageInfo;
    }

    /**
     * @Route("/login", name="app_login")
     *
     * @param Request $request
     *
     * @return Response|JsonResponse
     */
    public function __invoke(Request $request)
    {
        try {
            $trackingNumber = 'RU732248186NL';
            $data = $this->getSerbianPostPackageInfo->execute($trackingNumber);

            return new JsonResponse(
                [
                    'data' => $data,
                ],
            );
        } catch (\Exception $exception) {
            $this->logger->error($exception->getMessage());

            return new JsonResponse([], JsonResponse::HTTP_BAD_REQUEST);
        }

    }
}
