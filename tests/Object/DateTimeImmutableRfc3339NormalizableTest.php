<?php
declare(strict_types=1);

namespace Era269\Normalizable\Tests\Object;

use Era269\Normalizable\Object\DateTimeImmutableRfc3339Normalizable;
use PHPUnit\Framework\TestCase;
use UnexpectedValueException;

class DateTimeImmutableRfc3339NormalizableTest extends TestCase
{
    public function testNormalize(): DateTimeImmutableRfc3339Normalizable
    {
        $datetime = new DateTimeImmutableRfc3339Normalizable();

        self::assertEquals(
            [
                '@type' => get_class($datetime),
                'dateTime' => $datetime->format(DATE_RFC3339),
            ],
            $datetime->normalize()
        );

        return $datetime;
    }

    /**
     * @depends testNormalize
     */
    public function testDenormalize(DateTimeImmutableRfc3339Normalizable $dateTime): void
    {
        self::assertEquals(
            $dateTime->normalize(),
            DateTimeImmutableRfc3339Normalizable::denormalize($dateTime->normalize())->normalize()
        );
    }

    public function testDenormalizeFail(): void
    {
        $this->expectException(UnexpectedValueException::class);
        DateTimeImmutableRfc3339Normalizable::denormalize(
            []
        );
    }
}
