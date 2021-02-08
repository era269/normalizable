<?php
declare(strict_types=1);


namespace Era269\Normalizable\Adapter;


use Era269\Normalizable\AbstractNormalizableObject;
use Throwable;

abstract class AbstractThrowableToNormalizableAdapter extends AbstractNormalizableObject
{
    private Throwable $throwable;

    final public function __construct(Throwable $throwable)
    {
        $this->throwable = $throwable;
    }

    final protected function getNormalized(): array
    {
        $throwable = $this->throwable;
        $previous = $throwable->getPrevious();
        $previousOrTrace = ($previous instanceof Throwable)
            ? ['previous' => (new static($previous))->normalize()]
            : ['trace' => $this->getTrace($throwable)];
        return [
                'message' => $throwable->getMessage(),
                'code' => $throwable->getCode(),
                'file' => $throwable->getFile(),
                'line' => $throwable->getLine(),
            ] + $previousOrTrace;
    }

    final protected function getObjectForNormalization(): Throwable
    {
        return $this->throwable;
    }

    /**
     * @return array<string, mixed>
     */
    abstract protected function getTrace(Throwable $throwable): array;
}
