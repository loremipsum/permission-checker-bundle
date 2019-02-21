<?php

namespace LoremIpsum\PermissionCheckerBundle\Tests;

use Doctrine\ORM\EntityManagerInterface;
use LoremIpsum\PermissionCheckerBundle\Permission\PermissionInterface;
use LoremIpsum\PermissionCheckerBundle\PermissionChecker;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class PermissionCheckerTest extends TestCase
{
    public function testPermissionChecker()
    {
        /** @var AuthorizationCheckerInterface $securityChecker */
        /** @var TokenStorage $tokenStorage */
        /** @var EntityManagerInterface $entityManager */
        /** @var PermissionInterface $permission */

        $user = new \stdClass();

        $securityChecker = $this->getMockBuilder(AuthorizationCheckerInterface::class)->getMock();
        $securityChecker->expects($this->any())->method('isGranted')->will($this->returnValueMap([
            ['ROLE_ADMIN', null, true],
            ['ROLE_SUPER_ADMIN', null, false],
        ]));

        $token = $this->getMockBuilder(TokenInterface::class)->getMock();
        $token->expects($this->once())->method('getUser')->will($this->returnValue($user));

        $tokenStorage = $this->createMock(TokenStorage::class);
        $tokenStorage->expects($this->once())->method('getToken')->will($this->returnValue($token));

        $entityManager = $this->getMockBuilder(EntityManagerInterface::class)->disableOriginalConstructor()->getMock();

        $checker = new PermissionChecker($securityChecker, $tokenStorage, $entityManager, ['admin' => 'ROLE_ADMIN', 'super_admin' => 'ROLE_SUPER_ADMIN']);

        $this->assertSame($securityChecker, $checker->getSecurityChecker());
        $this->assertSame($tokenStorage, $checker->getTokenStorage());
        $this->assertSame($entityManager, $checker->getEntityManager());
        $this->assertSame($user, $checker->getUser());

        $this->assertTrue($checker->isAdmin());
        $this->assertFalse($checker->isSuperAdmin());

        $permission = $this->getMockBuilder(PermissionInterface::class)->getMock();
        $permission->expects($this->once())->method('isGranted')->will($this->returnValue(true));
        $this->assertTrue($checker->has($permission));
    }
}
