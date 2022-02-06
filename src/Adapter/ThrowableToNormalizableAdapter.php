<?php

declare(strict_types=1);

namespace Era269\Normalizable\Adapter;

use Era269\Normalizable\NormalizableInterface;
use Era269\Normalizable\NormalizableWrapperInterface;
use Era269\Normalizable\Normalizer\KeyDecoratorAwareInterface;
use Era269\Normalizable\Normalizer\NormalizerAwareInterface;
use Era269\Normalizable\Traits\NormalizableTrait;
use Throwable;

class ThrowableToNormalizableAdapter implements NormalizableWrapperInterface, NormalizableInterface, NormalizerAwareInterface, KeyDecoratorAwareInterface
{
    use NormalizableTrait;

    /**
     * @var Throwable
     */
    private $throwable;

    final public function __construct(
        Throwable $throwable
    )
    {
        $this->throwable = $throwable;
    }

    /**
     * @return array<int|string, mixed>
     */
    private function getObjectVars(): array
    {
        $throwable = $this->throwable;
        $previous = $throwable->getPrevious();
        $previousOrTrace = $previous instanceof Throwable
            ? [
                'previous' => $previous instanceof NormalizableInterface
                    ? $previous
                    : new static($previous),
            ]
            : [
                'trace' => $this->getTrace($throwable),
            ];

        return [
                'message' => $throwable->getMessage(),
                'code' => $throwable->getCode(),
                'file' => $throwable->getFile(),
                'line' => $throwable->getLine(),
            ] + $previousOrTrace;
    }

    /**
     * @return array<int|string, mixed>
     */
    protected function getTrace(Throwable $throwable): array
    {
        return $throwable->getTrace();
    }

    public function getWrappedObject()
    {
        return $this->throwable;
    }
}
