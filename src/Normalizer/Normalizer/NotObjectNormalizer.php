<?php

declare(strict_types=1);

namespace Era269\Normalizable\Normalizer\Normalizer;

use Era269\Normalizable\NormalizerInterface;

final class NotObjectNormalizer implements NormalizerInterface
{
    public function supports($value): bool
    {
        return !is_object($value);
    }

    public function normalize($value)
    {
        return $value;
    }
}
