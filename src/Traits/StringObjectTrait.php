<?php

declare(strict_types=1);

namespace Era269\Normalizable\Traits;

use Era269\Normalizable\ComparableInterface;

trait StringObjectTrait
{
    /**
     * @var string
     */
    private $value;

    public function __construct(
        string $value
    )
    {
        $this->value = $value;
    }

    public function equals(ComparableInterface $to): bool
    {
        return $to->equalsTo(
            $this->toScalar()
        );
    }

    public function toScalar(): string
    {
        return (string) $this;
    }

    public function __toString(): string
    {
        return $this->value;
    }

    /**
     * @inheritDoc
     */
    public function equalsTo($scalar): bool
    {
        return $scalar === $this->toScalar();
    }
}
