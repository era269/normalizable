<?php

declare(strict_types=1);

namespace Era269\Normalizable\Tests\Object;

use Era269\Normalizable\IntegerInterface;
use Era269\Normalizable\Object\IntegerObject;
use PHPUnit\Framework\TestCase;

class IntegerObjectTest extends TestCase
{
    public function testEqualsToSelf(): void
    {
        $x = $this->createInteger(1);
        $y = $this->createInteger(1);
        $z = $this->createInteger(2);

        self::assertTrue($x->equals($y));
        self::assertFalse($x->equals($z));
    }

    private function createInteger(int $value): IntegerInterface
    {
        return new IntegerObject($value);
    }

}
