<?php
namespace Optional\Internal;

use Optional\Optional;
use function Value\equal;
use function Value\hash;

final class Some extends Optional
{
    private $value;
    private $hashCode;

    protected function __construct($value)
    {
        if ($value === null) {
            throw new \LogicException();
        }
        $this->value = $value;
    }

    function get()
    {
        return $this->value;
    }

    function isPresent(): bool
    {
        return true;
    }

    function ifPresent(callable $consumer): void
    {
        $consumer($this->value);
    }

    function filter(callable $predicate): Optional
    {
        return $predicate($this->value) ? Optional::of($this->value) : Optional::empty();
    }

    function map(callable $mapper): Optional
    {
        return Optional::ofNullable($mapper($this->value));
    }

    function flatMap(callable $mapper): Optional
    {
        return $mapper($this->value);
    }

    function or($other)
    {
        return $this->value;
    }

    function orNull()
    {
        return $this->value;
    }

    function orGet(callable $other)
    {
        return $this->value;
    }

    function orThrow(callable $exceptionSupplier)
    {
        return $this->value;
    }

    function equals($value): bool
    {
        return $value instanceof Some && equal($this->value, $value->value);
    }

    function hashCode(): int
    {
        return $this->hashCode ?? $this->hashCode = hash($this->value);
    }
}
