<?php
declare(strict_types=1);

namespace Era269\Normalizable\Tests\Adapter;

use Era269\Normalizable\Normalizable\DateTimeRfc3339Normalizable;
use PHPUnit\Framework\TestCase;

class DateTimeRfc3339NormalizableTest extends TestCase
{
    public function testNormalize(): DateTimeRfc3339Normalizable
    {
        $datetime = new DateTimeRfc3339Normalizable();

        self::assertEquals(
            [
                '@type' => $datetime::class,
                'dateTime' => $datetime->format(DATE_RFC3339),
            ],
            $datetime->normalize()
        );

        return $datetime;
    }

    /**
     * @depends testNormalize
     */
    public function testDenormalize(DateTimeRfc3339Normalizable $dateTime): void
    {
        self::assertEquals(
            $dateTime,
            DateTimeRfc3339Normalizable::denormalize($dateTime->normalize())
        );
    }
}
