<?php

declare(strict_types=1);

namespace Era269\Normalizable\Object;

use Era269\Normalizable\StringNormalizableInterface;
use Era269\Normalizable\Traits\NormalizableTrait;
use Era269\Normalizable\Traits\StringObjectTrait;

class StringNormalizable implements StringNormalizableInterface
{
    use StringObjectTrait;
    use NormalizableTrait;
}
