<?php

declare(strict_types=1);

namespace Era269\Normalizable\Tests\Normalizer;

use DateTime;
use Era269\Normalizable\Normalizer\FailNormalizer;
use LogicException;
use PHPUnit\Framework\TestCase;

class FailNormalizerTest extends TestCase
{
    /**
     * @var FailNormalizer
     */
    private $normalizer;

    /**
     * @inheritDoc
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->normalizer = new FailNormalizer();
    }

    /**
     * @param mixed $value
     *
     * @dataProvider dataProvider
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
     * @dataProvider dataProvider
     */
    public function testNormalize($value): void
    {
        self::expectException(LogicException::class);
        $this->normalizer->normalize($value);
    }

    /**
     * @return array<mixed, mixed>
     */
    public function dataProvider(): array
    {
        return [
            [1],
            ['1'],
            [true],
            [null],
            [[1]],
            [new DateTime()],
        ];
    }
}
