<?php

declare(strict_types=1);

namespace Era269\Normalizable\Object;

use Era269\Normalizable\Abstraction\AbstractDateTimeNormalizable;

final class DateTimeRfc3339Normalizable extends AbstractDateTimeNormalizable
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
