<?php

declare(strict_types=1);

namespace Era269\Normalizable\Abstraction;

use Era269\Normalizable\StringNormalizableInterface;
use Era269\Normalizable\Traits\StringObjectTrait;

abstract class AbstractStringNormalizable extends AbstractNormalizable implements StringNormalizableInterface
{
    use StringObjectTrait;

    /**
     * @return array<string, string>
     */
    protected function getNormalized(): array
    {
        return [
            $this->getValueFieldName() => (string)$this->getObjectForNormalization()
        ];
    }

    abstract protected static function getValueFieldName(): string;
}
