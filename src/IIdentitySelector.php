<?php

namespace Bogosoft\Identity;

/**
 * Represents a strategy for selecting an identity from a sequence of
 * identities.
 *
 * @package Bogosoft\Identity
 */
interface IIdentitySelector
{
    /**
     * Select an identity from a given sequence of identities.
     *
     * @param  iterable  $identities A sequence of identities from which
     *                               an identity will be selected.
     * @return IIdentity             The selected identity.
     */
    function selectIdentity(iterable $identities): IIdentity;
}
