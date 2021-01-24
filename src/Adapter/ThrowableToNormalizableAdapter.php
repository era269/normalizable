<?php
declare(strict_types=1);


namespace Era269\Normalizable\Adapter;


use Throwable;

final class ThrowableToNormalizableAdapter extends AbstractThrowableToNormalizableAdapter
{
    /**
     * @inheritDoc
     */
    protected function getTrace(Throwable $throwable): string|array
    {
        return $throwable->getTrace();
    }
}
