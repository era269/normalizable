<?php
declare(strict_types=1);

namespace Era269\Normalizable\Tests\Object;

use Era269\Normalizable\Normalizer\Normalizer\DefaultNormalizationFacade;
use Era269\Normalizable\Object\DateTimeImmutableRfc3339Normalizable;
use PHPUnit\Framework\TestCase;
use UnexpectedValueException;

class DateTimeImmutableRfc3339NormalizableTest extends TestCase
{
    public function testNormalize(): DateTimeImmutableRfc3339Normalizable
    {
        $dateTime = new DateTimeImmutableRfc3339Normalizable();

        self::assertEquals(
            [
                '@type' => 'DateTimeImmutableRfc3339Normalizable',
                'dateTime' => $dateTime->format(DATE_RFC3339),
            ],
            (new DefaultNormalizationFacade())->normalize($dateTime)
        );

        return $dateTime;
    }

    /**
     * @depends testNormalize
     */
    public function testDenormalize(DateTimeImmutableRfc3339Normalizable $dateTime): void
    {
        $normalizedDateTime = (new DefaultNormalizationFacade())->normalize($dateTime);
        self::assertEquals(
            $normalizedDateTime,
            (new DefaultNormalizationFacade())->normalize(
                DateTimeImmutableRfc3339Normalizable::denormalize($normalizedDateTime)
            )
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
