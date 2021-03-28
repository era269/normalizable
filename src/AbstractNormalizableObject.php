<?php

declare(strict_types=1);

namespace Era269\Normalizable;

use Era269\Normalizable\Traits\AbstractNormalizableTrait;

abstract class AbstractNormalizableObject implements NormalizableInterface
{
    use AbstractNormalizableTrait;
}
