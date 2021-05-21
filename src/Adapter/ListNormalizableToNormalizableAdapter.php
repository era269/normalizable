<?php

declare(strict_types=1);

namespace Era269\Normalizable\Adapter;

use Era269\Normalizable\NormalizableInterface;

final class ListNormalizableToNormalizableAdapter implements NormalizableInterface
{
    private const TYPE = 'array';
    /**
     * @var NormalizableInterface[]
     */
    private $objects;

    public function __construct(NormalizableInterface ...$objects)
    {
        $this->objects = $objects;
    }

    /**
     * @inheritDoc
     */
    public function normalize(): array
    {
        return array_map(
            static function (NormalizableInterface $o): array {
                return $o->normalize();
            },
            $this->objects
        );
    }

    public function getType(): string
    {
        return self::TYPE;
    }
}
