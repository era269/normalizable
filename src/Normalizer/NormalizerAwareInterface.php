<?php

declare(strict_types=1);

namespace Era269\Normalizable\Normalizer;

use Era269\Normalizable\NormalizerInterface;

interface NormalizerAwareInterface
{
    public function setNormalizer(NormalizerInterface $normalizer): void;
}
