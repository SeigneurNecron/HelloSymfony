<?php

namespace App\Security\Voter;

use App\Constants\EntityPermission as EP;
use App\Constants\UserRole as UR;
use App\Entity\Base\AdminEntityCUD;
use App\Entity\Base\MemberEntityCRUD;
use App\Entity\Base\RestrictedAccessEntity;
use Exception;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

final class EntityVoter extends Voter {

    protected function supports(string $attribute, mixed $subject): bool {
        return in_array($attribute, EP::VALUES) && is_string($subject);
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool {
        try {
            $entity = new $subject;
        }
        catch(Exception $e) {
            dump($e->getMessage());
            return true;
        }

        if($entity instanceof RestrictedAccessEntity) {
            $user = $token->getUser();

            if($entity instanceof MemberEntityCRUD) {
                return $user instanceof UserInterface;
            }

            if($entity instanceof AdminEntityCUD) {
                return ($attribute === EP::READ) || (($user instanceof UserInterface) && in_array(UR::ROLE_ADMIN, $user->getRoles()));
            }
        }

        return true;
    }

}
