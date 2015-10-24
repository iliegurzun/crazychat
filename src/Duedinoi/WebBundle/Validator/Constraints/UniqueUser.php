<?php
namespace Duedinoi\WebBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class UniqueUser extends Constraint
{
    public $messageUsername = 'register.username_taken';
    
    public $messageEmail = 'register.email_taken';




    public function validatedBy()
    {
        return 'unique_user';
    }
    
    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
