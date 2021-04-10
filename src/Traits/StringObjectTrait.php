<?php

declare(strict_types=1);

namespace Era269\Normalizable\Traits;


use Era269\Normalizable\ComparableInterface;

trait StringObjectTrait
{
    public function __construct(
        private string $value,
    )
    {
    }

    public function equals(ComparableInterface $to): bool
    {
        return $to->equalsTo(
            $this->toScalar()
        );
    }

    public function toScalar(): string
    {
        return (string)$this;
    }

    public function __toString(): string
    {
        return $this->value;
    }

    public function equalsTo(float|bool|int|string $scalar): bool
    {
        return $scalar === $this->toScalar();
    }
}
