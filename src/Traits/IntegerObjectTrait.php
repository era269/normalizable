<?php

declare(strict_types=1);

namespace Era269\Normalizable\Traits;

use Era269\Normalizable\ComparableInterface;

trait IntegerObjectTrait
{
    public function __construct(
        private int $value,
    )
    {
    }

    public function equals(ComparableInterface $to): bool
    {
        return $to->equalsTo(
            $this->toScalar()
        );
    }

    public function toScalar(): int
    {
        return $this->toInteger();
    }

    public function toInteger(): int
    {
        return $this->value;
    }

    public function equalsTo(float|bool|int|string $scalar): bool
    {
        return $scalar === $this->toInteger();
    }
}
