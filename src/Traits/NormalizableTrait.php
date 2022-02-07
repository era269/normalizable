<?php

declare(strict_types=1);

namespace Era269\Normalizable\Traits;

use Era269\Normalizable\KeyDecoratorInterface;
use Era269\Normalizable\NormalizableInterface;
use Era269\Normalizable\NormalizerInterface;
use Era269\Normalizable\ScalarableInterface;
use LogicException;

trait NormalizableTrait
{
    /**
     * @var NormalizerInterface|null
     */
    private $_normalizer;
    /**
     * @var KeyDecoratorInterface|null
     */
    private $_keyDecorator;

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
        foreach (array_merge($this->getObjectVars(), $objectVars) as $key => $var) {
            $normalizedVar = isset($this->_normalizer) ? $this->_normalizer->normalize($var) : $this->extractScalar($var);
            $decoratedKey = isset($this->_keyDecorator) ? $this->_keyDecorator->decorate($key) : $key;
            $normalized[$decoratedKey] = $normalizedVar;
        }

        return $normalized;
    }

    public function setNormalizer(NormalizerInterface $normalizer): void
    {
        $this->_normalizer = $normalizer;
    }

    public function setKeyDecorator(KeyDecoratorInterface $keyDecorator): void
    {
        $this->_keyDecorator = $keyDecorator;
    }

    /**
     * @return array<int|string, mixed>
     */
    private function getObjectVars(): array
    {
        $objectVars = get_object_vars($this);
        unset($objectVars['_normalizer'], $objectVars['_keyDecorator']);

        return $objectVars;
    }

    /**
     * @param null|int|float|string|bool|array<mixed, mixed>|object $value
     *
     * @return null|int|float|string|bool|array<mixed, mixed>
     * @deprecated left for back compatibility
     *
     */
    private function extractScalar($value)
    {
        switch (true) {
            case !is_object($value):
                return $value;

            case $value instanceof NormalizableInterface:
                return $value->normalize();

            case $value instanceof ScalarableInterface:
                return $value->toScalar();

            case $this->isStringable($value):
                return (string) $value;

            default:
                throw new LogicException(sprintf(
                    'Value "%s", but MUST be scalar or implement any of [%s, %s]',
                    get_class($value),
                    NormalizableInterface::class,
                    ScalarableInterface::class
                ));
        }
    }

    /**
     * @param object $value
     */
    private function isStringable($value): bool
    {
        return method_exists($value, '__toString');
    }
}
