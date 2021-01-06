<?php


namespace App\Validator;

use Symfony\Component\Form\FormInterface;

class FormValidator
{
  public static function getErrorsFromForm(FormInterface $form, $level = 0)
  {
    $errors = [];

    if ($level === 0) {
      foreach ($form->getErrors() as $error) {
        if (!isset($errors['form'])) {
          $errors['form'] = [];
        }

        $errors['form'][] = $error->getMessage();
      }
    } else {
      foreach ($form->getErrors() as $error) {
        $errors[] = $error->getMessage();
      }
    }

    foreach ($form->all() as $childForm) {
      if (($childForm instanceof FormInterface) && $childErrors = self::getErrorsFromForm($childForm, $level + 1)) {
        $errors[$childForm->getName()] = $childErrors;
      }
    }

    $suberrors = $errors['first'] ?? [];

    if (isset($errors['second'])) {
      $suberrors = array_merge($suberrors, $errors['second']);
    }

    if (!empty($suberrors)) {
      $errors = $suberrors;
    }

    return $errors;
  }
}