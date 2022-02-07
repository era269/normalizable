<?php

declare(strict_types=1);

namespace Era269\Normalizable\Traits;

use Era269\Normalizable\Object\ShortClassName;

trait ShortClassNameTypeAwareTrait
{
    public function getType(): string
    {
        return (string) new ShortClassName($this);
    }
}
