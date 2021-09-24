<?php
declare(strict_types=1);

namespace Era269\Normalizable\Tests\Object;

use BadMethodCallException;
use DateTime;
use DateTimeImmutable;
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

    public function testCreateFromInterface(): void
    {
        $dateTime = new DateTimeImmutable();
        if (PHP_VERSION_ID >= 80000) {
            $dateTimeFrom = DateTimeImmutableRfc3339Normalizable::createFromInterface($dateTime);
            self::assertInstanceOf(DateTimeImmutableRfc3339Normalizable::class, $dateTimeFrom);
            self::assertEquals(
                $dateTime->format(DATE_RFC3339),
                $dateTimeFrom->format(DATE_RFC3339)
            );
        } else {
            $this->expectException(BadMethodCallException::class);
            DateTimeImmutableRfc3339Normalizable::createFromInterface($dateTime);
        }
    }

    public function testCreateFromFormat(): void
    {
        $dateTime = new DateTimeImmutable();
        $dateTimeFrom = DateTimeImmutableRfc3339Normalizable::createFromFormat(
            DATE_RFC3339,
            $dateTime->format(DATE_RFC3339)
        );
        self::assertInstanceOf(DateTimeImmutableRfc3339Normalizable::class, $dateTimeFrom);
        self::assertEquals(
            $dateTime->format(DATE_RFC3339),
            $dateTimeFrom->format(DATE_RFC3339)
        );
    }

    public function testCreateFromMutable(): void
    {
        $dateTime = new DateTime();
        $dateTimeFrom = DateTimeImmutableRfc3339Normalizable::createFromMutable($dateTime);
        self::assertInstanceOf(DateTimeImmutableRfc3339Normalizable::class, $dateTimeFrom);
        self::assertEquals(
            $dateTime->format(DATE_RFC3339),
            $dateTimeFrom->format(DATE_RFC3339)
        );
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
