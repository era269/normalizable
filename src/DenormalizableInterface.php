<?php

declare(strict_types=1);

namespace Era269\Normalizable;

interface DenormalizableInterface extends NormalizableInterface
{
    /**
     * @param array<string, mixed> $data
     *
     * @return static
     */
    public static function denormalize(array $data);
}
