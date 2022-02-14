<?php

declare(strict_types=1);

namespace Era269\Normalizable\Traits;

use Era269\Normalizable\NormalizableInterface;
use Era269\Normalizable\NormalizationFacadeAwareInterface;
use Era269\Normalizable\Object\ShortClassName;

trait NormalizableTrait
{
    use NormalizationFacadeAwareTrait;

    /**
     * @return array<int|string, null|int|string|bool|array<int|string, mixed>>
     */
    public function normalize(): array
    {
        return $this->getAutoNormalized();
    }

    /**
     * @param array<int|string, mixed> $objectVars
     *
     * @return array<int|string, mixed>
     */
    private function getAutoNormalized(array $objectVars = []): array
    {
        $normalized = [];
        $this->addTypeIfNeeded($normalized);

        foreach (array_merge($this->getObjectVars(), $objectVars) as $key => $var) {
            $normalizedVar = $this->getNormalizationFacade()->normalize($var);
            $decoratedKey = $this->getNormalizationFacade()->decorate($key);
            $normalized[$decoratedKey] = $normalizedVar;
        }

        return array_merge(
            $this->getParentNormalized(),
            $normalized
        );
    }

    /**
     * @param array<int|string, null|int|string|bool|array<int|string, mixed>> $normalized
     *
     * @deprecated was added for back compatibility
     */
    private function addTypeIfNeeded(array &$normalized): void
    {
        if (!isset($this->_normalizationFacade)) {
            $normalized['@type'] = (string) (new ShortClassName($this));
        }
    }

    /**
     * @return array<int|string, mixed>
     */
    private function getObjectVars(): array
    {
        $objectVars = get_object_vars($this);
        unset($objectVars['_normalizationFacade']);

        return $objectVars;
    }

    /**
     * @return array<int|string, null|int|string|bool|array<int|string, mixed>>
     */
    private function getParentNormalized(): array
    {
        $parentClass = (string) get_parent_class(self::class);
        // @phpstan-ignore-next-line
        $isParentNormalizable = is_subclass_of($parentClass, NormalizableInterface::class);
        // @phpstan-ignore-next-line
        $isParentNormalizeCallable = is_callable([$parentClass, 'normalize']);

        // @phpstan-ignore-next-line
        if (!($isParentNormalizable && $isParentNormalizeCallable)) {
            return [];
        }
        // @phpstan-ignore-next-line
        if (is_subclass_of($parentClass, NormalizationFacadeAwareInterface::class)) {
            // @phpstan-ignore-next-line
            parent::setNormalizationFacade(
                $this->getNormalizationFacade()
            );
        }

        // @phpstan-ignore-next-line
        return parent::normalize();
    }
}
