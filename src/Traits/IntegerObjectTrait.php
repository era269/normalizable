<?php

declare(strict_types=1);

namespace Era269\Normalizable\Traits;

use Era269\Normalizable\ComparableInterface;

trait IntegerObjectTrait
{
    /**
     * @var int
     */
    private $value;

    public function __construct(
        int $value
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

    public function toScalar(): int
    {
        return $this->toInteger();
    }

    public function toInteger(): int
    {
        return $this->value;
    }

    /**
     * @inheritDoc
     */
    public function equalsTo($scalar): bool
    {
        return $scalar === $this->toInteger();
    }
}
