<?php
declare(strict_types=1);


namespace Era269\Normalizable\Adapter;


final class DateTimeToRfc3339NormalizableAdapter extends AbstractDateTimeToNormalizableAdapter
{
    protected function getDateTimeFormat(): string
    {
        return DATE_RFC3339;
    }
}
