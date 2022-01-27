<?php

declare(strict_types=1);

namespace Era269\Normalizable\Normalizer\Traits;

use Era269\Normalizable\NormalizerInterface;

trait NormalizerAwareTrait
{
    /**
     * @var NormalizerInterface
     */
    private $normalizer;

    public function setNormalizer(NormalizerInterface $normalizer): void
    {
        $this->normalizer = $normalizer;
    }
}
