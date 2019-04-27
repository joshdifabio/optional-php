<?php
namespace Optional\Internal;

use Optional\Optional;

final class None extends Optional
{
    function get()
    {
        throw new \RuntimeException('No value is present for the optional.');
    }

    function isPresent(): bool
    {
        return false;
    }

    function ifPresent(callable $consumer): void
    {
        // nothing to do
    }

    function filter(callable $predicate): Optional
    {
        return $this;
    }

    function map(callable $mapper): Optional
    {
        return $this;
    }

    function flatMap(callable $mapper): Optional
    {
        return $this;
    }

    function or($other)
    {
        return $other;
    }

    function orNull()
    {
        return null;
    }

    function orGet(callable $other)
    {
        return $other();
    }

    function orThrow(callable $exceptionSupplier)
    {
        throw $exceptionSupplier();
    }

    function equals($value): bool
    {
        return $value instanceof self;
    }

    function hashCode(): int
    {
        return 0;
    }
}
