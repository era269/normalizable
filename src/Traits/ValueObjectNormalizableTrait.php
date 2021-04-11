<?php

declare(strict_types=1);

namespace Era269\Normalizable\Traits;

use Era269\Normalizable\NormalizableInterface;
use Era269\Normalizable\ScalarableInterface;
use LogicException;

trait ValueObjectNormalizableTrait
{
    use AbstractNormalizableTrait;

    /**
     * @return array<string, mixed>
     */
    protected function getSelfNormalized(): array
    {
        $normalized = [];
        foreach (get_object_vars($this) as $key => $value) {
            $normalized[$key] = $this->extractScalar($value);
        }

        return $normalized;
    }

    /**
     * @param null|int|float|string|bool|array<mixed, mixed>|object $value
     *
     * @return null|int|float|string|bool|array<mixed, mixed>
     */
    private function extractScalar(null|int|float|string|bool|array|object $value): null|int|float|string|bool|array
    {
        return match (true) {
            !is_object($value) => $value,

            $value instanceof ScalarableInterface => $value->toScalar(),

            $value instanceof NormalizableInterface => $value->normalize(),

            default => throw new LogicException(sprintf(
                'Value "%s", but MUST be scalar or implement any of [%s, %s]',
                $value::class,
                ScalarableInterface::class,
                NormalizableInterface::class
            )),
        };
    }
}
