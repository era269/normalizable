<?php

declare(strict_types=1);

namespace Era269\Normalizable\Normalizable;

use DateTime;
use DateTimeInterface;
use DateTimeZone;
use Era269\Normalizable\DenormalizableInterface;
use Era269\Normalizable\NormalizableInterface;
use Era269\Normalizable\Traits\AbstractNormalizableTrait;

abstract class AbstractDateTimeNormalizable extends DateTime implements NormalizableInterface, DenormalizableInterface
{
    use AbstractNormalizableTrait;

    final public function __construct(string $datetime = 'now', DateTimeZone $timezone = null)
    {
        parent::__construct($datetime, $timezone);
    }

    /**
     * ToDo: return "static" with php 8
     * @inheritDoc
     */
    public static function denormalize(array $data): self
    {
        return new static(
            $data[static::getDateTimeFieldName()]
        );
    }

    abstract protected static function getDateTimeFieldName(): string;

    /**
     * @inheritDoc
     */
    public function getNormalized(): array
    {
        return [
            $this->getDateTimeFieldName() => $this->getObjectForNormalization()->format(
                $this->getDateTimeFormat()
            )
        ];
    }

    final protected function getObjectForNormalization(): DateTimeInterface
    {
        return $this;
    }

    abstract protected function getDateTimeFormat(): string;
}
