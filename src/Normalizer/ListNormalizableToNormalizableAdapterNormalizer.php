<?php

declare(strict_types=1);

namespace Era269\Normalizable\Normalizer;

use Era269\Normalizable\Adapter\ListNormalizableToNormalizableAdapter;

final class ListNormalizableToNormalizableAdapterNormalizer extends NormalizableNormalizer
{
    public function supports($value): bool
    {
        return $value instanceof ListNormalizableToNormalizableAdapter;
    }
}
