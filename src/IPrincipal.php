<?php

namespace Bogosoft\Identity;

/**
 * Represents the security context of a user or agent on whose behalf code is
 * running.
 *
 * @package Bogosoft\Identity
 */
interface IPrincipal
{
    /**
     * Get the identity of the current principal.
     *
     * @return IIdentity The identity of the current principal.
     */
    function getIdentity(): IIdentity;

    /**
     * Get a value indicating whether or not the current principal is within
     * a given role.
     *
     * @param  string $role The name of a role.
     * @return bool         {@see true} if the current principal is considered
     *                      to be in the given role; {@see false} otherwise.
     */
    function isInRole(string $role): bool;
}
