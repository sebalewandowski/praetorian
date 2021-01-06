<?php

namespace App\Controller;

use App\Entity\Country;
use App\Repository\CountryRepository;
use App\Validator\FormValidator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;

class AddCountryController extends AbstractController
{
  /**
   * @var CountryRepository
   */
  private $countryRepository;

  public function __construct(CountryRepository $countryRepository)
  {
    $this->countryRepository = $countryRepository;
  }

  /**
   * @Route("/country", name="add_country", methods={"POST"})
   * @param Request $request
   * @return Response
   * @OA\Post(
   *     path="/country",
   *     summary="Returns most accurate search result object",
   *     description="Search for an object, if found return it!",
   *     @OA\RequestBody(
   *         description="Client side search object",
   *         required=true,
   *         @OA\MediaType(
   *             mediaType="application/json"
   *         )
   *     ),
   *     @OA\Response(
   *         response=200,
   *         description="Success"
   *     ),
   *     @OA\Response(
   *         response=404,
   *         description="Could Not Find Resource"
   *     )
   * )
   */
    public function addCountry(Request $request): Response
    {
      $contents = json_decode($request->getContent(),1);

      $country = new Country();
      $country->setName($contents['name']);

      $form = $this->createCountryForm($country);
      $form->submit($contents, true);

      if (!$form->isValid()) {
        $fields = FormValidator::getErrorsFromForm($form);
      }

      $this->countryRepository->save($country);

      return new JsonResponse([$country->getId()], Response::HTTP_OK);
    }

    private function createCountryForm(Country $country)
    {
      return $this->createForm(CountryFormType::class, $country);
    }
}
