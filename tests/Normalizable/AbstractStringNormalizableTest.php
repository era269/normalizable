<?php

declare(strict_types=1);

namespace Era269\Normalizable\Tests\Normalizable;

use Era269\Normalizable\Normalizable\AbstractStringNormalizable;
use Era269\Normalizable\StringNormalizableInterface;
use PHPUnit\Framework\TestCase;

class AbstractStringNormalizableTest extends TestCase
{
    private const VALUE            = 'value';
    private const VALUE_FIELD_NAME = 'value_field_name';
    private const MOCK_CLASS_NAME  = 'StringNormalizableMockClassName';

    private StringNormalizableInterface $stringNormalizable;

    public function testToString(): void
    {
        self::assertEquals(
            self::VALUE,
            (string)$this->stringNormalizable
        );
    }

    public function testEquals(): void
    {
        self::assertTrue(
            $this->stringNormalizable->equals(
                $this->getMockForAbstractStringNormalizable(self::VALUE)
            )
        );
    }

    protected function getMockForAbstractStringNormalizable(string $value): StringNormalizableInterface
    {
        $mock = $this->getMockForAbstractClass(
            AbstractStringNormalizable::class,
            [$value],
            self::MOCK_CLASS_NAME,
        );
        $mock
            ->method('getValueFieldName')
            ->willReturn(self::VALUE_FIELD_NAME);
        return $mock;
    }

    public function testNotEquals(): void
    {
        self::assertFalse(
            $this->stringNormalizable->equals(
                $this->getMockForAbstractStringNormalizable('not_equal_value')
            )
        );
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->stringNormalizable = $this->getMockForAbstractStringNormalizable(self::VALUE);
    }
}
