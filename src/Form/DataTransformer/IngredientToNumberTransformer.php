<?php

namespace App\Form\DataTransformer;

use App\Entity\Ingredient;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class IngredientToNumberTransformer implements DataTransformerInterface
{
  private $entityManager;

  public function __construct(EntityManagerInterface $entityManager)
  {
    $this->entityManager = $entityManager;

  }

   /**
     * Transforms an object (ingredient) to a string (number).
     *
     * @param  Ingredient|null $ingredient
     */
    public function transform($ingredient): string
    {
     
        if (null === $ingredient) {
          
            return '';
        }

        return $ingredient->getLibelle();
    }

    /**
     * Transforme une chaine de caractère (libelle) en objet (ingredient).
     *
     * @param  string $ingredientLibelle
     * @throws TransformationFailedException if object (ingredient) is not found.
     */
    public function reverseTransform($ingredientLibelle): ?Ingredient
    {
        // no ingredient number? It's optional, so that's ok
        if (!$ingredientLibelle) {
          return null;
        }

        $ingredient = $this->entityManager
            ->getRepository(Ingredient::class)
            // query for the ingredient with this id
            ->findByLibelle($ingredientLibelle)
        ;

      

        if (null === $ingredient) {
          $privateErrorMessage = sprintf('An ingredient with number "%s" does not exist!', $ingredientLibelle);
          $publicErrorMessage = 'The given "{{ value }}" value is not a valid ingredient number.';

          $failure = new TransformationFailedException($privateErrorMessage);
          $failure->setInvalidMessage($publicErrorMessage, [
              '{{ value }}' => $ingredientLibelle,
          ]);

          throw $failure;
        }

        return $ingredient;
    }

}