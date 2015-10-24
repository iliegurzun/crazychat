<?php
namespace Duedinoi\WebBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Duedinoi\UserBundle\Entity\User;

class UniqueUserValidator extends ConstraintValidator
{
    protected $userRepository;
    
    protected $translator;
    
    public function __construct($userRepository, $translator) 
    {
        $this->userRepository = $userRepository;
        $this->translator = $translator;
    }

    public function validate($value, Constraint $constraint)
    {
        if ($value->getId()) {
            return;
        }
        $userByUsername = $this->userRepository->findOneByUsername($value->getUsername());
        if ($userByUsername instanceof User) {
            $this->context->buildViolation($this->translator->trans($constraint->messageUsername))
                ->atPath('username')
                ->addViolation();
        }
        $userByEmail = $this->userRepository->findOneByEmail($value->getEmail());
        if ($userByEmail instanceof User) {
            $this->context->buildViolation($this->translator->trans($constraint->messageEmail))
                ->atPath('email')
                ->addViolation();
        }
        
        return;
    }
}