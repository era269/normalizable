<?php

declare(strict_types=1);

namespace Era269\Normalizable\Abstraction;

use DateTime;
use Era269\Normalizable\DenormalizableInterface;
use Era269\Normalizable\NormalizableInterface;
use Era269\Normalizable\Traits\AbstractDateTimeNormalizableTrait;

abstract class AbstractDateTimeNormalizable extends DateTime implements NormalizableInterface, DenormalizableInterface
{
    use AbstractDateTimeNormalizableTrait;
}
