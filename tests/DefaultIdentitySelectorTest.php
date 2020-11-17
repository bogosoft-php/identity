<?php

declare(strict_types=1);

namespace Bogosoft\Identity\Tests;

use Bogosoft\Identity\DefaultIdentitySelector;
use Bogosoft\Identity\GenericIdentity;
use Bogosoft\Identity\NullIdentity;
use PHPUnit\Framework\TestCase;

class DefaultIdentitySelectorTest extends TestCase
{
    function testSelectsFirstIdentityFromSequenceOfMoreThanOneIdentity(): void
    {
        $a = new GenericIdentity('Alice');
        $b = new GenericIdentity('Bob');

        $identities = [$a, $b];

        $this->assertGreaterThan(1, count($identities));

        $selector = new DefaultIdentitySelector();

        $actual = $selector->selectIdentity($identities);

        $this->assertTrue($actual->isAuthenticated());

        $this->assertEquals($a->getName(), $actual->getName());
    }

    function testSelectsNullIdentityWhenIdentitySequenceIsEmpty(): void
    {
        $identities = [];

        $this->assertEmpty($identities);

        $selector = new DefaultIdentitySelector();

        $identity = $selector->selectIdentity($identities);

        $this->assertInstanceOf(NullIdentity::class, $identity);
    }

    function testSelectsOnlyIdentityFromSequenceWithOnlyOneIdentity(): void
    {
        $expected = new GenericIdentity('Alice');

        $identities = [$expected];

        $this->assertCount(1, $identities);

        $selector = new DefaultIdentitySelector();

        $actual = $selector->selectIdentity($identities);

        $this->assertTrue($actual->isAuthenticated());

        $this->assertEquals($expected->getName(), $actual->getName());
    }
}
