<?php

namespace Bogosoft\Identity;

/**
 * Represents the identity of a user or agent.
 *
 * @package Bogosoft\Identity
 */
interface IIdentity
{
    /**
     * Get the type of authentication used to establish the current identity.
     *
     * Implementations SHOULD return {@see null} if the current identity has
     * not been authenticated.
     *
     * @return string An authentication type.
     */
    function getAuthenticationType(): ?string;

    /**
     * Get the name of the current identity.
     *
     * Implementations SHOULD return {@see null} if the current identity has
     * not been authenticated.
     *
     * @return string The name of the current identity.
     */
    function getName(): ?string;

    /**
     * Get a value indicating whether or not the current identity has been
     * authenticated.
     *
     * @return bool {@see true} if the current identity has been authenticated;
     *              {@see false} otherwise.
     */
    function isAuthenticated(): bool;
}
