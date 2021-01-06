<?php

namespace App\Service;

use App\Controller\CountryFormType;
use App\Entity\City;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CityFromRawData extends AbstractController
{
  public function createByFormData(City $city): \Symfony\Component\Form\FormInterface
  {
    return $this->createForm(CountryFormType::class, $city);
  }
}