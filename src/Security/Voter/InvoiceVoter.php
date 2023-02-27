<?php

namespace App\Security\Voter;

use App\Entity\Invoice;
use App\Entity\Roles;
use Nette\Utils\Paginator;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class InvoiceVoter extends Voter
{
    public const UPDATE = 'INVOICE_UPDATE';
    public const READ = 'INVOICE_READ';
    public const CREATE = 'INVOICE_CREATE';
    public const DELETE = 'INVOICE_DELETE';
    public const FIX = 'INVOICE_FIX';
    private $security = null;
    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    protected function supports(string $attribute, $subject): bool
    {
        return in_array($attribute, [self::UPDATE, self::READ, self::CREATE, self::DELETE])
            && ($subject instanceof Invoice or $subject instanceof \ApiPlatform\Doctrine\Orm\Paginator);
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
            case self::CREATE:
            case self::UPDATE:
            case self::DELETE:
                if ( !$this->security->isGranted(Roles::ROLES_ADMIN) ) 
                    return false;
                return true;                
            default:
                return true;
        }
    }
}
