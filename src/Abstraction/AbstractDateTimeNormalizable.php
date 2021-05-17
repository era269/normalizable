<?php

declare(strict_types=1);

namespace Era269\Normalizable\Abstraction;

use DateTime;
use DateTimeInterface;
use DateTimeZone;
use Era269\Normalizable\DenormalizableInterface;
use Era269\Normalizable\NormalizableInterface;
use Era269\Normalizable\Traits\AbstractNormalizableTrait;
use Exception;
use UnexpectedValueException;

abstract class AbstractDateTimeNormalizable extends DateTime implements NormalizableInterface, DenormalizableInterface
{
    use AbstractNormalizableTrait;

    final public function __construct(string $datetime = 'now', DateTimeZone $timezone = null)
    {
        parent::__construct($datetime, $timezone);
    }

    /**
     * @inheritDoc
     */
    public static function denormalize(array $data)
    {
        try {
            return new static(
                $data[static::getDateTimeFieldName()]
            );
        } catch (Exception $exception) {
            $message = sprintf('Cannot denormalize "%s"', static::class);
            throw new UnexpectedValueException($message, 0, $exception);
        }
    }

    abstract protected static function getDateTimeFieldName(): string;

    /**
     * @return array<string, string>
     */
    public function getNormalized(): array
    {
        return [
            $this->getDateTimeFieldName() => $this->getObjectForNormalization()->format(
                $this->getDateTimeFormat()
            ),
        ];
    }

    final protected function getObjectForNormalization(): DateTimeInterface
    {
        return $this;
    }

    abstract protected function getDateTimeFormat(): string;
}
