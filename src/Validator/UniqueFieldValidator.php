<?php
declare(strict_types = 1);

namespace App\Validator;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class UniqueFieldValidator extends ConstraintValidator
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof UniqueField) {
            return;
        }

        $query = $this->entityManager->createQueryBuilder()
            ->select('COUNT(e)')
            ->from($constraint->class, 'e')
            ->where("e.{$constraint->field} = :value")
            ->setParameter('value', $value)
            ->getQuery();

        $result = (int) $query->getSingleScalarResult();

        if ($result > 0) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $value)
                ->setParameter('{{ field }}', $constraint->field)
                ->addViolation();
        }
    }
}
