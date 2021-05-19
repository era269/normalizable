<?php

declare(strict_types=1);

namespace Era269\Normalizable\Object;

use Era269\Normalizable\Abstraction\AbstractDateTimeImmutableNormalizable;

final class DateTimeImmutableRfc3339Normalizable extends AbstractDateTimeImmutableNormalizable
{
    private const FIELD_NAME_DATE_TIME = 'dateTime';

    protected static function getDateTimeFieldName(): string
    {
        return self::FIELD_NAME_DATE_TIME;
    }

    protected function getDateTimeFormat(): string
    {
        return DATE_RFC3339;
    }
}
