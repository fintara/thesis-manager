<?php
/**
 * Created by PhpStorm.
 * User: fintara
 * Date: 25/01/2017
 * Time: 13:11
 */

namespace AppBundle\Security\Voters;


use AppBundle\Entity\Draft;
use AppBundle\Entity\Student;
use AppBundle\Entity\Thesis;
use AppBundle\Entity\User;
use AppBundle\Entity\Worker;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class ThesisVoter extends Voter
{
    const UPLOAD_DRAFT = 'UPLOAD_DRAFT';
    const VIEW_DRAFTS = 'VIEW_DRAFTS';

    protected static function getAttributes()
    {
        return [
            self::UPLOAD_DRAFT,
            self::VIEW_DRAFTS,
        ];
    }

    /**
     * Determines if the attribute and subject are supported by this voter.
     *
     * @param string $attribute An attribute
     * @param mixed $subject The subject to secure, e.g. an object the user wants to access or any other PHP type
     *
     * @return bool True if the attribute and subject are supported, false otherwise
     */
    protected function supports($attribute, $subject)
    {
        if (!in_array($attribute, self::getAttributes())) {
            return false;
        }

        return $subject instanceof Thesis;
    }

    /**
     * Perform a single access check operation on a given attribute, subject and token.
     * It is safe to assume that $attribute and $subject already passed the "supports()" method check.
     *
     * @param string $attribute
     * @param mixed $subject
     * @param TokenInterface $token
     *
     * @return bool
     */
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        /** @var User $user */
        $user = $token->getUser();

        /** @var Thesis $thesis */
        $thesis = $subject;

        switch ($attribute) {
            case self::UPLOAD_DRAFT:
                return $this->canUploadDraft($thesis, $user);
            case self::VIEW_DRAFTS:
                return $this->canViewDrafts($thesis, $user);
        }

        throw new \LogicException('Shouldn\'t be reached');
    }

    private function canUploadDraft(Thesis $thesis, User $student)
    {
        if (!$student instanceof Student) {
            return false;
        }

        if (!$this->canViewDrafts($thesis, $student)) {
            return false;
        }

        /** @var Draft|null $lastDraft */
        $lastDraft = $thesis->getDrafts()->last();

        if (!$lastDraft) {
            return true;
        }

        $diff = $lastDraft->getCreatedAt()->diff(new \DateTime());
        var_dump($diff->d + $diff->m + $diff->y > 0);

        return $diff->d + $diff->m + $diff->y > 0;
    }

    private function canViewDrafts(Thesis $thesis, User $user)
    {
        if ($user instanceof Student) {
            return $thesis->getStudents()->contains($user);
        }

        return $user == $thesis->getSupervisor();
    }
}