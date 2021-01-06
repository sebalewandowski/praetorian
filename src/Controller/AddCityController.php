<?php

namespace App\Controller;

use App\Entity\City;
use App\Repository\CityRepository;
use App\Repository\CountryRepository;
use App\Service\CityFromRawData;
use App\Validator\FormValidator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AddCityController extends AbstractController
{
  /**
   * @var CityRepository
   */
  private $cityRepository;

  /**
   * @var CountryRepository
   */
  private $countryRepository;

  /**
   * @var CityFromRawData
   */
  private $cityFromRawData;

  public function __construct(CityRepository $cityRepository, CountryRepository $countryRepository, CityFromRawData $cityFromRawData)
  {
    $this->cityRepository = $cityRepository;
    $this->countryRepository = $countryRepository;
    $this->cityFromRawData = $cityFromRawData;
  }

  /**
   * @Route("/city", name="add_city", methods={"POST"})
   * @param Request $request
   * @return Response
   */
  public function addCity(Request $request): Response
  {
    $contents = json_decode($request->getContent(),1);

    $city = new City();
    $city->setName($contents['name']);
//    $country = $this->countryRepository->find(2);
//
//    if (!$country) {
//      new JsonResponse('No country',Response::HTTP_NOT_FOUND);
//    }

//    $city->setCountry($country);

    $form = $this->createForm(City::class, null, ['csrf_protection' => false]);
    $form->submit($contents, true);
    $this->createForm(CityFromRawData::class);
    $cityForm = $this->cityFromRawData->createByFormData($city);
    $cityForm->submit($contents, true);

    if (!$cityForm->isValid()) {
      $fields = FormValidator::getErrorsFromForm($cityForm);
    }

    $this->cityRepository->save($city);

    return new JsonResponse($city->getId(),Response::HTTP_OK);
  }
}
