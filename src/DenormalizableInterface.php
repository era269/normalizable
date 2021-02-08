<?php

declare(strict_types=1);

namespace Era269\Normalizable;

interface DenormalizableInterface extends NormalizableInterface
{
    /**
     * @param array<string, mixed> $data Only scalar types in values
     * ToDo: return "static" with php 8
     */
    public static function denormalize(array $data): object;
}
