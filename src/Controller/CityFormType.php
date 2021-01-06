<?php

namespace App\Controller;

use App\Entity\Country;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class CityFormType extends AbstractController
{

  public function index(Request $request, FormBuilderInterface $builder): Response
  {
    $builder->add('country', EntityType::class, [
      'class' => Country::class,
    ]);
  }
}