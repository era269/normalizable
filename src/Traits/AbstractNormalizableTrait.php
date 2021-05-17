<?php

declare(strict_types=1);

namespace Era269\Normalizable\Traits;

use Era269\Normalizable\NormalizableInterface;

trait AbstractNormalizableTrait
{
    /**
     * @return array<string, mixed>
     */
    public function normalize(): array
    {
        return [$this->getTypeFieldName() => $this->getType()]
            + $this->getNormalized();
    }

    protected function getTypeFieldName(): string
    {
        return NormalizableInterface::DEFAULT_FIELD_NAME_TYPE;
    }

    public function getType(): string
    {
        return get_class(
            $this->getObjectForNormalization()
        );
    }

    /**
     * @return object
     */
    protected function getObjectForNormalization()
    {
        return $this;
    }

    /**
     * @return array<string, mixed>
     */
    abstract protected function getNormalized(): array;
}
