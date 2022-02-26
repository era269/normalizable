<?php

declare(strict_types=1);

namespace Era269\Normalizable\Normalizer;

use Era269\Normalizable\NormalizerInterface;

final class ArrayNormalizer implements NormalizerInterface
{
    public function supports($value): bool
    {
        return is_array($value);
    }

    /**
     * @inheritDoc
     */
    public function normalize($value)
    {
        /** @var array<int|string, mixed> $value */
        return $value;
    }
}
