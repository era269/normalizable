<?php

declare(strict_types=1);

namespace Era269\Normalizable\Adapter;

use Era269\Normalizable\NormalizableInterface;
use Era269\Normalizable\Normalizer\KeyDecoratorAwareInterface;
use Era269\Normalizable\Normalizer\NormalizerAwareInterface;
use Era269\Normalizable\Traits\NormalizableTrait;

class ListNormalizableToNormalizableAdapter implements NormalizableInterface, NormalizerAwareInterface, KeyDecoratorAwareInterface
{
    use NormalizableTrait;

    /**
     * @var NormalizableInterface[]
     */
    private $objects;

    public function __construct(NormalizableInterface ...$objects)
    {
        $this->objects = $objects;
    }

    /**
     * @return NormalizableInterface[]
     */
    private function getObjectVars(): array
    {
        return $this->objects;
    }
}
