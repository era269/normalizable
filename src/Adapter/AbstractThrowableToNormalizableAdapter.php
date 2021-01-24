<?php
declare(strict_types=1);


namespace Era269\Normalizable\Adapter;


use Era269\Normalizable\AbstractNormalizableObject;
use Throwable;

abstract class AbstractThrowableToNormalizableAdapter extends AbstractNormalizableObject
{
    private Throwable $throwable;

    public function __construct(Throwable $throwable)
    {
        $this->throwable = $throwable;
    }

    protected function getNormalized(): array
    {
        return $this->getNormalizedThrowable(
            $this->getNormalizableObject()
        );
    }

    protected function getNormalizableObject(): Throwable
    {
        return $this->throwable;
    }

    /**
     * @return  array<string, mixed>
     */
    public function getNormalizedThrowable(Throwable $throwable): array
    {
        $previous = $throwable->getPrevious();
        $previousOrTrace = ($previous instanceof Throwable)
            ? ['previous' => $this->getNormalizedThrowable($previous)]
            : ['trace' => $throwable->getTrace()];
        return [
            'message' => $throwable->getMessage(),
            'code' => $throwable->getCode(),
            'file' => $throwable->getFile(),
            'line' => $throwable->getLine(),
        ] + $previousOrTrace;
    }
}
