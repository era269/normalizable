<?php

declare(strict_types=1);

namespace Era269\Normalizable\Tests\Normalizer\KeyDecorator;

use Era269\Normalizable\KeyDecorator\CamelCaseToSnackCaseKeyDecorator;
use PHPUnit\Framework\TestCase;

class CamelCaseToSnackCaseKeyDecoratorTest extends TestCase
{
    /**
     * @dataProvider dataProvider
     */
    public function test(string $input, string $expectedOutput): void
    {
        self::assertEquals(
            $expectedOutput,
            (new CamelCaseToSnackCaseKeyDecorator())->decorate($input)
        );
    }

    /**
     * @return array<mixed>
     */
    public function dataProvider(): array
    {
        return [
            [
                'input' => 'CamelCase',
                'expected-output' => 'camel_case',
            ],
            [
                'input' => 'camelCase',
                'expected-output' => 'camel_case',
            ],
            [
                'input' => 'XML',
                'expected-output' => 'x_m_l',
            ],
            [
                'input' => 'xml',
                'expected-output' => 'xml',
            ],
            [
                'input' => 'camel_case',
                'expected-output' => 'camel_case',
            ],
        ];
    }
}
