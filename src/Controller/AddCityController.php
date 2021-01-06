<?php

namespace App\Controller;

use App\Entity\City;
use App\Entity\Country;
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
    $city->setName('Piano1');

    // for further needs if we need to find id of existing country and just add cities into
//    $this->countryRepository->find($id);

    $country = new Country();

    $country->setName('asd3');
    $city->setCountry($country);

    $cityForm = $this->cityFromRawData->createByFormData($city);
    $cityForm->submit($contents, true);

    if (!$cityForm->isValid()) {
      $fields = FormValidator::getErrorsFromForm($cityForm);
    }

    $this->cityRepository->save($city, $country);

    return new JsonResponse('Great',Response::HTTP_OK);
  }
}
