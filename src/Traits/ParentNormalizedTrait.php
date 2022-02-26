<?php

declare(strict_types=1);

namespace Era269\Normalizable\Traits;

use Era269\Normalizable\NormalizableInterface;
use Era269\Normalizable\NormalizationFacadeAwareInterface;

trait ParentNormalizedTrait
{
    /**
     * @return array<int|string, null|int|string|bool|array<int|string, mixed>>
     */
    private function getParentNormalized(): array
    {
        $parentClass = (string) get_parent_class(self::class);
        $isParentNormalizable = is_subclass_of($parentClass, NormalizableInterface::class); //@phpstan-ignore-line
        $isParentNormalizeCallable = is_callable([$parentClass, 'normalize']); //@phpstan-ignore-line

        if (!($isParentNormalizable && $isParentNormalizeCallable)) { //@phpstan-ignore-line
            return [];
        }
        // @codeCoverageIgnoreStart
        //@phpstan-ignore-next-line
        if (is_subclass_of($parentClass, NormalizationFacadeAwareInterface::class)) {
            parent::setNormalizationFacade( //@phpstan-ignore-line
                $this->getNormalizationFacade()
            );
        }

        return parent::normalize(); //@phpstan-ignore-line
        // @codeCoverageIgnoreEnd
    }
}
