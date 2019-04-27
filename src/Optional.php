<?php
namespace Optional;

use Optional\Internal\None;
use Optional\Internal\Some;
use Value\Value;

/**
 * @template T
 */
abstract class Optional implements Value
{
    /** @var None */
    private static $none;

    protected function __construct()
    {
    }

    /**
     * Returns an empty Optional instance. No value is present for this Optional.
     */
    static function empty(): self
    {
        return self::$none ?? self::$none = new None();
    }

    /**
     * Returns an Optional with the specified present non-null value.
     *
     * @template U
     * @param U $value The value to be present, which must be non-null
     * @return Optional<U> An Optional with the value present
     */
    static function of($value): self
    {
        return new Some($value);
    }

    /**
     * Returns an Optional describing the specified value, if non-null, otherwise returns an empty Optional.
     *pwd
     * @template U
     * @param U|null $value The possibly-null value to describe
     * @return Optional<U> An Optional with a present value if the specified value is non-null, otherwise an empty
     *                     Optional
     */
    static function ofNullable($value): self
    {
        return $value === null ? self::empty() : new Some($value);
    }

    /**
     * If a value is present in this Optional, return the value, otherwise throw \RuntimeException.
     *
     * @return T The non-null value held by this Optional
     * @throws \RuntimeException If there is no value present
     */
    abstract function get();

    /**
     * Return true if there is a value present, otherwise false.
     */
    abstract function isPresent(): bool;

    /**
     * If a value is present, invoke the specified consumer with the value, otherwise do nothing.
     *
     * @param callable(T):mixed $consumer Function to be executed if a value is present
     */
    abstract function ifPresent(callable $consumer): void;

    /**
     * If a value is present, and the value matches the given predicate, return an Optional describing the value,
     * otherwise return an empty Optional.
     *
     * @param callable(T):bool $predicate A predicate to apply to the value, if present
     * @return Optional<T> An Optional describing the value of this Optional if a value is present and the value matches
     *                     the given predicate, otherwise an empty Optional
     */
    abstract function filter(callable $predicate): self;

    /**
     * If a value is present, apply the provided mapping function to it, and if the result is non-null, return an
     * Optional describing the result. Otherwise return an empty Optional.
     *
     * @template U
     * @param callable(T):U $mapper A mapping function to apply to the value, if present
     * @return Optional<U> An Optional describing the result of applying a mapping function to the value of this
     *                     Optional, if a value is present, otherwise an empty Optional
     */
    abstract function map(callable $mapper): self;

    /**
     * If a value is present, apply the provided Optional-bearing mapping function to it, return that result, otherwise
     * return an empty Optional. This method is similar to @see Optional::map(), but the provided mapper is one whose
     * result is already an Optional, and if invoked, flatMap does not wrap it with an additional Optional.
     *
     * @template U
     * @param callable(T):Optional<U> $mapper A mapping function to apply to the value, if present
     * @return Optional<U> The result of applying an Optional-bearing mapping function to the value of this Optional, if
     *                     a value is present, otherwise an empty Optional
     */
    abstract function flatMap(callable $mapper): self;

    /**
     * Return the value if present, otherwise return other.
     *
     * @param T $other The value to be returned if there is no value present, may be null
     * @return T The value, if present, otherwise $other
     */
    abstract function or($other);

    /**
     * Return the value if present, otherwise return null.
     *
     * @return T|null The value, if present, otherwise null
     */
    abstract function orNull();

    /**
     * Return the value if present, otherwise invoke other and return the result of that invocation.
     *
     * @param callable():T $other A function whose result is returned if no value is present
     * @return T The value if present otherwise the result of $other()
     */
    abstract function orGet(callable $other);

    /**
     * Return the contained value, if present, otherwise throw an exception to be created by the provided supplier.
     *
     * @param callable():\Throwable $exceptionSupplier The function which will return the exception to be thrown
     * @return T The present value
     */
    abstract function orThrow(callable $exceptionSupplier);
}
