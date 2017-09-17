<?php

namespace AppBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class UniqueField extends Constraint
{
    /** @var string */
    public $message = 'Not unique value for "{{ field }}"';

    /** @var string */
    public $class;

    /** @var string */
    public $field;
}
