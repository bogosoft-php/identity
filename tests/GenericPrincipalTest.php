<?php

declare(strict_types=1);

namespace Bogosoft\Identity\Tests;

use Bogosoft\Identity\GenericIdentity;
use Bogosoft\Identity\GenericPrincipal;
use Bogosoft\Identity\NullIdentity;
use PHPUnit\Framework\TestCase;

class GenericPrincipalTest extends TestCase
{
    function testCanRetrieveIdentity(): void
    {
        $expected = new GenericIdentity('Alice');

        $principal = new GenericPrincipal($expected);

        $actual = $principal->getIdentity();

        $this->assertInstanceOf(get_class($expected), $actual);
        $this->assertEquals($expected->getName(), $actual->getName());
    }

    function testIndicatesIsInRoleWhenConstructedWithRolesAndGivenRolesWasAmongThem(): void
    {
        $roles = ['Admin', 'Manager', 'User'];

        $identity = new GenericIdentity('Bob');

        $principal = new GenericPrincipal($identity, $roles);

        $this->assertTrue($principal->isInRole($roles[0]));
    }

    function testIndicatesNotInRoleWhenConstructedWithRolesButGivenRoleNotAmongThem(): void
    {
        $roles = ['Admin', 'Manager', 'User'];

        $role = 'Testers';

        $this->assertFalse(in_array($role, $roles));

        $identity = new GenericIdentity('Bob');

        $principal = new GenericPrincipal($identity, $roles);

        $this->assertFalse($principal->isInRole($role));
    }

    function testIndicatesNotInRoleWhenNotConstructedWithRoles(): void
    {
        $principal = new GenericPrincipal();

        $this->assertFalse($principal->isInRole('Developers'));
    }

    function testReturnsNullIdentityWhenNotConstructedWithIdentity(): void
    {
        $principal = new GenericPrincipal();

        $actual = $principal->getIdentity();

        $this->assertInstanceOf(NullIdentity::class, $actual);
    }
}
