<?php

declare(strict_types=1);

namespace Era269\Normalizable;

interface NormalizerAwareInterface
{
    public function setNormalizer(NormalizerInterface $normalizer): void;
}
