<?php

declare(strict_types=1);

namespace Era269\Normalizable\Object;

use Era269\Normalizable\NormalizableInterface;
use Era269\Normalizable\NormalizationFacadeAwareInterface;
use Era269\Normalizable\StringInterface;
use Era269\Normalizable\Traits\NormalizableTrait;
use Era269\Normalizable\Traits\StringObjectTrait;

class StringNormalizable implements NormalizableInterface, StringInterface, NormalizationFacadeAwareInterface
{
    use StringObjectTrait;
    use NormalizableTrait;
}
