<?php

namespace App\Security\Voter;

use App\Constant\EntityPermission as EP;
use App\Constant\UserRole as UR;
use App\Entity\Base\AdminEntityCUD;
use App\Entity\Base\RestrictedAccessEntity;
use App\Entity\Base\VerifiedMemberEntityCRUD;
use App\Entity\Final\User;
use Exception;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

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

            if(
                $entity instanceof VerifiedMemberEntityCRUD
                && in_array($attribute, EP::CRUD)
                && !(($user instanceof User) && $user->isVerified())
            ) {
                return false;
            }

            if(
                ($entity instanceof AdminEntityCUD)
                && in_array($attribute, EP::CUD)
                && !(($user instanceof User) && in_array(UR::ROLE_ADMIN, $user->getRoles()))
            ) {
                return false;
            }
        }

        return true;
    }

}
