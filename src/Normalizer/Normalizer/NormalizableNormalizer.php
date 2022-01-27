<?php

declare(strict_types=1);

namespace Era269\Normalizable\Normalizer\Normalizer;

use Era269\Normalizable\NormalizableInterface;
use Era269\Normalizable\Normalizer\KeyDecoratorAwareInterface;
use Era269\Normalizable\Normalizer\NormalizerAwareInterface;
use Era269\Normalizable\Normalizer\Traits\KeyDecoratorAwareTrait;
use Era269\Normalizable\Normalizer\Traits\NormalizerAwareTrait;
use Era269\Normalizable\NormalizerInterface;

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
