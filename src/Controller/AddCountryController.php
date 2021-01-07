<?php

namespace App\Controller;

use App\Entity\City;
use App\Entity\Country;
use App\Repository\CountryRepository;
use App\Service\CountryFromRawData;
use App\Validator\FormValidator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;
use Nelmio\ApiDocBundle\Annotation\Model;

class AddCountryController extends AbstractController
{

  /**
   * @var CountryFromRawData
   */
  private $countryFromRawData;

  public function __construct(CountryFromRawData $countryFromRawData)
  {
    $this->countryFromRawData = $countryFromRawData;
  }

  /**
   * @Route("api/country", name="add_country", methods={"POST"})
   * @param Request $request
   * @return Response
   *
   * @OA\Post(
   *     path="/api/country",
   *     operationId="add_country",
   *     description="Creates a new country in the db.",
   *     @OA\RequestBody(
   *         description="Country to add",
   *         required=true,
   *         @OA\MediaType(
   *             mediaType="application/json",
   *         )
   *     ),
   *     @OA\Response(
   *         response=200,
   *         description="country response",

   *     ),
   *     @OA\Response(
   *         response="default",
   *         description="unexpected error",

   *     )
   * )
   *
   */
    public function addCountry(Request $request): Response
    {
      $response = $this->countryFromRawData->createCountryFromRawData($request);

      return new JsonResponse($response['message'], $response['code']);
    }
}
