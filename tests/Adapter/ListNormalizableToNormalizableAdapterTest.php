<?php

declare(strict_types=1);

namespace Era269\Normalizable\Tests\Adapter;

use Era269\Normalizable\Adapter\ListNormalizableToNormalizableAdapter;
use Era269\Normalizable\NormalizableInterface;
use PHPUnit\Framework\TestCase;

class ListNormalizableToNormalizableAdapterTest extends TestCase
{
    private const NORMALIZED_OBJECT = [
        '@type' => 'object/class',
        'content' => [],
    ];

    /**
     * @dataProvider dataProvider
     *
     * @param NormalizableInterface[] $objects
     */
    public function testNormalize(array $objects): void
    {
        $adapter = new ListNormalizableToNormalizableAdapter(...$objects);
        $expected = [];
        foreach ($objects as $object) {
            $expected[] = self::NORMALIZED_OBJECT;
        }
        self::assertSame(
            $expected,
            $adapter->normalize()
        );
    }

    /**
     * @return array<int, array[]>
     */
    public function dataProvider(): array
    {
        $object = $this->createMock(NormalizableInterface::class);
        $object
            ->method('normalize')
            ->willReturn(self::NORMALIZED_OBJECT);

        return [
            [[$object]],
            [[$object, clone $object, clone $object]],
            [[]],
        ];
    }
}
