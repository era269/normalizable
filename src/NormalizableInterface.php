<?php

declare(strict_types=1);

namespace Era269\Normalizable;

interface NormalizableInterface
{
    public const DEFAULT_FIELD_NAME_TYPE = '@type';

    /**
     * @return array<string, mixed>
     */
    public function normalize(): array;

    public function getType(): string;
}
