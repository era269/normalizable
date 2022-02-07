<?php
declare(strict_types=1);

namespace Era269\Normalizable\Tests\Adapter;

use Era269\Normalizable\Adapter\ThrowableToNormalizableAdapter;
use Era269\Normalizable\NormalizableInterface;
use Era269\Normalizable\Normalizer\DefaultNormalizationFacade;
use Era269\Normalizable\Traits\NormalizableTrait;
use Exception;
use PHPUnit\Framework\TestCase;
use Throwable;

class ThrowableToNormalizableAdapterTest extends TestCase
{
    /**
     * @param string[] $hasKeys
     * @param string[] $notHasKeys
     *
     * @dataProvider dataProvider
     */
    public function testNormalize(Throwable $throwable, array $hasKeys, array $notHasKeys): void
    {
        $normalized = (new DefaultNormalizationFacade())->normalize(
            new ThrowableToNormalizableAdapter($throwable)
        );
        if (!is_array($normalized)) {
            self::fail('Throwable has to be normalized into an array');
        }
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

    /**
     * @return array<mixed>
     */
    public function dataProvider(): array
    {
        $normalizableExceptionWithoutPrevious = new class extends Exception implements NormalizableInterface {
            use NormalizableTrait;
        };
        $exceptionWithoutPrevious = new Exception();
        $exceptionWithPreviousNormalizable = new Exception('', 0, $normalizableExceptionWithoutPrevious);
        $exceptionWithManyPrevious = new Exception(
            '',
            0,
            new Exception('', 0, $normalizableExceptionWithoutPrevious)
        );

        return [
            [
                'exception' => $normalizableExceptionWithoutPrevious,
                'keysPresent' => ['file', 'line', 'code', 'message', 'trace'],
                'keysNotPresent' => ['previous'],
            ],
            [
                'exception' => $exceptionWithoutPrevious,
                'keysPresent' => ['file', 'line', 'code', 'message', 'trace'],
                'keysNotPresent' => ['previous'],
            ],
            [
                'exception' => $exceptionWithPreviousNormalizable,
                'keysPresent' => ['file', 'line', 'code', 'message', 'previous'],
                'keysNotPresent' => ['trace'],
            ],
        ];
    }
}
