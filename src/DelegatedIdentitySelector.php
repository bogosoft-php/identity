<?php

declare(strict_types=1);

namespace Bogosoft\Identity;

/**
 * An implementation of the {@see IIdentitySelector} contract that delegates
 * the responsibility of selecting an identity from a sequence of identities
 * to a {@see callable} object.
 *
 * The delegate is expected to be of the form ...
 *
 * - fn({@see iterable}): {@see IIdentity}
 *
 * ... where the {@see iterable} input parameter is a sequence of
 * {@see IIdentity} objects.
 *
 * This class cannot be inherited.
 *
 * @package Bogosoft\Identity
 */
final class DelegatedIdentitySelector implements IIdentitySelector
{
    /** @var callable */
    private $delegate;

    /**
     * Create a new delegated identity selector.
     *
     * @param callable $delegate An invokable object to which identity
     *                           selection will be delegated.
     */
    function __construct(callable $delegate)
    {
        $this->delegate = $delegate;
    }

    /**
     * @inheritDoc
     */
    function selectIdentity(iterable $identities): IIdentity
    {
        return ($this->delegate)($identities);
    }
}
