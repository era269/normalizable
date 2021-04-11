<?php

declare(strict_types=1);

namespace Era269\Normalizable\Abstraction;

use Throwable;

abstract class AbstractThrowableToNormalizableAdapter extends AbstractNormalizable
{
    final public function __construct(
        private Throwable $throwable
    )
    {
    }

    /**
     * @inheritDoc
     */
    final protected function getNormalized(): array
    {
        $throwable = $this->throwable;
        $previous = $throwable->getPrevious();
        $previousOrTrace = $previous instanceof Throwable
            ? ['previous' => (new static($previous))->normalize()]
            : ['trace' => $this->getTrace($throwable)];

        return [
                'message' => $throwable->getMessage(),
                'code' => $throwable->getCode(),
                'file' => $throwable->getFile(),
                'line' => $throwable->getLine(),
            ] + $previousOrTrace;
    }

    /**
     * @return array<string, mixed>
     */
    abstract protected function getTrace(Throwable $throwable): array;

    final protected function getObjectForNormalization(): Throwable
    {
        return $this->throwable;
    }
}
