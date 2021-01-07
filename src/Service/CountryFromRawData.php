<?php


namespace App\Service;

use App\Form\CountryFormType;
use App\Entity\Country;
use App\Validator\FormValidator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CountryFromRawData extends AbstractController
{
  /**
   * @var EntityManagerInterface
   */
  private $em;

  public function __construct(EntityManagerInterface $em)
  {
    $this->em = $em;
  }

  public function createCountryFromRawData(Request $request): array
  {
    $response = [];
    $contents = json_decode($request->getContent(),1);
    $country = new Country();

    $form = $this->createCountryForm($country);
    $form->submit($contents);

    if (!$form->isSubmitted()) {
      $response['message'] = 'Form not submitted';
      $response['code'] = Response::HTTP_NOT_FOUND;
      return $response;
    }

    if (!$form->isValid()) {
      $fields = FormValidator::getErrorsFromForm($form);
      $response['message'] = $fields;
      $response['code'] = Response::HTTP_NOT_FOUND;
      return $response;
    }

    $this->em->persist($form->getNormData());
    $this->em->flush();

    $response = [
      'message' => $country->getId(),
      'code' => Response::HTTP_OK
    ];

    return $response;
  }

  private function createCountryForm(Country $country): \Symfony\Component\Form\FormInterface
  {
    return $this->createForm(CountryFormType::class, $country);
  }
}