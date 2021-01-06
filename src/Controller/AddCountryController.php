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
   * @Route("/country", name="add_country", methods={"POST"})
   * @param Request $request
   * @return Response
   *
   * @OA\Response(
   *     response=200,
   *     description="Returns the rewards of an user"
   * )
   */
    public function addCountry(Request $request): Response
    {
      $entityManager = $this->getDoctrine()->getManager();
      $contents = json_decode($request->getContent(),1);

      $country = new Country();

//      $form = $this->createForm(CountryFormType::class, $country);
//      $form->submit($contents);
//
//      if (!$form->isSubmitted()) {
//        return new JsonResponse('Form not submitted', Response::HTTP_NOT_FOUND);
//      }
//
//      if (!$form->isValid()) {
//        $fields = FormValidator::getErrorsFromForm($form);
//        return new JsonResponse('Form not submitted', Response::HTTP_NOT_FOUND);
//      }
//
//      $entityManager->persist($form->getNormData());
//      $entityManager->flush();

      if ($this->countryFromRawData->createCountryFromRawData()) {

      }
      return new JsonResponse('sds', Response::HTTP_OK);
    }
}
