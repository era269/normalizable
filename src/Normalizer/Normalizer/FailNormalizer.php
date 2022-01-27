<?php

declare(strict_types=1);

namespace Era269\Normalizable\Normalizer\Normalizer;

use Era269\Normalizable\NormalizerInterface;
use LogicException;

final class FailNormalizer implements NormalizerInterface
{
    public function supports($value): bool
    {
        return true;
    }

    public function normalize($value)
    {
        throw new LogicException(sprintf(
            'No Normalizers found'
        ));
    }
}
