<?php

declare(strict_types=1);

namespace Era269\Normalizable\Traits;

use Era269\Normalizable\NormalizationFacadeInterface;
use Era269\Normalizable\Normalizer\DefaultNormalizationFacade;

trait NormalizationFacadeAwareTrait
{
    /**
     * @var ?NormalizationFacadeInterface
     */
    private $_normalizationFacade;

    public function setNormalizationFacade(NormalizationFacadeInterface $normalizationFacade): void
    {
        $this->_normalizationFacade = $normalizationFacade;
    }

    private function getNormalizationFacade(): NormalizationFacadeInterface
    {
        if (!isset($this->_normalizationFacade)) {
            $this->_normalizationFacade = new DefaultNormalizationFacade();
        }

        return $this->_normalizationFacade;
    }
}
