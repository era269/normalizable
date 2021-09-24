<?php

declare(strict_types=1);

namespace Era269\Normalizable\Traits;

use BadMethodCallException;
use DateTimeInterface;
use DateTimeZone;
use Exception;
use UnexpectedValueException;

trait AbstractDateTimeNormalizableTrait
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

    final protected static function throwInvalidMethodCallException(int $phpVersion, string $methodName): void
    {
        throw new BadMethodCallException(sprintf(
            'Method "%s" is available starting with %s PHP version',
            $phpVersion,
            $methodName
        ));
    }

    /**
     * @inheritDoc
     * @return static|false
     */
    public static function createFromFormat($format, $datetime, DateTimeZone $timezone = null)
    {
        return parent::createFromFormat($format, $datetime, $timezone);
    }
}
