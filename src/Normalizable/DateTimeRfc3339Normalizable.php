<?php
declare(strict_types=1);


namespace Era269\Normalizable\Normalizable;


final class DateTimeRfc3339Normalizable extends AbstractDateTimeNormalizable
{
    private const FIELD_NAME_DATE_TIME = 'dateTime';

    protected function getDateTimeFormat(): string
    {
        return DATE_RFC3339;
    }

    protected static function getDateTimeFieldName(): string
    {
        return self::FIELD_NAME_DATE_TIME;
    }
}
