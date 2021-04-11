<?php

declare(strict_types=1);

namespace Era269\Normalizable\Tests\Object;

use DateTime;
use DateTimeInterface;
use Era269\Normalizable\NormalizableInterface;
use Era269\Normalizable\Object\DateTimeRfc3339Normalizable;
use Era269\Normalizable\Object\IntegerObject;
use Era269\Normalizable\Object\StringObject;
use Era269\Normalizable\Traits\ValueObjectNormalizableTrait;
use LogicException;
use PHPUnit\Framework\TestCase;

class ValueObjectNormalizableTraitTest extends TestCase
{
    public function testNormalize(): void
    {
        $dateTime = new DateTimeRfc3339Normalizable();
        $normalizable = $this->createNormalizable($dateTime);
        self::assertEquals(
            [
                '@type' => $normalizable::class,
                'publicInt' => 1,
                'privateInt' => 2,
                'protectedInt' => 3,
                'privateNullableInt' => null,
                'privateString' => '2',
                'privateBool' => false,
                'privateArray' => [1, '1', false, null],
                'integerObject' => 5,
                'stringObject' => '10',
                'dateTimeRfc3339Normalizable' => $dateTime->normalize(),
            ],
            $normalizable->normalize()
        );
    }

    private function createNormalizable(DateTimeRfc3339Normalizable $dateTimeRfc3339Normalizable): NormalizableInterface
    {
        return new class (
            1,
            2,
            3,
            null,
            '2',
            false,
            [1, '1', false, null],
            new IntegerObject(5),
            new StringObject('10'),
            $dateTimeRfc3339Normalizable,
        ) implements NormalizableInterface {
            use ValueObjectNormalizableTrait;

            /**
             * @param array<int, mixed> $privateArray
             */
            public function __construct(
                public int $publicInt,
                private int $privateInt,
                protected int $protectedInt,
                private ?int $privateNullableInt,
                private string $privateString,
                private bool $privateBool,
                private array $privateArray,
                private IntegerObject $integerObject,
                private StringObject $stringObject,
                private DateTimeInterface $dateTimeRfc3339Normalizable,
            )
            {
            }

            /**
             * @return array<string, mixed>
             */
            protected function getNormalized(): array
            {
                return $this->getSelfNormalized();
            }
        };
    }

    public function testNormalizableFail(): void
    {
        $this->expectException(LogicException::class);
        $this->createNormalizableWithWrongParameterType()
            ->normalize();
    }

    protected function createNormalizableWithWrongParameterType(): NormalizableInterface
    {
        return new class (
            new DateTime()
        ) implements NormalizableInterface {
            use ValueObjectNormalizableTrait;

            public function __construct(
                private DateTimeInterface $dateTime,
            )
            {
            }

            /**
             * @return array<string, mixed>
             */
            protected function getNormalized(): array
            {
                return $this->getSelfNormalized();
            }
        };
    }
}
