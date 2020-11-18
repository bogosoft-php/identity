<?php

declare(strict_types=1);

namespace Bogosoft\Identity\Tests;

use Bogosoft\Identity\DefaultIdentitySelector;
use Bogosoft\Identity\DelegatedIdentitySelector;
use Bogosoft\Identity\GenericIdentity;
use Bogosoft\Identity\IIdentity;
use Bogosoft\Identity\MultiIdentityPrincipal;
use Bogosoft\Identity\NullIdentity;
use DateTime;
use PHPUnit\Framework\TestCase;
use UnexpectedValueException;

class MultiIdentityPrincipalTest extends TestCase
{
    private static function getPrincipal(): MultiIdentityPrincipal
    {
        return new class extends MultiIdentityPrincipal
        {
            /**
             * @inheritDoc
             */
            function isInRole(string $role): bool
            {
                return false;
            }
        };
    }

    function testCanAddIdentity(): void
    {
        $principal = self::getPrincipal();

        $principal->addIdentity(new GenericIdentity('Alice'));

        $this->assertCount(1, $principal);
    }

    function testCanAddMultipleIdentities(): void
    {
        $principal = self::getPrincipal();

        $identities = [
            new GenericIdentity('Alice'),
            new GenericIdentity('Bob')
        ];

        $principal->addIdentities($identities);

        $this->assertSameSize($identities, $principal);
    }

    function testCanIterateIdentities(): void
    {
        $principal = self::getPrincipal();

        $identities = [
            new GenericIdentity('Alice'),
            new GenericIdentity('Bob')
        ];

        $principal->addIdentities($identities);

        $i = 0;

        foreach ($principal as $identity)
            ++$i;

        $this->assertEquals(count($identities), $i);
    }

    function testCannotAddSequenceContainingNonIdentityObjects(): void
    {
        $principal = self::getPrincipal();

        $this->expectException(UnexpectedValueException::class);

        $nonIdentities = [0, 'a', false, new DateTime()];

        $principal->addIdentities($nonIdentities);
    }

    function testCanRetrieveIdentity(): void
    {
        $principal = self::getPrincipal();

        $selector = new DefaultIdentitySelector();

        $principal->setPrimaryIdentitySelector($selector);

        $identities = [
            new GenericIdentity('Alice'),
            new GenericIdentity('Bod')
        ];

        $principal->addIdentities($identities);

        $expected = $selector->selectIdentity($identities);

        $actual = $principal->getIdentity();

        $this->assertEquals($expected->getName(), $actual->getName());
    }

    function testCanSetPrimaryIdentitySelector(): void
    {
        $identities = [
            new GenericIdentity('Alice'),
            new GenericIdentity('Bob')
        ];

        $first = static function(iterable $identities): IIdentity
        {
            foreach ($identities as $identity)
                return $identity;

            return new NullIdentity();
        };

        $selector = new DelegatedIdentitySelector($first);

        $principal = self::getPrincipal();

        $principal->addIdentities($identities);

        $principal->setPrimaryIdentitySelector($selector);

        $actual = $principal->getIdentity();

        $expected = $identities[0];

        $this->assertEquals($expected->getName(), $actual->getName());

        $last = static function(iterable $identities): IIdentity
        {
            /** @var IIdentity $identity */
            $selected = new NullIdentity();

            foreach ($identities as $identity)
                $selected = $identity;

            return $selected;
        };

        $selector = new DelegatedIdentitySelector($last);

        $principal->setPrimaryIdentitySelector($selector);

        $actual = $principal->getIdentity();

        $expected = $identities[count($identities) - 1];

        $this->assertEquals($expected->getName(), $actual->getName());
    }
}
