<?php

declare(strict_types=1);

namespace Bogosoft\Identity;

use IteratorAggregate;
use UnexpectedValueException;

/**
 * A partial implementation of the {@see IPrincipal} contract that represents
 * a principal consisting of
 * @package Bogosoft\Identity
 */
abstract class MultiIdentityPrincipal implements IPrincipal, IteratorAggregate
{
    private iterable $identities = [];
    private IIdentitySelector $selector;

    protected function __construct(IIdentitySelector $selector = null)
    {
        $this->selector = $selector ?? new DefaultIdentitySelector();
    }

    /**
     * Add an identity to the current principal.
     *
     * @param IIdentity $identity An identity.
     */
    function addIdentity(IIdentity $identity): void
    {
        $this->identities[] = $identity;
    }

    /**
     * Add a sequence of identities to the current principal.
     *
     * @param iterable $identities A sequence of {@see IIdentity} objects.
     */
    function addIdentities(iterable $identities): void
    {
        static $error_message =
            'Sequence contains element which does not implement the .\''
            . IIdentity::class
            . '\' interface.';

        foreach ($identities as $identity)
        {
            if (!($identity instanceof IIdentity))
                throw new UnexpectedValueException($error_message);

            $this->identities[] = $identity;
        }
    }

    /**
     * @inheritDoc
     */
    function getIdentity(): IIdentity
    {
        return $this->selector->selectIdentity($this->identities);
    }

    /**
     * @inheritDoc
     */
    function getIterator()
    {
        yield from $this->identities;
    }

    /**
     * Get the selection strategy used to select the primary identity from
     * the identity pool of the current principal.
     *
     * @return IIdentitySelector An identity selection strategy.
     */
    function getPrimaryIdentitySelector(): IIdentitySelector
    {
        return $this->selector;
    }

    /**
     * Set the selection strategy to be used when selecting the primary
     * identity from the identity pool of the current principal.
     *
     * @param IIdentitySelector $selector An identity selection strategy.
     */
    function setPrimaryIdentitySelector(IIdentitySelector $selector): void
    {
        $this->selector = $selector;
    }
}
