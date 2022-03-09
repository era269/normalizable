<?php

declare(strict_types=1);

namespace Era269\Normalizable\Tests\Object;

use DateTime;
use Era269\Normalizable\Object\IntegerObject;
use Era269\Normalizable\Object\ShortClassName;
use Exception;
use PHPUnit\Framework\TestCase;

class ShortClassNameTest extends TestCase
{
    /**
     * @dataProvider properDataProvider
     *
     * @param object $object
     */
    public function testSuccessCases($object, string $expectedString): void
    {
        self::assertEquals(
            $expectedString,
            (string) new ShortClassName($object)
        );
    }

    /**
     * @return array<mixed, mixed>
     */
    public function properDataProvider(): array
    {
        return [
            [
                'object' => new DateTime(),
                'expectedString' => 'DateTime',
            ],
            [
                'object' => new Exception(),
                'expectedString' => 'Exception',
            ],
            [
                'object' => new IntegerObject(1),
                'expectedString' => 'IntegerObject',
            ],
            [
                'object' => (object) [],
                'expectedString' => 'stdClass',
            ],
        ];
    }
}
