<?php

declare(strict_types=1);

namespace Era269\Normalizable\Tests\Traits;

use DateTime;
use DateTimeInterface;
use Era269\Normalizable\KeyDecoratorInterface;
use Era269\Normalizable\NormalizableInterface;
use Era269\Normalizable\NormalizationFacadeAwareInterface;
use Era269\Normalizable\Normalizer\DefaultNormalizationFacade;
use Era269\Normalizable\Normalizer\FailNormalizer;
use Era269\Normalizable\Normalizer\ListNormalizableToNormalizableAdapterNormalizer;
use Era269\Normalizable\Normalizer\NormalizableNormalizer;
use Era269\Normalizable\Normalizer\NormalizationFacade;
use Era269\Normalizable\Normalizer\ScalarableNormalizer;
use Era269\Normalizable\Normalizer\ScalarNormalizer;
use Era269\Normalizable\Normalizer\StringableNormalizer;
use Era269\Normalizable\Normalizer\WithTypeNormalizableNormalizerDecorator;
use Era269\Normalizable\Object\DateTimeRfc3339Normalizable;
use Era269\Normalizable\Object\IntegerObject;
use Era269\Normalizable\Object\ShortClassName;
use Era269\Normalizable\Object\StringNormalizable;
use Era269\Normalizable\Object\StringObject;
use Era269\Normalizable\Traits\NormalizableTrait;
use Exception;
use LogicException;
use PHPUnit\Framework\TestCase;
use ReflectionObject;
use SplObjectStorage;

/**
 * @covers \Era269\Normalizable\Normalizer\DefaultNormalizationFacade
 */
class NormalizableTraitTest extends TestCase
{
    public function testNormalize(): void
    {
        $dateTime = new DateTimeRfc3339Normalizable();
        $stringable = new Exception('message', 269);
        $normalizable = $this->createAutoNormalizable($dateTime, $stringable);
        self::assertEquals(
            $this->getExpectedNormalized($normalizable, $dateTime, $stringable, 1),
            (new DefaultNormalizationFacade())->normalize($normalizable)
        );
    }

    public function testDeprecatedNormalize(): void
    {
        $dateTime = new DateTimeRfc3339Normalizable();
        $stringable = new Exception('message', 269);
        $normalizable = $this->createAutoNormalizable($dateTime, $stringable);
        self::assertEquals(
            $this->getExpectedNormalized($normalizable, $dateTime, $stringable, 1),
            $normalizable->normalize()
        );
    }

    public function testNormalizeFail(): void
    {
        self::expectException(LogicException::class);
        $object = new SplObjectStorage();
        (new DefaultNormalizationFacade())->normalize($object);
    }

    public function testDeprecatedNormalizeFail(): void
    {
        self::expectException(LogicException::class);
        $object = new class implements NormalizableInterface {
            use NormalizableTrait;

            /**
             * @var DateTime
             */
            private $notNormalizableObject;

            public function __construct()
            {
                $this->notNormalizableObject = new DateTime();
            }
        };
        $object->normalize();
    }

    public function testInheritanceDeprecated(): void
    {
        $class = new class ('a', 'b') extends StringNormalizable {
            use NormalizableTrait;

            /**
             * @var string
             */
            private $childValue;

            public function __construct(string $value, string $childParam)
            {
                parent::__construct($value);
                $this->childValue = $childParam;
            }
        };

        $expected = [
            '@type' => (string) new ShortClassName($class),
            'value' => 'a',
            'childValue' => 'b',
        ];
        self::assertEquals(
            $expected,
            $class->normalize()
        );

        $normalizationFacade = new NormalizationFacade(
            new class implements KeyDecoratorInterface {
                public function decorate($value)
                {
                    return strtoupper((string) $value);
                }
            },
            [
                new ScalarNormalizer(),
                new ListNormalizableToNormalizableAdapterNormalizer(),
                new WithTypeNormalizableNormalizerDecorator(
                    new NormalizableNormalizer()
                ),
                new ScalarableNormalizer(),
                new StringableNormalizer(),
                new FailNormalizer(),
            ]
        );

        self::assertEquals(
            [
                '@TYPE' => (string) new ShortClassName($class),
                'VALUE' => 'a',
                'CHILDVALUE' => 'b',
            ],
            $normalizationFacade->normalize($class)
        );
    }

    public function testInheritance(): void
    {
        $class = new class ('a', 'b') extends StringNormalizable {
            use NormalizableTrait;

            /**
             * @var string
             */
            private $childValue;

            public function __construct(string $value, string $childParam)
            {
                parent::__construct($value);
                $this->childValue = $childParam;
            }
        };

        $expected = [
            '@TYPE' => (string) new ShortClassName($class),
            'VALUE' => 'a',
            'CHILDVALUE' => 'b',
        ];

        $normalizationFacade = new NormalizationFacade(
            new class implements KeyDecoratorInterface {
                public function decorate($value)
                {
                    return strtoupper((string) $value);
                }
            },
            [
                new ScalarNormalizer(),
                new ListNormalizableToNormalizableAdapterNormalizer(),
                new WithTypeNormalizableNormalizerDecorator(
                    new NormalizableNormalizer()
                ),
                new ScalarableNormalizer(),
                new StringableNormalizer(),
                new FailNormalizer(),
            ]
        );
        $normalizationFacade->normalize($class);
        self::assertEquals(
            $expected,
            $normalizationFacade->normalize($class)
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
        ) implements NormalizableInterface, NormalizationFacadeAwareInterface {
            use NormalizableTrait;

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
                int               $publicInt,
                int               $publicIntManuallyNormalized,
                int               $privateInt,
                int               $protectedInt,
                ?int              $privateNullableInt,
                string            $privateString,
                bool              $privateBool,
                array             $privateArray,
                IntegerObject     $integerObject,
                StringObject      $stringObject,
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
             * @inheritDoc
             */
            public function normalize(): array
            {
                return $this->getAutoNormalized([
                    'publicIntManuallyNormalized' => 1 + $this->publicIntManuallyNormalized,
                ]);
            }
        };
    }

    /**
     * @param object $stringable
     *
     * @return array<string, mixed>
     */
    private function getExpectedNormalized(
        NormalizableInterface       $normalizable,
        DateTimeRfc3339Normalizable $dateTime,
                                    $stringable,
        int                         $publicIntManuallyNormalized
    ): array
    {
        return [
            '@type' => (new ReflectionObject($normalizable))->getShortName(),
            'publicInt' => 1,
            'publicIntManuallyNormalized' => 1 + $publicIntManuallyNormalized,
            'privateInt' => 2,
            'protectedInt' => 3,
            'privateNullableInt' => null,
            'privateString' => '2',
            'privateBool' => false,
            'privateArray' => [1, '1', false, null],
            'integerObject' => 5,
            'stringObject' => '10',
            'dateTimeRfc3339Normalizable' => [
                '@type' => (new ReflectionObject($dateTime))->getShortName(),
                'dateTime' => $dateTime->format(DATE_RFC3339),
            ],
            'stringable' => (string) $stringable,
        ];
    }
}
