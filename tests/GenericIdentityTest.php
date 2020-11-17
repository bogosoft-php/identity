<?php

declare(strict_types=1);

namespace Bogosoft\Identity\Tests;

use Bogosoft\Identity\GenericIdentity;
use PHPUnit\Framework\TestCase;

class GenericIdentityTest extends TestCase
{
    function testCanRetrieveAuthenticationStatus(): void
    {
        $expected = false;

        $identity = new GenericIdentity('Charlie', 'cookie', $expected);

        $actual = $identity->isAuthenticated();

        $this->assertEquals($expected, $actual);
    }

    function testCanRetrieveAuthenticationType(): void
    {
        $expected = 'jwt_bearer';

        $identity = new GenericIdentity('Bob', $expected);

        $actual = $identity->getAuthenticationType();

        $this->assertEquals($expected, $actual);
    }

    function testCanRetrieveName(): void
    {
        $expected = 'Alice';

        $identity = new GenericIdentity($expected);

        $actual = $identity->getName();

        $this->assertEquals($expected, $actual);
    }
}
