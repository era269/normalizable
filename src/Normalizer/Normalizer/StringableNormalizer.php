<?php

declare(strict_types=1);

namespace Era269\Normalizable\Normalizer\Normalizer;

use Era269\Normalizable\NormalizerInterface;

final class StringableNormalizer implements NormalizerInterface
{
    public function supports($value): bool
    {
        return is_object($value)
            && method_exists($value, '__toString');
    }

    /**
     * @inheritDoc
     */
    public function normalize($value)
    {
        /** @var string $value */
        return (string) $value;
    }
}
