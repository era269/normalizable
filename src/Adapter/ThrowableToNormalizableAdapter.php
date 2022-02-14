<?php

declare(strict_types=1);

namespace Era269\Normalizable\Adapter;

use Era269\Normalizable\NormalizableInterface;
use Era269\Normalizable\NormalizationFacadeAwareInterface;
use Era269\Normalizable\Object\ShortClassName;
use Era269\Normalizable\Traits\NormalizableTrait;
use Era269\Normalizable\TypeAwareInterface;
use Throwable;

class ThrowableToNormalizableAdapter implements TypeAwareInterface, NormalizableInterface, NormalizationFacadeAwareInterface
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

    public function getType(): string
    {
        return (string) new ShortClassName($this->throwable);
    }
}
