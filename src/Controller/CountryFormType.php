<?php


namespace App\Controller;

use App\Entity\Country;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class CountryFormType extends AbstractType
{
  public function index(FormBuilderInterface $builder, array $options): void
  {
    $builder->add('country', EntityType::class, [
      'class' => Country::class,
    ]);
  }
}