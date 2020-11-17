<?php

declare(strict_types=1);

namespace Bogosoft\Identity;

/**
 * A null implementation of the {@see IIdentity} contract useful for
 * representing anonymous or unauthenticated identities.
 *
 * @package Bogosoft\Identity
 */
final class NullIdentity implements IIdentity
{
    /**
     * @inheritDoc
     */
    function getAuthenticationType(): ?string
    {
        return null;
    }

    /**
     * @inheritDoc
     */
    function getName(): ?string
    {
        return null;
    }

    /**
     * @inheritDoc
     */
    function isAuthenticated(): bool
    {
        return false;
    }
}
