<?php

declare(strict_types=1);

namespace Bogosoft\Identity;

/**
 * A simple implementation of the {@see IIdentity} contract.
 *
 * @package Bogosoft\Identity
 */
final class GenericIdentity implements IIdentity
{
    private bool $authenticated;
    private string $authType, $name;

    /**
     * Create a new generic identity.
     *
     * @param string $name          A name to associated with the new identity.
     * @param string $authType      The name of an authentication method.
     * @param bool   $authenticated A value indicating whether or not the
     *                              new identity should be considered to be
     *                              authenticated.
     */
    function __construct(
        string $name,
        string $authType = '',
        bool $authenticated = true
        )
    {
        $this->authenticated = $authenticated;
        $this->authType      = $authType;
        $this->name          = $name;
    }

    /**
     * @inheritDoc
     */
    function getAuthenticationType(): ?string
    {
        return $this->authType;
    }

    /**
     * @inheritDoc
     */
    function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @inheritDoc
     */
    function isAuthenticated(): bool
    {
        return $this->authenticated;
    }
}
