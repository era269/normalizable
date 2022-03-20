<?php

declare(strict_types=1);

namespace Era269\Normalizable\Tests\Normalizer;

use DateTime;
use Era269\Normalizable\Normalizer\ScalarableNormalizer;
use Era269\Normalizable\Normalizer\StringableNormalizer;
use Era269\Normalizable\Object\IntegerObject;
use Era269\Normalizable\Object\StringObject;
use Era269\Normalizable\ScalarableInterface;
use PHPUnit\Framework\TestCase;
use SplObjectStorage;

class ScalarableNormalizerTest extends TestCase
{
    /**
     * @var StringableNormalizer
     */
    private $normalizer;

    /**
     * @inheritDoc
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->normalizer = new ScalarableNormalizer();
    }

    /**
     * @param mixed $value
     *
     * @dataProvider supportsDataProvider
     */
    public function testSupports($value): void
    {
        self::assertTrue(
            $this->normalizer->supports($value)
        );
    }

    /**
     * @param mixed $value
     *
     * @dataProvider notSupportsDataProvider
     */
    public function testNotSupports($value): void
    {
        self::assertFalse(
            $this->normalizer->supports($value)
        );
    }

    /**
     * @param mixed $value
     * @param int|string $normalized
     *
     * @dataProvider normalizeDataProvider
     */
    public function testNormalize($value, $normalized): void
    {
        self::assertEquals(
            $normalized,
            $this->normalizer->normalize($value)
        );
    }

    /**
     * @return array<mixed, mixed>
     */
    public function supportsDataProvider(): array
    {
        $someInt = 1;
        $someString = '1';

        return [
            [new StringObject($someString)],
            [new IntegerObject($someInt)],
        ];
    }

    /**
     * @return array<mixed, mixed>
     */
    public function normalizeDataProvider(): array
    {
        $someString = '1';
        $someInt = 1;

        return [
            [
                'object' => new StringObject($someString),
                'normalized' => $someString,
            ],
            [
                'object' => new IntegerObject($someInt),
                'normalized' => $someInt,
            ],
            [
                'object' => new class implements ScalarableInterface {
                    public function toScalar()
                    {
                        return 'some_string';
                    }
                },
                'normalized' => 'some_string',
            ],
        ];
    }

    /**
     * @return array<mixed, mixed>
     */
    public function notSupportsDataProvider(): array
    {
        $someInt = 1;
        $someString = '1';

        return [
            [$someInt],
            [$someString],
            [true],
            [null],
            [[$someInt]],
            [new DateTime()],
            [new SplObjectStorage()],
            [new class {
                public function __toString()
                {
                    return '';
                }
            }],

        ];
    }
}
