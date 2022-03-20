<?php

declare(strict_types=1);

namespace Era269\Normalizable\Tests\Normalizer;

use DateTime;
use Era269\Normalizable\Normalizer\StringableNormalizer;
use Era269\Normalizable\Object\IntegerObject;
use Era269\Normalizable\Object\StringObject;
use PHPUnit\Framework\TestCase;
use SplObjectStorage;

class StringableNormalizerTest extends TestCase
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

        $this->normalizer = new StringableNormalizer();
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
     *
     * @dataProvider normalizeDataProvider
     */
    public function testNormalize($value, string $normalized): void
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
        $someString = '1';

        return [
            [new StringObject($someString)],
            [new class {
                public function __toString()
                {
                    return '';
                }
            }],
        ];
    }

    /**
     * @return array<mixed, mixed>
     */
    public function normalizeDataProvider(): array
    {
        $someString = '1';

        return [
            [
                'object' => new StringObject($someString),
                'normalized' => $someString,
            ],
            [
                'object' => new class {
                    public function __toString()
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
            [new IntegerObject($someInt)],
        ];
    }
}
