<?php

declare(strict_types=1);

namespace Era269\Normalizable\Tests\Object;

use DateTime;
use DateTimeInterface;
use Era269\Normalizable\NormalizableInterface;
use Era269\Normalizable\Object\DateTimeRfc3339Normalizable;
use Era269\Normalizable\Object\IntegerObject;
use Era269\Normalizable\Object\StringObject;
use Era269\Normalizable\Traits\SimpleNormalizableTrait;
use Exception;
use LogicException;
use PHPUnit\Framework\TestCase;

class SimpleNormalizableTraitTest extends TestCase
{
    public function testNormalize(): void
    {
        $dateTime = new DateTimeRfc3339Normalizable();
        $stringable = new Exception('message', 269);
        $normalizable = $this->createAutoNormalizable($dateTime, $stringable);
        self::assertEquals(
            $this->getExpectedNormalized($normalizable, $dateTime, $stringable, 1),
            $normalizable->normalize()
        );
    }

    /**
     * @param object $stringable
     */
    private function createAutoNormalizable(
        DateTimeRfc3339Normalizable $dateTimeRfc3339Normalizable,
        $stringable
    ): NormalizableInterface
    {
        return new class (
            1,
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
            $stringable
        ) implements NormalizableInterface {
            use SimpleNormalizableTrait;

            /**
             * @var int
             */
            public $publicInt;
            /**
             * @var int
             */
            public $publicIntManuallyNormalized;
            /**
             * @var int
             */
            private $privateInt;
            /**
             * @var int
             */
            protected $protectedInt;
            /**
             * @var int|null
             */
            private $privateNullableInt;
            /**
             * @var string
             */
            private $privateString;
            /**
             * @var bool
             */
            private $privateBool;
            /**
             * @var array[]
             */
            private $privateArray;
            /**
             * @var IntegerObject
             */
            private $integerObject;
            /**
             * @var StringObject
             */
            private $stringObject;
            /**
             * @var DateTimeInterface
             */
            private $dateTimeRfc3339Normalizable;
            /**
             * @var object
             */
            private $stringable;

            /**
             * @param object $stringable
             * @param array<int, mixed> $privateArray
             */
            public function __construct(
                int $publicInt,
                int $publicIntManuallyNormalized,
                int $privateInt,
                int $protectedInt,
                ?int $privateNullableInt,
                string $privateString,
                bool $privateBool,
                array $privateArray,
                IntegerObject $integerObject,
                StringObject $stringObject,
                DateTimeInterface $dateTimeRfc3339Normalizable,
                $stringable
            )
            {
                $this->publicInt = $publicInt;
                $this->publicIntManuallyNormalized = $publicIntManuallyNormalized;
                $this->privateInt = $privateInt;
                $this->protectedInt = $protectedInt;
                $this->privateNullableInt = $privateNullableInt;
                $this->privateString = $privateString;
                $this->privateBool = $privateBool;
                $this->privateArray = $privateArray;
                $this->integerObject = $integerObject;
                $this->stringObject = $stringObject;
                $this->dateTimeRfc3339Normalizable = $dateTimeRfc3339Normalizable;
                $this->stringable = $stringable;
            }
        };
    }

    /**
     * @param object $stringable
     *
     * @return array<string, mixed>
     */
    private function getExpectedNormalized(
        NormalizableInterface $normalizable,
        DateTimeRfc3339Normalizable $dateTime,
        $stringable,
        int $publicIntManuallyNormalized
    ): array
    {
        return [
            '@type' => get_class($normalizable),
            'publicInt' => 1,
            'publicIntManuallyNormalized' => $publicIntManuallyNormalized,
            'privateInt' => 2,
            'protectedInt' => 3,
            'privateNullableInt' => null,
            'privateString' => '2',
            'privateBool' => false,
            'privateArray' => [1, '1', false, null],
            'integerObject' => 5,
            'stringObject' => '10',
            'dateTimeRfc3339Normalizable' => $dateTime->normalize(),
            'stringable' => (string) $stringable,
        ];
    }

    public function testAutoNormalize(): void
    {
        $dateTime = new DateTimeRfc3339Normalizable();
        $stringable = new Exception('message', 269);
        $normalizable = $this->createNormalizable($dateTime, $stringable);
        self::assertEquals(
            $this->getExpectedNormalized($normalizable, $dateTime, $stringable, 2),
            $normalizable->normalize()
        );
    }

    /**
     * @param object $stringable
     */
    private function createNormalizable(DateTimeRfc3339Normalizable $dateTimeRfc3339Normalizable, $stringable): NormalizableInterface
    {
        return new class (
            1,
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
            $stringable
        ) implements NormalizableInterface {
            use SimpleNormalizableTrait;

            /**
             * @var int
             */
            public $publicInt;
            /**
             * @var int
             */
            public $publicIntManuallyNormalized;
            /**
             * @var int
             */
            private $privateInt;
            /**
             * @var int
             */
            protected $protectedInt;
            /**
             * @var int|null
             */
            private $privateNullableInt;
            /**
             * @var string
             */
            private $privateString;
            /**
             * @var bool
             */
            private $privateBool;
            /**
             * @var array[]
             */
            private $privateArray;
            /**
             * @var IntegerObject
             */
            private $integerObject;
            /**
             * @var StringObject
             */
            private $stringObject;
            /**
             * @var DateTimeInterface
             */
            private $dateTimeRfc3339Normalizable;
            /**
             * @var object
             */
            private $stringable;

            /**
             * @param array<int, mixed> $privateArray
             */
            public function __construct(
                int $publicInt,
                int $publicIntManuallyNormalized,
                int $privateInt,
                int $protectedInt,
                ?int $privateNullableInt,
                string $privateString,
                bool $privateBool,
                array $privateArray,
                IntegerObject $integerObject,
                StringObject $stringObject,
                DateTimeInterface $dateTimeRfc3339Normalizable,
                $stringable
            )
            {
                $this->publicInt = $publicInt;
                $this->publicIntManuallyNormalized = $publicIntManuallyNormalized;
                $this->privateInt = $privateInt;
                $this->protectedInt = $protectedInt;
                $this->privateNullableInt = $privateNullableInt;
                $this->privateString = $privateString;
                $this->privateBool = $privateBool;
                $this->privateArray = $privateArray;
                $this->integerObject = $integerObject;
                $this->stringObject = $stringObject;
                $this->dateTimeRfc3339Normalizable = $dateTimeRfc3339Normalizable;
                $this->stringable = $stringable;
            }

            /**
             * @return array<string, mixed>
             */
            protected function getNormalized(): array
            {
                return $this->getAutoNormalized([
                    'publicIntManuallyNormalized' => $this->publicIntManuallyNormalized * 2,
                ]);
            }
        };
    }

    public function testNormalizableFail(): void
    {
        $this->expectException(LogicException::class);
        $this->createNormalizableWithWrongParameterType()
            ->normalize();
    }

    private function createNormalizableWithWrongParameterType(): NormalizableInterface
    {
        return new class (
            new DateTime()
        ) implements NormalizableInterface {
            use SimpleNormalizableTrait;

            /**
             * @var DateTimeInterface
             */
            private $dateTime;

            public function __construct(
                DateTimeInterface $dateTime
            )
            {
                $this->dateTime = $dateTime;
            }

            /**
             * @return array<string, mixed>
             */
            protected function getNormalized(): array
            {
                return $this->getAutoNormalized();
            }
        };
    }
}
