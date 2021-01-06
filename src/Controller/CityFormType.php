<?php

namespace App\Controller;

use App\Entity\City;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class CityFormType extends AbstractController
{

  public function index(Request $request, FormBuilderInterface $builder): Response
  {
    $builder->add('city', EntityType::class, [
      'class' => City::class,
    ])->getForm();
  }
}