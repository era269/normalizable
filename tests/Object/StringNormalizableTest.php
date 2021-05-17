<?php

declare(strict_types=1);

namespace Era269\Normalizable\Tests\Object;

use Era269\Normalizable\Object\StringNormalizable;
use PHPUnit\Framework\TestCase;

class StringNormalizableTest extends TestCase
{
    private const FIELD_NAME_VALUE = 'value';
    private const VALUE            = 'some_string';

    public function test(): void
    {
        $normalized = (new StringNormalizable('some_string'))->normalize();
        self::assertArrayHasKey(
            self::FIELD_NAME_VALUE,
            $normalized
        );
        self::assertEquals(
            self::VALUE,
            $normalized[self::FIELD_NAME_VALUE]
        );
    }
}
