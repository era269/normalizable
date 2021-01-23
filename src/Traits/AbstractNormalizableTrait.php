<?php

declare(strict_types=1);

namespace Era269\Normalizable\Traits;

use Era269\Normalizable\NormalizableInterface;

trait AbstractNormalizableTrait
{
    /**
     * @return array<string, string|int|array|bool|float|null>
     */
    public function normalize(): array
    {
        return [$this->getTypeFieldName() => $this->getObjectForNormalization()::class]
            + $this->getNormalized();
    }

    protected function getTypeFieldName(): string
    {
        return NormalizableInterface::DEFAULT_FIELD_NAME_TYPE;
    }

    /**
     * @return string
     */
    protected function getObjectForNormalization(): object
    {
        return $this;
    }

    /**
     * @return array<string, string|int|array|bool|float|null>
     */
    abstract protected function getNormalized(): array;
}
