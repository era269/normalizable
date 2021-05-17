<?php

declare(strict_types=1);

namespace Era269\Normalizable;

interface StringInterface extends ComparableInterface, ScalarableInterface
{
    /**
     * Magic method {@see https://www.php.net/manual/en/language.oop5.magic.php}
     * called during serialization to string.
     *
     * @return string Returns string representation of the object that
     * implements this interface (and/or "__toString" magic method).
     */
    public function __toString(): string;

    public function toScalar(): string;
}
