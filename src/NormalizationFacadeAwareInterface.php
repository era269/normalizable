<?php

declare(strict_types=1);

namespace Era269\Normalizable;

interface NormalizationFacadeAwareInterface
{
    public function setNormalizationFacade(NormalizationFacadeInterface $normalizationFacade): void;
}
