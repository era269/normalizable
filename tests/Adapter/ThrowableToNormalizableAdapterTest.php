<?php
declare(strict_types=1);

namespace Era269\Normalizable\Tests\Adapter;

use Era269\Normalizable\Adapter\ThrowableToNormalizableAdapter;
use Era269\Normalizable\Normalizer\Normalizer\DefaultNormalizationFacade;
use Exception;
use PHPUnit\Framework\TestCase;
use Throwable;

class ThrowableToNormalizableAdapterTest extends TestCase
{
    /**
     * @var Exception
     */
    private $throwable;
    /**
     * @var ThrowableToNormalizableAdapter
     */
    private $adaptedThrowable;

    public function testNormalize(): void
    {
        $normalized = (new DefaultNormalizationFacade())->normalize($this->adaptedThrowable);
        $this->assertNormalized(
            $this->throwable,
            $normalized,
            ['file', 'line', 'code', 'message', 'previous'],
            ['trace']
        );
        $this->assertNormalized(
            $this->throwable->getPrevious(),
            $normalized['previous'],
            ['file', 'line', 'code', 'message', 'previous'],
            ['trace']
        );
        $this->assertNormalized(
            !is_null($this->throwable->getPrevious()) ? $this->throwable->getPrevious()->getPrevious() : null,
            $normalized['previous']['previous'],
            ['file', 'line', 'code', 'message', 'trace'],
            ['previous']
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
            is_object($throwable) ? get_class($throwable) : '',
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
        $this->adaptedThrowable = new ThrowableToNormalizableAdapter($this->throwable);
    }
}
