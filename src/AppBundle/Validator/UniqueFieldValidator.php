<?php

namespace AppBundle\Validator;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class UniqueFieldValidator extends ConstraintValidator
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof UniqueField) {
            return;
        }

        $repository = $this->entityManager->getRepository($constraint->class);
        $query = $repository->createQueryBuilder('e')
            ->select('COUNT(e)')
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
