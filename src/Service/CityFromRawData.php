<?php

namespace App\Service;

use App\Form\CityFormType;
use App\Entity\City;
use App\Validator\FormValidator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CityFromRawData extends AbstractController
{
  /**
   * @var EntityManagerInterface
   */
  private $em;

  public function __construct(EntityManagerInterface $em)
  {
    $this->em = $em;
  }

  public function createByFormData(Request $request): array
  {
    $contents = json_decode($request->getContent(),1);

    $response = [];
    $city = new City();

    $form = $this->createForm(CityFormType::class, $city);
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
      'message' => $city->getId(),
      'code' => Response::HTTP_OK
    ];

    return $response;
  }
}