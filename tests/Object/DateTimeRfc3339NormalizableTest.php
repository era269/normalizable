<?php
declare(strict_types=1);

namespace Era269\Normalizable\Tests\Object;

use BadMethodCallException;
use DateTime;
use Era269\Normalizable\Object\DateTimeRfc3339Normalizable;
use PHPUnit\Framework\TestCase;
use UnexpectedValueException;

class DateTimeRfc3339NormalizableTest extends TestCase
{
    public function testNormalize(): DateTimeRfc3339Normalizable
    {
        $datetime = new DateTimeRfc3339Normalizable();

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
    public function testDenormalize(DateTimeRfc3339Normalizable $dateTime): void
    {
        self::assertEquals(
            $dateTime->normalize(),
            DateTimeRfc3339Normalizable::denormalize($dateTime->normalize())->normalize()
        );
    }

    public function testCreateFromInterface(): void
    {
        $dateTime = new DateTime();
        if (PHP_VERSION_ID >= 80000) {
            $dateTimeFrom = DateTimeRfc3339Normalizable::createFromInterface($dateTime);
            self::assertInstanceOf(DateTimeRfc3339Normalizable::class, $dateTimeFrom);
            self::assertEquals(
                $dateTime->format(DATE_RFC3339),
                $dateTimeFrom->format(DATE_RFC3339)
            );
        } else {
            $this->expectException(BadMethodCallException::class);
            DateTimeRfc3339Normalizable::createFromInterface($dateTime);
        }
    }

    public function testCreateFromFormat(): void
    {
        $dateTime = new DateTime();
        $dateTimeFrom = DateTimeRfc3339Normalizable::createFromFormat(
            DATE_RFC3339,
            $dateTime->format(DATE_RFC3339)
        );
        self::assertInstanceOf(DateTimeRfc3339Normalizable::class, $dateTimeFrom);
        self::assertEquals(
            $dateTime->format(DATE_RFC3339),
            $dateTimeFrom->format(DATE_RFC3339)
        );
    }

    public function testDenormalizeFail(): void
    {
        $this->expectException(UnexpectedValueException::class);
        DateTimeRfc3339Normalizable::denormalize(
            []
        );
    }
}
