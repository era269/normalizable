<?php

declare(strict_types=1);

namespace Era269\Normalizable\Object;

use DateTimeInterface;
use Era269\Normalizable\Abstraction\AbstractDateTimeImmutableNormalizable;

final class DateTimeImmutableRfc3339Normalizable extends AbstractDateTimeImmutableNormalizable
{
    private const FIELD_NAME_DATE_TIME = 'dateTime';

    /**
     * @inheritDoc
     */
    public static function createFromInterface(DateTimeInterface $object): self
    {
        $phpVersion = 80000;
        if (PHP_VERSION_ID < $phpVersion) {
            self::throwInvalidMethodCallException($phpVersion, __METHOD__);
        }
        /** @var self $dateTime */
        $dateTime = parent::createFromInterface($object);

        return $dateTime;
    }

    protected static function getDateTimeFieldName(): string
    {
        return self::FIELD_NAME_DATE_TIME;
    }

    protected function getDateTimeFormat(): string
    {
        return DATE_RFC3339;
    }
}
