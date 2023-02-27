<?php

namespace App\Security\Voter;

use App\Entity\Order;
use App\Entity\Roles;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class OrderVoter extends Voter
{
    public const UPDATE = 'ORDER_UPDATE';
    public const READ = 'ORDER_READ';
    public const CREATE = 'ORDER_CREATE';
    public const DELETE = 'ORDER_DELETE';
    public const FIX = 'ORDER_FIX';
    public const ACCEPT = 'ORDER_ACCEPT';
    private $security = null;
    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    protected function supports(string $attribute, $subject): bool
    {
        return in_array($attribute, [self::UPDATE, self::READ, self::CREATE, self::DELETE])
            && ($subject instanceof Order or $subject instanceof \ApiPlatform\Doctrine\Orm\Paginator);
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }
        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case self::ACCEPT:
                if ( !$this->security->isGranted(Roles::ROLE_ADMIN) ) 
                    return false;
                return true;
            case self::FIX:
                if ( !$this->security->isGranted(Roles::ROLE_USER) ) 
                    return false;
                return true;
            case self::CREATE:
            case self::UPDATE:
            case self::DELETE:                  
            default:
                return true;
        }
    }
}
