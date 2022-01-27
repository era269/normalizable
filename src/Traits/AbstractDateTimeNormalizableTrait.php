<?php

declare(strict_types=1);

namespace Era269\Normalizable\Traits;

use DateTimeInterface;
use DateTimeZone;
use Exception;
use UnexpectedValueException;

trait AbstractDateTimeNormalizableTrait
{
    use NormalizableTrait;

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
    private function getObjectVars(): array
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
