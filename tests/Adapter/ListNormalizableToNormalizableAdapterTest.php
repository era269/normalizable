<?php

declare(strict_types=1);

namespace Era269\Normalizable\Tests\Adapter;

use Era269\Normalizable\Adapter\ListNormalizableToNormalizableAdapter;
use Era269\Normalizable\NormalizableInterface;
use Era269\Normalizable\Normalizer\Normalizer\DefaultNormalizationFacade;
use Era269\Normalizable\Object\Normalizable;
use PHPUnit\Framework\TestCase;

class ListNormalizableToNormalizableAdapterTest extends TestCase
{
    private const NORMALIZED_OBJECT = [
        '@type' => 'Normalizable',
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
        self::assertEquals(
            $expected,
            (new DefaultNormalizationFacade())->normalize($adapter)
        );
    }

    /**
     * @return array<int, array[]>
     */
    public function dataProvider(): array
    {
        $object = new Normalizable();

        return [
            [[$object]],
            [[$object, clone $object, clone $object]],
            [[]],
        ];
    }
}
