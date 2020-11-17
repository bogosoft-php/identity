<?php

declare(strict_types=1);

namespace Bogosoft\Identity\Tests;

use Bogosoft\Identity\NullIdentity;
use PHPUnit\Framework\TestCase;

class NullIdentityTest extends TestCase
{
    function testNullIdentityHasNullAuthenticationType(): void
    {
        $identity = new NullIdentity();

        $this->assertNull($identity->getAuthenticationType());
    }

    function testNullIdentityHasNullName(): void
    {
        $identity = new NullIdentity();

        $this->assertNull($identity->getName());
    }

    function testNullIdentityIsNotAuthenticated(): void
    {
        $identity = new NullIdentity();

        $this->assertFalse($identity->isAuthenticated());
    }
}
