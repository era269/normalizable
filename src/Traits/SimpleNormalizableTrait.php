<?php

declare(strict_types=1);

namespace Era269\Normalizable\Traits;

use Era269\Normalizable\NormalizableInterface;
use Era269\Normalizable\ScalarableInterface;
use LogicException;

trait SimpleNormalizableTrait
{
    use AbstractNormalizableTrait;

    /**
     * @return array<string, mixed>
     */
    protected function getNormalized(): array
    {
        return $this->getAutoNormalized();
    }

    /**
     * @param array<string, mixed> $normalized
     *
     * @return array<string, mixed>
     */
    protected function getAutoNormalized(array $normalized = []): array
    {
        foreach (get_object_vars($this) as $propertyName => $value) {
            $key = $this->getNormalizedPropertyName($propertyName);
            if (isset($normalized[$key])) {
                continue;
            }
            $normalized[$key] = $this->extractScalar($value);
        }

        return $normalized;
    }

    /**
     * Override it to implement snake_case_keys
     */
    protected function getNormalizedPropertyName(string $key): string
    {
        return $key;
    }

    /**
     * @param null|int|float|string|bool|array<mixed, mixed>|object $value
     *
     * @return null|int|float|string|bool|array<mixed, mixed>
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
