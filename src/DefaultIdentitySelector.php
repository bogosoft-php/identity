<?php

declare(strict_types=1);

namespace Bogosoft\Identity;

/**
 * A simple implementation of the {@see IIdentitySelector} contract that
 * selects the first identity in a non-empty sequence of identities.
 *
 * If an empty sequence of identities is provided, an instance of the
 * {@see NullIdentity} class will be returned.
 *
 * This class cannot be inherited.
 *
 * @package Bogosoft\Identity
 */
final class DefaultIdentitySelector implements IIdentitySelector
{
    /**
     * @inheritDoc
     */
    function selectIdentity(iterable $identities): IIdentity
    {
        foreach ($identities as $identity)
            return $identity;

        return new NullIdentity();
    }
}
