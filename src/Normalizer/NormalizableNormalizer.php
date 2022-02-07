<?php

declare(strict_types=1);

namespace Era269\Normalizable\Normalizer;

use Era269\Normalizable\KeyDecoratorAwareInterface;
use Era269\Normalizable\NormalizableInterface;
use Era269\Normalizable\NormalizerAwareInterface;
use Era269\Normalizable\NormalizerInterface;
use Era269\Normalizable\Traits\KeyDecoratorAwareTrait;
use Era269\Normalizable\Traits\NormalizerAwareTrait;

class NormalizableNormalizer implements NormalizerInterface, NormalizerAwareInterface, KeyDecoratorAwareInterface
{
    use NormalizerAwareTrait;
    use KeyDecoratorAwareTrait;

    public function supports($value): bool
    {
        return $value instanceof NormalizableInterface;
    }

    public function normalize($value)
    {
        if ($value instanceof NormalizerAwareInterface) {
            $value->setNormalizer($this->normalizer);
        }
        if ($value instanceof KeyDecoratorAwareInterface) {
            $value->setKeyDecorator($this->keyDecorator);
        }

        /** @var NormalizableInterface $value */
        return $value->normalize();
    }
}
