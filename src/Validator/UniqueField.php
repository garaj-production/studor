<?php
declare(strict_types = 1);

namespace App\Validator;

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
