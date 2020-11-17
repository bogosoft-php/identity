<?php

declare(strict_types=1);

namespace Bogosoft\Identity\Tests;

use Bogosoft\Identity\DelegatedIdentitySelector;
use Bogosoft\Identity\GenericIdentity;
use Bogosoft\Identity\IIdentity;
use Bogosoft\Identity\NullIdentity;
use PHPUnit\Framework\TestCase;

class DelegatedIdentitySelectorTest extends TestCase
{
    function testDelegatesSelectionToGivenCallable(): void
    {
        $delegate = function(iterable $identities): IIdentity
        {
            foreach ($identities as $identity)
                return $identity;

            return new NullIdentity();
        };

        $alice = new GenericIdentity('Alice');

        $identities = [$alice];

        $expected = $delegate($identities);

        $selector = new DelegatedIdentitySelector($delegate);

        $actual = $selector->selectIdentity($identities);

        $this->assertEquals($expected->getName(), $actual->getName());
    }
}
