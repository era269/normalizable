<?php

declare(strict_types=1);

namespace Era269\Normalizable;

interface NormalizableWrapperInterface
{
    /**
     * @return object
     */
    public function getWrappedObject();
}
