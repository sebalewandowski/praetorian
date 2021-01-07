<?php


namespace App\Controller;

use App\Service\CityFromRawData;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AddCityController extends AbstractController
{
  /**
   * @var CityFromRawData
   */
  private $cityFromRawData;

  public function __construct(CityFromRawData $cityFromRawData)
  {
    $this->cityFromRawData = $cityFromRawData;
  }
  /**
   * @Route("/city", name="add_city", methods={"POST"})
   * @param Request $request
   * @return Response
   */
  public function addCity(Request $request): Response
  {
    $response = $this->cityFromRawData->createByFormData($request);

    return new JsonResponse($response['message'],$response['code']);
  }
}
