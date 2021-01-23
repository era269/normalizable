<?php
declare(strict_types=1);


namespace Era269\Normalizable;


interface DenormalizableInterface extends NormalizableInterface
{
    /**
     * @param array<string, int|bool|string|null|array|float> $data
     */
    public static function denormalize(array $data): static;
}
