<?php

declare(strict_types=1);

namespace Era269\Normalizable\Traits;

use Era269\Normalizable\NormalizableInterface;
use Era269\Normalizable\Object\ShortClassName;
use Throwable;

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
        $this
            ->addTypeIfNeeded($normalized)
            ->addNormalizedParentIfPossible($normalized);

        foreach (array_merge($this->getObjectVars(), $objectVars) as $key => $var) {
            $normalizedVar = $this->getNormalizationFacade()->normalize($var);
            $decoratedKey = $this->getNormalizationFacade()->decorate($key);
            $normalized[$decoratedKey] = $normalizedVar;
        }

        return $normalized;
    }

    /**
     * @param array<int|string, null|int|string|bool|array<int|string, mixed>> $normalized
     */
    private function addNormalizedParentIfPossible(array &$normalized): self
    {
        $parentClass = (string) get_parent_class($this);

        $isParentNormalizable = is_subclass_of($parentClass, NormalizableInterface::class);
        $isParentNormalizeCallable = is_callable([$parentClass, 'normalize']);
        if (!($isParentNormalizable && $isParentNormalizeCallable)) {
            return $this;
        }
        try {
            $normalizedParent = parent::normalize();
        } catch (Throwable $e) {
            $normalizedParent = [];
        }
        $normalized = array_merge($normalized, $normalizedParent);

        return $this;
    }

    /**
     * @param array<int|string, null|int|string|bool|array<int|string, mixed>> $normalized
     *
     * @deprecated was added for back compatibility
     */
    private function addTypeIfNeeded(array &$normalized): self
    {
        if (!isset($this->_normalizationFacade)) {
            $normalized['@type'] = (string) (new ShortClassName($this));
        }

        return $this;
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
}
