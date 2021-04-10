<?php

declare(strict_types=1);

namespace Era269\Normalizable\Abstraction;

use Era269\Normalizable\NormalizableInterface;
use Era269\Normalizable\Traits\AbstractNormalizableTrait;

abstract class AbstractNormalizable implements NormalizableInterface
{
    use AbstractNormalizableTrait;
}
