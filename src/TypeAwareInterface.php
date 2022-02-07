<?php

declare(strict_types=1);

namespace Era269\Normalizable;

interface TypeAwareInterface
{
    public function getType(): string;
}
