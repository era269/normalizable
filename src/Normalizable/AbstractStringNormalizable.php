<?php

declare(strict_types=1);

namespace Era269\Normalizable\Normalizable;

use Era269\Normalizable\AbstractNormalizableObject;
use Era269\Normalizable\StringNormalizableInterface;

abstract class AbstractStringNormalizable extends AbstractNormalizableObject implements StringNormalizableInterface
{
    public function __construct(
        private string $value
    )
    {

    }

    /**
     * @inheritDoc
     */
    public function __toString(): string
    {
        return $this->value;
    }

    /**
     * @inheritDoc
     */
    public function equals(StringNormalizableInterface $to): bool
    {
        return (string)$this === (string)$to;
    }

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
