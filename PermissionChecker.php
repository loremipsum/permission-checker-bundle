<?php

namespace LoremIpsum\PermissionCheckerBundle;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use LoremIpsum\PermissionCheckerBundle\Exception\PermissionDeniedException;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class PermissionChecker implements PermissionCheckerInterface
{
    /**
     * @var AuthorizationCheckerInterface
     */
    protected $securityChecker;

    /**
     * @var TokenStorageInterface
     */
    protected $tokenStorage;

    /**
     * @var EntityManagerInterface
     */
    protected $em;

    /**
     * @var User
     */
    protected $user;

    /**
     * @param AuthorizationCheckerInterface $securityChecker
     * @param TokenStorageInterface         $tokenStorage
     * @param EntityManagerInterface        $em
     */
    public function __construct(AuthorizationCheckerInterface $securityChecker, TokenStorageInterface $tokenStorage, EntityManagerInterface $em)
    {
        $this->securityChecker = $securityChecker;
        $this->tokenStorage    = $tokenStorage;
        $this->em              = $em;
    }

    public function getEntityManager()
    {
        return $this->em;
    }

    public function getUser()
    {
        if (! $this->user && null !== ($token = $this->tokenStorage->getToken()) && is_object($user = $token->getUser())) {
            $this->user = $user;
        }

        return $this->user;
    }

    public function isAdmin()
    {
        return $this->hasRole(User::ROLE_ADMIN)
            || $this->isSuperAdmin();
    }

    public function isSuperAdmin()
    {
        return $this->hasRole(User::ROLE_SUPER_ADMIN);
    }

    public function has(Permission $permission)
    {
        $permission->setPermissionChecker($this);

        $preCheck = $permission->preCheck();
        if ($preCheck !== null) {
            return $preCheck;
        }

        return $permission->isGranted();
    }

    public function mustHave(Permission $permission)
    {
        if (! $this->has($permission)) {
            throw new PermissionDeniedException($permission);
        }
    }

    /**
     * @param string $role
     * @return bool
     */
    private function hasRole($role)
    {
        return $this->securityChecker->isGranted($role);
    }
}
