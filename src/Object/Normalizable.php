<?php

declare(strict_types=1);

namespace Era269\Normalizable\Object;

use Era269\Normalizable\NormalizableInterface;
use Era269\Normalizable\NormalizationFacadeAwareInterface;
use Era269\Normalizable\Traits\NormalizableTrait;

class Normalizable implements NormalizableInterface, NormalizationFacadeAwareInterface
{
    use NormalizableTrait;
}
