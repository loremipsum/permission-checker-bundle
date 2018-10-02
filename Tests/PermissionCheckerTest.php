<?php

namespace LoremIpsum\PermissionCheckerBundle\Tests;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use LoremIpsum\PermissionCheckerBundle\Permission;
use LoremIpsum\PermissionCheckerBundle\PermissionChecker;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class PermissionCheckerTest extends TestCase
{
    public function testPermissionChecker()
    {
        /** @var AuthorizationCheckerInterface|\PHPUnit_Framework_MockObject_MockObject $securityChecker */
        /** @var TokenStorage|\PHPUnit_Framework_MockObject_MockObject $tokenStorage */
        /** @var EntityManagerInterface|\PHPUnit_Framework_MockObject_MockObject $entityManager */
        /** @var Permission|\PHPUnit_Framework_MockObject_MockObject $permission */

        $user = new User();

        $securityChecker = $this->getMockBuilder(AuthorizationCheckerInterface::class)->getMock();
        $securityChecker->expects($this->any())->method('isGranted')->will($this->returnValueMap([
            [User::ROLE_ADMIN, null, true],
            [User::ROLE_SUPER_ADMIN, null, false]
        ]));

        $token = $this->getMockBuilder(TokenInterface::class)->getMock();
        $token->expects($this->once())->method('getUser')->will($this->returnValue($user));

        $tokenStorage = $this->createMock(TokenStorage::class);
        $tokenStorage->expects($this->once())->method('getToken')->will($this->returnValue($token));

        $entityManager = $this->getMockBuilder(EntityManagerInterface::class)->disableOriginalConstructor()->getMock();

        $checker = new PermissionChecker($securityChecker, $tokenStorage, $entityManager);

        $this->assertSame($entityManager, $checker->getEntityManager());
        $this->assertSame($user, $checker->getUser());

        $this->assertTrue($checker->isAdmin());
        $this->assertFalse($checker->isSuperAdmin());

        $permission = $this->getMockBuilder(Permission::class)->getMock();
        $permission->expects($this->once())->method('isGranted')->will($this->returnValue(true));
        $this->assertTrue($checker->has($permission));
    }
}
