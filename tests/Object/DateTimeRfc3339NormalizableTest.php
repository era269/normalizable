<?php
declare(strict_types=1);

namespace Era269\Normalizable\Tests\Object;

use Era269\Normalizable\Normalizer\Normalizer\DefaultNormalizationFacade;
use Era269\Normalizable\Object\DateTimeRfc3339Normalizable;
use PHPUnit\Framework\TestCase;
use UnexpectedValueException;

class DateTimeRfc3339NormalizableTest extends TestCase
{
    public function testNormalize(): DateTimeRfc3339Normalizable
    {
        $dateTime = new DateTimeRfc3339Normalizable();

        self::assertEquals(
            [
                '@type' => 'DateTimeRfc3339Normalizable',
                'dateTime' => $dateTime->format(DATE_RFC3339),
            ],
            (new DefaultNormalizationFacade())->normalize($dateTime)
        );

        return $dateTime;
    }

    /**
     * @depends testNormalize
     */
    public function testDenormalize(DateTimeRfc3339Normalizable $dateTime): void
    {
        $normalizedDateTime = (new DefaultNormalizationFacade())->normalize($dateTime);
        self::assertEquals(
            $normalizedDateTime,
            (new DefaultNormalizationFacade())->normalize(
                DateTimeRfc3339Normalizable::denormalize($normalizedDateTime)
            )
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
