<?php

declare(strict_types=1);

namespace Era269\Normalizable\Normalizer;

use Era269\Normalizable\NormalizableInterface;
use Era269\Normalizable\NormalizationFacadeAwareInterface;
use Era269\Normalizable\NormalizerInterface;
use Era269\Normalizable\Traits\NormalizationFacadeAwareTrait;

class NormalizableNormalizer implements NormalizerInterface, NormalizationFacadeAwareInterface
{
    use NormalizationFacadeAwareTrait;

    public function supports($value): bool
    {
        return $value instanceof NormalizableInterface;
    }

    public function normalize($value)
    {
        if ($value instanceof NormalizationFacadeAwareInterface) {
            $value->setNormalizationFacade($this->getNormalizationFacade());
        }

        /** @var NormalizableInterface $value */
        return $value->normalize();
    }
}
