<?php


namespace App\Service;

use App\Controller\CountryFormType;
use App\Repository\CountryRepository;
use App\Validator\FormValidator;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class CountryFromRawData extends AbstractController
{
  /**
   * @var CountryRepository
   */
  private $countryRepository;

  public function __construct(CountryRepository $countryRepository)
  {
    $this->countryRepository = $countryRepository;
  }

  public function createCountryFromRawData()
  {
    $errors = [];
    $form = $this->createForm(CountryFormType::class, $country);
    $form->submit($contents);

    if (!$form->isSubmitted()) {
      $errors['message'] = 'Form not submitted';
      $errors['code'] = Response::HTTP_NOT_FOUND;
      return $errors;
    }

    if (!$form->isValid()) {
      $fields = FormValidator::getErrorsFromForm($form);
      $errors['message'] = $fields;
      $errors['code'] = Response::HTTP_NOT_FOUND;
      return $errors;
    }

    $this->countryRepository->persist($form->getNormData());
    $this->countryRepository->flush();

    return $errors;
  }
}