<?php
declare(strict_types=1);

namespace Era269\Normalizable\Tests\Adapter;

use Era269\Normalizable\Adapter\ThrowableToNormalizableAdapter;
use Exception;
use PHPUnit\Framework\TestCase;
use Throwable;

class ThrowableToNormalizableAdapterTest extends TestCase
{
    private Exception $throwable;
    private ThrowableToNormalizableAdapter $adapter;

    public function testNormalize(): void
    {
        $normalized = $this->adapter->normalize();
        $this->assertNormalized(
            $this->throwable,
            $normalized,
            ['file', 'line', 'code', 'message', 'previous'],
            ['trace'],
        );
        $this->assertNormalized(
            $this->throwable->getPrevious(),
            $normalized['previous'],
            ['file', 'line', 'code', 'message', 'previous'],
            ['trace'],
        );
        $this->assertNormalized(
            $this->throwable->getPrevious()->getPrevious(),
            $normalized['previous']['previous'],
            ['file', 'line', 'code', 'message', 'trace'],
            ['previous'],
        );
    }

    /**
     * @param array<string, mixed> $normalized
     * @param string[] $hasKeys
     * @param string[] $notHasKeys
     */
    private function assertNormalized(?Throwable $throwable, array $normalized, array $hasKeys, array $notHasKeys): void
    {
        self::assertInstanceOf(Throwable::class, $throwable);
        self::assertEquals(
            get_class($throwable),
            $normalized['@type']
        );
        foreach ($hasKeys as $hasKey) {
            self::assertArrayHasKey($hasKey, $normalized);
        }
        foreach ($notHasKeys as $notHasKey) {
            self::assertArrayNotHasKey($notHasKey, $normalized);
        }
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->throwable = new Exception(
            'Exception 1',
            1,
            new Exception(
                'Exception 2',
                2,
                new Exception(
                    'Exception 3',
                    3
                )
            )
        );
        $this->adapter = new ThrowableToNormalizableAdapter($this->throwable);
    }
}
