<?php

declare(strict_types=1);

namespace Era269\Normalizable\Object;

use Era269\Normalizable\Abstraction\AbstractStringNormalizable;

class StringNormalizable extends AbstractStringNormalizable
{
    private const FIELD_NAME_VALUE = 'value';

    protected static function getValueFieldName(): string
    {
        return self::FIELD_NAME_VALUE;
    }
}
