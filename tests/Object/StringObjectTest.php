<?php

declare(strict_types=1);

namespace Era269\Normalizable\Tests\Object;

use Era269\Normalizable\Object\StringObject;
use Era269\Normalizable\StringInterface;
use PHPUnit\Framework\TestCase;

class StringObjectTest extends TestCase
{
    public function testEqualsToSelf(): void
    {
        $x = $this->createString('');
        $y = $this->createString('');
        $z = $this->createString('2');

        self::assertTrue($x->equals($y));
        self::assertFalse($x->equals($z));
    }

    private function createString(string $value): StringInterface
    {
        return new StringObject($value);
    }
}
