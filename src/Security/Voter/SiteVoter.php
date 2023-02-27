<?php

namespace App\Security\Voter;

use App\Entity\Site;
use App\Entity\Roles;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class SiteVoter extends Voter
{
    public const UPDATE = 'SITE_UPDATE';
    public const READ = 'SITE_READ';
    public const CREATE = 'SITE_CREATE';
    public const DELETE = 'SITE_DELETE';
    private $security = null;
    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    protected function supports(string $attribute, $subject): bool
    {
        return in_array($attribute, [self::UPDATE, self::READ, self::CREATE, self::DELETE])
            && ($subject instanceof Site or $subject instanceof \ApiPlatform\Doctrine\Orm\Paginator);
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
            case self::UPDATE:
            case self::CREATE:
            case self::DELETE:
                if ( !$this->security->isGranted(Roles::ROLES_ADMIN) ) 
                    return false;  // only admins can create books
                return true;                
            default:
                return true;
        }
    }
}
