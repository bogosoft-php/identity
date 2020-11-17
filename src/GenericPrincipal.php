<?php

declare(strict_types=1);

namespace Bogosoft\Identity;

/**
 * A simple implementation of the {@see IPrincipal} contract.
 *
 * This class cannot be inherited.
 *
 * @package Bogosoft\Identity
 */
final class GenericPrincipal implements IPrincipal
{
    private ?IIdentity $identity;
    private iterable $roles;

    /**
     * Create a new generic principal.
     *
     * @param IIdentity|null $identity An optional identity to associate with
     *                                 the new principal.
     * @param array|iterable $roles    An optional collection of roles to
     *                                 which the new principal will belong.
     */
    function __construct(IIdentity $identity = null, iterable $roles = [])
    {
        $this->identity = $identity;
        $this->roles    = $roles;
    }

    /**
     * @inheritDoc
     */
    function getIdentity(): IIdentity
    {
        return $this->identity ?? new NullIdentity();
    }

    /**
     * @inheritDoc
     */
    function isInRole(string $role): bool
    {
        foreach ($this->roles as $r)
            if ($r === $role)
                return true;

        return false;
    }
}
